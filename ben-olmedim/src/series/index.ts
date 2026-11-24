import { ACT1 } from "./episodes/act1";
import { ACT2 } from "./episodes/act2";
import { ACT3 } from "./episodes/act3";
import { kapiTavan } from "./specials/kapiTavan";
import type { EpisodeSpec } from "./types";

export const EPISODES: EpisodeSpec[] = [...ACT1, ...ACT2, ...ACT3].sort((a, b) => a.number - b.number);

/** Diziden bağımsız özel bölümler (izleyici hikâyeleri vb.) */
export const SPECIALS: EpisodeSpec[] = [kapiTavan];

export const getEpisode = (n: number): EpisodeSpec => {
  const ep = EPISODES.find((e) => e.number === n) ?? SPECIALS.find((e) => e.number === n);
  if (!ep) throw new Error(`Bölüm ${n} senaryo verisinde yok`);
  return ep;
};

export const epId = (n: number) => `e${String(n).padStart(2, "0")}`;
export const compId = (n: number) => `B${String(n).padStart(2, "0")}`;
