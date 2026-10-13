<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    public array $translatable = ['title'];

    protected $fillable = [
        'key',
        'title',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }

    public function activeSections(): HasMany
    {
        return $this->hasMany(PageSection::class)->where('is_enabled', true)->orderBy('sort_order');
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public function getSection(string $type): ?PageSection
    {
        if ($this->relationLoaded('sections')) {
            return $this->sections->firstWhere('type', $type);
        }
        return $this->sections()->where('type', $type)->first();
    }

    public function getSectionData(string $type, array $default = []): array
    {
        $section = $this->getSection($type);
        if (! $section || ! is_array($section->data)) {
            return $default;
        }

        return array_replace_recursive($default, $section->data);
    }
}
