@extends ('admin.index')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('title', 'User-List')

<style>
    label.error {
        color: red;
        /* animation: fadeOut 5s forwards; */
    }

    .form-valid-error {
        color: red;

    }

    /* @keyframes fadeOut {
        0% {
            opacity: 1;
        }

        100% {
            opacity: 0;
            visibility: hidden;
        } */
    /* } */
</style>

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">All Users</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
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
                    <div class="card-header">
                        <button type="button" id="user_add_btn" class="btn btn-primary float-left" data-toggle="modal"
                            data-target="#user_modal">
                            Add User
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    {{-- <th>Profile Image</th> --}}
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>DOB</th>
                                    <th>Class</th>
                                    <th>Language</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allUsers as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($user->full_name) }}</td>
                                        <td>{{ $user->phone }}</td>

                                        <td>{{ $user->dob }}</td>
                                        <td>
                                            @if ($user->class == 1)
                                                1st
                                            @elseif ($user->class == 2)
                                                2nd
                                            @elseif ($user->class == 3)
                                                3rd
                                            @elseif ($user->class == 4)
                                                4th
                                            @elseif ($user->class == 5)
                                                5th
                                            @elseif ($user->class == 6)
                                                6th
                                            @elseif ($user->class == 7)
                                                7th
                                            @elseif ($user->class == 8)
                                                8th
                                            @elseif ($user->class == 9)
                                                9th
                                            @elseif ($user->class == 10)
                                                10th
                                            @else
                                                {{$user->class}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($user->languages->name))
                                                {{ $user->languages->name }}
                                            @endif
                                        </td>
                                        <td>
                                            {{-- <a href="" id="edit_user_btn" data-status="{{ $user->status }}"
                                                data-full_name="{{ $user->full_name }}" data-email="{{ $user->email }}"
                                                data-phone="{{ $user->phone }}" data-id="{{ $user->id }}"
                                                data-profile_image="{{ $user->profile_image }}"
                                                data-class="{{ $user->class }}" data-dob="{{ $user->dob }}"
                                                class="btn btn-warning btn-sm edit_user_btn">Edit</a> --}}

                                            <a href="javascript:void(0)" class="btn btn-warning btn-sm edit_user_btns"
                                                data-id="{{ $user->id }}" data-full_name="{{ $user->full_name }}"
                                                data-phone="{{ $user->phone }}" data-dob="{{ $user->dob }}"
                                                data-class="{{ $user->class }}" data-language="{{ $user->language }}">
                                                Edit
                                            </a>


                                            {{-- <a href="{{ route('user.delete', $user->id) }}"
                                                class="btn btn-danger btn-sm deleteUser">Delete</a> --}}

                                            <button class="btn btn-danger btn-sm deleteUser"
                                                data-id="{{ $user->id }}">Delete</button>

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

<!--Add Modal -->
<div class="modal fade" id="user_modal" tabindex="-1" role="dialog" aria-labelledby="user_modalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title user_modal_title" id="user_modal_title">Add user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_user_form" method="POST" action="javascript:void(0)">
                    {{-- @csrf --}}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="full_name">Name</label>
                            <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Name">
                            <label class="form-valid-error" id="error-full_name"></label>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number">
                            <label class="form-valid-error" id="error-phone"></label>
                        </div>

                        <div class="form-group">
                            <label for="dob">Dob</label>
                            <input type="date" name="dob" class="form-control" id="dob" max="{{ date('Y-m-d') }}">
                            <label class="form-valid-error" id="error-dob"></label>
                        </div>

                        <div class="form-group">
                            <label for="class">Class</label>
                            <select class="form-control" name="class" id="class">
                                <option value="">Select Class</option>
                                <option value="1">1st</option>
                                <option value="2">2nd</option>
                                <option value="3">3rd</option>
                                <option value="4">4th</option>
                                <option value="5">5th</option>
                                <option value="6">6th</option>
                                <option value="7">7th</option>
                                <option value="8">8th</option>
                                <option value="9">9th</option>
                                <option value="10">10th</option>
                                <!-- <option value="11">11th</option>
                                    <option value="12">12th</option> -->
                            </select>
                            <label class="form-valid-error" id="error-class"></label>
                        </div>

                        <div class="form-group">
                            <label for="language">Language</label>
                            <select class="form-control" name="language" id="language">
                                <option value="">Select Langauage</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                                {{-- <option value="Cs">Cs</option>
                                <option value="Da">Da</option>
                                <option value="De">De</option>
                                <option value="En">En</option>
                                <option value="En-AU">En-AU</option>
                                <option value="En-Gb">En-Gb</option>
                                <option value="Es">Es</option>
                                <option value="fi">Fi</option>
                                <option value="Fr">Fr</option>
                                <option value="He">He</option>
                                <option value="Hi">Hi</option>
                                <option value="It">It</option>
                                <option value="Ja">Ja</option>
                                <option value="Nb">Nb</option>
                                <option value="Nl">Nl</option>
                                <option value="Ru">Ru</option>
                                <option value="Sv">Sv</option>
                                <option value="Zh-Hans">Zh-Hans</option> --}}
                            </select>
                            <label class="form-valid-error" id="error-language"></label>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" id="user_submit_btn" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- update modal --}}
