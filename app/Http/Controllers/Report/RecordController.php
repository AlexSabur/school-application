<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\Record\AddRequest;
use App\Http\Requests\Report\Record\StoreRequest;
use App\Models\Report\Record;
use App\Models\Report\Report;
use App\Models\Report\Violation;
use App\Models\Student\Classroom;
use App\Models\Student\Student;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

use function Tonysm\TurboLaravel\dom_id;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Report $report, Classroom $classroom, Student $student)
    {
        $record = $this->newRecord($report, $classroom, $student);

        $violations = Violation::query()->get();
        $classrooms = Classroom::query()
            ->withCount([
                'students',
                'students as students_with_record_count' => function (Builder $builder) use ($report) {
                    $builder->whereRelation('records', 'report_id', $report->id);
                }
            ])
            ->get()
            ->sortByName();

        $classroom->load([
            'students' => function (Builder $builder) use ($report) {
                $builder->withExists([
                    'records as record' => function (Builder $builder) use ($report) {
                        $builder->where('report_id', $report->id);
                    }
                ]);
                $builder->withAggregate([
                    'records as record_id' => function (Builder $builder) use ($report) {
                        $builder->where('report_id', $report->id);
                    }
                ], 'id');
                $builder->withAggregate([
                    'records as violation_id' => function (Builder $builder) use ($report) {
                        $builder->where('report_id', $report->id);
                    }
                ], 'violation_id');
                $builder->orderBy('name');
            }
        ]);

        if ($firstViolation = $violations->first()) {
            $record->violation_id = $firstViolation->id;
            $record->violation()->associate($firstViolation);
        }

        return view('record.add', [
            'classrooms' => $classrooms,
            'violations' => $violations,
            'report' => $report,
            'classroom' => $classroom,
            'student' => $student,
            'record' => $record,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeQuick(Request $request, Report $report, Classroom $classroom, Student $student, Violation $violation)
    {
        $record = $this->newRecord($report, $classroom, $student, $violation);

        if ($record->violation()->is($violation)) {
            $record->delete();
        } else {
            $record->violation()->associate($violation);

            $record->saveOrFail();
        }


        if ($request->wantsTurboStream()) {
            $student->record = $record->exists;
            $student->record_id = $record->exists ? $record->id : null;
            $student->violation_id = $record->exists ? $violation->id : null;

            $data = [
                'violations' => Violation::query()->get(),
                'report' => $report,
                'classroom' => $classroom,
                'student' => $student,
                'record' => $record,
            ];

            return response()->turboStream([
                response()
                    ->turboStream()
                    ->replace(dom_id($student, 'info'), view('record._student-info', $data)),
                response()
                    ->turboStream()
                    ->replace(dom_id($student, 'buttons'), view('record._student-buttons', $data)),
            ]);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, Report $report, Classroom $classroom, Student $student)
    {
        $record = $this->newRecord($report, $classroom, $student);

        $record->fill($request->safe([
            'message',
            'violation_id',
        ]));

        $record->save();

        return to_route('report.show', [
            'report' => $report->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report, Record $record)
    {
        $violations = Violation::query()->get();

        return view('record.edit', [
            'violations' => $violations,
            'report' => $report,
            'record' => $record,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Report $report, Record $record)
    {
        $record->update($request->safe([
            'message',
            'violation_id',
        ]));

        return to_route('report.show', [
            'report' => $report->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }

    protected function newRecord(Report $report, Classroom $classroom, Student $student): Record
    {
        $record = Record::unguarded(fn () => Record::firstOrNew([
            'report_id' => $report->id,
            'classroom_id' => $classroom->id,
            'student_id' => $student->id,
        ]));

        return $record;
    }
}
