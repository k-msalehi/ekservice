<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProvincesAndCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = json_decode(File::get(storage_path('data/provinces.json')), true);
        $cities = json_decode(File::get(storage_path('data/cities.json')), true);

        DB::table('provinces')->insert($provinces);
        DB::table('cities')->insert($cities);
    }
}
