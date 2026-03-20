# Jobs Portal

Laravel 10 + PHP 8.2 tabanlı iş ilanları, firma yönetimi, ev/hizmet talepleri, CRM ve personel otomasyonu içeren portal projesi.

---

## Hızlı Kurulum

1. **Projeyi klonlayın**
   ```bash
   git clone https://github.com/madhadess/jobsportal.git
   cd jobsportal
   ```

2. **Bağımlılıklar**
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

3. **Veritabanı**
   - MySQL'de `jobsportal` adında veritabanı oluşturun.
   - `database/jobsportal_guncel.sql` dosyasını import edin (phpMyAdmin veya `mysql` komutu).

4. **Ortam ayarları**
   - `.env` içinde `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` değerlerini kendi MySQL bilgilerinize göre düzenleyin.

5. **Storage ve çalıştırma**
   ```bash
   php artisan storage:link
   php artisan optimize:clear
   php artisan serve
   ```
   Tarayıcıda: **http://127.0.0.1:8000**  
   Admin: **http://127.0.0.1:8000/admin/login**

---

## Gereksinimler

| Bileşen      | Sürüm        |
|-------------|--------------|
| PHP         | 8.2+         |
| Laravel     | 10.x         |
| MySQL       | 8+ / MariaDB |
| Composer    | 2.x          |
| Node.js/npm | (frontend için) |

**PHP eklentileri:** `bcmath`, `ctype`, `curl`, `fileinfo`, `gd`, `json`, `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `zip`

**Sunucu:** Apache (mod_rewrite) veya Nginx; yerelde `php artisan serve` yeterli.

---

## Veritabanı Kurulumu

### .env ayarları

`.env.example` dosyasını `.env` olarak kopyalayıp aşağıdaki alanları doldurun:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobsportal
DB_USERNAME=root
DB_PASSWORD=your_password
```

- **Yerel WAMP/XAMPP:** Genelde `DB_USERNAME=root`, `DB_PASSWORD=` (boş).
- **Canlı sunucu:** Hosting panelinden verilen veritabanı adı, kullanıcı ve şifreyi yazın.

### SQL import

**Komut satırı (MySQL client yüklüyse):**
```bash
mysql -u root -p jobsportal < database/jobsportal_guncel.sql
```

**phpMyAdmin:**
1. Yeni veritabanı: `jobsportal`
2. **Import** → `database/jobsportal_guncel.sql` dosyasını seçin → Go

Import sonrası tablolar hazır; ekstra migration çalıştırmanız gerekmez (dump güncel yapıyı içerir).

---

## Proje Yapısı (Önemli Dosyalar)

| Dosya / Klasör | Açıklama |
|----------------|----------|
| `.env.example` | Örnek ortam değişkenleri (`.env` bunu kopyalayarak oluşturulur) |
| `.env` | Gerçek ayarlar (Git’e **eklenmez**) |
| `database/jobsportal_guncel.sql` | Güncel veritabanı dump’ı – kurulumda import edilir |
| `storage/app/backup/` | `php artisan db:export` ile alınan yedekler (Git’e eklenmez) |
| `app/Console/Commands/ExportDatabase.php` | `php artisan db:export` komutu |

---

## Ortam Değişkenleri (.env)

### Zorunlu

- `APP_NAME` – Uygulama adı  
- `APP_ENV` – Ortam (local, production)  
- `APP_KEY` – `php artisan key:generate` ile üretilir  
- `APP_DEBUG` – true/false  
- `APP_URL` – Site adresi (örn. `http://localhost/jobsportal` veya `https://site.com`)  
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

### İsteğe bağlı (entegrasyonlar)

- **Ödeme:** Stripe, PayPal, Razorpay, PayU  
- **Mail:** SMTP ayarları (MAIL_*), Mailchimp  
- **reCAPTCHA:** NOCAPTCHA_SECRET, NOCAPTCHA_SITEKEY  
- **PDF:** WKHTMLTOPDF_BINARY, WKHTMLTOIMAGE_BINARY  
- **Windows’ta DB export:** `MYSQLDUMP_PATH=C:\wamp64\bin\mysql\mysql8.4.7\bin\mysqldump.exe`

Bu alanların bir kısmı admin panelinden de yönetilebilir.

---

## Veritabanı Yedekleme (Export)

Güncel SQL dump almak için:

```bash
php artisan db:export
```

Dump `storage/app/backup/` altına kaydedilir.  
Windows’ta `mysqldump` PATH’te yoksa `.env` içine `MYSQLDUMP_PATH` ekleyin (yol örneği yukarıda).

---

## Zip Dosyaları

**`.gitignore`** nedeniyle `*.zip` dosyaları repoda **yer almaz** ve GitHub’a yüklenmez. Bu isteyerek yapılmıştır (repo boyutunu ve gereksiz arşivleri önlemek için).

Yerelde projeyi zip’lemek isterseniz:

```bash
php zip_project.php
```

Oluşan zip dosyası repoya commit edilmez.

---

## Admin Girişi

- **URL:** `http://localhost/jobsportal/admin/login` (veya kullandığınız `APP_URL` + `/admin/login`)
- Kullanıcılar veritabanında; şifreler hash’li olduğu için doğrudan README’de verilemez.  
  SQL dump içindeki test hesapları veya kendi oluşturduğunuz admin kullanıcıları kullanın.

---

## Sorun Giderme

| Sorun | Çözüm |
|-------|--------|
| `php artisan` veritabanı hatası | `.env` içindeki DB_* değerlerini kontrol edin; yerelde çalışan MySQL kullanıcı/şifre ile eşleşmeli. |
| Tablo zaten var / migration hatası | Kurulumu SQL dump ile yaptıysanız `php artisan migrate` çalıştırmayın; dump yeterli. |
| Asset’ler (CSS/JS) yüklenmiyor | `npm install` ve `npm run dev` (veya `npm run build`) çalıştırın. |
| 500 / storage hatası | `php artisan storage:link`, `php artisan optimize:clear`; `storage/` ve `bootstrap/cache/` yazılabilir olmalı. |

---

## Güvenlik

- **`.env`** dosyasını asla GitHub’a eklemeyin (zaten `.gitignore`’da).
- Gerçek API anahtarlarını ve veritabanı şifrelerini README veya kod içine yazmayın.
- Canlı ortamda `APP_DEBUG=false` ve `APP_ENV=production` kullanın.

---

## Lisans

MIT (Laravel varsayılanı).
