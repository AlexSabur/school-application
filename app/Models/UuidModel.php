<?php

namespace App\Models;

use DateTimeInterface;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class UuidModel extends Model
{
    use GeneratesUuid;
    use SoftDeletes;

    public $uuidVersion = 'ordered';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = false;

    /**
     * The name of the column that should be used for the UUID.
     *
     * @return string
     */
    public function uuidColumn(): string
    {
        return $this->primaryKey;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->getTimestamp() * 1000;
    }
}
