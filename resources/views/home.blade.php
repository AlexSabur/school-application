@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-md-4">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 d-flex">
                            <x-bi-people class="m-auto" width="32" height="32" />
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $classroomCount }}</h5>
                                <p class="card-text"><small class="text-muted">Классов</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 d-flex">
                            <x-bi-person class="m-auto" width="32" height="32" />
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $studentCount }}</h5>
                                <p class="card-text"><small class="text-muted">Учеников</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 d-flex">
                            <x-bi-clipboard class="m-auto" width="32" height="32" />
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $reportCount }}</h5>
                                <p class="card-text"><small class="text-muted">Отчётов</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
