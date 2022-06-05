<?php

namespace App\Models\Report;

use App\Models\Student\Classroom;
use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'violation_id',
    ];

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
