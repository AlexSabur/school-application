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

                <x-errors-alert />

                <div class="card mb-3">
                    <div class="card-header">
                        <a href="{{ route('report.show', ['report' => $report->id]) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i>
                            Назад
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('report.record.update', ['report' => $report->id, 'record' => $record->id]) }}" method="post">
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

            </div>

        </div>
    </div>
@endsection
