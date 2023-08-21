<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabService extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'price' => MoneyCast::class,
    ];

    //Get the category that owns the test_service
    public function service_category(): BelongsTo
    {
        return $this->belongsTo(LabServiceCategory::class);
    }
}
