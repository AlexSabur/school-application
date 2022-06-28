<tr id="@domid($student, 'buttons')">
    <td colspan="2">
        <turbo-frame class="d-flex cols-3 gap-3 justify-content-center">
            @foreach ($violations as $violation)
                <button form="store-quick-{{ $student->id }}-{{ $violation->id }}" class="btn btn-sm d-block @if($student->violation_id === $violation->id) btn-accent1 @else btn-accent2 @endif">
                    {{ $violation->name }}
                </button>
                <form id="store-quick-{{ $student->id }}-{{ $violation->id }}" class="d-none" action="{{ route('report.record.store-quick', ['report' => $report->id, 'classroom' => $classroom->id, 'student' => $student->id, 'violation' => $violation->id]) }}" method="post">
                    @csrf
                </form>
            @endforeach
        </turbo-frame>
    </td>
</tr>
