@extends('admin.components.index');
@section('title')
Manufacturers
@endsection
@section('content')
<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content d-flex justify-content-center align-items-center">
            <a href="{{ route('admin.manufacturer.create') }}" class="btn btn-success">+Add</a>
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
                                <option value="manufacturer"> manufacturer </option>
                                <option value="group"> Group </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                        <select class="form-control dropdown-item">
                                <option>Value</option>
                                <option value=""> manufacturer </option>
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
            <input name="keyword" id="manufacturer-search" placeholder="Type your query and press enter" type="text" class="form-control">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover manufacturer-table">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Slug</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($manufacturers as $index => $manufacturer)
                        <tr>
                            <td class="text-center text-muted">{{ ++$index }}</td>
                            <td class="text-center"> {{ $manufacturer->name }} </td>
                            <td class="text-center"> {{ $manufacturer->phone }} </td>
                            <td class="text-center"> {{ $manufacturer->email }} </td>
                            <td class="text-center"> {{ $manufacturer->address }} </td>
                            <td class="text-center"> {{ $manufacturer->slug }} </td>
                            <td class="text-center status-toggle" data-manufacturer-id="{{ $manufacturer->id }}" data-status="{{ $manufacturer->status }}">
                                {{ $manufacturer->status == 1 ? 'Active' : 'Decommissioning' }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.manufacturer.edit', ['id' => $manufacturer->id]) }}" class="btn btn-warning"><i class="pe-7s-pen"></i></a>
                                <button type="button" class="btn btn-danger" data-id="{{$manufacturer->id}}" data-toggle="modal" data-target="#exampleModal{{$manufacturer->id}}">
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
@foreach($manufacturers as $index => $manufacturer)
<div class="modal fade" id="exampleModal{{$manufacturer->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete manufacturer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this manufacturer? <span style="color:red">{{$manufacturer->name}}</span></p>
                <form method="POST" action="{{ route('admin.manufacturer.destroy', ['id' => $manufacturer->id]) }}" onsubmit="return ConfirmDelete(this)">
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
<script>
    $(document).ready(function() {
        $('.status-toggle').click(function() {
            var manufacturer_id = $(this).data('manufacturer-id');
            var current_status = $(this).data('status');
            var new_status = current_status == 1 ? 0 : 1;

            $.ajax({
                url: '{{ route("admin.manufacturer.change-status") }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'manufacturer_id': manufacturer_id,
                    'status': new_status
                },
                success: function(response) {
                    if (response.success) {
                        $('.status-toggle[data-manufacturer-id="' + manufacturer_id + '"]').data('status', new_status);
                        $('.status-toggle[data-manufacturer-id="' + manufacturer_id + '"]').text(new_status == 1 ? 'Active' : 'Decommissioning');
                        alertify.success(response.message);
                    } else {
                        alertify.warning(response.message);
                    }
                },
                error: function(xhr) {
                    alertify.error('Something went wrong. Please try again later.');
                }
            });
        });
    });
</script>

