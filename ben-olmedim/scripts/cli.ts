// BEN ÖLMEDİM üretim komutları.
//
//   npm run validate                 → tüm senaryoları doğrula
//   npm run prepare:ep -- 1          → seslendirme + zamanlama + manifest + rapor (B01)
//   npm run media -- 1-5             → yapılandırılmış sağlayıcıyla eksik AI klipleri üret
//   npm run render -- 1 [--final] [--no-subs] [--clean]
//   npm run build:ep -- all          → prepare + media + render (toplu)
//   npm run report                   → tüm bölümlerin durum tablosu (reports/README.md)
//   npm run screenplay               → okunabilir sezon senaryosu (reports/SENARYO.md)
import fs from "node:fs";
import path from "node:path";
import { buildManifest, toSrt } from "../src/pipeline/timeline";
import { EPISODES, getEpisode } from "../src/series";
import { SERIES, VOICES } from "../src/series/bible";
import type { EpisodeManifest, SfxId } from "../src/series/types";
import { configuredProvider, findSceneMedia, resolveEpisodeMedia } from "./lib/media";
import { MANIFEST_DIR, OUT_DIR, REPORT_DIR, ROOT, SFX_DIR } from "./lib/paths";
import { renderEpisode } from "./lib/render";
import { validateEpisode, writeMissingIndex, writeReport } from "./lib/report";
import { probeSeconds, synthesizeEpisode } from "./lib/tts";

try {
  process.loadEnvFile(path.join(ROOT, ".env"));
} catch {
  /* .env isteğe bağlı */
}

const args = process.argv.slice(2);
const cmd = args[0];
const flags = new Set(args.filter((a) => a.startsWith("--")));
const target = args.slice(1).find((a) => !a.startsWith("--")) ?? "1";
const log = (s: string) => console.log(s);

function parseTarget(t: string): number[] {
  if (t === "all") return EPISODES.map((e) => e.number);
  return t.split(",").flatMap((part) => {
    const [a, b] = part.split("-").map(Number);
    return b ? Array.from({ length: b - a + 1 }, (_, i) => a + i) : [a];
  });
}

const pad = (n: number) => String(n).padStart(2, "0");

function sfxDurations(): Record<SfxId, number> {
  if (!fs.existsSync(path.join(SFX_DIR, "knock3.wav"))) {
    throw new Error("Ses efektleri yok — önce `npm run sfx`");
  }
  const out: Record<string, number> = {};
  for (const f of fs.readdirSync(SFX_DIR)) if (f.endsWith(".wav") && !f.startsWith("amb_")) out[f.replace(".wav", "")] = probeSeconds(path.join(SFX_DIR, f));
  return out as Record<SfxId, number>;
}

async function prepare(n: number, generateMedia: boolean): Promise<EpisodeManifest> {
  const ep = getEpisode(n);
  log(`\n▶ Bölüm ${n} — ${ep.title}`);
  const voice = await synthesizeEpisode(ep, { force: flags.has("--force-tts"), log });
  const sfx = sfxDurations();
  // 1. geçiş: medyasız zamanlama (prompt süreleri için)
  const media0 = ep.scenes.map((_, i) => findSceneMedia(n, i));
  let manifest = buildManifest({ episode: ep, voice, sfxSeconds: sfx, media: media0 });
  const sceneSecs = manifest.scenes.map((s) => s.durationInFrames / manifest.fps);
  const mediaStatus = await resolveEpisodeMedia(ep, sceneSecs, { generate: generateMedia, log });
  const media = ep.scenes.map((_, i) => mediaStatus.find((m) => m.sceneIndex === i)?.file ?? findSceneMedia(n, i));
  manifest = buildManifest({ episode: ep, voice, sfxSeconds: sfx, media });
  fs.mkdirSync(MANIFEST_DIR, { recursive: true });
  fs.writeFileSync(path.join(MANIFEST_DIR, `e${pad(n)}.json`), JSON.stringify(manifest, null, 1));
  fs.mkdirSync(OUT_DIR, { recursive: true });
  fs.writeFileSync(path.join(OUT_DIR, `BEN_OLMEDIM_B${pad(n)}.srt`), toSrt(manifest));
  const issues = validateEpisode(ep, manifest);
  const report = writeReport(ep, manifest, mediaStatus, issues);
  const missing = writeMissingIndex([{ ep, media: mediaStatus }]);
  const miss = mediaStatus.filter((m) => m.status === "missing" || m.status === "failed").length;
  log(`  süre ${manifest.seconds} sn · ${manifest.scenes.length} sahne · AI medya ${mediaStatus.length - miss}/${mediaStatus.length}`);
  for (const i of issues) log(`  ${i.level === "error" ? "✖" : "!"} ${i.msg}`);
  log(`  rapor: ${path.relative(process.cwd(), report)} · eksik medya listesi: ${path.relative(process.cwd(), missing.file)}`);
  if (issues.some((i) => i.level === "error")) process.exitCode = 1;
  return manifest;
}

