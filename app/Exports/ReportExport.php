<?php

namespace App\Exports;

use App\Exports\ReportExport\ClassroomSheet;
use App\Exports\ReportExport\ReportSheet;
use App\Models\Report\Record;
use App\Models\Report\Report;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportExport implements WithMultipleSheets
{
    use Exportable;

    public function __construct(public Report $report)
    {
        //
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        /** @var Collection<int, Record> */
        $records = $this->report->records;

        $records->load([
            'student',
            'classroom',
            'violation',
        ]);

        $recordsByClassroom = $records->groupBy('classroom.id')->sort(function ($a, $b) {
            [$aRecord] = $a;
            [$bRecord] = $b;

            [$aNumber, $aSymbol] = $this->numberAndSymbol($aRecord->classroom->name);
            [$bNumber, $bSymbol] = $this->numberAndSymbol($bRecord->classroom->name);

            if ($aNumber === $bNumber) {
                return $aSymbol <=> $bSymbol;
            }

            return $aNumber <=> $bNumber;
        });

        return $recordsByClassroom
            ->map(function ($records) {
                [$record] = $records;

                return new ClassroomSheet(
                    $record->classroom,
                    $records
                );
            })
            ->prepend(new ReportSheet($recordsByClassroom))
            ->values()
            ->toArray();
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
