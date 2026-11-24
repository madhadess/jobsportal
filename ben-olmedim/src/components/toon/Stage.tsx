// 2D animasyon sahnesi: dekor + karakterler + ışık. Tamamen Remotion/SVG.
import React from "react";
import { AbsoluteFill, random, useCurrentFrame, useVideoConfig } from "remotion";
import { noise2D } from "@remotion/noise";
import type { ActorExpr, ActorPose, ManifestLine, StageActor, StageInsert, StageTime } from "../../series/types";
import { Dust, useFlicker } from "../fx";
import { Character, LOOKS } from "./Character";

const W = 1080;
const H = 1920;

// ---------------------------------------------------------------- dekor parçaları

const Wallpaper: React.FC<{ base: string; dim: number }> = ({ base, dim }) => (
  <>
    <rect width={W} height={1500} fill={base} />
    <rect width={W} height={1500} fill="url(#wpPattern)" opacity={0.35} />
    <rect width={W} height={1500} fill="#000" opacity={dim} />
  </>
);

const Defs: React.FC = () => (
  <defs>
    <pattern id="wpPattern" width="90" height="90" patternUnits="userSpaceOnUse">
      <path d="M 45 10 Q 60 30 45 50 Q 30 30 45 10 Z" fill="#000" opacity={0.25} />
      <circle cx="0" cy="70" r="6" fill="#000" opacity={0.2} />
      <circle cx="90" cy="70" r="6" fill="#000" opacity={0.2} />
    </pattern>
    <pattern id="rugPattern" width="60" height="60" patternUnits="userSpaceOnUse">
      <rect width="60" height="60" fill="#5a1f1f" />
      <path d="M 30 5 L 55 30 L 30 55 L 5 30 Z" fill="#7a3a2a" />
      <circle cx="30" cy="30" r="6" fill="#c9a24a" opacity={0.7} />
    </pattern>
    <radialGradient id="lampGlow">
      <stop offset="0" stopColor="#ffd890" stopOpacity="0.85" />
      <stop offset="1" stopColor="#ffd890" stopOpacity="0" />
    </radialGradient>
    <radialGradient id="candleGlow">
      <stop offset="0" stopColor="#ffb054" stopOpacity="0.7" />
      <stop offset="1" stopColor="#ff8a2a" stopOpacity="0" />
    </radialGradient>
    <linearGradient id="floorGrad" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0" stopColor="#3a2a1e" />
      <stop offset="1" stopColor="#1a120c" />
    </linearGradient>
  </defs>
);

const Room: React.FC<{ wall: string; dim: number; doorAjar?: number; lampOn?: boolean; window?: boolean; sofa?: boolean }> = ({ wall, dim, doorAjar = 0, lampOn = true, window = true, sofa = true }) => (
  <g>
    <Wallpaper base={wall} dim={dim} />
    {/* tavan pervazı ve tavan */}
    <rect width={W} height={150} fill="#000" opacity={0.35 + dim * 0.4} />
    <rect y={150} width={W} height={14} fill="#c9b89a" opacity={0.25} />
    {/* kapı (sol) */}
    <rect x={40} y={620} width={250} height={880} fill="#2a1a10" />
    <rect x={52} y={632} width={226} height={868} fill="#4a2e1c" />
    <rect x={52} y={632} width={226} height={868} fill="#000" opacity={dim * 0.6} />
    {doorAjar > 0 && <rect x={52} y={632} width={226 * doorAjar} height={868} fill="#050302" />}
    <circle cx={258} cy={1080} r={10} fill="#c9a24a" />
    {/* pencere ve tül */}
    {window && (
      <g>
        <rect x={640} y={360} width={330} height={520} fill="#0d1a2a" />
        <rect x={640} y={360} width={330} height={520} fill="#6f8fb0" opacity={0.18} />
        <path d="M 650 360 Q 700 600 660 880 L 640 880 L 640 360 Z" fill="#d9d4c6" opacity={0.35} />
        <path d="M 960 360 Q 910 600 950 880 L 970 880 L 970 360 Z" fill="#d9d4c6" opacity={0.35} />
        <rect x={630} y={350} width={350} height={14} fill="#2a1a10" />
      </g>
    )}
    {/* zemin, halı */}
    <rect y={1500} width={W} height={420} fill="url(#floorGrad)" />
    <ellipse cx={540} cy={1700} rx={500} ry={150} fill="url(#rugPattern)" opacity={0.8} />
    <ellipse cx={540} cy={1700} rx={500} ry={150} fill="#000" opacity={0.25 + dim * 0.4} />
    {/* kanepe */}
    {sofa && (
      <g>
        <rect x={600} y={1200} width={470} height={300} rx={40} fill="#4b3a5a" />
        <rect x={600} y={1110} width={470} height={150} rx={40} fill="#5a4669" />
        <rect x={600} y={1200} width={470} height={300} rx={40} fill="#000" opacity={dim * 0.6} />
      </g>
    )}
    {/* lambader */}
    <g>
      <rect x={472} y={1050} width={10} height={450} fill="#222" />
      <path d="M 430 1050 L 524 1050 L 505 980 L 449 980 Z" fill={lampOn ? "#f1d9a0" : "#6a5f4a"} />
      {lampOn && <circle cx={477} cy={1040} r={260} fill="url(#lampGlow)" opacity={0.55} />}
    </g>
  </g>
);

