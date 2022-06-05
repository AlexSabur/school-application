@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-8">

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
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $report->name }}</td>
                                        <td>
                                            <div class="d-flex gap-3 justify-content-end">
                                                {{-- <a href="{{ route('classroom.student.show', ['classroom' => $classroom->id, 'student' => $student->id]) }}" class="btn btn-accent1">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                                <a href="{{ route('classroom.student.edit', ['classroom' => $classroom->id, 'student' => $student->id]) }}" class="btn btn-accent2">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a> --}}
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
