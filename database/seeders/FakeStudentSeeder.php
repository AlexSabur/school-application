<?php

namespace Database\Seeders;

use App\Models\Student\Classroom;
use App\Models\Student\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakeStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classroom::factory(rand(5, 10))->create()->each(function (Classroom $classroom) {
            $students = Student::factory(rand(5, 30))->make();

            $classroom->students()->saveMany($students);
        });
    }
}
