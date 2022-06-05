<?php

namespace App\Exports\ReportExport;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
{
    public function __construct(public Collection $recordsByClassroom)
    {
        //
    }

    public function title(): string
    {
        return 'Кратко';
    }

    public function headings(): array
    {
        return [
            'name' => 'Класс',
            'count' => 'количество',
        ];
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->recordsByClassroom->map(function (Collection $records) {
            [$record] = $records;

            return [
                'name' => $record->classroom->name,
                'count' => $records->count(),
            ];
        });
    }
}
