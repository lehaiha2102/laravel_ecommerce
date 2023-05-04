@extends('admin.components.index');
@section('title')
Edit A Attributes
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
                @foreach ($attributes as $attribute)
                <form method="POST" action="{{ route('admin.attribute.update', ['id' => $attribute->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" value="{{ $attribute->name }}" id="name" placeholder="Enter a attribute name" type="text" class="form-control">
                    </div>
                    <button class="mt-1 btn btn-primary">Update Attribute</button>
                </form>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection