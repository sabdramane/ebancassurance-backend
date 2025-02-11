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
        Schema::create('agences', function (Blueprint $table) {
            $table->id();
            $table->string("codeagence");
            $table->string("libeagence");
            $table->string("abrevagence")->nullabe();
            $table->string("adresse")->nullabe();
            $table->string("contact")->nullabe();
            $table->unsignedBigInteger('banque_id')->nullable();
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->foreign('banque_id')->references('id')
                                            ->on('banques')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
            $table->foreign('ville_id')->references('id')
                                            ->on('villes')
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
        Schema::dropIfExists('agences');
    }
};
