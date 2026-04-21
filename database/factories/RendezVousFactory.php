<?php

namespace Database\Factories;

use App\Models\RendezVous;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RendezVous>
 */
class RendezVousFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => User::where('role', 'patient')->inRandomOrder()->first()->id,
            'medecin_id' => User::where('role', 'medecin')->inRandomOrder()->first()->id,
            'service_id' => Service::inRandomOrder()->first()->id,
            'date_heure' => $this->faker->dateTimeBetween('now', '+3 months'),
            'statut'     => $this->faker->randomElement(['en_attente', 'confirme', 'annule']),
        ];
    }
}
