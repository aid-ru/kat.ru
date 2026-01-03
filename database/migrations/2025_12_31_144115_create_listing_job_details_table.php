<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('listing_job_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->unique()->constrained()->cascadeOnDelete();
            
            $table->string('job_type')->index(); // vacancy (вакансия), resume (резюме)
            $table->string('employment_type')->nullable(); // full-time, part-time, project
            $table->string('schedule')->nullable(); // remote, office, shift
            
            $table->decimal('salary_from', 12, 2)->nullable()->index();
            $table->decimal('salary_to', 12, 2)->nullable()->index();
            $table->string('currency')->default('RUB');
            
            $table->string('experience_years')->nullable(); // без опыта, 1-3 года и т.д.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_job_details');
    }
};
