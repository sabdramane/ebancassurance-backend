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
            $table->date("dateeffet");
            $table->date("dateeche");
            $table->date("datenaissance");
            $table->integer("duree");
            $table->integer("fraisacces");
            $table->string("periodicite");
            $table->integer("differe");
            $table->integer("traite");
            $table->double("primetotale");
            $table->unsignedBigInteger('agence_id')->nullable();
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->foreign('agence_id')->references('id')
                                            ->on('agences')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('produit_id')->references('id')
                                            ->on('produits')
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
