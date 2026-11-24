# BEN ÖLMEDİM — 30 bölümlük sinematik korku dizisi üretim hattı

Dikey (1080×1920, 9:16) Instagram Reels / TikTok / YouTube Shorts için, birbirine bağlı
30 bölümlük psikolojik korku dizisini **tek projeden** yöneten Remotion + TypeScript altyapısı.

- 30 bölümün tam senaryosu, sahne sahne (`src/series/episodes/act1..3.ts`) — okunabilir hali: [`reports/SENARYO.md`](reports/SENARYO.md)
- Karakter / mekân / zaman çizelgesi / görsel stil / ses profilleri tek yerde: [`src/series/bible.ts`](src/series/bible.ts)
- Türkçe seslendirme **yerelde ve ücretsiz** (Piper TTS, üç Türkçe ses, karakter başına filtre zinciri)
- Seslendirme süreleri ölçülür, sahne/replik/efekt/altyazı zamanlaması otomatik hesaplanır (45–60 sn kontrolü)
- Özgün, matematiksel olarak sentezlenmiş efekt ve ortam sesleri — lisans sorunu yok
- Fotogerçekçi sahneler için yapay zekâ video/görsel servis katmanı (Replicate, fal.ai), prompt önbelleği
- Anahtar yoksa **hiçbir şey üretilmiş gibi gösterilmez**: eksik medya raporlanır, video "animatik" olarak render edilir

## Kurulum

```bash
cd ben-olmedim
npm install
pip install piper-tts numpy soundfile    # Python 3.10+
npm run setup                             # Türkçe ses modellerini indirir + efektleri sentezler
```

Gereken araçlar: Node 20+, Python 3.10+, `ffmpeg`/`ffprobe`.

## Komutlar

| Komut | Ne yapar |
|---|---|
| `npm run validate` | 30 bölümün senaryo verisini doğrular (kelime sayısı, eksik görsel vb.) |
| `npm run prepare:ep -- 1` | Seslendirme → süre ölçümü → zamanlama → `public/manifests/e01.json` + `reports/e01.md` + `out/*.srt` |
| `npm run media -- 1-5` | Sağlayıcı yapılandırılmışsa eksik yapay zekâ kliplerini üretir; değilse yalnızca raporlar |
| `npm run render -- 1` | MP4 render (`out/BEN_OLMEDIM_B01[_ANIMATIK].mp4`) |
| `npm run render -- 1 --final` | Yalnızca bütün AI medyası hazırsa render eder (yayın kopyası) |
| `npm run build:ep -- all` | prepare + media + render, toplu (`1`, `3-7`, `1,4,9`, `all`) |
| `npm run report` | Sezon durum tablosu → `reports/README.md` |
| `npm run screenplay` | Okunabilir sezon senaryosu → `reports/SENARYO.md` |
| `npm run studio` | Remotion Studio (B01…B30 kompozisyonları, kare kare önizleme) |
| `npm test` / `npm run typecheck` | Testler / TypeScript kontrolü |

Render bayrakları: `--no-subs` (altyazısız), `--clean` (animatik etiketsiz), `--force-tts` (sesleri yeniden üret).

## Mimari

```
src/
  series/
    bible.ts          karakter kimlikleri, mekânlar, TIMELINE, VISUAL_STYLE, VOICES
    types.ts          senaryo + manifest tipleri
    dsl.ts            scene()/episode()/vid()/img() yazım yardımcıları
    episodes/act1-3   30 bölümün sahneleri, replikleri, efekt ve ortam ipuçları, AI promptları
  pipeline/
    timeline.ts       ölçülmüş süreler → kareler, 45 sn'ye gerilim ağırlıklı dolgu, altyazı, SRT
    prompts.ts        sahne → tam üretim promptu (stil + karakter kimliği + mekân + çekim dili)
    audio.ts          ortam sesi parçalarını sahneler arası birleştirme
  components/
    Episode.tsx       bölüm: sahneler, VO, SFX, ortam, altyazı, renk/gren/vinyet, kapanış kartı
    Scene.tsx         kamera hareketleri (push-in, handheld, tilt…), geçişler, medya/katman seçimi
    inserts/          prosedürel katmanlar: telefon ekranı, duvar saati, kapı, dürbün, CCTV,
                      belge/gazete/defter/kimlik/plan, koridor, monitör duvarı, ayna, duvar, asansör
scripts/
  cli.ts              komutlar
  lib/tts.ts          Piper → ffmpeg karakter işleme → loudnorm, metin+profil özetli önbellek
  lib/media.ts        Replicate / fal.ai sağlayıcıları, prompt-özet önbelleği, eksik medya durumu
  lib/render.ts       Remotion bundle + renderMedia + -14 LUFS ses normalizasyonu
  lib/report.ts       storyboard raporu, doğrulama, eksik medya listesi
  tts/synth.py        Piper sentezi (cümle arası dramatik duraklamalar)
  sfx/generate_sfx.py 26 efekt + 8 ortam sesi sentezi
```

