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
        // Eliminem la taula anterior en anglès si existeix (de desenvolupament).
        Schema::dropIfExists('direct_messages');

        Schema::create('missatges_privats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emissor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receptor_id')->constrained('users')->cascadeOnDelete();
            $table->text('missatge');
            $table->timestamps();

            $table->index(['emissor_id', 'receptor_id', 'created_at']);
            $table->index(['receptor_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missatges_privats');
    }
};
