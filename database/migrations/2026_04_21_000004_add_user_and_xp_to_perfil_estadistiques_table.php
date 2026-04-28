<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('perfil_estadistiques', 'user_id')) {
            Schema::table('perfil_estadistiques', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('perfil_estadistiques', 'experiencia')) {
            Schema::table('perfil_estadistiques', function (Blueprint $table) {
                $table->unsignedBigInteger('experiencia')->default(0)->after('nivell');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('perfil_estadistiques', 'user_id')) {
            Schema::table('perfil_estadistiques', function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }

        if (Schema::hasColumn('perfil_estadistiques', 'experiencia')) {
            Schema::table('perfil_estadistiques', function (Blueprint $table) {
                $table->dropColumn('experiencia');
            });
        }
    }
};

