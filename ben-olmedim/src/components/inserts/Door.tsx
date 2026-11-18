// Daire kapısı (içeriden) ve 13 numaralı kapı — altından ışık, ayak gölgesi, vuruşta sarsıntı, kâğıt.
import React from "react";
import { AbsoluteFill, interpolate, useCurrentFrame, useVideoConfig } from "remotion";
import { noise2D } from "@remotion/noise";
import type { DoorInsert } from "../../series/types";
import { Dust, SERIF, useFlicker } from "../fx";

const DoorDrawing: React.FC = () => (
  // mum boya çocuk çizimi: yanan ev, el ele iki çocuk, aralarında uzun bir adam
  <svg width={420} height={330} viewBox="0 0 420 330" style={{ position: "absolute", left: 120, top: 760, opacity: 0.85, mixBlendMode: "screen" }}>
    <g fill="none" strokeLinecap="round" strokeLinejoin="round" style={{ filter: "url(#crayon)" }}>
      <defs>
        <filter id="crayon">
          <feTurbulence baseFrequency="0.9" numOctaves="2" seed="4" />
          <feDisplacementMap in="SourceGraphic" scale="4" />
        </filter>
      </defs>
      <path d="M 40 170 L 130 90 L 220 170 L 220 290 L 40 290 Z" stroke="#d9d2c0" strokeWidth={6} />
      <rect x={70} y={200} width={40} height={40} stroke="#d9d2c0" strokeWidth={5} />
      <rect x={150} y={230} width={40} height={60} stroke="#d9d2c0" strokeWidth={5} />
      <path d="M 70 200 Q 60 160 85 150 Q 90 175 100 160 Q 110 185 110 200" stroke="#e0662c" strokeWidth={6} />
      <path d="M 130 90 Q 120 50 140 30 Q 150 60 160 45 Q 170 75 150 95" stroke="#e0662c" strokeWidth={6} />
      {/* adam */}
      <circle cx={320} cy={120} r={20} stroke="#d9d2c0" strokeWidth={5} />
      <path d="M 320 140 L 320 230 M 320 165 L 280 205 M 320 165 L 360 205 M 320 230 L 295 290 M 320 230 L 345 290" stroke="#d9d2c0" strokeWidth={5} />
      {/* iki çocuk */}
      {[262, 378].map((x) => (
        <g key={x}>
          <circle cx={x} cy={215} r={14} stroke="#d9d2c0" strokeWidth={5} />
          <path d={`M ${x} 229 L ${x} 265 M ${x} 240 L ${x - 18} 252 M ${x} 240 L ${x + 18} 252 M ${x} 265 L ${x - 12} 290 M ${x} 265 L ${x + 12} 290`} stroke="#d9d2c0" strokeWidth={5} />
        </g>
      ))}
      <path d="M 378 201 L 388 186" stroke="#7aa0d8" strokeWidth={4} />
    </g>
  </svg>
);

