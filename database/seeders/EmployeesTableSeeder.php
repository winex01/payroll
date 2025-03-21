<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('employees')->delete();
        
        \DB::table('employees')->insert(array (
            0 => 
            array (
                'id' => 1,
                'photo' => 'photos/23657442-sZ3D.jpg',
                'employee_no' => '001',
                'last_name' => 'Damayo',
                'first_name' => 'Winnie',
                'middle_name' => 'Alterado',
                'tin' => NULL,
                'sss' => NULL,
                'pagibig' => NULL,
                'philhealth' => NULL,
                'home_address' => 'Near EVRMC hospital',
                'current_address' => 'Cabungahan Villaba Leyte',
                'house_no' => NULL,
                'street' => NULL,
                'barangay' => NULL,
                'city' => 'Ormoc',
                'province' => 'Leyte',
                'zip_code' => '6537',
                'gender_id' => 1,
                'birth_date' => NULL,
                'birth_place' => NULL,
                'civil_status_id' => 1,
                'date_of_marriage' => NULL,
                'telephone_no' => NULL,
                'mobile_no' => '09208783268',
                'personal_email' => 'winnie131212592@gmail.com',
                'company_email' => 'winnie131212592@gmail.com',
                'created_at' => '2025-03-21 13:43:41',
                'updated_at' => '2025-03-21 17:24:32',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'photo' => 'photos/images-1-lNpg.jpg',
                'employee_no' => '002',
                'last_name' => 'Cline',
                'first_name' => 'Aurora',
                'middle_name' => 'Ava Dalton',
                'tin' => NULL,
                'sss' => NULL,
                'pagibig' => NULL,
                'philhealth' => NULL,
                'home_address' => 'Quia sapiente pariat',
                'current_address' => 'Autem corporis proid',
                'house_no' => 'Aliquid eaque sit li',
                'street' => 'Unde assumenda quia',
                'barangay' => NULL,
                'city' => 'Ut laboris in lorem',
                'province' => 'Reiciendis harum acc',
                'zip_code' => '64310',
                'gender_id' => 1,
                'birth_date' => '1972-10-21',
                'birth_place' => 'Iure est consectetur',
                'civil_status_id' => 2,
                'date_of_marriage' => '1972-01-26',
            'telephone_no' => '+1 (603) 463-4688',
                'mobile_no' => NULL,
                'personal_email' => 'jixo@mailinator.com',
                'company_email' => 'pypob@mailinator.com',
                'created_at' => '2025-03-21 17:24:06',
                'updated_at' => '2025-03-21 17:24:16',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'photo' => 'photos/download-Xbin.jpg',
                'employee_no' => '003',
                'last_name' => 'Hansen',
                'first_name' => 'Seth',
                'middle_name' => 'Tatyana',
                'tin' => NULL,
                'sss' => NULL,
                'pagibig' => NULL,
                'philhealth' => NULL,
                'home_address' => 'Enim ut velit ab rec',
                'current_address' => 'Ab aliquip elit adi',
                'house_no' => 'Sunt et ipsam nemo v',
                'street' => 'Minim esse placeat',
                'barangay' => NULL,
                'city' => 'Velit maiores magni',
                'province' => 'Vel velit facere des',
                'zip_code' => '17616',
                'gender_id' => 2,
                'birth_date' => '1985-03-16',
                'birth_place' => 'Voluptas quo omnis o',
                'civil_status_id' => 4,
                'date_of_marriage' => '1994-11-21',
            'telephone_no' => '+1 (492) 872-7979',
                'mobile_no' => NULL,
                'personal_email' => 'ramoni@mailinator.com',
                'company_email' => 'dulavyjum@mailinator.com',
                'created_at' => '2025-03-21 17:25:09',
                'updated_at' => '2025-03-21 17:25:09',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'photo' => 'photos/images-3-Py6d.jpg',
                'employee_no' => '004',
                'last_name' => 'Barrera',
                'first_name' => 'Wallace',
                'middle_name' => 'Renee Hull',
                'tin' => NULL,
                'sss' => NULL,
                'pagibig' => NULL,
                'philhealth' => NULL,
                'home_address' => 'Non ullamco quisquam',
                'current_address' => 'Consequatur Tenetur',
                'house_no' => 'Non id possimus con',
                'street' => 'Dolor quisquam in do',
                'barangay' => NULL,
                'city' => 'Aut illo odit dolor',
                'province' => 'Id rem harum culpa',
                'zip_code' => '74048',
                'gender_id' => 2,
                'birth_date' => '2017-01-14',
                'birth_place' => 'Expedita similique f',
                'civil_status_id' => 1,
                'date_of_marriage' => '1987-08-05',
            'telephone_no' => '+1 (508) 819-2994',
                'mobile_no' => NULL,
                'personal_email' => 'rudebyje@mailinator.com',
                'company_email' => 'cedol@mailinator.com',
                'created_at' => '2025-03-21 17:25:51',
                'updated_at' => '2025-03-21 17:25:51',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}