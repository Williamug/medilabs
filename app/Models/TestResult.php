<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestResult extends Model
{
    use HasFactory, SoftDeletes;

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class);
    }
}
