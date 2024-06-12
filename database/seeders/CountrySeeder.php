<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder {

    public function run(): void {
        $json = file_get_contents(public_path('ar.json'));
        $data = json_decode($json, true);
        foreach ($data['data'] as $country) {
            $dd = Country::firstOrCreate(
                [
                    'name' => $country['province_ar_name'],
                    'name_en' => $country['province_name'],
                    'flag' => 'kwd',
                    'currency' => 'kwd',
                ],
                [
                    'name' => $country['province_ar_name'],
                    'name_en' => $country['province_name'],
                    'flag' => 'kwd',
                    'currency' => 'kwd',
                ]
            );
            $countryId = $dd->id;
            $area = Area::firstOrCreate(
                [
                    'name' => $country['ar_name'],
                    'name_en' => $country['name'],
                    'country_id' => $countryId,
                ],
                [
                    'name' => $country['ar_name'],
                    'name_en' => $country['name'],
                    'country_id' => $countryId,
                ]
            );



        }
    }
}
