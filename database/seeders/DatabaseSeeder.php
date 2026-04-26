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
        // Comptes par defaut pour la demonstration
        User::factory()->create([
            'name' => 'Admin Cabinet',
            'email' => 'admin@cabinet.test',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Patient Test',
            'email' => 'patient@cabinet.test',
            'role' => 'patient',
        ]);

        User::factory()->create([
            'name' => 'Medecin Test',
            'email' => 'medecin@cabinet.test',
            'role' => 'medecin',
        ]);

        // Jeu de donnees minimal: 10 utilisateurs
        User::factory(4)->create(['role' => 'patient']);
        User::factory(3)->create(['role' => 'medecin']);
        Service::factory(5)->create();

        // Jeu de donnees minimal: 20 rendez-vous
        RendezVous::factory(20)->create();
    }
}
