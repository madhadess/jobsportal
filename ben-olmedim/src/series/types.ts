// BEN ÖLMEDİM — tüm dizi verisinin tip tanımları.
// Senaryo verisi (episodes/*), dizi kutsal kitabı (bible.ts) ve üretim manifestleri bu tipleri paylaşır.

export type CharacterId =
  | "aras"
  | "arasKanli"
  | "arasCocuk"
  | "cocuk13"
  | "baba"
  | "anne"
  | "nermin"
  | "memur"
  | "arasYasli"
  | "arasEvli"
  | "sakinler";

export type LocationId =
  | "daire7Salon"
  | "daire7Yatak"
  | "daire7Banyo"
  | "daire7Kapi"
  | "koridor3"
  | "merdiven"
  | "giris"
  | "daire13"
  | "bodrum"
  | "gizliOda"
  | "camBolme"
  | "kayipKat"
  | "asansor"
  | "belediye"
  | "yanginGecesi"
  | "normalEv";

export type SpeakerId =
  | "anlatici" // Aras'ın iç sesi / anlatıcı
  | "aras" // Aras doğrudan konuşma
  | "arasKayit" // telefondaki ses kaydı (Aras'ın sesi)
  | "arasKapi" // kapının arkasındaki / kanlı Aras
  | "yansima" // aynadaki Aras
  | "arasYasli" // yaşlı Aras versiyonu
  | "cocuk" // 13 numaradaki çocuk
  | "baba" // Kemal Yalçın, yüz yüze
  | "babaTelefon" // telefon / eski ses kaydı
  | "anneTelefon" // Selma Yalçın, telefonda
  | "nermin" // ölü komşu Nermin Hanım
  | "memur" // belediye memuru
  // --- Özel bölüm: KAPI. TAVAN. ---
  | "hikaye" // anlatıcı (bugün 18 yaşında)
  | "benGenc" // anlatıcı, 14 yaşındaki hali
  | "mustafa"
  | "ercan"
  | "ercanCin" // Ercan'ın içindeki ses
  | "ercanAnne"
  | "gokhan";

export type ShotType = "ECU" | "CU" | "MCU" | "MS" | "WS" | "POV" | "INSERT" | "CCTV" | "OTS";

export type CameraMove =
  | "static"
  | "pushIn" // yavaş yaklaşma
  | "slowPushIn"
  | "pullOut"
  | "handheld" // kontrollü titreme
  | "panLeft"
  | "panRight"
  | "tiltUp"
  | "tiltDown"
  | "dollyZoom" // vertigo etkisi
  | "drift";

export type Transition = "cut" | "fade" | "blackout" | "glitch" | "flash";

export type AmbienceId =
  | "roomTone"
  | "fluorescent"
  | "corridorDrone"
  | "lowTension"
  | "basementHum"
  | "fireRoar"
  | "rain"
  | "cityMorning"
  | "partyMusic"
  | "nightStreet"
  | "siren";

export type SfxId =
  | "knock3"
  | "knock1"
  | "phoneVibrate"
  | "phoneNotify"
  | "phoneRing"
  | "heartbeat"
  | "clockTick"
  | "breath"
  | "woodCreak"
  | "footsteps"
  | "metalScrape"
  | "riser"
  | "hitLow"
  | "staticBurst"
  | "doorHandle"
  | "paperSlide"
  | "fireCrackle"
  | "elevatorDing"
  | "tapeClick"
  | "glitch"
  | "plasterCrack"
  | "scratching"
  | "doorsOpen"
  | "powerDown"
  | "childHum"
  | "suddenSilence"
  | "slap"
  | "bodyFall"
  | "motorbike"
  | "glassClink"
  | "doorSlam"
  | "liquidSplash"
  | "musicCut";

// ---------- Prosedürel (Remotion içinde çizilen) görsel katmanlar ----------

export type PhoneInsert = {
  kind: "phone";
  screen: "notification" | "voice" | "call" | "search" | "message" | "gallery" | "clock";
  time: string; // ekrandaki saat "23:58"
  date?: string; // "16 Kasım Pazartesi"
  title?: string;
  subtitle?: string;
  body?: string;
  /** ses kaydı oynatma çubuğu (0..1) sahne boyunca from→to */
  progress?: [number, number];
  /** telefon titreşimi sahne başında */
  buzz?: boolean;
  /** arama ekranı: mezar taşı görseli yerine bulanık sonuç başlıkları */
  results?: string[];
  /** yakın plan: ekranın üst kısmına yakınlaşma çarpanı (1 = tüm telefon) */
  zoom?: number;
};

export type ClockInsert = {
  kind: "clock";
  from: string; // "03:16"
  to?: string; // "03:17"
  /** saniye cinsinden geçiş anı (sahne içi) */
  switchAt?: number;
  stopped?: boolean;
};

export type DoorInsert = {
  kind: "door";
  number?: string;
  knocks?: number[]; // sahne içi saniyeler — kapı titrer
  shadowUnder?: boolean;
  paperAt?: number; // kapı altından kâğıt itildiği an
  ajar?: boolean;
  drawing?: boolean; // 13 numaralı kapıdaki çocuk çizimi
};