/** Tüm sezonun okunabilir senaryo metni: reports/SENARYO.md */
function screenplay() {
  const L: string[] = ["# BEN ÖLMEDİM — Sezon 1 Senaryosu", "", "_Bu dosya `src/series/episodes/*.ts` verisinden üretilir (`npm run screenplay`). Düzenlemeyi veride yapın._", ""];
  for (const ep of EPISODES) {
    L.push(`## Bölüm ${ep.number} — ${ep.title}`, "", `> ${ep.logline}`, "", `- **Hikâye zamanı:** ${ep.storyTime}`, `- **Devamı:** ${ep.continuesFrom}`, `- **İlk 3 sn:** ${ep.hook}`, `- **Yeni bilgi:** ${ep.revelation}`, `- **Son 5 sn:** ${ep.cliffhanger}`, "");
    ep.scenes.forEach((s, i) => {
      L.push(`**SAHNE ${i + 1} — ${s.title.toLocaleUpperCase("tr")}** _(${s.shot} · ${s.camera}${s.silence ? " · ortam sesi kesilir" : ""})_`, "", s.visual, "");
      for (const l of s.lines) L.push(`> **${VOICES[l.speaker].label.toLocaleUpperCase("tr")}:** ${l.text}`, ">");
      if (s.lines.length) L.pop();
      if (s.sfx.length) L.push("", `_Ses: ${s.sfx.map((c) => c.id).join(", ")}_`);
      L.push("");
    });
    L.push(ep.number < SERIES.episodes ? `_DEVAM EDECEK — BÖLÜM ${ep.number + 1}_` : "_SEZON SONU_", "", "---", "");
  }
  fs.mkdirSync(REPORT_DIR, { recursive: true });
  fs.writeFileSync(path.join(REPORT_DIR, "SENARYO.md"), L.join("\n"));
  log(`reports/SENARYO.md yazıldı (${EPISODES.length} bölüm)`);
}

function statusTable() {
  const rows: string[] = ["# BEN ÖLMEDİM — Sezon 1 durum tablosu", "", "| # | Bölüm | Sahne | Replik | Süre | AI medya | MP4 |", "|---|---|---|---|---|---|---|"];
  for (const ep of EPISODES) {
    const mf = path.join(MANIFEST_DIR, `e${pad(ep.number)}.json`);
    const m: EpisodeManifest | null = fs.existsSync(mf) ? JSON.parse(fs.readFileSync(mf, "utf8")) : null;
    const needs = ep.scenes.filter((s) => s.media).length;
    const have = ep.scenes.filter((s, i) => s.media && findSceneMedia(ep.number, i)).length;
    const mp4 = path.join(OUT_DIR, `BEN_OLMEDIM_B${pad(ep.number)}.mp4`);
    rows.push(
      `| ${ep.number} | [${ep.title}](e${pad(ep.number)}.md) | ${ep.scenes.length} | ${ep.scenes.reduce((a, s) => a + s.lines.length, 0)} | ${m ? `${m.seconds} sn` : "—"} | ${have}/${needs} | ${fs.existsSync(mp4) ? "✅" : "—"} |`,
    );
  }
  fs.mkdirSync(REPORT_DIR, { recursive: true });
  fs.writeFileSync(path.join(REPORT_DIR, "README.md"), rows.join("\n") + "\n");
  log(rows.join("\n"));
}

async function main() {
  const eps = parseTarget(target);
  switch (cmd) {
    case "validate": {
      let errors = 0;
      for (const ep of EPISODES) {
        const issues = validateEpisode(ep);
        const words = ep.scenes.flatMap((s) => s.lines).reduce((a, l) => a + l.text.split(/\s+/).length, 0);
        log(`B${pad(ep.number)} ${ep.title.padEnd(26)} ${ep.scenes.length} sahne · ${words} kelime ${issues.map((i) => `[${i.msg}]`).join(" ")}`);
        errors += issues.filter((i) => i.level === "error").length;
      }
      const missingEps = Array.from({ length: SERIES.episodes }, (_, i) => i + 1).filter((n) => !EPISODES.some((e) => e.number === n));
      if (missingEps.length) log(`Senaryosu olmayan bölümler: ${missingEps.join(", ")}`);
      if (errors) process.exitCode = 1;
      break;
    }
    case "prepare":
      for (const n of eps) await prepare(n, false);
      break;
    case "media": {
      const p = configuredProvider();
      if (!p) log("Yapay zekâ medya sağlayıcısı yapılandırılmamış (REPLICATE_API_TOKEN veya FAL_KEY). Hiçbir şey üretilmedi; eksikler raporlanıyor.");
      for (const n of eps) await prepare(n, !!p);
      break;
    }
    case "render":
      for (const n of eps) {
        const mf = path.join(MANIFEST_DIR, `e${pad(n)}.json`);
        if (!fs.existsSync(mf)) await prepare(n, false);
        const m: EpisodeManifest = JSON.parse(fs.readFileSync(mf, "utf8"));
        await renderEpisode(m, { final: flags.has("--final"), subtitles: !flags.has("--no-subs"), draftBadges: !flags.has("--clean"), log });
      }
      break;
    case "build":
      for (const n of eps) {
        const m = await prepare(n, !!configuredProvider());
        if (process.exitCode) {
          log(`  B${pad(n)} doğrulama hatası — render atlandı`);
          process.exitCode = 0;
          continue;
        }
        await renderEpisode(m, { final: flags.has("--final"), subtitles: !flags.has("--no-subs"), draftBadges: !flags.has("--clean"), log });
      }
      statusTable();
      break;
    case "report":
      statusTable();
      break;
    case "screenplay":
      screenplay();
      break;
    default:
      log("Komutlar: validate | prepare <n> | media <n> | render <n> | build <n|a-b|all> | report | screenplay");
  }
}

main().catch((e) => {
  console.error(e);
  process.exit(1);
});
