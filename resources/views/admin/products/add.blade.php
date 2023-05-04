@extends('admin.components.index');
@section('title')
Create New Product
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
                <form method="POST" action="{{ route('admin.product.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" id="name" placeholder="Enter a product name" type="text" class="form-control">
                    </div>
                    <div>
                        <label>Choose categories for the product</label>
                        @foreach($categories as $category)
                        <div>
                            <input type="checkbox" name="category_id[]" value="{{ $category->id }}" id="category{{ $category->id }}">
                            <label for="category{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleSelect" class="">Manufacturer</label>
                        <select name="manufacturer_id" id="exampleSelect" class="form-control">
                            @foreach($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="position-relative form-group">
                        <label for="import_price" class="">Import price</label>
                        <input name="import_price" id="import_price" placeholder="Enter a product import price" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="price" class="">Price</label>
                        <input name="price" id="price" placeholder="Enter a product price" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="quantity" class="">Quantity</label>
                        <input name="quantity" id="quantity" placeholder="Enter a product quantity" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleText" class="">Description</label>
                        <textarea name="description" id="exampleText" class="form-control"></textarea>
                    </div>
                    <div class="position-relative form-group">
                        <label for="image-category" class="">Files</label>
                        <input class="form-control-file" type="file" name="images[]" multiple onchange="previewImages()">
                        <div id="preview-container"></div>
                    </div>
                    <button class="mt-1 btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
function previewImages() {
  var previewContainer = document.getElementById('preview-container');
  var files = document.querySelector('input[type=file]').files;
  previewContainer.innerHTML = '';
  for (var i = 0; i < files.length; i++) {
    var reader = new FileReader();
    reader.onloadend = function() {
      var img = document.createElement('img');
      img.src = reader.result;
      previewContainer.appendChild(img);
    };
    reader.readAsDataURL(files[i]);
  }
}
</script>