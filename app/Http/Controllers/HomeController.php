<?php

namespace App\Http\Controllers;

use App\Models\Report\Report;
use App\Models\Student\Classroom;
use App\Models\Student\Student;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        /** @var User */
        $user = $request->user();

        return view('app', [
            'user' => $user,
            'token' => $user->application_token,
        ]);
    }
}
