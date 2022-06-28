<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Classroom\UpdateRequest;
use App\Models\Student\Classroom;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('classroom.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('classroom.create', [
            'classroom' => new Classroom()
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
        $classroom = Classroom::create($request->safe([
            'name',
        ]));

        return to_route('classroom.show', ['classroom' => $classroom->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        $classroom->load([
            'students' => function (Builder $builder) {
                $builder->withCount('records');
            },
        ]);

        return view('classroom.show', [
            'classroom' => $classroom
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        return view('classroom.edit', [
            'classroom' => $classroom
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Classroom $classroom)
    {
        $classroom->update($request->safe([
            'name',
        ]));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return to_route('classroom.index');
    }
}
