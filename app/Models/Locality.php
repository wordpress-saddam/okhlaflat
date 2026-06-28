<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'slug', 'description', 'is_active'])]
class Locality extends Model
{
    use HasFactory;

    /**
     * Get the properties for the locality.
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
