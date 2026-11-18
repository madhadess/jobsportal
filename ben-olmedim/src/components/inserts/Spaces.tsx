// Mekân katmanları: atmosfer, koridor, dürbün, CCTV, ayna, duvar, asansör.
import React from "react";
import { AbsoluteFill, interpolate, random, useCurrentFrame, useVideoConfig } from "remotion";
import { noise2D } from "@remotion/noise";
import type { AtmosInsert, CctvInsert, CorridorInsert, ElevatorInsert, MirrorInsert, PeepholeInsert, WallInsert } from "../../series/types";
import { Dust, MONO, SERIF, Silhouette, clamp01, useFlicker } from "../fx";

const TONES: Record<AtmosInsert["tone"], [string, string, string]> = {
  cold: ["#0a1219", "#15232f", "rgba(120,170,220,0.35)"],
  warm: ["#140d06", "#2a1b0c", "rgba(255,190,110,0.35)"],
  fire: ["#140502", "#3a1205", "rgba(255,120,40,0.55)"],
  red: ["#120203", "#2e0607", "rgba(220,40,40,0.45)"],
  green: ["#06110c", "#0f2219", "rgba(120,220,170,0.30)"],
};

// ---------------------------------------------------------------- Atmosfer
export const Atmos: React.FC<{ ins: AtmosInsert; tension: number }> = ({ ins, tension }) => {
  const f = useCurrentFrame();
  const [a, b, light] = TONES[ins.tone];
  const flick = useFlicker(`atmos-${ins.tone}`, ins.light === "flicker" ? 0.9 : ins.tone === "fire" ? 0.5 : 0);
  const pulse = ins.light === "pulse" || ins.tone === "fire" ? 0.75 + 0.25 * noise2D("pulse", f / 12, 0) : 1;
  const lv = flick * pulse;
  return (
    <AbsoluteFill style={{ background: `linear-gradient(180deg, ${a}, ${b} 60%, ${a})`, overflow: "hidden" }}>
      {ins.light === "beam" ? (
        <AbsoluteFill style={{ background: `conic-gradient(from 160deg at 70% -5%, transparent 0deg, ${light} 10deg, transparent 22deg)`, opacity: lv, filter: "blur(12px)" }} />
      ) : (
        <AbsoluteFill style={{ background: `radial-gradient(ellipse 60% 45% at 35% 30%, ${light}, transparent 70%)`, opacity: lv }} />
      )}
      {/* oda: tül perdeli pencereden düşen ışık, duvar köşesi, eşyalar */}
      <AbsoluteFill style={{ opacity: 0.9 * lv }}>
        <div style={{ position: "absolute", left: 640, top: 260, width: 330, height: 620, background: `linear-gradient(180deg, ${light}, transparent)`, opacity: 0.55, filter: "blur(2px)" }}>
          <div style={{ position: "absolute", inset: 0, background: "repeating-linear-gradient(90deg, rgba(255,255,255,0.10) 0 3px, transparent 3px 16px), repeating-linear-gradient(0deg, rgba(255,255,255,0.06) 0 2px, transparent 2px 14px)" }} />
          <div style={{ position: "absolute", left: "50%", top: 0, bottom: 0, width: 10, marginLeft: -5, background: "rgba(0,0,0,0.6)" }} />
        </div>
        <div style={{ position: "absolute", left: 560, top: 900, width: 520, height: 900, background: `linear-gradient(200deg, ${light}, transparent 55%)`, opacity: 0.35, transform: "skewX(-18deg)", filter: "blur(14px)" }} />
      </AbsoluteFill>
      <svg width={1080} height={1920} style={{ position: "absolute" }}>
        <path d="M 0 1560 L 1080 1500 L 1080 1920 L 0 1920 Z" fill="rgba(0,0,0,0.55)" />
        <rect x={40} y={1330} width={300} height={260} fill="#0b0b0a" opacity={0.9} style={{ filter: "blur(2px)" }} />
        <path d="M 40 1330 L 120 1290 L 410 1290 L 340 1330 Z" fill="#141413" opacity={0.9} />
        <rect x={700} y={1420} width={380} height={200} fill="#070707" opacity={0.85} style={{ filter: "blur(3px)" }} />
      </svg>
      {ins.figure && ins.figure !== "none" && (
        <svg width={1080} height={1920} style={{ position: "absolute" }}>
          <Silhouette
            x={560 + noise2D("fig", f / 90, 0) * 10}
            y={1780}
            h={ins.figure === "child" ? 760 : 1250}
            child={ins.figure === "child"}
            blur={3}
            fill={ins.tone === "fire" ? "#0b0402" : "#030405"}
            rim={TONES[ins.tone][2]}
            eyes={tension > 0.85 ? 0.35 : 0}
          />
        </svg>
      )}
      <Dust count={70} seed={`atmos-${ins.tone}`} color={ins.tone === "fire" ? "rgba(255,170,90,0.7)" : "rgba(210,225,240,0.5)"} />
      {ins.tone === "fire" && (
        <AbsoluteFill style={{ background: "linear-gradient(0deg, rgba(255,90,20,0.35), transparent 45%)", opacity: lv, mixBlendMode: "screen" }} />
      )}
    </AbsoluteFill>
  );
};

