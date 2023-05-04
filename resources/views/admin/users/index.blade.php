@extends('admin.components.index');
@section('title')
Users
@endsection
@section('content')
<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content d-flex justify-content-center align-items-center">
            <a href="{{ route('admin.user.create') }}" class="btn btn-success">+Add</a>
        </div>
    </div>
    <div class=" col-md-6 col-xl-4">
        <div class="card mb-3 widget-content d-flex justify-content-center align-items-center">
            <div class="dropdown d-inline-block">
                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-outline-primary">Filter</button>
                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 32px, 0px);">
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control dropdown-item">
                                <option>Object</option>
                                <option value="user"> user </option>
                                <option value="group"> Group </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control dropdown-item">
                                <option>Value</option>
                                <option value=""> user </option>
                                <option value=""> Group </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content d-flex justify-content-center align-items-center">
            <input name="keyword" id="user-search" placeholder="Type your query and press enter" type="text" class="form-control">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover user-table">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Email verify</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td class="text-center text-muted">{{ ++$index }}</td>
                            <td class="text-center"> {{ $user->name }} </td>
                            <td class="text-center"> {{ $user->email }} </td>
                            <td class="text-center"> {{ $user->phone }} </td>
                            <td class="text-center"> {{ $user->address }} </td>
                            <td class="text-center"> {{ $user->role_name }} </td>
                            <td class="text-center"> {{ $user->email_verify = 1 ? 'Confirmed' : 'Unconfirmed' }} </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger" data-id="{{$user->id}}" data-toggle="modal" data-target="#exampleModal{{$user->id}}">
                                    <i class="pe-7s-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@foreach($users as $user)
<div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this user? <span style="color:red">{{$user->name}}</span></p>
                <form method="POST" action="{{ route('admin.user.destroy', ['id' => $user->id]) }}" onsubmit="return ConfirmDelete(this)">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <button class="btn btn-danger" type="submit"><i class="pe-7s-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>