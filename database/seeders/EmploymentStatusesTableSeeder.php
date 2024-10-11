<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmploymentStatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('employment_statuses')->delete();
        
        \DB::table('employment_statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Contractual',
                'created_at' => '2024-10-11 13:28:12',
                'updated_at' => '2024-10-11 13:28:12',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Probationary',
                'created_at' => '2024-10-11 13:28:20',
                'updated_at' => '2024-10-11 13:28:20',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Regular',
                'created_at' => '2024-10-11 13:28:27',
                'updated_at' => '2024-10-11 13:28:27',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Special Project',
                'created_at' => '2024-10-11 13:28:33',
                'updated_at' => '2024-10-11 13:28:33',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Trainee / Intern',
                'created_at' => '2024-10-11 13:28:39',
                'updated_at' => '2024-10-11 13:28:39',
            ),
        ));
        
        
    }
}