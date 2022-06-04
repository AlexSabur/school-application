@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-md-none d-lg-block">
                @include('classroom._list')
            </div>

            <div class="col-12 col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="{{ route('classroom.store') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="@domid($classroom, 'name')" class="form-label">Имя класса</label>
                                <input type="text" name="name" value="{{ old('name', $classroom->name) }}" class="form-control" id="@domid($classroom, 'name')" aria-describedby="@domid($classroom, 'name_help')">
                                <div id="@domid($classroom, 'name_help')" class="form-text"></div>
                            </div>

                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
