<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by its key.
     * Caches the value forever until it's updated.
     */
    public static function getValue($key, $default = null)
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            try {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        } catch (\Illuminate\Database\QueryException $e) {
            return $default;
        }
        });
    }

    /**
     * Set a setting value by its key.
     * Clears the cache for that key.
     */
    public static function setValue($key, $value)
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        Cache::forget("setting_{$key}");
    }

    /**
     * Clear the cache when a setting is saved or deleted via Eloquent directly.
     */
    protected static function booted()
    {
        static::saved(function ($setting) {
            Cache::forget("setting_{$setting->key}");
        });

        static::deleted(function ($setting) {
            Cache::forget("setting_{$setting->key}");
        });
    }
}
