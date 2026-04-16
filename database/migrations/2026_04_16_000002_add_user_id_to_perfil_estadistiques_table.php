<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perfil_estadistiques', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->constrained('users')
                ->nullOnDelete()
                ->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('perfil_estadistiques', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};

