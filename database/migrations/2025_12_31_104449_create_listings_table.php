<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Основная таблица: только то, что нужно для листинга и поиска по базовым фильтрам
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->index();
            
            $table->string('title')->index(); 
            $table->text('description');
            $table->decimal('price', 12, 2)->unsigned()->index();
            
            $table->string('condition')->nullable()->index(); // new, used
            $table->string('status')->default('active')->index();
            $table->string('city')->index();
            
            $table->timestamps();
        });

        // Характеристики товаров народного потребления (ТНП)
        Schema::create('listing_product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->unique()->constrained()->cascadeOnDelete();
            
            // Плоские типизированные поля для быстрой фильтрации (Одежда, Электроника, Быт)
            $table->string('brand')->nullable()->index();
            $table->string('model')->nullable()->index();
            $table->string('color')->nullable();
            $table->string('size')->nullable(); // Размер или габариты
            $table->string('material')->nullable();
            
            // Для специфических данных (н-р, "вид переплета" для книг), которые не ищутся фильтрами
            $table->json('extra_metadata')->nullable(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_product_details');
        Schema::dropIfExists('listings');
    }
};
