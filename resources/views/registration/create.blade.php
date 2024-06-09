@extends('layout.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="2">{{session('status')}}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Add users
                            <a href="{{ url ('user')}}" class="btn">back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{url('user/create')}}" method="POST">
                            @csrf
                            <div class="mb">
                                <label>username </label>
                                <input type="text" name="name" value="{{old('name')}}"/>
                            </div>
                            <div class="mb">
                                <label>Email </label>
                                <input type="text" name="email" value="{{old('email')}}"/>
                            </div>
                            <div class="mb">
                                <label>Password </label>
                                <input type="password" name="password" required/>
                                @error('password')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" name="password_confirmation" required>
                            </div>
                            <div class="mb">
                                <button type="submit" class='btn'>Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
