<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comunitat_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comunitat_id')->constrained('comunitats')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('rol', 32)->default('usuari');
            $table->timestamps();

            $table->unique(['comunitat_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comunitat_user');
    }
};
