<?php

namespace App\Http\Responses;

class PullChangesResponse
{
    public int $timestamp;
    public array $changes = [];

    public function __construct()
    {
        $this->timestamp = now()->getTimestampMs();
    }

    public function setChanges($changes)
    {
        $this->changes = $changes;
    }

    public function setChange($entity, $changes)
    {
        $this->changes[$entity] = $changes;
    }

    public function addChange(string $entity, string $type, mixed $value)
    {
        $this->changes[$entity][$type][] = $value;
    }
}