// ---------------------------------------------------------------- Koridor (tek kaçış noktalı perspektif)
export const Corridor: React.FC<{ ins: CorridorInsert; tension: number }> = ({ ins, tension }) => {
  const f = useCurrentFrame();
  const { fps } = useVideoConfig();
  const flick = useFlicker("corridor", ins.flicker ?? 0.3);
  const vx = 540;
  const vy = 900;
  const far = { l: 430, r: 650, t: 760, b: 1060 };
  const wall = ins.burned ? "#1a1410" : "#6f6346";
  const wallDark = ins.burned ? "#0b0806" : "#3e3626";
  const doors = ins.doors;
  const sideDoors = doors.filter((d) => d !== "13");
  const has13 = doors.includes("13");
  const lerp = (a: number, b: number, t: number) => a + (b - a) * t;
  return (
    <AbsoluteFill style={{ background: "#050403", overflow: "hidden" }}>
      <svg width={1080} height={1920} style={{ filter: `brightness(${0.35 + 0.65 * flick})` }}>
        <defs>
          <linearGradient id="lw" x1="0" x2="1">
            <stop offset="0" stopColor={wallDark} />
            <stop offset="1" stopColor={wall} />
          </linearGradient>
          <linearGradient id="rw" x1="1" x2="0">
            <stop offset="0" stopColor={wallDark} />
            <stop offset="1" stopColor={wall} />
          </linearGradient>
          <linearGradient id="fl" x1="0" y1="1" x2="0" y2="0">
            <stop offset="0" stopColor={ins.burned ? "#0e0b09" : "#4a4336"} />
            <stop offset="1" stopColor={ins.burned ? "#1a1612" : "#6d6450"} />
          </linearGradient>
          <pattern id="terrazzo" width="40" height="40" patternUnits="userSpaceOnUse">
            <circle cx="8" cy="10" r="3" fill="rgba(0,0,0,0.25)" />
            <circle cx="28" cy="26" r="2" fill="rgba(255,255,255,0.12)" />
            <circle cx="18" cy="34" r="2.5" fill="rgba(0,0,0,0.2)" />
          </pattern>
        </defs>
        <polygon points={`0,0 ${far.l},${far.t} ${far.l},${far.b} 0,1920`} fill="url(#lw)" />
        <polygon points={`1080,0 ${far.r},${far.t} ${far.r},${far.b} 1080,1920`} fill="url(#rw)" />
        <polygon points={`0,0 1080,0 ${far.r},${far.t} ${far.l},${far.t}`} fill={ins.burned ? "#080605" : "#2d281d"} />
        <polygon points={`0,1920 1080,1920 ${far.r},${far.b} ${far.l},${far.b}`} fill="url(#fl)" />
        <polygon points={`0,1920 1080,1920 ${far.r},${far.b} ${far.l},${far.b}`} fill="url(#terrazzo)" opacity={0.6} />
        {/* dipteki kapı (13) ya da duvar */}
        <rect x={far.l} y={far.t} width={far.r - far.l} height={far.b - far.t} fill={ins.burned ? "#0d0a08" : "#4c4331"} />
        {has13 && (
          <g>
            <rect x={490} y={820} width={100} height={240} fill="#1d0f07" stroke="#0a0503" strokeWidth={4} />
            <text x={540} y={860} textAnchor="middle" fontFamily={SERIF} fontSize={22} fill="#b8954a">
              13
            </text>
            {ins.openDoors && <rect x={495} y={825} width={30} height={232} fill="rgba(255,200,120,0.85)" style={{ filter: "blur(3px)" }} />}
          </g>
        )}
        {/* yan kapılar */}
        {sideDoors.map((d, i) => {
          const left = i % 2 === 0;
          const t0 = 0.12 + Math.floor(i / 2) * 0.32;
          const t1 = t0 + 0.16;
          const x0 = left ? lerp(0, far.l, t0) : lerp(1080, far.r, t0);
          const x1 = left ? lerp(0, far.l, t1) : lerp(1080, far.r, t1);
          const top0 = lerp(0, far.t, t0) + lerp(380, 60, t0);
          const top1 = lerp(0, far.t, t1) + lerp(380, 60, t1);
          const bot0 = lerp(1920, far.b, t0);
          const bot1 = lerp(1920, far.b, t1);
          return (
            <g key={d}>
              <polygon points={`${x0},${top0} ${x1},${top1} ${x1},${bot1} ${x0},${bot0}`} fill={ins.burned ? "#060403" : "#2b170b"} stroke="#120904" strokeWidth={3} />
              {ins.openDoors && <polygon points={`${x0},${top0} ${x1},${top1} ${x1},${bot1} ${x0},${bot0}`} fill="rgba(255,190,110,0.55)" style={{ filter: "blur(6px)" }} />}
              <text x={(x0 + x1) / 2} y={(top0 + top1) / 2 + 70} textAnchor="middle" fontFamily={SERIF} fontSize={lerp(48, 18, t0)} fill="#a88544">
                {d}
              </text>
            </g>
          );
        })}
        {/* floresan */}
        <rect x={420} y={180} width={240} height={22} rx={8} fill={`rgba(235,245,255,${0.95 * flick})`} />
        <ellipse cx={540} cy={191} rx={360} ry={90} fill={`rgba(200,230,255,${0.12 * flick})`} style={{ filter: "blur(30px)" }} />
        {ins.burned && (
          <g opacity={0.8}>
            {new Array(18).fill(0).map((_, i) => (
              <ellipse key={i} cx={random(`soot${i}`) * 1080} cy={random(`sooty${i}`) * 1920} rx={60 + random(`sr${i}`) * 160} ry={40 + random(`sr2${i}`) * 220} fill="#000" opacity={0.5} style={{ filter: "blur(30px)" }} />
            ))}
          </g>
        )}
        {(ins.figures ?? []).map((fg, i) => {
          const walk = fg.walk ? clamp01(f / (fps * 8)) * 0.18 : 0;
          const depth = Math.max(0.05, fg.depth - walk);
          const h = interpolate(depth, [0, 1], [1500, 260]);
          const y = interpolate(depth, [0, 1], [1920, far.b]);
          const x = fg.x * 1080 * (1 - depth) + vx * depth;
          return <Silhouette key={i} x={x + Math.sin(f / 8 + i) * (fg.walk ? 3 : 0)} y={y} h={h} child={fg.type === "child"} blur={2 + depth * 3} fill="#050403" />;
        })}
        <rect x={vx - 1} y={vy - 1} width={2} height={2} fill="transparent" />
      </svg>
      <AbsoluteFill style={{ background: `radial-gradient(ellipse 50% 30% at 50% 10%, rgba(220,240,255,${0.15 * flick}), transparent)` }} />
      <Dust count={50} seed="corr-dust" />
      {tension > 0.8 && <AbsoluteFill style={{ background: "rgba(0,0,0,0.25)" }} />}
    </AbsoluteFill>
  );
};