### Sahne nasıl görüntülenir?

Her sahnede iki katman tanımlıdır:

1. **`media`** — fotogerçekçi yapay zekâ klibi/karesi için prompt. Dosya
   `public/media/eXX/eXXsYY.mp4` (veya `.png/.jpg`) olarak bulunursa kullanılır.
   Elle üretip bu adla koymanız da yeterlidir.
2. **`insert`** — Remotion içinde çizilen katman (telefon ekranı, saat, CCTV arayüzü, belge…).
   Medya yoksa yerine geçer; `overlayInsert` ile medyanın üstüne de bindirilebilir.
   Telefon, saat, belge, CCTV gibi sahneler zaten tamamen prosedüreldir (AI gerektirmez).

Medyası eksik sahneler render'da küçük bir **"ANİMATİK · eXXsYY · AI klip bekleniyor"**
etiketi taşır (`--clean` ile kaldırılır). `--final` eksik varken render'ı reddeder.

### Maliyet azaltma

- Seslendirme: metin + ses profili özeti aynıysa yeniden sentezlenmez.
- Görsel/video: tam prompt özeti `.cache/media-index.json`'da tutulur; aynı prompt ikinci kez
  ücretlendirilmez, başka sahneye kopyalanır. Sadece senaryosu değişen sahne yeniden üretilir.
- `reports/missing-media.json` tüm sezonun eksik kliplerini, hedef dosya adları, süreleri,
  promptları ve gereken referans görselleriyle listeler — toplu üretim için doğrudan kullanılabilir.

### Karakter tutarlılığı

`bible.ts` içindeki `identity` metni her promptta birebir tekrarlanır; `refs/` altındaki
referans görselleri (bkz. [`refs/README.md`](refs/README.md)) sağlayıcıya başlangıç/referans
görseli olarak gönderilir. Aras'ın farklı versiyonları aynı yüz tanımından türetilir
(yaş, kan, kıyafet farkı; yara izi kuralı: kurtarılan Aras'ta **var**, 13'teki çocukta **yok**).

## Senaryo düzenleme

Bir bölümü değiştirmek için ilgili `act*.ts` dosyasında sahneyi düzenleyin, sonra:

```bash
npm run prepare:ep -- 7      # sadece değişen replikler yeniden seslendirilir
npm run render -- 7
```

Süre 60 sn'yi aşarsa `prepare` hata verir; 45 sn'nin altındaysa en gergin sahnelere nefes payı eklenir.

## Ses tasarımı

| Katman | Kaynak |
|---|---|
| Anlatıcı / Aras | Piper `tr_TR-fahrettin-medium`, perde −1 yarım ton, oda yankısı, yavaş tempo |
| Ses kaydı | aynı ses + telefon bandı (320–3300 Hz) + bit kırma |
| Kapıdaki Aras / yansıma | perde düşürülmüş, boğuk (kapı arkası) ya da uzun yankılı |
| Çocuk | `tr_TR-fettah-medium`, perde +5 yarım ton (~260 Hz), uzak yankı |
| Anne / Nermin | `tr_TR-fettah-medium`, perde +2–3 yarım ton (anne telefon bandında, Nermin titrek ve yavaş) |
| Baba | `tr_TR-fettah-medium`, perde −3 yarım ton (telefon/kaset versiyonu bant filtreli) |
| Efektler | `knock3`, `phoneVibrate`, `heartbeat`, `hitLow`, `suddenSilence`… (sentez) |
| Ortam | oda tonu, floresan vızıltısı, koridor uğultusu, düşük gerilim, bodrum, yangın… |

Sahnede `silence: true` → bütün ortam sesleri kesilir (korkunun en güçlü anları için).
Çıktı −14 LUFS / −1,5 dBTP'ye normalize edilir.

## Özel bölümler — "KAPI. TAVAN." (izleyici hikâyesi, ~3 dk, 2D animasyon)

