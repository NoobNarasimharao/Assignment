<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    protected $fillable = ['business_name', 'last_update_date', 'street_address', 'city', 'state', 'postal_code'];

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function getFullAddressAttribute(): string
    {
        return "{$this->street_address}, {$this->city}, {$this->state} {$this->postal_code}";
    }
}