export const Door: React.FC<{ ins: DoorInsert; tension: number }> = ({ ins, tension }) => {
  const frame = useCurrentFrame();
  const { fps } = useVideoConfig();
  const sec = frame / fps;
  const corridor = useFlicker("door-corridor", 0.5 + tension * 0.5);

  let shake = 0;
  for (const k of ins.knocks ?? []) {
    const d = sec - k;
    if (d >= 0 && d < 0.35) shake += Math.sin(d * 90) * Math.exp(-d * 14) * 9;
  }
  const paperX = ins.paperAt !== undefined ? interpolate(sec, [ins.paperAt, ins.paperAt + 1.3], [-60, 260], { extrapolateLeft: "clamp", extrapolateRight: "clamp" }) : null;
  const feetPresent = ins.shadowUnder && (ins.paperAt === undefined || sec < ins.paperAt + 1.6);
  const feetShift = noise2D("feet", sec / 2, 0) * 8;
  const is13 = ins.number === "13";
  const doorTop = 220;
  const doorBottom = 1700;

  return (
    <AbsoluteFill style={{ background: "#040404", overflow: "hidden" }}>
      {/* antre duvarları */}
      <AbsoluteFill style={{ background: is13 ? "linear-gradient(90deg,#1a160d,#2a2414 50%,#1a160d)" : "linear-gradient(90deg,#090807,#141210 50%,#090807)" }} />
      {is13 && <AbsoluteFill style={{ background: `radial-gradient(ellipse 60% 40% at 50% 0%, rgba(230,220,170,${0.25 * corridor}), transparent)` }} />}
      {/* kapı */}
      <div style={{ position: "absolute", left: 170, right: 170, top: doorTop, height: doorBottom - doorTop, transform: `translateX(${shake}px)` }}>
        <div
          style={{
            position: "absolute",
            inset: 0,
            background: "linear-gradient(90deg,#2a160b,#3a2112 30%,#2f1b0e 70%,#21110a), repeating-linear-gradient(88deg, rgba(0,0,0,0.18) 0 2px, rgba(0,0,0,0) 2px 9px)",
            backgroundBlendMode: "multiply",
            boxShadow: "inset 0 0 120px rgba(0,0,0,0.85), 0 0 0 26px #1b0f08, 0 0 0 30px #0a0604",
            filter: `brightness(${is13 ? 0.9 : 0.55})`,
          }}
        />
        {/* paneller */}
        {[
          [70, 90, 600, 560],
          [70, 760, 600, 600],
        ].map(([x, y, w, h], i) => (
          <div key={i} style={{ position: "absolute", left: x, top: y, width: w, height: h, boxShadow: "inset 6px 6px 12px rgba(0,0,0,0.6), inset -4px -4px 10px rgba(120,70,30,0.15)", borderRadius: 4 }} />
        ))}
        {/* dürbün */}
        <div style={{ position: "absolute", left: "50%", top: 470, width: 46, height: 46, marginLeft: -23, borderRadius: "50%", background: "radial-gradient(circle,#f0d080 0 6px,#6b5323 8px,#a88a4a 14px,#3e2f12 22px)", boxShadow: `0 0 ${30 * corridor}px rgba(255,210,120,${0.35 * corridor})` }} />
        {/* numara */}
        <div style={{ position: "absolute", left: "50%", top: is13 ? 300 : 360, transform: "translateX(-50%)", fontFamily: SERIF, fontWeight: 700, fontSize: is13 ? 150 : 90, color: "#b8954a", textShadow: "0 3px 6px rgba(0,0,0,0.9)" }}>
          {ins.number ?? "7"}
        </div>
        {/* kol ve zincir */}
        <div style={{ position: "absolute", right: 50, top: 820, width: 130, height: 26, borderRadius: 13, background: "linear-gradient(#c8a45a,#6b5225)", transformOrigin: "100% 50%", transform: `rotate(${ins.knocks?.length && !is13 ? interpolate(sec, [ins.knocks[0], ins.knocks[0] + 1.2], [0, 32], { extrapolateLeft: "clamp", extrapolateRight: "clamp" }) : 0}deg)` }} />
        {!is13 && (
          <svg style={{ position: "absolute", right: 20, top: 600 }} width={120} height={70}>
            <rect x={80} y={20} width={34} height={22} rx={4} fill="#7d6a42" />
            {new Array(6).fill(0).map((_, i) => (
              <ellipse key={i} cx={74 - i * 12} cy={31 + Math.sin(i / 1.6) * 6} rx={7} ry={4} fill="none" stroke="#a48d5c" strokeWidth={3} />
            ))}
          </svg>
        )}
        {ins.drawing && <DoorDrawing />}
        {/* aralık kapı */}
        {ins.ajar && <div style={{ position: "absolute", right: -26, top: 0, bottom: 0, width: 40, background: "linear-gradient(90deg, rgba(240,235,220,0.9), rgba(200,200,190,0.3))", filter: "blur(4px)" }} />}
      </div>
      {/* kapı altı ışık şeridi */}
      <div style={{ position: "absolute", left: 170, right: 170, top: doorBottom, height: 16, background: `rgba(255,205,110,${0.9 * corridor})`, boxShadow: `0 0 60px 20px rgba(255,190,90,${0.25 * corridor})`, filter: "blur(2px)" }} />
      {feetPresent && (
        <>
          <div style={{ position: "absolute", left: 400 + feetShift, top: doorBottom - 4, width: 90, height: 26, background: "#000", filter: "blur(6px)", borderRadius: 12 }} />
          <div style={{ position: "absolute", left: 560 + feetShift, top: doorBottom - 4, width: 90, height: 26, background: "#000", filter: "blur(6px)", borderRadius: 12 }} />
        </>
      )}
      {/* zemin ve ışık yansıması */}
      <div style={{ position: "absolute", left: 0, right: 0, top: doorBottom + 16, bottom: 0, background: `linear-gradient(180deg, rgba(255,190,90,${0.18 * corridor}), #050403 60%)` }} />
      {paperX !== null && (
        <div
          style={{
            position: "absolute",
            left: 420,
            top: doorBottom + 10 + paperX * 0.3,
            width: 240,
            height: 150,
            background: "linear-gradient(160deg,#e8e2d0,#b9b09a)",
            transform: `perspective(600px) rotateX(70deg) translateY(${paperX}px) rotateZ(-6deg)`,
            boxShadow: "0 10px 20px rgba(0,0,0,0.6)",
          }}
        />
      )}
      <Dust count={30} seed="door-dust" color="rgba(255,220,160,0.5)" area={[170, 1500, 740, 300]} />
    </AbsoluteFill>
  );
};
