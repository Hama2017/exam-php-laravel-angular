<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Classe;
use App\Models\Etudiant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
            Classe::factory(10)->create()->each(function ($classe) {
            Etudiant::factory(10)->create(['classe_id' => $classe->id]);
        });

    }
}
