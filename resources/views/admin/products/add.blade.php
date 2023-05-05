@extends('admin.components.index');
@section('style')
<style>
    .preview-container {
        display: inline-block;
        position: relative;
        margin-right: 10px;
    }

    #image-preview {
        white-space: nowrap;
        overflow-x: auto;
    }

    .preview-image {
        display: inline-block;
        max-width: 160px;
        height: 80px;
        margin-right: 10px;
        position: relative;
    }

    .preview-image .cancel-btn {
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
    }
</style>
@endsection
@section('title')
Create New Product
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
                <form method="POST" action="{{ route('admin.product.store')}}" enctype="multipart/form-data" id="product-form">
                    @csrf
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" id="name" placeholder="Enter a product name" type="text" class="form-control">
                        <span id="name-error"></span>
                    </div>
                    <div>
                        <label>Choose categories for the product</label>
                        @foreach($categories as $category)
                        <div>
                            <input type="checkbox" name="category_id[]" value="{{ $category->id }}" id="category{{ $category->id }}">
                            <label for="category{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                        <span id="category-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="manufacturer" class="">Manufacturer</label>
                        <select name="manufacturer_id" id="manufacturer" class="form-control">
                            @foreach($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                            @endforeach
                        </select>
                        <span id="manufacturer-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="import_price" class="">Import price</label>
                        <input name="import_price" id="import_price" placeholder="Enter a product import price" type="text" class="form-control">
                        <span id="import_price-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="price" class="">Price</label>
                        <input name="price" id="price" placeholder="Enter a product price" type="text" class="form-control">
                        <span id="price-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="quantity" class="">Quantity</label>
                        <input name="quantity" id="quantity" placeholder="Enter a product quantity" type="text" class="form-control">
                        <span id="quantity-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="description" class="">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                        <span id="description-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="image-product" class="">Files</label>
                        <input class="form-control-file" type="file" name="images[]" onchange="previewImage(event)">
                        <div id="image-preview">
                        </div>
                        <span id="image-error"></span>
                    </div>

                    <button class="mt-1 btn btn-primary">Add Product</button>
                </form>
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
<script>
    $(document).ready(function() {
        $("#name").on("input", function() {
            $("#name-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var name = $("#name").val();
                if (name.length == 0) {
                    $("#name-error").html("The product name field is required.").css("color", "red");
                } else if (name.length > 255) {
                    $("#name-error").html("The product name may not be greater than 255 characters.").css("color", "red");
                } else if (!/^[a-zA-Z0-9 ]*$/.test(name)) {
                    $("#name-error").html("The product name must not contain special characters.").css("color", "red");
                } else {
                    $("#name-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("input[name='category_id[]']").on("change", function() {
            if ($("input[name='category_id[]']:checked").length == 0) {
                $("#category-error").html("Please select at least one category.").css("color", "red");
            } else {
                $("#category-error").html("").css("color", "green");
            }
        });

        $("#manufacturer").on("change", function() {
            if ($("#manufacturer").val() == "") {
                $("#manufacturer-error").html("Please select a manufacturer.").css("color", "red");
            } else {
                $("#manufacturer-error").html("").css("color", "green");
            }
        });

        $("#import_price").on("input", function() {
            $("#import_price-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var import_price = $("#import_price").val();
                if (import_price.length == 0) {
                    $("#import_price-error").html("The import price field is required.").css("color", "red");
                } else if (!/^\d+(\.\d{1,2})?$/.test(import_price)) {
                    $("#import_price-error").html("The import price must be a number with up to 2 decimal places.").css("color", "red");
                } else {
                    $("#import_price-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#price").on("input", function() {
            $("#price-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var price = $("#price").val();
                if (price.length == 0) {
                    $("#price-error").html("The price field is required.").css("color", "red");
                } else if (!/^\d+(\.\d{1,2})?$/.test(price)) {
                    $("#price-error").html("The price must be a number with up to 2 decimal places.").css("color", "red");
                } else {
                    $("#price-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#quantity").on("input", function() {
            $("#quantity-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var quantity = $("#quantity").val();
                if (quantity.length == 0) {
                    $("#quantity-error").html("The quantity field is required.").css("color", "red");
                } else if (!/^[0-9]*$/.test(quantity)) {
                    $("#quantity-error").html("The quantity must be a number.").css("color", "red");
                } else if (quantity <= 0) {
                    $("#quantity-error").html("The quantity must be greater than 0.").css("color", "red");
                } else {
                    $("#quantity-error").html("").css("color", "green");
                }
            }, 1000);
        });
        $("#import_price").on("input", function() {
            $("#import_price-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var importPrice = $("#import_price").val();
                if (importPrice.length == 0) {
                    $("#import_price-error").html("The import price field is required.").css("color", "red");
                } else if (!/^[0-9]*\.?[0-9]*$/.test(importPrice)) {
                    $("#import_price-error").html("The import price must be a number.").css("color", "red");
                } else if (importPrice < 0) {
                    $("#import_price-error").html("The import price must be greater than or equal to 0.").css("color", "red");
                } else {
                    $("#import_price-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#price").on("input", function() {
            $("#price-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var price = $("#price").val();
                if (price.length == 0) {
                    $("#price-error").html("The price field is required.").css("color", "red");
                } else if (!/^[0-9]*\.?[0-9]*$/.test(price)) {
                    $("#price-error").html("The price must be a number.").css("color", "red");
                } else if (price < 0) {
                    $("#price-error").html("The price must be greater than or equal to 0.").css("color", "red");
                } else {
                    $("#price-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#description").on("input", function() {
            $("#description-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var description = $("#description").val();
                if (description.length == 0) {
                    $("#description-error").html("Description is required").css("color", "red");
                } else {
                    $("#description-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#image-product").on("change", function() {
            $("#image-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var files = $(this)[0].files;
                if (files.length == 0) {
                    $("#image-error").html("At least one image is required").css("color", "red");
                } else {
                    var errorMessages = [];
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        if (file.type.indexOf("image/") != 0) {
                            errorMessages.push("File " + (i + 1) + " is not an image file");
                        } else if (file.size > 1024 * 1024) {
                            errorMessages.push("File " + (i + 1) + " may not be greater than :max kilobytes");
                        }
                    }
                    if (errorMessages.length > 0) {
                        $("#image-error").html(errorMessages.join("<br>")).css("color", "red");
                    } else {
                        $("#image-error").html("").css("color", "green");
                    }
                }
            }, 1000);
        });
        $("#product-form").submit(function(event) {
            event.preventDefault();
            var name = $('#name').val();
            var manufacture = $('#manufacturer').val();
            // var category = $('#category' + {{ $category->id }}).val();
            var importPrice = $('#import_price').val();
            var price = $('#price').val();
            var quantity = $("#quantity").val();
            var description = $("#description").val();
            // var image = $("#image-product").val();
            if (name.length == 0) {
                alertify.error("Name is required");
                return;
            } else if (name.length > 255) {
                alertify.error("Name cannot exceed 255 characters");
                return;
            } else if (!/^[a-zA-Z0-9 ]*$/.test(name)) {
                alertify.error("Name cannot contain special characters");
                return;
            }
            if (manufacturer == '') {
                alertify.error('Please select a manufacturer');
                return;
            }

            // if (category.length == 0) {
            //     alertify.error('Please choose at least one category');
            //     return;
            // }

            if (importPrice.trim().length == 0) {
                alertify.error('Import price is required');
                return;
            } else if (isNaN(importPrice)) {
                alertify.error('Import price must be a number');
                return;
            }

            if (price.trim().length == 0) {
                alertify.error('Price is required');
                return;
            } else if (isNaN(price)) {
                alertify.error('Price must be a number');
                return;
            }

            if (quantity.trim().length == 0) {
                alertify.error('Quantity is required');
                return;
            } else if (isNaN(quantity)) {
                alertify.error('Quantity must be a number');
                return;
            }

            if (description.trim().length == 0) {
                alertify.error('Description is required');
                return;
            }

            // if (image.trim().length == 0) {
            //     alertify.error('Image is required');
            //     return;
            // }
            $("#product-form").unbind('submit').submit();
        });
    });
</script>