<div class="modal fade" id="edit_user_modal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_user_form">
                    @csrf
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <div class="form-group">
                        <label for="edit_full_name">Name</label>
                        <input type="text" name="full_name" class="form-control" id="edit_full_name" placeholder="Name">
                        <label class="form-valid-error" id="error-full_name"></label>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone">Phone Number</label>
                        <input type="text" name="phone" class="form-control" id="edit_phone" placeholder="Phone Number"
                            readonly>
                        <label class="form-valid-error" id="error-phone"></label>
                    </div>
                    <div class="form-group">
                        <label for="edit_dob">DOB</label>
                        <input type="date" name="dob" class="form-control" id="edit_dob"
                            max="<?php echo date('Y-m-d'); ?>">
                        <label class="form-valid-error" id="error-dob"></label>
                    </div>
                    <div class="form-group">
                        <label for="edit_class">Class</label>
                        <select name="class" class="form-control" id="edit_class">
                            <option value="">Select Class</option>
                            <option value="1">1st</option>
                            <option value="2">2nd</option>
                            <option value="3">3rd</option>
                            <option value="4">4th</option>
                            <option value="5">5th</option>
                            <option value="6">6th</option>
                            <option value="7">7th</option>
                            <option value="8">8th</option>
                            <option value="9">9th</option>
                            <option value="10">10th</option>
                            <!-- <option value="11">11th</option>
                                <option value="12">12th</option> -->
                        </select>
                        <label class="form-valid-error" id="error-class"></label>
                    </div>

                    <div class="form-group">
                        <label for="edit_language">Language</label>
                        <select class="form-control" name="language" id="edit_language">
                            <option value="">Select Langauage</option>
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                            {{-- <option value="Ar">Ar</option>
                            <option value="Cs">Cs</option>
                            <option value="Da">Da</option>
                            <option value="De">De</option>
                            <option value="En">En</option>
                            <option value="En-AU">En-AU</option>
                            <option value="En-Gb">En-Gb</option>
                            <option value="Es">Es</option>
                            <option value="fi">Fi</option>
                            <option value="Fr">Fr</option>
                            <option value="He">He</option>
                            <option value="Hi">Hi</option>
                            <option value="It">It</option>
                            <option value="Ja">Ja</option>
                            <option value="Nb">Nb</option>
                            <option value="Nl">Nl</option>
                            <option value="Ru">Ru</option>
                            <option value="Sv">Sv</option>
                            <option value="Zh-Hans">Zh-Hans</option> --}}
                        </select>
                        <label class="form-valid-error" id="error-language"></label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" id="save_user_btn" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

{{-- End udpate modal --}}


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>


<script>
    $(document).ready(function () {
        $.validator.addMethod("maxDate", function (value, element) {
            const today = new Date();
            const inputDate = new Date(value);
            return this.optional(element) || inputDate <= today;
        }, "The date must be today or earlier.");

        $.validator.addMethod("validPhone", function (value, element) {
            return this.optional(element) || /^[0-9]{10,15}$/.test(value);
        }, "Please enter a valid phone number");

        // $.validator.addMethod("notNumber", function(value, element) {
        //     return this.optional(element) || isNaN(value);
        // }, "Please select a valid language (numbers are not allowed).");

        // Add custom validation for valid phone number
        $.validator.addMethod("validFullName", function (value, element) {
            return this.optional(element) || /^(?!^\d+$)[A-Za-z0-9\s]+$/.test(value);
        }, "Name may contain numbers and alphabets mixed, but cannot be only numbers.");

        $("#add_user_form").validate({

            rules: {
                full_name: {
                    required: true,
                    minlength: 3,
                    validFullName: true
                },
                phone: {
                    required: true,
                    validPhone: true,
                },
                dob: {
                    required: true,
                    maxDate: true
                },
                class: {
                    required: true
                },
                language: {
                    required: true,
                    // notNumber: true
                }
            },
            messages: {
                full_name: {
                    required: "Please enter your name",
                    minlength: "Your name must be at least 3 characters long"
                },
                phone: {
                    required: "Please enter afdsa phone number",
                    validPhone: "Phone number must be exactly 10 to 15 digits only",
                },
                dob: {
                    required: "Please select your date of birth",
                    // maxDate: "The date must be today or earlier."
                },
                class: {
                    required: "Please select a class"
                },
                language: {
                    required: "Please select a Language",
                    // notNumber: "Please select a valid language (numbers are not allowed)."
                }
            },
            submitHandler: function (form) {
                let formData = $(form).serialize();

                // alert(formData);
                $.ajax({
                    url: '{{ route('user.store') }}',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            var message = response.message;
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                            // function reloadPage() {
                            //     location.reload();
                            // }
                            // setTimeout(reloadPage, 1500);
                            // alert(response.message);
                            // Clear form after success
                            $('#add_user_form')[0].reset();
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Clear previous errors
                            $('.form-valid-error').html('');

                            // Display new errors
                            $.each(errors, function (key, value) {
                                $(`#error-${key}`).html(value[0]);
                            });
                        } else {
                            Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                        }
                    }
                });

                // alert("ok");

            }
        });
    });
