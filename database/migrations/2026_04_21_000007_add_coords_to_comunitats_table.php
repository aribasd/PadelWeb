<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comunitats', function (Blueprint $table) {
            if (!Schema::hasColumn('comunitats', 'lat')) {
                $table->decimal('lat', 10, 7)->nullable()->after('direccio');
            }
            if (!Schema::hasColumn('comunitats', 'lng')) {
                $table->decimal('lng', 10, 7)->nullable()->after('lat');
            }
        });
    }

    public function down(): void
    {
        Schema::table('comunitats', function (Blueprint $table) {
            if (Schema::hasColumn('comunitats', 'lng')) {
                $table->dropColumn('lng');
            }
            if (Schema::hasColumn('comunitats', 'lat')) {
                $table->dropColumn('lat');
            }
        });
    }
};

