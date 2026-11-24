// Tek sahne: kamera hareketi + (yapay zekâ medyası | prosedürel katman) + geçiş.
import React from "react";
import { AbsoluteFill, Img, OffthreadVideo, interpolate, random, staticFile, useCurrentFrame, useVideoConfig } from "remotion";
import { noise2D } from "@remotion/noise";
import type { CameraMove, Insert, ManifestLine, ManifestScene } from "../series/types";
import { Stage } from "./toon/Stage";
import { MONO } from "./fx";
import { Clock } from "./inserts/Clock";
import { Door } from "./inserts/Door";
import { Document, Monitors, Photo } from "./inserts/Paper";
import { Phone } from "./inserts/Phone";
import { Atmos, Cctv, Corridor, Elevator, Mirror, Peephole, Wall } from "./inserts/Spaces";

export function cameraTransform(move: CameraMove, frame: number, dur: number, tension: number): string {
  const p = Math.min(1, frame / Math.max(1, dur));
  const e = p * p * (3 - 2 * p) * 0.5 + p * 0.5; // yumuşak ama sürekli
  // her sahnede hafif "nefes alan" kamera: gerginlik arttıkça titreme artar
  const shakeAmp = (move === "handheld" ? 9 : 1.6) * (0.5 + tension);
  const sx = noise2D("camx", frame / 45, 0) * shakeAmp;
  const sy = noise2D("camy", frame / 45, 1) * shakeAmp;
  const rot = noise2D("camr", frame / 80, 2) * (move === "handheld" ? 0.45 : 0.08);
  let scale = 1.04;
  let tx = 0;
  let ty = 0;
  switch (move) {
    case "pushIn":
      scale = 1.03 + 0.14 * e;
      break;
    case "slowPushIn":
      scale = 1.03 + 0.07 * e;
      break;
    case "pullOut":
      scale = 1.17 - 0.13 * e;
      break;
    case "panLeft":
      scale = 1.12;
      tx = 50 - 100 * e;
      break;
    case "panRight":
      scale = 1.12;
      tx = -50 + 100 * e;
      break;
    case "tiltUp":
      scale = 1.12;
      ty = -70 + 140 * e;
      break;
    case "tiltDown":
      scale = 1.12;
      ty = 70 - 140 * e;
      break;
    case "dollyZoom":
      scale = 1.0 + 0.2 * e;
      break;
    case "drift":
      scale = 1.06;
      tx = noise2D("drift", frame / 200, 0) * 30;
      ty = -20 * e;
      break;
    default:
      break;
  }
  return `translate(${tx + sx}px, ${ty + sy}px) rotate(${rot}deg) scale(${scale})`;
}

export const InsertView: React.FC<{ insert: Insert; tension: number; lines?: (ManifestLine & { rel: number })[] }> = ({ insert, tension, lines = [] }) => {
  switch (insert.kind) {
    case "stage":
      return <Stage ins={insert} tension={tension} lines={lines} />;
    case "phone":
      return <Phone ins={insert} />;
    case "clock":
      return <Clock ins={insert} tension={tension} />;
    case "door":
      return <Door ins={insert} tension={tension} />;
    case "peephole":
      return <Peephole ins={insert} />;
    case "cctv":
      return <Cctv ins={insert} />;
    case "document":
      return <Document ins={insert} />;
    case "corridor":
      return <Corridor ins={insert} tension={tension} />;
    case "monitors":
      return <Monitors ins={insert} />;
    case "photo":
      return <Photo ins={insert} />;
    case "atmos":
      return <Atmos ins={insert} tension={tension} />;
    case "wall":
      return <Wall ins={insert} />;
    case "mirror":
      return <Mirror ins={insert} />;
    case "elevator":
      return <Elevator ins={insert} />;
    case "blackout":
      return <AbsoluteFill style={{ background: "#000" }} />;
  }
};

const TransitionIn: React.FC<{ kind: ManifestScene["transitionIn"] }> = ({ kind }) => {
  const f = useCurrentFrame();
  if (kind === "cut") return null;
  if (kind === "fade") {
    const o = interpolate(f, [0, 14], [1, 0], { extrapolateRight: "clamp" });
    return o > 0 ? <AbsoluteFill style={{ background: "#000", opacity: o }} /> : null;
  }
  if (kind === "blackout") {
    const o = interpolate(f, [0, 8, 22], [1, 1, 0], { extrapolateRight: "clamp" });
    return o > 0 ? <AbsoluteFill style={{ background: "#000", opacity: o }} /> : null;
  }
  if (kind === "flash") {
    const o = interpolate(f, [0, 6], [0.9, 0], { extrapolateRight: "clamp" });
    return o > 0 ? <AbsoluteFill style={{ background: "#fff", opacity: o }} /> : null;
  }
  // glitch
  if (f > 9) return null;
  return (
    <AbsoluteFill style={{ mixBlendMode: "screen" }}>
      {new Array(7).fill(0).map((_, i) => (
        <div
          key={i}
          style={{
            position: "absolute",
            left: 0,
            right: 0,
            top: random(`g${f}-${i}`) * 1920,
            height: 20 + random(`gh${f}-${i}`) * 120,
            background: i % 2 ? "rgba(255,0,60,0.35)" : "rgba(0,255,220,0.25)",
            transform: `translateX(${(random(`gx${f}-${i}`) - 0.5) * 200}px)`,
          }}
        />
      ))}
    </AbsoluteFill>
  );
};

export const SceneView: React.FC<{ scene: ManifestScene; draftBadges: boolean }> = ({ scene, draftBadges }) => {
  const frame = useCurrentFrame();
  const { durationInFrames } = useVideoConfig();
  const transform = cameraTransform(scene.camera, frame, durationInFrames, scene.tension);
  const media = scene.media;
  return (
    <AbsoluteFill style={{ background: "#000", overflow: "hidden" }}>
      <AbsoluteFill style={{ transform }}>
        {media ? (
          <>
            {media.type === "video" ? (
              <OffthreadVideo src={staticFile(media.src)} muted style={{ width: "100%", height: "100%", objectFit: "cover" }} />
            ) : (
              <Img src={staticFile(media.src)} style={{ width: "100%", height: "100%", objectFit: "cover" }} />
            )}
            {media.overlayInsert && scene.insert && (
              <AbsoluteFill style={{ mixBlendMode: "screen", opacity: 0.55 }}>
                <InsertView insert={scene.insert} tension={scene.tension} />
              </AbsoluteFill>
            )}
          </>
        ) : scene.insert ? (
          <InsertView insert={scene.insert} tension={scene.tension} lines={scene.lines.map((l) => ({ ...l, rel: l.from - scene.from }))} />
        ) : (
          <Atmos ins={{ kind: "atmos", tone: "cold", light: "steady" }} tension={scene.tension} />
        )}
      </AbsoluteFill>
      <TransitionIn kind={scene.transitionIn} />
      {draftBadges && scene.mediaMissing && (
        <div style={{ position: "absolute", bottom: 70, left: "50%", transform: "translateX(-50%)", whiteSpace: "nowrap", padding: "8px 16px", borderRadius: 8, background: "rgba(0,0,0,0.55)", border: "1px solid rgba(255,255,255,0.25)", fontFamily: MONO, fontSize: 22, color: "rgba(255,255,255,0.75)" }}>
          ANİMATİK · {scene.id} · AI klip bekleniyor
        </div>
      )}
    </AbsoluteFill>
  );
};
