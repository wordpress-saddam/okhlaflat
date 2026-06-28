<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'visit_request_id',
    'property_id',
    'customer_id',
    'agent_id',
    'rent_amount',
    'service_fee',
    'payment_status',
    'agreement_doc_path',
    'id_proof_path',
    'closed_at'
])]
class Deal extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'closed_at' => 'datetime',
        ];
    }

    /**
     * Get the visit request that led to this deal.
     */
    public function visitRequest(): BelongsTo
    {
        return $this->belongsTo(VisitRequest::class);
    }

    /**
     * Get the property associated with this deal.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the customer (user) who rented the property.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the agent who closed this deal.
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
