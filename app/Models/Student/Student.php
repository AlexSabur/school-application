<?php

namespace App\Models\Student;

use App\Models\Report\Record;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class)->withDefault();
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
    }
}
