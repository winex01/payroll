<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FamilyTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('family_types')->delete();
        
        \DB::table('family_types')->insert(array (
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
                'name' => 'Cousin',
                'created_at' => '2024-09-28 14:35:42',
                'updated_at' => '2024-09-28 14:35:42',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Niece',
                'created_at' => '2024-09-28 14:35:53',
                'updated_at' => '2024-09-28 14:35:53',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Nephew',
                'created_at' => '2024-09-28 14:35:59',
                'updated_at' => '2024-09-28 14:35:59',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Foster Parent',
                'created_at' => '2024-09-28 14:36:14',
                'updated_at' => '2024-09-28 14:36:14',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Step-Parent',
                'created_at' => '2024-09-28 14:36:31',
                'updated_at' => '2024-09-28 14:36:31',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Step-Child',
                'created_at' => '2024-09-28 14:36:44',
                'updated_at' => '2024-09-28 14:36:44',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Live-in Partner',
                'created_at' => '2024-09-28 14:37:56',
                'updated_at' => '2024-09-28 14:37:56',
            ),
        ));
        
        
    }
}