`src/series/specials/kapiTavan.ts` — diziden bağımsız, karakterli 2D animasyon bölümü.

```bash
# doğal ses (Trendyol-TTS) ile hazırla + render al
TTS_ENGINE=voxcpm TTS_VOXCPM_PYTHON=/home/user/tts-venv/bin/python npm run prepare:ep -- kapi-tavan
npm run render -- kapi-tavan --clean          # out/KAPI_TAVAN.mp4
```

### 2D animasyon karakterleri (`src/components/toon/`)

- `Character.tsx` — SVG iskelet: omuz/dirsek/kalça/diz açılarıyla pozlar (`stand`, `dance`, `sit`,
  `sitFloor`, `lie`, `point`, `armsOut`, `grab`, `walk`, `handsFace`, `phone`), yüz ifadeleri
  (`smile`, `creepy`, `scared`, `shout`, `cry`, `possessed`…), otomatik göz kırpma, nefes alma.
  Karakter görünümleri `LOOKS` içinde (saç, ten, kıyafet, yapı).
- Ağız senkronu: her repliğin ses dalgasından kare başına zarf çıkarılır (`scripts/lib/tts.ts → envelope`);
  `speaks: ["mustafa"]` olan karakterin ağzı o repliklerde sese göre açılır.
- `Stage.tsx` — dekorlar ve ışık: `party`, `living`, `candles`, `street`, `doorway`, `police`,
  `bedroom`, `glass`, `doorCeiling`, `hallway`.
- Sahne olayları repliklere bağlanır: `"E2"` = 3. replik bitince, `"L1+2.5"` = 2. replik başlayınca
  2,5 sn sonra (`poseAt`, `exprAt`, `appearAt`, `vanishAt`, `moveTo`).

### Doğal Türkçe ses: Trendyol-TTS (VoxCPM2, MIT)

Piper yerine gerçek insana yakın ses için [Boran-Sert/Turkish-TTS](https://github.com/Boran-Sert/Turkish-TTS)
paketi ve Trendyol'un MIT lisanslı ağırlıkları kullanılır. GPU önerilir; CPU'da ~5× gerçek zaman çalışır.

```bash
python3 -m venv /home/user/tts-venv
/home/user/tts-venv/bin/pip install torch torchaudio --index-url https://download.pytorch.org/whl/cpu
git clone https://github.com/Boran-Sert/Turkish-TTS && /home/user/tts-venv/bin/pip install -e Turkish-TTS faster-whisper
```

- Her karakterin sesi `voices/<konuşan>.wav` referansından klonlanır (bkz. [`voices/README.md`](voices/README.md));
  referans yoksa `bible.ts → VOX[...].design` tarifiyle bir kez tasarlanır.
- Her replik faster-whisper ile geri yazıya çevrilir; duyulan sözcük oranı %88'in altındaysa
  replik yeniden üretilir (en fazla 3 deneme) — bozuk/yutulmuş Türkçe çıkmaz.
- Gerekli ağ erişimi: `huggingface.co`, `us.aws.cdn.hf.co` (model indirme), `download(-r2).pytorch.org`.

## Lisanslar

- Piper Türkçe ses modelleri: `tr_TR-fahrettin-medium` ve `tr_TR-fettah-medium` **CC0** — varsayılan
  profiller yalnızca bunları kullanır, ticari paylaşım serbesttir.
- `tr_TR-dfki-medium` (gerçek kadın sesi) **CC BY-NC-SA 4.0 — ticari kullanım yasak**. Yalnızca
  `TTS_ALLOW_NC=1 npm run setup:voices` ve `TTS_ALLOW_NC=1 npm run prepare:ep -- N` ile, ticari
  olmayan kullanım için açılır (`bible.ts` → `NC_VOICE_OVERRIDES`).
- Daha doğal sesler için ticari bir Türkçe TTS (ör. ElevenLabs, Azure) `scripts/lib/tts.ts`
  içindeki sentez adımına eklenebilir; zamanlama hattı ses kaynağından bağımsızdır.
- Trendyol-TTS ağırlıkları: MIT; Turkish-TTS paketi ve `voices/ercanAnne.wav` (repo içindeki `kadın.wav`): Apache-2.0.
- Fontlar: Inter, JetBrains Mono, Liberation Serif (SIL OFL) — `public/fonts`.
- Efekt ve ortam sesleri bu projede sentezlenir.