// ---------------------------------------------------------------- Kapı dürbünü (balıkgözü)
export const Peephole: React.FC<{ ins: PeepholeInsert }> = ({ ins }) => {
  const f = useCurrentFrame();
  const { fps, durationInFrames } = useVideoConfig();
  const flick = useFlicker("peep", 0.5);
  const lean = ins.lean ? interpolate(f, [fps * 0.3, durationInFrames * 0.85], [1, 2.6], { extrapolateLeft: "clamp", extrapolateRight: "clamp" }) : 1;
  const R = 470;
  return (
    <AbsoluteFill style={{ background: "#000" }}>
      <AbsoluteFill style={{ alignItems: "center", justifyContent: "center" }}>
        <div style={{ width: R * 2, height: R * 2, borderRadius: "50%", overflow: "hidden", position: "relative", boxShadow: "0 0 0 40px #020202, 0 0 160px 60px rgba(0,0,0,1) inset" }}>
          <div style={{ position: "absolute", inset: 0, transform: "scale(1.15)", filter: `brightness(${0.5 + 0.5 * flick}) sepia(0.5) saturate(1.3)` }}>
            <svg width={R * 2} height={R * 2} viewBox="0 0 940 940">
              {/* bükülmüş koridor */}
              <rect width={940} height={940} fill="#4d4128" />
              <path d="M 0 0 Q 470 330 940 0 L 940 940 Q 470 610 0 940 Z" fill="#6b5a36" />
              <path d="M 330 300 Q 470 280 610 300 L 610 640 Q 470 660 330 640 Z" fill="#2b2416" />
              <path d="M 0 940 Q 470 620 940 940 Z" fill="#3a3122" />
              <ellipse cx={470} cy={60} rx={180} ry={40} fill={`rgba(255,240,200,${0.9 * flick})`} style={{ filter: "blur(10px)" }} />
              {ins.figure !== "none" && (
                <g transform={`translate(470 ${ins.figure === "child" ? 860 : 990}) scale(${lean}) translate(-470 ${ins.figure === "child" ? -860 : -990})`}>
                  <Silhouette x={470 + noise2D("pf", f / 70, 0) * 6} y={ins.figure === "child" ? 860 : 990} h={ins.figure === "child" ? 520 : 820} child={ins.figure === "child"} fill="#120c07" blur={2} />
                  {ins.figure === "arasKanli" && (
                    <g>
                      {/* koridor ışığında yarı görünen yüz, saç çizgisinden süzülen koyu kan */}
                      <ellipse cx={470} cy={238} rx={46} ry={58} fill="rgba(140,110,85,0.42)" style={{ filter: "blur(6px)" }} />
                      <g style={{ filter: "blur(3.5px)" }} opacity={0.85}>
                        <path d="M 448 188 Q 444 232 452 286" stroke="#3c0605" strokeWidth={10} fill="none" />
                        <path d="M 482 186 Q 490 236 484 270" stroke="#3c0605" strokeWidth={7} fill="none" />
                        <path d="M 440 190 Q 470 175 500 192" stroke="#2a0403" strokeWidth={14} fill="none" />
                      </g>
                      <g style={{ filter: "blur(1.5px)" }}>
                        <ellipse cx={454} cy={236} rx={7} ry={3.5} fill="#0d0605" />
                        <ellipse cx={488} cy={236} rx={7} ry={3.5} fill="#0d0605" />
                      </g>
                    </g>
                  )}
                </g>
              )}
            </svg>
          </div>
          <div style={{ position: "absolute", inset: 0, borderRadius: "50%", background: "radial-gradient(circle, transparent 45%, rgba(0,0,0,0.6) 75%, #000 100%)" }} />
          <div style={{ position: "absolute", inset: 0, borderRadius: "50%", background: "radial-gradient(circle at 35% 30%, rgba(255,255,255,0.12), transparent 30%)" }} />
        </div>
      </AbsoluteFill>
    </AbsoluteFill>
  );
};

