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
        Schema::create('rapprochements', function (Blueprint $table) {
            $table->id();
            $table->string("libelle")->nullable();
            $table->string("datedebut")->nullable();
            $table->string("datefin")->nullable();
            $table->string("fichier_rapprochement")->nullable();
            $table->string("montanttotal_fichier")->nullable();
            $table->string("montantrapproche")->nullable();
            $table->string("montant_non_rapproche")->nullable();
            $table->unsignedBigInteger('banque_id')->nullable();
            $table->foreign('banque_id')->references('id')
                                        ->on('banques')
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
        Schema::dropIfExists('rapprochements');
    }
};
