<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("codeagence")->nullable();
            $table->string("numcompte")->nullable();
            $table->string("clerib")->nullable();
            $table->string("nom")->nullable();
            $table->string("prenom")->nullable();
            $table->string("dateNaissance")->nullable();
            $table->string("civilite")->nullable();
            $table->string("profession")->nullable();
            $table->string("lieuNaissance")->nullable();
            $table->string("telephone")->nullable();
            $table->string("email")->nullable();
            $table->string("boitepostale")->nullable();
            $table->string("adresse")->nullable();
            $table->string("ville")->nullable();
            $table->string("numcnib")->nullable();
            $table->string("fichier_cnib")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
