<?php

namespace App\Services;

class UrlMapperService
{
    /**
     * Map a URL path to a human-readable name.
     *
     * @param string $path
     * @return string
     */
    public static function getFriendlyName($path)
    {
        // Parse URL to get path only
        $parsedUrl = parse_url($path);
        $path = $parsedUrl['path'] ?? $path;

        // Remove 'admin/' prefix if present
        $cleanPath = str_replace('admin/', '', $path);

        // Remove job portal prefix if matches localhost context
        $cleanPath = str_replace('/jobsportal/', '', $cleanPath); // Hardcoded fix for screenshot context
        $cleanPath = str_replace('jobsportal/', '', $cleanPath);

        // Remove 'admin/' again just in case
        $cleanPath = str_replace('admin/', '', $cleanPath);

        // Ensure no leading slash
        $cleanPath = ltrim($cleanPath, '/');

        // Remove query parameters (already done by parse_url for full URLs, but safety net for partials)
        $cleanPath = strtok($cleanPath, '?');

        // Direct mappings
        $mappings = [
            'home' => 'Kontrol Paneli (Anasayfa)',
            'crm' => 'Personel Takip Ekranı',
            'crm/get-my-notifications' => 'Bildirim Kontrolü',
            'security' => 'Güvenlik Merkezi',
            'profile' => 'Profil Ayarları',

            // Admin User Management
            'list-admin-users' => 'Yönetici Kullanıcılar Listesi',
            'fetch-admin-users' => 'Yönetici Kullanıcılar Listesi',
            'create-admin-user' => 'Yeni Yönetici Ekleme',
            'store-admin-user' => 'Yönetici Ekleme',
            'edit-admin-user' => 'Yönetici Düzenleme',
            'update-admin-user' => 'Yönetici Güncelleme',
            'delete-admin-user' => 'Yönetici Silme',

            // Services Module
            'services' => 'Hizmetler',
            'service-categories' => 'Hizmet Kategorileri',
            'service-addons' => 'Ek Hizmetler',
            'service-requests' => 'Hizmet Talepleri',
            'service-add-ons' => 'Ek Hizmetler',

            'cms' => 'İçerik Yönetimi (CMS)',
            'fetch-cms' => 'İçerik Yönetimi (CMS)',
            'fetch-cmsContent' => 'İçerik Yönetimi (CMS)',
            'list-cms' => 'CMS Listesi',
            'create-cms' => 'Yeni CMS İçeriği',
            'edit-cms' => 'CMS Düzenleme',

            // Job Module
            'job' => 'İş İlanları Listesi',
            'fetch-jobs' => 'İş İlanları Listesi',
            'list-jobs' => 'İş İlanları',
            'create-job' => 'Yeni İş İlanı Ekleme',
            'edit-job' => 'İş İlanı Düzenleme',

            // Company Module
            'company' => 'Şirketler Listesi',
            'fetch-companies' => 'Şirketler Listesi',
            'list-companies' => 'Şirketler',
            'create-company' => 'Yeni Şirket Ekleme',
            'edit-company' => 'Şirket Düzenleme',

            // Candidate Module
            'user' => 'Adaylar Listesi',
            'fetch-users' => 'Adaylar Listesi',

            // Packages
            'package' => 'Paketler',
            'list-packages' => 'Paket Listesi',
            'create-package' => 'Yeni Paket Ekleme',
            'edit-package' => 'Paket Düzenleme',

            // Blogs
            'blog' => 'Blog Yazıları',
            'fetch-blogs' => 'Blog Yazıları',

            // Location
            'country' => 'Ülke Yönetimi',
            'state' => 'Bölge/Şehir Yönetimi',
            'city' => 'İlçe Yönetimi',

            // Settings
            'site_setting' => 'Site Ayarları',

            // Attributes
            'functional_area' => 'Fonksiyonel Alanlar',
            'industry' => 'Sektörler',
            'job_experience' => 'Deneyim Seviyeleri',
            'job_skill' => 'Yetenekler',
            'job_type' => 'İş Tipleri',
            'job_shift' => 'Çalışma Şekilleri',
            'degree_level' => 'Eğitim Seviyeleri',
            'degree_type' => 'Eğitim Tipleri',
            'major_subject' => 'Ana Bilim Dalları',
            'language' => 'Diller',
            'marital_status' => 'Medeni Durum',
            'career_level' => 'Kariyer Seviyesi',
            'salary_period' => 'Maaş Dönemi',
            'ownership_type' => 'Mülkiyet Tipi',
            'gender' => 'Cinsiyet',
            'result_type' => 'Sonuç Tipi',
            'language_level' => 'Dil Seviyesi',
            'job_title' => 'İş Unvanları',
            'faq' => 'Sıkça Sorulan Sorular',
            'seo' => 'SEO Ayarları',
            'video' => 'Videolar',
            'testimonial' => 'Referanslar',
            'slider' => 'Slider',
            'reports' => 'Raporlar',

            // List pages
            'list-videos' => 'Video Listesi',
            'list-testimonials' => 'Referans Listesi',
            'list-sliders' => 'Slider Listesi',
            'list-users' => 'Kullanıcı Listesi',
            'list-applicants' => 'Başvuru Yapanlar',
            'list-seo' => 'SEO Listesi',
            'list-salary-periods' => 'Maaş Dönemleri',
            'list-result-types' => 'Sonuç Tipleri',
            'list-states' => 'Eyalet/Şehir Listesi',
            'list-cities' => 'İlçe Listesi',
            'list-countries' => 'Ülke Listesi',
            'list-industries' => 'Sektör Listesi',
            'list-functional-areas' => 'Fonksiyonel Alan Listesi',
            'list-job-skills' => 'Yetenek Listesi',
            'list-job-types' => 'İş Tipi Listesi',
            'list-job-shifts' => 'Çalışma Şekli Listesi',
            'list-degree-levels' => 'Eğitim Seviyesi Listesi',
            'list-degree-types' => 'Eğitim Tipi Listesi',
            'list-major-subjects' => 'Ana Bilim Dalı Listesi',
            'list-languages' => 'Dil Listesi',
            'list-marital-statuses' => 'Medeni Durum Listesi',
            'list-career-levels' => 'Kariyer Seviyesi Listesi',
            'list-genders' => 'Cinsiyet Listesi',
            'list-language-levels' => 'Dil Seviyesi Listesi',
            'list-job-titles' => 'İş Unvanı Listesi',
            'list-ownership-types' => 'Mülkiyet Tipi Listesi',

            // Create pages
            'create-video' => 'Video Ekleme',
            'create-testimonial' => 'Referans Ekleme',
            'create-slider' => 'Slider Ekleme',
            'create-user' => 'Kullanıcı Ekleme',
            'create-salary-period' => 'Maaş Dönemi Ekleme',
            'create-result-type' => 'Sonuç Tipi Ekleme',
            'create-state' => 'Eyalet/Şehir Ekleme',
            'create-city' => 'İlçe Ekleme',
            'create-country' => 'Ülke Ekleme',
            'create-industry' => 'Sektör Ekleme',
            'create-functional-area' => 'Fonksiyonel Alan Ekleme',
            'create-job-skill' => 'Yetenek Ekleme',
            'create-job-type' => 'İş Tipi Ekleme',
            'create-job-shift' => 'Çalışma Şekli Ekleme',
            'create-degree-level' => 'Eğitim Seviyesi Ekleme',
            'create-degree-type' => 'Eğitim Tipi Ekleme',
            'create-major-subject' => 'Ana Bilim Dalı Ekleme',
            'create-language' => 'Dil Ekleme',
            'create-marital-status' => 'Medeni Durum Ekleme',
            'create-career-level' => 'Kariyer Seviyesi Ekleme',
            'create-gender' => 'Cinsiyet Ekleme',
            'create-language-level' => 'Dil Seviyesi Ekleme',
            'create-job-title' => 'İş Unvanı Ekleme',
            'create-ownership-type' => 'Mülkiyet Tipi Ekleme',

            // Edit pages
            'edit-video' => 'Video Düzenleme',
            'edit-testimonial' => 'Referans Düzenleme',
            'edit-slider' => 'Slider Düzenleme',
            'edit-user' => 'Kullanıcı Düzenleme',
            'edit-seo' => 'SEO Düzenleme',
            'edit-salary-period' => 'Maaş Dönemi Düzenleme',
            'edit-result-type' => 'Sonuç Tipi Düzenleme',
            'edit-state' => 'Eyalet/Şehir Düzenleme',
            'edit-city' => 'İlçe Düzenleme',
            'edit-country' => 'Ülke Düzenleme',
            'edit-industry' => 'Sektör Düzenleme',
            'edit-functional-area' => 'Fonksiyonel Alan Düzenleme',
            'edit-job-skill' => 'Yetenek Düzenleme',
            'edit-job-type' => 'İş Tipi Düzenleme',
            'edit-job-shift' => 'Çalışma Şekli Düzenleme',
            'edit-degree-level' => 'Eğitim Seviyesi Düzenleme',
            'edit-degree-type' => 'Eğitim Tipi Düzenleme',
            'edit-major-subject' => 'Ana Bilim Dalı Düzenleme',
            'edit-language' => 'Dil Düzenleme',
            'edit-marital-status' => 'Medeni Durum Düzenleme',
            'edit-career-level' => 'Kariyer Seviyesi Düzenleme',
            'edit-gender' => 'Cinsiyet Düzenleme',
            'edit-language-level' => 'Dil Seviyesi Düzenleme',
            'edit-job-title' => 'İş Unvanı Düzenleme',
            'edit-ownership-type' => 'Mülkiyet Tipi Düzenleme',
            'edit-site-setting' => 'Site Ayarları',

            // Fetch/Data pages
            'fetch-videos' => 'Video Listesi',
            'fetch-testimonials' => 'Referans Listesi',
            'fetch-sliders' => 'Slider Listesi',
            'fetch-applicants' => 'Başvuru Yapanlar',
            'fetch-seo' => 'SEO Listesi',
            'fetch-salary.periods' => 'Maaş Dönemleri',
            'fetch-result.types' => 'Sonuç Tipleri',
            'fetch-states' => 'Eyalet/Şehir Listesi',
            'fetch-cities' => 'İlçe Listesi',
            'fetch-countries' => 'Ülke Listesi',
            'fetch-industries' => 'Sektör Listesi',
            'fetch-functional-areas' => 'Fonksiyonel Alan Listesi',
            'fetch-job-skills' => 'Yetenek Listesi',
            'fetch-job-types' => 'İş Tipi Listesi',
            'fetch-job-shifts' => 'Çalışma Şekli Listesi',
            'fetch-degree-levels' => 'Eğitim Seviyesi Listesi',
            'fetch-degree-types' => 'Eğitim Tipi Listesi',
            'fetch-major-subjects' => 'Ana Bilim Dalı Listesi',
            'fetch-languages' => 'Dil Listesi',
            'fetch-marital-statuses' => 'Medeni Durum Listesi',
            'fetch-career-levels' => 'Kariyer Seviyesi Listesi',
            'fetch-genders' => 'Cinsiyet Listesi',
            'fetch-language-levels' => 'Dil Seviyesi Listesi',
            'fetch-job-titles' => 'İş Unvanı Listesi',
            'fetch-ownership-types' => 'Mülkiyet Tipi Listesi',
            'fetch-job' => 'İş Listesi',
            'fetch-company' => 'Şirket Listesi',
            'fetch-user' => 'Aday Listesi',
            'fetch-package' => 'Paket Listesi',
            'fetch-service' => 'Hizmet Listesi',
            'fetch-service-category' => 'Hizmet Kategorisi Listesi',
            'fetch-service-request' => 'Hizmet Talep Listesi',
            'fetch-service-add-on' => 'Ek Hizmet Listesi',
            'fetch-crm' => 'CRM Listesi',
            'list-payment-history' => 'Ödeme Geçmişi',
            'fetch-payment-history' => 'Ödeme Geçmişi Listesi',

            // Messages & Notifications
            'messages' => 'Mesajlar',
            'messages/unread' => 'Okunmamış Mesajlar',
            'messages/inbox' => 'Gelen Kutusu',
            'messages/sent' => 'Gönderilen Mesajlar',
            'messages/compose' => 'Mesaj Yazma',
            'notifications' => 'Bildirimler',
            'get-my-notifications' => 'Bildirim Kontrolü',

            // CRM Sub-pages
            'crm/index' => 'Personel Takip Ekranı',
            'crm/get-staff-activities' => 'Personel Etkinlikleri',
            'crm/profile' => 'Personel Profili',
            'crm/set-status' => 'Durum Değiştirme',
            'crm/heartbeat' => 'Bağlantı Kontrolü',
            'crm/page-activity' => 'Sayfa Etkinliği',
            'crm/send-notification' => 'Bildirim Gönderme',
            'crm/notes' => 'Notlar',

            // Reports sub-pages
            'reports/jobs' => 'İş İlanları Raporu',
            'reports/companies' => 'Şirketler Raporu',
            'reports/export' => 'Rapor Dışa Aktarma',

            // Update/Store patterns
            'update-site-setting' => 'Site Ayarları Kaydetme',
            'store-admin-user' => 'Yönetici Kaydetme',

            // Automation
            'automation' => 'Otomasyon',
            'automation/index' => 'Otomasyon Paneli',
            'automation/personnel' => 'Personel Performansı',

            // Profile
            'my-profile' => 'Profilim',
            'profile/update' => 'Profil Güncelleme',
        ];

        // Check exact match
        if (isset($mappings[$cleanPath])) {
            return $mappings[$cleanPath];
        }

        // Check patterns for dynamic URLs with IDs
        // Edit patterns
        if (strpos($cleanPath, 'edit-video') !== false)
            return 'Video Düzenleme';
        if (strpos($cleanPath, 'edit-testimonial') !== false)
            return 'Referans Düzenleme';
        if (strpos($cleanPath, 'edit-slider') !== false)
            return 'Slider Düzenleme';
        if (strpos($cleanPath, 'edit-user') !== false)
            return 'Kullanıcı Düzenleme';
        if (strpos($cleanPath, 'edit-seo') !== false)
            return 'SEO Düzenleme';
        if (strpos($cleanPath, 'edit-salary-period') !== false)
            return 'Maaş Dönemi Düzenleme';
        if (strpos($cleanPath, 'edit-result-type') !== false)
            return 'Sonuç Tipi Düzenleme';
        if (strpos($cleanPath, 'edit-state') !== false)
            return 'Eyalet/Şehir Düzenleme';
        if (strpos($cleanPath, 'edit-city') !== false)
            return 'İlçe Düzenleme';
        if (strpos($cleanPath, 'edit-country') !== false)
            return 'Ülke Düzenleme';
        if (strpos($cleanPath, 'edit-industry') !== false)
            return 'Sektör Düzenleme';
        if (strpos($cleanPath, 'edit-functional-area') !== false)
            return 'Fonksiyonel Alan Düzenleme';
        if (strpos($cleanPath, 'edit-job-skill') !== false)
            return 'Yetenek Düzenleme';
        if (strpos($cleanPath, 'edit-job-type') !== false)
            return 'İş Tipi Düzenleme';
        if (strpos($cleanPath, 'edit-job-shift') !== false)
            return 'Çalışma Şekli Düzenleme';
        if (strpos($cleanPath, 'edit-degree-level') !== false)
            return 'Eğitim Seviyesi Düzenleme';
        if (strpos($cleanPath, 'edit-degree-type') !== false)
            return 'Eğitim Tipi Düzenleme';
        if (strpos($cleanPath, 'edit-major-subject') !== false)
            return 'Ana Bilim Dalı Düzenleme';
        if (strpos($cleanPath, 'edit-language') !== false)
            return 'Dil Düzenleme';
        if (strpos($cleanPath, 'edit-marital-status') !== false)
            return 'Medeni Durum Düzenleme';
        if (strpos($cleanPath, 'edit-career-level') !== false)
            return 'Kariyer Seviyesi Düzenleme';
        if (strpos($cleanPath, 'edit-gender') !== false)
            return 'Cinsiyet Düzenleme';
        if (strpos($cleanPath, 'edit-language-level') !== false)
            return 'Dil Seviyesi Düzenleme';
        if (strpos($cleanPath, 'edit-job-title') !== false)
            return 'İş Unvanı Düzenleme';
        if (strpos($cleanPath, 'edit-ownership-type') !== false)
            return 'Mülkiyet Tipi Düzenleme';
        if (strpos($cleanPath, 'edit-admin-user') !== false)
            return 'Yönetici Düzenleme';
        if (strpos($cleanPath, 'edit-company') !== false)
            return 'Şirket Düzenleme';
        if (strpos($cleanPath, 'edit-job') !== false)
            return 'İş İlanı Düzenleme';
        if (strpos($cleanPath, 'edit-package') !== false)
            return 'Paket Düzenleme';

        // Detail/View patterns
        if (strpos($cleanPath, 'detail-company') !== false)
            return 'Şirket Detayı';
        if (strpos($cleanPath, 'detail-job') !== false)
            return 'İş İlanı Detayı';
        if (strpos($cleanPath, 'detail-user') !== false)
            return 'Kullanıcı Detayı';
        if (strpos($cleanPath, 'view-public-profile') !== false)
            return 'Profil Görüntüleme';

        // Update patterns (e.g., update-seo/6, update-company/3)
        if (preg_match('#^update[/-]#', $cleanPath)) {
            $updateModule = preg_replace('#^update[/-]#', '', $cleanPath);
            $updateModule = preg_replace('#/\d+.*$#', '', $updateModule); // Remove ID
            $updateModule = trim($updateModule, '/');
            $moduleNames = self::getModuleNames();
            if (isset($moduleNames[$updateModule])) {
                return $moduleNames[$updateModule] . ' Güncelleme';
            }
            return self::formatTurkish($updateModule) . ' Güncelleme';
        }

        // Store patterns (e.g., store-seo, store-company)
        if (preg_match('#^store[/-]#', $cleanPath)) {
            $storeModule = preg_replace('#^store[/-]#', '', $cleanPath);
            $storeModule = preg_replace('#/\d+.*$#', '', $storeModule);
            $storeModule = trim($storeModule, '/');
            $moduleNames = self::getModuleNames();
            if (isset($moduleNames[$storeModule])) {
                return $moduleNames[$storeModule] . ' Kaydetme';
            }
            return self::formatTurkish($storeModule) . ' Kaydetme';
        }

        // Delete patterns
        if (strpos($cleanPath, 'delete-video') !== false)
            return 'Video Silme';
        if (strpos($cleanPath, 'delete-testimonial') !== false)
            return 'Referans Silme';
        if (strpos($cleanPath, 'delete-slider') !== false)
            return 'Slider Silme';
        if (strpos($cleanPath, 'delete-user') !== false)
            return 'Kullanıcı Silme';
        if (strpos($cleanPath, 'delete-admin-user') !== false)
            return 'Yönetici Silme';
        if (strpos($cleanPath, 'delete-company') !== false)
            return 'Şirket Silme';
        if (strpos($cleanPath, 'delete-job') !== false)
            return 'İş İlanı Silme';

        // Service patterns
        if (strpos($cleanPath, 'service-categories/create') !== false)
            return 'Hizmet Kategorisi Ekleme';
        if (strpos($cleanPath, 'service-categories/edit') !== false || strpos($cleanPath, 'service-categories/') !== false)
            return 'Hizmet Kategorisi Düzenleme';
        if (strpos($cleanPath, 'service-categories') !== false)
            return 'Hizmet Kategorileri';
        if (strpos($cleanPath, 'services/create') !== false)
            return 'Hizmet Ekleme';
        if (strpos($cleanPath, 'services/edit') !== false || strpos($cleanPath, 'services/') !== false)
            return 'Hizmet Düzenleme';
        if (strpos($cleanPath, 'services') !== false)
            return 'Hizmetler';
        if (strpos($cleanPath, 'service-requests') !== false)
            return 'Hizmet Talepleri';
        if (strpos($cleanPath, 'service-addons') !== false || strpos($cleanPath, 'service-add-ons') !== false)
            return 'Ek Hizmetler';

        // Specific patterns for main modules (BEFORE generic matching)
        if (strpos($cleanPath, 'job/create') !== false)
            return 'İş İlanı Ekleme';
        if (strpos($cleanPath, 'job/edit') !== false)
            return 'İş İlanı Düzenleme';
        if (strpos($cleanPath, 'company/create') !== false)
            return 'Şirket Ekleme';
        if (strpos($cleanPath, 'company/edit') !== false)
            return 'Şirket Düzenleme';
        if (strpos($cleanPath, 'user/create') !== false)
            return 'Aday Ekleme';
        if (strpos($cleanPath, 'user/edit') !== false)
            return 'Aday Düzenleme';
        if (strpos($cleanPath, 'package/create') !== false)
            return 'Paket Ekleme';
        if (strpos($cleanPath, 'package/edit') !== false)
            return 'Paket Düzenleme';

        // Generic patterns for all modules with /create, /edit, etc.
        // This handles URLs like: functional_area/create, industry/edit, etc.
        // AND action-module style like: create-job, edit-company
        if (preg_match('#[/-](create|edit|list|fetch|delete|view|detail|update|store)#', $cleanPath) || preg_match('#^(create|edit|list|fetch|delete|view|detail|update|store)-#', $cleanPath)) {
            // Extract module name and action
            $parts = preg_split('#[/-]#', $cleanPath);
            if (count($parts) >= 2) {
                $action = '';
                $module = '';

                // Check if first part is action (create-job)
                $possibleActions = ['create', 'edit', 'list', 'fetch', 'delete', 'view', 'detail', 'update', 'store'];
                if (in_array($parts[0], $possibleActions)) {
                    $action = $parts[0];
                    $module = $parts[1];
                    // Handle modules with underscores or hyphens in them (e.g., job_skill)
                    if (count($parts) > 2) {
                        $module = implode('_', array_slice($parts, 1));
                    }
                } else {
                    // Check if second part is action (job/create)
                    $action = $parts[1];
                    $module = $parts[0];
                }

                $moduleNames = self::getModuleNames();

                // Action mappings
                $actionNames = [
                    'create' => 'Ekleme',
                    'edit' => 'Düzenleme',
                    'list' => 'Listesi',
                    'fetch' => 'Listesi',
                    'delete' => 'Silme',
                    'view' => 'Görüntüleme',
                    'detail' => 'Detayı',
                    'update' => 'Güncelleme',
                    'store' => 'Kaydetme',
                ];

                if (isset($moduleNames[$module]) && isset($actionNames[$action])) {
                    return $moduleNames[$module] . ' ' . $actionNames[$action];
                }
            }
        }

        // Other specific patterns
        if (strpos($cleanPath, 'job/create') !== false)
            return 'İş İlanı Ekleme';
        if (strpos($cleanPath, 'job/edit') !== false)
            return 'İş İlanı Düzenleme';
        if (strpos($cleanPath, 'company/create') !== false)
            return 'Şirket Ekleme';
        if (strpos($cleanPath, 'company/edit') !== false)
            return 'Şirket Düzenleme';
        if (strpos($cleanPath, 'user/create') !== false)
            return 'Aday Ekleme';
        if (strpos($cleanPath, 'user/edit') !== false)
            return 'Aday Düzenleme';
        if (strpos($cleanPath, 'package/create') !== false)
            return 'Paket Ekleme';
        if (strpos($cleanPath, 'package/edit') !== false)
            return 'Paket Düzenleme';
        if (strpos($cleanPath, 'reports') !== false)
            return 'Raporlama Merkezi';

        // Messages patterns
        if (strpos($cleanPath, 'messages') !== false) {
            if (strpos($cleanPath, 'unread') !== false)
                return 'Okunmamış Mesajlar';
            if (strpos($cleanPath, 'inbox') !== false)
                return 'Gelen Kutusu';
            if (strpos($cleanPath, 'sent') !== false)
                return 'Gönderilen Mesajlar';
            if (strpos($cleanPath, 'compose') !== false)
                return 'Mesaj Yazma';
            if (strpos($cleanPath, 'count') !== false)
                return 'Mesaj Sayısı Kontrolü';
            return 'Mesajlar';
        }

        // Notifications patterns
        if (strpos($cleanPath, 'notification') !== false) {
            if (strpos($cleanPath, 'send') !== false)
                return 'Bildirim Gönderme';
            return 'Bildirimler';
        }

        // CRM patterns
        if (strpos($cleanPath, 'crm') !== false) {
            if (strpos($cleanPath, 'profile') !== false)
                return 'Personel Profili';
            if (strpos($cleanPath, 'heartbeat') !== false)
                return 'Bağlantı Kontrolü';
            if (strpos($cleanPath, 'page-activity') !== false)
                return 'Sayfa Etkinliği';
            if (strpos($cleanPath, 'notes') !== false)
                return 'Notlar';
            if (strpos($cleanPath, 'status') !== false)
                return 'Durum Güncelleme';
            return 'Personel Takip';
        }

        // Fallback: Translate common English words to Turkish
        return self::formatTurkish($cleanPath);
    }

