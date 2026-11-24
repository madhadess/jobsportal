// Bölüm kompozisyonu: manifestteki sahneler + seslendirme + efekt + ortam sesi + altyazı + kapanış kartı.
import React from "react";
import { AbsoluteFill, Audio, Sequence, interpolate, staticFile, useCurrentFrame } from "remotion";
import { ambienceSegments } from "../pipeline/audio";
import type { AmbienceId, EpisodeManifest, SubtitleCue } from "../series/types";
import { ColorGrade, FilmGrain, MONO, SANS, SERIF, Vignette, ensureFonts } from "./fx";
import { SceneView } from "./Scene";

export type EpisodeProps = {
  episode: number;
  manifest: EpisodeManifest | null;
  subtitles: boolean;
  draftBadges: boolean;
};

const AMB_GAIN: Record<AmbienceId, number> = {
  roomTone: 0.32,
  fluorescent: 0.22,
  corridorDrone: 0.3,
  lowTension: 0.38,
  basementHum: 0.3,
  fireRoar: 0.35,
  rain: 0.25,
  cityMorning: 0.25,
  partyMusic: 0.5,
  nightStreet: 0.3,
  siren: 0.22,
};

const Subtitles: React.FC<{ cues: SubtitleCue[] }> = ({ cues }) => {
  const f = useCurrentFrame();
  const cue = cues.find((c) => f >= c.from && f < c.to);
  if (!cue) return null;
  const o = interpolate(f, [cue.from, cue.from + 4, cue.to - 4, cue.to], [0, 1, 1, 0], { extrapolateLeft: "clamp", extrapolateRight: "clamp" });
  const italic = cue.speaker !== "anlatici";
  return (
    <div style={{ position: "absolute", left: 90, right: 90, bottom: 330, textAlign: "center", opacity: o }}>
      <span
        style={{
          fontFamily: SANS,
          fontWeight: 500,
          fontStyle: italic ? "italic" : "normal",
          fontSize: 44,
          lineHeight: 1.3,
          color: cue.speaker === "anlatici" ? "#f1f1ee" : "#f6e7c8",
          textShadow: "0 2px 10px rgba(0,0,0,0.95), 0 0 2px rgba(0,0,0,1)",
          letterSpacing: 0.2,
        }}
      >
        {cue.text}
      </span>
    </div>
  );
};

const EndCard: React.FC<{ text: string; episode: number; sub?: string }> = ({ text, episode, sub }) => {
  const f = useCurrentFrame();
  const o = interpolate(f, [10, 26], [0, 1], { extrapolateLeft: "clamp", extrapolateRight: "clamp" });
  return (
    <AbsoluteFill style={{ background: "#000", alignItems: "center", justifyContent: "center" }}>
      <div style={{ opacity: o, textAlign: "center" }}>
        <div style={{ fontFamily: MONO, fontSize: 30, letterSpacing: 6, color: "rgba(255,255,255,0.86)" }}>{text}</div>
        <div style={{ fontFamily: SERIF, fontSize: 24, letterSpacing: 10, color: "rgba(255,255,255,0.35)", marginTop: 26 }}>{sub ?? `BEN ÖLMEDİM · ${String(episode).padStart(2, "0")}`}</div>
      </div>
    </AbsoluteFill>
  );
};

const NotPrepared: React.FC<{ episode: number }> = ({ episode }) => (
  <AbsoluteFill style={{ background: "#000", alignItems: "center", justifyContent: "center", color: "#ddd", fontFamily: MONO, fontSize: 34, textAlign: "center", padding: 80 }}>
    Bölüm {episode} hazırlanmadı.
    <br />
    <br />
    npm run prepare:ep -- {episode}
  </AbsoluteFill>
);

export const Episode: React.FC<EpisodeProps> = ({ episode, manifest, subtitles, draftBadges }) => {
  ensureFonts();
  if (!manifest) return <NotPrepared episode={episode} />;
  const segs = ambienceSegments(manifest);
  const fade = 12;
  return (
    <AbsoluteFill style={{ background: "#000" }}>
      {manifest.scenes.map((s) => (
        <Sequence key={s.id} from={s.from} durationInFrames={s.durationInFrames} name={`${s.id} ${s.title}`}>
          <SceneView scene={s} draftBadges={draftBadges} />
        </Sequence>
      ))}
      <Sequence from={manifest.endCard.from} durationInFrames={manifest.endCard.durationInFrames} name="Kapanış">
        <EndCard text={manifest.endCard.text} episode={manifest.episode} sub={manifest.endCard.sub} />
      </Sequence>

      <ColorGrade />
      <FilmGrain opacity={0.14} />
      <Vignette />
      {subtitles && <Subtitles cues={manifest.subtitles} />}

      {/* ses: ortam */}
      {segs.map((seg, i) => (
        <Sequence key={`amb-${i}`} from={seg.from} durationInFrames={seg.to - seg.from + fade} name={`amb ${seg.id}`}>
          <Audio
            src={staticFile(`audio/sfx/amb_${seg.id}.wav`)}
            loop
            volume={(fr) => AMB_GAIN[seg.id] * interpolate(fr, [0, fade * 2, seg.to - seg.from - 2, seg.to - seg.from + fade], [0, 1, 1, 0], { extrapolateLeft: "clamp", extrapolateRight: "clamp" })}
          />
        </Sequence>
      ))}
      {/* ses: efektler */}
      {manifest.scenes.flatMap((s) =>
        s.sfx.map((c, i) => (
          <Sequence key={`${s.id}-sfx-${i}`} from={c.from} durationInFrames={c.durationInFrames} name={`sfx ${c.id}`}>
            <Audio src={staticFile(c.src)} volume={c.volume} />
          </Sequence>
        )),
      )}
      {/* ses: seslendirme */}
      {manifest.scenes.flatMap((s) =>
        s.lines.map((l, i) => (
          <Sequence key={`${s.id}-vo-${i}`} from={l.from} durationInFrames={l.durationInFrames} name={`vo ${l.speaker}`}>
            <Audio src={staticFile(l.src)} volume={1} />
          </Sequence>
        )),
      )}
    </AbsoluteFill>
  );
};
