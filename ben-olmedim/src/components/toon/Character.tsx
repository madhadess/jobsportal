// 2D animasyon karakter sistemi — tamamen SVG, iskelet (eklem açıları) + yüz ifadeleri + ağız senkronu.
// Koordinatlar: ayak ortası (0,0), yukarı negatif y. Ayakta boy ≈ 1000 birim (ölçekle büyütülür).
import React from "react";
import { random } from "remotion";
import { noise2D } from "@remotion/noise";

export type Expression = "neutral" | "smile" | "creepy" | "smirk" | "scared" | "shout" | "cry" | "possessed" | "blank" | "worried";
export type Pose = "stand" | "dance" | "sit" | "sitFloor" | "lie" | "point" | "armsOut" | "grab" | "walk" | "handsFace" | "phone";

export type Look = {
  skin: string;
  skinShade: string;
  hair: "messy" | "buzz" | "spiky" | "curly" | "headscarf" | "short";
  hairColor: string;
  top: "hoodie" | "sweater" | "tee-jacket" | "polo" | "jacket" | "cardigan";
  topColor: string;
  topColor2?: string; // ceket / şerit
  pants: string;
  shoes: string;
  build: number; // 1 = normal, >1 tombul
  height: number; // 1 = 14 yaş
  eyeColor: string;
  glasses?: boolean;
  underEyes?: boolean; // göz altı morluk
};

export const LOOKS: Record<string, Look> = {
  ben: { skin: "#d9a87e", skinShade: "#b98760", hair: "messy", hairColor: "#1a1412", top: "hoodie", topColor: "#4a4f57", pants: "#2b3445", shoes: "#d8d8d8", build: 1, height: 1, eyeColor: "#3b2414" },
  mustafa: { skin: "#e6cdb6", skinShade: "#c7ab93", hair: "buzz", hairColor: "#111", top: "sweater", topColor: "#17181b", pants: "#1d1f24", shoes: "#2a2a2a", build: 0.88, height: 0.98, eyeColor: "#120c08", underEyes: true },
  ercan: { skin: "#c99772", skinShade: "#a87a58", hair: "spiky", hairColor: "#0e0b0a", top: "tee-jacket", topColor: "#e9e6df", topColor2: "#3d5a86", pants: "#1f2733", shoes: "#f0f0f0", build: 1.05, height: 1.12, eyeColor: "#2a1a10" },
  gokhan: { skin: "#dcae86", skinShade: "#bb8c66", hair: "curly", hairColor: "#5a3a22", top: "polo", topColor: "#9b2e2e", topColor2: "#e8d9c4", pants: "#3a3530", shoes: "#5a4636", build: 1.3, height: 0.97, eyeColor: "#4a2c18" },
  furkan: { skin: "#cf9f78", skinShade: "#ae7f5b", hair: "short", hairColor: "#2a1d14", top: "jacket", topColor: "#3f5a3a", pants: "#2c2c30", shoes: "#202020", build: 1, height: 1.02, eyeColor: "#2a1a10", glasses: true },
  arkadas1: { skin: "#d4a27a", skinShade: "#b2825d", hair: "short", hairColor: "#18120e", top: "hoodie", topColor: "#7a2f45", pants: "#263045", shoes: "#cfcfcf", build: 1, height: 1.03, eyeColor: "#2a1a10" },
  arkadas2: { skin: "#e0b58f", skinShade: "#c0946d", hair: "messy", hairColor: "#3d2617", top: "tee-jacket", topColor: "#2d2d2d", topColor2: "#6b6b6b", pants: "#30363f", shoes: "#9a2b2b", build: 0.95, height: 0.96, eyeColor: "#3b2414" },
  arkadas3: { skin: "#c48f68", skinShade: "#a2714d", hair: "spiky", hairColor: "#2a1a10", top: "polo", topColor: "#2f5d7a", topColor2: "#dfe7ee", pants: "#2a2a2a", shoes: "#e0e0e0", build: 1.08, height: 1.0, eyeColor: "#2a1a10" },
  anne: { skin: "#dcb08c", skinShade: "#bb8f6c", hair: "headscarf", hairColor: "#b8a689", top: "cardigan", topColor: "#6e5a4a", pants: "#3a3430", shoes: "#2a2420", build: 1.12, height: 1.12, eyeColor: "#3b2414" },
};

