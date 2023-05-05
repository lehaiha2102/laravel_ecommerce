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
                @foreach ($products as $product)
                <form method="POST" action="{{ route('admin.product.update', ['id' => $product->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" value="{{ $product->name }}" id="name" placeholder="Enter a product name" type="text" class="form-control">
                    </div>
                    <div>
                        <label>Choose categories for the product</label>
                        @foreach ($categories as $category)
                        <div>
                            <input type="checkbox" name="category_id[]" value="{{ $category->id }}" id="category{{ $category->id }}" @if (in_array($category->id, explode(',', $product->category_ids))) checked @endif>
                            <label for="category{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    </div>

                    <div class="position-relative form-group">
                        <label for="exampleSelect" class="">Manufacturer</label>
                        <select name="manufacturer_id" id="exampleSelect" class="form-control">
                            @foreach ($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}" @if ($manufacturer->id == $product->manufacturer_id) selected @endif>{{ $manufacturer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="position-relative form-group">
                        <label for="import_price" class="">Import price</label>
                        <input name="import_price" value="{{$product->import_price}}" id="import_price" placeholder="Enter a product import price" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="price" class="">Price</label>
                        <input name="price" value="{{$product->price}}" id="price" placeholder="Enter a product price" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="quantity" class="">Quantity</label>
                        <input name="quantity" value="{{$product->quantity}}" id="quantity" placeholder="Enter a product quantity" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleText" class="">Description</label>
                        <textarea name="description" value="" id="exampleText" class="form-control">{{$product->description}}</textarea>
                    </div>
                    <div class="position-relative form-group">
                        <label for="image-product" class="">Files</label>
                        <input class="form-control-file" type="file" id="image-product" name="images[]" value="{{$product->images}}" multiple onchange="previewImage(event)">
                        @php $images = json_decode($product->images); @endphp
                        @foreach ($images as $image)
                        <div id="image-preview">
                        <img id="preview" src="/images/products/{{ $image }}" alt="Preview" style="max-width:160px; height:80px;">
                        </div>
                        @endforeach
                    </div>
                    <button class="mt-1 btn btn-primary">Update Product</button>
                </form>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function previewImage(event) {
        var input = event.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imgContainer = document.createElement("div");
                imgContainer.classList.add("preview-container");

                var imgElement = document.createElement("img");
                imgElement.src = e.target.result;
                imgElement.classList.add("preview-image");
                imgElement.style.maxWidth = "160px";
                imgElement.style.height = "80px";
                imgContainer.appendChild(imgElement);

                var cancelBtn = document.createElement("button");
                cancelBtn.innerHTML = "x";
                cancelBtn.classList.add("cancel-btn");
                cancelBtn.style = `
                                position: absolute;
                                top: 0;
                                right: 0;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                width: 20px;
                                height: 20px;
                                background-color: red;
                                color: white;
                                border-radius: 50%;
                                font-size: 12px;
                                cursor: pointer;
                                border: none;
                                `;
                cancelBtn.addEventListener("click", function() {
                    imgContainer.remove();
                });
                imgContainer.appendChild(cancelBtn);

                document.getElementById("image-preview").appendChild(imgContainer);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
