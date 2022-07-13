<?php

use App\Http\Controllers\Student\StudentController;
use App\Http\Procedures\DatabaseProcedure;
use App\Http\Procedures\PingProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$procedures = [
    PingProcedure::class,
    DatabaseProcedure::class,
];

Route::rpc('/v1/endpoint', $procedures)
    ->name('rpc.endpoint')
    ->middleware('auth:rpc');

Route::post('/classrooms/{classroom}/students/upload', [StudentController::class, 'upload'])->name('api.classroom.student.upload');