type Angles = {
  lSh: number; lEl: number; rSh: number; rEl: number; // omuz/dirsek (0 = aşağı, + = dışa/yukarı)
  lHip: number; lKn: number; rHip: number; rKn: number;
  thigh: number; // uyluk uzunluk çarpanı (oturunca kısalma)
  lift: number; // gövdenin aşağı inişi (birim)
  tilt: number; // gövde eğimi (derece)
  head: number; // baş eğimi
};

const BASE: Angles = { lSh: 8, lEl: 6, rSh: 8, rEl: 6, lHip: 3, lKn: 0, rHip: 3, rKn: 0, thigh: 1, lift: 0, tilt: 0, head: 0 };

function poseAngles(pose: Pose, t: number, seed: string, pointPeriod = 1.4): Angles {
  const n = (k: string, sp = 1) => noise2D(seed + k, t * sp, 0);
  switch (pose) {
    case "dance": {
      const b = Math.sin(t * Math.PI * 2 * 1.03 + random(seed) * 6);
      return { ...BASE, lSh: 120 + b * 40, lEl: 60 + b * 30, rSh: 130 - b * 40, rEl: 50 - b * 30, lHip: 6 + b * 6, rHip: 6 - b * 6, lKn: Math.max(0, b) * 25, rKn: Math.max(0, -b) * 25, lift: Math.abs(b) * 25, tilt: b * 7, head: -b * 9 };
    }
    case "sit":
      return { ...BASE, lSh: 14, lEl: 40, rSh: 14, rEl: 40, lHip: 10, rHip: 10, thigh: 0.25, lift: 190, head: n("h", 0.3) * 4 };
    case "sitFloor":
      return { ...BASE, lSh: 18, lEl: 55, rSh: 18, rEl: 55, lHip: 70, lKn: -140, rHip: 70, rKn: -140, thigh: 0.55, lift: 420, head: n("h", 0.3) * 4 };
    case "lie":
      return { ...BASE, lSh: 12, rSh: 12 };
    case "point": {
      // kapı (yana) ↔ tavan (yukarı) arasında gidip gelen kol
      const phase = Math.floor(t / pointPeriod) % 2;
      const k = Math.min(1, (t % pointPeriod) / 0.25);
      const from = phase ? 92 : 168;
      const to = phase ? 168 : 92;
      return { ...BASE, lHip: 70, lKn: -140, rHip: 70, rKn: -140, thigh: 0.55, lift: 420, lSh: from + (to - from) * k, lEl: 0, rSh: 18, rEl: 40, head: phase ? -6 : 8 };
    }
    case "armsOut":
      return { ...BASE, lSh: 110 + n("a", 2) * 10, lEl: 15, rSh: 110 - n("b", 2) * 10, rEl: 15, head: -8 + n("h", 1.5) * 6, tilt: n("t", 1) * 4 };
    case "grab":
      return { ...BASE, lSh: 75, lEl: 50, rSh: 80, rEl: 45, lHip: 12, rHip: -4, rKn: 10, tilt: n("t", 4) * 6 };
    case "walk": {
      const w = Math.sin(t * Math.PI * 2 * 0.9);
      return { ...BASE, lSh: 8 + w * 18, rSh: 8 - w * 18, lHip: w * 16, rHip: -w * 16, lKn: Math.max(0, -w) * 20, rKn: Math.max(0, w) * 20, lift: Math.abs(w) * 10 };
    }
    case "handsFace":
      return { ...BASE, lSh: 40, lEl: 150, rSh: 40, rEl: 150, head: 12, tilt: 4 };
    case "phone":
      return { ...BASE, lSh: 20, lEl: 120, rSh: 10, rEl: 8, head: 10 };
    default:
      return { ...BASE, lSh: 8 + n("l", 0.4) * 3, rSh: 8 + n("r", 0.4) * 3, head: n("h", 0.3) * 3 };
  }
}

// ---------------------------------------------------------------- yüz

