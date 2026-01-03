<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingServiceDetails extends Model
{
    public $timestamps = false; // Экономим ресурсы, так как дата есть в основной таблице
    protected $fillable = [
        'listing_id', 'service_type', 'duration_unit', 'access_info', 'is_recurring', 
        'extra_metadata'
    ];

    protected $casts = [
        'extra_metadata' => 'array', // Автоматическая конвертация JSON в массив
    ];
}

