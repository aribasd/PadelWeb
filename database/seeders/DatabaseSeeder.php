<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\ComunitatSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin de demo (admin@example.com / password) via env si vols.
        $this->call(AdminUserSeeder::class);

        // Usuaris de prova
        User::factory()
            ->count(10)
            ->create();

        // Usuari "fàcil" per entrar ràpid
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Comunitats + assignació d'usuaris
        $this->call(ComunitatSeeder::class);
    }
}
