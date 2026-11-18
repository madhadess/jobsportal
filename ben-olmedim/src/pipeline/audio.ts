import type { AmbienceId, EpisodeManifest } from "../series/types";

export type AmbSegment = { id: AmbienceId; from: number; to: number };

/** Ardışık sahnelerde süren ortam seslerini tek parça halinde birleştirir (her kesmede yeniden başlamasın). */
export function ambienceSegments(m: Pick<EpisodeManifest, "scenes">): AmbSegment[] {
  const open = new Map<AmbienceId, AmbSegment>();
  const done: AmbSegment[] = [];
  for (const s of m.scenes) {
    const active = new Set(s.silence ? [] : s.ambience);
    for (const [id, seg] of open) {
      if (!active.has(id)) {
        done.push(seg);
        open.delete(id);
      }
    }
    for (const id of active) {
      const seg = open.get(id);
      if (seg) seg.to = s.from + s.durationInFrames;
      else open.set(id, { id, from: s.from, to: s.from + s.durationInFrames });
    }
  }
  done.push(...open.values());
  return done;
}
