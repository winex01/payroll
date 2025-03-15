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
                'name' => 'company',
                'validation' => 'required|exists:companies,id',
                'parent_id' => NULL,
                'lft' => 2,
                'rgt' => 3,
                'depth' => 1,
                'created_at' => '2024-10-17 19:48:42',
                'updated_at' => '2025-03-15 12:44:19',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'job_status',
                'validation' => 'required|exists:job_statuses,id',
                'parent_id' => NULL,
                'lft' => 4,
                'rgt' => 5,
                'depth' => 1,
                'created_at' => '2024-10-17 19:48:58',
                'updated_at' => '2025-03-15 12:43:11',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'employment_status',
                'validation' => 'required|exists:employment_statuses,id',
                'parent_id' => NULL,
                'lft' => 6,
                'rgt' => 7,
                'depth' => 1,
                'created_at' => '2024-10-17 19:49:10',
                'updated_at' => '2025-03-15 12:44:30',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'basic_rate',
                'validation' => 'required|numeric|gt:0',
                'parent_id' => NULL,
                'lft' => 8,
                'rgt' => 9,
                'depth' => 1,
                'created_at' => '2024-10-17 19:53:28',
                'updated_at' => '2025-03-15 12:44:39',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'basic_adjustment',
                'validation' => 'required|numeric|min:0',
                'parent_id' => NULL,
                'lft' => 10,
                'rgt' => 11,
                'depth' => 1,
                'created_at' => '2024-10-17 19:53:35',
                'updated_at' => '2025-03-15 12:44:48',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'department',
                'validation' => 'required|exists:departments,id',
                'parent_id' => NULL,
                'lft' => 12,
                'rgt' => 13,
                'depth' => 1,
                'created_at' => '2024-10-17 19:53:53',
                'updated_at' => '2025-03-15 12:44:55',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'days_per_year',
                'validation' => 'required|exists:days_per_years,id',
                'parent_id' => NULL,
                'lft' => 14,
                'rgt' => 15,
                'depth' => 1,
                'created_at' => '2024-10-17 19:55:51',
                'updated_at' => '2025-03-15 12:45:09',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'pay_basis',
                'validation' => 'required|exists:pay_bases,id',
                'parent_id' => NULL,
                'lft' => 16,
                'rgt' => 17,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:00',
                'updated_at' => '2025-03-15 12:45:19',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'payment_method',
                'validation' => 'required|exists:payment_methods,id',
                'parent_id' => NULL,
                'lft' => 18,
                'rgt' => 19,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:06',
                'updated_at' => '2025-03-15 12:45:31',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'date_hired',
                'validation' => 'required|date',
                'parent_id' => NULL,
                'lft' => 20,
                'rgt' => 21,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:14',
                'updated_at' => '2025-03-15 12:45:41',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'date_started',
                'validation' => 'required|date',
                'parent_id' => NULL,
                'lft' => 22,
                'rgt' => 23,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:21',
                'updated_at' => '2025-03-15 12:45:55',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'payroll_group',
                'validation' => 'required|exists:payroll_groups,id',
                'parent_id' => NULL,
                'lft' => 24,
                'rgt' => 25,
                'depth' => 1,
                'created_at' => '2024-10-17 19:56:31',
                'updated_at' => '2025-03-15 12:46:04',
            ),
        ));
        
        
    }
}