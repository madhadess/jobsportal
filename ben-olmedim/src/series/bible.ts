// DİZİ KUTSAL KİTABI — karakterler, mekânlar, zaman çizelgesi, görsel stil ve ses profilleri.
// Tüm üretim promptları buradan beslenir; tutarlılık için yüz/kıyafet tanımlarını yalnızca burada değiştirin.
import type { CharacterId, LocationId, SpeakerId } from "./types";

export const SERIES = {
  title: "BEN ÖLMEDİM",
  episodes: 30,
  fps: 30,
  width: 1080,
  height: 1920,
  minSeconds: 45,
  maxSeconds: 60,
  endCardSeconds: 2.6,
} as const;

/** Hikâyenin sabit zaman çizelgesi — senaryolarda bu tarihlere sadık kalın. */
export const TIMELINE = {
  fireDate: "17 Kasım 2009",
  fireTime: "03:17",
  arasAgeAtFire: 11,
  presentMoveIn: "16 Kasım 2026 Pazartesi",
  firstKnock: "17 Kasım 2026 Salı 03:17",
  fatherFakeDeath: "2 Kasım 2026",
  nerminDeath: "9 Mart 2023",
  building: "Yalçın Apartmanı, Kurtuluş, İstanbul — 1974 yapımı, 5 kat, resmî olarak 12 daire",
  arasFlat: "Daire 7, 3. kat (çocukluk evi)",
  hiddenFlat: "Daire 13, 3. kat koridorun dibinde, mimari planda yok",
  experiment: "Deney 03.17 — baba Kemal Yalçın'ın bodrumdaki gizli odadan yönettiği gerçeklik tekrar düzeneği",
} as const;

export type Character = {
  id: CharacterId;
  name: string;
  role: string;
  /** İngilizce, yüz kimliği — her promptta birebir kullanılır */
  identity: string;
  wardrobe: string;
  /** karakter referans görseli (tutarlılık için img2vid / reference-image girdisi) */
  referenceImage: string;
  referencePrompt: string;
};

const ARAS_FACE =
  "28-year-old Turkish man, lean build, pale olive skin, dark tousled hair slightly long on top, short dark stubble, deep-set dark brown eyes with dark circles, thin straight nose, narrow jaw, a small pale scar above the left eyebrow";

