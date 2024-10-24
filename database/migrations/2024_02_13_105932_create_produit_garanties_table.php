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
        Schema::create('produit_garanties', function (Blueprint $table) {
            $table->id();
            $table->string('nature')->nullable();
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
