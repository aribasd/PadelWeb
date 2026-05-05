<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE `partits` MODIFY `nom1` VARCHAR(255) NULL');
        DB::statement('ALTER TABLE `partits` MODIFY `nom2` VARCHAR(255) NULL');
        DB::statement('ALTER TABLE `partits` MODIFY `nom3` VARCHAR(255) NULL');
        DB::statement('ALTER TABLE `partits` MODIFY `nom4` VARCHAR(255) NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE `partits` MODIFY `nom1` VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE `partits` MODIFY `nom2` VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE `partits` MODIFY `nom3` VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE `partits` MODIFY `nom4` VARCHAR(255) NOT NULL');
    }
};

