@extends ('admin.index')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('title', 'Scene Audio List')

<style>
    label.error {
        color: red;
    }
</style>
<style>
    /* Example spinner styling */
    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(179, 214, 243, 0.5);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        border: 8px solid #e7c4c4;
        border-radius: 50%;
        border-top: 8px solid blue;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scene Audio</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Scene Audio</li>
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
                <div class="col-12">
                    <div class="card">
                        {{-- @if (session('sucees'))
                    <span class="alert alert-success">{{session('success')}}</span>
                    @endif --}}
                        <div class="card-header">
                            <button type="button" id="scene_audio_add_btn" class="btn btn-primary float-left"
                                data-toggle="modal" data-target="#scene_audio_modal">
                                Add Scene Audio
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.no</th>
                                        <th>Name</th>
                                        <th>Audio File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($SceneAudios as $SceneAudio)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucwords($SceneAudio->name) }}</td>
                                            <td>
                                                <audio controls>
                                                    <source src="{{ asset('SceneAudio/' . $SceneAudio->audioFile) }}"
                                                        type="audio/mpeg">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            </td>

                                            <td>
                                                <a href="javascript:void(0)"
                                                    class="btn btn-warning btn-sm edit_scene_audio_btns"
                                                    data-id="{{ $SceneAudio->id }}" data-name="{{ $SceneAudio->name }}"
                                                    data-audioFile="{{ asset('SceneAudio/' . $SceneAudio->audioFile) }}">
                                                    Edit
                                                </a>
                                                <button class="btn btn-danger btn-sm deleteSceneAudio"
                                                    data-id="{{ $SceneAudio->id }}">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Scene Audio Modal -->
    <div class="modal fade" id="scene_audio_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title scene_audio_modal_title" id="scene_audio_modal_title">Add Scene Audio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add_scene_audio_form" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <select name="name" id="name" class="form-control">
                                    <option value="">Select an Audio File</option>
                                    <option value="Safari_1">Safari_1</option>
                                    <option value="Safari_2">Safari_2</option>
                                    <option value="Safari_3">Safari_3</option>
                                    <option value="Safari_4">Safari_4</option>
                                    <option value="Safari_5">Safari_5</option>
                                    <option value="Safari_6">Safari_6</option>
                                    <option value="Safari_7">Safari_7</option>
                                    <option value="Safari_8">Safari_8</option>
                                </select>
                                <div id="error-name" class="form-valid-error text-danger"></div>
                            </div>

                            <div class="form-group">
                                <label for="scene_audio">Scene Audio File</label>
                                <input type="file" name="scene_audio" class="form-control" id="scene_audio"
                                    accept="audio/*">
                                <div id="error-scene_audio" class="form-valid-error text-danger"></div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" id="scene_audio_submit_btn" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Edit Scene Audio Modal -->
    <div class="modal fade" id="edit_scene_audio_modal" tabindex="-1" role="dialog"
        aria-labelledby="editSceneAudioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSceneAudioModalLabel">Edit Scene Audio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_scene_audio_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="scene_audio_id" id="edit_scene_audio_id">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <select name="name" id="edit_name" class="form-control">
                                <option value="Safari_1">Safari_1</option>
                                <option value="Safari_2">Safari_2</option>
                                <option value="Safari_3">Safari_3</option>
                                <option value="Safari_4">Safari_4</option>
                                <option value="Safari_5">Safari_5</option>
                                <option value="Safari_6">Safari_6</option>
                                <option value="Safari_7">Safari_7</option>
                                <option value="Safari_8">Safari_8</option>
                            </select>
                        </div>


                        <div id="current_audio_container" style="margin-top: 10px;">
                            <audio controls id="current_audio">
                                <source src="" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>



                        <div class="form-group">
                            <label for="edit_audioFile">Scene Audio File</label>
                            <input type="file" name="edit_audioFile" class="form-control" id="edit_audioFile">
                            <small>Leave blank if you want to keep previous file</small>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="save_scene_audio_btn" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <div id="preloader" style="display: none;">
        <div class="spinner"></div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

    <!-- Add Scene Audio Script -->
    <script>
        $(document).ready(function() {
            $("#scene_audio_add_btn").click(function() {

                $("label.error").hide();
                $('#add_scene_audio_form')[0].reset();
                $("#scene_audio_modal").modal('show');
            });

            $("#add_scene_audio_form").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    scene_audio: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a scene name",
                    },
                    scene_audio: {
                        required: "Please Upload A File"
                    }
                },

                submitHandler: function(form) {
                    event.preventDefault();
                    $('#preloader').show();

                    $('#error-name').text('');
                    $('#error-scene_audio').text('');
                    $(".form-valid-error.text-danger").text('');

                    var formData = new FormData(form);


                    $.ajax({
                        url: "{{ route('scene.create') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#preloader').hide();
                            if (response.success) {
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                $("#scene_audio_modal").modal('hide');
                                $('#add_scene_audio_form')[0].reset();

                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }

                        },
                        error: function(xhr) {
                            $('#preloader').hide();

                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                $('#error-name').text(errors.name ? errors.name[0] : '');
                                $('#error-scene_audio').text(errors.scene_audio ? errors
                                    .scene_audio[0] : '');
                            }
                        }
                    });
                }
            });
        });
    </script>

    <!-- Edit Scene Audio Script -->
    <script>
        $(document).ready(function() {
            $(document).on('click', '.edit_scene_audio_btns', function() {
                let sceneAudioId = $(this).data('id');
                let name = $(this).data('name');
                let audioFile = $(this).data('audioFile');

                $('#edit_scene_audio_id').val(sceneAudioId);
                $('#edit_name').val(name);
                // $('#edit_audioFile').val('');


                if (audioFile) {
                    let audioPath = "{{ asset('SceneAudio') }}/" + audioFile;
                    $('#current_audio').attr('src', audioPath).parent().show(); // Show the audio player
                } else {
                    $('#current_audio_container').hide(); // Hide audio player if no file
                }


                $('#edit_scene_audio_modal').modal('show');
            });

            $("#edit_scene_audio_form").validate({
                rules: {
                    name: {
                        required: true,
                        // minlength: 3
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a scene name",
                        minlength: "Scene name must be at least 3 characters long"
                    }
                },
                submitHandler: function(form) {
                    $('#preloader').show();

                    let formData = new FormData(form);
                    let sceneAudioId = $('#edit_scene_audio_id').val();

                    $.ajax({
                        url: 'scene-audio-update/' + sceneAudioId,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#preloader').hide();

                            if (response.success) {
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $('#edit_scene_audio_modal').modal('hide');
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }
                        },
                        error: function(xhr) {
                            $('#preloader').hide();

                            let errors = xhr.responseJSON.errors;
                            $('.form-valid-error').html('');
                            $.each(errors, function(key, value) {
                                $(`#error-${key}`).html(value[0]);
                            });
                        }
                    });
                }
            });

            $('#save_scene_audio_btn').click(function() {
                $('#edit_scene_audio_form').submit();
            });
        });
    </script>

    <!-- Delete Scene Audio Script -->
    <script>
        $(document).ready(function() {
            $('.deleteSceneAudio').click(function() {
                let sceneAudioId = $(this).data(
                    'id'); // Get the scene audio ID from the button's data attribute

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send an AJAX DELETE request to the server to delete the scene audio
                        $.ajax({
                            url: 'scene-audio-delete/' +
                                sceneAudioId, // Construct the URL for the delete request
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content') // CSRF token for security
                            },
                            success: function(response) {
                                // Handle the response from the server
                                if (response.status === false) {
                                    // If deletion is not allowed (due to association), show an error message
                                    Swal.fire({
                                        title: "Error",
                                        text: response
                                            .message, // Show the error message returned by the controller
                                        icon: "error"
                                    });
                                } else {
                                    // If deletion is successful, show a success message
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: response
                                            .message, // Show the success message returned by the controller
                                        icon: "success"
                                    });

                                    // Reload the page after a short delay to reflect the changes
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1500);
                                }
                            },
                            error: function() {
                                // If the AJAX request fails, show a generic error message
                                Swal.fire({
                                    title: "Error",
                                    text: "There was an issue deleting the scene audio.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>



    <!-- Data Table Initialization -->
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>

@endsection
