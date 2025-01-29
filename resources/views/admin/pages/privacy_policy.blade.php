@extends ('admin/index')
@section('title', 'Privacy Policy')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Privacy Policy </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('pages') }}">Pages</a> / Privacy Policy</li>
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

                <div class="card-body">
                    <form id="privacy_policy" method="post" action="{{ route('privacy.policy.edit') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-12">
                            <label for="meta_title name">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter title"
                                value="{{ $data->title }}">
                            @error('title')
                                <span class=" text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 row">
                            <div class="form-group col-12">
                                <label for="content">Content</label>
                                <textarea id="content" class="form-control" rows="8" name="content" placeholder="Enter content" value="">{{ $data->content }}</textarea>
                                @error('content')
                                    <span class=" text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer card_footer_digi">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <script>
        $(function() {
            // Summernote
            $('#content').summernote()
        })
    </script>

@endsection
