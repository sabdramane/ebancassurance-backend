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
        Schema::create('simulation_garanties', function (Blueprint $table) {
            $table->id();
            $table->double("prime")->nullable();
            $table->integer("capital")->nullable();
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->unsignedBigInteger('garantie_id')->nullable();
            $table->unsignedBigInteger('simulation_id')->nullable();
            $table->foreign('produit_id')->references('id')
                                            ->on('produits')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('garantie_id')->references('id')
                                            ->on('garanties')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('simulation_id')->references('id')
                                            ->on('simulations')
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
        Schema::dropIfExists('simulation_garanties');
    }
};
