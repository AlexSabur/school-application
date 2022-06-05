<?php

namespace App\Exports\ReportExport;

use App\Models\Report\Record;
use App\Models\Student\Classroom;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ClassroomSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
{
    public function __construct(public Classroom $classroom, public Collection $records)
    {
        //
    }

    public function title(): string
    {
        return $this->classroom->name;
    }

    public function headings(): array
    {
        return [
            'student' => 'фИО',
            'violation' => 'Причина',
            'message' => 'Сообщение',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->records->map(fn (Record $record) => [
            'student' => $record->student->name,
            'violation' => $record->violation->name,
            'message' => $record->message,
        ]);
    }
}
