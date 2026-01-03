<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Обновляем таблицу listings: меняем city на location_id
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->foreignId('location_id')->after('category_id')->index()->nullable()->default(null)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
