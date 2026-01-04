<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingJobDetails extends Model
{
    public $timestamps = false; // Экономим ресурсы, так как дата есть в основной таблице
    protected $fillable = [
        'listing_id', 'sub_type', 'job_type', 'employment_type', 'schedule', 
        'salary_from', 'salary_to', 'currency', 'experience_years',
        'extra_metadata'
    ];

    protected $casts = [
        'extra_metadata' => 'array', // Автоматическая конвертация JSON в массив
    ];
}
