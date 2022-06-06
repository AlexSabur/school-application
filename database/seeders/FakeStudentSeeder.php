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

        collect(range(1, 11))->crossJoin(['А', 'Б', 'В', 'Г'])->each(function ($components) {
            $name = implode('', $components);

            $classroom = ClassRoom::create([
                'name' => $name
            ]);

            $students = Student::factory(rand(5, 30))->make();

            $classroom->students()->saveMany($students);
        });

        // Classroom::factory(rand(5, 10))->create()->each(function (Classroom $classroom) {
        //     $students = Student::factory(rand(5, 30))->make();

        //     $classroom->students()->saveMany($students);
        // });
    }
}
