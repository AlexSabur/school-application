<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\ClassroomController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::view('/', 'welcome')->middleware('guest')->name('welcome');

Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false,
]);

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::controller(ClassroomController::class)->group(function () {
        Route::get('/classrooms', 'index')->name('classroom.index');
        Route::post('/classrooms', 'store')->name('classroom.store');
        Route::get('/classrooms/create', 'create')->name('classroom.create');
        Route::get('/classrooms/{classroom}', 'show')->name('classroom.show');
        Route::post('/classrooms/{classroom}', 'update')->name('classroom.update');
        Route::get('/classrooms/{classroom}/edit', 'edit')->name('classroom.edit');
    });

    Route::controller(StudentController::class)->group(function () {
        Route::post('/classrooms/{classroom}/students', 'store')->name('classroom.student.store');
        // Route::redirect('/classrooms/{classroom}/students', '/classrooms/{classroom}')->name('classroom.student.index');
        Route::get('/classrooms/{classroom}/students/create', 'create')->name('classroom.student.create');
        Route::get('/classrooms/{classroom}/students/{student}', 'show')->name('classroom.student.show');
        Route::post('/classrooms/{classroom}/students/{student}', 'update')->name('classroom.student.update');
        Route::get('/classrooms/{classroom}/students/{student}/edit', 'edit')->name('classroom.student.edit');
    });
});

