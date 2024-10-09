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
        Schema::create('contrat_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string("valeur")->nullable();
            $table->string("description")->nullable();
            $table->date("datesurvenance")->nullable();
            $table->unsignedBigInteger('contrat_id')->nullable();
            $table->unsignedBigInteger('questionnaire_medical_id')->nullable();
            $table->foreign('contrat_id')->references('id')
                                            ->on('contrats')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('questionnaire_medical_id')->references('id')
                                            ->on('questionnaire_medicals')
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
        Schema::dropIfExists('contrat_questionnaires');
    }
};
