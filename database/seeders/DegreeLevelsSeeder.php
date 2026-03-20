<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DegreeLevelsSeeder extends Seeder
{
    public function run()
    {
        $degreeLevels = [
            ['degree_level' => 'İlkokul', 'is_default' => 1, 'is_active' => 1, 'lang' => 'tr', 'sort_order' => 1],
            ['degree_level' => 'Ortaokul', 'is_default' => 1, 'is_active' => 1, 'lang' => 'tr', 'sort_order' => 2],
            ['degree_level' => 'Lise', 'is_default' => 1, 'is_active' => 1, 'lang' => 'tr', 'sort_order' => 3],
            ['degree_level' => 'Ön Lisans', 'is_default' => 1, 'is_active' => 1, 'lang' => 'tr', 'sort_order' => 4],
            ['degree_level' => 'Lisans', 'is_default' => 1, 'is_active' => 1, 'lang' => 'tr', 'sort_order' => 5],
            ['degree_level' => 'Yüksek Lisans', 'is_default' => 1, 'is_active' => 1, 'lang' => 'tr', 'sort_order' => 6],
            ['degree_level' => 'Doktora', 'is_default' => 1, 'is_active' => 1, 'lang' => 'tr', 'sort_order' => 7],
        ];

        // Check the table structure first
        $columns = DB::getSchemaBuilder()->getColumnListing('degree_levels');

        foreach ($degreeLevels as $level) {
            $insertData = [];
            foreach ($level as $key => $value) {
                if (in_array($key, $columns)) {
                    $insertData[$key] = $value;
                }
            }

            // Also set the degree_level_id if the column exists
            if (in_array('degree_level_id', $columns)) {
                $insertData['degree_level_id'] = $level['sort_order'];
            }

            // Check if exists already
            $exists = DB::table('degree_levels')
                ->where('degree_level', $level['degree_level'])
                ->where('lang', 'tr')
                ->first();

            if (!$exists) {
                $insertData['created_at'] = now();
                $insertData['updated_at'] = now();
                DB::table('degree_levels')->insert($insertData);
            }
        }

        echo "Degree levels seeded successfully!\n";
    }
}
