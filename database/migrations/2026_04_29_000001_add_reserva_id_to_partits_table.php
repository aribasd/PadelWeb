<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('partits', 'reserva_id')) {
            Schema::table('partits', function (Blueprint $table) {
                $table->foreignId('reserva_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('reserves')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('partits', 'reserva_id')) {
            Schema::table('partits', function (Blueprint $table) {
                $table->dropConstrainedForeignId('reserva_id');
            });
        }
    }
};

