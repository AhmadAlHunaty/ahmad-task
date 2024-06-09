@extends('layout.main')
@section('content')
    <div class="card-body" id="users">

        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-user">
                Create new User
            </button>
            <x-modal id="create-user">
                <x-slot:body>
                    <x-users.create :action="url('admin/user')">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </x-users.create>
                </x-slot:body>
            </x-modal>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-subject">Create
                new Subject
            </button>
            <x-modal id="create-subject">
                <x-slot:body>
                    <x-subjects.create/>
                </x-slot:body>
            </x-modal>
            <button
                type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assign-subject"
            >Assign a Subject to User
            </button>
            <x-modal id="assign-subject">
                <x-slot:body>
                    <x-subjects.assign :subjects="$subjects" :students="$students"/>
                </x-slot:body>
            </x-modal>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#set-mark">Set Mark
            </button>
            <x-modal id="set-mark">
                <x-slot:body>
                    <x-subjects.mark :subjects="$subjects" :students="$students"/>
                </x-slot:body>
            </x-modal>

        </div>

        <table class="table">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @foreach ($users as $user)
                <tr>
                    <th>username</th>
                    <th>email</th>
                </tr>

                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#edit-{{ $user->id }}">
                            Edit
                        </button>

                        <div class="modal fade" id="edit-{{ $user->id }}" tabindex="-1"
                             aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>

                                    <x-users.edit :user="$user">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </x-users.edit>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#delete-{{$user->id}}">
                            Delete
                        </button>

                        <div class="modal fade" id="delete-{{$user->id}}" tabindex="-1"
                             aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Do you want to delete the User?
                                    </div>

                                    <div class="modal-footer">
                                        <form action="{{ url("admin/user/$user->id/delete") }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
