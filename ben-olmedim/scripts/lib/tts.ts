// Türkçe seslendirme: Piper (yerel, ücretsiz) → ffmpeg karakter işleme → süre ölçümü.
// Önbellek: metin + ses profili özeti aynıysa dosya yeniden kullanılır (maliyet/zaman tasarrufu).
import { execFileSync } from "node:child_process";
import crypto from "node:crypto";
import fs from "node:fs";
import path from "node:path";
import { NC_VOICE_OVERRIDES, VOICES, VOX, type VoiceProfile } from "../../src/series/bible";
import type { EpisodeSpec, SpeakerId } from "../../src/series/types";
import { epKey } from "../../src/pipeline/timeline";
import { CACHE_DIR, ROOT, VO_DIR, pub } from "./paths";

export type VoiceResult = { src: string; seconds: number; env?: number[] };

/** Ağız senkronu için kare başına (30 fps) normalize ses yüksekliği zarfı, 0..1. */
export function envelope(file: string, fps = 30): number[] {
  const sr = 6000;
  const raw = execFileSync("ffmpeg", ["-v", "error", "-i", file, "-ac", "1", "-ar", String(sr), "-f", "s16le", "-"], { maxBuffer: 64 * 1024 * 1024 });
  const pcm = new Int16Array(raw.buffer, raw.byteOffset, Math.floor(raw.length / 2));
  const per = sr / fps;
  const out: number[] = [];
  for (let i = 0; i < pcm.length; i += per) {
    let sum = 0;
    const end = Math.min(pcm.length, i + per);
    for (let k = i; k < end; k++) sum += pcm[k] * pcm[k];
    out.push(Math.sqrt(sum / Math.max(1, end - i)) / 32768);
  }
  const peak = Math.max(1e-6, ...out);
  // gürültü eşiği + yumuşak eğri: konuşurken ağız 0.3–1 arası açılır
  return out.map((v) => {
    const n = v / peak;
    return n < 0.08 ? 0 : +Math.min(1, Math.pow(n, 0.6) * 1.1).toFixed(2);
  });
}

/** Etkin ses profili: varsayılan CC0; TTS_ALLOW_NC=1 ise ticari olmayan lisanslı sesler devreye girer. */
export function profileFor(speaker: SpeakerId): VoiceProfile {
  const base = VOICES[speaker];
  const nc = process.env.TTS_ALLOW_NC === "1" ? NC_VOICE_OVERRIDES[speaker] : undefined;
  return nc ? { ...base, ...nc } : base;
}

/** Piper'ın Türkçe telaffuzunu iyileştiren küçük metin düzeltmeleri. */
export function normalizeForTts(text: string): string {
  return text
    .replace(/03[.:]17/g, "üçü on yedi")
    .replace(/\.\.\./g, "…")
    .replace(/…\s*/g, "… ")
    .replace(/\s+/g, " ")
    .trim();
}

/** Etkin ses motoru: TTS_ENGINE=voxcpm ise (ve konuşanın VOX profili varsa) Trendyol-TTS, yoksa Piper. */
export function engineFor(speaker: SpeakerId): "piper" | "voxcpm" {
  return process.env.TTS_ENGINE === "voxcpm" && VOX[speaker] ? "voxcpm" : "piper";
}

export const voxRef = (speaker: SpeakerId) => path.join(ROOT, "voices", `${speaker}.wav`);

export function voiceKey(speaker: SpeakerId, text: string): string {
  const engine = engineFor(speaker);
  const p = engine === "voxcpm" ? { vox: VOX[speaker], ref: fs.existsSync(voxRef(speaker)) ? fs.statSync(voxRef(speaker)).size : 0 } : profileFor(speaker);
  return crypto.createHash("sha1").update(JSON.stringify({ v: 5, engine, p, text })).digest("hex").slice(0, 16);
}

export function probeSeconds(file: string): number {
  const out = execFileSync("ffprobe", ["-v", "error", "-show_entries", "format=duration", "-of", "csv=p=0", file]).toString().trim();
  return parseFloat(out);
}

