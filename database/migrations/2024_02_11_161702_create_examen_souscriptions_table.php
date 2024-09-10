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
        Schema::create('examen_souscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categorie_produit_id')->nullable();
            $table->unsignedBigInteger('examen_id')->nullable();
            $table->unsignedBigInteger('tranche_age_id')->nullable();
            $table->unsignedBigInteger('tranche_capital_id')->nullable();
            $table->foreign('categorie_produit_id')->references('id')
                        ->on('categorie_produits')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            $table->foreign('examen_id')->references('id')
                        ->on('examens')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            $table->foreign('tranche_age_id')->references('id')
                        ->on('tranche_ages')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            $table->foreign('tranche_capital_id')->references('id')
                        ->on('tranche_capitals')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examen_souscriptions');
    }
};
