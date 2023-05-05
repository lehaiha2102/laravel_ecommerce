@extends('admin.components.index');
@section('title')
Create New Manufacturer
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
                <form method="POST" action="{{ route('admin.manufacturer.store')}}" enctype="multipart/form-data" id="manufacturer-form">
                    @csrf
                    <div class="position-relative form-group">
                        <label for="name" class="">Name</label>
                        <input name="name" id="name" placeholder="Enter a manufacturer name" type="text" class="form-control">
                        <span id="name-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="email" class="">Email</label>
                        <input name="email" id="email" placeholder="Enter a manufacturer email" type="text" class="form-control">
                        <span id="email-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="phone" class="">Phone</label>
                        <input name="phone" id="phone" placeholder="Enter a manufacturer phone" type="text" class="form-control">
                        <span id="phone-error"></span>
                    </div>
                    <div class="position-relative form-group">
                        <label for="address" class="">Address</label>
                        <input name="address" id="address" placeholder="Enter a manufacturer address" type="text" class="form-control">
                        <span id="address-error"></span>
                    </div>
                    <button class="mt-1 btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#name").on("input", function() {
            $("#name-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var name = $("#name").val();
                if (name.length == 0) {
                    $("#name-error").html("The Manufacturer name field is required.").css("color", "red");
                } else if (name.length > 255) {
                    $("#name-error").html("The Manufacturer name may not be greater than 255 characters.").css("color", "red");
                } else if (!/^[a-zA-Z0-9 ]*$/.test(name)) {
                    $("#name-error").html("The Manufacturer name must not contain special characters.").css("color", "red");
                } else {
                    $("#name-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#email").on("input", function() {
            $("#email-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var email = $("#email").val();
                if (email.length == 0) {
                    $("#email-error").html("The Email address field is required.").css("color", "red");
                } else if (email.length > 255) {
                    $("#email-error").html("The Email address may not be greater than 255 characters.").css("color", "red");
                } else if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(email)) {
                    $("#email-error").html("The Email address format is invalid.").css("color", "red");
                } else {
                    $("#email-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#phone").on("input", function() {
            $("#phone-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var phone = $("#phone").val();
                if (phone.length == 0) {
                    $("#phone-error").html("The Phone number field is required.").css("color", "red");
                } else if (phone.length > 255) {
                    $("#phone-error").html("The Phone number may not be greater than 255 characters.").css("color", "red");
                } else if (!/^0[0-9]{9}$/.test(phone)) {
                    $("#phone-error").html("The Phone number format is invalid.").css("color", "red");
                } else {
                    $("#phone-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#address").on("input", function() {
            $("#address-error").html("checking...").css("color", "red");
            setTimeout(function() {
                var address = $("#address").val();
                if (address.length == 0) {
                    $("#address-error").html("The Address field is required.").css("color", "red");
                } else if (address.length > 255) {
                    $("#address-error").html("The Address may not be greater than 255 characters.").css("color", "red");
                } else {
                    $("#address-error").html("").css("color", "green");
                }
            }, 1000);
        });

        $("#manufacturer-form").submit(function(event) {
            event.preventDefault();
            var name = $("#name").val();
            var phone = $("#phone").val();
            var email = $("#email").val();
            var address = $("#address").val();
            if (name.length == 0) {
                alertify.error("Name is required");
                return;
            } else if (name.length > 255) {
                alertify.error("Name cannot exceed 255 characters");
                return;
            } else if (!/^[a-zA-Z0-9 ]*$/.test(name)) {
                alertify.error("Name cannot contain special characters");
                return;
            } else if (phone.length == 0) {
                alertify.error("The Phone number field is required.");
                return;
            } else if (phone.length > 255) {
                alertify.error("The Phone number may not be greater than 255 characters.");
                return;
            } else if (!/^0[0-9]{9}$/.test(phone)) {
                alertify.error("The Phone number format is invalid.");
                return;
            } else if (email.length == 0) {
                alertify.error("The Email address field is required.");
                return;
            } else if (email.length > 255) {
                alertify.error("The Email address may not be greater than 255 characters.");
                return;
            } else if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(email)) {
                alertify.error("The Email address format is invalid.");
                return;
            } else if (address.length == 0) {
                alertify.error("The Address field is required.");
                return;
            } else if (address.length > 255) {
                alertify.error("The Address may not be greater than 255 characters.");
                return;
            }
            $("#manufacturer-form").unbind('submit').submit();
        });
    });
</script>