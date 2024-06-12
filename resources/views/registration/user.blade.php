@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @if (!\Auth::check())
                            <h4>
                                <div style="padding: 8px;"> Registration</div>
                                <br />
                                <div style="display: flex; flex-direction:column; gap:8px;">
                                    <a href="{{ url('user/create') }}" class="btn btn-secondary" style="min-width: 200px">Sign
                                        Up</a>
                                    <a href="{{ url('user/login') }}" class="btn btn-primary" style="min-width: 200px">Sign
                                        in</a>
                                </div>
                            </h4>
                        @endif
                    </div>
                    @if (\Auth::check())
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>username</th>
                                    <th>email</th>
                                </tr>
                                <tr>
                                    <td>{{ auth()->user()->name }}</td>
                                    <td>{{ auth()->user()->email }}</td>
                                </tr>
                            </table>

                            <table class="table">
                                <tr>
                                    <th>Subject</th>
                                    <th>Mark</th>
                                    <th>Pass Mark</th>
                                </tr>


                                @foreach (auth()->user()?->student?->subjects ?? [] as $subject)
                                    <tr>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->subjectMark->mark ?? 'N/A' }}</td>
                                        <td>{{ $subject->min_mark ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('students_in_subject', $subject->id) }}"
                                                class="btn btn-primary">Class Students</a>

                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
