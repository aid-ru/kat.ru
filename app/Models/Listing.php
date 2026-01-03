<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    protected $fillable = ['user_id', 'category_id', 'location_id', 'title', 'description', 'price', 'condition', 'status'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function productDetails(): HasOne
    {
        return $this->hasOne(ListingProductDetails::class);
    }

    public function serviceDetails(): HasOne
    {
        return $this->hasOne(ListingServiceDetails::class);
    }

    public function jobDetails(): HasOne
    {
        return $this->hasOne(ListingJobDetails::class);
    }

    public function personDetails(): HasOne
    {
        return $this->hasOne(ListingPersonDetails::class);
    }

    // Динамическое получение деталей в зависимости от категории
    public function getDetailsAttribute()
    {
        return match($this->category->type) {
            'product'   =>  $this->productDetails,
            'service'   =>  $this->serviceDetails,
            'job'       =>  $this->jobDetails,
            'person'    =>  $this->personDetails,
            default     =>  null,
        };
    }
}
