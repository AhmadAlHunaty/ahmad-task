@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="2">{{ session('status') }}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4 style="display: flex; justify-content: space-between;">
                            <div> Add users</div>
                            <a href="{{ url('user') }}" class="btn btn-secondary">back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('user/create') }}" method="POST"
                            style="display: flex; flex-direction: column; gap: 8px;">
                            @csrf
                            <div class="mb">
                                <label style="min-width: 200px;">Username </label>
                                <input type="text" name="name" value="{{ old('name') }}" />
                            </div>
                            <div class="mb">
                                <label style="min-width: 200px;">Email </label>
                                <input type="text" name="email" value="{{ old('email') }}" />
                            </div>
                            <div class="mb">
                                <label style="min-width: 200px;">Password </label>
                                <input type="password" name="password" required />
                                @error('password')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="password-confirm" style="min-width: 200px;">Confirm Password</label>
                                <input id="password-confirm" type="password" name="password_confirmation" required>
                            </div>
                            <div class="mb" style="display: flex; width: 100%; justify-content: end;">
                                <button type="submit" class='btn btn-primary'>Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
