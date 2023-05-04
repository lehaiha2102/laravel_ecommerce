@extends('admin.components.index');
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css">
@toastr_css
@endsection
@section('title')
Create New Role
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">
                @if($errors->any())
                <div>
                    <ul>
                        @foreach($errors->all() as $error)
                      <script> alertify.error("{{ $error }}");</script>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('admin.role.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" id="name" placeholder="Enter a role name" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleText" class="">Description</label>
                        <textarea name="description" id="exampleText" class="form-control"></textarea>
                    </div>
                    <button class="mt-1 btn btn-primary">Add Role</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@jquery
@toastr_js
@toastr_render