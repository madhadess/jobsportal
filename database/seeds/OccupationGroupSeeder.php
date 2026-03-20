<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OccupationGroupSeeder extends Seeder
{
    public function run()
    {
        // Ana Kategoriler
        $categories = [
            'Temizlik Personeli' => [
                'Ev Temizliği',
                'Ofis Temizliği',
                'Dış Cephe / Cam Temizliği',
                'İnşaat Sonrası Temizlik'
            ],
            'Bakıcı / Refakatçi' => [
                'Bebek / Çocuk Bakıcısı',
                'Yaşlı Bakıcısı',
                'Hasta Bakıcısı / Refakatçi',
                'Oyun Ablası / Abisi'
            ],
            'Montaj ve Tamirat' => [
                'Mobilya Montajı',
                'Elektrik Arıza / Tesisat',
                'Su Tesisatı',
                'Boyat / Badana'
            ],
            'Bahçe ve Dış Alan' => [
                'Bahçe Bakımı / Peyzaj',
                'Havuz Temizliği'
            ],
            'Ev Hizmetleri' => [
                'Ev Yardımcısı',
                'Özel Aşçı',
                'Ütü / Çamaşır Hizmeti'
            ],
        ];

        foreach ($categories as $parentName => $subCategories) {
            $parentId = DB::table('occupation_groups')->updateOrInsert(
                ['name' => $parentName],
                ['is_active' => 1, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()]
            );

            // Get ID if updated
            $parent = DB::table('occupation_groups')->where('name', $parentName)->first();

            foreach ($subCategories as $subName) {
                DB::table('occupation_groups')->updateOrInsert(
                    ['name' => $subName],
                    ['is_active' => 1, 'parent_id' => $parent->id, 'created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
