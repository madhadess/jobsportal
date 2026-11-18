// Zamanlama motoru: ölçülmüş seslendirme süreleri → sahne/replik/efekt kareleri + altyazılar.
// Saf fonksiyon: hem CLI hem testler kullanır.
import { SERIES } from "../series/bible";
import type {
  EpisodeManifest,
  EpisodeSpec,
  ManifestScene,
  SfxId,
  SubtitleCue,
} from "../series/types";

export const DEFAULT_LINE_DELAY = 0.35;
export const MIN_SCENE_SECONDS = 2.2;

export type TimelineInputs = {
  episode: EpisodeSpec;
  /** her replik için [sahneIndex][replikIndex] → { src, seconds } */
  voice: { src: string; seconds: number }[][];
  sfxSeconds: Record<SfxId, number>;
  /** sahne index → mevcut medya dosyası (public/ göreli) */
  media: (string | null)[];
  fps?: number;
};

type SceneTiming = {
  lineStarts: number[];
  linesEnd: number;
  base: number;
};

function timeScene(ep: EpisodeSpec, i: number, voice: TimelineInputs["voice"], sfxSeconds: TimelineInputs["sfxSeconds"]): SceneTiming {
  const s = ep.scenes[i];
  let cursor = 0;
  const lineStarts: number[] = [];
  s.lines.forEach((l, j) => {
    cursor += l.delay ?? DEFAULT_LINE_DELAY;
    lineStarts.push(cursor);
    cursor += voice[i][j].seconds;
  });
  const linesEnd = cursor;
  let base = Math.max(linesEnd + s.hold, s.minDuration ?? 0, MIN_SCENE_SECONDS);
  // sayısal konumlu efektler sahneye sığmalı (ilk 1.2 sn'si)
  for (const c of s.sfx) {
    if (typeof c.at === "number") base = Math.max(base, c.at + Math.min(1.2, sfxSeconds[c.id] ?? 1));
    if (c.at === "afterLines") base = Math.max(base, linesEnd + 0.15 + Math.min(2.4, sfxSeconds[c.id] ?? 1));
  }
  return { lineStarts, linesEnd, base };
}

/** Bölüm süresini hedef aralığa getirmek için sahnelere eklenecek ek bekleme. Gerilimli sahneler daha çok nefes alır. */
export function distributePadding(bases: number[], tensions: number[], deficit: number): number[] {
  if (deficit <= 0) return bases.map(() => 0);
  const weights = tensions.map((t) => 0.5 + t);
  const sum = weights.reduce((a, b) => a + b, 0);
  return weights.map((w) => (deficit * w) / sum);
}

export function splitSubtitle(text: string, maxChars = 34): string[] {
  const words = text.split(/\s+/).filter(Boolean);
  const chunks: string[] = [];
  let cur = "";
  for (const w of words) {
    const next = cur ? `${cur} ${w}` : w;
    if (next.length > maxChars && cur) {
      chunks.push(cur);
      cur = w;
    } else cur = next;
    if (/[.!?…]$/.test(w) && cur.length > 12) {
      chunks.push(cur);
      cur = "";
    }
  }
  if (cur) chunks.push(cur);
  return chunks;
}

export function buildManifest(inp: TimelineInputs): EpisodeManifest {
  const { episode: ep, voice, sfxSeconds, media } = inp;
  const fps = inp.fps ?? SERIES.fps;
  const timings = ep.scenes.map((_, i) => timeScene(ep, i, voice, sfxSeconds));
  const endCard = SERIES.endCardSeconds;
  const baseTotal = timings.reduce((a, t) => a + t.base, 0) + endCard;
  const target = SERIES.minSeconds + 1; // 46 sn alt hedef: platform sınırlarına güvenli pay
  const pads = distributePadding(
    timings.map((t) => t.base),
    ep.scenes.map((s) => s.tension),
    target - baseTotal,
  );

  const f = (sec: number) => Math.round(sec * fps);
  let cursorFrames = 0;
  const scenes: ManifestScene[] = [];
  const subtitles: SubtitleCue[] = [];

  ep.scenes.forEach((s, i) => {
    const t = timings[i];
    const seconds = t.base + pads[i];
    const from = cursorFrames;
    const durationInFrames = f(seconds);
    const lines = s.lines.map((l, j) => {
      const lf = from + f(t.lineStarts[j]);
      const d = Math.max(1, f(voice[i][j].seconds));
      // altyazı parçaları, karakter uzunluğuna orantılı
      const parts = splitSubtitle(l.text);
      const total = parts.reduce((a, p) => a + p.length, 0);
      let pf = lf;
      parts.forEach((p, k) => {
        const len = k === parts.length - 1 ? lf + d - pf : Math.round((d * p.length) / total);
        subtitles.push({ from: pf, to: pf + len, text: p, speaker: l.speaker });
        pf += len;
      });
      return { speaker: l.speaker, text: l.text, src: voice[i][j].src, from: lf, durationInFrames: d };
    });
    const sfx = s.sfx.map((c) => {
      const sd = sfxSeconds[c.id] ?? 1;
      let at: number;
      if (c.at === "end") at = Math.max(0, seconds - 0.2);
      else if (c.at === "afterLines") at = t.linesEnd + 0.15;
      else at = c.at;
      return { id: c.id, src: `audio/sfx/${c.id}.wav`, from: from + f(at), volume: c.volume ?? 0.8, durationInFrames: Math.max(1, f(sd)) };
    });
    scenes.push({
      id: `e${String(ep.number).padStart(2, "0")}s${String(i + 1).padStart(2, "0")}`,
      index: i,
      title: s.title,
      from,
      durationInFrames,
      shot: s.shot,
      camera: s.camera,
      transitionIn: s.transitionIn,
      tension: s.tension,
      silence: !!s.silence,
      ambience: s.ambience,
      insert: s.insert ?? null,
      media: media[i] && s.media ? { src: media[i]!, type: s.media.type, overlayInsert: !!s.media.overlayInsert } : null,
      mediaMissing: !!s.media && !media[i],
      lines,
      sfx,
    });
    cursorFrames += durationInFrames;
  });

  const endFrames = f(endCard);
  const durationInFrames = cursorFrames + endFrames;
  return {
    episode: ep.number,
    title: ep.title,
    fps,
    width: SERIES.width,
    height: SERIES.height,
    durationInFrames,
    seconds: +(durationInFrames / fps).toFixed(2),
    scenes,
    subtitles,
    endCard: {
      from: cursorFrames,
      durationInFrames: endFrames,
      text: ep.number >= SERIES.episodes ? "SEZON SONU" : `DEVAM EDECEK — BÖLÜM ${ep.number + 1}`,
    },
    generatedAt: new Date().toISOString(),
  };
}

export function toSrt(m: EpisodeManifest): string {
  const ts = (fr: number) => {
    const ms = Math.round((fr / m.fps) * 1000);
    const h = Math.floor(ms / 3600000);
    const mi = Math.floor((ms % 3600000) / 60000);
    const s = Math.floor((ms % 60000) / 1000);
    const r = ms % 1000;
    const p = (n: number, l = 2) => String(n).padStart(l, "0");
    return `${p(h)}:${p(mi)}:${p(s)},${p(r, 3)}`;
  };
  return m.subtitles.map((c, i) => `${i + 1}\n${ts(c.from)} --> ${ts(c.to)}\n${c.text}\n`).join("\n");
}