const Eyes: React.FC<{ expr: Expression; look: Look; blink: number; t: number; lookX: number }> = ({ expr, look, blink, t, lookX }) => {
  const y = -892;
  const dx = 30;
  if (expr === "possessed") {
    return (
      <g>
        {[-1, 1].map((s) => (
          <g key={s}>
            <ellipse cx={s * dx} cy={y} rx={17} ry={14} fill="#050505" />
            <circle cx={s * dx + 5} cy={y - 4} r={2.2} fill="#9fb3c8" opacity={0.7} />
            <path d={`M ${s * dx - 18} ${y + 14} q ${s * 4} 18 ${s * 2} 36`} stroke="#3a1414" strokeWidth={2} fill="none" opacity={0.6} />
          </g>
        ))}
      </g>
    );
  }
  const wide = expr === "scared" || expr === "shout" ? 1.25 : expr === "smirk" ? 0.7 : expr === "creepy" ? 1.05 : 1;
  const ry = 13 * wide * (1 - blink);
  return (
    <g>
      {[-1, 1].map((s) => (
        <g key={s}>
          {look.underEyes && <ellipse cx={s * dx} cy={y + 13} rx={19} ry={7} fill="#5a3a4a" opacity={0.35} />}
          {ry > 1 ? (
            <>
              <ellipse cx={s * dx} cy={y} rx={16} ry={ry} fill="#f4f1ea" />
              <circle cx={s * dx + lookX * 5} cy={y + 1} r={Math.min(9, ry * 0.75)} fill={look.eyeColor} />
              <circle cx={s * dx + lookX * 5} cy={y + 1} r={Math.min(4.5, ry * 0.38)} fill="#050403" />
              <circle cx={s * dx + lookX * 5 + 3} cy={y - 3} r={2} fill="#fff" opacity={0.9} />
            </>
          ) : (
            <path d={`M ${s * dx - 15} ${y + 1} q 15 6 30 0`} stroke="#2a1a12" strokeWidth={3} fill="none" />
          )}
        </g>
      ))}
      {expr === "cry" &&
        [-1, 1].map((s) => (
          <path key={s} d={`M ${s * dx} ${y + 14} q ${s * 3} 25 0 ${45 + Math.sin(t * 3) * 6}`} stroke="#bcd8f0" strokeWidth={4} fill="none" opacity={0.8} />
        ))}
    </g>
  );
};

const Brows: React.FC<{ expr: Expression; color: string }> = ({ expr, color }) => {
  const y = -918;
  const tilt: Record<Expression, number> = { neutral: 0, smile: -2, creepy: 6, smirk: 4, scared: -10, shout: 12, cry: -12, possessed: 14, blank: 0, worried: -9 };
  const a = tilt[expr];
  return (
    <g stroke={color} strokeWidth={7} strokeLinecap="round" fill="none">
      <path d={`M ${-46} ${y - a * 0.4} L ${-16} ${y + a * 0.6}`} />
      <path d={`M ${46} ${y - a * 0.4} L ${16} ${y + a * 0.6}`} />
    </g>
  );
};

const Mouth: React.FC<{ expr: Expression; open: number }> = ({ expr, open }) => {
  const y = -838;
  const o = Math.max(0, Math.min(1, open));
  if (o > 0.06 || expr === "shout") {
    const h = expr === "shout" ? 18 + o * 22 : 4 + o * 20;
    const w = expr === "shout" ? 26 : 16 + o * 5;
    return (
      <g>
        <ellipse cx={0} cy={y + h * 0.3} rx={w} ry={h} fill="#3a1414" />
        {h > 10 && <ellipse cx={0} cy={y + h * 0.3 + h * 0.55} rx={w * 0.6} ry={h * 0.3} fill="#a5524f" />}
        {h > 8 && <rect x={-w * 0.7} y={y + h * 0.3 - h + 1} width={w * 1.4} height={Math.min(6, h * 0.3)} rx={2} fill="#f1ede4" />}
      </g>
    );
  }
  const d: Record<Expression, string> = {
    neutral: `M -16 ${y} q 16 3 32 0`,
    smile: `M -20 ${y - 3} q 20 16 40 0`,
    creepy: `M -30 ${y - 6} q 30 22 60 0`,
    smirk: `M -14 ${y + 2} q 18 2 30 -9`,
    scared: `M -10 ${y} q 10 -6 20 0 q -10 8 -20 0`,
    shout: "",
    cry: `M -18 ${y + 6} q 18 -14 36 0`,
    possessed: `M -26 ${y} q 26 4 52 0`,
    blank: `M -14 ${y} L 14 ${y}`,
    worried: `M -16 ${y + 4} q 16 -8 32 0`,
  };
  return <path d={d[expr]} stroke="#3a1a14" strokeWidth={5} fill={expr === "scared" ? "#3a1414" : "none"} strokeLinecap="round" />;
};

