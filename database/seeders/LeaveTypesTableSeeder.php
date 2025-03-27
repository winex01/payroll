<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LeaveTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('leave_types')->delete();
        
        \DB::table('leave_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Sick leave with pay',
                'description' => NULL,
                'with_pay' => 1,
                'created_at' => '2025-03-24 20:30:07',
                'updated_at' => '2025-03-24 20:35:12',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Sick leave without pay',
                'description' => NULL,
                'with_pay' => 0,
                'created_at' => '2025-03-24 20:31:11',
                'updated_at' => '2025-03-24 20:32:59',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Leave with pay',
                'description' => NULL,
                'with_pay' => 1,
                'created_at' => '2025-03-24 20:35:19',
                'updated_at' => '2025-03-24 20:35:19',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Leave without pay',
                'description' => NULL,
                'with_pay' => 0,
                'created_at' => '2025-03-24 20:35:26',
                'updated_at' => '2025-03-24 20:35:26',
            ),
        ));
        
        
    }
}