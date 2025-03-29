<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RelationshipsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('relationships')->delete();
        
        \DB::table('relationships')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Father',
                'created_at' => '2024-09-28 14:30:52',
                'updated_at' => '2024-09-28 14:30:52',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Mother',
                'created_at' => '2024-09-28 14:30:56',
                'updated_at' => '2024-09-28 14:30:56',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Spouse',
                'created_at' => '2024-09-28 14:31:02',
                'updated_at' => '2024-09-28 14:31:02',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Child',
                'created_at' => '2024-09-28 14:31:40',
                'updated_at' => '2024-09-28 14:31:40',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Sibling',
                'created_at' => '2024-09-28 14:33:27',
                'updated_at' => '2024-09-28 14:33:27',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Grandfather',
                'created_at' => '2024-09-28 14:34:29',
                'updated_at' => '2024-09-28 14:34:29',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Grandmother',
                'created_at' => '2024-09-28 14:34:38',
                'updated_at' => '2024-09-28 14:34:38',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Grandchild',
                'created_at' => '2024-09-28 14:34:52',
                'updated_at' => '2024-09-28 14:34:52',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Aunt',
                'created_at' => '2024-09-28 14:35:27',
                'updated_at' => '2024-09-28 14:35:27',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Uncle',
                'created_at' => '2024-09-28 14:35:35',
                'updated_at' => '2024-09-28 14:35:35',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Relative',
                'created_at' => '2024-09-28 14:35:42',
                'updated_at' => '2024-09-28 14:35:42',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Character Reference',
                'created_at' => '2025-03-29 21:55:57',
                'updated_at' => '2025-03-29 21:55:57',
            ),
        ));
        
        
    }
}