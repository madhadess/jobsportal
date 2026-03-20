<?php

use Illuminate\Database\Seeder;


class TurkishDistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $provincesJson = json_decode(file_get_contents('provinces.json'), true);
        $districtsJson = json_decode(file_get_contents('districts.json'), true);

        $provinces = $provincesJson[2]['data'];
        $districts = $districtsJson[3]['data'];

        // 1. WIPE existing TR districts to ensure clean slate
        $trStateIds = \App\State::where('country_id', 805)->pluck('id')->toArray();
        \App\City::whereIn('state_id', $trStateIds)->delete();
        $this->command->info("Wiped existing TR districts.");

        $states = \App\State::where('country_id', 805)->get();
        $pMap = [];

        // Normalization function for Turkish names
        $normalize = function ($str) {
            $str = mb_strtoupper($str, 'UTF-8');
            $search = ['İ', 'I', 'ı', 'i', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
            $replace = ['I', 'I', 'I', 'I', 'G', 'U', 'S', 'O', 'C'];
            return str_replace($search, $replace, $str);
        };

        foreach ($provinces as $p) {
            $pNameNorm = $normalize($p['name']);
            $s = $states->first(function ($v) use ($pNameNorm, $normalize) {
                $dbNameNorm = $normalize($v->state);
                return $dbNameNorm == $pNameNorm || str_contains($pNameNorm, $dbNameNorm) || str_contains($dbNameNorm, $pNameNorm);
            });
            if ($s) {
                $pMap[$p['id']] = $s->id;
            }
        }

        $count = 0;
        $seen = [];
        foreach ($districts as $d) {
            if (isset($pMap[$d['il_id']])) {
                $nm = mb_convert_case($d['name'], MB_CASE_TITLE, 'UTF-8');
                $stId = $pMap[$d['il_id']];
                $normNm = $normalize($nm);

                // Avoid state-name matches (e.g. Adana-Adana)
                $stRecord = $states->where('id', $stId)->first();
                if ($stRecord && $normalize($stRecord->state) == $normNm)
                    continue;

                // Avoid duplicates within the same state in the JSON itself or near-duplicates (ı/i)
                $key = $stId . '_' . $normNm;
                if (isset($seen[$key]))
                    continue;
                $seen[$key] = true;

                \App\City::create([
                    'city_id' => (int) $d['id'],
                    'city' => $nm,
                    'state_id' => $stId,
                    'is_default' => 1,
                    'is_active' => 1,
                    'lang' => 'tr',
                    'sort_order' => 0
                ]);
                $count++;
            }
        }
        $this->command->info("Successfully seeded $count unique districts.");
    }
}
