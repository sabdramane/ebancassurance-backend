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
        Schema::create('tableau_tarifs', function (Blueprint $table) {
            $table->id();
            $table->integer("age")->nullable();
            $table->integer("duree_min")->nullable();
            $table->integer("duree_max")->nullable();
            $table->string("taux")->nullable();
            $table->unsignedBigInteger('tarif_id')->nullable();
            $table->foreign('tarif_id')->references('id')
                                            ->on('tarifs')
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
        Schema::dropIfExists('tableau_tarifs');
    }
};
