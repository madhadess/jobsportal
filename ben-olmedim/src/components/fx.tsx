// Ortak sinematik katmanlar: font, film greni, vinyet, titreme, siluet.
import React from "react";
import { AbsoluteFill, continueRender, delayRender, random, staticFile, useCurrentFrame } from "remotion";
import { noise2D } from "@remotion/noise";

// ---------------------------------------------------------------- fontlar
const FONTS: [string, string, string][] = [
  ["Inter", "fonts/Inter-Light.otf", "300"],
  ["Inter", "fonts/Inter-Regular.otf", "400"],
  ["Inter", "fonts/Inter-Medium.otf", "500"],
  ["Inter", "fonts/Inter-SemiBold.otf", "600"],
  ["Mono", "fonts/JetBrainsMono-Regular.ttf", "400"],
  ["Mono", "fonts/JetBrainsMono-Medium.ttf", "500"],
  ["Serif", "fonts/LiberationSerif-Regular.ttf", "400"],
  ["Serif", "fonts/LiberationSerif-Bold.ttf", "700"],
  ["SerifItalic", "fonts/LiberationSerif-Italic.ttf", "400"],
];

let fontsRequested = false;
export function ensureFonts() {
  if (fontsRequested || typeof document === "undefined") return;
  fontsRequested = true;
  const handle = delayRender("fontlar");
  Promise.all(
    FONTS.map(([family, file, weight]) => {
      const f = new FontFace(family, `url(${staticFile(file)})`, { weight });
      return f.load().then((loaded) => (document.fonts as unknown as { add: (f: FontFace) => void }).add(loaded));
    }),
  )
    .then(() => continueRender(handle))
    .catch((e) => {
      console.error(e);
      continueRender(handle);
    });
}

export const SANS = "Inter, sans-serif";
export const MONO = "Mono, monospace";
export const SERIF = "Serif, serif";
export const SERIF_I = "SerifItalic, serif";

// ---------------------------------------------------------------- yardımcılar
export const clamp01 = (v: number) => Math.max(0, Math.min(1, v));
export const ease = (t: number) => (t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2);

/** Floresan/ampul titremesi: 0..1 parlaklık. intensity 0 → sabit. */
export function useFlicker(seed: string, intensity: number): number {
  const f = useCurrentFrame();
  if (intensity <= 0) return 1;
  const slow = noise2D(seed, f / 40, 0) * 0.08;
  const burst = random(`${seed}-${Math.floor(f / 3)}`) < 0.06 * intensity ? random(`${seed}-b-${f}`) * 0.7 : 0;
  const dropout = random(`${seed}-d-${Math.floor(f / 2)}`) < 0.015 * intensity ? 0.85 : 0;
  return Math.max(0.05, 1 - burst - dropout + slow);
}

// ---------------------------------------------------------------- film greni
export const FilmGrain: React.FC<{ opacity?: number }> = ({ opacity = 0.16 }) => {
  const f = useCurrentFrame();
  const seed = (f % 8) * 13 + 1;
  return (
    <AbsoluteFill style={{ pointerEvents: "none", mixBlendMode: "overlay", opacity }}>
      <svg width="100%" height="100%">
        <filter id={`grain-${seed}`}>
          <feTurbulence type="fractalNoise" baseFrequency="0.85" numOctaves="2" seed={seed} stitchTiles="stitch" />
          <feColorMatrix type="saturate" values="0" />
        </filter>
        <rect width="100%" height="100%" filter={`url(#grain-${seed})`} />
      </svg>
    </AbsoluteFill>
  );
};

export const Vignette: React.FC<{ strength?: number }> = ({ strength = 0.85 }) => (
  <AbsoluteFill
    style={{
      pointerEvents: "none",
      background: `radial-gradient(ellipse 75% 60% at 50% 48%, rgba(0,0,0,0) 35%, rgba(0,0,0,${strength * 0.7}) 75%, rgba(0,0,0,${strength}) 100%)`,
    }}
  />
);

/** Soğuk renk derecelendirme + hafif ışık sızması */
export const ColorGrade: React.FC = () => (
  <>
    <AbsoluteFill style={{ pointerEvents: "none", background: "linear-gradient(180deg, rgba(20,40,55,0.18), rgba(0,0,0,0) 40%, rgba(40,30,10,0.12))", mixBlendMode: "soft-light" }} />
    <AbsoluteFill style={{ pointerEvents: "none", background: "rgba(10,25,35,0.12)", mixBlendMode: "multiply" }} />
  </>
);

