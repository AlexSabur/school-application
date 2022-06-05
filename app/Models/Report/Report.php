<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

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
}
