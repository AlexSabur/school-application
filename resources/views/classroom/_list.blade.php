<div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
        <div class="d-flex gap-3 justify-content-start">
            Классы
        </div>
        <div class="d-flex gap-3 justify-content-end">
            <a href="{{ route('classroom.create') }}" class="btn btn-sm btn-icon btn-secondary">
                <x-bi-plus />
            </a>
        </div>
    </div>
    <div class="list-group list-group-flush">
        @foreach ($classrooms as $classroom)
            <a id="@domid($classroom)" href="{{ route('classroom.show', ['classroom' => $classroom->id]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                <div class="me-auto">
                    <div class="fw-bold">{{ $classroom->name }}</div>
                </div>
                <span class="badge bg-primary rounded-pill">{{ $classroom->students_count }}</span>
            </a>
        @endforeach
    </div>
</div>
