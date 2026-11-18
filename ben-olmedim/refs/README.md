# Tutarlılık referansları

Yapay zekâ üretiminde karakterlerin her bölümde aynı yüzle görünmesi için buraya
**referans görselleri** konur. Dosya adları `src/series/bible.ts` içindeki
`referenceImage` alanlarıyla birebir aynı olmalıdır:

| Dosya | Karakter / mekân |
|---|---|
| `characters/aras.png` | Aras Yalçın (28) — ana yüz kimliği |
| `characters/aras-kanli.png` | Kapıdaki kanlı Aras |
| `characters/aras-cocuk.png` | 11 yaşındaki Aras (kaşında yara izi **var**) |
| `characters/cocuk-13.png` | 13 numaradaki çocuk (yara izi **yok**) |
| `characters/baba.png` | Kemal Yalçın (62) |
| `characters/anne.png` | Selma Yalçın (55) |
| `characters/nermin.png` | Nermin Hanım (74) |
| `characters/memur.png` | Belediye memuru |
| `characters/aras-yasli.png` / `aras-evli.png` | Alternatif Aras'lar |
| `characters/sakinler.png` | Apartman sakinleri |
| `locations/*.png` | Mekân referansları (`bible.ts` → `LOCATIONS`) |

Önerilen sıra: önce `reports/eXX.md` dosyalarındaki **Referans promptu** ile
`aras.png`'yi üretin/seçin, diğer Aras versiyonlarını bu görselden türetin
(aynı yüz, farklı yaş/yara/kıyafet). Medya servisi, sahnedeki ilk karakterin
referansını `start_image` / `image_url` olarak gönderir.
