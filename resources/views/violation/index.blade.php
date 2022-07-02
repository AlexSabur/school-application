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
                                                <button type="button" class="btn btn-danger btn-sm btn-icon text-white" data-bs-toggle="modal" data-bs-target="#remove-record-modal" data-bs-action="{{ route('violation.destroy', ['violation' => $violation->id]) }}">
                                                    <x-bi-trash />
                                                </button>
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
