<?php

namespace Database\Seeders;

use App\Models\RendezVous;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(5)->create(['role' => 'patient']);
        User::factory(3)->create(['role' => 'medecin']);
        Service::factory(5)->create();

        RendezVous::factory(20)->create();
    }
}
