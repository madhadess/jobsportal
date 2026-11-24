// Bölüm üretim raporu: storyboard, seslendirme metinleri + süreler, sahne promptları, eksik dosyalar.
import fs from "node:fs";
import path from "node:path";
import { CHARACTERS, LOCATIONS, VOICES } from "../../src/series/bible";
import type { EpisodeManifest, EpisodeSpec } from "../../src/series/types";
import { epKey } from "../../src/pipeline/timeline";
import type { MediaStatus } from "./media";
import { REPORT_DIR, ROOT } from "./paths";

const tc = (frames: number, fps: number) => {
  const s = frames / fps;
  return `${String(Math.floor(s / 60)).padStart(2, "0")}:${(s % 60).toFixed(1).padStart(4, "0")}`;
};

export type ValidationIssue = { level: "error" | "warn"; msg: string };

export function validateEpisode(ep: EpisodeSpec, m?: EpisodeManifest): ValidationIssue[] {
  const issues: ValidationIssue[] = [];
  const words = ep.scenes.flatMap((s) => s.lines).reduce((a, l) => a + l.text.split(/\s+/).length, 0);
  if (words < 55) issues.push({ level: "warn", msg: `Konuşma ${words} kelime — çok kısa (ölçülen anlatım hızıyla hedef 60–100)` });
  if (words > 110 && !ep.durationRange) issues.push({ level: "warn", msg: `Konuşma ${words} kelime — 60 sn'yi aşabilir` });
  if (!ep.scenes.length) issues.push({ level: "error", msg: "Sahne yok" });
  ep.scenes.forEach((s, i) => {
    if (!s.media && !s.insert) issues.push({ level: "warn", msg: `Sahne ${i + 1}: ne medya ne prosedürel katman var` });
  });
  if (m) {
    const [lo, hi] = ep.durationRange ?? [45, 60];
    if (m.seconds > hi) issues.push({ level: "error", msg: `Süre ${m.seconds} sn > ${hi} sn — repliği kısaltın` });
    if (m.seconds < lo) issues.push({ level: "error", msg: `Süre ${m.seconds} sn < ${lo} sn` });
    const firstLine = m.scenes[0]?.lines[0];
    if (firstLine && firstLine.from / m.fps > 1.6) issues.push({ level: "warn", msg: `İlk replik ${(firstLine.from / m.fps).toFixed(1)} sn'de başlıyor — ilk 3 sn kancası zayıf olabilir` });
  }
  return issues;
}

