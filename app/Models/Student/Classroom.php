<?php

namespace App\Models\Student;

use App\Collection\ClassroomCollection;
use App\Models\UuidModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends UuidModel
{
    use HasFactory;

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new ClassroomCollection($models);
    }

    protected static function booted()
    {
        static::deleted(function (Classroom $classroom) {
            $classroom->loadMissing('students.records');

            $classroom->students->each->delete();
        });
    }
}
