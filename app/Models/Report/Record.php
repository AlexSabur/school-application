<?php

namespace App\Models\Report;

use App\Models\Student\Classroom;
use App\Models\Student\Student;
use App\Models\UuidModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends UuidModel
{
    use HasFactory;

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class)->withDefault();
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class)->withDefault();
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class)->withDefault();
    }

    public function violation(): BelongsTo
    {
        return $this->belongsTo(Violation::class)->withDefault();
    }
}