export const CHARACTERS: Record<CharacterId, Character> = {
  aras: {
    id: "aras",
    name: "Aras Yalçın",
    role: "Ana karakter, 28. Babasının ölümünden sonra çocukluk evine (Daire 7) taşınır. İçine kapanık, uykusuz.",
    identity: ARAS_FACE,
    wardrobe: "charcoal grey hoodie over a faded black t-shirt, dark jeans, barefoot or worn grey socks",
    referenceImage: "refs/characters/aras.png",
    referencePrompt: `Photorealistic character reference sheet, front and three-quarter view, ${ARAS_FACE}, charcoal grey hoodie, neutral expression, soft cold window light, plain dark grey background, 85mm lens, natural skin texture, no makeup`,
  },
  arasKanli: {
    id: "arasKanli",
    name: "Kapıdaki Aras",
    role: "Aras'ın başka bir tekrardan gelen versiyonu. Yüzü kan içinde, aynı kıyafet ama yırtık ve islenmiş.",
    identity: `${ARAS_FACE}, same face as Aras, blood running from the hairline down the face, soot on cheeks, wet hair, eyes unnervingly calm`,
    wardrobe: "the same charcoal grey hoodie, torn at the shoulder, soot-stained",
    referenceImage: "refs/characters/aras-kanli.png",
    referencePrompt: `Photorealistic portrait, ${ARAS_FACE}, blood streaks from the hairline, soot, torn charcoal hoodie, calm unblinking stare, dim yellow corridor light, 50mm, film grain`,
  },
  arasCocuk: {
    id: "arasCocuk",
    name: "Küçük Aras (kurtarılan)",
    role: "11 yaşındaki Aras — yangın gecesi babasının kucağında dışarı taşınan çocuk.",
    identity: "11-year-old Turkish boy, thin, dark messy hair, dark brown eyes, the same facial structure as adult Aras, small pale scar above the left eyebrow",
    wardrobe: "navy blue and white striped pyjama top",
    referenceImage: "refs/characters/aras-cocuk.png",
    referencePrompt: "Photorealistic portrait of an 11-year-old Turkish boy, thin, dark messy hair, dark brown eyes, small scar above left eyebrow, navy and white striped pyjamas, 2009 home photo look, soft flash",
  },
  cocuk13: {
    id: "cocuk13",
    name: "13 Numaradaki Çocuk",
    role: "Yangından kurtarılamayan çocuk. Kendini 'gerçek Aras' olarak tanıtır. Vücudunda hiç yanık izi yok.",
    identity: "11-year-old Turkish boy, identical to young Aras but with NO scar, very pale clean skin, dark messy hair, still dark eyes that rarely blink",
    wardrobe: "the same navy blue and white striped pyjama top, perfectly clean despite the fire",
    referenceImage: "refs/characters/cocuk-13.png",
    referencePrompt: "Photorealistic portrait of an 11-year-old Turkish boy, very pale clean skin, no scars, dark messy hair, still dark eyes, clean navy and white striped pyjamas, standing in darkness lit by a single warm bulb",
  },
  baba: {
    id: "baba",
    name: "Kemal Yalçın",
    role: "Aras'ın babası, 62. Fizikçi. Kasım 2026'da öldüğü sanılır; aslında bodrumdaki gizli odada deneyi sürdürmektedir.",
    identity: "62-year-old Turkish man, thin and slightly stooped, short grey beard, receding grey hair, round wire-rimmed glasses, hollow cheeks, tired grey-brown eyes",
    wardrobe: "worn brown wool cardigan over a white shirt, grey trousers",
    referenceImage: "refs/characters/baba.png",
    referencePrompt: "Photorealistic portrait of a 62-year-old Turkish physicist, short grey beard, round wire glasses, hollow cheeks, brown wool cardigan, lit by the green glow of old CRT monitors, 85mm, film grain",
  },
  anne: {
    id: "anne",
    name: "Selma Yalçın",
    role: "Aras'ın annesi, 55. İzmir'de yaşıyor. Bu gerçeklikte Aras'ı hiç doğurmamış gibi davranıyor.",
    identity: "55-year-old Turkish woman, short chestnut hair, reading glasses on a chain, warm but tired face",
    wardrobe: "beige knit sweater",
    referenceImage: "refs/characters/anne.png",
    referencePrompt: "Photorealistic portrait of a 55-year-old Turkish woman, short chestnut hair, reading glasses on a chain, beige knit sweater, kitchen at dusk",
  },
  nermin: {
    id: "nermin",
    name: "Nermin Hanım",
    role: "Daire 8'in sahibi, 9 Mart 2023'te ölen komşu. Sabahları kahvaltı getirir.",
    identity: "74-year-old Turkish woman, kind round face with deep wrinkles, loosely tied white floral headscarf, milky pale eyes",
    wardrobe: "knitted burgundy cardigan, long dark skirt, house slippers",
    referenceImage: "refs/characters/nermin.png",
    referencePrompt: "Photorealistic portrait of a 74-year-old Turkish grandmother, white floral headscarf loosely tied, burgundy knitted cardigan, holding a tray with simit, cheese and tea, standing in a dim apartment doorway, slightly too still",
  },
  memur: {
    id: "memur",
    name: "Nüfus/Belediye Memuru",
    role: "Belediye arşivinde Aras'ın ölüm kaydını bulan memur.",
    identity: "45-year-old Turkish clerk, moustache, tired eyes, receding hairline",
    wardrobe: "pale blue shirt, dark tie, lanyard",
    referenceImage: "refs/characters/memur.png",
    referencePrompt: "Photorealistic Turkish municipal clerk, 45, moustache, pale blue shirt, behind a counter with an old computer, fluorescent office light",
  },
  arasYasli: {
    id: "arasYasli",
    name: "Yaşlı Aras",
    role: "Monitörlerde ve koridorlarda görülen 70 yaşındaki Aras versiyonu.",
    identity: `${ARAS_FACE}, aged to 70 years old, white stubble, deep wrinkles, the same scar above the left eyebrow`,
    wardrobe: "old brown cardigan like his father's",
    referenceImage: "refs/characters/aras-yasli.png",
    referencePrompt: `Photorealistic portrait of the same man aged 70, ${ARAS_FACE}, white stubble, deep wrinkles, old brown cardigan`,
  },
  arasEvli: {
    id: "arasEvli",
    name: "Evli Aras",
    role: "Alternatif gerçeklikte evli ve mutlu Aras.",
    identity: `${ARAS_FACE}, healthier, clean shaven, wedding ring`,
    wardrobe: "white shirt, sleeves rolled",
    referenceImage: "refs/characters/aras-evli.png",
    referencePrompt: `Photorealistic portrait, ${ARAS_FACE}, clean shaven, warm smile, white shirt, wedding ring, warm kitchen light`,
  },
  sakinler: {
    id: "sakinler",
    name: "Apartman Sakinleri",
    role: "Deneyin farklı tekrarlarından kalan komşular.",
    identity: "several Turkish apartment residents of different ages, faces pale and expressionless, clothes from different decades",
    wardrobe: "1970s to 2020s mixed home clothes",
    referenceImage: "refs/characters/sakinler.png",
    referencePrompt: "Photorealistic group of Turkish apartment residents standing still in a narrow stairwell, clothes from different decades, pale expressionless faces",
  },
};

