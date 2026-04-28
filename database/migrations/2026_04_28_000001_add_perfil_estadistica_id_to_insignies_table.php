<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('insignies', 'perfil_estadistica_id')) {
            Schema::table('insignies', function (Blueprint $table) {
                $table->foreignId('perfil_estadistica_id')
                    ->nullable()
                    ->after('dificultat')
                    ->constrained('perfil_estadistiques')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('insignies', 'perfil_estadistica_id')) {
            Schema::table('insignies', function (Blueprint $table) {
                $table->dropConstrainedForeignId('perfil_estadistica_id');
            });
        }
    }
};

