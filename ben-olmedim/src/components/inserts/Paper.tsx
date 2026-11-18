// Kâğıt işleri: ölüm belgesi, gazete, kimlik, defter, kat planı, fotoğraflar, monitör duvarı.
import React from "react";
import { AbsoluteFill, interpolate, random, useCurrentFrame, useVideoConfig } from "remotion";
import { noise2D } from "@remotion/noise";
import type { DocumentInsert, MonitorsInsert, PhotoInsert } from "../../series/types";
import { MONO, SANS, SERIF, SERIF_I, Silhouette, clamp01 } from "../fx";

/** Telefon feneri: belgenin üzerinde gezinen sıcak ışık halkası */
const Flashlight: React.FC = () => {
  const f = useCurrentFrame();
  const x = 50 + noise2D("flx", f / 90, 0) * 12;
  const y = 46 + noise2D("fly", f / 90, 1) * 10;
  return <AbsoluteFill style={{ background: `radial-gradient(circle at ${x}% ${y}%, rgba(255,250,235,0) 0%, rgba(0,0,0,0.25) 32%, rgba(0,0,0,0.92) 62%)` }} />;
};

const Burn: React.FC = () => (
  <AbsoluteFill style={{ background: "radial-gradient(ellipse 40% 30% at 100% 0%, #000 30%, #3a1c08 45%, rgba(120,60,20,0.5) 55%, transparent 65%), radial-gradient(ellipse 30% 25% at 0% 100%, #000 30%, #3a1c08 48%, transparent 62%)" }} />
);