const Hair: React.FC<{ look: Look; back?: boolean }> = (props) => (
  // ince kenar ışığı: koyu saç karanlık dekorda kaybolmasın
  <g stroke="rgba(255,236,210,0.22)" strokeWidth={4} strokeLinejoin="round">
    <HairShape {...props} />
  </g>
);

const HairShape: React.FC<{ look: Look; back?: boolean }> = ({ look, back }) => {
  const c = look.hairColor;
  switch (look.hair) {
    case "buzz":
      return <path d="M -80 -905 Q -82 -990 0 -995 Q 82 -990 80 -905 Q 60 -950 0 -955 Q -60 -950 -80 -905 Z" fill={c} opacity={0.85} />;
    case "spiky":
      return (
        <path
          d="M -86 -900 Q -95 -975 -60 -995 L -70 -1040 L -30 -1005 L -20 -1060 L 10 -1008 L 35 -1055 L 45 -1003 L 85 -1030 L 72 -985 Q 96 -960 86 -900 Q 72 -930 30 -938 L 0 -925 L -30 -940 Q -72 -930 -86 -900 Z"
          fill={c}
        />
      );
    case "curly":
      return (
        <g fill={c}>
          {[-70, -45, -15, 15, 45, 70, -82, 82, -58, 58, 0].map((x, i) => (
            <circle key={i} cx={x} cy={-975 + Math.abs(x) * 0.55 + (i % 2) * 10} r={30} />
          ))}
        </g>
      );
    case "headscarf":
      // önde yalnızca alın bandı ve yüzü çevreleyen kenar; büyük örtü ScarfBack ile yüzün arkasında
      return (
        <g>
          <path d="M -92 -880 Q -96 -1000 0 -1004 Q 96 -1000 92 -880 Q 82 -955 0 -962 Q -82 -955 -92 -880 Z" fill={c} />
          <path d="M -84 -900 Q -86 -958 0 -962 Q 86 -958 84 -900" fill="none" stroke="#9c8b70" strokeWidth={6} />
          {[...Array(7)].map((_, i) => (
            <circle key={i} cx={-66 + i * 22} cy={-978 + Math.abs(i - 3) * 5} r={5} fill="#e4d6ba" />
          ))}
          <path d="M -92 -880 Q -100 -800 -60 -770" stroke={c} strokeWidth={22} fill="none" />
          <path d="M 92 -880 Q 100 -800 60 -770" stroke={c} strokeWidth={22} fill="none" />
        </g>
      );
    case "short":
      return <path d="M -84 -895 Q -92 -1000 0 -1002 Q 92 -1000 84 -895 Q 72 -935 20 -940 Q -40 -928 -84 -895 Z" fill={c} />;
    default:
      // dağınık
      return (
        <path
          d="M -88 -890 Q -100 -985 -40 -1008 Q 0 -1022 45 -1005 Q 98 -990 88 -890 Q 80 -940 40 -945 Q 55 -925 30 -915 Q 20 -945 -10 -948 Q 0 -925 -30 -918 Q -40 -940 -60 -935 Q -82 -925 -88 -890 Z"
          fill={c}
        />
      );
  }
  void back;
};

// ---------------------------------------------------------------- uzuv yardımcıları

const Limb: React.FC<{ x: number; y: number; a1: number; a2: number; l1: number; l2: number; w: number; color: string; end: React.ReactNode; side: 1 | -1 }> = ({ x, y, a1, a2, l1, l2, w, color, end, side }) => (
  <g transform={`translate(${x} ${y}) rotate(${side * a1})`}>
    <rect x={-w / 2} y={0} width={w} height={l1 + w * 0.3} rx={w / 2} fill={color} />
    <g transform={`translate(0 ${l1}) rotate(${side * a2})`}>
      <rect x={-w * 0.45} y={0} width={w * 0.9} height={l2} rx={w * 0.45} fill={color} />
      <g transform={`translate(0 ${l2})`}>{end}</g>
    </g>
  </g>
);

// ---------------------------------------------------------------- karakter

export type CharacterProps = {
  look: Look;
  pose: Pose;
  expr: Expression;
  /** sahne içi saniye */
  t: number;
  /** ağız açıklığı 0..1 (seslendirme zarfından) */
  mouth?: number;
  seed: string;
  back?: boolean;
  bandages?: boolean;
  pointPeriod?: number;
  shake?: number;
  lookX?: number;
};