    /**
     * Map status code to friendly name and class
     */
    public static function getStatusDetails($status)
    {
        switch ($status) {
            case 'ONLINE':
                return ['text' => 'Çevrimiçi', 'class' => 'success', 'icon' => 'fa fa-check-circle'];
            case 'BREAK':
                return ['text' => 'Molada', 'class' => 'warning', 'icon' => 'fa fa-coffee'];
            case 'IN_CALL':
                return ['text' => 'Çağrıda', 'class' => 'info', 'icon' => 'fa fa-phone'];
            case 'SYSTEM_ERROR':
                return ['text' => 'Sistem Hatası', 'class' => 'danger', 'icon' => 'fa fa-exclamation-triangle'];
            case 'OFFLINE':
            default:
                return ['text' => 'Çevrimdışı', 'class' => 'default', 'icon' => 'fa fa-circle-o'];
        }
    }

    /**
     * Generate a natural language sentence for the activity
     */
    public static function getActivitySentence($method, $url, $payload = null)
    {
        $friendlyName = self::getFriendlyName($url);
        $data = $payload ? json_decode($payload, true) : null;

        switch ($method) {
            case 'GET':
                return $friendlyName . ' Görüntüledi';
            case 'POST':
                if (strpos($url, 'process-login') !== false)
                    return 'Sisteme Giriş Yaptı';
                if (strpos($url, 'logout') !== false)
                    return 'Sistemden Çıkış Yaptı';
                if (strpos($url, 'set-status') !== false) {
                    $status = $data['status'] ?? '';
                    $statusText = self::getStatusDetails($status)['text'] ?? 'Bilinmiyor';
                    return 'Durumunu Değiştirdi: ' . $statusText;
                }
                if (strpos($url, 'store-admin-user') !== false)
                    return 'Yeni Yönetici Ekledi';
                if (strpos($url, 'store') !== false || strpos($url, 'create') !== false)
                    return $friendlyName . ' Ekledi';
                return $friendlyName . ' Üzerinde İşlem Yaptı';
            case 'PUT':
            case 'PATCH':
                if (strpos($url, 'update-admin-user') !== false)
                    return 'Yönetici Bilgilerini Güncelledi';
                return $friendlyName . ' Güncelledi';
            case 'DELETE':
                if (strpos($url, 'delete-admin-user') !== false)
                    return 'Yönetici Sildi';
                return $friendlyName . ' Sildi';
            default:
                return $friendlyName . ' (' . $method . ')';
        }
    }