export const Document: React.FC<{ ins: DocumentInsert }> = ({ ins }) => {
  const f = useCurrentFrame();
  const { fps } = useVideoConfig();
  const sec = f / fps;
  const hl = clamp01((sec - 1.2) / 0.8);

  if (ins.variant === "blueprint") {
    return (
      <AbsoluteFill style={{ background: "#0a1a33" }}>
        <AbsoluteFill style={{ background: "#1c3d6e", backgroundImage: "linear-gradient(rgba(255,255,255,0.08) 2px, transparent 2px), linear-gradient(90deg, rgba(255,255,255,0.08) 2px, transparent 2px)", backgroundSize: "60px 60px", transform: "rotate(-3deg) scale(1.1)" }}>
          <div style={{ position: "absolute", top: 260, left: 120, right: 120, fontFamily: MONO, color: "#dce8ff", fontSize: 34 }}>{ins.heading}</div>
          <div style={{ position: "absolute", top: 400, left: 140, width: 800, height: 900, border: "6px solid #dce8ff", display: "grid", gridTemplateColumns: "1fr 1fr", gridTemplateRows: "1fr 0.35fr 1fr" }}>
            {ins.lines.slice(0, 4).map((l, i) => (
              <div key={l} style={{ border: "3px solid rgba(220,232,255,0.8)", display: "flex", alignItems: "center", justifyContent: "center", fontFamily: MONO, color: "#dce8ff", fontSize: 40, gridRow: i < 2 ? 1 : 3 }}>
                {l}
              </div>
            ))}
            <div style={{ gridColumn: "1 / span 2", gridRow: 2, fontFamily: MONO, color: "rgba(220,232,255,0.6)", fontSize: 28, display: "flex", alignItems: "center", justifyContent: "center" }}>KORİDOR</div>
          </div>
          <div style={{ position: "absolute", top: 1380, left: 140, fontFamily: MONO, color: "#fff", fontSize: 40, borderBottom: `5px solid rgba(255,80,60,${hl})` }}>{ins.lines[4]}</div>
        </AbsoluteFill>
        <Flashlight />
      </AbsoluteFill>
    );
  }

  if (ins.variant === "registry") {
    return (
      <AbsoluteFill style={{ background: "#0b0a09", alignItems: "center", justifyContent: "center" }}>
        <div style={{ width: 900, height: 570, borderRadius: 36, background: "linear-gradient(135deg,#d7e3ea,#a9bcc7 60%,#c8d6de)", transform: "rotate(-7deg)", boxShadow: "0 40px 80px rgba(0,0,0,0.8)", position: "relative", overflow: "hidden", fontFamily: SANS }}>
          <div style={{ background: "#c8102e", color: "#fff", padding: "18px 34px", fontSize: 30, fontWeight: 600, letterSpacing: 2 }}>{ins.heading}</div>
          <div style={{ position: "absolute", left: 40, top: 110, width: 250, height: 320, background: "linear-gradient(#8f9aa1,#5e676d)", borderRadius: 10, overflow: "hidden" }}>
            <svg width={250} height={320}>
              <Silhouette x={125} y={360} h={330} fill="#2a2f33" blur={1} />
            </svg>
          </div>
          <div style={{ position: "absolute", left: 330, top: 120, right: 30, display: "flex", flexDirection: "column", gap: 18 }}>
            {ins.lines.map((l, i) => (
              <div key={l} style={{ fontSize: 34, color: "#1d2a33", fontWeight: i === ins.highlightLine ? 600 : 400, background: i === ins.highlightLine ? `rgba(255,220,80,${0.5 * hl})` : "none" }}>
                {l}
              </div>
            ))}
          </div>
        </div>
        <Flashlight />
      </AbsoluteFill>
    );
  }

  if (ins.variant === "notebook") {
    return (
      <AbsoluteFill style={{ background: "#070504", alignItems: "center", justifyContent: "center" }}>
        <div style={{ width: 900, height: 1300, background: "#e6dcc4", transform: "rotate(2deg)", boxShadow: "0 0 0 30px #6e1414, 0 50px 90px rgba(0,0,0,0.9)", position: "relative", overflow: "hidden", backgroundImage: "repeating-linear-gradient(0deg, transparent 0 68px, rgba(60,90,140,0.35) 68px 70px)" }}>
          <div style={{ position: "absolute", left: 110, top: 0, bottom: 0, width: 3, background: "rgba(200,40,40,0.5)" }} />
          {ins.heading && <div style={{ position: "absolute", top: 90, left: 150, right: 60, fontFamily: SERIF, fontWeight: 700, fontSize: 40, color: "#2a1a10" }}>{ins.heading}</div>}
          <div style={{ position: "absolute", top: ins.heading ? 210 : ins.lines.length === 1 ? 560 : 150, left: 150, right: 50 }}>
            {ins.lines.map((l, i) => {
              const appear = clamp01((sec - 0.3 - i * 0.55) / 0.5);
              return (
                <div key={i} style={{ fontFamily: SERIF_I, fontSize: ins.lines.length === 1 ? 130 : 46, lineHeight: ins.lines.length === 1 ? 1.2 : "70px", color: i === ins.highlightLine ? "#7a0d0d" : "#1f1c2c", opacity: appear, transform: `rotate(${(random(`nb${i}`) - 0.5) * 1.5}deg)` }}>
                  {l}
                </div>
              );
            })}
          </div>
          {ins.burned && <Burn />}
        </div>
        <Flashlight />
      </AbsoluteFill>
    );
  }

  if (ins.variant === "newspaper") {
    return (
      <AbsoluteFill style={{ background: "#060504", alignItems: "center", justifyContent: "center" }}>
        <div style={{ width: 960, height: 1500, background: "linear-gradient(170deg,#cfc6ad,#a39a80)", transform: "rotate(-4deg)", position: "relative", overflow: "hidden", padding: 50, boxShadow: "0 50px 90px rgba(0,0,0,0.9)" }}>
          <div style={{ fontFamily: SERIF, fontWeight: 700, fontSize: 92, textAlign: "center", borderBottom: "6px double #222", color: "#1a1712" }}>KURTULUŞ POSTASI</div>
          <div style={{ fontFamily: MONO, fontSize: 24, textAlign: "center", margin: "8px 0 24px", color: "#2b2720" }}>{ins.heading}</div>
          <div style={{ fontFamily: SERIF, fontWeight: 700, fontSize: 64, lineHeight: 1.05, color: "#141210" }}>{ins.lines[0]}</div>
          <div style={{ display: "flex", gap: 30, marginTop: 30 }}>
            <div style={{ flex: 1, height: 520, background: "linear-gradient(#3a3530,#151310)", position: "relative", overflow: "hidden", filter: "grayscale(1) contrast(1.2)" }}>
              <svg width="100%" height="100%" viewBox="0 0 420 520">
                <rect x={60} y={40} width={300} height={480} fill="#28231f" />
                <rect x={150} y={180} width={90} height={80} fill="#e8e0d0" />
                <ellipse cx={195} cy={170} rx={120} ry={60} fill="#cfc6b0" opacity={0.4} style={{ filter: "blur(20px)" }} />
                {new Array(9).fill(0).map((_, i) => (
                  <Silhouette key={i} x={20 + i * 48} y={540} h={150 + (i % 3) * 14} fill={i === 6 ? "#5a544c" : "#0c0b0a"} blur={1.5} />
                ))}
              </svg>
            </div>
            <div style={{ flex: 1, fontFamily: SERIF, fontSize: 30, lineHeight: 1.35, color: "#1d1a15" }}>
              {ins.lines.slice(1).map((l, i) => (
                <p key={i} style={{ margin: "0 0 18px", background: i + 1 === ins.highlightLine ? `rgba(200,30,30,${0.35 * hl})` : "none" }}>
                  {l}
                </p>
              ))}
            </div>
          </div>
          {ins.burned && <Burn />}
        </div>
        <Flashlight />
      </AbsoluteFill>
    );
  }

  // ölüm belgesi
  return (
    <AbsoluteFill style={{ background: "#050403", alignItems: "center", justifyContent: "center" }}>
      <div style={{ width: 900, height: 1260, background: "linear-gradient(175deg,#ece6d6,#c9c0a8)", transform: "rotate(3deg)", padding: "70px 70px", position: "relative", boxShadow: "0 50px 90px rgba(0,0,0,0.9)", fontFamily: MONO, color: "#1b1a18" }}>
        <div style={{ textAlign: "center", fontSize: 26, letterSpacing: 3 }}>T.C. SAĞLIK BAKANLIĞI</div>
        <div style={{ textAlign: "center", fontFamily: SERIF, fontWeight: 700, fontSize: 72, margin: "20px 0 50px", letterSpacing: 4 }}>{ins.heading}</div>
        {ins.lines.map((l, i) => (
          <div key={i} style={{ fontSize: 36, padding: "16px 0", borderBottom: "1px solid rgba(0,0,0,0.25)", position: "relative" }}>
            {l}
            {i === ins.highlightLine && <div style={{ position: "absolute", left: -10, right: -10, bottom: 6, height: 6, background: "#a3140f", transformOrigin: "0 50%", transform: `scaleX(${hl})` }} />}
          </div>
        ))}
        {ins.signature && (
          <div style={{ marginTop: 50, fontSize: 28 }}>
            {ins.signature}
            <svg width={340} height={110} style={{ display: "block" }}>
              <path d="M 10 70 C 50 10, 70 110, 110 50 S 170 20, 190 70 S 260 90, 330 30" stroke="#1d2a5a" strokeWidth={4} fill="none" strokeDasharray={600} strokeDashoffset={600 * (1 - clamp01((sec - 1.5) / 1.2))} />
            </svg>
          </div>
        )}
        {ins.stamp && (
          <div style={{ position: "absolute", right: 60, bottom: 90, width: 230, height: 230, borderRadius: "50%", border: "8px solid rgba(160,25,25,0.7)", color: "rgba(160,25,25,0.75)", display: "flex", alignItems: "center", justifyContent: "center", textAlign: "center", fontSize: 30, fontWeight: 500, transform: "rotate(-18deg)" }}>
            {ins.stamp}
          </div>
        )}
        {ins.burned && <Burn />}
      </div>
      <Flashlight />
    </AbsoluteFill>
  );
};

