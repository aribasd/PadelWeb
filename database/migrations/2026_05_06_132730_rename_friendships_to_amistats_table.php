<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('friendships') && ! Schema::hasTable('amistats')) {
            Schema::rename('friendships', 'amistats');
        }

        if (Schema::hasTable('amistats')) {
            Schema::table('amistats', function (Blueprint $table) {
                if (Schema::hasColumn('amistats', 'sender_id')) {
                    $table->renameColumn('sender_id', 'emissor_id');
                }
                if (Schema::hasColumn('amistats', 'receiver_id')) {
                    $table->renameColumn('receiver_id', 'receptor_id');
                }
            });
        }

        // Renombrar ENUM de manera segura a MySQL (evita problemes de default).
        if (Schema::hasTable('amistats') && Schema::hasColumn('amistats', 'status') && ! Schema::hasColumn('amistats', 'estat')) {
            DB::statement("ALTER TABLE `amistats` CHANGE `status` `estat` ENUM('pending','accepted','declined') NOT NULL DEFAULT 'pending'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('amistats')) {
            Schema::table('amistats', function (Blueprint $table) {
                if (Schema::hasColumn('amistats', 'emissor_id')) {
                    $table->renameColumn('emissor_id', 'sender_id');
                }
                if (Schema::hasColumn('amistats', 'receptor_id')) {
                    $table->renameColumn('receptor_id', 'receiver_id');
                }
            });
        }

        if (Schema::hasTable('amistats') && Schema::hasColumn('amistats', 'estat') && ! Schema::hasColumn('amistats', 'status')) {
            DB::statement("ALTER TABLE `amistats` CHANGE `estat` `status` ENUM('pending','accepted','declined') NOT NULL DEFAULT 'pending'");
        }

        if (Schema::hasTable('amistats') && ! Schema::hasTable('friendships')) {
            Schema::rename('amistats', 'friendships');
        }
    }
};
