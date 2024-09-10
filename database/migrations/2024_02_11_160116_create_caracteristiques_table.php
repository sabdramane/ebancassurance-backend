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
        Schema::create('caracteristiques', function (Blueprint $table) {
            $table->id();
            $table->boolean("capital")->unique();
            $table->boolean("duree")->nullable();
            $table->boolean("traite")->nullable();
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
        Schema::dropIfExists('caracteristiques');
    }
};