// ---------------------------------------------------------------- Güvenlik kamerası
function addSeconds(ts: string, s: number) {
  const m = ts.match(/(\d+)\.(\d+)\.(\d+) (\d+):(\d+):(\d+)/);
  if (!m) return ts;
  const total = +m[4] * 3600 + +m[5] * 60 + +m[6] + Math.floor(s);
  const p = (n: number) => String(n).padStart(2, "0");
  return `${m[1]}.${m[2]}.${m[3]} ${p(Math.floor(total / 3600) % 24)}:${p(Math.floor(total / 60) % 60)}:${p(total % 60)}`;
}

const CctvRoom: React.FC<{ room: CctvInsert["room"] }> = ({ room }) => {
  if (room === "living")
    return (
      <g>
        <rect width={1080} height={1920} fill="#2f3330" />
        <polygon points="0,1100 1080,1000 1080,1920 0,1920" fill="#3c403b" />
        <rect x={60} y={420} width={260} height={700} fill="#1c1f1c" />
        <rect x={140} y={720} width={20} height={20} fill="#7a7e78" />
        <path d="M 620 1180 L 980 1150 L 990 1420 L 610 1450 Z" fill="#232723" />
        <path d="M 620 1180 L 640 1020 L 960 1000 L 980 1150 Z" fill="#2a2e29" />
        <rect x={430} y={540} width={160} height={160} rx={80} fill="#4a4e48" />
        <rect x={700} y={300} width={300} height={420} fill="#454a44" opacity={0.6} />
      </g>
    );
  if (room === "stairs")
    return (
      <g>
        <rect width={1080} height={1920} fill="#2c302d" />
        {new Array(12).fill(0).map((_, i) => (
          <rect key={i} x={120 + i * 30} y={1800 - i * 110} width={900 - i * 50} height={30} fill={i % 2 ? "#4b504b" : "#3d423d"} />
        ))}
        <path d="M 100 1800 L 520 480" stroke="#141614" strokeWidth={14} />
      </g>
    );
  if (room === "elevator")
    return (
      <g>
        <rect width={1080} height={1920} fill="#2a2e2a" />
        <rect x={160} y={300} width={760} height={1500} fill="#3a3f3a" stroke="#1a1d1a" strokeWidth={10} />
        <rect x={200} y={360} width={680} height={600} fill="#4a4f4a" opacity={0.5} />
      </g>
    );
  if (room === "fire")
    return (
      <g>
        <rect width={1080} height={1920} fill="#151210" />
        <rect x={180} y={300} width={720} height={1400} fill="#2a2420" />
        {new Array(15).fill(0).map((_, i) => (
          <rect key={i} x={220 + (i % 3) * 230} y={360 + Math.floor(i / 3) * 260} width={150} height={170} fill={i === 7 ? "#d9d0c0" : "#3a332d"} />
        ))}
      </g>
    );
  return (
    <g>
      <rect width={1080} height={1920} fill="#2f332f" />
      <polygon points="0,1920 1080,1920 680,900 400,900" fill="#454a44" />
      <polygon points="0,0 400,900 400,1100 0,1920" fill="#3a3e39" />
      <polygon points="1080,0 680,900 680,1100 1080,1920" fill="#353934" />
      <rect x={400} y={700} width={280} height={400} fill="#262a26" />
      <polygon points="80,420 250,700 250,1350 80,1700" fill="#1d201d" />
      <polygon points="1000,420 830,700 830,1350 1000,1700" fill="#1d201d" />
      <text x={170} y={900} fontFamily={SERIF} fontSize={46} fill="#8a8f88">7</text>
    </g>
  );
};