export type Location = { id: LocationId; name: string; prompt: string; referenceImage: string };

export const LOCATIONS: Record<LocationId, Location> = {
  daire7Salon: {
    id: "daire7Salon",
    name: "Daire 7 — salon",
    prompt: "small old Turkish apartment living room from the 1970s, yellowed wallpaper with faded pattern, dark wooden cabinet with glass doors, crocheted doilies, half-unpacked cardboard boxes, a round wall clock, cold blue streetlight through net curtains",
    referenceImage: "refs/locations/daire7-salon.png",
  },
  daire7Yatak: {
    id: "daire7Yatak",
    name: "Daire 7 — yatak odası",
    prompt: "cramped old Turkish bedroom, single bed with grey blanket, yellowed plaster walls with hairline cracks, old wooden wardrobe, bare bulb, moving boxes, cold moonlight",
    referenceImage: "refs/locations/daire7-yatak.png",
  },
  daire7Banyo: {
    id: "daire7Banyo",
    name: "Daire 7 — banyo",
    prompt: "small old Turkish bathroom, pale green 1970s tiles, chipped sink, oval mirror with blackened edges, a buzzing tube light above the mirror",
    referenceImage: "refs/locations/daire7-banyo.png",
  },
  daire7Kapi: {
    id: "daire7Kapi",
    name: "Daire 7 — giriş kapısı (içeriden)",
    prompt: "inside view of an old dark-brown wooden Turkish apartment front door with a brass peephole and a chain lock, a thin strip of yellow corridor light under the door, a narrow hallway with a coat hook",
    referenceImage: "refs/locations/daire7-kapi.png",
  },
  koridor3: {
    id: "koridor3",
    name: "3. kat koridoru",
    prompt: "narrow old Turkish apartment corridor, yellowed walls, worn mosaic terrazzo floor, dark wooden doors with brass numbers, a flickering fluorescent tube, stairwell railing at the end",
    referenceImage: "refs/locations/koridor3.png",
  },
  merdiven: {
    id: "merdiven",
    name: "Merdiven boşluğu",
    prompt: "dark spiral stairwell of an old Istanbul apartment, worn marble steps, iron railing, timer light switch glowing orange, peeling paint",
    referenceImage: "refs/locations/merdiven.png",
  },
  giris: {
    id: "giris",
    name: "Apartman girişi",
    prompt: "old Istanbul apartment entrance hall, metal mailboxes, a cheap DVR security monitor in a wall cabinet, cracked marble floor",
    referenceImage: "refs/locations/giris.png",
  },
  daire13: {
    id: "daire13",
    name: "Daire 13",
    prompt: "an apartment frozen in 2009, soot-blackened walls, a child's room with crayon drawings, a single warm bulb, everything covered in fine ash yet a small bed perfectly clean",
    referenceImage: "refs/locations/daire13.png",
  },
  bodrum: {
    id: "bodrum",
    name: "Bodrum",
    prompt: "damp old apartment basement, coal storage, pipes, a single caged bulb, wet concrete floor, a steel door painted grey",
    referenceImage: "refs/locations/bodrum.png",
  },
  gizliOda: {
    id: "gizliOda",
    name: "Gizli kayıt odası",
    prompt: "hidden basement control room full of old CRT monitors stacked on metal shelves, VHS recorders, reel-to-reel tape machines, tangled cables, green and blue screen glow, hand-written labels with dates",
    referenceImage: "refs/locations/gizli-oda.png",
  },
  camBolme: {
    id: "camBolme",
    name: "Cam bölme",
    prompt: "a thick glass observation partition at the back of the basement control room, a dim room behind it with a single chair and a desk covered in notebooks",
    referenceImage: "refs/locations/cam-bolme.png",
  },
  kayipKat: {
    id: "kayipKat",
    name: "Kayıp kat",
    prompt: "a completely burned apartment floor, charred walls, melted door numbers, ash on the floor, smoke stains on the ceiling, a 2009 newspaper on the floor",
    referenceImage: "refs/locations/kayip-kat.png",
  },
  asansor: {
    id: "asansor",
    name: "Asansör",
    prompt: "tiny old Turkish elevator cabin with folding inner door, wooden panels, mirror, mechanical floor buttons, flickering light",
    referenceImage: "refs/locations/asansor.png",
  },
  belediye: {
    id: "belediye",
    name: "Belediye arşivi",
    prompt: "Turkish municipal records office, metal filing cabinets, fluorescent light, old CRT computer, stacks of folders",
    referenceImage: "refs/locations/belediye.png",
  },
  yanginGecesi: {
    id: "yanginGecesi",
    name: "Yangın gecesi (2009)",
    prompt: "the same apartment building on fire at night in 2009, orange flames in a third-floor window, smoke in the stairwell, firefighters' lights, low quality 2009 camcorder footage",
    referenceImage: "refs/locations/yangin-gecesi.png",
  },
  normalEv: {
    id: "normalEv",
    name: "Normal ev (final)",
    prompt: "a clean, bright, ordinary modern apartment bedroom at dawn, white walls, soft morning light, everything calm and normal",
    referenceImage: "refs/locations/normal-ev.png",
  },
};

