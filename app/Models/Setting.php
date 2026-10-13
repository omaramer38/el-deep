<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'group',
        'value',
        'is_encrypted',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'json',
            'is_encrypted' => 'boolean',
        ];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $cached = Cache::rememberForever('setting_'.$key, function () use ($key) {
            return static::where('key', $key)->first();
        });

        if (! $cached) {
            return $default;
        }

        $value = $cached->value;
        if ($cached->is_encrypted && is_string($value)) {
            try {
                $value = decrypt($value);
            } catch (\Exception $e) {
                // Return encrypted or null if decryption fails
            }
        }

        return $value ?? $default;
    }

    public static function set(string $key, mixed $value, string $group = 'general', bool $isEncrypted = false): self
    {
        if ($isEncrypted && ! is_null($value)) {
            $value = encrypt($value);
        }

        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $value,
                'is_encrypted' => $isEncrypted,
            ]
        );

        Cache::forget('setting_'.$key);

        return $setting;
    }
}