const PartyLights: React.FC<{ t: number; on: number }> = ({ t, on }) => {
  const beat = t * (124 / 60);
  const colors = ["#ff2e88", "#2ee6ff", "#ffd23a", "#8a5bff"];
  return (
    <g opacity={on} style={{ mixBlendMode: "screen" }}>
      {[0, 1, 2].map((i) => {
        const ang = Math.sin(t * 0.9 + i * 2.1) * 35;
        const c = colors[(Math.floor(beat) + i) % colors.length];
        return <path key={i} d="M 540 140 L 300 1900 L 780 1900 Z" fill={c} opacity={0.16 + 0.08 * (Math.floor(beat) % 2)} transform={`rotate(${ang} 540 140)`} style={{ filter: "blur(18px)" }} />;
      })}
      {[...Array(40)].map((_, i) => {
        const x = (random(`dot${i}`) * W + t * 60 * (i % 2 ? 1 : -1)) % W;
        const y = random(`doty${i}`) * 1500;
        return <circle key={i} cx={(x + W) % W} cy={y} r={7} fill={colors[(i + Math.floor(beat)) % 4]} opacity={0.5} />;
      })}
      <circle cx={540} cy={150} r={40} fill="#cfd6e0" />
    </g>
  );
};

const Candles: React.FC<{ t: number }> = ({ t }) => (
  <g>
    {[...Array(9)].map((_, i) => {
      const a = (i / 9) * Math.PI * 2;
      const x = 540 + Math.cos(a) * 330;
      const y = 1700 + Math.sin(a) * 95;
      const f = 1 + noise2D("cf" + i, t * 4, 0) * 0.25;
      return (
        <g key={i}>
          <circle cx={x} cy={y - 60} r={110} fill="url(#candleGlow)" opacity={0.55} />
          <rect x={x - 12} y={y - 55} width={24} height={60} rx={4} fill="#efe6d2" />
          <path d={`M ${x} ${y - 95 * f} Q ${x + 12} ${y - 70} ${x} ${y - 58} Q ${x - 12} ${y - 70} ${x} ${y - 95 * f} Z`} fill="#ffcf6a" />
          <path d={`M ${x} ${y - 80 * f} Q ${x + 5} ${y - 68} ${x} ${y - 62} Q ${x - 5} ${y - 68} ${x} ${y - 80 * f} Z`} fill="#fff6d0" />
        </g>
      );
    })}
  </g>
);

