<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmploymentDetailTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('employment_detail_types')->delete();
        
        \DB::table('employment_detail_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Company',
                'parent_id' => NULL,
                'lft' => 2,
                'rgt' => 3,
                'depth' => 1,
                'created_at' => '2024-10-17 19:48:42',
                'updated_at' => '2024-10-17 19:48:42',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Job Status',
                'parent_id' => NULL,
                'lft' => 4,
                'rgt' => 5,
                'depth' => 1,
                'created_at' => '2024-10-17 19:48:58',
                'updated_at' => '2024-10-18 18:54:35',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Employment Status',
                'parent_id' => NULL,
                'lft' => 6,
                'rgt' => 7,
                'depth' => 1,
                'created_at' => '2024-10-17 19:49:10',
                'updated_at' => '2024-10-18 15:18:26',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Basic Rate',
                'parent_id' => NULL,
                'lft' => 8,
                'rgt' => 9,
                'depth' => 1,
                'created_at' => '2024-10-17 19:53:28',
                'updated_at' => '2024-10-17 19:53:28',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Basic Adjustment',
                'parent_id' => NULL,
                'lft' => 10,
                'rgt' => 11,
                'depth' => 1,
                'created_at' => '2024-10-17 19:53:35',
                'updated_at' => '2024-10-17 19:53:35',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Department',
                'parent_id' => NULL,
                'lft' => 12,
                'rgt' => 13,
                'depth' => 1,
                'created_at' => '2024-10-17 19:53:53',
                'updated_at' => '2024-10-17 19:54:41',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Days Per Year',
                'parent_id' => NULL,
                'lft' => 14,
                'rgt' => 15,
                'depth' => 1,
                'created_at' => '2024-10-17 19:55:51',
                'updated_at' => '2024-10-18 15:18:37',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Pay Basis',
                'parent_id' => NULL,
                'lft' => 16,
                'rgt' => 17,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:00',
                'updated_at' => '2024-10-18 15:18:47',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Payment Method',
                'parent_id' => NULL,
                'lft' => 18,
                'rgt' => 19,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:06',
                'updated_at' => '2024-10-18 15:18:53',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Date Applied',
                'parent_id' => NULL,
                'lft' => 20,
                'rgt' => 21,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:14',
                'updated_at' => '2024-10-17 19:56:14',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Date Hired',
                'parent_id' => NULL,
                'lft' => 22,
                'rgt' => 23,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:21',
                'updated_at' => '2024-10-17 19:56:21',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Payroll Group',
                'parent_id' => NULL,
                'lft' => 24,
                'rgt' => 25,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:31',
                'updated_at' => '2024-10-18 18:18:20',
            ),
        ));
        
        
    }
}