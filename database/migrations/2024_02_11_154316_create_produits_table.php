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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string("codeprod")->unique();
            $table->string("libeprod")->nullable();
            $table->string("descprod")->nullable();
            $table->unsignedBigInteger('categorie_produit_id')->nullable();
            $table->foreign('categorie_produit_id')->references('id')
                                            ->on('categorie_produits')
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
        Schema::dropIfExists('produits');
    }
};
