<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class FaqCategory extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $fillable = [
        'name',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class, 'category_id')->orderBy('sort_order');
    }
}
