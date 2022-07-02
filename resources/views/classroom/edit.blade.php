@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-none d-lg-block">
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
                            <button type="button" class="btn btn-danger btn-icon text-white" data-bs-toggle="modal" data-bs-target="#remove-record-modal" data-bs-action="{{ route('classroom.destroy', ['classroom' => $classroom->id]) }}">
                                <x-bi-trash />
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('classroom.update', ['classroom' => $classroom->id]) }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="@domid($classroom, 'name')" class="form-label">Имя класса</label>
                                <input type="text" name="name" value="{{ old('name', $classroom->name) }}" class="form-control" id="@domid($classroom, 'name')" aria-describedby="@domid($classroom, 'name_help')">
                                <div id="@domid($classroom, 'name_help')" class="form-text"></div>
                            </div>

                            <button type="submit" class="btn btn-primary" data-form-target="button">Сохранить</button>
                        </form>
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