const Street: React.FC<{ t: number; speed: number }> = ({ t, speed }) => {
  const off = (t * 900 * speed) % 400;
  return (
    <g>
      <rect width={W} height={H} fill="#070a12" />
      {/* bina siluetleri, pencereler */}
      {[...Array(8)].map((_, i) => {
        const x = ((i * 260 - t * 140 * speed) % 2080 + 2080) % 2080 - 500;
        const h = 500 + (i % 3) * 180;
        return (
          <g key={i}>
            <rect x={x} y={1000 - h} width={240} height={h + 10} fill="#0e121c" />
            {[...Array(12)].map((_, k) => (
              <rect key={k} x={x + 30 + (k % 3) * 65} y={1000 - h + 40 + Math.floor(k / 3) * 110} width={36} height={52} fill={random(`w${i}-${k}`) > 0.75 ? "#e8c27a" : "#151a26"} opacity={0.9} />
            ))}
          </g>
        );
      })}
      {/* yol perspektifi */}
      <path d="M 0 1920 L 470 1000 L 610 1000 L 1080 1920 Z" fill="#14161c" />
      {[...Array(7)].map((_, i) => {
        const p = ((i * 400 + off) % 2800) / 2800;
        const y = 1000 + p * p * 920;
        const w = 6 + p * 30;
        return <rect key={i} x={540 - w / 2} y={y} width={w} height={20 + p * 120} fill="#d9d2b0" opacity={0.7} />;
      })}
      {/* sokak lambaları */}
      {[...Array(4)].map((_, i) => {
        const p = ((i * 700 + off * 1.7) % 2800) / 2800;
        const y = 1000 - 260 * p * p;
        const x = 470 - p * p * 470 - 60;
        return (
          <g key={i} opacity={Math.min(1, p * 3)}>
            <rect x={x} y={y} width={6 + p * 14} height={260 * (0.3 + p)} fill="#222" />
            <circle cx={x + 5} cy={y} r={10 + p * 50} fill="#ffcf80" opacity={0.85} />
            <circle cx={x + 5} cy={y} r={60 + p * 200} fill="url(#lampGlow)" opacity={0.5} />
          </g>
        );
      })}
      {/* ıslak yol yansıması */}
      <path d="M 0 1920 L 470 1000 L 610 1000 L 1080 1920 Z" fill="#ffcf80" opacity={0.05} />
    </g>
  );
};

const PoliceCar: React.FC<{ t: number }> = ({ t }) => {
  const blue = Math.floor(t * 3) % 2 === 0;
  return (
    <g>
      <rect width={W} height={H} fill="#1b1f27" />
      <rect x={120} y={200} width={840} height={1250} fill="#3a3a40" />
      {[...Array(15)].map((_, i) => (
        <rect key={i} x={180 + (i % 3) * 260} y={260 + Math.floor(i / 3) * 230} width={160} height={150} fill="#1f2530" />
      ))}
      <rect y={1450} width={W} height={470} fill="#2a2c30" />
      {/* araba */}
      <g transform="translate(140 1380)">
        <rect x={0} y={130} width={800} height={190} rx={50} fill="#e9ecef" />
        <path d="M 170 130 L 260 20 L 560 20 L 650 130 Z" fill="#dfe3e8" />
        <path d="M 200 125 L 275 40 L 400 40 L 400 125 Z M 420 125 L 420 40 L 545 40 L 620 125 Z" fill="#273544" />
        <rect x={0} y={220} width={800} height={36} fill="#1f4e8c" />
        <text x={400} y={248} textAnchor="middle" fontFamily="Inter" fontWeight={700} fontSize={30} fill="#fff">POLİS</text>
        <circle cx={170} cy={330} r={62} fill="#111" />
        <circle cx={630} cy={330} r={62} fill="#111" />
        <rect x={330} y={-10} width={70} height={30} rx={8} fill={blue ? "#3f7bff" : "#3a1010"} />
        <rect x={400} y={-10} width={70} height={30} rx={8} fill={blue ? "#102040" : "#ff3030"} />
      </g>
      <rect width={W} height={H} fill={blue ? "#2a5bff" : "#ff2a2a"} opacity={0.12} />
    </g>
  );
};