export const Cctv: React.FC<{ ins: CctvInsert }> = ({ ins }) => {
  const f = useCurrentFrame();
  const { fps } = useVideoConfig();
  const sec = f / fps;
  const roll = (f * 7) % 1920;
  return (
    <AbsoluteFill style={{ background: "#000" }}>
      <AbsoluteFill style={{ filter: `${ins.color ? "sepia(0.4) saturate(0.6)" : "grayscale(1)"} contrast(1.25) brightness(${0.9 + random(`cb${Math.floor(f / 2)}`) * 0.08}) blur(1.2px)` }}>
        <svg width={1080} height={1920}>
          <CctvRoom room={ins.room} />
          {ins.room === "fire" && <rect x={0} y={0} width={1080} height={1920} fill={`rgba(255,120,30,${0.18 + 0.1 * noise2D("fire", f / 6, 0)})`} />}
          {ins.figures.map((fg, i) => {
            const a = fg.appearAt !== undefined ? clamp01((sec - fg.appearAt) / 0.4) : 1;
            const v = fg.vanishAt !== undefined && sec > fg.vanishAt ? 0 : 1;
            const turned = fg.turnAt !== undefined && sec > fg.turnAt;
            const turnAmt = fg.turnAt !== undefined ? clamp01((sec - fg.turnAt) / 0.8) : 0;
            const h = (fg.type === "child" ? 480 : 780) * (fg.scale ?? 1);
            return (
              <Silhouette
                key={i}
                x={fg.x * 1080}
                y={fg.y * 1920}
                h={h}
                child={fg.type === "child"}
                fill="#0a0b0a"
                blur={2}
                opacity={a * v}
                headTurn={turned ? -turnAmt : 0.6}
                eyes={turned ? turnAmt : 0}
              />
            );
          })}
        </svg>
      </AbsoluteFill>
      {/* tarama çizgileri, sinyal bozulması */}
      <AbsoluteFill style={{ background: "repeating-linear-gradient(0deg, rgba(0,0,0,0.35) 0 2px, rgba(0,0,0,0) 2px 5px)" }} />
      <div style={{ position: "absolute", left: 0, right: 0, top: roll, height: 90, background: "rgba(255,255,255,0.05)" }} />
      <AbsoluteFill style={{ background: "radial-gradient(ellipse at center, transparent 50%, rgba(0,0,0,0.75))" }} />
      <div style={{ position: "absolute", top: 120, left: 60, fontFamily: MONO, fontSize: 38, color: "#e8e8e8", textShadow: "0 0 6px rgba(255,255,255,0.4)" }}>{ins.cam}</div>
      <div style={{ position: "absolute", top: 172, left: 60, fontFamily: MONO, fontSize: 36, color: "#e8e8e8" }}>{addSeconds(ins.timestamp, sec)}</div>
      <div style={{ position: "absolute", top: 124, right: 60, display: "flex", alignItems: "center", gap: 14, fontFamily: MONO, fontSize: 36, color: "#e8e8e8" }}>
        <span style={{ width: 26, height: 26, borderRadius: "50%", background: "#ff2a2a", opacity: Math.floor(sec * 2) % 2 ? 1 : 0.15 }} />
        REC
      </div>
      <div style={{ position: "absolute", bottom: 150, left: 60, fontFamily: MONO, fontSize: 28, color: "rgba(232,232,232,0.7)" }}>DVR-16 · 720×576 · IR AÇIK</div>
    </AbsoluteFill>
  );
};

