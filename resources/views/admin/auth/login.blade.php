<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin-Login</title>

    {{-- ----------------------- --}}
    <!-- Google Font: Source Sans Pro -->
    <!-- jQuery -->
    <script src="{{ asset('/admin-assets/plugins/jquery/jquery.min.js') }}"></script>
    {{-- --toster links--- --}}
    <script src="//cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>
    <!-- Toastr JS -->
    <script src="{{ url('/admin-assets/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    {{-- --toster links end here--- --}}

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('/admin-assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/admin-assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin-assets/assets/css/style.css') }}">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h2><b style="color: #c58c02; font-size:35px"></b>Admin Login(joyTap)</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('login.crediential') }}" method="post" name="adminlogin"
                    class="adminlogin_form">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <div class="form-valid-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password"
                            value="{{ old('password') }}" id="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock" onclick="togglePassword()" id="lockIcon"></span>
                            </div>
                        </div>
                        @error('password')
                            <div class="form-valid-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Log In</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1">
                    <a href="{{ route('admin.forgotpassword') }}">I forgot my password</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    {{-- ----toster------- --}}
    @if (Session::has('success'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('success') }}", "Success", {
                    closeButton: true,
                    progressBar: true
                });
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            $(document).ready(function() {
                toastr.error("{{ session('error') }}", "Error", {
                    closeButton: true,
                    progressBar: true
                });
            });
        </script>
    @endif


    <script>
        function togglePassword() {
            var x = document.getElementById("password");
            var lockIcon = document.getElementById("lockIcon")
            // alert(lockIcon);
            if (x.type === "password") {
                x.type = "text";
                lockIcon.classList.remove("fa-lock");
                lockIcon.classList.add("fa-unlock")
            } else {
                x.type = "password";
                lockIcon.classList.remove("fa-unlock");
                lockIcon.classList.add("fa-lock");
            }
        }
    </script>
</body>

</html>