export function writeReport(ep: EpisodeSpec, m: EpisodeManifest, media: MediaStatus[], issues: ValidationIssue[]): string {
  fs.mkdirSync(REPORT_DIR, { recursive: true });
  const id = epKey(ep);
  const L: string[] = [];
  L.push(`# BEN ÖLMEDİM — Bölüm ${ep.number}: ${ep.title}`);
  L.push("");
  L.push(`> ${ep.logline}`);
  L.push("");
  L.push(`| | |\n|---|---|\n| Süre | **${m.seconds} sn** (${m.durationInFrames} kare @ ${m.fps} fps) |\n| Hikâye zamanı | ${ep.storyTime} |\n| Devamı | ${ep.continuesFrom} |\n| İlk 3 sn kancası | ${ep.hook} |\n| Yeni bilgi | ${ep.revelation} |\n| Son 5 sn | ${ep.cliffhanger} |`);
  L.push("");
  const missing = media.filter((x) => x.status === "missing" || x.status === "failed");
  L.push(`## Durum`);
  L.push("");
  L.push(`- Seslendirme: ${m.scenes.reduce((a, s) => a + s.lines.length, 0)} replik, hepsi üretildi (Piper TTS, yerel)`);
  L.push(`- Yapay zekâ medyası: ${media.length - missing.length}/${media.length} sahne hazır${missing.length ? ` — **${missing.length} eksik**` : ""}`);
  L.push(`- Prosedürel katmanlı sahneler: ${m.scenes.filter((s) => !s.media).length}`);
  for (const i of issues) L.push(`- ${i.level === "error" ? "❌" : "⚠️"} ${i.msg}`);
  L.push("");
  L.push(`## Storyboard`);
  L.push("");
  L.push(`| # | Zaman | Çekim | Görüntü | Ses | Medya |`);
  L.push(`|---|---|---|---|---|---|`);
  m.scenes.forEach((s, i) => {
    const spec = ep.scenes[i];
    const audio = s.lines.map((l) => `**${VOICES[l.speaker].label}:** “${l.text}”`).join("<br>") || "_(diyalog yok)_";
    const fx = s.sfx.map((c) => c.id).join(", ");
    const ms = media.find((x) => x.sceneIndex === i);
    const mediaCell = !spec.media ? `prosedürel: \`${s.insert?.kind}\`` : ms?.file ? `✅ \`${ms.file}\`` : `❌ \`media/${id}/${s.id}.mp4\``;
    L.push(`| ${i + 1} | ${tc(s.from, m.fps)}–${tc(s.from + s.durationInFrames, m.fps)} | ${s.shot} / ${s.camera} | ${spec.visual} | ${audio}${fx ? `<br>_SFX: ${fx}_` : ""}${s.silence ? "<br>_ortam sesi kesik_" : ""} | ${mediaCell} |`);
  });
  L.push(`| — | ${tc(m.endCard.from, m.fps)}–${tc(m.durationInFrames, m.fps)} | kapanış | ${m.endCard.text} | | |`);
  L.push("");
  if (media.length) {
    L.push(`## Görsel üretim promptları`);
    L.push("");
    for (const x of media) {
      L.push(`### ${x.id} — ${ep.scenes[x.sceneIndex].title} (${x.type === "video" ? "video" : "görsel"}, ~${Math.ceil(x.prompt.seconds)} sn) — ${x.status}`);
      L.push("");
      L.push("```text");
      L.push(x.prompt.prompt);
      L.push("```");
      L.push(`Negatif: \`${x.prompt.negative}\``);
      if (x.prompt.referenceImages.length) L.push(`Referanslar: ${x.prompt.referenceImages.map((r) => (x.missingRefs.includes(r) ? `❌ \`${r}\`` : `✅ \`${r}\``)).join(", ")}`);
      if (x.error) L.push(`Hata: ${x.error}`);
      L.push(`Hedef dosya: \`public/media/${id}/${x.id}.mp4\` (ya da .png/.jpg — görselse kamera hareketiyle canlandırılır)`);
      L.push("");
    }
  }
  const usedChars = new Set(ep.scenes.flatMap((s) => s.media?.characters ?? []));
  const usedLocs = new Set(ep.scenes.flatMap((s) => (s.media?.location ? [s.media.location] : [])));
  if (usedChars.size || usedLocs.size) {
    L.push(`## Tutarlılık referansları`);
    L.push("");
    for (const c of usedChars) {
      const ch = CHARACTERS[c];
      const ok = fs.existsSync(path.join(ROOT, ch.referenceImage));
      L.push(`- ${ok ? "✅" : "❌"} **${ch.name}** — \`${ch.referenceImage}\`  \n  Referans promptu: _${ch.referencePrompt}_`);
    }
    for (const l of usedLocs) {
      const lo = LOCATIONS[l];
      const ok = fs.existsSync(path.join(ROOT, lo.referenceImage));
      L.push(`- ${ok ? "✅" : "❌"} **${lo.name}** — \`${lo.referenceImage}\``);
    }
    L.push("");
  }
  const file = path.join(REPORT_DIR, `${id}.md`);
  fs.writeFileSync(file, L.join("\n"));
  return file;
}

export function writeMissingIndex(all: { ep: EpisodeSpec; media: MediaStatus[] }[]) {
  const rows = all.flatMap(({ ep, media }) =>
    media
      .filter((x) => x.status === "missing" || x.status === "failed")
      .map((x) => ({
        episode: ep.number,
        scene: x.id,
        type: x.type,
        target: `public/media/${epKey(ep)}/${x.id}.${x.type === "video" ? "mp4" : "png"}`,
        seconds: Math.ceil(x.prompt.seconds),
        prompt: x.prompt.prompt,
        negative: x.prompt.negative,
        references: x.prompt.referenceImages,
        missingReferences: x.missingRefs,
      })),
  );
  fs.mkdirSync(REPORT_DIR, { recursive: true });
  const file = path.join(REPORT_DIR, "missing-media.json");
  // diğer bölümlerin kayıtlarını koru
  const prev: typeof rows = fs.existsSync(file) ? JSON.parse(fs.readFileSync(file, "utf8")) : [];
  const eps = new Set(all.map((a) => a.ep.number));
  const merged = [...prev.filter((r) => !eps.has(r.episode)), ...rows].sort((a, b) => a.scene.localeCompare(b.scene));
  fs.writeFileSync(file, JSON.stringify(merged, null, 2));
  return { file, count: merged.length };
}
