<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GendersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('genders')->delete();
        
        \DB::table('genders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Male',
                'created_at' => '2024-09-27 14:09:23',
                'updated_at' => '2024-09-27 14:09:23',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Female',
                'created_at' => '2024-09-27 14:09:42',
                'updated_at' => '2024-09-27 14:09:42',
            ),
        ));
        
        
    }
}