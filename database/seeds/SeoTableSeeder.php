<?php
use Illuminate\Database\Seeder;
use App\Seo;

class SeoTableSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            [
                'page_title' => 'front_index_page',
                'seo_title' => 'Personel Noktası - En Güncel İş İlanları ve Kariyer Fırsatları',
                'seo_description' => 'Personel Noktası ile hayalinizdeki işe ulaşın. Binlerce güncel iş ilanı, kariyer tavsiyeleri ve seçkin şirketler sizi bekliyor. Hemen özgeçmiş oluşturun ve başvurun.',
                'priority' => '1.0',
                'slug' => '/',
                'route_name' => 'index',
                'controller_action' => 'App\Http\Controllers\IndexController@index',
                'is_static' => 1
            ],
            [
                'page_title' => 'jobs',
                'seo_title' => 'İş İlanları - Aradığınız İşi Hemen Bulun | Personel Noktası',
                'seo_description' => 'Sektörlere, pozisyonlara ve şehirlere göre en güncel iş ilanlarını inceleyin. Size en uygun iş fırsatlarını keşfedin ve kariyerinize yön verin.',
                'slug' => 'is-ilanlari',
                'route_name' => 'job.list',
                'controller_action' => 'App\Http\Controllers\Job\JobController@jobsBySearch',
                'is_static' => 1
            ],
            [
                'page_title' => 'companies',
                'seo_title' => 'Şirketler - En İyi İşverenleri Keşfedin | Personel Noktası',
                'seo_description' => 'Türkiye\'nin önde gelen şirketlerini, çalışan yorumlarını ve açık pozisyonlarını inceleyin. Sizin için en doğru çalışma ortamını bulun.',
                'slug' => 'sirketler',
                'route_name' => 'company.listing',
                'controller_action' => 'App\Http\Controllers\Company\CompaniesController@company_listing',
                'is_static' => 1
            ],
            [
                'page_title' => 'contact',
                'seo_title' => 'İletişim - Bize Ulaşın | Personel Noktası',
                'seo_description' => 'Sorularınız, görüşleriniz ve önerileriniz için Personel Noktası ekibiyle iletişime geçin. Size yardımcı olmaktan memnuniyet duyarız.',
                'slug' => 'iletisim',
                'route_name' => 'contact.us',
                'controller_action' => 'App\Http\Controllers\ContactController@index',
                'is_static' => 1
            ],
            [
                'page_title' => 'blogs',
                'seo_title' => 'Kariyer Blogu - İş Hayatı ve İpuçları | Personel Noktası',
                'seo_description' => 'İş hayatı, kariyer gelişimi, mülakat teknikleri ve CV hazırlama ipuçları hakkında güncel blog yazılarımızı okuyun.',
                'slug' => 'blog',
                'route_name' => 'blogs',
                'controller_action' => 'App\Http\Controllers\BlogController@index',
                'is_static' => 1
            ],
        ];

        foreach ($pages as $page) {
            Seo::updateOrCreate(
                ['page_title' => $page['page_title']],
                [
                    'slug' => $page['slug'],
                    'route_name' => $page['route_name'],
                    'controller_action' => $page['controller_action'],
                    'is_static' => $page['is_static'],
                    // Update meta only if creating, to avoid overwriting user edits if any (though updateOrCreate updates everything)
                    // For now we assume we want to fill these if missing, or update them.
                    'seo_title' => $page['seo_title'],
                    'seo_description' => $page['seo_description']
                ]
            );
        }
    }
}
