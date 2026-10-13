<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class SeoMeta extends Model
{
    use HasTranslations;

    protected $table = 'seo_meta';

    public array $translatable = ['title', 'description'];

    protected $fillable = [
        'seoable_type',
        'seoable_id',
        'title',
        'description',
        'og_image',
        'canonical',
        'robots',
    ];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
