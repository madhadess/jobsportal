// Remotion ile MP4 render (1080×1920, H.264, AAC).
import { execFileSync, spawnSync } from "node:child_process";
import fs from "node:fs";
import path from "node:path";
import { bundle } from "@remotion/bundler";
import { renderMedia, selectComposition } from "@remotion/renderer";
import type { EpisodeManifest } from "../../src/series/types";
import { OUT_DIR, ROOT } from "./paths";

let bundled: string | null = null;

/** Önceden kurulu Chromium'u bul (ör. Playwright). Yoksa Remotion kendi tarayıcısını indirir. */
function browserExecutable(): string | null {
  if (process.env.REMOTION_BROWSER) return process.env.REMOTION_BROWSER;
  const base = "/opt/pw-browsers";
  if (!fs.existsSync(base)) return null;
  for (const d of fs.readdirSync(base)) {
    const p = path.join(base, d, "chrome-headless-shell-linux64", "chrome-headless-shell");
    if (d.startsWith("chromium_headless_shell") && fs.existsSync(p)) return p;
  }
  return null;
}

export async function renderEpisode(
  m: EpisodeManifest,
  opts: { final: boolean; subtitles: boolean; draftBadges: boolean; log: (s: string) => void },
) {
  const missing = m.scenes.filter((s) => s.mediaMissing);
  if (opts.final && missing.length) {
    throw new Error(`--final: ${missing.length} sahnenin yapay zekâ medyası eksik (${missing.map((s) => s.id).join(", ")}). Önce medyayı ekleyin ya da animatik render alın.`);
  }
  const id = m.comp;
  if (!bundled) {
    opts.log("  Remotion paketleniyor…");
    bundled = await bundle({ entryPoint: path.join(ROOT, "src", "index.ts"), publicDir: path.join(ROOT, "public") });
  }
  const inputProps = { episode: m.episode, manifest: m, subtitles: opts.subtitles, draftBadges: opts.draftBadges && !opts.final };
  const exe = browserExecutable();
  const composition = await selectComposition({ serveUrl: bundled, id, inputProps, browserExecutable: exe });
  fs.mkdirSync(OUT_DIR, { recursive: true });
  const suffix = missing.length ? "_ANIMATIK" : "";
  const out = path.join(OUT_DIR, `${m.special ? id.replace(/-/g, "_") : `BEN_OLMEDIM_${id}`}${suffix}.mp4`);
  let last = -1;
  const t0 = Date.now();
  await renderMedia({
    composition,
    serveUrl: bundled,
    codec: "h264",
    crf: 20,
    pixelFormat: "yuv420p",
    audioCodec: "aac",
    audioBitrate: "192k",
    outputLocation: out,
    inputProps,
    browserExecutable: exe,
    concurrency: Number(process.env.RENDER_CONCURRENCY ?? 4),
    chromiumOptions: { gl: "swangle" },
    onProgress: ({ progress }) => {
      const p = Math.floor(progress * 10);
      if (p !== last) {
        last = p;
        opts.log(`  render ${id}: %${p * 10}`);
      }
    },
  });
  normalizeAudio(out);
  opts.log(`  ✓ ${path.relative(process.cwd(), out)} (${((Date.now() - t0) / 1000).toFixed(0)} sn)`);
  return out;
}

/** Platform standardı ses: -14 LUFS, gerçek tepe -1.5 dBTP (video yeniden kodlanmaz). */
export function normalizeAudio(out: string) {
  const tmp = out.replace(/\.mp4$/, ".tmp.mp4");
  if (fs.existsSync(out)) fs.renameSync(out, tmp);
  // iki geçişli loudnorm: önce ölç, sonra doğrusal uygula (dinamikleri ezmeden hedefe oturur)
  const probe = spawnSync("ffmpeg", ["-hide_banner", "-i", tmp, "-af", "loudnorm=I=-14:TP=-1.5:LRA=11:print_format=json", "-f", "null", "-"], { encoding: "utf8" }).stderr ?? "";
  let af = "loudnorm=I=-14:TP=-1.5:LRA=11";
  const json = probe.slice(probe.lastIndexOf("{"), probe.lastIndexOf("}") + 1);
  try {
    const m = JSON.parse(json) as Record<string, string>;
    af += `:measured_I=${m.input_i}:measured_TP=${m.input_tp}:measured_LRA=${m.input_lra}:measured_thresh=${m.input_thresh}:offset=${m.target_offset}:linear=true`;
  } catch {
    /* ölçüm okunamazsa tek geçiş */
  }
  execFileSync("ffmpeg", ["-y", "-v", "error", "-i", tmp, "-c:v", "copy", "-af", `${af},aresample=48000`, "-c:a", "aac", "-b:a", "192k", "-movflags", "+faststart", out]);
  fs.unlinkSync(tmp);
}
