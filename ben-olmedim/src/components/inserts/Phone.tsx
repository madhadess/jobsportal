// Gerçekçi telefon ekranı — karanlıkta yanan ekran, bildirim, sesli mesaj, arama, arama sonucu.
import React from "react";
import { AbsoluteFill, interpolate, random, useCurrentFrame, useVideoConfig } from "remotion";
import { noise2D } from "@remotion/noise";
import type { PhoneInsert } from "../../series/types";
import { Dust, MONO, SANS, SERIF } from "../fx";

const W = 760;
const H = 1560;

const StatusBar: React.FC<{ time: string }> = ({ time }) => (
  <div style={{ display: "flex", justifyContent: "space-between", padding: "26px 52px 0", fontSize: 30, fontWeight: 600, color: "#f2f2f2" }}>
    <span>{time}</span>
    <span style={{ display: "flex", gap: 12, alignItems: "center" }}>
      <span style={{ display: "flex", gap: 3, alignItems: "flex-end" }}>
        {[10, 15, 20, 25].map((h, i) => (
          <span key={i} style={{ width: 6, height: h, background: i < 2 ? "#f2f2f2" : "#666", borderRadius: 2 }} />
        ))}
      </span>
      <span style={{ width: 46, height: 22, border: "2px solid #bbb", borderRadius: 6, padding: 2, display: "inline-flex" }}>
        <span style={{ width: "18%", background: "#e5484d", borderRadius: 2 }} />
      </span>
    </span>
  </div>
);

const Waveform: React.FC<{ progress: number; seed: string; bars?: number }> = ({ progress, seed, bars = 38 }) => (
  <div style={{ display: "flex", alignItems: "center", gap: 5, height: 70 }}>
    {new Array(bars).fill(0).map((_, i) => {
      const h = 10 + Math.pow(random(`${seed}${i}`), 1.6) * 58 * (0.5 + 0.5 * Math.sin(i / 3));
      return <span key={i} style={{ width: 6, height: Math.max(8, h), borderRadius: 3, background: i / bars < progress ? "#e8eef5" : "rgba(232,238,245,0.32)" }} />;
    })}
  </div>
);

const Avatar: React.FC<{ size: number; label: string }> = ({ size, label }) => (
  <div
    style={{
      width: size,
      height: size,
      borderRadius: "50%",
      background: "linear-gradient(160deg,#5b6470,#2b3038)",
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
      fontSize: size * 0.4,
      color: "#e9edf2",
      fontWeight: 500,
    }}
  >
    {label.slice(0, 1).toLocaleUpperCase("tr")}
  </div>
);

