<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Fillable([
    'property_code',
    'title',
    'description',
    'rent',
    'deposit',
    'property_type',
    'bhk',
    'area',
    'floor',
    'furnishing',
    'availability',
    'approximate_location',
    'nearest_metro',
    'landmark',
    'exact_address',
    'building_number',
    'owner_name',
    'owner_contact',
    'verification_status',
    'publication_status',
    'locality_id',
    'assigned_agent_id',
    'created_by'
])]
#[Hidden([
    'exact_address',
    'building_number',
    'owner_name',
    'owner_contact'
])]
class Property extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the locality that owns the property.
     */
    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }

    /**
     * Get the agent assigned to the property.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    /**
     * Get the admin or agent who created the property.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The amenities that belong to the property.
     */
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    /**
     * Get the images/media files for the property.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('order');
    }

    /**
     * Scope a query to only include published properties.
     */
    public function scopePublished($query)
    {
        return $query->where('publication_status', 'published');
    }

    /**
     * Scope a query to only include verified properties.
     */
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    /**
     * Get the visit requests made for this property.
     */
    public function visitRequests(): HasMany
    {
        return $this->hasMany(VisitRequest::class);
    }

    /**
     * Get the deals closed for this property.
     */
    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }
}

