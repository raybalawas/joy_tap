@extends ('admin/index')
@section('title', 'Admin-Profile')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin-Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Admin Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <style>
        .avatar-upload {
            position: relative;
            display: inline-block;
        }

        .avatar-upload .avatar-preview {
            position: relative;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            overflow: hidden;
            background: #f8f8f8;
            margin: 0 auto;
            border: 2px solid #dddddd;
        }

        .avatar-upload .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .avatar-upload .avatar-edit {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #ffffff;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #cccccc;
            cursor: pointer;
        }

        .avatar-upload .avatar-edit input[type='file'] {
            display: none;
        }

        .avatar-upload .avatar-edit label {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            margin: 0;
        }

        .avatar-upload .avatar-edit label .pencil-icon {
            width: 20px;
            height: 20px;
        }
    </style>


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline admin_edit_profile_image">
                        <div class="card-body box-profile">
                            <form method="post" action="{{ route('update.admin.profile') }}" id="upload-image-form"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="avatar-upload">
                                    <div class="avatar-preview">
                                        @if (Auth::guard('admin')->user()->profile_image)
                                            <img id="imagePreview"
                                                src="{{ url('admin-assets/uploads/profileimages/' . $data->profile_image) }}"
                                                alt="image">
                                        @else
                                            <img id="imagePreview"
                                                src="{{ url('/admin-assets/uploads/placeholderImage/admin.jpg') }}"
                                                class="user-image img-circle elevation-2" alt="User Image">
                                        @endif
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" name="image" id="adminimageUpload"
                                            accept=".png, .jpg, .jpeg" onchange="readURLAndSubmit(this);" />
                                        <label for="adminimageUpload">
                                        </label>
                                    </div>
                                </div>
                            </form>
                            {{-- {{$data->all()}} --}}
                            <h3 class="profile-username text-center">{{ $data->name }}</h3>
                            <p class="text-muted text-center">{{ ucwords($data->user_type) }}</p>

                        </div>
                    </div>
                    <!-- /.Profile Image -->
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <!------Tab-------->
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#information"
                                        data-toggle="tab">Info</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
                                </li>
                            </ul>
                        </div>
                        <!-----/.Tab----->

                        <!------Tab Content-------->
                        <div class="card-body">
                            <div class="tab-content">

                                <!------Information Tab-------->
                                <div class="tab-pane active" id="information">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Name : </label>
                                        <div class="col-sm-10 mt-2">{{ $data->name }}</div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Email : </label>
                                        <div class="col-sm-10 mt-2">{{ $data->email }}</div>
                                    </div>
                                </div>

                                <!------Setting Tab-------->
                                <div class="tab-pane" id="settings">

                                    <form class="form-horizontal" action="{{ route('admin.change.detail') }}" method="post"
                                        name="admin_deatils" id="admin_deatils">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Enter Name" value="{{ $data->name }}">
                                                @error('name')
                                                    <div class="form-valid-error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Email" value="{{ $data->email }}">
                                                @error('email')
                                                    <div class="form-valid-error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                    <form class="form-horizontal" action="{{ route('admin.reset.password') }}"
                                        method="post" id="change_password_admin">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Current
                                                Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="current_password"
                                                    name="current_password" placeholder="Current Password">
                                                @error('current_password')
                                                    <div class="form-valid-error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">New Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="password"
                                                    name="password" placeholder="New Password">
                                                @error('password')
                                                    <div class="form-valid-error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Confirm
                                                Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation" placeholder="Confirm Password">
                                                @error('password_confirmation')
                                                    <div class="form-valid-error text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!------/. Tab Content-------->
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <script type="text/javascript">
        function readURLAndSubmit(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);

                // Submit the form after the image is loaded
                input.form.submit();
            }
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#adminimageUpload').change(function(e) {
            e.preventDefault();
            $('#upload-image-form').submit();
        });

        $('#upload-image-form').submit(function(e) {
            e.preventDefault();
            //alert('fsf');

            let formData = new FormData(this);
            // Append data
            //formData.append('file',files[0]);
            //formData.append('_token',CSRF_TOKEN);
            $.ajax({
                type: 'POST',
                data: formData,
                //data : {},
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: (response) => {
                    if (response) {
                        this.reset();
                        //alert('Image has been updated successfully');
                        toastr.success('Image has been updated successfully');
                    }
                },
                error: function(response) {
                    console.log(response);
                    $('#image-input-error').text(response.responseJSON.errors.file);
                }
            });
        });
    </script>

@endsection
