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
        // Обновляем listings
        Schema::table('listings', function (Blueprint $table) {
            $table->string('listing_type')->nullable()->index()->after('category_id'); 
            // Пример: 'sell', 'rent', 'exchange', 'giveaway'
        });

        // Обновляем таблицы деталей
        Schema::table('listing_product_details', function (Blueprint $table) {
            $table->string('sub_type')->nullable()->index()->after('listing_id');
            // Пример: для Электроники - 'phone', 'laptop', 'accessory'
        });
        Schema::table('listing_service_details', function (Blueprint $table) {
            $table->string('sub_type')->nullable()->index()->after('listing_id');
        });
        Schema::table('listing_job_details', function (Blueprint $table) {
            $table->string('sub_type')->nullable()->index()->after('listing_id');
        });
        Schema::table('listing_person_details', function (Blueprint $table) {
            $table->string('sub_type')->nullable()->index()->after('listing_id');
        });
        Schema::table('listing_asset_details', function (Blueprint $table) {
            $table->string('sub_type')->nullable()->index()->after('listing_id');
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
