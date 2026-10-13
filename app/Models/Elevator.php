<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Elevator extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia, SoftDeletes;

    public array $translatable = [
        'name',
        'slug',
        'short_description',
        'description',
        'specifications',
        'features',
        'applications',
        'advantages',
    ];

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'specifications',
        'features',
        'applications',
        'advantages',
        'status',
        'publish_at',
        'sort_order',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'publish_at' => 'datetime',
            'sort_order' => 'integer',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ElevatorCategory::class, 'category_id');
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('publish_at')
                    ->orWhere('publish_at', '<=', now());
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery');
    }
}
