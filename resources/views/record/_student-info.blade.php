<tr id="@domid($student, 'info')">
    <td>{{ $student->name }}</td>
    <td>
        <div class="d-flex gap-1 justify-content-end">
            @if ($student->record)
            <a href="{{ route('report.record.edit', ['report' => $report->id, 'record' => $student->record_id]) }}" class="btn btn-accent2 btn-icon btn-sm">
                <x-bi-pencil />
            </a>
            @else
            <a href="{{ route('report.record.add', ['report' => $report->id, 'classroom' => $classroom->id, 'student' => $student->id]) }}" class="btn btn-accent1 btn-icon btn-sm">
                <x-bi-plus />
            </a>
            @endif
        </div>
    </td>
</tr>
