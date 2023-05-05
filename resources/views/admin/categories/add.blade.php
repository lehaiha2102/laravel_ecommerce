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
                        <script>
                            alertify.error("{{ $error }}");
                        </script>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('admin.category.store')}}" enctype="multipart/form-data" id="category-form">
                    @csrf
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" id="name" placeholder="Enter a category name" type="text" class="form-control">
                        <span id="name-error"></span>
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
                        <span id="description-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="image-category" class="">File</label>
                        <input name="image" id="image-category" type="file" class="form-control-file">
                        <span id="image-error"></span>
                        <img id="preview" src="#" alt="Preview" style="display:none; max-width:160px; height:80px;">
                    </div>
                    <button class="mt-1 btn btn-primary" id="submit-btn">Add Category</button>
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
<script>
    $(document).ready(function() {
        $("#name").on("input", function() {
            $("#name-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var name = $("#name").val();
                if (name.length == 0) {
                    $("#name-error").html("Name is required").css("color", "red");
                } else if (name.length > 255) {
                    $("#name-error").html("Name cannot exceed 255 characters").css("color", "red");
                } else if (!/^[a-zA-Z0-9 ]*$/.test(name)) {
                    $("#name-error").html("Name cannot contain special characters").css("color", "red");
                } else {
                    $("#name-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#exampleText").on("input", function() {
            $("#description-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var description = $("#exampleText").val();
                if (description.length == 0) {
                    $("#description-error").html("Description is required").css("color", "red");
                } else {
                    $("#description-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#image-category").on("change", function() {
            $("#image-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var fileInput = $("#image-category")[0];
                var file = fileInput.files[0];
                if (!file) {
                    $("#image-error").html("Image is required").css("color", "red");
                } else if (file.type.indexOf("image/") != 0) {
                    $("#image-error").html("Please select an image file, image field must be an image file (jpeg, png, bmp, gif, or svg).").css("color", "red");
                } else if (file.size > 1024 * 1024) {
                    $("#image-error").html("Image may not be greater than :max kilobytes.").css("color", "red");
                } else {
                    $("#image-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#category-form").submit(function(event) {
            event.preventDefault();
            var name = $("#name").val();
            var fileInput = $("#image-category")[0];
            var file = fileInput.files[0];
            var description = $("#exampleText").val();
            if (name.length == 0) {
                alertify.error("Name is required");
                return;
            } else if (name.length > 255) {
                alertify.error("Name cannot exceed 255 characters");
                return;
            } else if (!/^[a-zA-Z0-9 ]*$/.test(name)) {
                alertify.error("Name cannot contain special characters");
                return;
            } else if (!file) {
                alertify.error("Image is required");
                return;
            } else if (file.type.indexOf("image/") != 0) {
                alertify.error("Please select an image file, image field must be an image file (jpeg, png, bmp, gif, or svg).");
                return;
            } else if (file.size > 1024 * 1024) {
                alertify.error("Image may not be greater than :max kilobytes.");
                return;
            } else if (description.length == 0) {
                alertify.error("Description is required");
                return;
            }
            $("#category-form").unbind('submit').submit();
        });
    });
</script>