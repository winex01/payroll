<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_no' => $this->faker->unique()->numberBetween(1000, 9999),
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->lastName, // Optional middle name
            'tin' => $this->faker->optional()->numerify('###-###-###'),
            'sss' => $this->faker->optional()->numerify('##-#######-#'),
            'pagibig' => $this->faker->optional()->numerify('####-####-####'),
            'philhealth' => $this->faker->optional()->numerify('##-###-###-###'),
            'home_address' => $this->faker->address,
            'current_address' => $this->faker->address,
            'house_no' => $this->faker->optional()->buildingNumber,
            'street' => $this->faker->streetName,
            'barangay' => $this->faker->streetSuffix,
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'birth_date' => $this->faker->optional()->date('Y-m-d', 'now -18 years'), // Minimum age of 18
            'birth_place' => $this->faker->city,
            'date_of_marriage' => $this->faker->optional()->date('Y-m-d'),
            'telephone_no' => $this->faker->optional()->phoneNumber,
            'mobile_no' => $this->faker->optional()->phoneNumber,
            'personal_email' => $this->faker->optional()->safeEmail,
            'company_email' => $this->faker->optional()->companyEmail,
            'gender_id' => \App\Models\Gender::inRandomOrder()->first(),
            'civil_status_id' => \App\Models\CivilStatus::inRandomOrder()->first(),
        ];
    }
}
