@props(['user' => null])

<form method="POST" action="{{ url("admin/user/{$user->id}/edit") }}">
    @method('PUT')
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label" for="name-{{ $user->id }}">username</label>
            <input class="form-control" type="text" id="name-{{ $user->id }}"
                   name="name"
                   value="{{ $user->name }}"/>
            @error('is_active')
            <div class="name">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="email-{{ $user->id }}">Email</label>
            <input class="form-control" type="text" name="email"
                   id="email-{{ $user->id }}"
                   value="{{ $user->email }}"/>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="is_active-{{ $user->id }}">Active</label>
            <select class="form-select" name="is_active"
                    id="is_active-{{ $user->id }}">
                <option {{ !$user->is_active ? 'selected' : '' }} value="0">No
                </option>
                <option {{ $user->is_active ? 'selected' : '' }} value="1">Yes
                </option>
            </select>
            @error('is_active')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    @if(empty($slot))
        <button type="submit" class="btn btn-primary">Save changes</button>
    @else
        {{$slot}}
    @endif
</form>
