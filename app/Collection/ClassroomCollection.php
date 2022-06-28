<?php

namespace App\Collection;

use App\Models\Student\Classroom;
use Illuminate\Database\Eloquent\Collection;

class ClassroomCollection extends Collection
{
    public function sortByName()
    {
        return $this->sort(function (Classroom $a, Classroom $b) {
            [$aNumber, $aSymbol] = $this->numberAndSymbol($a->name);
            [$bNumber, $bSymbol] = $this->numberAndSymbol($b->name);

            if ($aNumber === $bNumber) {
                return $aSymbol <=> $bSymbol;
            }

            return $aNumber <=> $bNumber;
        });
    }

    protected function numberAndSymbol($name)
    {
        preg_match('#(?<number>\d+)(?<symbol>\W+)#', $name, $out);

        return [
            (int) $out['number'],
            (string) $out['symbol'],
        ];
    }
}
