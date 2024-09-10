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
        Schema::create('banque_garantie_tarifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->foreign('produit_id')->references('id')
                                         ->on('produits')
                                         ->onDelete('cascade')
                                         ->onUpdate('cascade');
            $table->unsignedBigInteger('garantie_id')->nullable();
            $table->foreign('garantie_id')->references('id')
                                         ->on('garanties')
                                         ->onDelete('cascade')
                                         ->onUpdate('cascade');
            $table->unsignedBigInteger('banque_id')->nullable();
            $table->foreign('banque_id')->references('id')
                                         ->on('banques')
                                         ->onDelete('cascade')
                                         ->onUpdate('cascade');
            $table->unsignedBigInteger('tarif_id')->nullable();
            $table->foreign('tarif_id')->references('id')
                                         ->on('tarifs')
                                         ->onDelete('cascade')
                                         ->onUpdate('cascade');
            $table->string('typegara')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_garanties');
    }
};
