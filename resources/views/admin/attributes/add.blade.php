@extends('admin.components.index');
@section('title')
Create New Attributes
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
                <form method="POST" action="{{ route('admin.attribute.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" id="name" placeholder="Enter a attribute name" type="text" class="form-control">
                    </div>
                    <button class="mt-1 btn btn-primary">Add Attribute</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection