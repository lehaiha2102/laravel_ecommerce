@extends('admin.components.index');
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css">
@toastr_css
@endsection
@section('title')
Create New Category
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
                <form method="POST" action="{{ route('admin.category.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" id="name" placeholder="Enter a category name" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleSelect" class="">Parent category</label>
                        <select name="parent_category" id="exampleSelect" class="form-control">
                            <option>--Select--</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name ?? 'No parent category' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleText" class="">Description</label>
                        <textarea name="description" id="exampleText" class="form-control"></textarea>
                    </div>
                    <div class="position-relative form-group">
                        <label for="image-category" class="">File</label>
                        <input name="image" id="image-category" type="file" class="form-control-file">
                        <img id="preview" src="#" alt="Preview" style="display:none; max-width:160px; height:80px;">
                    </div>
                    <button class="mt-1 btn btn-primary">Add Category</button>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('image-category');
        const previewImg = document.getElementById('preview');
        fileInput.addEventListener("change", function() {
            const reader = new FileReader();
            reader.onload = function() {
                previewImg.src = reader.result;
                previewImg.style.display = "block";
            };
            reader.readAsDataURL(fileInput.files[0]);
        });
    });
</script>