@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-md-none d-lg-block">
                @include('classroom._list')
            </div>

            <div class="col-12 col-lg-8">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            <a href="{{ route('classroom.show', ['classroom' => $classroom->id]) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i>
                                Назад
                            </a>
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('classroom.student.edit', ['classroom' => $classroom->id, 'student' => $student->id]) }}" class="btn btn-secondary">
                                <i class="bi bi-pencil"></i>
                                Редактировать
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        Студент: {{ $student->name }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
