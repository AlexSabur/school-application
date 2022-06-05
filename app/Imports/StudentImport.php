<?php

namespace App\Imports;

use App\Models\Student\Classroom;
use App\Models\Student\Student;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class StudentImport implements OnEachRow
{
    public $headRow = [];

    public function __construct(
        public Classroom $classroom,
        public bool $withHeadingRow,
    ) {
        //
    }

    public function onRow(Row $row) {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        $numbericRow = $row;

        if ($this->withHeadingRow) {
            if (1 === $rowIndex) {
                $this->headRow = array_map(
                    fn ($col) => Str::slug($col, '_'),
                    $row,
                );

                return;
            }

            $row = array_combine($this->headRow, $row);
        }

        return $this->classroom->students()->create([
            'name' => $row['name'] ?? $row['imia'] ?? $row['fio'] ?? $numbericRow[0],
        ]);
    }
}
