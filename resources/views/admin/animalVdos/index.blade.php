@extends('admin.index')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="dropzone.min.js"></script>
@section('title', 'Videos-List')

<style>
    label.error {
        color: rgb(255, 0, 0);
    }
</style>
<style>
    /* Pagination container styling */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        /* Adjust spacing */
        padding: 10px 0;
        list-style: none;
    }

    /* Pagination item (each page number) */
    .pagination li {
        margin: 0 4px;
        /* Small space between items */
    }

    /* Styling for pagination links */
    .pagination li a,
    .pagination li span {
        padding: 8px 12px;
        font-size: 14px;
        font-weight: 500;
        border: 1px solid #ddd;
        border-radius: 4px;
        /* Rounded corners */
        color: #007bff;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Pagination item on hover */
    .pagination li a:hover {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    /* Active pagination item styling */
    .pagination li.active span {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    /* Disabled state for pagination (not clickable) */
    .pagination li.disabled span {
        background-color: #f5f5f5;
        color: #ccc;
        cursor: not-allowed;
    }

    /* First and Last page buttons styling */
    .pagination .first,
    .pagination .last {
        font-weight: bold;
    }

    /* Previous and Next buttons styling */
    .pagination .previous,
    .pagination .next {
        font-weight: bold;
    }

    /* Add custom spacing between first, prev, next, last buttons */
    .pagination .first,
    .pagination .previous,
    .pagination .next,
    .pagination .last {
        margin-right: 8px;
    }

    /* Add styling for page number buttons */
    .pagination .page-item {
        display: inline-block;
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

    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">All Videos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Videos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary float-left" data-bs-toggle="modal"
                                data-bs-target="#createModal">
                                Add Video
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Scene</th>
                                        <th>Animal Type</th>
                                        <th>Language</th>
                                        <th>Language Audio</th>
                                        <th>Video URL</th>
                                        <th>Scene Audio</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($videos as $video)
                                        <tr>
                                            <td>{{ $loop->iteration + ($videos->currentPage() - 1) * $videos->perPage() }}
                                            </td>
                                            <td>{{ $video->scene_name }}</td>
                                            <td>{{ $video->animal_type }}</td>
                                            {{-- <td>{{ $video->languages->name }}</td> --}}
                                            <td>{{ $video->language }}</td>
                                            <td>
                                                <audio controls>
                                                    <source src="{{ asset('LanguageAudio/' . $video->ln_audio) }}"
                                                        type="audio/mpeg">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            </td>
                                            <td>
                                                <a href="{{ asset('AnimalVideos/' . $video->video_link) }}"
                                                    target="_blank">View
                                                    Video</a>
                                            </td>
                                            <td>
                                                @if ($video->sceneAudio)
                                                    <audio controls>
                                                        <source
                                                            src="{{ asset('SceneAudio/' . $video->sceneAudio->audioFile) }}"
                                                            type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                @else
                                                    <span>No Audio Available</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning  btn-sm edit-video"
                                                    data-id="{{ $video->id }}">Edit</button>
                                                <button class="btn btn-danger btn-sm delete-video"
                                                    data-id="{{ $video->id }}">Delete</button>
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

    <!-- Create Video Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add Video</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <form id="createVideoFormsdf" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="scene">Select Scene</label>
                            <select class="form-control" name="scene" id="scene">
                                <option value="">Select Scene</option>
                                @foreach ($safaries as $safari_name => $animals)
                                    <option value="{{ $safari_name }}">{{ $safari_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="animal_type">Select Animal</label>
                            <select class="form-control" name="animal_type" id="animal_type">
                                <option value="">Select Animal</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="create_language">Select Language</label>
                            <select class="form-control" name="language" id="create_language">
                                <option value="">Select Language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="scene_audio" class="form-label">Scene Audio</label>
                            <select class="form-control" name="scene_audio" id="scene_audio">
                                <option value="">Select Scene Audio</option>
                                @foreach ($SceneAudios as $SceneAudio)
                                    <option value="{{ $SceneAudio->id }}">{{ $SceneAudio->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ln_audio" class="form-label">Language Audio</label>
                            <input type="file" class="form-control" id="ln_audio" name="ln_audio" accept="audio/*">
                        </div>




                        <div class="mb-3">
                            <label for="create_video_link" class="form-label">Video Link</label>
                            <input type="file" class="form-control" id="create_video_link" name="video_link"
                                accept="video/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Add Video</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="preloader" style="display: none;">
        <div class="spinner"></div>
    </div>

    <!-- Edit Video Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Video</h5>
                </div>
                <div class="modal-body">
                    <form id="editVideoForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="edit_scene">Select Scene</label>
                            <select class="form-control" name="scene" id="edit_scene" required>
                                <option value="">Select Scene</option>
                                @foreach ($safaries as $safari_name => $animals)
                                    <option value="{{ $safari_name }}">{{ $safari_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_animal_type">Select Animal</label>
                            <select class="form-control" name="animal_type" id="edit_animal_type" required>
                                <option value="">Select Animal</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_language">Select Language</label>
                            <select class="form-control" name="language" id="edit_language" required>
                                <option value="">Select Language</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="mb-3">
                            <label>Current Language Audio</label>
                            <audio id="current_ln_audio_preview" controls>
                                <source src="{{ asset('LanguageAudio') }}/{{ $video->ln_audio }}" id="current_ln_audio">
                                Your browser does not support the Language Audio tag.
                            </audio>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ln_audio" class="form-label">Replace Language Audio</label>
                            <input type="file" class="form-control" id="edit_ln_audio" name="ln_audio"
                                accept="audio/*">
                            <small class="form-text text-muted">Leave blank to keep the existing Language Audio.</small>
                        </div>

                        <div class="mb-3">
                            <label>Current Scene Audio</label><br>
                            <audio id="current_scene_audio_preview" controls>
                                <source src="{{ asset('SceneAudio') }}/{{ $video->sceneAudio->audioFile }}"
                                    id="current_scene_audio">
                                Your browser does not support the Scene Audio tag.
                            </audio>
                        </div>

                        <div class="mb-3">
                            <label for="edit_scene_audio" class="form-label">Replace Scene Audio</label>
                            <select class="form-control" name="scene_audio" id="edit_scene_audio">
                                <option value="">Select Scene Audio</option>
                                @foreach ($SceneAudios as $SceneAudio)
                                    <option value="{{ $SceneAudio->id }}">{{ $SceneAudio->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-3">
                            <label>Current Video</label>
                            <video id="current_video_preview" width="100%" height="240" controls>
                                <source src="" id="current_video_source">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <div class="mb-3">
                            <label for="edit_video_link" class="form-label">Replace Video</label>
                            <input type="file" class="form-control" id="edit_video_link" name="video_link"
                                accept="video/*">
                            <small class="form-text text-muted">Leave blank to keep the existing video.</small>
                        </div>


                        <input type="hidden" id="video_id" name="video_id">
                        <button type="submit" class="btn btn-primary">Update Video</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Create Modal-->
    <script>
        $(document).ready(function() {
            // Validate the form on submit
            $('#createVideoFormsdf').validate({
                rules: {
                    scene: {
                        required: true
                    },
                    animal_type: {
                        required: true
                    },
                    language: {
                        required: true
                    },
                    video_link: {
                        required: true
                    },
                    ln_audio: {
                        required: true
                    },
                    scene_audio: {
                        required: true
                    },
                },
                messages: {
                    scene: {
                        required: 'Please select a scene.'
                    },
                    animal_type: {
                        required: 'Please select an animal type.'
                    },
                    language: {
                        required: 'Please select a language.'
                    },
                    video_link: {
                        required: 'Please upload a video.'
                    },
                    ln_audio: {
                        required: 'Please upload a language audio.'
                    },
                    scene_audio: {
                        required: 'Please select a scene audio.'
                    },
                },
                // On form submit, if the form is valid, submit via AJAX
                submitHandler: function(form) {
                    $('#preloader').show();
                    const formData = new FormData(form);
                    $.ajax({
                        url: '{{ route('animal.videos.create') }}',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function() {
                            $('#preloader').hide();
                            Swal.fire('Success', 'Video added successfully!', 'success');
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            $('#preloader').hide();
                            let errorMessage = 'An error occurred. Please try again.';
                            if (xhr.status === 500) {
                                errorMessage = 'Server error. Please try again later.';
                            }
                            Swal.fire('Error', errorMessage, 'error');
                        }
                    });
                }
            });

            // Open Create Modal
            $('.btn.btn-primary.float-left').click(function() {
                $("label.error").hide(); // Hide any previous validation errors
                $('#createVideoFormsdf')[0].reset(); // Reset form fields
                $('#createModal').modal('show'); // Show the modal
            });
        });
    </script>

    <!-- Edit Modal  -->
    <script type="text/javascript">
        $(document).ready(function() {
            const baseUrl = '{{ url('admin') }}';

            // Open Edit Modal
            $(document).on('click', '.edit-video', function() {
                const videoId = $(this).data('id');
                const editUrl = `${baseUrl}/animal-videos-edit/${videoId}`;

                // Reset all fields before loading new data
                $('#editVideoForm')[0].reset();
                $('#current_video_source').attr('src', '');
                $('#current_ln_audio').attr('src', '');
                $('#current_scene_audio').attr('src', '');
                $('#edit_scene_audio').val('');
                $('#edit_animal_type').empty().append('<option value="">Select Animal</option>');
                $('#edit_scene').val('');
                $('#edit_language').val('');
                $("label.error").hide(); // Clear validation errors

                $.ajax({
                    url: editUrl,
                    type: 'GET',
                    success: function(response) {
                        $('#edit_scene').val(response.scene_name).trigger('change');
                        $('#edit_animal_type').val(response.animal_type);
                        $('#edit_language').val(response.language);
                        $('#edit_scene_audio').val(response.scene_audio_id);
                        $('#video_id').val(response.id);

                        const sceneAudioUrl =
                            `{{ asset('SceneAudio') }}/${response.scene_audio_file}`;
                        $('#current_scene_audio').attr('src', sceneAudioUrl);
                        $('#current_scene_audio_preview')[0].load();



                        const videoUrl = `{{ asset('AnimalVideos') }}/${response.video_link}`;
                        $('#current_video_source').attr('src', videoUrl);
                        $('#current_video_preview')[0].load();

                        const lnAudioUrl = `{{ asset('LanguageAudio') }}/${response.ln_audio}`;
                        $('#current_ln_audio').attr('src', lnAudioUrl);
                        $('#current_ln_audio_preview')[0].load();

                        $('#editModal').modal('show');
                    },
                    error: function() {
                        Swal.fire('Error', 'Unable to fetch video details.', 'error');
                    },
                });
            });

            // jQuery Validation Setup
            $('#editVideoForm').validate({
                rules: {
                    scene: {
                        required: true,
                    },
                    animal_type: {
                        required: true,
                    },
                    language: {
                        required: true,
                    },
                    scene_audio: {
                        required: true,
                    },
                },
                messages: {
                    scene: {
                        required: 'Please select a scene.',
                    },
                    animal_type: {
                        required: 'Please select an animal.',
                    },
                    language: {
                        required: 'Please select a language.',
                    },
                    scene_audio: {
                        required: 'Please select a scene audio.',
                    },
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element); // Place validation error messages properly
                },
            });

            // Update Video
            $('#editVideoForm').on('submit', function(e) {
                e.preventDefault();

                if (!$('#editVideoForm').valid()) {
                    return; // Stop submission if form is invalid
                }

                $('#preloader').show(); // Show preloader

                const videoId = $('#video_id').val();
                const url = `${baseUrl}/animal-videos-update/${videoId}`;
                const formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function() {
                        $('#preloader').hide(); // Hide preloader

                        Swal.fire('Success', 'Video updated successfully!', 'success');
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function(jqXHR, textStatus) {
                        $('#preloader').hide(); // Hide preloader

                        if (jqXHR.status === 422) {
                            const errors = jqXHR.responseJSON.errors;
                            let errorList = '<ul>';
                            $.each(errors, function(key, value) {
                                errorList += `<li>${value[0]}</li>`;
                            });
                            errorList += '</ul>';
                            Swal.fire('Validation Error', errorList, 'error');
                        } else if (jqXHR.status === 500) {
                            Swal.fire(
                                'Server Error',
                                'An unexpected error occurred on the server. Please try again later.',
                                'error'
                            );
                        } else if (jqXHR.status === 401) {
                            Swal.fire(
                                'Unauthorized',
                                'You are not authorized to perform this action. Please log in again.',
                                'error'
                            );
                        } else if (textStatus === 'timeout' || textStatus === 'error' ||
                            textStatus === 'abort') {
                            Swal.fire(
                                'Network Error',
                                'There was an issue with the network. Please check your internet connection and try again.',
                                'error'
                            );
                        } else {
                            Swal.fire('Error', 'Failed to update video. Please try again.',
                                'error');
                        }
                    },
                });
            });
        });
    </script>

    <!-- DataTable Initialization -->
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>

    <!-- Modal and AJAX Operations -->
    <script>
        $(document).ready(function() {
            const baseUrl = '{{ url('admin') }}';

            // // Open Create Modal
            // $('.btn.btn-primary.float-left').click(function() {

            //     $("label.error").hide();
            //     $('#createVideoFormsdf')[0].reset();
            //     $('#createModal').modal('show');


            // });

            // // Create Video
            // $('#createVideoFormsdf').on('submit', function(e) {
            //     e.preventDefault();
            //     $('#preloader').show();
            //     const formData = new FormData(this);
            //     $.ajax({
            //         url: '{{ route('animal.videos.create') }}',
            //         type: 'POST',
            //         data: formData,
            //         contentType: false,
            //         processData: false,
            //         success: function() {
            //             $('#preloader').hide();
            //             Swal.fire('Success', 'Video added successfully!', 'success');
            //             setTimeout(() => location.reload(), 1500);
            //         },
            //         error: function(xhr) {
            //             $('#preloader').hide();
            //             // let errorMessage = 'An error occurred. Please try again.';
            //             if (xhr.status === 500) {
            //                 errorMessage = 'Server error. Please try again later.';
            //             }
            //             Swal.fire('Error', errorMessage, 'error');
            //         }
            //     });
            // });

            // Open Edit Modal
            // $(document).on('click', '.edit-video', function() {
            //     const videoId = $(this).data('id');
            //     const editUrl = `${baseUrl}/animal-videos-edit/${videoId}`;


            //     // Reset all fields before loading new data
            //     $('#editVideoForm')[0].reset();
            //     $('#current_video_source').attr('src', '');
            //     $('#current_ln_audio').attr('src', '');
            //     $('#current_scene_audio').attr('src', '');
            //     $('#edit_scene_audio').val('');
            //     $('#edit_animal_type').empty().append(
            //         '<option value="">Select Animal</option>'); // Reset animal dropdown
            //     $('#edit_scene').val(''); // Clear the scene dropdown
            //     $('#edit_language').val(''); // Clear the language dropdown

            //     $("label.error").hide();

            //     $.ajax({
            //         url: editUrl,
            //         type: 'GET',
            //         success: function(response) {
            //             $('#edit_scene').val(response.scene_name);

            //             $('#edit_scene').trigger('change');

            //             $('#edit_animal_type').val(response.animal_type);
            //             $('#edit_language').val(response.language);

            //             $('#edit_scene_audio').val(response.scene_audio);

            //             $('#video_id').val(response.id);

            //             const videoUrl =
            //                 `{{ asset('AnimalVideos') }}/${response.video_link}`;
            //             $('#current_video_source').attr('src', videoUrl);
            //             $('#current_video_preview')[0].load();

            //             const lnAudioUrl =
            //                 `{{ asset('LanguageAudio') }}/${response.ln_audio}`;
            //             $('#current_ln_audio').attr('src', lnAudioUrl);
            //             $('#current_ln_audio_preview')[0].load();



            //             $('#editModal').modal('show');
            //         },
            //         error: function() {
            //             Swal.fire('Error', 'Unable to fetch video details.', 'error');
            //         }
            //     });

            // });

            // // Update Video
            // $('#editVideoForm').on('submit', function(e) {
            //     e.preventDefault();
            //     $('#preloader').show();
            //     const videoId = $('#video_id').val();
            //     const url = `${baseUrl}/animal-videos-update/${videoId}`;
            //     const formData = new FormData(this);
            //     $.ajax({
            //         url: url,
            //         type: 'POST',
            //         data: formData,
            //         contentType: false,
            //         processData: false,
            //         success: function() {
            //             $('#preloader').hide();

            //             Swal.fire('Success', 'Video updated successfully!', 'success');
            //             setTimeout(() => location.reload(), 1500);
            //         },
            //         error: function(jqXHR, textStatus, errorThrown) {
            //             $('#preloader').hide();
            //             // Skip displaying validation error messages
            //             if (jqXHR.status === 400 || jqXHR.status === 422) {
            //                 console.error('Validation Error:', jqXHR.responseJSON?.errors ||
            //                     'Invalid input');
            //                 return; // Don't show Swal for validation errors
            //             }
            //             // Handle server errors (500)
            //             else if (jqXHR.status === 500) {
            //                 Swal.fire(
            //                     'Server Error',
            //                     'An unexpected error occurred on the server. Please try again later.',
            //                     'error'
            //                 );
            //             }
            //             // Handle unauthorized access (401)
            //             else if (jqXHR.status === 401) {
            //                 Swal.fire(
            //                     'Unauthorized',
            //                     'You are not authorized to perform this action. Please log in again.',
            //                     'error'
            //                 );
            //             }
            //             // Handle network or connection errors
            //             else if (textStatus === 'timeout' || textStatus === 'error' ||
            //                 textStatus === 'abort') {
            //                 Swal.fire(
            //                     'Network Error',
            //                     'There was an issue with the network. Please check your internet connection and try again.',
            //                     'error'
            //                 );
            //             }
            //             // Handle other errors
            //             else {
            //                 Swal.fire('Error', 'Failed to update video. Please try again.',
            //                     'error');
            //             }
            //         },
            //     });
            // });

            // Delete Video
            // $(document).on('click', '.delete-video', function () {
            //     const videoId = $(this).data('id');
            //     const deleteUrl = `${baseUrl}/animal-videos-delete/${videoId}`;

            //     Swal.fire({
            //         title: 'Are you sure?',
            //         text: "You won't be able to revert this!",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Yes, delete it!'
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             $.ajax({
            //                 url: deleteUrl,
            //                 type: 'DELETE',
            //                 data: {
            //                     _token: '{{ csrf_token() }}'
            //                 },
            //                 success: function () {
            //                     Swal.fire('Deleted!', 'Your video has been deleted.',
            //                         'success');
            //                     setTimeout(() => location.reload(), 1500);
            //                 },
            //                 error: function () {
            //                     Swal.fire('Error', 'Failed to delete video.', 'error');
            //                 }
            //             });
            //         }
            //     });
            // });

            $(document).on('click', '.delete-video', function() {
                const videoId = $(this).data('id');
                const deleteUrl = `${baseUrl}/animal-videos-delete/${videoId}`;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Deleted!',
                                        'Your video has been deleted.', 'success');
                                    setTimeout(() => location.reload(), 1500);
                                } else {
                                    // Display error message from response
                                    Swal.fire('Error', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error', 'Failed to delete video.', 'error');
                            }
                        });
                    }
                });
            });

        });
    </script>

    <!-- Scene Dropdown Handling -->
    <script>
        $(document).ready(function() {
            const safaries = @json($safaries);

            function handleSceneChange(sceneSelect, animalSelect) {
                const selectedScene = sceneSelect.val();
                animalSelect.empty().append('<option value="">Select Animal</option>');
                if (selectedScene && safaries[selectedScene]) {
                    $.each(safaries[selectedScene], function(index, animal) {
                        animalSelect.append(`<option value="${animal}">${animal}</option>`);
                    });
                }
            }

            $('#scene').on('change', function() {
                handleSceneChange($(this), $('#animal_type'));
            });



        });
    </script>

    <!-- Prepopulate Edit Modal Scene Dropdown -->
    <script>
        // $(document).ready(function() {
        //     const safaries = @json($safaries);
        //     const selectedScene = '{{ $video->scene_name }}';
        //     const selectedAnimal = '{{ $video->animal_type }}';

        //     $('#edit_scene').val(selectedScene).trigger('change');

        //     // Trigger when scene changes in the modal
        //     $('#edit_scene').on('change', function() {
        //         handleSceneChange($(this), $('#edit_animal_type'));
        //     });

        //     // Preload animals when the modal opens
        //     const selectedScene = $('#edit_scene').val();
        //     handleSceneChange($('#edit_scene'), $('#edit_animal_type'));

        //     $('#edit_scene').on('change', function() {
        //         const selectedScene = $(this).val();
        //         const animalSelect = $('#edit_animal_type');

        //         animalSelect.empty().append('<option value="">Select Animal</option>');
        //         if (selectedScene && safaries[selectedScene]) {
        //             $.each(safaries[selectedScene], function(index, animal) {
        //                 animalSelect.append(
        //                     `<option value="${animal}" ${animal === selectedAnimal ? 'selected' : ''}>${animal}</option>`
        //                 );
        //             });
        //         }
        //     });

        //     $('#edit_scene').trigger('change');
        // });

        $(document).ready(function() {
            const safaries = @json($safaries);
            let selectedAnimal = '';

            function populateAnimalDropdown(scene, animalSelect, preselectedAnimal = '') {
                animalSelect.empty().append('<option value="">Select Animal</option>');
                if (scene && safaries[scene]) {
                    $.each(safaries[scene], function(index, animal) {
                        animalSelect.append(
                            `<option value="${animal}" ${animal === preselectedAnimal ? 'selected' : ''}>${animal}</option>`
                        );
                    });
                }
            }

            // Trigger when scene changes
            $('#edit_scene').on('change', function() {
                const selectedScene = $(this).val();
                const animalSelect = $('#edit_animal_type');
                populateAnimalDropdown(selectedScene, animalSelect, selectedAnimal);
            });

            // Preload animals when modal opens
            $(document).on('click', '.edit-video', function() {
                const videoId = $(this).data('id');
                selectedAnimal = ''; // Reset before new data
                $('#edit_scene').trigger('change');
            });
        });
    </script>

    <div class="d-flex justify-content-center">
        {{ $videos->links('pagination::bootstrap-4') }}
    </div>

@endsection
