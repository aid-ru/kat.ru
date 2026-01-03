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
        Schema::create('listing_service_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->unique()->constrained()->cascadeOnDelete();
            
            $table->string('service_type')->index(); // например: online, offline, video_access
            $table->string('duration_unit')->nullable(); // например: час, курс, месяц
            $table->text('access_info')->nullable(); // Скрытое поле для ссылки на урок или инструкций (показывается после оплаты/контакта)
            $table->boolean('is_recurring')->default(false); // Флаг: является ли услуга разовой или периодической

            // Для специфических данных, которые не ищутся фильтрами
            $table->json('extra_metadata')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_service_details');
    }
};
