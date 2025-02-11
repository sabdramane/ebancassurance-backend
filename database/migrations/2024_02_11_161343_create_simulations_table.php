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
        Schema::create('simulations', function (Blueprint $table) {
            $table->id();
            $table->date("datenaissance");
            $table->integer("duree_amort");
            $table->integer("duree_pret");
            $table->string("periodicite");
            $table->integer("differe");
            $table->integer("montantpret");
            $table->integer("capitalprevoyance");
            $table->integer("montant_traite");
            $table->boolean("beogo");
            $table->double("prime_nette_flex");
            $table->double("prime_nette_prevoyance");
            $table->double("prime_perte_emploi");
            $table->double("prime_beogo");
            $table->double("primetotale");
            $table->unsignedBigInteger('banque_id')->nullable();
            $table->unsignedBigInteger('agence_id')->nullable();
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('banque_id')->references('id')
                                            ->on('banques')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('agence_id')->references('id')
                                            ->on('agences')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('produit_id')->references('id')
                                            ->on('produits')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')
                                            ->on('users')
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
        Schema::dropIfExists('simulations');
    }
};
