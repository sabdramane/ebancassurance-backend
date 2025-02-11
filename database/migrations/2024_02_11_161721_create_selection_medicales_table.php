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
        Schema::create('selection_medicales', function (Blueprint $table) {
            $table->id();
            $table->date("dateedition")->nullable();
            $table->unsignedBigInteger('medecin_conseil_id')->nullable();
            $table->unsignedBigInteger('examen_souscription_id')->nullable();
            $table->unsignedBigInteger('contrat_id')->nullable();
            $table->foreign('medecin_conseil_id')->references('id')
                        ->on('medecin_conseils')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            $table->foreign('examen_souscription_id')->references('id')
                        ->on('examen_souscriptions')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            $table->foreign('contrat_id')->references('id')
                        ->on('contrats')
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
        Schema::dropIfExists('selection_medicales');
    }
};