    /**
     * Get module name mappings (shared across methods)
     */
    private static function getModuleNames()
    {
        return [
            'company' => 'Şirket',
            'job' => 'İş İlanı',
            'user' => 'Kullanıcı',
            'package' => 'Paket',
            'blog' => 'Blog',
            'cms' => 'İçerik',
            'faq' => 'SSS',
            'seo' => 'SEO',
            'video' => 'Video',
            'testimonial' => 'Referans',
            'slider' => 'Slider',
            'country' => 'Ülke',
            'state' => 'Eyalet/Şehir',
            'city' => 'İlçe',
            'language' => 'Dil',
            'gender' => 'Cinsiyet',
            'functional_area' => 'Fonksiyonel Alan',
            'functional-area' => 'Fonksiyonel Alan',
            'industry' => 'Sektör',
            'job_experience' => 'Deneyim Seviyesi',
            'job-experience' => 'Deneyim Seviyesi',
            'job_skill' => 'Yetenek',
            'job-skill' => 'Yetenek',
            'job_type' => 'İş Tipi',
            'job-type' => 'İş Tipi',
            'job_shift' => 'Çalışma Şekli',
            'job-shift' => 'Çalışma Şekli',
            'degree_level' => 'Eğitim Seviyesi',
            'degree-level' => 'Eğitim Seviyesi',
            'degree_type' => 'Eğitim Tipi',
            'degree-type' => 'Eğitim Tipi',
            'major_subject' => 'Ana Bilim Dalı',
            'major-subject' => 'Ana Bilim Dalı',
            'marital_status' => 'Medeni Durum',
            'marital-status' => 'Medeni Durum',
            'career_level' => 'Kariyer Seviyesi',
            'career-level' => 'Kariyer Seviyesi',
            'salary_period' => 'Maaş Dönemi',
            'salary-period' => 'Maaş Dönemi',
            'ownership_type' => 'Mülkiyet Tipi',
            'ownership-type' => 'Mülkiyet Tipi',
            'result_type' => 'Sonuç Tipi',
            'result-type' => 'Sonuç Tipi',
            'language_level' => 'Dil Seviyesi',
            'language-level' => 'Dil Seviyesi',
            'job_title' => 'İş Unvanı',
            'job-title' => 'İş Unvanı',
            'blog_category' => 'Blog Kategorisi',
            'blog-category' => 'Blog Kategorisi',
            'admin' => 'Yönetici',
            'admin-user' => 'Yönetici',
            'service' => 'Hizmet',
            'service-category' => 'Hizmet Kategorisi',
            'service-request' => 'Hizmet Talebi',
            'service-addon' => 'Ek Hizmet',
            'service-add-on' => 'Ek Hizmet',
            'payment' => 'Ödeme',
            'payment-history' => 'Ödeme Geçmişi',
            'message' => 'Mesaj',
            'messages' => 'Mesajlar',
            'notification' => 'Bildirim',
            'site-setting' => 'Site Ayarları',
            'site_setting' => 'Site Ayarları',
        ];
    }

