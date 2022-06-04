<?php

namespace Database\Factories\Student;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student\Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $letter = $this->faker->unique()->randomLetter();
        $number = $this->faker->unique()->numberBetween(1, 99);

        return [
            'name' =>  $letter . $number,
        ];
    }
}
