@extends('admin.components.index');
@section('title')
Roles
@endsection
@section('content')
<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content d-flex justify-content-center align-items-center">
            <a href="{{ route('admin.role.create') }}" class="btn btn-success">+Add</a>
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
                                <option value="role"> role </option>
                                <option value="group"> Group </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control dropdown-item">
                                <option>Value</option>
                                <option value=""> role </option>
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
            <input name="keyword" id="role-search" placeholder="Type your query and press enter" type="text" class="form-control">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover role-table">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $index => $role)
                        <tr>
                            <td class="text-center text-muted">{{ ++$index }}</td>
                            <td class="text-center"> {{ $role->name }} </td>
                            <td class="text-center"> {{ $role->description }} </td>
                            <td class="text-center">
                                <a href="{{ route('admin.role.edit', ['id' => $role->id]) }}" class="btn btn-warning"><i class="pe-7s-pen"></i></a>
                                <button type="button" class="btn btn-danger" data-id="{{$role->id}}" data-toggle="modal" data-target="#exampleModal{{$role->id}}">
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
@foreach($roles as $role)
<div class="modal fade" id="exampleModal{{$role->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this role? <span style="color:red">{{$role->name}}</span></p>
                <form method="POST" action="{{ route('admin.role.destroy', ['id' => $role->id]) }}" onsubmit="return ConfirmDelete(this)">
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