function Screen({ ins, frame, fps, dur }: { ins: PhoneInsert; frame: number; fps: number; dur: number }) {
  const prog = ins.progress ? interpolate(frame, [fps * 0.4, Math.max(fps * 0.5, dur - fps * 0.4)], ins.progress, { extrapolateLeft: "clamp", extrapolateRight: "clamp" }) : 0;
  switch (ins.screen) {
    case "notification":
    case "clock": {
      const appear = interpolate(frame, [fps * 0.15, fps * 0.55], [0, 1], { extrapolateLeft: "clamp", extrapolateRight: "clamp" });
      return (
        <div style={{ height: "100%", background: "radial-gradient(ellipse at 50% 30%, #1b2a3c 0%, #0a1018 60%, #04070b 100%)" }}>
          <StatusBar time="" />
          <div style={{ textAlign: "center", marginTop: 90, color: "#eef3f8" }}>
            <div style={{ fontSize: 34, fontWeight: 500, opacity: 0.85 }}>{ins.date}</div>
            <div style={{ fontSize: 210, fontWeight: 300, letterSpacing: -6, lineHeight: 1.05 }}>{ins.time}</div>
          </div>
          {ins.screen === "notification" && (
            <div
              style={{
                margin: "120px 34px 0",
                padding: "30px 32px",
                borderRadius: 40,
                background: "rgba(60,70,84,0.62)",
                backdropFilter: "blur(20px)",
                opacity: appear,
                transform: `translateY(${(1 - appear) * -40}px) scale(${0.96 + appear * 0.04})`,
                color: "#f2f5f8",
              }}
            >
              <div style={{ display: "flex", alignItems: "center", gap: 18, fontSize: 26, opacity: 0.75 }}>
                <span style={{ width: 44, height: 44, borderRadius: 12, background: "linear-gradient(#5fd068,#2f9e44)", display: "inline-flex", alignItems: "center", justifyContent: "center" }}>
                  <span style={{ width: 22, height: 17, borderRadius: 10, background: "#fff" }} />
                </span>
                <span style={{ flex: 1 }}>MESAJLAR</span>
                <span>şimdi</span>
              </div>
              <div style={{ fontSize: 36, fontWeight: 600, marginTop: 18 }}>{ins.title}</div>
              <div style={{ fontSize: 28, opacity: 0.7, marginTop: 4, fontFamily: MONO }}>{ins.subtitle}</div>
              <div style={{ fontSize: 32, marginTop: 12, display: "flex", alignItems: "center", gap: 12 }}>
                <span style={{ width: 0, height: 0, borderLeft: "18px solid #f2f5f8", borderTop: "11px solid transparent", borderBottom: "11px solid transparent" }} />
                {ins.body}
              </div>
            </div>
          )}
        </div>
      );
    }
    case "voice":
    case "message":
      return (
        <div style={{ height: "100%", background: "#0b0d10", color: "#eef2f6" }}>
          <StatusBar time={ins.time} />
          <div style={{ display: "flex", alignItems: "center", gap: 22, padding: "30px 36px 26px", borderBottom: "1px solid #1d2128" }}>
            <span style={{ fontSize: 44, color: "#4c9eff" }}>‹</span>
            <Avatar size={78} label={ins.title ?? "?"} />
            <div>
              <div style={{ fontSize: 36, fontWeight: 600 }}>{ins.title}</div>
              <div style={{ fontSize: 24, opacity: 0.55, fontFamily: MONO }}>+90 5•• ••• 03 17</div>
            </div>
          </div>
          <div style={{ textAlign: "center", fontSize: 24, opacity: 0.45, marginTop: 70 }}>{ins.date}</div>
          <div style={{ padding: "40px 36px" }}>
            {ins.screen === "voice" ? (
              <div style={{ display: "inline-flex", alignItems: "center", gap: 22, padding: "26px 30px", borderRadius: 38, background: "#262b33", maxWidth: 620 }}>
                <span style={{ width: 70, height: 70, borderRadius: "50%", background: "#e8eef5", display: "inline-flex", alignItems: "center", justifyContent: "center" }}>
                  {prog > 0 && prog < 1 ? (
                    <span style={{ display: "flex", gap: 8 }}>
                      <span style={{ width: 9, height: 28, background: "#262b33" }} />
                      <span style={{ width: 9, height: 28, background: "#262b33" }} />
                    </span>
                  ) : (
                    <span style={{ width: 0, height: 0, marginLeft: 8, borderLeft: "26px solid #262b33", borderTop: "16px solid transparent", borderBottom: "16px solid transparent" }} />
                  )}
                </span>
                <Waveform progress={prog} seed="vm" />
                <span style={{ fontFamily: MONO, fontSize: 26, opacity: 0.8 }}>{ins.body}</span>
              </div>
            ) : (
              <div style={{ display: "inline-block", padding: "26px 32px", borderRadius: 34, background: "#262b33", fontSize: 34, lineHeight: 1.35, maxWidth: 620 }}>{ins.body}</div>
            )}
            <div style={{ fontSize: 24, color: "#ff6b6b", marginTop: 16, fontFamily: MONO, letterSpacing: 0.5 }}>{ins.subtitle}</div>
          </div>
        </div>
      );
    case "call": {
      const pulse = 0.5 + 0.5 * Math.sin((frame / fps) * Math.PI * 1.6);
      return (
        <div style={{ height: "100%", background: "linear-gradient(180deg,#1d2530,#0a0d12 70%)", color: "#f1f4f7", textAlign: "center" }}>
          <StatusBar time={ins.time} />
          <div style={{ marginTop: 200, display: "flex", justifyContent: "center" }}>
            <div style={{ position: "relative" }}>
              <div style={{ position: "absolute", inset: -30 * pulse, borderRadius: "50%", border: "2px solid rgba(255,255,255,0.15)" }} />
              <div style={{ width: 230, height: 230, borderRadius: "50%", overflow: "hidden", background: "linear-gradient(160deg,#6c6f73,#33373c)", position: "relative" }}>
                <svg width={230} height={230}>
                  <circle cx={115} cy={92} r={46} fill="#9a9894" />
                  <rect x={88} y={84} width={54} height={14} rx={7} fill="none" stroke="#2a2a2a" strokeWidth={3} />
                  <path d="M 40 230 Q 115 120 190 230 Z" fill="#6b5442" />
                  <path d="M 85 112 Q 115 150 145 112 L 145 125 Q 115 165 85 125 Z" fill="#bdbab4" opacity={0.8} />
                </svg>
              </div>
            </div>
          </div>
          <div style={{ fontSize: 76, fontWeight: 500, marginTop: 70 }}>{ins.title}</div>
          <div style={{ fontSize: 34, opacity: 0.6, marginTop: 10 }}>{ins.subtitle}</div>
          <div style={{ position: "absolute", bottom: 170, left: 0, right: 0, display: "flex", justifyContent: "space-around" }}>
            {["#e5484d", "#30a46c"].map((c, i) => (
              <div key={c} style={{ width: 150, height: 150, borderRadius: "50%", background: c, display: "flex", alignItems: "center", justifyContent: "center", fontSize: 30 }}>
                <svg width={70} height={70} viewBox="0 0 24 24" style={{ transform: i === 0 ? "rotate(135deg)" : undefined }}>
                  <path fill="#fff" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                </svg>
              </div>
            ))}
          </div>
        </div>
      );
    }
    case "search":
    case "gallery":
      return (
        <div style={{ height: "100%", background: "#111316", color: "#e8eaed" }}>
          <StatusBar time={ins.time} />
          <div style={{ margin: "26px 30px", padding: "22px 30px", borderRadius: 40, background: "#25282d", fontSize: 30, display: "flex", gap: 18, alignItems: "center" }}>
            <span style={{ width: 26, height: 26, borderRadius: "50%", border: "4px solid #9aa0a6" }} />
            {ins.title}
          </div>
          <div style={{ padding: "10px 40px" }}>
            <div style={{ fontSize: 24, opacity: 0.5 }}>vefat-ilanlari.example › kurtulus</div>
            <div style={{ fontSize: 38, color: "#8ab4f8", margin: "10px 0" }}>{ins.title?.split(" ").slice(0, 2).join(" ")} — Vefat İlanı</div>
            <div style={{ fontSize: 28, opacity: 0.75, lineHeight: 1.4 }}>{ins.subtitle}</div>
            <div style={{ marginTop: 40, height: 620, borderRadius: 24, overflow: "hidden", background: "linear-gradient(180deg,#5d6a5b,#2f3a2f)", position: "relative" }}>
              <svg width="100%" height="100%" viewBox="0 0 680 620">
                <rect width={680} height={620} fill="url(#sky)" />
                <defs>
                  <linearGradient id="sky" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stopColor="#8d9590" />
                    <stop offset="1" stopColor="#3d4a3b" />
                  </linearGradient>
                </defs>
                <path d="M 200 620 L 200 210 Q 200 130 340 130 Q 480 130 480 210 L 480 620 Z" fill="#b9b6ad" />
                <path d="M 200 620 L 200 210 Q 200 130 340 130 Q 480 130 480 210 L 480 620 Z" fill="none" stroke="#7c786f" strokeWidth={6} />
                <text x={340} y={300} textAnchor="middle" fontFamily={SERIF} fontSize={34} fill="#3d3a35" fontWeight={700}>
                  NERMİN AKGÜL
                </text>
                <text x={340} y={350} textAnchor="middle" fontFamily={SERIF} fontSize={30} fill="#3d3a35">
                  1949 – 2023
                </text>
                <text x={340} y={420} textAnchor="middle" fontFamily={SERIF} fontSize={24} fill="#4a463f">
                  RUHUNA FATİHA
                </text>
                <rect y={560} width={680} height={60} fill="#2f3a2a" />
              </svg>
            </div>
          </div>
        </div>
      );
  }
}

