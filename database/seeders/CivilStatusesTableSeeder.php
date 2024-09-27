<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CivilStatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('civil_statuses')->delete();
        
        \DB::table('civil_statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Single',
                'created_at' => '2024-09-27 14:15:02',
                'updated_at' => '2024-09-27 14:15:02',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Married',
                'created_at' => '2024-09-27 14:15:10',
                'updated_at' => '2024-09-27 14:15:10',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Widowed',
                'created_at' => '2024-09-27 14:15:24',
                'updated_at' => '2024-09-27 14:15:24',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Legally Separated',
                'created_at' => '2024-09-27 14:15:35',
                'updated_at' => '2024-09-27 14:15:35',
            ),
        ));
        
        
    }
}