    /**
     * Format a URL path segment into Turkish-friendly text.
     * Translates common English words and cleans up the output.
     */
    private static function formatTurkish($path)
    {
        // Remove numeric IDs from path
        $path = preg_replace('#/\d+#', '', $path);
        $path = trim($path, '/');

        // Try to match individual segments against module names
        $moduleNames = self::getModuleNames();
        $segments = preg_split('#[/_-]#', $path);

        // First, try full path match
        $hyphenated = implode('-', $segments);
        $underscored = implode('_', $segments);
        if (isset($moduleNames[$hyphenated]))
            return $moduleNames[$hyphenated];
        if (isset($moduleNames[$underscored]))
            return $moduleNames[$underscored];

        // Common English-to-Turkish word translations for fallback
        $wordMap = [
            'messages' => 'Mesajlar',
            'message' => 'Mesaj',
            'unread' => 'Okunmamış',
            'count' => 'Sayısı',
            'inbox' => 'Gelen Kutusu',
            'sent' => 'Gönderilen',
            'notifications' => 'Bildirimler',
            'notification' => 'Bildirim',
            'update' => 'Güncelleme',
            'store' => 'Kaydetme',
            'create' => 'Ekleme',
            'edit' => 'Düzenleme',
            'delete' => 'Silme',
            'list' => 'Liste',
            'fetch' => 'Liste',
            'view' => 'Görüntüleme',
            'detail' => 'Detay',
            'index' => 'Ana Sayfa',
            'home' => 'Anasayfa',
            'dashboard' => 'Kontrol Paneli',
            'settings' => 'Ayarlar',
            'setting' => 'Ayar',
            'profile' => 'Profil',
            'search' => 'Arama',
            'filter' => 'Filtre',
            'export' => 'Dışa Aktarma',
            'import' => 'İçe Aktarma',
            'report' => 'Rapor',
            'reports' => 'Raporlar',
            'analytics' => 'Analiz',
            'users' => 'Kullanıcılar',
            'admin' => 'Yönetici',
            'login' => 'Giriş',
            'logout' => 'Çıkış',
            'password' => 'Şifre',
            'reset' => 'Sıfırlama',
            'all' => 'Tüm',
            'new' => 'Yeni',
            'active' => 'Aktif',
            'inactive' => 'Pasif',
            'pending' => 'Bekleyen',
            'approved' => 'Onaylı',
            'rejected' => 'Reddedilen',
            'status' => 'Durum',
            'history' => 'Geçmiş',
            'log' => 'Kayıt',
            'logs' => 'Kayıtlar',
            'activity' => 'Etkinlik',
            'page' => 'Sayfa',
            'data' => 'Veri',
            'heartbeat' => 'Bağlantı Kontrolü',
            'check' => 'Kontrol',
            'process' => 'İşlem',
            'get' => '',
            'set' => '',
            'my' => 'Benim',
            'send' => 'Gönder',
            'staff' => 'Personel',
            'activities' => 'Etkinlikler',
        ];

        $translated = [];
        foreach ($segments as $segment) {
            $lower = strtolower($segment);
            if (isset($wordMap[$lower]) && $wordMap[$lower] !== '') {
                $translated[] = $wordMap[$lower];
            } elseif (isset($moduleNames[$lower])) {
                $translated[] = $moduleNames[$lower];
            } elseif ($lower !== 'get' && $lower !== 'set' && $lower !== '') {
                $translated[] = ucfirst($lower);
            }
        }

        return !empty($translated) ? implode(' ', $translated) : ucfirst($path);
    }
}
