<?php

namespace App\Models\Report;

use App\Models\UuidModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Violation extends UuidModel
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
    }
}
