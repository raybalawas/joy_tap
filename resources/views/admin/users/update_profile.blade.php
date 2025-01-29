@extends ('admin/index')
@section('title', 'Complete User Profile')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Complete-User-Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Complete Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <style>
                .form-container {
                    max-width: 500px;
                    margin: auto;
                    padding: 20px;
                    border: 1px solid #ccc;
                    border-radius: 10px;
                }

                .form-group {
                    margin-bottom: 15px;
                }

                .form-group label {
                    display: block;
                    margin-bottom: 5px;
                }

                .form-group input,
                .form-group select,
                .form-group textarea {
                    width: 100%;
                    padding: 6px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                }

                .image-upload {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 15px;
                }

                .image-upload div {
                    width: 32%;
                    border: 1px dashed #ccc;
                    padding: 10px;
                    text-align: center;
                    border-radius: 5px;
                }

                .image-upload input {
                    display: none;
                }

                .image-upload img {
                    width: 100%;
                    height: auto;
                    border-radius: 5px;
                    margin-top: 10px;
                }

                .verticals {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 10px;
                }

                .verticals label {
                    background: #f1f1f1;
                    padding: 10px;
                    border-radius: 5px;
                    cursor: pointer;
                }

                .verticals input {
                    display: none;
                }

                .img_height_width {
                    height: 110px !important;
                    width: 110px !important;
                }
            </style>
            </head>

            <body>
                <div class="form-container float-left">
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="image-upload">
                            <div>
                                <label for="main_image">
                                    Main Profile Picture
                                    <input type="file" id="main_image" name="main_image" accept="image/*"
                                        onchange="previewImage(event, 'main_image_preview')">
                                </label>
                                @if (isset($user->userProfile->profile_image))
                                    <img class="img_height_width"id="main_image_preview"
                                        src="{{ asset('admin-assets/uploads/profileimages') . '/' . $user->userProfile->profile_image }}"
                                        alt="Main Image Preview">
                                @else
                                    <img class="img_height_width"id="main_image_preview" src="#"
                                        alt="Main Image Preview" style="display: none;">
                                @endif
                            </div>
                            <div>
                                <label for="second_image">
                                    2rd Profile Picture
                                    <input type="file" id="second_image" name="second_image" accept="image/*"
                                        onchange="previewImage(event, 'second_image_preview')">
                                </label>
                                @if (isset($user->userProfile->profile_img_second))
                                    <img class="img_height_width"id="second_image_preview"
                                        src="{{ asset('admin-assets/uploads/profileimages') . '/' . $user->userProfile->profile_img_second }}"
                                        alt="Second Image Preview">
                                @else
                                    <img class="img_height_width"id="second_image_preview" src=""
                                        alt="Second Image Preview" style="display: none;">
                                @endif

                            </div>
                            <div>
                                <label for="third_image">
                                    3rd Profile Picture
                                    <input type="file" id="third_image" name="third_image" accept="image/*"
                                        onchange="previewImage(event, 'third_image_preview')">
                                </label>

                                @if (isset($user->userProfile->profile_img_third))
                                    <img class="img_height_width"id="third_image_preview"
                                        src="{{ asset('admin-assets/uploads/profileimages') . '/' . $user->userProfile->profile_img_third }}"
                                        alt="Third Image Preview">
                                @else
                                    <img class="img_height_width"id="third_image_preview" src="#"
                                        alt="Third Image Preview" style="display: none;">
                                @endif
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <label for="brand_name">Brand Name</label>
                            <input class="form-control" type="text" id="brand_name" name="brand_name"
                                value="{{ $user->brand_name }}" placeholder="Enter brand name">
                            <input type="hidden" id="id" name="id" value="{{ $user->id }}">
                        </div> --}}

                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" placeholder="Enter bio">{{ $user->userProfile ? $user->userProfile->bio : '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="instagram_username">Instagram Username</label>
                            <input class="form-control" type="text" id="instagram_username" name="instagram_username"
                                value="{{ $user->userProfile ? $user->userProfile->instagram_username : '' }}"
                                placeholder="Enter instagram username">
                            <input type="hidden" id="id" name="id" value="{{ $user->id }}">
                        </div>
                        <div class="form-group">
                            <label for="instagram_username">Instagram followers</label>
                            <input class="form-control" type="number" id="insta_followers" name="insta_followers" placeholder="Enter instagram followers">
                        </div>
                        {{-- testing --}}
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob"
                                value="{{ $user->userProfile ? $user->userProfile->dob : '' }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" class="form-control">
                                <option value="">Select</option>
                                <option
                                    {{ $user->userProfile ? ($user->userProfile->gender == 'male' ? 'selected' : '') : '' }}
                                    value="male">Male
                                </option>
                                <option
                                    {{ $user->userProfile ? ($user->userProfile->gender == 'female' ? 'selected' : '') : '' }}
                                    value="female">
                                    Female
                                </option>
                                <option
                                    {{ $user->userProfile ? ($user->userProfile->gender == 'other' ? 'selected' : '') : '' }}
                                    value="other">Other
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="vertical">Verticals</label>
                            <select class="form-control " id="vertical_id" name="vertical_id">
                                <option value="">Select</option>
                                @foreach ($verticals as $vertical)
                                    <option value="{{ $vertical->id }}"
                                        @if ($user->userProfile && $vertical->id == $user->userProfile->vertical_ids) selected
                                        @endif>
                                        {{ $vertical->vertical_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label for="duratioverticalsnInput">Verticals</label>
                            <select style="width: 100%;" name="verticals[]" class="form-control select_verticals" id="verticals" multiple>
                                @foreach ($verticals as $vertical)
                                {{-- <option value="{{ $vertical->vertical_name }}">{{ $vertical->vertical_name }}</option> --}}
                                {{-- <option value="{{ $vertical->id }}"
                                    @if ($user->userProfile && $vertical->id == $user->userProfile->vertical_ids) selected
                                    @endif>
                                    {{ $vertical->vertical_name }}
                                </option>
                                @endforeach
                            </select> --}}
                        {{-- </div> --}}

                        <div class="form-group">
                            <button type="submit" class="btn-primary btn">Update</button>
                        </div>
                    </form>
                </div>
        </div>
    </section>
    <!-- /. Main content -->
    <script>
        function previewImage(event, previewId) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById(previewId);
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#subadminlisting').DataTable();
        });
    </script>

@endsection
