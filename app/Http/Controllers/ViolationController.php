<?php

namespace App\Http\Controllers;

use App\Models\Report\Violation;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('violation.index', [
            'violations' => Violation::withCount('records')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('violation.create', [
            'violation' => new Violation(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Violation::create($request->only(['name']));

        return to_route('violation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function show(Violation $violation)
    {
        return to_route('violation.edit', [
            'violation' => $violation->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function edit(Violation $violation)
    {
        return view('violation.edit', [
            'violation' => $violation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Violation $violation)
    {
        $violation->update($request->only(['name']));

        return to_route('violation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report\Violation  $violation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Violation $violation)
    {
        $violation->delete();

        return to_route('violation.index');
    }
}
