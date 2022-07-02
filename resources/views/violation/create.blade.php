@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-8">

                <x-errors-alert />

                <div class="card mb-3">
                    <div class="card-header">
                        <a href="{{ route('violation.index') }}" class="btn btn-secondary">
                            <x-bi-arrow-left />
                            Назад
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('violation.store') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="@domid($violation, 'name')" class="form-label">Имя</label>
                                <input type="text" name="name" value="{{ old('name', $violation->name) }}" class="form-control" id="@domid($violation, 'name')" aria-describedby="@domid($violation, 'name_help')">
                                <div id="@domid($violation, 'name_help')" class="form-text"></div>
                            </div>

                            <button type="submit" class="btn btn-primary" data-form-target="button">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
