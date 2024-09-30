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
        Schema::create('beneficiaires', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->nullable();
            $table->string("prenom")->nullable();
            $table->string("telephone")->nullable();
            $table->string("adresse")->nullable();
            $table->string("ville")->nullable();
            $table->string("typebeneficiaire")->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('contrat_id')->nullable();
            $table->foreign('client_id')->references('id')
                                            ->on('clients')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('contrat_id')->references('id')
                                            ->on('contrats')
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
        Schema::dropIfExists('beneficiaires');
    }
};
