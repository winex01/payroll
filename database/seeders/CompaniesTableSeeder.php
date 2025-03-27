<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('companies')->delete();
        
        \DB::table('companies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Company AAA',
                'address' => NULL,
                'contact_person' => NULL,
                'fax_number' => NULL,
                'mobile_no' => NULL,
                'telephone_no' => NULL,
                'pagibig' => NULL,
                'philhealth' => NULL,
                'sss' => NULL,
                'tax_id_number' => NULL,
                'bir_rdo' => NULL,
                'created_at' => '2025-03-21 17:52:42',
                'updated_at' => '2025-03-21 17:52:42',
            ),
        ));
        
        
    }
}