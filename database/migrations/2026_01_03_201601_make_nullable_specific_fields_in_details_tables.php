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
        Schema::table('listings', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
        Schema::table('listings', function (Blueprint $table) {
            $table->decimal('price', 12, 2)
                  ->unsigned()
                  ->default(0)
                  ->nullable(false) // Гарантированно убираем NULL
                  ->change();
        });
        Schema::table('listing_service_details', function (Blueprint $table) {
            $table->string('service_type')->nullable()->change();
        });
        Schema::table('listing_job_details', function (Blueprint $table) {
            $table->string('job_type')->nullable()->change();
        });
        Schema::table('listing_person_details', function (Blueprint $table) {
            $table->string('gender')->nullable()->change();
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
