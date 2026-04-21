<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {



        $services = [
            'Consultation Générale',
            'Consultation Pédiatrique',
            'Consultation Gynécologique',
            'Consultation Cardiologique',
            'Consultation Dermatologique',
            'Consultation Psychologique',
            'Consultation Dentaire',
            'Consultation Ophtalmologique',
            'Consultation Orthopédique',
            'Consultation Nutritionniste',
        ];


        return [
            "name" => fake()->randomElement($services)
        ];
    }
}
