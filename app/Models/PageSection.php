<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = [
        'page_id',
        'type',
        'data',
        'draft_data',
        'is_enabled',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'draft_data' => 'array',
            'is_enabled' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the live data (or fallback to draft if not published yet).
     */
    public function getActiveDataAttribute(): array
    {
        return $this->data ?? $this->draft_data ?? [];
    }
}
