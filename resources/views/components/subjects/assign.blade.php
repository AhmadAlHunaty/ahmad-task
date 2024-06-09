@php
    /**
     * @var $subjects \App\Models\Subject[]
     * @var $students \App\Models\Student[]
    */
@endphp
@props(['students', 'subjects'])
<form action="{{url()->route('subject.assign')}}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Student</label>
        <select class="form-select" aria-label="Default select example" name="student_id">
            <option selected>Open this select menu</option>
            @foreach($students as $student)
                <option value="{{$student->id}}">{{$student->user->name}}</option>
            @endforeach
        </select>
        @error('student_id')
        <span>{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label>Subject</label>
        <select class="form-select mb-3" aria-label="Default select example" name="subject_id">
            <option selected>Open this select menu</option>
            @foreach($subjects as $subject)
                <option value="{{$subject->id}}">{{$subject->name}}</option>
            @endforeach
        </select>
        @error('subject_id')
        <span>{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary">Create</button>
    </div>

</form>
