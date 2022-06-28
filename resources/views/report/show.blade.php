@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-md-none d-lg-block">
                <div class="card mb-3">
                    <div class="card-body">
                        Отчёт: {{ $report->name }}
                        @if ($report->is_closed)
                            Закрыт: {{ $report->closed_at }}
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">

                <x-errors-alert />

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            Записи
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('report.download', ['report' => $report->id]) }}" download class="btn btn-secondary">
                                <x-bi-download />
                                Скачать
                            </a>
                            @if (!$report->is_closed)
                                <a href="{{ route('report.record.add', ['report' => $report->id]) }}" class="btn btn-secondary">
                                    <x-bi-plus />
                                    Добавить
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 3rem" class="d-none d-sm-table-cell">#</th>
                                    <th scope="col">Класс</th>
                                    {{-- <th scope="col"></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportClassroomRecords as $classroomRecords)
                                    <tr>
                                        <th scope="row" class="d-none d-sm-table-cell">{{ $loop->iteration }}</th>
                                        <td>{{ $classroomRecords->first()->classroom->name }}</td>
                                        {{-- <td></td> --}}
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width: 3rem" class="d-none d-sm-table-cell ">#</th>
                                                        <th scope="col" style="width: 25%">Ученик</th>
                                                        <th scope="col" style="width: 25%">Причина</th>
                                                        <th scope="col" class="d-none d-sm-table-cell ">Сообщение</th>
                                                        @if (!$report->is_closed)
                                                            <th scope="col"></th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($classroomRecords as $record)
                                                        <tr>
                                                            <th scope="row" class="d-none d-sm-table-cell ">{{ $loop->iteration }}</th>
                                                            <td>{{ $record->student->name }}</td>
                                                            <td>{{ $record->violation->name }}</td>
                                                            <td class="d-none d-sm-table-cell ">{{ $record->message }}</td>
                                                            @if (!$report->is_closed)
                                                                <td>
                                                                    <div class="d-flex gap-1 justify-content-end">
                                                                        <a href="{{ route('report.record.edit', ['report' => $report->id, 'record' => $record->id]) }}" class="btn btn-accent2 btn-sm btn-icon">
                                                                            <x-bi-pencil />
                                                                        </a>
                                                                        <button type="button" class="btn btn-danger btn-sm btn-icon text-white" data-bs-toggle="modal" data-bs-target="#remove-record-modal" data-bs-action="{{ route('report.record.destroy', ['report' => $report->id, 'record' => $record->id]) }}">
                                                                            <x-bi-trash />
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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

    <form method="POST" class="modal fade" id="remove-record-modal" tabindex="-1" aria-labelledby="remove-record-modal-label" aria-hidden="true" data-controller="confirm-modal" data-action="show.bs.modal->confirm-modal#onShow">
        @csrf
        @method('delete')
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remove-record-modal-label">Подтверждение удаления</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Удалить запись?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Удалить</button>
                </div>
            </div>
        </div>
    </form>
@endsection
