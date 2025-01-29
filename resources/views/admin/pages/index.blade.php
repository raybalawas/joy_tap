@extends ('admin/index')
@section('title', 'pages')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pages</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pages</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-danger"><i class="fa fa-shield"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Privacy Policy</span>
            <span class="info-box-number"><a href="{{route('privacy.policy')}}">Edit</a></span>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="far fa-file-alt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Terms & Condition</span>
            <span class="info-box-number"><a href="{{route('terms.conditions')}}">Edit</a></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /. Main content -->
@endsection