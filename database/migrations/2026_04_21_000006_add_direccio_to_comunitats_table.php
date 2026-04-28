<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('comunitats', 'direccio')) {
            Schema::table('comunitats', function (Blueprint $table) {
                $table->string('direccio')->nullable()->after('descripcio');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('comunitats', 'direccio')) {
            Schema::table('comunitats', function (Blueprint $table) {
                $table->dropColumn('direccio');
            });
        }
    }
};