</script>


<script>
    $(document).ready(function () {
        // Show edit modal and populate fields
        $(document).on('click', '.edit_user_btns', function () {
            let userId = $(this).data('id');
            let fullName = $(this).data('full_name');
            let phone = $(this).data('phone');
            let dob = $(this).data('dob');
            let userClass = $(this).data('class');
            let language = $(this).data('language');

            // Populate modal fields with data
            $('#edit_user_id').val(userId);
            $('#edit_full_name').val(fullName);
            $('#edit_phone').val(phone);
            $('#edit_dob').val(dob);
            $('#edit_class').val(userClass);
            $('#edit_language').val(language);

            $('#edit_user_modal').modal('show');
        });

        // Add custom validation for maxDate
        $.validator.addMethod("maxDate", function (value, element) {
            const today = new Date();
            const inputDate = new Date(value);
            return this.optional(element) || inputDate <= today;
        }, "The date must be today or earlier.");

        // Add custom validation for valid phone number
        $.validator.addMethod("validPhone", function (value, element) {
            return this.optional(element) || /^[0-9]{10,15}$/.test(value);
        }, "Please enter a valid phone number");

        // Add custom validation for valid phone number
        $.validator.addMethod("validFullName", function (value, element) {
            return this.optional(element) || /^(?!^\d+$)[A-Za-z0-9\s]+$/.test(value);
        }, "Name may contain numbers and alphabets mixed, but cannot be only numbers.");

        // Initialize validation for the edit form
        $("#edit_user_form").validate({
            rules: {
                full_name: {
                    required: true,
                    minlength: 3,
                    validFullName: true
                },
                phone: {
                    required: true,
                    validPhone: true,
                },
                dob: {
                    required: true,
                    maxDate: true,
                },
                class: {
                    required: true,
                },
                language: {
                    required: true,
                },
            },
            messages: {
                full_name: {
                    required: "Please enter the user's name",
                    minlength: "Name must be at least 3 characters long",
                },
                phone: {
                    required: "Please enter the user's phone number",
                    validPhone: "Phone number must be exactly 10 to 15 digits only",
                },
                dob: {
                    required: "Please enter the date of birth",
                    maxDate: "The date must not be in the future",
                },
                class: {
                    required: "Please select a class",
                },
                language: {
                    required: "Please select a language",
                },
            },
            submitHandler: function (form) {
                let formData = $(form).serialize();
                let userId = $('#edit_user_id').val();

                $.ajax({
                    url: 'user-update/' + userId,
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            $('#edit_user_modal').modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Clear previous errors
                            $('.form-valid-error').html('');

                            // Display validation errors
                            $.each(errors, function (key, value) {
                                $(`#error-${key}`).html(value[0]);
                            });
                        } else {
                            Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                        }
                    },
                });
            },
        });

        // Trigger form submission
        $('#save_user_btn').click(function () {
            $('#edit_user_form').submit(); // Triggers validation and AJAX submission
        });
    });
</script>


<script>
    $(document).ready(function () {
        $(".deleteUser").click(function () {
            var userId = $(this).data("id");
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
                        url: 'user-delete/' + userId,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "User has been deleted.",
                                    icon: "success"
                                });
                                // $('button[data-id="' + userId + '"]').closest('tr')
                                //     .remove();
                                function pageReload() {
                                    location.reload();
                                }
                                setTimeout(pageReload, 1500);

                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                title: "Error",
                                text: "There was an issue deleting the user.",
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
    function previewImage(event, previewId) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById(previewId);
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<script>
    $(document).ready(function () {
        var table = $('#datatable').DataTable();
    });
</script>

@endsection