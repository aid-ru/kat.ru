<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;
    protected $fillable = ['parent_id', 'name', 'slug', 'type', 'sort_order'];

    public function children() {
        return $this->hasMany(Location::class, 'parent_id');
    }
}
