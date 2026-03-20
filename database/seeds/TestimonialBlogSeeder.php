<?php

use Illuminate\Database\Seeder;
use DB;

class TestimonialBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mevcut referansları sil
        DB::table('testimonials')->truncate();
        
        // Yeni Türkçe referansları ekle
        DB::table('testimonials')->insert([
            [
                'testimonial_by' => 'Ahmet Yılmaz',
                'testimonial_description' => 'Bu platform sayesinde harika bir iş buldum. Profesyonel arayüzü ve kolay kullanımı çok beğendim. Tüm iş arayanları bu platformu kullanmaya tavsiye ederim.',
                'lang' => 'tr',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'testimonial_by' => 'Fatma Kaya',
                'testimonial_description' => 'İşveren olarak bu platform bana çok yardımcı oldu. Nitelikli adayları hızlı bir şekilde buldum ve ekibimi genişlettim. Hizmet kalitesi ve müşteri desteği harika.',
                'lang' => 'tr',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'testimonial_by' => 'Mehmet Demir',
                'testimonial_description' => 'Kariyer yolculuğumda bu platform bana çok katkı sağladı. Birçok fırsat buldum ve sonunda hayalımın işine ulaştım. Herkesin bu platformu denemesini öneriyorum.',
                'lang' => 'tr',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        // Mevcut blog yazılarını sil
        DB::table('blogs')->truncate();
        
        // Yeni Türkçe blog yazılarını ekle
        DB::table('blogs')->insert([
            [
                'blog_title' => 'Başarılı İş Görüşmesi İçin 5 İpucu',
                'blog_slug' => 'basarili-is-gorusmesi-icin-5-ipucu',
                'blog_description' => 'İş görüşmesine giderken neler yapmalısınız? Bu yazıda, başarılı bir iş görüşmesi için gerekli olan 5 önemli ipucunu sizlerle paylaşıyoruz. Doğru hazırlık yaparak, özgüveninizi artırarak ve iyi bir izlenim bırakarak, hayalinizdeki işi elde etme şansınızı artırabilirsiniz.',
                'blog_image' => 'blog1.jpg',
                'lang' => 'tr',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_title' => 'Özgeçmiş Yazarken Dikkat Edilmesi Gereken Noktalar',
                'blog_slug' => 'ozgecmis-yazarken-dikkat-edilmesi-gereken-noktalar',
                'blog_description' => 'Özgeçmiş, işveren ile ilk iletişim noktanızıdır. Profesyonel bir özgeçmiş yazarak, işverenin dikkatini çekebilir ve iş görüşmesine davet edilme şansınızı artırabilirsiniz. Bu yazıda, özgeçmiş yazarken dikkat edilmesi gereken önemli noktaları inceleyeceğiz.',
                'blog_image' => 'blog2.jpg',
                'lang' => 'tr',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_title' => 'Kariyer Gelişimi İçin Gerekli Beceriler',
                'blog_slug' => 'kariyer-gelisimi-icin-gerekli-beceriler',
                'blog_description' => 'Günümüzün rekabetçi iş piyasasında, teknik beceriler kadar soft skills de önemlidir. İletişim, liderlik, problem çözme ve takım çalışması gibi beceriler, kariyer gelişiminizde önemli rol oynar. Bu yazıda, kariyer gelişimi için gerekli olan temel becerileri inceleyeceğiz.',
                'blog_image' => 'blog3.jpg',
                'lang' => 'tr',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
