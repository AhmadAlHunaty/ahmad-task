@props(['students', 'subjects'])
<div>
    <form action="{{ url()->route('subject.mark') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Student</label>
            <select class="form-select" aria-label="Default select example" id="set-mark-student-select" name="student_id">
                <option selected>Open this select menu</option>
                @foreach ($students as $student)
                    @if ($student->user->is_active && !$student->user->is_admin)
                        <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                    @endif
                @endforeach
            </select>
            @error('student_id')
                <span>{{ $message }}</span>
            @enderror
        </div>


        @foreach ($students as $student)
            <div class="mb-3 d-none" id="student-mark-{{ $student->id }}">
                <label>Subject</label>

                <select class="form-select mb-3" aria-label="Default select example" name="subject_id">
                    {{-- @dd($student->subjects) --}}
                    @foreach ($student->subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('subject_id')
                    <span>{{ $message }}</span>
                @enderror
            </div>
        @endforeach

        <div class="mb-3">
            <label for="mark" class="form-label">Mark </label>
            <input required type="number" max="99" min="20" class="form-control" id="mark"
                name="mark">
        </div>
        @error('mark')
            <span>{{ $message }}</span>
        @enderror

        <div class="mb-3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Create</button>
        </div>

    </form>
</div>

<script>
    let oldId = null;
    $('#set-mark-student-select').change(function() {
        $('#student-mark-' + oldId).toggleClass('d-none')

        const id = oldId = this.value

        $('#student-mark-' + id).toggleClass('d-none')
    })
</script>
