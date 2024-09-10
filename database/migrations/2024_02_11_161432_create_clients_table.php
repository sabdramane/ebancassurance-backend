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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->nullable();
            $table->string("prenom")->nullable();
            $table->date("dateNaissance")->nullable();
            $table->string("genre")->nullable();
            $table->string("profession")->nullable();
            $table->string("lieuNaissance")->nullable();
            $table->string("telephone")->nullable();
            $table->string("email")->nullable();
            $table->string("boitepostale")->nullable();
            $table->string("numcompte")->nullable();
            $table->string("clerib")->nullable();
            $table->string("codeagence")->nullable();
            $table->unsignedBigInteger('agence_id')->nullable();
            $table->foreign('agence_id')->references('id')
                                            ->on('agences')
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
        Schema::dropIfExists('clients');
    }
};
