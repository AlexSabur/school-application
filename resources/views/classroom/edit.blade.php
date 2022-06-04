@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-md-none d-lg-block">
                @include('classroom._list')
            </div>

            <div class="col-12 col-lg-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <a href="{{ route('classroom.show', ['classroom' => $classroom->id]) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i>
                            Назад
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('classroom.update', ['classroom' => $classroom->id]) }}" method="post" data-controller="form" data-action="form#onSubmit">
                            @csrf

                            <div class="mb-3">
                                <label for="@domid($classroom, 'name')" class="form-label">Имя класса</label>
                                <input type="text" name="name" value="{{ old('name', $classroom->name) }}" class="form-control" id="@domid($classroom, 'name')" aria-describedby="@domid($classroom, 'name_help')">
                                <div id="@domid($classroom, 'name_help')" class="form-text"></div>
                            </div>

                            <button type="submit" class="btn btn-primary" data-form-target="button">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
