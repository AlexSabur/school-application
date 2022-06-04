<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Classroom\UpdateRequest;
use App\Models\Student\Classroom;
use App\Models\Student\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Classroom $classroom)
    {
        $student = new Student();

        $student->setRelation('classroom', $classroom);

        return view('student.create', [
            'classroom' => $classroom,
            'student' => $student,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateRequest $request, Classroom $classroom)
    {
        $classroom->students()->create($request->safe([
            'name',
        ]));

        return to_route('classroom.show', ['classroom' => $classroom->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom, Student $student)
    {
        $student->setRelation('classroom', $classroom);

        return view('student.show', [
            'classroom' => $classroom,
            'student' => $student,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom, Student $student)
    {
        $student->setRelation('classroom', $classroom);

        return view('student.edit', [
            'classroom' => $classroom,
            'student' => $student,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Classroom $classroom, Student $student)
    {
        $student->update($request->safe([
            'name',
        ]));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom, Student $student)
    {
        //
    }
}
