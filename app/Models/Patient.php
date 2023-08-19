<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function test_results(): BelongsToMany
    {
        return $this->belongsToMany(TestResult::class);
    }
}
