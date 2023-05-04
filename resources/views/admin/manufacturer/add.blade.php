@extends('admin.components.index');
@section('title')
Create New Manufacturer
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('admin.manufacturer.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" id="name" placeholder="Enter a manufacturer name" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="email" class="">Email</label>
                        <input name="email" id="email" placeholder="Enter a manufacturer email" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="phone" class="">Phone</label>
                        <input name="phone" id="phone" placeholder="Enter a manufacturer phone" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="address" class="">Address</label>
                        <input name="address" id="address" placeholder="Enter a manufacturer address" type="text" class="form-control">
                    </div>
                    <button class="mt-1 btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection