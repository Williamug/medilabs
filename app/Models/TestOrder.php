<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestOrder extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'lab_service_id' => 'array',
    ];


    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function lab_services(): HasMany
    {
        // Assuming lab_service_ids is the JSON column storing lab service IDs
        return $this->hasMany(LabService::class, 'id', 'lab_service_id');
    }
}
