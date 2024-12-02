<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PayBasesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('pay_bases')->delete();

        \DB::table('pay_bases')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'Daily Paid',
                    'created_at' => '2024-10-24 13:17:50',
                    'updated_at' => '2024-10-24 13:17:50',
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'Hourly Paid',
                    'created_at' => '2024-10-24 13:18:02',
                    'updated_at' => '2024-10-24 13:18:02',
                ),
            2 =>
                array(
                    'id' => 3,
                    'name' => 'Monthly Paid',
                    'created_at' => '2024-10-24 13:18:12',
                    'updated_at' => '2024-10-24 13:18:12',
                ),
            3 =>
                array(
                    'id' => 4,
                    'name' => 'Pro-rated Monthly Paid',
                    'created_at' => '2024-10-24 13:18:20',
                    'updated_at' => '2024-10-24 13:18:20',
                ),
        ));


    }
}
