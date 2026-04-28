<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pistes', 'comunitat_id')) {
            Schema::table('pistes', function (Blueprint $table) {
                $table->foreignId('comunitat_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('comunitats')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pistes', 'comunitat_id')) {
            Schema::table('pistes', function (Blueprint $table) {
                $table->dropConstrainedForeignId('comunitat_id');
            });
        }
    }
};

