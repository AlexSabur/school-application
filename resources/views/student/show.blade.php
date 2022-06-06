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
                                <x-bi-arrow-left />
                                Назад
                            </a>
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('classroom.student.edit', ['classroom' => $classroom->id, 'student' => $student->id]) }}" class="btn btn-secondary">
                                <x-bi-pencil />
                                Редактировать
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        Студент: {{ $student->name }}
                    </div>
                </div>

                <div class="card md-3">
                    <div class="card-body table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 3rem">#</th>
                                    <th scope="col" style="width: 25%">Отчёт</th>
                                    <th scope="col" style="width: 25%">Причина</th>
                                    <th scope="col">Сообщение</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student->records as $record)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <a class="link-secondary" href="{{ route('report.show', ['report' => $record->report->id]) }}">{{ $record->report->name }}</a>
                                        </td>
                                        <td>{{ $record->violation->name }}</td>
                                        <td>{{ $record->message }}</td>
                                        <td>
                                            @if (!$record->report->is_closed)
                                                <div class="d-flex gap-1 justify-content-end">
                                                    <a href="{{ route('report.record.edit', ['report' => $record->report->id, 'record' => $record->id]) }}" class="btn btn-accent2 btn-sm btn-icon">
                                                        <x-bi-pencil />
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm btn-icon text-white" data-bs-toggle="modal" data-bs-target="#remove-record-modal" data-bs-action="{{ route('report.record.destroy', ['report' => $record->report->id, 'record' => $record->id]) }}">
                                                        <x-bi-trash />
                                                    </button>
                                                </div>
                                            @endif
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
