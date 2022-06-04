<?php

namespace App\Http\Controllers;

use App\Models\Student\Classroom;
use App\Models\Student\Student;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'classroomCount' => Classroom::count(),
            'studentCount' => Student::count(),
        ]);
    }
}
