<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PayrollGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payroll_groups')->delete();
        
        \DB::table('payroll_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Group1',
                'created_at' => '2025-03-21 17:50:10',
                'updated_at' => '2025-03-21 17:50:10',
            ),
        ));
        
        
    }
}