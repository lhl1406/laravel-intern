<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Director',
            'email' => 'director@gmail.com',
            'password' => Hash::make('password'),
            'group_id' =>  1,
            'started_date' => now(),
            'position_id' => 0,
            'created_date' => now(),
            'updated_date' => now(),
        ];
        
    }
}
