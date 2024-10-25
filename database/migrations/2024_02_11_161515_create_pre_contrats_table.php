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
        Schema::create('pre_contrats', function (Blueprint $table) {
            $table->id();
            $table->string("numprojet")->nullable();
            $table->string("dateeffet")->nullable();
            $table->string("dateeche")->nullable();
            $table->string("datesaisie")->nullable();
            $table->integer("duree_amort")->nullable();
            $table->integer("duree_pret")->nullable();
            $table->string("periodicite")->nullable();
            $table->string("type_pret")->nullable();
            $table->integer("differe")->nullable();
            $table->string("montant_traite")->nullable();
            $table->string("montantpret")->nullable();
            $table->string("capitalprevoyance")->nullable();
            $table->boolean("beogo")->nullable();
            $table->double("prime_nette_flex")->nullable();
            $table->double("prime_nette_prevoyance")->nullable();
            $table->double("prime_perte_emploi")->nullable();
            $table->double("prime_beogo")->nullable();
            $table->double("cout_police")->nullable();
            $table->double("primetotale")->nullable();
            $table->string("etat")->nullable();
            $table->string("contrat_travail")->nullable();
            $table->string("contrat_travail_ext")->nullable();
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->unsignedBigInteger('agence_id')->nullable();
            $table->unsignedBigInteger('banque_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('rapprochement_id')->nullable();
            $table->unsignedBigInteger('beneficiaire_id')->nullable();
            $table->foreign('produit_id')->references('id')
                                            ->on('produits')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('agence_id')->references('id')
                                            ->on('agences')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('banque_id')->references('id')
                                            ->on('banques')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('client_id')->references('id')
                                            ->on('clients')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('rapprochement_id')->references('id')
                                            ->on('rapprochements')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('beneficiaire_id')->references('id')
                                            ->on('beneficiaires')
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
        Schema::dropIfExists('contrats');
    }
};