export const Phone: React.FC<{ ins: PhoneInsert }> = ({ ins }) => {
  const frame = useCurrentFrame();
  const { fps, durationInFrames } = useVideoConfig();
  const wake = interpolate(frame, [0, 6], [0, 1], { extrapolateRight: "clamp" });
  const buzzing = ins.buzz && ((frame > 2 && frame < 18) || (frame > 36 && frame < 52));
  const bx = buzzing ? noise2D("bx", frame * 2.3, 0) * 7 : 0;
  const by = buzzing ? noise2D("by", frame * 2.3, 1) * 4 : 0;
  const tilt = 9 + noise2D("tilt", frame / 120, 0) * 0.6;

  return (
    <AbsoluteFill style={{ background: "#020304", fontFamily: SANS, overflow: "hidden" }}>
      {/* masa yüzeyi ve ekran ışığının yansıması */}
      <AbsoluteFill style={{ background: "radial-gradient(ellipse 70% 45% at 50% 52%, rgba(70,110,160,0.38), rgba(10,20,30,0.15) 55%, rgba(0,0,0,0) 75%)", opacity: wake }} />
      <AbsoluteFill style={{ background: "repeating-linear-gradient(92deg, rgba(60,40,25,0.10) 0 3px, rgba(0,0,0,0) 3px 11px)", opacity: 0.6 * wake }} />
      <Dust count={45} seed="phone-dust" color="rgba(160,200,255,0.5)" area={[140, 120, 800, 1600]} />
      <AbsoluteFill style={{ perspective: 2200, alignItems: "center", justifyContent: "center", transform: `scale(${ins.zoom ?? 1})`, transformOrigin: "50% 28%" }}>
        <div
          style={{
            width: W,
            height: H,
            borderRadius: 96,
            background: "#0d0f12",
            padding: 18,
            transform: `translate(${bx}px, ${by}px) rotateX(${tilt}deg) rotateZ(-2deg)`,
            boxShadow: `0 0 ${220 * wake}px ${40 * wake}px rgba(90,140,210,0.28), 0 60px 120px rgba(0,0,0,0.9), inset 0 0 0 3px #2a2e33`,
          }}
        >
          <div style={{ width: "100%", height: "100%", borderRadius: 80, overflow: "hidden", position: "relative", opacity: wake, filter: `brightness(${0.85 + 0.15 * wake})` }}>
            <Screen ins={ins} frame={frame} fps={fps} dur={durationInFrames} />
            {/* çentik */}
            <div style={{ position: "absolute", top: 18, left: "50%", width: 200, height: 54, marginLeft: -100, borderRadius: 30, background: "#000" }} />
            {/* cam yansıması ve parmak izi lekeleri */}
            <div style={{ position: "absolute", inset: 0, background: "linear-gradient(125deg, rgba(255,255,255,0.07) 0%, rgba(255,255,255,0) 35%)" }} />
            <div style={{ position: "absolute", inset: 0, background: "radial-gradient(circle at 70% 75%, rgba(255,255,255,0.05) 0 60px, transparent 120px), radial-gradient(circle at 30% 60%, rgba(255,255,255,0.04) 0 40px, transparent 90px)" }} />
          </div>
        </div>
      </AbsoluteFill>
    </AbsoluteFill>
  );
};
