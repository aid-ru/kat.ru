<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = ['parent_id', 'name', 'slug', 'type', 'sort_order'];

    /**
     * Связь с родительской категорией
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Связь с подкатегориями
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Связь с объявлениями
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    /**
     * Позволяет скрывать в шаблонах несвойственные для данной категории поля:
     *    @if(!$category->shouldHide('price')) ... @endif
     */
    public function shouldHide($field): bool
    {
        // Проверяем, есть ли поле в массиве hide_fields внутри настроек
        return in_array($field, $this->settings['hide_fields'] ?? []);
    }

}
