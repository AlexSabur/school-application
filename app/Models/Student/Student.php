<?php

namespace App\Models\Student;

use App\Models\Report\Record;
use App\Models\UuidModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends UuidModel
{
    use HasFactory;

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class)->withDefault();
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
    }
}