// ---------------------------------------------------------------- Fotoğraflar
const PhotoPrint: React.FC<{ kids: number; adults: number; caption?: string; burned?: boolean; rot: number; x: number; y: number; scale?: number; seed: string }> = ({ kids, adults, caption, burned, rot, x, y, scale = 1, seed }) => (
  <div style={{ position: "absolute", left: x, top: y, width: 760 * scale, padding: 30 * scale, paddingBottom: 120 * scale, background: "#e9e4d8", transform: `rotate(${rot}deg)`, boxShadow: "0 30px 60px rgba(0,0,0,0.85)" }}>
    <div style={{ height: 700 * scale, background: "radial-gradient(ellipse at 50% 40%, #a08a6a, #3b2e20 70%)", position: "relative", overflow: "hidden", filter: "sepia(0.4) contrast(1.1)" }}>
      <svg width="100%" height="100%" viewBox="0 0 700 700">
        <rect x={420} y={80} width={180} height={260} fill="#2a2018" />
        {new Array(adults).fill(0).map((_, i) => (
          <Silhouette key={`a${i}`} x={170 + i * 360} y={760} h={640} fill="#1a130c" blur={2} />
        ))}
        {new Array(kids).fill(0).map((_, i) => (
          <g key={`k${i}`}>
            <Silhouette x={(kids === 1 ? 350 : 250 + i * 200) + (random(`${seed}${i}`) - 0.5) * 10} y={760} h={430} child fill="#1a2238" blur={1.5} eyes={kids === 2 ? 0.25 : 0} />
          </g>
        ))}
        <ellipse cx={350} cy={300} rx={300} ry={200} fill="rgba(255,250,230,0.25)" style={{ filter: "blur(40px)" }} />
      </svg>
    </div>
    {caption && <div style={{ fontFamily: SERIF_I, fontSize: 52 * scale, color: "#2b2a4a", marginTop: 26 * scale }}>{caption}</div>}
    {burned && <Burn />}
  </div>
);