// ---------------------------------------------------------------- Ayna
export const Mirror: React.FC<{ ins: MirrorInsert }> = ({ ins }) => {
  const f = useCurrentFrame();
  const { fps, durationInFrames } = useVideoConfig();
  const flick = useFlicker("mirror", 0.7);
  const lagF = (ins.lag ?? 0) * fps;
  const me = Math.sin(f / 25) * 10; // gerçek kişi hafifçe sallanır
  const refl = Math.sin(Math.max(0, f - lagF) / 25) * 10;
  const lean = ins.lean ? interpolate(f, [fps * 0.5, durationInFrames], [1, 1.5], { extrapolateLeft: "clamp", extrapolateRight: "clamp" }) : 1;
  return (
    <AbsoluteFill style={{ background: "#0a100c" }}>
      <AbsoluteFill
        style={{
          background: "linear-gradient(#5d7a66,#3f5747)",
          backgroundImage: "linear-gradient(#5d7a66,#3f5747), repeating-linear-gradient(0deg, rgba(0,0,0,0.35) 0 4px, transparent 4px 120px), repeating-linear-gradient(90deg, rgba(0,0,0,0.35) 0 4px, transparent 4px 120px)",
          backgroundBlendMode: "multiply",
          filter: `brightness(${0.35 + 0.55 * flick})`,
        }}
      />
      <div style={{ position: "absolute", left: 340, top: 190, width: 400, height: 18, borderRadius: 9, background: `rgba(230,255,240,${flick})`, boxShadow: `0 0 120px 40px rgba(180,255,210,${0.25 * flick})` }} />
      <div style={{ position: "absolute", left: 160, top: 300, width: 760, height: 1040, borderRadius: "50%", overflow: "hidden", boxShadow: "0 0 0 18px #2a2a24, 0 30px 60px rgba(0,0,0,0.8)" }}>
        <AbsoluteFill style={{ background: "linear-gradient(170deg,#3c5546,#16211a)", filter: `brightness(${0.4 + 0.6 * flick})` }} />
        <svg width={760} height={1040} style={{ position: "absolute" }}>
          <g transform={`translate(${380 + refl} 1180) scale(${lean}) translate(-380 -1180)`}>
            <Silhouette x={380} y={1180} h={1000} fill="#070907" blur={3} eyes={ins.lean ? 0.3 : 0} />
          </g>
        </svg>
        <AbsoluteFill style={{ borderRadius: "50%", background: "radial-gradient(ellipse, transparent 55%, rgba(0,0,0,0.9) 100%)" }} />
        <AbsoluteFill style={{ background: "linear-gradient(120deg, rgba(255,255,255,0.10), transparent 40%)" }} />
      </div>
      {/* gerçek Aras: ön planda, sırtı kameraya */}
      <svg width={1080} height={1920} style={{ position: "absolute" }}>
        <Silhouette x={540 + me} y={2300} h={1500} fill="#020302" blur={6} />
      </svg>
      <div style={{ position: "absolute", left: 300, right: 300, top: 1500, height: 160, borderRadius: "0 0 80px 80px", background: "linear-gradient(#d8dcd4,#9aa197)", filter: `brightness(${0.4 + 0.5 * flick})` }} />
    </AbsoluteFill>
  );
};

