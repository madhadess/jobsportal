// Sahne → tam üretim promptu (stil + karakter kimliği + mekân + çekim dili).
import { CHARACTERS, LOCATIONS, VISUAL_STYLE } from "../series/bible";
import type { CameraMove, SceneSpec, ShotType } from "../series/types";

const SHOT_EN: Record<ShotType, string> = {
  ECU: "extreme close-up",
  CU: "close-up",
  MCU: "medium close-up",
  MS: "medium shot",
  WS: "wide shot",
  POV: "first-person POV shot",
  INSERT: "insert detail shot",
  CCTV: "high-angle security camera footage, fixed wide lens, timestamp-free",
  OTS: "over-the-shoulder shot",
};

const CAMERA_EN: Record<CameraMove, string> = {
  static: "locked-off static camera",
  pushIn: "slow push-in",
  slowPushIn: "very slow creeping push-in",
  pullOut: "slow pull-out",
  handheld: "subtle controlled handheld tremor",
  panLeft: "slow pan left",
  panRight: "slow pan right",
  tiltUp: "slow tilt up",
  tiltDown: "slow tilt down",
  dollyZoom: "subtle dolly zoom",
  drift: "barely perceptible drift",
};

export type BuiltPrompt = {
  prompt: string;
  negative: string;
  referenceImages: string[];
  seconds: number;
};

export function buildScenePrompt(scene: SceneSpec, seconds: number): BuiltPrompt | null {
  if (!scene.media) return null;
  const m = scene.media;
  const chars = (m.characters ?? []).map((c) => CHARACTERS[c]);
  const loc = m.location ? LOCATIONS[m.location] : null;
  const parts = [
    `${SHOT_EN[scene.shot]}, ${CAMERA_EN[scene.camera]}.`,
    m.prompt + ".",
    chars.length ? "Characters: " + chars.map((c) => `${c.name.split(" ")[0]} = ${c.identity}, wearing ${c.wardrobe}`).join("; ") + "." : "",
    loc ? `Location: ${loc.prompt}.` : "",
    VISUAL_STYLE.positive + ".",
    m.type === "video" ? `Duration about ${Math.ceil(seconds)} seconds, no cuts, realistic motion.` : "Single still frame.",
  ];
  return {
    prompt: parts.filter(Boolean).join(" "),
    negative: VISUAL_STYLE.negative,
    referenceImages: [...chars.map((c) => c.referenceImage), ...(loc ? [loc.referenceImage] : [])],
    seconds,
  };
}
