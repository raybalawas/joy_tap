@extends('admin.index')
@section('title', 'Language-List')
<style>
    label.error {
        color: red;
    }
</style>
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Language</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Language</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary float-left" data-toggle="modal"
                            data-target="#language_modal">
                            Add Language
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Language</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($languages as $key => $language)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $language->name }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm edit_language_btn"
                                            data-id="{{ $language->id }}" data-name="{{ $language->name }}">
                                            Edit
                                        </button>
                                        <!-- <form action="{{ route('language.destroy', $language->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE') -->
                                        <button type="submit" class="btn btn-danger btn-sm deleteLanguage"
                                            data-id="{{$language->id}}">Delete</button>
                                        <!-- </form> -->
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


<!-- Add Langauge Modal -->
<div class="modal fade" id="language_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Language</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_language_form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Language Name">
                            @error('name')
                            <span>{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Edit Language Modal -->
<div class="modal fade" id="edit_language_modal" tabindex="-1" role="dialog" aria-labelledby="editLanguageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLanguageModalLabel">Edit Language</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_language_form">
                @csrf
                <input type="hidden" name="language_id" id="edit_language_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" name="name" class="form-control" id="edit_name" placeholder="Language Name">
                        <!-- <span id="edit_name_error" class="text-danger"></span> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<!-- update language -->
<script>
    $(document).ready(function () {
        $('#edit_language_modal').on('hide.bs.modal', function () {
            $('#edit_language_form')[0].reset(); // Clear the form
            $('#edit_language_form').validate().resetForm(); // Reset validation messages
        });

        // Show edit modal and populate fields
        $(document).on('click', '.edit_language_btn', function () {
            let languageId = $(this).data('id');
            let Name = $(this).data('name');
            $('#edit_language_id').val(languageId);
            $('#edit_name').val(Name);
            $('#edit_language_modal').modal('show');
        });

        $.validator.addMethod("noNumbers", function (value, element) {
            return this.optional(element) || /^[A-Za-z\s]+$/.test(value); // Only letters and spaces allowed
        }, "Please enter a valid language name (letters and spaces only)");

        $("#edit_language_form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    noNumbers: true
                }
            },
            messages: {
                name: {
                    required: "Language Field is required",
                    minlength: "Name must be at least 3 characters long",
                    noNumbers: "Please enter a valid language name (letters and spaces only)"
                }
            },
            submitHandler: function (form) {
                // preventDefault(form);
                let formData = $(form).serialize();
                let languageId = $('#edit_language_id').val();

                $.ajax({
                    url: 'languages/' + languageId,
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        // if (response.status) {
                        var msg = response.message;
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // alert(response.message);
                        $('#edit_language_modal').modal('hide');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                        // } else {
                        //     alert('Error: ' + response.message);
                        // }
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            let errorMessages = Object.values(errors).map(err => err
                                .join(', ')).join('\n');
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Errors',
                                text: errorMessages,  // Show errors in the SweetAlert
                                confirmButtonText: 'Ok'
                            });
                        }
                    }
                });
            }
        });

        // Trigger form submission
        $('#edit_language_btn').click(function () {
            $('#edit_language_form').submit(); // Triggers validation and AJAX submission
        });
    });
</script>


<!-- create language -->
<script>
    $(document).ready(function () {
        // Reset form when modal opens
        $('#language_modal').on('shown.bs.modal', function () {
            $('#add_language_form')[0].reset(); // Clear the form
            $('#add_language_form').validate().resetForm(); // Reset validation messages
        });

        $('#language_modal').on('hide.bs.modal', function () {
            $('#add_language_form')[0].reset(); // Clear the form
            $('#add_language_form').validate().resetForm(); // Reset validation messages
        });


        $.validator.addMethod("noNumbers", function (value, element) {
            return this.optional(element) || /^[A-Za-z\s]+$/.test(value); // Only letters and spaces allowed
        }, "Please enter a valid language name (letters and spaces only)");


        $("#add_language_form").validate({

            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    noNumbers: true
                }
            },
            messages: {
                name: {
                    required: "Language Field is required",
                    minlength: "Language Field must be at least 3 characters long",
                    noNumbers: "Please enter a valid language name (letters and spaces only)"
                }
            },
            submitHandler: function (form) {
                let formData = $(form).serialize();

                // alert(formData);
                $.ajax({
                    url: '{{ route('language.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                        $('#add_language_form')[0].reset();
                    },
                    error: function (xhr) {
                        // In case of validation error, show alert with error message
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            let errorMessages = Object.values(errors).map(err => err.join(', ')).join('\n');
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Errors',
                                text: errorMessages,  // Show errors in the SweetAlert
                                confirmButtonText: 'Ok'
                            });
                        }
                    }
                });

                // alert("ok");

            }
        });
    });
</script>

<!-- delete language -->

<script>
    $(document).ready(function () {
        $(".deleteLanguage").click(function () {
            var languageId = $(this).data("id");
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
                    $.ajax({
                        url: 'languages/' + languageId,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === false) {
                                // If the deletion is not allowed
                                Swal.fire({
                                    title: "Error",
                                    text: response.message,
                                    icon: "error"
                                });
                            } else {
                                // If the deletion is successful
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success"
                                });
                                // Reload the page after 1.5 seconds to reflect the changes
                                setTimeout(function () {
                                    location.reload();
                                }, 1500);
                            }
                        },
                        error: function () {
                            Swal.fire({
                                title: "Error",
                                text: "There was an issue deleting the language.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        var table = $('#datatable').DataTable();
    });
</script>
@endsection