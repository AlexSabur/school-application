<?php

namespace App\Models\Report;

use App\Models\UuidModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends UuidModel
{
    use HasFactory;

    protected $casts = [
        'closed_at' => 'datetime',
    ];

    protected $appends = [
        'is_closed',
    ];

    public function getIsClosedAttribute()
    {
        return null !== $this->closed_at;
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    protected static function booted()
    {
        static::deleted(function (Report $report) {
            $report->loadMissing('records');

            $report->records->each->delete();
        });
    }
}
