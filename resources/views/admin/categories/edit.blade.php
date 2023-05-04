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
                <form method="POST" action="{{ route('admin.category.update', ['id' => $category->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" id="name" value="{{ $category->name }}" placeholder="Enter a category name" type="text" class="form-control">
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
                    </div>
                    <div class="position-relative form-group">
                        <label for="image-category" class="">File</label>
                        <input name="image" value="{{ $category->image }}" id="image-category" type="file" class="form-control-file">
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