<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/admin-assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('/admin-assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/admin-assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin-assets/assets/css/style.css') }}">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    {{-- --toster links end here--- --}}

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h4">
                    <p>Forgot Password</p>
                </a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                <form action="{{ route('admin.reset.forgotpassword') }}" method="post">
                    @csrf
                    <div class="input-group mb-1">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror

                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}">Login</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    {{-- -------------- --}}
    <!-- jQuery -->
    <script src="{{ asset('/admin-assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/admin-assets/dist/js/adminlte.min.js') }}"></script>

    <!-- Toastr JS -->
    <script src="{{ url('/admin-assets/plugins/toastr/toastr.min.js') }}"></script>


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
    @if (Session::has('info'))
        <script>
            $(document).ready(function() {
                toastr.info("{{ session('info') }}", "Info", {
                    closeButton: true,
                    progressBar: true
                });
            });
        </script>
    @endif
</body>

</html>
