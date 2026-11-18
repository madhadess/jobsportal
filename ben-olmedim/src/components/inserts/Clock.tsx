// Salon duvarındaki eski yuvarlak saat — sararmış duvar kâğıdı, ay ışığı, tik tak.
import React from "react";
import { AbsoluteFill, interpolate, useCurrentFrame, useVideoConfig } from "remotion";
import type { ClockInsert } from "../../series/types";
import { Dust, SERIF, useFlicker } from "../fx";

const parse = (t: string) => {
  const [h, m] = t.split(":").map(Number);
  return { h, m };
};

export const Clock: React.FC<{ ins: ClockInsert; tension: number }> = ({ ins, tension }) => {
  const frame = useCurrentFrame();
  const { fps } = useVideoConfig();
  const sec = frame / fps;
  const switched = ins.to && sec >= (ins.switchAt ?? 1);
  const { h, m } = parse(switched ? ins.to! : ins.from);
  // saniye ibresi: 03:16'da 52. saniyeden başlar; geçişte 0'a oturur
  const startSecond = ins.to ? 60 - (ins.switchAt ?? 1) : 47;
  const s = ins.stopped ? 0 : Math.floor(startSecond + sec) % 60;
  // ibre "tık" atlaması: her saniyede küçük bir yay
  const frac = (startSecond + sec) % 1;
  const kick = ins.stopped ? 0 : frac < 0.08 ? Math.sin((frac / 0.08) * Math.PI) * 1.4 : 0;
  const secAngle = s * 6 + kick;
  // yelkovan geçişte "zıplar"
  const jump = switched ? interpolate(sec - (ins.switchAt ?? 1), [0, 0.12, 0.25], [-6, 1.5, 0], { extrapolateRight: "clamp" }) : 0;
  const minAngle = m * 6 + (ins.stopped ? 0 : s * 0.1) + jump;
  const hourAngle = (h % 12) * 30 + m * 0.5;
  const light = useFlicker("clock-light", tension > 0.7 ? 0.4 : 0);
  const R = 300;

  return (
    <AbsoluteFill style={{ background: "#0b0a08", overflow: "hidden" }}>
      {/* duvar kâğıdı */}
      <AbsoluteFill
        style={{
          background:
            "repeating-linear-gradient(90deg, rgba(150,130,90,0.10) 0 2px, rgba(0,0,0,0) 2px 70px), radial-gradient(circle at 35px 35px, rgba(120,100,60,0.22) 6px, rgba(0,0,0,0) 7px) 0 0/70px 70px, linear-gradient(180deg,#3b3424,#2a2418)",
          filter: `brightness(${0.75 * light})`,
        }}
      />
      {/* lekeler */}
      <AbsoluteFill style={{ background: "radial-gradient(ellipse 30% 20% at 20% 80%, rgba(60,45,20,0.6), transparent), radial-gradient(ellipse 25% 35% at 85% 20%, rgba(70,55,25,0.5), transparent)" }} />
      {/* soğuk sokak ışığı (perdeden) */}
      <AbsoluteFill style={{ background: "linear-gradient(115deg, rgba(110,150,200,0.0) 30%, rgba(110,150,200,0.22) 45%, rgba(110,150,200,0.0) 62%)", mixBlendMode: "screen", opacity: light }} />
      <AbsoluteFill style={{ alignItems: "center", justifyContent: "center" }}>
        <svg width={760} height={760} viewBox="-380 -380 760 760" style={{ filter: `drop-shadow(30px 40px 30px rgba(0,0,0,0.75)) brightness(${0.9 * light})` }}>
          <defs>
            <radialGradient id="face" cx="0.4" cy="0.35">
              <stop offset="0" stopColor="#efe6cf" />
              <stop offset="0.7" stopColor="#d9cba7" />
              <stop offset="1" stopColor="#a8987a" />
            </radialGradient>
            <linearGradient id="rim" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0" stopColor="#5a3d22" />
              <stop offset="0.5" stopColor="#2e1d10" />
              <stop offset="1" stopColor="#1a0f07" />
            </linearGradient>
          </defs>
          <circle r={R + 52} fill="url(#rim)" />
          <circle r={R + 20} fill="#1c130b" />
          <circle r={R + 12} fill="url(#face)" />
          {new Array(60).fill(0).map((_, i) => {
            const a = (i * 6 * Math.PI) / 180;
            const long = i % 5 === 0;
            return (
              <line key={i} x1={Math.sin(a) * (R - (long ? 34 : 18))} y1={-Math.cos(a) * (R - (long ? 34 : 18))} x2={Math.sin(a) * (R - 4)} y2={-Math.cos(a) * (R - 4)} stroke="#2b241a" strokeWidth={long ? 7 : 2.5} />
            );
          })}
          {new Array(12).fill(0).map((_, i) => {
            const n = i === 0 ? 12 : i;
            const a = (i * 30 * Math.PI) / 180;
            return (
              <text key={i} x={Math.sin(a) * (R - 82)} y={-Math.cos(a) * (R - 82) + 22} textAnchor="middle" fontFamily={SERIF} fontSize={62} fill="#2b241a">
                {n}
              </text>
            );
          })}
          <text y={110} textAnchor="middle" fontFamily={SERIF} fontSize={26} letterSpacing={6} fill="#5c4f3a">
            YALÇIN SAAT
          </text>
          {/* ibreler */}
          <g transform={`rotate(${hourAngle})`}>
            <path d="M -11 30 L -7 -170 L 0 -190 L 7 -170 L 11 30 Z" fill="#17120c" />
          </g>
          <g transform={`rotate(${minAngle})`}>
            <path d="M -8 34 L -5 -255 L 0 -275 L 5 -255 L 8 34 Z" fill="#17120c" />
          </g>
          <g transform={`rotate(${secAngle})`}>
            <line y1={50} y2={-270} stroke="#8a1c14" strokeWidth={3.5} />
            <circle r={13} fill="#8a1c14" />
          </g>
          <circle r={6} fill="#c9b27a" />
          {/* cam yansıması */}
          <ellipse cx={-90} cy={-140} rx={210} ry={120} fill="rgba(255,255,255,0.10)" transform="rotate(-30)" />
          <circle r={R + 12} fill="none" stroke="rgba(255,255,255,0.08)" strokeWidth={6} />
        </svg>
      </AbsoluteFill>
      <Dust count={40} seed="clock-dust" />
    </AbsoluteFill>
  );
};
