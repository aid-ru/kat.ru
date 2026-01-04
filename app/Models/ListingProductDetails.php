<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingProductDetails extends Model
{
    public $timestamps = false; // Экономим ресурсы, так как дата есть в основной таблице
    protected $fillable = [
        'listing_id', 'sub_type', 'brand', 'model', 'color', 'size', 'material', 
        'extra_metadata'
    ];
    
    protected $casts = [
        'extra_metadata' => 'array', // Автоматическая конвертация JSON в массив
    ];
}