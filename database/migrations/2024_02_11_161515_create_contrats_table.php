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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->string("numprojet")->nullable();
            $table->date("dateeffet")->nullable();
            $table->date("dateeche")->nullable();
            $table->date("datesaisie")->nullable();
            $table->integer("duree")->nullable();
            $table->string("periodicite")->nullable();
            $table->integer("differe")->nullable();
            $table->string("traite")->nullable();
            $table->string("etat")->nullable();
            $table->double("fraisacces")->nullable();
            $table->double("primetotale");
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->unsignedBigInteger('agence_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('rapprochement_id')->nullable();
            $table->foreign('produit_id')->references('id')
                                            ->on('produits')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('agence_id')->references('id')
                                            ->on('agences')
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
