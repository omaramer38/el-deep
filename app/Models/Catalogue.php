<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Catalogue extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia, SoftDeletes;

    public array $translatable = [
        'title',
    ];

    protected $fillable = [
        'title',
        'file_path',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    public function getPdfUrlAttribute(): string
    {
        if ($this->hasMedia('pdf')) {
            return $this->getFirstMediaUrl('pdf');
        }

        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }

        return '#';
    }
}
