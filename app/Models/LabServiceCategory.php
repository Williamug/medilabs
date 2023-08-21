<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabServiceCategory extends Model
{
    use HasFactory, SoftDeletes;

    // Get all of the test_services for the category
    public function lab_services(): HasMany
    {
        return $this->hasMany(LabService::class);
    }
}
