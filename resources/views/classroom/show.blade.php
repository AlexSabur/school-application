@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-md-none d-lg-block">
                @include('classroom._list')
            </div>

            <div class="col-12 col-lg-8">

                <x-errors-alert />

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            <a href="{{ route('classroom.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i>
                                Назад
                            </a>
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('classroom.edit', ['classroom' => $classroom->id]) }}" class="btn btn-secondary">
                                <i class="bi bi-pencil"></i>
                                Редактировать
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        Класс: {{ $classroom->name }}
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            Ученики
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <button type="button" class="btn btn-accent2 btn-sm btn-icon text-white" data-bs-toggle="modal" data-bs-target="#upload-clasroom-modal">
                                <i class="bi bi-upload"></i>
                            </button>
                            <a href="{{ route('classroom.student.create', ['classroom' => $classroom->id]) }}" class="btn btn-secondary">
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
                                    <th scope="col">Отчётов</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classroom->students as $student)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->records_count }}</td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="{{ route('classroom.student.show', ['classroom' => $classroom->id, 'student' => $student->id]) }}" class="btn btn-accent1 btn-icon btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('classroom.student.edit', ['classroom' => $classroom->id, 'student' => $student->id]) }}" class="btn btn-accent2 btn-icon btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm btn-icon text-white" data-bs-toggle="modal" data-bs-target="#remove-student-modal" data-bs-action="{{ route('classroom.student.destroy', ['classroom' => $classroom->id, 'student' => $student->id]) }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
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

    <form method="POST" class="modal fade" id="remove-student-modal" tabindex="-1" aria-labelledby="remove-student-modal-label" aria-hidden="true" data-controller="confirm-modal" data-action="show.bs.modal->confirm-modal#onShow">
        @csrf
        @method('delete')
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remove-student-modal-label">Подтверждение удаления</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Удалить ученика?</p>
                    <p>Также будут удалены все связанные записи.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Удалить</button>
                </div>
            </div>
        </div>
    </form>

    <form method="POST" enctype="multipart/form-data" action="{{ route('classroom.student.upload', ['classroom' => $classroom->id]) }}" class="modal fade" id="upload-clasroom-modal" tabindex="-1" aria-labelledby="upload-clasroom-modal-label" aria-hidden="true">
        @csrf
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="upload-clasroom-modal-label">Загрузка учеников</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="hidden" name="with_heading_row" value="0">
                            <input class="form-check-input" name="with_heading_row" type="checkbox" value="1" id="upload-with-heading-row">
                            <label class="form-check-label" for="upload-with-heading-row">
                                Пропустить первую строку
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="action" value="reload" id="upload-action-reload">
                            <label class="form-check-label" for="upload-action-reload">
                                Перезагрузить <br> <span class="text-danger">Все ученики и всё с ними связанное будет удалено</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="action" value="add" id="upload-action-add" checked>
                            <label class="form-check-label" for="upload-action-add">
                                Добавить учеников
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="upload-file" class="form-label">Файл с учениками</label>
                        <input class="form-control" name="file" type="file" id="upload-file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Выгрузить</button>
                </div>
            </div>
        </div>
    </form>
@endsection
