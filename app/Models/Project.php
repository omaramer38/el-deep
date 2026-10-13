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

class Project extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia, SoftDeletes;

    public array $translatable = [
        'title',
        'slug',
        'short_description',
        'description',
        'location',
        'service_type',
        'specifications',
    ];

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'location',
        'year',
        'status',
        'elevators_count',
        'service_type',
        'specifications',
        'is_featured',
        'status_publish',
        'publish_at',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'elevators_count' => 'integer',
            'is_featured' => 'boolean',
            'publish_at' => 'datetime',
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status_publish', 'published')
            ->where(function ($q) {
                $q->whereNull('publish_at')
                    ->orWhere('publish_at', '<=', now());
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('execution');
    }
}
