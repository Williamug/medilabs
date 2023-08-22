<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabServiceTestOrder extends Model
{
    use HasFactory;

    public function lab_service(): BelongsTo
    {
        return $this->belongsTo(LabService::class);
    }

    public function test_order(): BelongsTo
    {
        return $this->belongsTo(TestResult::class);
    }
}
