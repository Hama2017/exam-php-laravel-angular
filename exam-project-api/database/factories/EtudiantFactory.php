<?php

namespace Database\Factories;

use App\Models\Etudiant;
use App\Models\Classe;
use Illuminate\Database\Eloquent\Factories\Factory;

class EtudiantFactory extends Factory
{
    protected $model = Etudiant::class;

    public function definition()
    {
        // Assuming you have a method to generate the student code as defined previously
        $classe = Classe::factory()->create();
        $prenom = $this->faker->firstName;
        $nom = $this->faker->lastName;
        $date_de_naissance = $this->faker->date('Y-m-d');

        return [
            'code' => $this->generateStudentCode($classe->id, $prenom, $nom, $date_de_naissance),
            'nom' => $nom,
            'prenom' => $prenom,
            'date_de_naissance' => $date_de_naissance,
            'adresse' => $this->faker->address,
            'classe_id' => $classe->id,
        ];
    }

    private function generateStudentCode($classe_id, $prenom, $nom, $date_de_naissance)
    {
        $firstLetterPrenom = strtoupper(substr($prenom, 0, 1));
        $firstLetterNom = strtoupper(substr($nom, 0, 1));
        $anneeNaissance = date('Y', strtotime($date_de_naissance));
        $randomNumber = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

        return $classe_id . $firstLetterPrenom . $firstLetterNom . $anneeNaissance . $randomNumber;
    }
}