const Doorway: React.FC = () => (
  <g>
    <rect width={W} height={H} fill="#6c6a60" />
    <rect width={W} height={H} fill="#000" opacity={0.35} />
    <rect x={190} y={300} width={700} height={1420} fill="#2a1a10" />
    <rect x={220} y={330} width={640} height={1390} fill="#1a1410" />
    <rect x={220} y={330} width={640} height={1390} fill="#cfc6a8" opacity={0.18} />
    <rect y={1720} width={W} height={200} fill="#4a463e" />
    <text x={540} y={270} textAnchor="middle" fontFamily="Serif" fontSize={70} fill="#b8954a">4</text>
  </g>
);

const Bedroom: React.FC = () => (
  <g>
    <Wallpaper base="#3a4048" dim={0.45} />
    <rect y={1500} width={W} height={420} fill="url(#floorGrad)" />
    <rect x={60} y={1260} width={960} height={260} rx={20} fill="#3a4a6a" />
    <rect x={60} y={1200} width={960} height={110} rx={30} fill="#d8d4cc" />
    <rect x={680} y={420} width={300} height={420} fill="#0d1a2a" />
    <rect x={680} y={420} width={300} height={420} fill="#9ab3cf" opacity={0.15} />
  </g>
);

const GlassStain: React.FC<{ t: number; stainAt: number }> = ({ t, stainAt }) => {
  const k = Math.max(0, Math.min(1, (t - stainAt) / 3.5));
  const fall = Math.max(0, Math.min(1, (t - stainAt + 0.6) / 0.5));
  return (
    <g>
      <rect width={W} height={H} fill="url(#rugPattern)" />
      <rect width={W} height={H} fill="#000" opacity={0.45} />
      {/* bardak */}
      <g transform={`translate(560 ${900}) rotate(${fall * 85} 0 300)`}>
        <path d="M -110 0 L 110 0 L 90 320 L -90 320 Z" fill="#cfe4f0" opacity={0.35} stroke="#e9f4fa" strokeWidth={6} />
        <path d={`M -98 ${120} L 98 ${120} L 90 320 L -90 320 Z`} fill="#9cc4dc" opacity={fall > 0.5 ? 0 : 0.45} />
      </g>
      {/* yayılan siyah leke */}
      <g style={{ filter: "blur(3px)" }}>
        <ellipse cx={520} cy={1320} rx={60 + k * 380} ry={30 + k * 210} fill="#030303" opacity={k > 0 ? 0.95 : 0} />
        {[...Array(6)].map((_, i) => (
          <ellipse key={i} cx={520 + Math.cos(i) * (80 + k * 300)} cy={1320 + Math.sin(i * 1.7) * (40 + k * 170)} rx={20 + k * 90} ry={12 + k * 50} fill="#030303" opacity={k > 0.1 ? 0.9 : 0} />
        ))}
        <ellipse cx={470} cy={1270} rx={40 + k * 120} ry={10 + k * 30} fill="#5a6a7a" opacity={k * 0.25} />
      </g>
    </g>
  );
};

const DoorCeiling: React.FC<{ t: number; period: number }> = ({ t, period }) => {
  const phase = Math.floor(t / period) % 2;
  const k = (t % period) / period;
  const pulse = Math.sin(Math.min(1, k * 2) * Math.PI);
  return (
    <g>
      <rect width={W} height={H} fill="#06070a" />
      {/* tavan köşesi */}
      <path d="M 0 0 L 1080 0 L 1080 260 L 540 520 L 0 260 Z" fill="#14161c" />
      <path d="M 0 0 L 1080 0 L 1080 260 L 540 520 L 0 260 Z" fill="#c8d4e8" opacity={phase ? pulse * 0.35 : 0.03} />
      <path d="M 540 520 L 540 1920" stroke="#0c0d12" strokeWidth={8} />
      {/* kapı */}
      <g>
        <rect x={150} y={760} width={300} height={1000} fill="#1c130c" />
        <rect x={170} y={780} width={110} height={980} fill="#020202" />
        <rect x={150} y={760} width={300} height={1000} fill="#e0c79a" opacity={phase ? 0.02 : pulse * 0.25} />
      </g>
      <rect y={1760} width={W} height={160} fill="#0a0b0e" />
    </g>
  );
};

