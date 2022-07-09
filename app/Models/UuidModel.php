<?php

namespace App\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class UuidModel extends Model
{
    use GeneratesUuid;

    public $uuidVersion = 'ordered';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The name of the column that should be used for the UUID.
     *
     * @return string
     */
    public function uuidColumn(): string
    {
        return $this->primaryKey;
    }
}
