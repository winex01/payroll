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
                'validation' => 'required|exists:companies,id',
                'parent_id' => NULL,
                'lft' => 2,
                'rgt' => 3,
                'depth' => 1,
                'created_at' => '2024-10-17 19:48:42',
                'updated_at' => '2024-10-26 22:49:08',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Job Status',
                'validation' => 'required|exists:job_statuses,id',
                'parent_id' => NULL,
                'lft' => 4,
                'rgt' => 5,
                'depth' => 1,
                'created_at' => '2024-10-17 19:48:58',
                'updated_at' => '2024-10-26 22:49:14',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Employment Status',
                'validation' => 'required|exists:employment_statuses,id',
                'parent_id' => NULL,
                'lft' => 6,
                'rgt' => 7,
                'depth' => 1,
                'created_at' => '2024-10-17 19:49:10',
                'updated_at' => '2024-10-26 22:49:20',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Basic Rate',
                'validation' => 'required|numeric|gt:0',
                'parent_id' => NULL,
                'lft' => 8,
                'rgt' => 9,
                'depth' => 1,
                'created_at' => '2024-10-17 19:53:28',
                'updated_at' => '2024-11-26 11:46:19',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Basic Adjustment',
                'validation' => 'required|numeric|min:0',
                'parent_id' => NULL,
                'lft' => 10,
                'rgt' => 11,
                'depth' => 1,
                'created_at' => '2024-10-17 19:53:35',
                'updated_at' => '2024-11-26 11:44:07',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Department',
                'validation' => 'required|exists:departments,id',
                'parent_id' => NULL,
                'lft' => 12,
                'rgt' => 13,
                'depth' => 1,
                'created_at' => '2024-10-17 19:53:53',
                'updated_at' => '2024-10-26 22:49:26',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Days Per Year',
                'validation' => 'required|exists:days_per_years,id',
                'parent_id' => NULL,
                'lft' => 14,
                'rgt' => 15,
                'depth' => 1,
                'created_at' => '2024-10-17 19:55:51',
                'updated_at' => '2024-10-26 22:49:31',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Pay Basis',
                'validation' => 'required|exists:pay_bases,id',
                'parent_id' => NULL,
                'lft' => 16,
                'rgt' => 17,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:00',
                'updated_at' => '2024-10-26 22:49:41',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Payment Method',
                'validation' => 'required|exists:payment_methods,id',
                'parent_id' => NULL,
                'lft' => 18,
                'rgt' => 19,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:06',
                'updated_at' => '2024-10-26 22:49:46',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Date Applied',
                'validation' => 'required|date',
                'parent_id' => NULL,
                'lft' => 20,
                'rgt' => 21,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:14',
                'updated_at' => '2024-11-25 18:52:32',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Date Hired',
                'validation' => 'required|date',
                'parent_id' => NULL,
                'lft' => 22,
                'rgt' => 23,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:21',
                'updated_at' => '2024-11-25 18:52:36',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Payroll Group',
                'validation' => 'required|exists:payroll_groups,id',
                'parent_id' => NULL,
                'lft' => 24,
                'rgt' => 25,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:31',
                'updated_at' => '2024-10-26 22:49:56',
            ),
        ));
        
        
    }
}