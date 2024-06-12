<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $days = [
            ['name_ar' => 'السبت', 'name_en' => 'Saturday'],
            ['name_ar' => 'الأحد', 'name_en' => 'Sunday'],
            ['name_ar' => 'الاثنين', 'name_en' => 'Monday'],
            ['name_ar' => 'الثلاثاء', 'name_en' => 'Tuesday'],
            ['name_ar' => 'الأربعاء', 'name_en' => 'Wednesday'],
            ['name_ar' => 'الخميس', 'name_en' => 'Thursday'],
            ['name_ar' => 'الجمعة', 'name_en' => 'Friday'],
        ];

        Day::insert($days);
    }

}
