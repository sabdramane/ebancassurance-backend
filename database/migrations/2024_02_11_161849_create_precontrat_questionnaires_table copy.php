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
        Schema::create('precontrat_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string("valeur")->nullable();
            $table->string("motif")->nullable();
            $table->date("datesurvenance")->nullable();
            $table->unsignedBigInteger('precontrat_id')->nullable();
            $table->unsignedBigInteger('questionnaire_medical_id')->nullable();
            $table->foreign('precontrat_id')->references('id')
                                            ->on('pre_contrats')
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
        Schema::dropIfExists('precontrat_questionnaires');
    }
};