/** Tüm görsel üretim promptlarına eklenen sinematografi stili. */
export const VISUAL_STYLE = {
  positive:
    "photorealistic cinematic film still, vertical 9:16 composition, shot on ARRI Alexa with anamorphic lenses, cold desaturated teal and sodium-yellow palette, natural motivated practical lighting, deep shadows, shallow depth of field, subtle 35mm film grain, realistic skin texture, slow deliberate camera, Turkish psychological horror series",
  negative:
    "cartoon, anime, 3d render, CGI look, plastic skin, oversaturated, text, watermark, logo, subtitles, extra fingers, deformed face, jump-cut, fast motion, bright cheerful lighting",
} as const;

/** Ses profilleri: Piper modeli + ffmpeg filtre zinciri. */
export type VoiceProfile = {
  voice: "tr_TR-fahrettin-medium" | "tr_TR-fettah-medium" | "tr_TR-dfki-medium";
  lengthScale: number;
  noiseScale?: number;
  noiseW?: number;
  /** perde çarpanı (1 = değişmez). asetrate+atempo ile hız korunur */
  pitch: number;
  /** ek ffmpeg -af filtreleri (perde ayarından sonra) */
  filters: string[];
  gainDb: number;
  label: string;
  /** cümleler arası sessizlik (sn) */
  sentencePause?: number;
};

