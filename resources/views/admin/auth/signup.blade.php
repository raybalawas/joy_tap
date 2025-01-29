<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('public/backend/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('public/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/backend/dist/css/adminlte.min.css')}}">

  <!-----Custom Style Sheet------->
  <link rel="stylesheet" href="{{asset('public/backend/dist/css/customstyle.css')}}">

</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    
    <div class="card-body">
      <p class="login-box-msg">Create Account</p>
      <form action="{{url('admin/register')}}" method="post" class="registration_from">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control @error('full_name') is-invalid @enderror" placeholder="Full name" name="full_name" value="{{ old('full_name') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>          
        </div>
        <!-- Full Name Error -->
       <!--  @error('full_name')
          <div class="error">{{ $message }}</div>
        @enderror -->

        <div class="input-group mb-3">
          <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <!-- Email Error -->
        <!--  @error('email')
          <div class="error">{{ $message }}</div>
        @enderror -->

        <div class="input-group mb-3">
          <input type="password" class="form-control  @error('user_password') is-invalid @enderror" placeholder="Password" name="user_password" value="{{ old('user_password') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!-- Email Error -->
        <!--  @error('email')
          <div class="error">{{ $message }}</div>
        @enderror -->

        <div class="input-group mb-3">
          <input type="password" class="form-control @error('confirm_pass') is-invalid @enderror" placeholder="Retype password" name="confirm_pass" value="{{ old('confirm_pass') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!-- Email Error -->
        <!--  @error('email')
          <div class="error">{{ $message }}</div>
        @enderror -->


        <!-- Terms and Condition Error -->
        @error('terms')
          <div class="signup_error">{{ $message }}</div>
        @enderror
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree" class="@error('terms') is-invalid @enderror">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>          
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->         

        </div>
      </form>

      <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="login" class="text-center">Login</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{asset('public/backend/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/backend/dist/js/adminlte.js')}}"></script>
</body>
</html>