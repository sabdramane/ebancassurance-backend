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
        Schema::create('agence_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agence_id')->nullable();
            $table->foreign('agence_id')->references('id')
                                         ->on('agences')
                                         ->onDelete('cascade')
                                         ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')
                                         ->on('users')
                                         ->onDelete('cascade')
                                         ->onUpdate('cascade');
            $table->date('date_affectation')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agence_users');
    }
};
