<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payment_methods')->delete();
        
        \DB::table('payment_methods')->insert(array (
            0 => 
            array (
                'id' => 1,
            'name' => 'Bank (ATM)',
                'created_at' => '2024-10-24 13:22:33',
                'updated_at' => '2024-10-24 13:22:33',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Cash',
                'created_at' => '2024-10-24 13:22:42',
                'updated_at' => '2024-10-24 13:22:42',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Check',
                'created_at' => '2024-10-24 13:22:50',
                'updated_at' => '2024-10-24 13:22:50',
            ),
        ));
        
        
    }
}