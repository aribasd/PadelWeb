<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galeria', function (Blueprint $table) {
            if (!Schema::hasColumn('galeria', 'comunitat_id')) {
                $table
                    ->foreignId('comunitat_id')
                    ->nullable()
                    ->constrained('comunitats')
                    ->nullOnDelete()
                    ->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('galeria', function (Blueprint $table) {
            if (Schema::hasColumn('galeria', 'comunitat_id')) {
                $table->dropConstrainedForeignId('comunitat_id');
            }
        });
    }
};

