// Senaryo yazımını kısaltan yardımcılar.
import type {
  AmbienceId,
  CameraMove,
  EpisodeSpec,
  Insert,
  LineTuple,
  MediaSpec,
  SceneSpec,
  ShotType,
  SfxTuple,
  Transition,
} from "./types";

export type SceneInput = {
  title: string;
  visual: string;
  shot: ShotType;
  camera?: CameraMove;
  media?: MediaSpec;
  insert?: Insert;
  lines?: LineTuple[];
  sfx?: SfxTuple[];
  amb?: AmbienceId[];
  silence?: boolean;
  hold?: number;
  min?: number;
  tr?: Transition;
  tension?: number;
};

export const scene = (s: SceneInput): SceneSpec => ({
  title: s.title,
  visual: s.visual,
  shot: s.shot,
  camera: s.camera ?? "slowPushIn",
  media: s.media,
  insert: s.insert,
  lines: (s.lines ?? []).map(([speaker, text, delay]) => ({ speaker, text, delay })),
  sfx: (s.sfx ?? []).map(([id, at, volume]) => ({ id, at, volume })),
  ambience: s.amb ?? ["roomTone"],
  silence: s.silence ?? false,
  hold: s.hold ?? 0.6,
  minDuration: s.min,
  transitionIn: s.tr ?? "cut",
  tension: s.tension ?? 0.4,
});

export type EpisodeInput = Omit<EpisodeSpec, "scenes"> & { scenes: SceneSpec[] };
export const episode = (e: EpisodeInput): EpisodeSpec => e;

/** Görüntü kısa yolu */
export const vid = (prompt: string, extra: Omit<MediaSpec, "type" | "prompt"> = {}): MediaSpec => ({ type: "video", prompt, ...extra });
export const img = (prompt: string, extra: Omit<MediaSpec, "type" | "prompt"> = {}): MediaSpec => ({ type: "image", prompt, ...extra });
