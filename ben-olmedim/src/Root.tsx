import React from "react";
import { Composition, staticFile } from "remotion";
import { Episode, type EpisodeProps } from "./components/Episode";
import { SERIES } from "./series/bible";
import type { EpisodeManifest } from "./series/types";

const pad = (n: number) => String(n).padStart(2, "0");

export const RemotionRoot: React.FC = () => (
  <>
    {new Array(SERIES.episodes).fill(0).map((_, i) => {
      const n = i + 1;
      return (
        <Composition
          key={n}
          id={`B${pad(n)}`}
          component={Episode}
          width={SERIES.width}
          height={SERIES.height}
          fps={SERIES.fps}
          durationInFrames={SERIES.fps * 3}
          defaultProps={{ episode: n, manifest: null, subtitles: true, draftBadges: true } satisfies EpisodeProps}
          calculateMetadata={async ({ props }) => {
            if (props.manifest) return { durationInFrames: props.manifest.durationInFrames };
            try {
              const res = await fetch(staticFile(`manifests/e${pad(n)}.json`));
              if (!res.ok) return {};
              const manifest = (await res.json()) as EpisodeManifest;
              return { durationInFrames: manifest.durationInFrames, props: { ...props, manifest } };
            } catch {
              return {};
            }
          }}
        />
      );
    })}
  </>
);
