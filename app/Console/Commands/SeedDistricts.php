<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SeedDistricts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:districts';
    protected $description = 'Seed Turkish districts from JSON files';

    public function handle()
    {
        if (!file_exists('provinces.json') || !file_exists('districts.json')) {
            $this->error("JSON files not found!");
            return 1;
        }

        $this->info("Loading JSON data...");
        $provincesJson = json_decode(file_get_contents('provinces.json'), true);
        $districtsJson = json_decode(file_get_contents('districts.json'), true);

        $provinces = $provincesJson[2]['data'];
        $districts = $districtsJson[2]['data'];

        $this->info("Mapping provinces to database states...");
        $states = \App\State::where('country_id', 805)->get();
        $pMap = [];

        foreach ($provinces as $p) {
            $pName = mb_strtoupper($p['name'], 'UTF-8');
            $s = $states->first(function ($v) use ($pName) {
                $dbName = mb_strtoupper($v->state, 'UTF-8');
                return $dbName == $pName || str_contains($pName, $dbName) || str_contains($dbName, $pName);
            });
            if ($s) {
                $pMap[$p['id']] = $s->id;
            }
        }

        $this->info("Seeding districts...");
        $count = 0;
        foreach ($districts as $d) {
            if (isset($pMap[$d['il_id']])) {
                $nm = mb_convert_case($d['name'], MB_CASE_TITLE, 'UTF-8');
                \App\City::updateOrCreate(
                    ['city_id' => (int) $d['id'], 'lang' => 'tr'],
                    [
                        'city' => $nm,
                        'state_id' => $pMap[$d['il_id']],
                        'is_default' => 0,
                        'is_active' => 1,
                        'sort_order' => 0
                    ]
                );
                $count++;
            }
        }

        $this->info("Successfully seeded $count districts.");
        return 0;
    }
}