export type PeepholeInsert = {
  kind: "peephole";
  figure: "none" | "arasKanli" | "child" | "many";
  lean?: boolean; // figür dürbüne yaklaşır
};

export type CctvFigure = {
  x: number; // 0..1
  y: number; // 0..1 (ayak çizgisi)
  scale?: number;
  type: "adult" | "child";
  /** sahne içi saniye — figürün kameraya dönüp "gülümsediği" an (yüz parlaması) */
  turnAt?: number;
  appearAt?: number;
  vanishAt?: number;
};

export type CctvInsert = {
  kind: "cctv";
  cam: string; // "KAM-02 / 3. KAT"
  timestamp: string; // "17.11.2026 03:17:02"
  room: "corridor" | "living" | "stairs" | "elevator" | "fire";
  figures: CctvFigure[];
  color?: boolean;
};

export type DocumentInsert = {
  kind: "document";
  variant: "deathCertificate" | "newspaper" | "registry" | "notebook" | "blueprint";
  heading: string;
  lines: string[];
  stamp?: string;
  signature?: string;
  burned?: boolean;
  highlightLine?: number;
};

export type CorridorInsert = {
  kind: "corridor";
  doors: string[];
  flicker?: number; // 0..1
  burned?: boolean;
  openDoors?: boolean;
  figures?: { x: number; depth: number; type: "adult" | "child"; walk?: boolean }[];
};

export type MonitorsInsert = {
  kind: "monitors";
  labels: string[];
  highlight?: number;
  highlightAt?: number;
};

export type PhotoInsert = {
  kind: "photo";
  variant: "family" | "twins" | "stack";
  caption?: string;
  burned?: boolean;
};

export type AtmosInsert = {
  kind: "atmos";
  tone: "cold" | "warm" | "fire" | "red" | "green";
  light?: "flicker" | "steady" | "beam" | "pulse";
  figure?: "none" | "adult" | "child" | "father";
};

export type WallInsert = { kind: "wall"; crackAt?: number; hand?: boolean; scratches?: boolean };
export type MirrorInsert = { kind: "mirror"; lag?: number; lean?: boolean };
export type ElevatorInsert = { kind: "elevator"; floors: string[]; stopOn: string };
export type BlackoutInsert = { kind: "blackout" };

export type ActorPose = "stand" | "dance" | "sit" | "sitFloor" | "lie" | "point" | "armsOut" | "grab" | "walk" | "handsFace" | "phone";
export type ActorExpr = "neutral" | "smile" | "creepy" | "smirk" | "scared" | "shout" | "cry" | "possessed" | "blank" | "worried";

/**
 * Sahne içi zaman: saniye (sayı) ya da replik bağlantılı "L<i>[±sn]" (i. repliğin başı) /
 * "E<i>[±sn]" (i. repliğin sonu). Ör. "E2" = 3. replik bitince, "L1+2.5" = 2. replik başlayınca 2,5 sn sonra.
 */
export type StageTime = number | `L${number}` | `E${number}` | `L${number}+${number}` | `E${number}+${number}` | `L${number}-${number}` | `E${number}-${number}`;

/** 2D animasyon sahnesindeki bir karakter */
export type StageActor = {
  /** karakter görünümü (components/toon/Character.tsx → LOOKS) */
  who: "ben" | "mustafa" | "ercan" | "gokhan" | "furkan" | "arkadas1" | "arkadas2" | "arkadas3" | "anne";
  x: number; // 0..1 yatay konum
  /** ayak çizgisi (px). Varsayılan 1720 */
  y?: number;
  scale?: number;
  pose: ActorPose;
  expr: ActorExpr;
  /** bu konuşanların replikleri sırasında ağız seslendirmeyle senkron açılır */
  speaks?: SpeakerId[];
  back?: boolean;
  bandages?: boolean;
  flip?: boolean;
  pointPeriod?: number;
  shake?: number;
  lookX?: number;
  appearAt?: StageTime;
  vanishAt?: StageTime;
  /** [zaman, poz] — sahne içinde poz değişimi */
  poseAt?: [StageTime, ActorPose][];
  /** [zaman, ifade] */
  exprAt?: [StageTime, ActorExpr][];
  /** yürüyerek gitme: [başlangıç, bitiş, hedef x, hedef ölçek?, hedef ayak y?] */
  moveTo?: [StageTime, StageTime, number, number?, number?];
};

export type StageInsert = {
  kind: "stage";
  bg: "party" | "living" | "candles" | "street" | "doorway" | "police" | "bedroom" | "glass" | "doorCeiling" | "hallway";
  actors: StageActor[];
  /** parti ışıkları/müzik bu saniyede kesilir */
  lightsOffAt?: number;
  /** bardak: siyah lekenin yayılmaya başladığı an */
  stainAt?: number;
  /** doorCeiling: kapı/tavan vurgusu periyodu */
  period?: number;
  /** sokak: ileri hareket hızı 0..1 */
  speed?: number;
};

