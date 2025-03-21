<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('password')
        ]);

        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(GendersTableSeeder::class);
        $this->call(CivilStatusesTableSeeder::class);
        $this->call(FamilyTypesTableSeeder::class);
        $this->call(JobStatusesTableSeeder::class);
        $this->call(EmploymentStatusesTableSeeder::class);
        $this->call(EmploymentDetailTypesTableSeeder::class);
        $this->call(PayBasesTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(DaysPerYearsTableSeeder::class);
        $this->call(ShiftSchedulesTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(PayrollGroupsTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
    }
}
