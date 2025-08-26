<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    protected $fillable = ['name'];

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class);
    }
}