export const Character: React.FC<CharacterProps> = ({ look, pose, expr, t, mouth = 0, seed, back, bandages, pointPeriod, shake = 0, lookX = 0 }) => {
  const a = poseAngles(pose, t, seed, pointPeriod);
  const bw = look.build;
  // göz kırpma: rastgele aralıklarla ~0.15 sn
  const period = 2.6 + random(seed + "bp") * 2.2;
  const ph = (t + random(seed + "bo") * period) % period;
  const blink = expr === "possessed" || pose === "lie" ? (pose === "lie" && expr === "blank" ? 1 : 0) : ph < 0.13 ? Math.sin((ph / 0.13) * Math.PI) : 0;
  const breathe = Math.sin(t * 1.6 + random(seed) * 5) * 4;
  const sx = shake ? noise2D(seed + "sx", t * 9, 0) * 12 * shake : 0;
  const sy = shake ? noise2D(seed + "sy", t * 9, 1) * 6 * shake : 0;
  const lift = a.lift;
  const thighL = 230 * a.thigh;
  const skin = look.skin;
  const top = look.topColor;

  const hand = <circle r={25} fill={skin} />;
  const shoe = <ellipse cx={0} cy={12} rx={38} ry={20} fill={look.shoes} />;

  const torsoTop = -770;
  const torsoBot = -462;
  const shW = 100 * bw;
  const hipW = 74 * bw;

  const legs = (
    <g>
      <Limb x={-38 * bw} y={-470} a1={a.lHip} a2={a.lKn} l1={thighL} l2={230} w={58 * bw} color={look.pants} end={shoe} side={1} />
      <Limb x={38 * bw} y={-470} a1={a.rHip} a2={a.rKn} l1={thighL} l2={230} w={58 * bw} color={look.pants} end={shoe} side={-1} />
    </g>
  );

  const torso = (
    <g>
      <path
        d={`M ${-shW} ${torsoTop + 20} Q ${-shW} ${torsoTop} ${-shW + 30} ${torsoTop - 8} L ${shW - 30} ${torsoTop - 8} Q ${shW} ${torsoTop} ${shW} ${torsoTop + 20} L ${hipW + 8} ${torsoBot} L ${-hipW - 8} ${torsoBot} Z`}
        fill={top}
      />
      {look.top === "tee-jacket" && (
        <>
          <path d={`M ${-shW} ${torsoTop + 20} L ${-shW + 30} ${torsoTop - 8} L -32 ${torsoTop - 6} L -26 ${torsoBot} L ${-hipW - 8} ${torsoBot} Z`} fill={look.topColor2} />
          <path d={`M ${shW} ${torsoTop + 20} L ${shW - 30} ${torsoTop - 8} L 32 ${torsoTop - 6} L 26 ${torsoBot} L ${hipW + 8} ${torsoBot} Z`} fill={look.topColor2} />
        </>
      )}
      {look.top === "polo" &&
        [0, 1, 2].map((i) => <rect key={i} x={-hipW - 6} y={torsoTop + 80 + i * 70} width={(hipW + 6) * 2} height={16} fill={look.topColor2} opacity={0.85} />)}
      {look.top === "hoodie" && !back && (
        <>
          <path d={`M -45 ${torsoTop - 6} Q 0 ${torsoTop + 50} 45 ${torsoTop - 6}`} stroke="rgba(0,0,0,0.35)" strokeWidth={8} fill="none" />
          <rect x={-55} y={torsoBot - 110} width={110} height={70} rx={14} fill="rgba(0,0,0,0.18)" />
        </>
      )}
      {look.top === "cardigan" && <rect x={-6} y={torsoTop} width={12} height={torsoBot - torsoTop} fill="rgba(0,0,0,0.3)" />}
      {look.top === "jacket" && <rect x={-4} y={torsoTop} width={8} height={torsoBot - torsoTop} fill="#c9c9c9" opacity={0.7} />}
      {back && bandages && (
        <g opacity={0.95}>
          {[0, 1, 2].map((i) => (
            <rect key={i} x={-shW + 18} y={torsoTop + 60 + i * 70} width={(shW - 18) * 2} height={30} rx={6} fill="#efe9de" transform={`rotate(${-12 + i * 9} 0 ${torsoTop + 75 + i * 70})`} />
          ))}
          <path d={`M -50 ${torsoTop + 90} L 40 ${torsoTop + 200}`} stroke="#b9a38f" strokeWidth={3} opacity={0.6} />
        </g>
      )}
      {/* gölge tarafı */}
      <path d={`M 0 ${torsoTop - 8} L ${shW - 30} ${torsoTop - 8} Q ${shW} ${torsoTop} ${shW} ${torsoTop + 20} L ${hipW + 8} ${torsoBot} L 0 ${torsoBot} Z`} fill="rgba(0,0,0,0.18)" />
    </g>
  );

  const armL = <Limb x={-shW + 6} y={-748} a1={a.lSh} a2={a.lEl} l1={185} l2={175} w={44 * bw} color={top} end={hand} side={1} />;
  const armR = <Limb x={shW - 6} y={-748} a1={a.rSh} a2={a.rEl} l1={185} l2={175} w={44 * bw} color={top} end={hand} side={-1} />;

  const head = (
    <g transform={`rotate(${a.head} 0 -800)`}>
      {look.hair === "headscarf" && (
        <path d="M -112 -860 Q -120 -1015 0 -1018 Q 120 -1015 112 -860 Q 118 -760 60 -730 L -60 -730 Q -118 -760 -112 -860 Z" fill={look.hairColor} />
      )}
      <rect x={-24} y={-815} width={48} height={60} fill={look.skinShade} />
      {!back && (
        <>
          <ellipse cx={-82} cy={-880} rx={14} ry={22} fill={look.skinShade} />
          <ellipse cx={82} cy={-880} rx={14} ry={22} fill={look.skinShade} />
        </>
      )}
      <ellipse cx={0} cy={-885} rx={82 * Math.min(1.12, 0.94 + bw * 0.06)} ry={95} fill={back ? look.hairColor : skin} stroke={back ? "rgba(255,236,210,0.2)" : "none"} strokeWidth={4} />
      {!back && (
        <>
          <path d="M 0 -980 Q 70 -975 82 -890 Q 80 -820 30 -792 Q 55 -860 0 -980 Z" fill="rgba(0,0,0,0.12)" />
          <Brows expr={expr} color={look.hair === "headscarf" ? "#3a2a1e" : look.hairColor} />
          <Eyes expr={expr} look={look} blink={blink} t={t} lookX={lookX} />
          <path d="M -4 -880 Q -12 -856 -2 -852 Q 6 -850 10 -856" stroke={look.skinShade} strokeWidth={4} fill="none" />
          <Mouth expr={expr} open={mouth} />
          {look.glasses && (
            <g fill="none" stroke="#1a1a1a" strokeWidth={4}>
              <rect x={-52} y={-908} width={44} height={34} rx={8} />
              <rect x={8} y={-908} width={44} height={34} rx={8} />
              <path d="M -8 -892 L 8 -892" />
            </g>
          )}
          {(expr === "possessed" || look.underEyes) && <ellipse cx={0} cy={-885} rx={82} ry={95} fill={expr === "possessed" ? "rgba(70,90,110,0.25)" : "rgba(255,255,255,0.05)"} />}
        </>
      )}
      <Hair look={look} back={back} />
    </g>
  );

  const chair =
    pose === "sit" ? (
      <g>
        <rect x={-150} y={-700} width={300} height={360} rx={18} fill="#2a1d14" />
        <rect x={-165} y={-300} width={330} height={40} rx={10} fill="#3a2a1c" />
        <rect x={-150} y={-262} width={22} height={262} fill="#21170f" />
        <rect x={128} y={-262} width={22} height={262} fill="#21170f" />
      </g>
    ) : null;

  const body = (
    <g transform={`translate(${sx} ${lift + breathe * 0.3 + sy}) rotate(${a.tilt} 0 -470)`}>
      {legs}
      {back ? (
        <>
          {armL}
          {armR}
          {torso}
        </>
      ) : (
        <>
          {torso}
          {armL}
          {armR}
        </>
      )}
      <g transform={`translate(0 ${breathe * 0.2})`}>{head}</g>
    </g>
  );

  const scaleY = look.height;
  if (pose === "lie") {
    // yerde yatan: gövde yere paralel, baş sağda
    return (
      <g transform={`translate(${-470 * scaleY} -95) rotate(90) scale(${scaleY})`}>{body}</g>
    );
  }
  return (
    <g transform={`scale(${scaleY})`}>
      {chair}
      {body}
    </g>
  );
};
