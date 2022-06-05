@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-8">

                <x-errors-alert />

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            Отчёты
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('report.create') }}" class="btn btn-secondary">
                                <i class="bi bi-plus"></i>
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
                                @foreach ($reports as $report)
                                    <tr>
                                        <th scope="row">{{ $report->id }}</th>
                                        <td>{{ $report->name }}</td>
                                        <td>{{ $report->records_count }}</td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="{{ route('report.show', ['report' => $report->id]) }}" class="btn btn-accent1 btn-sm btn-icon">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('report.download', ['report' => $report->id]) }}" class="btn btn-accent2 btn-sm btn-icon">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $reports->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
