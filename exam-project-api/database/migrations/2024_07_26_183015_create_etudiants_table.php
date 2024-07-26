<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtudiantsTable extends Migration
{
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('code', 12)->unique();
            $table->string('nom', 100);
            $table->string('prenom', 150);
            $table->date('date_de_naissance');
            $table->string('adresse', 100);
            $table->foreignId('classe_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
}
