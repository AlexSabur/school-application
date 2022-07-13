<?php

namespace App\Models\Report;

use App\Models\UuidModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Violation extends UuidModel
{
    use HasFactory;

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
    }

    protected static function booted()
    {
        static::deleted(function (Violation $violation) {
            $violation->loadMissing('records');

            $violation->records->each->delete();
        });
    }
}
