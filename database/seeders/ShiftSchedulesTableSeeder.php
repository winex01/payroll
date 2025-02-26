<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShiftSchedulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('shift_schedules')->delete();
        
        \DB::table('shift_schedules')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '08:00AM-5:00PM',
                'open_time' => 0,
                'working_hours' => '[{"end": "12:00", "start": "08:00"}, {"end": "17:00", "start": "13:00"}]',
                'early_login_overtime' => 0,
                'after_shift_overtime' => 1,
                'night_differential' => 1,
                'late' => 1,
                'undertime' => 1,
                'day_start' => 2,
            'description' => 'Lorem ipsum (/ˌlɔː.rəm ˈɪp.səm/ LOR-əm IP-səm) is a dummy or placeholder text commonly used in graphic design, publishing, and web development to fill empty spaces in a layout that does not yet have content.',
                'created_at' => '2024-12-09 13:46:14',
                'updated_at' => '2025-02-26 13:08:06',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => '09:00AM-6:00PM',
                'open_time' => 0,
                'working_hours' => '[{"end": "12:00", "start": "09:00"}, {"end": "18:00", "start": "13:00"}]',
                'early_login_overtime' => 0,
                'after_shift_overtime' => 1,
                'night_differential' => 1,
                'late' => 1,
                'undertime' => 1,
                'day_start' => 2,
                'description' => NULL,
                'created_at' => '2025-02-26 13:11:03',
                'updated_at' => '2025-02-27 07:33:48',
            ),
        ));
        
        
    }
}