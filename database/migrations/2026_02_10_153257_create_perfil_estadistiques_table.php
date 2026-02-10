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
        Schema::create('perfil_estadistiques', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('partits_jugats');
            $table->decimal('win_rate');
            $table->integer('nivell');
            $table->string('data_naixament');
            $table->string('foto_perfil')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfil_estadistiques');
    }
};