const Hallway: React.FC<{ dim: number }> = ({ dim }) => (
  <g>
    <rect width={W} height={H} fill="#1d1a16" />
    <path d="M 0 0 L 380 700 L 380 1300 L 0 1920 Z" fill="#3a332a" />
    <path d="M 1080 0 L 700 700 L 700 1300 L 1080 1920 Z" fill="#332c24" />
    <path d="M 0 1920 L 380 1300 L 700 1300 L 1080 1920 Z" fill="#2a221a" />
    <rect x={380} y={700} width={320} height={600} fill="#050404" />
    <rect width={W} height={H} fill="#000" opacity={dim} />
  </g>
);

// ---------------------------------------------------------------- oyuncu

type Resolve = (v: StageTime) => number;

/** "L2", "E1+3.2" gibi replik bağlantılı zamanları saniyeye çevirir. */
export function makeResolver(lines: { rel: number; durationInFrames: number }[], fps: number): Resolve {
  return (v) => {
    if (typeof v === "number") return v;
    const m = /^([LE])(\d+)([+-]\d+(?:\.\d+)?)?$/.exec(v);
    if (!m) return 0;
    const l = lines[Number(m[2])];
    if (!l) return 0;
    const base = m[1] === "L" ? l.rel : l.rel + l.durationInFrames;
    return base / fps + (m[3] ? Number(m[3]) : 0);
  };
}

function at<T>(base: T, list: [StageTime, T][] | undefined, t: number, r: Resolve): T {
  let v = base;
  for (const [s, val] of list ?? []) if (t >= r(s)) v = val;
  return v;
}

const Actor: React.FC<{ a: StageActor; t: number; mouth: number; idx: number; r: Resolve }> = ({ a, t, mouth, idx, r }) => {
  if (a.appearAt !== undefined && t < r(a.appearAt)) return null;
  if (a.vanishAt !== undefined && t >= r(a.vanishAt)) return null;
  let x = a.x;
  let scale = a.scale ?? 1;
  let y = a.y ?? 1720;
  let pose: ActorPose = at(a.pose, a.poseAt, t, r);
  if (a.moveTo) {
    const [s0, e0, tx, ts, ty] = a.moveTo;
    const s = r(s0);
    const e = r(e0);
    const k = Math.max(0, Math.min(1, (t - s) / Math.max(0.01, e - s)));
    x = a.x + (tx - a.x) * k;
    if (ts !== undefined) scale = (a.scale ?? 1) + (ts - (a.scale ?? 1)) * k;
    if (ty !== undefined) y = (a.y ?? 1720) + (ty - (a.y ?? 1720)) * k;
    if (k > 0 && k < 1 && pose === "stand") pose = "walk";
  }
  const expr: ActorExpr = at(a.expr, a.exprAt, t, r);
  return (
    <g transform={`translate(${x * W} ${y}) scale(${a.flip ? -scale : scale} ${scale})`}>
      <ellipse cx={0} cy={6} rx={pose === "lie" ? 520 : 140} ry={26} fill="#000" opacity={0.45} />
      <Character look={LOOKS[a.who]} pose={pose} expr={expr} t={t} mouth={mouth} seed={`${a.who}-${idx}`} back={a.back} bandages={a.bandages} pointPeriod={a.pointPeriod} shake={a.shake} lookX={a.lookX} />
    </g>
  );
};

// ---------------------------------------------------------------- sahne

