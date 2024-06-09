@props(['action' => url('user/create')])
<form action="{{$action}}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">username</label>
        <input class="form-control" type="text" name="name" value="{{old('name')}}"/>
    </div>
    <div class="mb-3">
        <label>Email </label>
        <input class="form-control" type="text" name="email" value="{{old('email')}}"/>
    </div>
    <div class="mb-3">
        <label class="form-label">Password </label>
        <input class="form-control" type="password" name="password" required/>
        @error('password')
        <span>{{ $message }}</span>
        @enderror
    </div>
    @if(auth()?->user()?->is_admin)
        <div class="mb-3">
            <label class="form-label" for="is_active">Active</label>
            <select class="form-select" name="is_active"
                    id="is_active">
                <option>Select</option>
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
            @error('is_active')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endif
    <div class="mb-3">
        <label for="password-confirm">Confirm Password</label>
        <input class="form-control" id="password-confirm" type="password" name="password_confirmation" required>
    </div>
    @if(!empty($slot))
        {{$slot}}
    @else
        <div class="mb-3">
            <button type="submit" class='btn'>Save</button>
        </div>
    @endif
</form>
