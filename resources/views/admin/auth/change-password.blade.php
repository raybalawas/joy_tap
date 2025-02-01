{{--
<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
</head>

<body>
    <h1>Reset Password</h1>
    <p>Click the link below to reset your password:</p>
    <a href="{{ route('admin.change.password', ['token' => $token]) }}">Reset Password</a>
</body>

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<style>
    .email-section .profile-bg {
        max-width: 600px;
        border-radius: 20px;
        margin: 70px auto;
    }

    .email-section .box {
        background-color: #fce190;
        border-radius: 20px 20px 0 0;
    }

    .email-section .box img {
        width: 580px;
        height: 200px;
        border-radius: 20px;
        background-position: center;
        object-fit: cover;
    }

    .btn {
        background-color: #007bff;
        color: #fff;
    }

    .btn:hover {
        background-color: #007bff;
        color: #fff;
    }
</style>

<body>
    <section class="email-section">
        <div class="profile-bg shadow">
            <div class="box text-center py-3">
                <a href="#"> <img src="{{ asset('images/logo.png') }}" alt="Logo" /> </a>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h6 class="pt-3">Hello Admin</h6>
                        <p class="my-3">
                            We received a request to reset your password. please click the
                            link provided below:
                        </p>
                        <p>
                            <a href="{{ route('admin.change.password', ['token' => $token]) }}">Reset Password</a>
                        </p>
                        <p>
                            If you did not request a password reset, please ignore this
                            email.
                        </p>
                        <p>Thank you for using Joytap.</p>
                        <div class="text-center">
                            <div class="btn btn-lg my-4">Reset Password</div>
                        </div>
                        <hr />
                        <p class="text-center">
                            &copy;
                            <script type="text/javascript">
                                var year = new Date();
                                document.write(year.getFullYear());
                            </script>
                            All Rights Reserved
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>