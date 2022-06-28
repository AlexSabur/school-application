<?php

namespace App\View\Composers;

use App\Attributes\View\Composer;
use App\Models\Student\Classroom;
use Illuminate\View\View;

class ClassroomComposer
{
    #[Composer('classroom._list')]
    // #[Composer('record.add')]
    public function classRoomList(View $view)
    {
        $classrooms = Classroom::query()->withCount('students')->get()->sortByName();

        $view->with('classrooms', $classrooms);
    }
}
