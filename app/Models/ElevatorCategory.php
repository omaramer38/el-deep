<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class ElevatorCategory extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'slug'];

    protected $fillable = [
        'name',
        'slug',
        'image',
        'sort_order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function elevators(): HasMany
    {
        return $this->hasMany(Elevator::class, 'category_id')->orderBy('sort_order');
    }
}
