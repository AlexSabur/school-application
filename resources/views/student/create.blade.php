@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-md-none d-lg-block">
                @include('classroom._list')
            </div>

            <div class="col-12 col-lg-8">

                <x-errors-alert />

                <div class="card mb-3">
                    <div class="card-header">
                        <a href="{{ route('classroom.show', ['classroom' => $classroom->id]) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i>
                            Назад
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('classroom.student.store', ['classroom' => $classroom->id]) }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="@domid($student, 'name')" class="form-label">Имя</label>
                                <input type="text" name="name" value="{{ old('name', $student->name) }}" class="form-control" id="@domid($student, 'name')" aria-describedby="@domid($student, 'name_help')">
                                <div id="@domid($student, 'name_help')" class="form-text"></div>
                            </div>

                            <button type="submit" class="btn btn-primary" data-form-target="button">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