export const Stage: React.FC<{ ins: StageInsert; tension: number; lines: (ManifestLine & { rel: number })[] }> = ({ ins, tension, lines }) => {
  const f = useCurrentFrame();
  const { fps } = useVideoConfig();
  const t = f / fps;
  const flick = useFlicker(`stage-${ins.bg}`, ins.bg === "candles" ? 0.3 : ins.bg === "living" || ins.bg === "hallway" ? 0.6 : 0.15);
  const lightsOn = ins.lightsOffAt === undefined ? 1 : t < ins.lightsOffAt ? 1 : 0;

  const mouthFor = (a: StageActor) => {
    if (!a.speaks?.length) return 0;
    for (const l of lines) {
      if (!a.speaks.includes(l.speaker)) continue;
      const k = f - l.rel;
      if (k >= 0 && k < l.durationInFrames) return l.env?.[k] ?? 0.5 + 0.5 * Math.abs(noise2D("m", f / 3, 0));
    }
    return 0;
  };

  const resolve = makeResolver(lines, fps);
  // derinlik: y'si küçük (uzakta) olan önce çizilir
  const order = ins.actors.map((a, i) => ({ a, i })).sort((p, q) => (p.a.y ?? 1720) - (q.a.y ?? 1720));

  const bg = (() => {
    switch (ins.bg) {
      case "party":
        return <Room wall="#3a2f45" dim={lightsOn ? 0.45 : 0.62} lampOn={!lightsOn} />;
      case "living":
        return <Room wall="#3a3530" dim={0.55} doorAjar={0.35} lampOn />;
      case "candles":
        return <Room wall="#2a2420" dim={0.82} lampOn={false} sofa />;
      case "street":
        return <Street t={t} speed={ins.speed ?? 1} />;
      case "police":
        return <PoliceCar t={t} />;
      case "doorway":
        return <Doorway />;
      case "bedroom":
        return <Bedroom />;
      case "glass":
        return <GlassStain t={t} stainAt={ins.stainAt ?? 2} />;
      case "doorCeiling":
        return <DoorCeiling t={t} period={ins.period ?? 1.6} />;
      case "hallway":
        return <Hallway dim={0.3} />;
    }
  })();

  return (
    <AbsoluteFill style={{ background: "#000" }}>
      <svg width={W} height={H} viewBox={`0 0 ${W} ${H}`}>
        <Defs />
        <g style={{ filter: `brightness(${0.75 + 0.25 * flick})` }}>{bg}</g>
        {ins.bg === "party" && <PartyLights t={t} on={lightsOn} />}
        {ins.bg === "candles" && <Candles t={t} />}
        <g style={{ filter: `brightness(${(ins.bg === "candles" ? 0.62 : ins.bg === "party" && lightsOn ? 0.85 : 0.72) * (0.85 + 0.15 * flick)})` }}>
          {order.map(({ a, i }) => (
            <Actor key={i} a={a} t={t} mouth={mouthFor(a)} idx={i} r={resolve} />
          ))}
        </g>
        {/* sahne ışığı: mum alttan turuncu, parti renkli, diğerleri soğuk */}
        {ins.bg === "candles" && <rect width={W} height={H} fill="url(#candleBottom)" />}
        <defs>
          <linearGradient id="candleBottom" x1="0" y1="1" x2="0" y2="0">
            <stop offset="0" stopColor="#ff9a3a" stopOpacity="0.35" />
            <stop offset="0.5" stopColor="#ff9a3a" stopOpacity="0.08" />
            <stop offset="1" stopColor="#000" stopOpacity="0.3" />
          </linearGradient>
        </defs>
        {ins.bg === "party" && lightsOn > 0 && (
          <rect width={W} height={H} fill={["#ff2e88", "#2ee6ff", "#ffd23a", "#8a5bff"][Math.floor(t * (124 / 60)) % 4]} opacity={0.08} style={{ mixBlendMode: "screen" }} />
        )}
      </svg>
      <Dust count={30} seed={`stage-${ins.bg}`} color={ins.bg === "candles" ? "rgba(255,190,120,0.5)" : "rgba(200,215,235,0.35)"} />
      {tension > 0.85 && <AbsoluteFill style={{ background: "radial-gradient(ellipse at center, transparent 40%, rgba(0,0,0,0.55))" }} />}
    </AbsoluteFill>
  );
};

