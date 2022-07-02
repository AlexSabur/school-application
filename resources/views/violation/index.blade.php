@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-8">

                <x-errors-alert />

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            Причины
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('violation.create') }}" class="btn btn-secondary">
                                <x-bi-plus />
                                Добавить
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">Записей</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($violations as $violation)
                                    <tr>
                                        <th scope="row">{{ $violation->id }}</th>
                                        <td>{{ $violation->name }}</td>
                                        <td>{{ $violation->records_count }}</td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="{{ route('violation.show', ['violation' => $violation->id]) }}" class="btn btn-accent1 btn-sm btn-icon">
                                                    <x-bi-pencil />
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
