@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-md-none d-lg-block">
                <div class="card mb-3">
                    <div class="card-body">
                        Отчёт: {{ $report->name }}
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">

                @switch(true)
                    @case($student->exists)

                        <x-errors-alert />

                        <div class="card mb-3">
                            <div class="card-header">
                                <a href="{{ route('report.record.add', ['report' => $report->id, 'classroom' => $classroom->id]) }}" class="btn btn-secondary">
                                    <x-bi-arrow-left />
                                    Назад
                                </a>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('report.record.store', ['report' => $report->id, 'classroom' => $classroom->id, 'student' => $student->id]) }}" method="post">
                                    @csrf

                                    @foreach ($violations as $violation)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="violation_id" value="{{ $violation->id }}" id="@domid($violation, 'checkbox')" @checked(old('violation_id', $record->violation_id) == $violation->id)>
                                            <label class="form-check-label" for="@domid($violation, 'checkbox')">{{ $violation->name }}</label>
                                        </div>
                                    @endforeach

                                    <div class="mb-3">
                                        <label for="@domid($record, 'message')" class="form-label">Сообщение</label>
                                        <textarea class="form-control" name="message" id="@domid($record, 'message')" rows="3" aria-describedby="@domid($record, 'message_help')">{{ old('message', $record->message) }}</textarea>
                                        <div id="@domid($record, 'message_help')" class="form-text"></div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" data-form-target="button">Сохранить</button>
                                </form>
                            </div>
                        </div>
                        @break
                    @case($classroom->exists)

                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between">
                                <div class="d-flex gap-3 justify-content-start">
                                    <a href="{{ route('report.record.add', ['report' => $report->id]) }}" class="btn btn-secondary">
                                        <x-bi-arrow-left />
                                        Назад
                                    </a>
                                </div>
                                <div class="d-flex gap-3 justify-content-start">
                                    Ученики
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Имя</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($classroom->students as $student)
                                            @include('record._student-info')
                                            @include('record._student-buttons')
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @break
                    @default

                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <div class="d-flex gap-3 justify-content-start">
                                <a href="{{ route('report.show', ['report' => $report->id]) }}" class="btn btn-secondary">
                                    <x-bi-arrow-left />
                                    Назад
                                </a>
                            </div>
                            <div class="d-flex gap-3 justify-content-start">
                                Классы
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        {{-- <th scope="col">#</th> --}}
                                        <th scope="col">Класс</th>
                                        <th scope="col">Учеников</th>
                                        <th scope="col">Записей</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classrooms as $classroom)
                                        <tr>
                                            {{-- <th scope="row">{{ $loop->iteration }}</th> --}}
                                            <td>{{ $classroom->name }}</td>
                                            <td>{{ $classroom->students_count }}</td>
                                            <td>{{ $classroom->students_with_record_count }}</td>
                                            <td>
                                                <div class="d-flex gap-3 justify-content-end">
                                                    <a href="{{ route('report.record.add', ['report' => $report->id, 'classroom' => $classroom->id]) }}" class="btn btn-accent1 btn-icon btn-sm">
                                                        <x-bi-arrow-right />
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                @endswitch

            </div>

        </div>
    </div>
@endsection
