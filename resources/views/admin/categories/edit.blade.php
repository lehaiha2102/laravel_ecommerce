@extends('admin.components.index');
@section('title')
Edit A Category
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
                @foreach ($categories as $category)
                <form method="POST" action="{{ route('admin.category.update', ['id' => $category->id])}}" enctype="multipart/form-data" id="category-form">
                    @csrf
                    @method('PATCH')
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" id="name" value="{{ $category->name }}" placeholder="Enter a category name" type="text" class="form-control">
                        <span id="name-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleSelect" class="">Parent category</label>
                        <select name="parent_category" id="exampleSelect" class="form-control">
                            <option>--Select--</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @if($cat->id == $category->parent_category) selected @endif>{{ $cat->name ?? 'No parent category' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleText" class="">Description</label>
                        <textarea name="description" id="exampleText" class="form-control">{{ $category->description }}</textarea>
                        <span id="description-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="image-category" class="">File</label>
                        <input name="image" value="{{ $category->image }}" id="image-category" type="file" class="form-control-file">
                        <span id="image-error"></span>
                        <img id="preview" src="/images/categories/{{ $category->image }}" alt="Preview" style=" max-width:160px; height:80px;">
                    </div>
                    <button class="mt-1 btn btn-primary">Update Category</button>
                </form>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            var image = $("#image-category").val(); // lưu giá trị của trường image
            var fileInput = $("#image-category")[0];
            var file = fileInput.files[0];
            if (name.length == 0) {
                alertify.error("Name is required");
                return;
            } else if (name.length > 255) {
                alertify.error("Name cannot exceed 255 characters");
                return;
            } else if (!/^[a-zA-Z0-9 ]*$/.test(name)) {
                alertify.error("Name cannot contain special characters");
                return;
            } else if (file && file.type.indexOf("image/") != 0) {
                alertify.error("Please select an image file, image field must be an image file (jpeg, png, bmp, gif, or svg).");
                return;
            } else if (file && file.size > 1024 * 1024) {
                alertify.error("Image may not be greater than :max kilobytes.");
                return;
            }
            $("#category-form").unbind('submit').submit();
        });
    });
</script>