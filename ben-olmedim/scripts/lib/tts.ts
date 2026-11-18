// Türkçe seslendirme: Piper (yerel, ücretsiz) → ffmpeg karakter işleme → süre ölçümü.
// Önbellek: metin + ses profili özeti aynıysa dosya yeniden kullanılır (maliyet/zaman tasarrufu).
import { execFileSync } from "node:child_process";
import crypto from "node:crypto";
import fs from "node:fs";
import path from "node:path";
import { NC_VOICE_OVERRIDES, VOICES, type VoiceProfile } from "../../src/series/bible";
import type { EpisodeSpec, SpeakerId } from "../../src/series/types";
import { CACHE_DIR, ROOT, VO_DIR, pub } from "./paths";

export type VoiceResult = { src: string; seconds: number };

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

export function voiceKey(speaker: SpeakerId, text: string): string {
  const p = profileFor(speaker);
  return crypto.createHash("sha1").update(JSON.stringify({ v: 4, p, text })).digest("hex").slice(0, 16);
}

export function probeSeconds(file: string): number {
  const out = execFileSync("ffprobe", ["-v", "error", "-show_entries", "format=duration", "-of", "csv=p=0", file]).toString().trim();
  return parseFloat(out);
}

function filterChain(speaker: SpeakerId): string {
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
  const dir = path.join(VO_DIR, `e${String(ep.number).padStart(2, "0")}`);
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

  const pending = jobs.filter((j) => opts.force || !fs.existsSync(j.final));
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
  } else log(`  TTS: ${jobs.length} replik önbellekte`);

  const res: VoiceResult[][] = ep.scenes.map((s) => s.lines.map(() => ({ src: "", seconds: 0 })));
  for (const j of jobs) res[j.si][j.li] = { src: pub(j.final), seconds: probeSeconds(j.final) };
  return res;
}
