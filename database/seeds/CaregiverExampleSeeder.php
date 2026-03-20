<?php

use Illuminate\Database\Seeder;
use App\ServiceCategory;
use App\Service;
use Illuminate\Support\Str;

class CaregiverExampleSeeder extends Seeder
{
    public function run()
    {
        // 1. Bakıcı Kategorileri Oluştur
        $categories = [
            ['name' => 'Bebek & Çocuk Bakıcısı', 'icon' => 'fa-baby'],
            ['name' => 'Yaşlı & Hasta Bakıcısı', 'icon' => 'fa-heartbeat'],
            ['name' => 'Ev Yardımcısı & Temizlikçi', 'icon' => 'fa-home'],
            ['name' => 'Evcil Hayvan Bakıcısı', 'icon' => 'fa-dog'],
        ];

        foreach ($categories as $catData) {
            $category = ServiceCategory::updateOrCreate(
                ['category_slug' => Str::slug($catData['name'])],
                [
                    'category_name' => $catData['name'],
                    'type' => 'caregiver',
                    'is_active' => 1
                ]
            );

            // 2. Her Kategoriye Örnek Bakıcı Türleri (Hizmetler) Ekle
            $services = [];
            if ($catData['name'] == 'Bebek & Çocuk Bakıcısı') {
                $services = [
                    ['name' => 'Gündüzlü Bebek Bakıcısı', 'price' => 25000],
                    ['name' => 'Yatılı Çocuk Bakıcısı', 'price' => 35000],
                    ['name' => 'Oyun Ablası / Abisi', 'price' => 500],
                ];
            } elseif ($catData['name'] == 'Yaşlı & Hasta Bakıcısı') {
                $services = [
                    ['name' => 'Refakatçi Hizmeti', 'price' => 1500],
                    ['name' => 'Alzheimer Hasta Bakımı', 'price' => 40000],
                    ['name' => 'Hemşire Destekli Bakım', 'price' => 45000],
                ];
            } elseif ($catData['name'] == 'Ev Yardımcısı & Temizlikçi') {
                $services = [
                    ['name' => 'Genel Ev Temizliği', 'price' => 2000],
                    ['name' => 'Yatılı Ev Yardımcısı', 'price' => 30000],
                ];
            }

            foreach ($services as $serviceData) {
                Service::updateOrCreate(
                    ['service_slug' => Str::slug($serviceData['name'])],
                    [
                        'category_id' => $category->id,
                        'service_name' => $serviceData['name'],
                        'service_price' => $serviceData['price'],
                        'is_active' => 1,
                        'service_description' => $serviceData['name'] . ' için profesyonel ve deneyimli destek personeli.',
                        'service_duration' => 'Aylık/Günlük Seçenekler',
                        'service_duration_num' => 1
                    ]
                );
            }
        }
    }
}
