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

        \DB::table('shift_schedules')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => '08:30AM-5:30PM',
                    'open_time' => 0,
                    'working_hours' => '[{"end": "12:00", "start": "08:30"}, {"end": "17:30", "start": "13:00"}]',
                    'day_start' => 2,
                    'early_login_overtime' => 0,
                    'after_shift_overtime' => 1,
                    'night_differential' => 1,
                    'description' => 'Lorem ipsum (/ˌlɔː.rəm ˈɪp.səm/ LOR-əm IP-səm) is a dummy or placeholder text commonly used in graphic design, publishing, and web development to fill empty spaces in a layout that does not yet have content.',
                    'created_at' => '2024-12-09 13:46:14',
                    'updated_at' => '2024-12-14 19:55:41',
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'Open Time',
                    'open_time' => 1,
                    'working_hours' => '[{"end": "", "start": ""}]',
                    'day_start' => NULL,
                    'early_login_overtime' => 0,
                    'after_shift_overtime' => 1,
                    'night_differential' => 1,
                    'description' => NULL,
                    'created_at' => '2024-12-09 13:46:30',
                    'updated_at' => '2024-12-18 13:46:26',
                ),
        ));


    }
}
