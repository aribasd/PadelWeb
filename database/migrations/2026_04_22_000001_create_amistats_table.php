<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('amistats')) {
            Schema::create('amistats', function (Blueprint $table) {
                $table->id();
                $table->timestamps();

                $table->foreignId('emissor_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('receptor_id')->constrained('users')->cascadeOnDelete();
                $table->enum('estat', ['pending', 'accepted', 'declined'])->default('pending');

                $table->unique(['emissor_id', 'receptor_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('amistats');
    }
};

