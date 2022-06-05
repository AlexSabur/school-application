@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-8">

                <x-errors-alert />

                <div class="card mb-3">
                    <div class="card-body">
                        <form action="{{ route('report.store') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="@domid($report, 'name')" class="form-label">Имя отчёта</label>
                                <input type="text" name="name" value="{{ old('name', $report->name) }}" class="form-control" id="@domid($report, 'name')" aria-describedby="@domid($report, 'name_help')">
                                <div id="@domid($report, 'name_help')" class="form-text"></div>
                            </div>

                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
