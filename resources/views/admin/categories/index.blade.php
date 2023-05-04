@extends('admin.components.index');
@section('title')
Categories
@endsection
@section('content')
<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content d-flex justify-content-center align-items-center">
            <a href="{{ route('admin.category.create') }}" class="btn btn-success">+Add</a>
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
                                <option value="category"> Category </option>
                                <option value="group"> Group </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control dropdown-item">
                                <option>Value</option>
                                <option value=""> Category </option>
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
            <input name="keyword" id="category-search" placeholder="Type your query and press enter" type="text" class="form-control">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover category-table">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Parent</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Slug</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $index => $category)
                        <tr>
                            <td class="text-center text-muted">{{ ++$index }}</td>
                            <td class="text-center"> {{ $category->name }} </td>
                            <td class="text-center"> {{ $category->parent_name }} </td>
                            <td class="text-center">
                                <img src="/images/categories/{{ $category->image }}" style="max-width: 80px; max-height: 160px;">
                            </td>
                            <td class="text-center"> {{ $category->slug }} </td>
                            <td class="text-center status-toggle" data-category-id="{{ $category->id }}" data-status="{{ $category->status }}">
                                {{ $category->status == 1 ? 'Active' : 'Decommissioning' }}
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}" class="btn btn-warning"><i class="pe-7s-pen"></i></a>
                                <button type="button" class="btn btn-danger" data-id="{{$category->id}}" data-toggle="modal" data-target="#exampleModal{{$category->id}}">
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
@foreach($categories as $category)
<div class="modal fade" id="exampleModal{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this category? <span style="color:red">{{$category->name}}</span></p>
                <form method="POST" action="{{ route('admin.category.destroy', ['id' => $category->id]) }}" onsubmit="return ConfirmDelete(this)">
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
            var category_id = $(this).data('category-id');
            var current_status = $(this).data('status');
            var new_status = current_status == 1 ? 0 : 1;

            $.ajax({
                url: '{{ route("admin.categories.change-status") }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'category_id': category_id,
                    'status': new_status
                },
                success: function(response) {
                    if (response.success) {
                        $('.status-toggle[data-category-id="' + category_id + '"]').data('status', new_status);
                        $('.status-toggle[data-category-id="' + category_id + '"]').text(new_status == 1 ? 'Active' : 'Decommissioning');
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