// ---------------------------------------------------------------- Duvar
export const Wall: React.FC<{ ins: WallInsert }> = ({ ins }) => {
  const f = useCurrentFrame();
  const { fps } = useVideoConfig();
  const sec = f / fps;
  const crack = ins.crackAt !== undefined ? clamp01((sec - ins.crackAt) / 2.2) : 0;
  const handOut = ins.hand ? clamp01(sec / 3) : 0;
  return (
    <AbsoluteFill style={{ background: "#1d1a12" }}>
      <AbsoluteFill
        style={{
          background: "radial-gradient(ellipse 60% 50% at 40% 40%, #8b7d58, #4a4230 70%, #241f15)",
          filter: "contrast(1.1)",
        }}
      />
      <AbsoluteFill style={{ opacity: 0.35, mixBlendMode: "multiply" }}>
        <svg width="100%" height="100%">
          <filter id="plaster">
            <feTurbulence type="fractalNoise" baseFrequency="0.012 0.03" numOctaves="4" seed="9" />
            <feColorMatrix type="saturate" values="0" />
          </filter>
          <rect width="100%" height="100%" filter="url(#plaster)" />
        </svg>
      </AbsoluteFill>
      <svg width={1080} height={1920} style={{ position: "absolute" }}>
        {[
          "M 540 960 L 500 820 L 520 700 L 470 560 L 490 400",
          "M 540 960 L 640 1040 L 700 1180 L 690 1320",
          "M 540 960 L 430 1010 L 330 1000 L 250 1080",
          "M 540 960 L 600 860 L 720 800 L 800 690",
        ].map((d, i) => (
          <path key={i} d={d} stroke="#1a140b" strokeWidth={5 - i * 0.6} fill="none" strokeDasharray={1200} strokeDashoffset={1200 * (1 - (ins.crackAt !== undefined ? crack : 0.25))} />
        ))}
        {ins.scratches &&
          new Array(9).fill(0).map((_, i) => {
            const x = 380 + random(`sc${i}`) * 320;
            const y = 700 + random(`scy${i}`) * 500;
            return <path key={i} d={`M ${x} ${y} l ${10 + random(`a${i}`) * 20} ${60 + random(`b${i}`) * 90}`} stroke="rgba(30,20,10,0.6)" strokeWidth={3} />;
          })}
        {(ins.hand || (ins.crackAt !== undefined && crack > 0.6)) && (
          <g>
            <ellipse cx={540} cy={980} rx={170 * Math.max(handOut, crack)} ry={230 * Math.max(handOut, crack)} fill="#030201" />
            <ellipse cx={540} cy={980} rx={190 * Math.max(handOut, crack)} ry={250 * Math.max(handOut, crack)} fill="none" stroke="#5a4e36" strokeWidth={18} strokeDasharray="30 18" />
          </g>
        )}
        {ins.hand && (
          <g transform={`translate(540 ${1060 - handOut * 50}) scale(${0.5 + handOut * 0.45}) rotate(-8)`}>
            <defs>
              <radialGradient id="skin" cx="0.45" cy="0.3" r="0.8">
                <stop offset="0" stopColor="#a39a8c" />
                <stop offset="0.6" stopColor="#6e675d" />
                <stop offset="1" stopColor="#2a2622" />
              </radialGradient>
            </defs>
            <g style={{ filter: "blur(2.6px)" }}>
              <path d="M -60 160 L -52 -6 Q -50 -36 -32 -40 L -30 -104 Q -28 -124 -14 -122 Q -2 -120 -2 -102 L 0 -48 L 4 -128 Q 6 -146 20 -144 Q 34 -142 32 -124 L 28 -46 L 38 -112 Q 42 -128 56 -124 Q 68 -120 64 -102 L 54 -36 L 66 -80 Q 72 -94 84 -88 Q 94 -82 88 -66 L 68 24 Q 58 90 40 160 Z" fill="url(#skin)" />
              <path d="M -30 -40 Q -10 -30 10 -36 M 0 -48 Q 14 -40 28 -46" stroke="#3a342d" strokeWidth={3} fill="none" opacity={0.6} />
              {[[-16, -118], [18, -140], [52, -118], [80, -84]].map(([x, y], i) => (
                <ellipse key={i} cx={x} cy={y + 6} rx={6} ry={5} fill="#2c2620" opacity={0.85} />
              ))}
            </g>
            <ellipse cx={0} cy={60} rx={90} ry={140} fill="#000" opacity={0.35} style={{ filter: "blur(30px)" }} />
          </g>
        )}
      </svg>
      <AbsoluteFill style={{ background: "radial-gradient(circle at 50% 50%, rgba(255,250,230,0.18), transparent 45%)" }} />
    </AbsoluteFill>
  );
};

