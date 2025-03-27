<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('departments')->delete();
        
        \DB::table('departments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'IT',
                'created_at' => '2025-03-21 17:50:32',
                'updated_at' => '2025-03-21 17:50:32',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'HR',
                'created_at' => '2025-03-21 17:50:38',
                'updated_at' => '2025-03-21 17:50:38',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Accounting',
                'created_at' => '2025-03-21 17:50:46',
                'updated_at' => '2025-03-21 17:50:46',
            ),
        ));
        
        
    }
}