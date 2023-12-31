<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class NextOfKin extends Model
{
    use HasFactory;

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class);
    }
}
