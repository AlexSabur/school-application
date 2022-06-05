<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\Classroom\UpdateRequest;
use App\Models\Report\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::query()->withCount('records')->latest()->paginate();

        return view('report.index', [
            'reports' => $reports,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('report.create', [
            'openReportExists' => Report::query()->whereNull('closed_at')->exists(),
            'report' => new Report([
                'name' => now()->format('Y-m-d'),
            ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateRequest $request)
    {
        $report = Report::create($request->safe([
            'name',
        ]));

        return to_route('report.show', [
            'report' => $report->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        $report->load([
            'records',
            'records.classroom',
            'records.student',
            'records.violation',
        ]);

        return view('report.show', [
            'report' => $report,
        ]);
    }

    public function download(Report $report)
    {
        # code...
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