function filterChain(speaker: SpeakerId): string {
  if (engineFor(speaker) === "voxcpm") {
    // doğal ses: yalnızca hafif son işlem (karakter efekti varsa), perde gerekiyorsa küçük kaydırma
    const v = VOX[speaker]!;
    const f = [
      "silenceremove=start_periods=1:start_threshold=-50dB:start_silence=0.02",
      "areverse",
      "silenceremove=start_periods=1:start_threshold=-50dB:start_silence=0.05",
      "areverse",
    ];
    if (v.pitch && v.pitch !== 1) f.push(`asetrate=48000*${v.pitch}`, "aresample=48000", `atempo=${(1 / v.pitch).toFixed(4)}`);
    f.push(...(v.filters ?? []), "aresample=48000", "loudnorm=I=-16:TP=-1.5:LRA=7", "apad=pad_dur=0.12");
    return f.join(",");
  }
  const p = profileFor(speaker);
  const f: string[] = [];
  // sessiz baş/sonları kırp
  f.push("silenceremove=start_periods=1:start_threshold=-48dB:start_silence=0.02");
  f.push("areverse", "silenceremove=start_periods=1:start_threshold=-48dB:start_silence=0.05", "areverse");
  if (p.pitch !== 1) {
    f.push(`asetrate=22050*${p.pitch}`, "aresample=22050", `atempo=${(1 / p.pitch).toFixed(4)}`);
  }
  f.push(...p.filters);
  f.push("aresample=48000", `volume=${p.gainDb}dB`, "loudnorm=I=-16:TP=-1.5:LRA=7", "apad=pad_dur=0.12");
  return f.join(",");
}

export async function synthesizeEpisode(ep: EpisodeSpec, opts: { force?: boolean; log?: (s: string) => void } = {}): Promise<VoiceResult[][]> {
  const log = opts.log ?? (() => {});
  const dir = path.join(VO_DIR, epKey(ep));
  fs.mkdirSync(dir, { recursive: true });
  fs.mkdirSync(CACHE_DIR, { recursive: true });

  type Job = { si: number; li: number; speaker: SpeakerId; text: string; final: string; raw: string };
  const jobs: Job[] = [];
  ep.scenes.forEach((s, si) =>
    s.lines.forEach((l, li) => {
      const key = voiceKey(l.speaker, l.text);
      const final = path.join(dir, `${l.speaker}-${key}.wav`);
      jobs.push({ si, li, speaker: l.speaker, text: l.text, final, raw: path.join(CACHE_DIR, `${key}.raw.wav`) });
    }),
  );

  const pendingAll = jobs.filter((j) => opts.force || !fs.existsSync(j.final));
  const voxPending = pendingAll.filter((j) => engineFor(j.speaker) === "voxcpm");
  const pending = pendingAll.filter((j) => engineFor(j.speaker) === "piper");
  if (voxPending.length) {
    log(`  TTS: ${voxPending.length} replik Trendyol-TTS ile sentezleniyor (her cümle Whisper ile doğrulanır)…`);
    const spec = voxPending.map((j) => {
      const v = VOX[j.speaker]!;
      return { text: normalizeForTts(j.text), speaker: j.speaker, refPath: voxRef(j.speaker), refText: v.refText, design: v.design, pause: 0.32, out: j.raw };
    });
    const specFile = path.join(CACHE_DIR, `vox-${epKey(ep)}.json`);
    fs.writeFileSync(specFile, JSON.stringify(spec));
    const py = process.env.TTS_VOXCPM_PYTHON ?? "python3";
    execFileSync(py, [path.join(ROOT, "scripts", "tts", "voxcpm_synth.py"), specFile], { stdio: ["ignore", "inherit", "inherit"] });
    for (const j of voxPending) {
      execFileSync("ffmpeg", ["-y", "-v", "error", "-i", j.raw, "-af", filterChain(j.speaker), "-ac", "2", "-c:a", "pcm_s16le", j.final]);
    }
  }
  if (pending.length) {
    log(`  TTS: ${pending.length}/${jobs.length} replik sentezleniyor (Piper)…`);
    const spec = pending.map((j) => {
      const p = profileFor(j.speaker);
      return { text: normalizeForTts(j.text), voice: p.voice, lengthScale: p.lengthScale, noiseScale: p.noiseScale ?? 0.667, noiseW: p.noiseW ?? 0.8, sentencePause: p.sentencePause ?? 0.4, out: j.raw };
    });
    const specFile = path.join(CACHE_DIR, `tts-${ep.number}.json`);
    fs.writeFileSync(specFile, JSON.stringify(spec));
    execFileSync("python3", [path.join(ROOT, "scripts", "tts", "synth.py"), specFile], { stdio: ["ignore", "pipe", "inherit"] });
    for (const j of pending) {
      execFileSync("ffmpeg", ["-y", "-v", "error", "-i", j.raw, "-af", filterChain(j.speaker), "-ac", "2", "-c:a", "pcm_s16le", j.final]);
    }
  } else if (!voxPending.length) log(`  TTS: ${jobs.length} replik önbellekte`);

  const res: VoiceResult[][] = ep.scenes.map((s) => s.lines.map(() => ({ src: "", seconds: 0 })));
  for (const j of jobs) res[j.si][j.li] = { src: pub(j.final), seconds: probeSeconds(j.final), env: envelope(j.final) };
  return res;
}
