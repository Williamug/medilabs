<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = ['created_at' => 'datetime'];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    // public function test_result(): 
    // {

    // }
}
