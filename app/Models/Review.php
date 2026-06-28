<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_request_id',
        'property_id',
        'customer_id',
        'agent_id',
        'property_rating',
        'agent_rating',
        'comment',
    ];

    /**
     * Get the visit request associated with the review.
     */
    public function visitRequest(): BelongsTo
    {
        return $this->belongsTo(VisitRequest::class);
    }

    /**
     * Get the property associated with the review.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the customer who submitted the review.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the agent who was rated.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
