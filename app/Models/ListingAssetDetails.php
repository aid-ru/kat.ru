<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingAssetDetails extends Model
{
    public $timestamps = false; // Экономим ресурсы, так как дата есть в основной таблице
    protected $fillable = [
        'listing_id', 'sub_type', 
        'extra_metadata'
    ];

    protected $casts = [
        'extra_metadata' => 'array', // Автоматическая конвертация JSON в массив
    ];
}
