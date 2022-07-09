<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Report\Record;
use App\Models\Report\Report;
use App\Models\Report\Violation;
use App\Models\Student\Classroom;
use App\Models\Student\Student;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class DatabaseProcedure extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'database';

    /**
     * Execute the procedure.
     *
     * @param Request $request
     *
     * @return array|string|integer
     */
    public function load(Request $request)
    {
        return [
            'violations' => Violation::all(),
            'reports' => Report::all(),
            'classrooms' => Classroom::all(),
            'students' => Student::all(),
            'records' => Record::all(),
        ];
    }

    // changes timestamp
    public function pullChanges(Request $request)
    {
        # code...
    }

    public function pushChanges(Request $request)
    {
        # code...
    }
}
