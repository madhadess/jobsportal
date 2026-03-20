<?php

use Illuminate\Database\Seeder;
use App\Cms;
use App\CmsContent;

class CmsTranslationSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            [
                'slug' => 'hakkimizda',
                'name' => 'Hakkımızda',
                'title' => 'Hakkımızda',
                'content' => '<p><strong>Personel Noktası</strong>, iş arayan yetenekler ile nitelikli personel arayan işverenleri en doğru noktada buluşturan öncü bir kariyer platformudur.</p><p>Amacımız, istihdam piyasasına değer katmak, süreçleri hızlandırmak ve her iki taraf için de en verimli eşleşmeleri sağlamaktır.</p><p>Misyonumuz, teknolojinin gücünü kullanarak işe alım süreçlerini kolaylaştırmak ve herkesin hayalindeki kariyere ulaşmasına yardımcı olmaktır.</p>',
                'seo_title' => 'Hakkımızda - Personel Noktası',
                'seo_description' => 'Personel Noktası hakkında bilgi edinin. Vizyonumuz, misyonumuz ve hizmetlerimiz.',
                'seo_keywords' => 'hakkımızda, personel noktası, kariyer platformu, iş ilanları'
            ],
            [
                'slug' => 'kullanim-kosullari',
                'name' => 'Kullanım Koşulları',
                'title' => 'Kullanım Koşulları',
                'content' => '<p>Personel Noktası web sitesini kullanarak aşağıdaki kullanım koşullarını kabul etmiş sayılırsınız.</p><ul><li>Sitede yer alan tüm içerikler bilgilendirme amaçlıdır.</li><li>İş başvurularında verilen bilgilerin doğruluğundan kullanıcı sorumludur.</li><li>Personel Noktası, sitede değişiklik yapma hakkını saklı tutar.</li></ul>',
                'seo_title' => 'Kullanım Koşulları - Personel Noktası',
                'seo_description' => 'Personel Noktası kullanım koşulları ve şartları.',
                'seo_keywords' => 'kullanım koşulları, şartlar, yasal uyarı'
            ],
            [
                'slug' => 'gizlilik-politikasi',
                'name' => 'Gizlilik Politikası',
                'title' => 'Gizlilik Politikası',
                'content' => '<p>Personel Noktası olarak kişisel verilerinizin gizliliğine önem veriyoruz.</p><p>Verileriniz 6698 sayılı Kişisel Verilerin Korunması Kanunu (KVKK) kapsamında işlenmekte ve korunmaktadır. Detaylı bilgi için lütfen KVKK aydınlatma metnini inceleyiniz.</p>',
                'seo_title' => 'Gizlilik Politikası - Personel Noktası',
                'seo_description' => 'Personel Noktası gizlilik politikası ve veri güvenliği.',
                'seo_keywords' => 'gizlilik politikası, kvkk, veri koruma'
            ]
        ];

        foreach ($pages as $pageData) {
            // Update or Create CMS Page
            $cms = Cms::where('page_slug', $pageData['slug'])->first();

            if (!$cms) {
                // Try to find by name if slug doesn't match, or create new
                $cms = Cms::updateOrCreate(
                    ['page_slug' => $pageData['slug']],
                    [
                        'name' => $pageData['name'],
                        'seo_title' => $pageData['seo_title'],
                        'seo_description' => $pageData['seo_description'],
                        'seo_keywords' => $pageData['seo_keywords'],
                        'seo_other' => ''
                    ]
                );
            } else {
                $cms->update([
                    'name' => $pageData['name'],
                    'seo_title' => $pageData['seo_title'],
                    'seo_description' => $pageData['seo_description'],
                    'seo_keywords' => $pageData['seo_keywords']
                ]);
            }

            // Update or Create CMS Content
            CmsContent::updateOrCreate(
                ['page_id' => $cms->id],
                [
                    'page_title' => $pageData['title'],
                    'page_content' => $pageData['content']
                ]
            );
        }
    }
}