// ---------------------------------------------------------------- Asansör göstergesi
export const Elevator: React.FC<{ ins: ElevatorInsert }> = ({ ins }) => {
  const f = useCurrentFrame();
  const { fps, durationInFrames } = useVideoConfig();
  const flick = useFlicker("elev", 0.6);
  const stopIdx = ins.floors.indexOf(ins.stopOn);
  const idx = Math.min(stopIdx, Math.floor(interpolate(f, [fps * 0.4, durationInFrames * 0.75], [0, stopIdx + 0.99], { extrapolateLeft: "clamp", extrapolateRight: "clamp" })));
  const arrived = idx === stopIdx;
  return (
    <AbsoluteFill style={{ background: "#120e09" }}>
      <AbsoluteFill style={{ background: "repeating-linear-gradient(90deg,#3a2a18 0 120px,#2f2214 120px 124px)", filter: `brightness(${0.4 + 0.5 * flick})` }} />
      <div style={{ position: "absolute", left: 140, right: 140, top: 340, height: 300, background: "#0a0806", borderRadius: 20, boxShadow: "inset 0 0 40px #000, 0 0 0 14px #6b5530", display: "flex", alignItems: "center", justifyContent: "space-around", padding: "0 30px" }}>
        {ins.floors.map((fl, i) => (
          <span key={fl} style={{ fontFamily: MONO, fontSize: 84, color: i === idx ? (arrived ? "#ff4636" : "#ffb347") : "#3a2a18", textShadow: i === idx ? "0 0 30px currentColor" : "none" }}>
            {fl}
          </span>
        ))}
      </div>
      <div style={{ position: "absolute", left: 380, top: 760, width: 320, display: "grid", gridTemplateColumns: "1fr 1fr", gap: 40 }}>
        {[...ins.floors].reverse().map((fl) => (
          <div key={fl} style={{ width: 130, height: 130, borderRadius: "50%", background: "radial-gradient(circle at 40% 35%, #d8c28a, #6b5530)", display: "flex", alignItems: "center", justifyContent: "center", fontFamily: SERIF, fontSize: 52, color: "#2a1d0c", boxShadow: fl === ins.stopOn && arrived ? "0 0 40px 10px rgba(255,80,50,0.5)" : "0 6px 10px rgba(0,0,0,0.6)" }}>
            {fl}
          </div>
        ))}
      </div>
    </AbsoluteFill>
  );
};
