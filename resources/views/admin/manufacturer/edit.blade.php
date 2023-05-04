@extends('admin.components.index');
@section('title')
Edit A Manufacturer
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
                @foreach ($manufacturers as $manufacturer)
                <form method="POST" action="{{ route('admin.manufacturer.update', ['id' => $manufacturer->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="position-relative form-group">
                <label for="name" class="">Name</label>
                <input name="name" value="{{ $manufacturer->name }}" id="name" placeholder="Enter a manufacturer name" type="text" class="form-control">
            </div>
                    <div class="position-relative form-group">
                        <label for="email" class="">Email</label>
                        <input name="email" value="{{ $manufacturer->email }}" id="email" placeholder="Enter a manufacturer email" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="phone" class="">Phone</label>
                        <input name="phone" value="{{ $manufacturer->phone }}" id="phone" placeholder="Enter a manufacturer phone" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="address" class="">Address</label>
                        <input name="address" value="{{ $manufacturer->address }}" id="address" placeholder="Enter a manufacturer address" type="text" class="form-control">
                    </div>
                    <button class="mt-1 btn btn-primary">Update Manufacturer</button>
                </form>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection