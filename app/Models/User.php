<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'mobile', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the visit requests made by this customer.
     */
    public function visitRequests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VisitRequest::class, 'customer_id');
    }

    /**
     * Get the visit requests assigned to this agent.
     */
    public function assignedVisits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VisitRequest::class, 'agent_id');
    }

    /**
     * Get the deals where this user is the customer.
     */
    public function dealsAsCustomer(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Deal::class, 'customer_id');
    }

    /**
     * Get the deals where this user is the agent.
     */
    public function dealsAsAgent(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Deal::class, 'agent_id');
    }

    /**
     * Get the reviews submitted by this customer.
     */
    public function reviewsAsCustomer(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    /**
     * Get the reviews received by this agent.
     */
    public function reviewsAsAgent(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class, 'agent_id');
    }

    /**
     * Get the average rating of this agent.
     */
    public function averageAgentRating(): float
    {
        return (float) ($this->reviewsAsAgent()->avg('agent_rating') ?? 0.0);
    }
}

