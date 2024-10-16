<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JobStatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('job_statuses')->delete();
        
        \DB::table('job_statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Active',
                'created_at' => '2024-10-11 13:23:10',
                'updated_at' => '2024-10-11 13:23:10',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'End Of Contract',
                'created_at' => '2024-10-11 13:23:22',
                'updated_at' => '2024-10-11 13:23:22',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Forced Leave',
                'created_at' => '2024-10-11 13:23:30',
                'updated_at' => '2024-10-11 13:23:30',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Resigned',
                'created_at' => '2024-10-11 13:23:37',
                'updated_at' => '2024-10-11 13:23:37',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Retired',
                'created_at' => '2024-10-11 13:23:43',
                'updated_at' => '2024-10-11 13:23:43',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Terminated',
                'created_at' => '2024-10-11 13:23:50',
                'updated_at' => '2024-10-11 13:23:50',
            ),
        ));
        
        
    }
}