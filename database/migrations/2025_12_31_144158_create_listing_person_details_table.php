<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('listing_person_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->unique()->constrained()->cascadeOnDelete();
            
            $table->string('gender')->index(); // male, female
            $table->integer('age')->unsigned()->nullable()->index();
            $table->string('relationship_goal')->nullable(); // friendship, marriage, dating
            
            $table->string('height')->nullable();
            $table->string('education')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_person_details');
    }
};