export const Photo: React.FC<{ ins: PhotoInsert }> = ({ ins }) => {
  const f = useCurrentFrame();
  const drift = noise2D("ph", f / 120, 0) * 6;
  return (
    <AbsoluteFill style={{ background: "#0c0906" }}>
      <AbsoluteFill style={{ background: "repeating-linear-gradient(90deg, #2a1c10 0 4px, #24180d 4px 60px)", opacity: 0.6 }} />
      {ins.variant === "stack" ? (
        <>
          <PhotoPrint kids={1} adults={2} burned rot={-12} x={60} y={250} scale={0.85} seed="s1" />
          <PhotoPrint kids={1} adults={1} burned rot={9} x={220} y={520} scale={0.85} seed="s2" />
          <PhotoPrint kids={1} adults={0} burned rot={-3 + drift * 0.2} x={140} y={820} scale={0.85} seed="s3" />
        </>
      ) : (
        <PhotoPrint kids={ins.variant === "twins" ? 2 : 1} adults={ins.variant === "family" ? 2 : 0} caption={ins.caption} burned={ins.burned} rot={-4 + drift * 0.2} x={130} y={420} seed={ins.variant} />
      )}
      <AbsoluteFill style={{ background: "radial-gradient(circle at 50% 45%, transparent 30%, rgba(0,0,0,0.85) 75%)" }} />
    </AbsoluteFill>
  );
};

// ---------------------------------------------------------------- Monitör duvarı
export const Monitors: React.FC<{ ins: MonitorsInsert }> = ({ ins }) => {
  const f = useCurrentFrame();
  const { fps } = useVideoConfig();
  const sec = f / fps;
  const hiOn = ins.highlight !== undefined && sec >= (ins.highlightAt ?? 0);
  const zoom = hiOn ? interpolate(sec - (ins.highlightAt ?? 0), [0, 2.5], [1, 1.35], { extrapolateRight: "clamp" }) : 1;
  const cols = 3;
  const n = Math.max(9, ins.labels.length);
  const hi = ins.highlight ?? -1;
  const hx = (hi % cols) * 330 + 210;
  const hy = Math.floor(hi / cols) * 300 + 520;
  return (
    <AbsoluteFill style={{ background: "#020403", overflow: "hidden" }}>
      <AbsoluteFill style={{ transform: `scale(${zoom})`, transformOrigin: hi >= 0 ? `${hx}px ${hy}px` : "50% 50%" }}>
        <div style={{ position: "absolute", top: 380, left: 45, display: "grid", gridTemplateColumns: `repeat(${cols}, 300px)`, gap: 30 }}>
          {new Array(n).fill(0).map((_, i) => {
            const on = random(`mon${i}-${Math.floor(f / 4)}`) > 0.02;
            const isHi = i === hi && hiOn;
            return (
              <div key={i} style={{ width: 300, height: 270, borderRadius: 26, background: "#121512", padding: 16, boxShadow: isHi ? "0 0 60px rgba(120,255,180,0.35)" : "0 10px 20px rgba(0,0,0,0.8)" }}>
                <div style={{ width: "100%", height: "100%", borderRadius: 40, overflow: "hidden", position: "relative", background: on ? "radial-gradient(#3e5a4a,#0c1a12)" : "#000", filter: isHi ? "brightness(1.4)" : "brightness(0.85)" }}>
                  <svg width={268} height={238} viewBox="0 0 268 238">
                    <rect x={0} y={150} width={268} height={88} fill="rgba(0,0,0,0.3)" />
                    <Silhouette x={80 + (i * 37) % 120 + noise2D(`m${i}`, f / 60, 0) * 8} y={240} h={i % 4 === 2 ? 120 : 190} child={i % 4 === 2} fill="#081009" blur={1} eyes={isHi ? 0.6 : 0} />
                  </svg>
                  <div style={{ position: "absolute", inset: 0, background: "repeating-linear-gradient(0deg, rgba(0,0,0,0.35) 0 2px, transparent 2px 4px)" }} />
                  <div style={{ position: "absolute", inset: 0, opacity: 0.25, background: `url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='268' height='238'><filter id='n'><feTurbulence baseFrequency='0.9' seed='${(f + i) % 20}'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>")` }} />
                  <div style={{ position: "absolute", left: 14, top: 10, fontFamily: MONO, fontSize: 20, color: "#bfffd8" }}>{ins.labels[i] ?? `T-${String(i * 7 + 3).padStart(2, "0")}`}</div>
                </div>
              </div>
            );
          })}
        </div>
      </AbsoluteFill>
      <AbsoluteFill style={{ background: "radial-gradient(ellipse at 50% 50%, rgba(80,200,140,0.10), transparent 70%)", mixBlendMode: "screen" }} />
    </AbsoluteFill>
  );
};