/** Toz parçacıkları (ışık huzmesinde süzülen) */
export const Dust: React.FC<{ count?: number; seed?: string; color?: string; area?: [number, number, number, number] }> = ({
  count = 60,
  seed = "dust",
  color = "rgba(220,230,240,0.55)",
  area = [0, 0, 1080, 1920],
}) => {
  const f = useCurrentFrame();
  return (
    <AbsoluteFill style={{ pointerEvents: "none" }}>
      <svg width={1080} height={1920}>
        {new Array(count).fill(0).map((_, i) => {
          const x0 = area[0] + random(`${seed}x${i}`) * area[2];
          const y0 = area[1] + random(`${seed}y${i}`) * area[3];
          const r = 0.8 + random(`${seed}r${i}`) * 2.4;
          const x = x0 + noise2D(`${seed}nx${i}`, f / 160, i) * 60;
          const y = y0 + noise2D(`${seed}ny${i}`, f / 160, i) * 60 - f * 0.08;
          const tw = 0.4 + 0.6 * Math.abs(noise2D(`${seed}t${i}`, f / 30, 0));
          return <circle key={i} cx={x} cy={((y % 1920) + 1920) % 1920} r={r} fill={color} opacity={tw} />;
        })}
      </svg>
    </AbsoluteFill>
  );
};

// ---------------------------------------------------------------- siluet
/** Baş-omuz-gövde siluet. (x,y) ayak noktası, h piksel boy. rim: bir yandan vuran kenar ışığı rengi. */
export const Silhouette: React.FC<{
  x: number;
  y: number;
  h: number;
  child?: boolean;
  fill?: string;
  blur?: number;
  eyes?: number; // 0..1 göz parıltısı
  headTurn?: number; // -1..1
  opacity?: number;
  rim?: string;
}> = ({ x, y, h, child = false, fill = "#050607", blur = 2, eyes = 0, headTurn = 0, opacity = 1, rim }) => {
  const k = h / 1000;
  const sw = child ? 1.12 : 1; // çocuk: daha iri baş, dar omuz
  const headR = (child ? 92 : 66) * k;
  const top = y - h;
  const hx = x + headTurn * headR * 0.25;
  const hy = top + headR * 1.05;
  const neck = hy + headR * 0.95;
  const sh = neck + 38 * k;
  const W = (child ? 120 : 150) * k * sw;
  const body = `M ${x - 28 * k} ${neck}
    C ${x - 40 * k} ${sh - 6 * k}, ${x - W * 0.9} ${sh - 8 * k}, ${x - W} ${sh + 40 * k}
    C ${x - W * 1.08} ${sh + 160 * k}, ${x - W * 1.02} ${y - h * 0.45}, ${x - W * 0.98} ${y - h * 0.3}
    L ${x - W * 0.72} ${y - h * 0.3} L ${x - W * 0.6} ${y}
    L ${x + W * 0.6} ${y} L ${x + W * 0.72} ${y - h * 0.3} L ${x + W * 0.98} ${y - h * 0.3}
    C ${x + W * 1.02} ${y - h * 0.45}, ${x + W * 1.08} ${sh + 160 * k}, ${x + W} ${sh + 40 * k}
    C ${x + W * 0.9} ${sh - 8 * k}, ${x + 40 * k} ${sh - 6 * k}, ${x + 28 * k} ${neck} Z`;
  const shape = (color: string) => (
    <>
      <path d={body} fill={color} />
      <ellipse cx={hx} cy={hy} rx={headR * 0.84} ry={headR} fill={color} />
    </>
  );
  return (
    <g opacity={opacity}>
      {rim && (
        <g transform={`translate(${-6 * k * 3} ${-2 * k})`} style={{ filter: `blur(${Math.max(3, blur * 2.5)}px)` }}>
          {shape(rim)}
        </g>
      )}
      <g style={{ filter: blur ? `blur(${blur}px)` : undefined }}>{shape(fill)}</g>
      {eyes > 0 && (
        <g opacity={eyes} style={{ filter: "blur(0.6px)" }}>
          {[-1, 1].map((d) => (
            <g key={d}>
              <circle cx={hx + d * headR * 0.32 + headTurn * headR * 0.3} cy={hy - headR * 0.05} r={headR * 0.08} fill="#e8f4ff" />
              <circle cx={hx + d * headR * 0.32 + headTurn * headR * 0.3} cy={hy - headR * 0.05} r={headR * 0.3} fill="#e8f4ff" opacity={0.14} />
            </g>
          ))}
        </g>
      )}
    </g>
  );
};

/** Göreli zamanı saniye olarak döndürür */
export const useSeconds = (fps = 30) => useCurrentFrame() / fps;
