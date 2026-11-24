# Karakter referans sesleri (Trendyol-TTS klonlama)

Her `.wav` bir karakterin sabit referansıdır; metni `src/series/bible.ts` → `VOX` içinde
(`refText`) tutulur ve **kaydın birebir dökümü olmak zorundadır** (devam modu bunu kullanır).

| Dosya | Kaynak |
|---|---|
| `hikaye.wav`, `benGenc.wav`, `mustafa.wav`, `ercan.wav`, `ercanCin.wav`, `gokhan.wav` | Trendyol-TTS "ses tasarımı" ile bu projede üretildi |
| `ercanAnne.wav` | [Boran-Sert/Turkish-TTS](https://github.com/Boran-Sert/Turkish-TTS) `voices/kadın.wav` (Apache-2.0) |

Bir sesi değiştirmek için dosyayı silin: `prepare` bir sonraki çalışmada `VOX[speaker].design`
tarifiyle yenisini üretir. Kendi kaydınızı koyarsanız `refText`'i dökümüyle güncelleyin.
