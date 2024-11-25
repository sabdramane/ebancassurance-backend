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
        Schema::create('prestations', function (Blueprint $table) {
            $table->id();
            $table->string("date_declaration")->nullable();
            $table->string("date_survenance")->nullable();
            $table->string("numerocontrat")->nullable();
            $table->string("etat")->default('declaré');
            $table->unsignedBigInteger('type_prestation_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string("declaration")->nullable();
            $table->string("contrat_assurance")->nullable();
            $table->string("piece_identite")->nullable();
            $table->string("tableau_amortissement")->nullable();
            $table->string("acte_deces")->nullable();
            $table->string("certificat_deces")->nullable();
            $table->string("acte_licenciement")->nullable();
            $table->string("certificat_travail")->nullable();
            $table->string("invalidite")->nullable();
            $table->foreign('type_prestation_id')->references('id')
                                            ->on('type_prestations')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('client_id')->references('id')
                                            ->on('clients')
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
        Schema::dropIfExists('prestations');
    }
};