export type Insert =
  | PhoneInsert
  | ClockInsert
  | DoorInsert
  | PeepholeInsert
  | CctvInsert
  | DocumentInsert
  | CorridorInsert
  | MonitorsInsert
  | PhotoInsert
  | AtmosInsert
  | WallInsert
  | MirrorInsert
  | ElevatorInsert
  | BlackoutInsert
  | StageInsert;

// ---------- Senaryo ----------

export type LineSpec = {
  speaker: SpeakerId;
  text: string;
  /** satır başlamadan önceki bekleme (sn). Varsayılan 0.35 */
  delay?: number;
};

/** [konuşan, metin, bekleme?] kısa yazım */
export type LineTuple = [SpeakerId, string] | [SpeakerId, string, number];

export type SfxCue = {
  id: SfxId;
  /** sahne başından itibaren saniye; "end" = sahne sonu; "afterLines" = son replikten hemen sonra */
  at: number | "end" | "afterLines";
  volume?: number;
};

export type SfxTuple = [SfxId, number | "end" | "afterLines"] | [SfxId, number | "end" | "afterLines", number];

export type MediaSpec = {
  /** "video" = yapay zekâ video klibi, "image" = fotogerçekçi kare (kamera hareketiyle canlandırılır) */
  type: "video" | "image";
  /** İngilizce üretim promptu (sahneye özgü kısım). Stil, karakter ve mekân tanımları otomatik eklenir. */
  prompt: string;
  characters?: CharacterId[];
  location?: LocationId;
  /** Prosedürel katman medyanın üstüne bindirilsin mi (ör. telefon ekranı, CCTV arayüzü) */
  overlayInsert?: boolean;
};

export type SceneSpec = {
  title: string;
  /** Türkçe yönetmen notu: görüntüde ne oluyor */
  visual: string;
  shot: ShotType;
  camera: CameraMove;
  media?: MediaSpec;
  insert?: Insert;
  lines: LineSpec[];
  sfx: SfxCue[];
  ambience: AmbienceId[];
  /** sahnede ortam sesi tamamen kesilir */
  silence?: boolean;
  /** son replikten sonra tutulacak süre (sn) */
  hold: number;
  /** sahnenin asgari süresi (sn) */
  minDuration?: number;
  transitionIn: Transition;
  /** kalp atışı vb. gerilim yoğunluğu 0..1 — grain/titreme şiddeti */
  tension: number;
};

export type EpisodeSpec = {
  number: number;
  title: string;
  logline: string;
  /** önceki bölümün bittiği an (devamlılık kontrolü için) */
  continuesFrom: string;
  /** ilk 3 saniyedeki merak unsuru */
  hook: string;
  /** bu bölümde öğrenilen yeni bilgi */
  revelation: string;
  /** son 5 saniyedeki çarpıcı olay */
  cliffhanger: string;
  /** hikâye içi tarih/saat */
  storyTime: string;
  /** Özel bölüm: dosya/kompozisyon adı (ör. "kapi-tavan"). Yoksa eXX/BXX kullanılır. */
  slug?: string;
  /** Özel bölüm: süre aralığı (sn). Varsayılan 45–60. */
  durationRange?: [number, number];
  /** Özel bölüm: kapanış kartı metni */
  endCardText?: string;
  /** Özel bölüm: kapanış kartının alt satırı */
  endCardSub?: string;
  scenes: SceneSpec[];
};

// ---------- Üretim manifesti (prepare adımının çıktısı, Remotion bunu okur) ----------

export type ManifestLine = {
  speaker: SpeakerId;
  text: string;
  src: string; // public/ altındaki göreli yol
  from: number; // bölüm başından kare
  durationInFrames: number;
  /** kare başına ses yüksekliği zarfı 0..1 (ağız senkronu) */
  env?: number[];
};

export type ManifestSfx = { id: SfxId; src: string; from: number; volume: number; durationInFrames: number };

export type ManifestScene = {
  id: string;
  index: number;
  title: string;
  from: number;
  durationInFrames: number;
  shot: ShotType;
  camera: CameraMove;
  transitionIn: Transition;
  tension: number;
  silence: boolean;
  ambience: AmbienceId[];
  insert: Insert | null;
  media: { src: string; type: "video" | "image"; overlayInsert: boolean } | null;
  mediaMissing: boolean;
  lines: ManifestLine[];
  sfx: ManifestSfx[];
};

export type SubtitleCue = { from: number; to: number; text: string; speaker: SpeakerId };

export type EpisodeManifest = {
  episode: number;
  /** dosya anahtarı (eXX / slug) */
  key: string;
  /** Remotion kompozisyon kimliği (BXX / SLUG) */
  comp: string;
  /** özel bölüm mü */
  special: boolean;
  title: string;
  fps: number;
  width: number;
  height: number;
  durationInFrames: number;
  seconds: number;
  scenes: ManifestScene[];
  subtitles: SubtitleCue[];
  endCard: { from: number; durationInFrames: number; text: string; sub?: string };
  generatedAt: string;
};

export type RenderOptions = {
  /** küçük altyazılar */
  subtitles: boolean;
  /** eksik yapay zekâ medyası için köşe işareti (animatik modu) */
  draftBadges: boolean;
};