const PHONE_BAND = ["highpass=f=320", "lowpass=f=3300", "acompressor=threshold=-20dB:ratio=4", "volume=1.4"];
const ROOM_VERB = ["aecho=0.8:0.55:38|71:0.18|0.10"];
const DOOR_MUFFLE = ["lowpass=f=1300", "aecho=0.8:0.6:24|53:0.35|0.22", "volume=1.6"];

export const VOICES: Record<SpeakerId, VoiceProfile> = {
  anlatici: { voice: "tr_TR-fahrettin-medium", lengthScale: 1.28, sentencePause: 0.55, noiseScale: 0.55, pitch: 0.94, filters: ["lowpass=f=8000", "acompressor=threshold=-18dB:ratio=3", ...ROOM_VERB], gainDb: 0, label: "Aras (iç ses / anlatıcı)" },
  aras: { voice: "tr_TR-fahrettin-medium", lengthScale: 1.2, sentencePause: 0.45, noiseScale: 0.6, pitch: 0.95, filters: ["acompressor=threshold=-18dB:ratio=3", ...ROOM_VERB], gainDb: 0, label: "Aras" },
  arasKayit: { voice: "tr_TR-fahrettin-medium", lengthScale: 1.18, sentencePause: 0.5, noiseScale: 0.7, pitch: 0.95, filters: [...PHONE_BAND, "acrusher=bits=10:mix=0.25"], gainDb: -1, label: "Aras (ses kaydı)" },
  arasKapi: { voice: "tr_TR-fahrettin-medium", lengthScale: 1.4, sentencePause: 0.7, noiseScale: 0.4, pitch: 0.86, filters: DOOR_MUFFLE, gainDb: 0, label: "Kapıdaki Aras" },
  yansima: { voice: "tr_TR-fahrettin-medium", lengthScale: 1.45, sentencePause: 0.6, noiseScale: 0.4, pitch: 0.84, filters: ["aecho=0.8:0.7:90|180:0.35|0.25", "lowpass=f=5000"], gainDb: 0, label: "Yansıma" },
  arasYasli: { voice: "tr_TR-fettah-medium", lengthScale: 1.35, sentencePause: 0.6, noiseScale: 0.5, pitch: 0.88, filters: [...ROOM_VERB], gainDb: 0, label: "Yaşlı Aras" },
  cocuk: { voice: "tr_TR-dfki-medium", lengthScale: 1.3, sentencePause: 0.55, noiseScale: 0.45, pitch: 1.24, filters: ["aecho=0.8:0.75:60|130:0.3|0.2", "lowpass=f=6500"], gainDb: -1, label: "Çocuk (13)" },
  baba: { voice: "tr_TR-fettah-medium", lengthScale: 1.25, sentencePause: 0.5, noiseScale: 0.55, pitch: 0.9, filters: [...ROOM_VERB], gainDb: 0, label: "Kemal Yalçın (baba)" },
  babaTelefon: { voice: "tr_TR-fettah-medium", lengthScale: 1.25, sentencePause: 0.5, noiseScale: 0.55, pitch: 0.9, filters: PHONE_BAND, gainDb: 0, label: "Baba (telefon/kayıt)" },
  anneTelefon: { voice: "tr_TR-dfki-medium", lengthScale: 1.18, sentencePause: 0.45, noiseScale: 0.6, pitch: 0.97, filters: PHONE_BAND, gainDb: 0, label: "Selma Yalçın (telefon)" },
  nermin: { voice: "tr_TR-dfki-medium", lengthScale: 1.35, sentencePause: 0.5, noiseScale: 0.45, pitch: 0.9, filters: ["tremolo=f=5:d=0.12", ...ROOM_VERB], gainDb: 0, label: "Nermin Hanım" },
  memur: { voice: "tr_TR-fettah-medium", lengthScale: 1.1, sentencePause: 0.35, noiseScale: 0.6, pitch: 1.0, filters: ["aecho=0.8:0.4:20|40:0.1|0.06"], gainDb: 0, label: "Memur" },
};
