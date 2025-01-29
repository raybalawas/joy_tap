@extends ('admin.index')
@section('title', 'Dashboard')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ route('user.list') }}" style="text-decoration: none; color: inherit;">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Users</span>
                                <span class="info-box-number">{{ $total_users }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ route('animal.videos') }}" style="text-decoration: none; color: inherit;">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-video"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Videos</span>
                                <span class="info-box-number">{{ $total_videos }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ route('scene.index') }}" style="text-decoration: none; color: inherit;">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i
                                    class="fas fa-audio-description"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Scene Audio</span>
                                <span class="info-box-number">{{ $total_scene_audio }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ route('language.index') }}" style="text-decoration: none; color: inherit;">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-language"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Language</span>
                                <span class="info-box-number">{{ $total_language }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>

            </div>


        </div>
        <!-- /.col -->
    </section>
    <!-- /.content -->
@endsection
