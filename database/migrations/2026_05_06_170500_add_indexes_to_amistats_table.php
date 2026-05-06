<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('amistats')) {
            return;
        }

        Schema::table('amistats', function (Blueprint $table) {
            // Agilitza: sol·licituds pendents enviades/rebudes i llistat d'amistats acceptades.
            // Noms d'índex explícits per poder fer rollback de forma segura.
            $table->index(['emissor_id', 'estat', 'created_at'], 'amistats_emissor_estat_created_at_idx');
            $table->index(['receptor_id', 'estat', 'created_at'], 'amistats_receptor_estat_created_at_idx');
            $table->index(['estat', 'updated_at'], 'amistats_estat_updated_at_idx');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('amistats')) {
            return;
        }

        Schema::table('amistats', function (Blueprint $table) {
            $table->dropIndex('amistats_emissor_estat_created_at_idx');
            $table->dropIndex('amistats_receptor_estat_created_at_idx');
            $table->dropIndex('amistats_estat_updated_at_idx');
        });
    }
};

