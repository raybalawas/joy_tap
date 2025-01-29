$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //--------------------------------Jquery custome validation------------------------

    $.validator.addMethod("customEmailValidation", function (value, element) {
        return /\S+@\S+\.\S+/.test(value);
    }, "Please enter a valid email address");
    $.validator.addMethod("noSpaces", function (value, element) {
        return value.trim().length > 0;
    }, "This field cannot be empty.");

    var res;
    $.validator.addMethod('email_existence', function (value, element) {
        var urlss = base_url + '/admin/check-email';
        $.ajax({
            url: urlss,
            method: 'POST',
            data: { email: value },
            async: false,
            success: function (response) {
                if (response.status == 'success') {
                    res = true;
                } else {
                    res = false;
                }
            }
        });
        return res;
    }, 'Email is already taken.');

    $.validator.addMethod('current_password', function (value, element) {
        var urlss = base_url + '/admin/check-current-password';
        $.ajax({
            url: urlss,
            method: 'POST',
            data: { current_password: value },
            async: false,
            success: function (response) {
                if (response.status == 'success') {
                    res = true;
                } else {
                    res = false;
                }
            }
        });
        return res;
    }, 'Current password not match');

    $.validator.addMethod('brand_name_existence', function (value, element) {
        var urlss = base_url + '/admin/check-brand-name';
        $.ajax({
            url: urlss,
            method: 'POST',
            data: { brand_name: value },
            async: false,
            success: function (response) {
                if (response.status == 'success') {
                    res = true;
                } else {
                    res = false;
                }
            }
        });
        return res;
    }, 'Brand name is already taken.');

    //active-inactive status of users
    $(document).on('click', '.user_status', function (event) {
        event.preventDefault(event)
        var urlss = base_url + '/admin/user-status-change';
        var status = $(this).data('status');
        var user_id = $(this).data('user_id');
        var button = $(this);
        $.ajax({
            url: urlss,
            method: 'post',
            data: { status: status, user_id: user_id },
            success: function (response) {
                if (response.status == 'success') {
                    if (response.user_status == 'active') {
                        button.removeClass('btn-danger').addClass('btn-success');
                    }
                    else {
                        button.removeClass('btn-success').addClass('btn-danger');
                    }
                    button.text(response.user_status);
                    toastr.success(response.message, "Success", {
                        closeButton: true,
                        progressBar: true
                    });
                } else {
                    toastr.error(response.message, "Error", {
                        closeButton: true,
                        progressBar: true
                    });

                }
            },
            error: function (response) {
                console.log(response);
            }
        });

    });
    //active-inactive status of post
    $(document).on('click', '.post_status', function (event) {
        event.preventDefault(event)
        var urlss = base_url + '/admin/post-status-change';
        var status = $(this).data('status');
        var post_id = $(this).data('post_id');
        var button = $(this);
        $.ajax({
            url: urlss,
            method: 'post',
            data: { status: status, post_id: post_id },
            success: function (response) {
                if (response.status == 'success') {
                    if (response.post_status == 'active') {
                        button.removeClass('btn-danger').addClass('btn-success');
                    }
                    else {
                        button.removeClass('btn-success').addClass('btn-danger');
                    }
                    button.text(response.post_status);
                    toastr.success(response.message, "Success", {
                        closeButton: true,
                        progressBar: true
                    });
                } else {
                    toastr.error(response.message, "Error", {
                        closeButton: true,
                        progressBar: true
                    });

                }
            },
            error: function (response) {
                console.log(response);
            }
        });

    });
    //active-inactive status of vertical
    $(document).on('click', '.vertical_status', function (event) {
        event.preventDefault(event)
        var urlss = base_url + '/admin/vertical-status-change';
        var status = $(this).data('status');
        var vertical_id = $(this).data('vertical_id');
        var button = $(this);
        $.ajax({
            url: urlss,
            method: 'post',
            data: { status: status, vertical_id: vertical_id },
            success: function (response) {
                if (response.status == 'success') {
                    if (response.vertical_status == 'active') {
                        button.removeClass('btn-danger').addClass('btn-success');
                    }
                    else {
                        button.removeClass('btn-success').addClass('btn-danger');
                    }
                    button.text(response.vertical_status);
                    toastr.success(response.message, "Success", {
                        closeButton: true,
                        progressBar: true
                    });
                } else {
                    toastr.error(response.message, "Error", {
                        closeButton: true,
                        progressBar: true
                    });

                }
            },
            error: function (response) {
                console.log(response);
            }
        });

    });

    //select multiple options
    $('.select_destinations').select2(
        {
            placeholder: 'Select multiple destinations',
            allowClear: true
        }
    );
    $('.select_verticals').select2(
        {
            placeholder: 'Select multiple verticals',
            allowClear: true
        }
    );


    //--------------------------------on edit button click------------------------
    $(document).on('click', '.edit_user_btn', function (event) {
        
        event.preventDefault(event)
        
        var id = $(this).data('id');
        var full_name = $(this).data('full_name');
        var email = $(this).data('email');
        var dob = $(this).data('dob');
        var userClass = $(this).data('class');
        alert(dob);
        // var profile_image = $(this).data('profile_image');
        // var phone = $(this).data('phone');
        // var status = $(this).data('status');

        $('#user_modal').modal('show');
        $('#user_modal').find('form').attr("id", "edit_user_form");
        $('#user_modal').find('form').attr("action", base_url + '/admin/user-update');
        // $('#user_modal #image_preview').attr('src', profile_image);
        // $('#user_modal #image_preview').show();
        // $('#user_modal #status').val(status);
        // $('#user_modal #phone').val(phone);
        $('#user_modal #full_name').val(full_name);
        $('#user_modal #email').val(email);
        $('#user_modal #dob').val(dob);
        $('#user_modal $class').val(userClass);

        $('#user_modal #user_modal_title').text("Edit user");
        $('#user_modal .password_div').hide();
        $('#user_modal #user_submit_btn').text("Update");
        var user_id = '<input type="hidden" name="user_id" value=' + id + ' class="user_id">';
        $("#full_name").after(user_id);

    });




    //------------------------------On model hide------------------------
    $('.modal').on('hidden.bs.modal', function () {


        if ($(this).find('form').attr("id") == 'add_hangout_form' || $(this).find('form').attr("id") == 'edit_hangout_form') {

            $(this).find('form').attr("id", "add_hangout_form");
            $(this).find('form').attr("action", base_url + '/admin/add-hangout');
            $('.hangout_id').remove();
            var form = $('#add_hangout_form');
            form.validate().resetForm();
            $(this).find('form').trigger('reset');
            form.find('.error').removeClass('error');
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.is-valid').removeClass('is-valid');

            $('#plan_modal #plan_model_title').text("Add plan");
            $('#plan_modal #plan_submit_btn').text("Submit");

        }
        else
            if ($(this).find('form').attr("id") == 'add_post_form' || $(this).find('form').attr("id") == 'edit_post_form') {

                $(this).find('form').attr("id", "add_post_form");
                $(this).find('form').attr("action", base_url + '/admin/add-post');
                $('.post_id').remove();
                var form = $('#add_post_form');
                form.validate().resetForm();
                $(this).find('form').trigger('reset');
                form.find('.error').removeClass('error');
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.is-valid').removeClass('is-valid');

                $('#post_modal #post_model_title').text("Add post");
                $('#post_modal #post_submit_btn').text("Submit");
            }
            else
                if ($(this).find('form').attr("id") == 'add_plan_form' || $(this).find('form').attr("id") == 'edit_plan_form') {

                    $(this).find('form').attr("id", "add_plan_form");
                    $(this).find('form').attr("action", base_url + '/admin/add-plan');
                    $('.plan_id').remove();
                    var form = $('#add_plan_form');
                    form.validate().resetForm();
                    $(this).find('form').trigger('reset');
                    form.find('.error').removeClass('error');
                    form.find('.is-invalid').removeClass('is-invalid');
                    form.find('.is-valid').removeClass('is-valid');

                    $('#plan_modal #plan_model_title').text("Add plan");
                    $('#plan_modal #plan_submit_btn').text("Submit");
                    $('#plan_modal #imgPreview').attr('src', '').hide();

                    $('#destinations').val([]).trigger('change');
                    $('#vertical').val().trigger('change');
                }
            else
                if ($(this).find('form').attr("id") == 'add_group_form' || $(this).find('form').attr("id") == 'edit_group_form') {

                    $(this).find('form').attr("id", "add_group_form");
                    $(this).find('form').attr("action", base_url + '/admin/edit-group');
                    $('.group_id').remove();
                    var form = $('#add_group_form');
                    form.validate().resetForm();
                    $(this).find('form').trigger('reset');
                    form.find('.error').removeClass('error');
                    form.find('.is-invalid').removeClass('is-invalid');
                    form.find('.is-valid').removeClass('is-valid');

                    $('#group_modal #group_model_title').text("Add Group");
                    $('#group_modal #group_submit_btn').text("Submit");
                    $('#group_modal #imgPreview').attr('src', '').hide();
                }
                else
                    if ($(this).find('form').attr("id") == 'vertical_store' || $(this).find('form').attr("id") == 'edit_verticale') {

                        $(this).find('form').attr("id", "vertical_store");
                        $(this).find('form').attr("action", base_url + '/admin/vertical-store');
                        $('.vertical_id').remove();
                        var form = $('#vertical_store');
                        form.validate().resetForm();
                        $(this).find('form').trigger('reset');
                        form.find('.error').removeClass('error');
                        form.find('.is-invalid').removeClass('is-invalid');
                        form.find('.is-valid').removeClass('is-valid');
                        $('#vertical_modal #imgPreview').attr('src', '').hide();

                        $('#vertical_modal #vertical_modal_title').text("Add vertical");
                        $('#vertical_modal #vertical_submit_btn').text("Submit");

                    }
                    else
                        if ($(this).find('form').attr("id") == 'category_store' || $(this).find('form').attr("id") == 'edit_category') {

                            $(this).find('form').attr("id", "category_store");
                            $(this).find('form').attr("action", base_url + '/admin/category-store');
                            $('.category_id').remove();
                            var form = $('#category_store');
                            form.validate().resetForm();
                            $(this).find('form').trigger('reset');
                            form.find('.error').removeClass('error');
                            form.find('.is-invalid').removeClass('is-invalid');
                            form.find('.is-valid').removeClass('is-valid');
                            $('#category_modal #imgPreview').attr('src', '').hide();

                            $('#category_modal #category_modal_title').text("Add category");
                            $('#category_modal #category_submit_btn').text("Submit");

                        }
                        else
                            if ($(this).find('form').attr("id") == 'group_store' || $(this).find('form').attr("id") == 'edit_group') {

                                $(this).find('form').attr("id", "group_store");
                                $(this).find('form').attr("action", base_url + '/admin/group-store');
                                $('.group_id').remove();
                                var form = $('#group_store');
                                form.validate().resetForm();
                                $(this).find('form').trigger('reset');
                                form.find('.error').removeClass('error');
                                form.find('.is-invalid').removeClass('is-invalid');
                                form.find('.is-valid').removeClass('is-valid');
                                $('#group_modal #imgPreview').attr('src', '').hide();

                                $('#group_modal #group_modal_title').text("Add group");
                                $('#group_modal #group_submit_btn').text("Submit");

                            }
                            else
                                if ($(this).find('form').attr("id") == 'add_user_form' || $(this).find('form').attr("id") == 'edit_user_form') {

                                    $(this).find('form').attr("id", "add_user_form");
                                    $(this).find('form').attr("action", base_url + '/admin/user-store');
                                    $('.user_id').remove();
                                    var form = $('#add_user_form');
                                    form.validate().resetForm();
                                    $(this).find('form').trigger('reset');
                                    form.find('.error').removeClass('error');
                                    form.find('.text-danger').remove();
                                    form.find('.is-invalid').removeClass('is-invalid');
                                    form.find('.is-valid').removeClass('is-valid');
                                    $('#user_modal .password_div').show();
                                    $('#user_modal #user_modal_title').text("Add brand");
                                    $('#user_modal #user_submit_btn').text("Submit");

                                }
                                else
                                    if ($(this).find('form').attr("id") == 'add_creator_form' || $(this).find('form').attr("id") == 'edit_creator_form') {

                                        $(this).find('form').attr("id", "add_creator_form");
                                        $(this).find('form').attr("action", base_url + '/admin/creator-store');
                                        $('.creator_id').remove();
                                        var form = $('#add_creator_form');
                                        form.validate().resetForm();
                                        $(this).find('form').trigger('reset');
                                        form.find('.error').removeClass('error');
                                        form.find('.text-danger').remove();
                                        form.find('.is-invalid').removeClass('is-invalid');
                                        form.find('.is-valid').removeClass('is-valid');
                                        $('#creator_modal .password_div').show();
                                        $('#creator_modal #creator_modal_title').text("Add Creator");
                                        $('#creator_modal #creator_submit_btn').text("Submit");
                                    }
                                    else
                                        if ($(this).find('form').attr("id") == 'edit_creator_profile_form') {
                                            var form = $('#edit_creator_profile_form');
                                            $('.user_id').remove();
                                            form.validate().resetForm();
                                            $(this).find('form').trigger('reset');
                                            form.find('.error').removeClass('error');
                                            form.find('.is-invalid').removeClass('is-invalid');
                                            form.find('.is-valid').removeClass('is-valid');
                                        }

    });
    // $('#hangout_add_btn').on('click', function (event) {
    //     event.preventDefault(event)
    //     $('#hangout_modal #imgPreview').attr('src', '').hide();
    //     $('#hangout_form').attr('action', base_url + "/admin/add-hangout");
    // });
    $(document).on('click', '#post_add_btn', function (event) {
        event.preventDefault(event)
        $('#post_modal #imgPreview').attr('src', '').hide();
        $('#post_form').attr('action', base_url + "/admin/add-post");
    });
    $(document).on('click', '#plan_add_btn', function (event) {
        event.preventDefault(event)
        $('#plan_modal #imgPreview').attr('src', '').hide();
        $('#plan_form').attr('action', base_url + "/admin/add-plan");
    });
    $(document).on('click', '.creator_add_btn', function (event) {
        event.preventDefault(event)
        $('#add_creator_form').attr('action', base_url + "/admin/creator-store");
    });

    //-------------------------------------validations start------------------------
    // $("#add_hangout_form,#edit_hangout_form").validate({
    //     rules: {
    //         image: {
    //             required: {
    //                 depends: function (elem) {
    //                     var fomrs_id = $(this).parents("form").attr("id");
    //                     return fomrs_id != 'edit_hangout_form';
    //                 }
    //             }
    //         },
    //         title: {
    //             required: true
    //         },
    //         duration: {
    //             required: true
    //         }
    //     },
    //     messages: {
    //         image: {
    //             required: 'Please upload a image'
    //         },
    //         title: {
    //             required: 'Please enter title'
    //         },
    //         duration: {
    //             required: 'Please select duration'
    //         }
    //     }, errorElement: 'span',
    //     errorPlacement: function (error, element) {
    //         error.addClass('invalid-feedback');
    //         element.closest('.form-group').append(error);
    //     },

    // });

    // Set up the CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#add_post_form,#edit_post_form").validate({
        rules: {
            // image: {
            //     required: {
            //         depends: function (elem) {
            //             var fomrs_id = $(this).parents("form").attr("id");
            //             return fomrs_id != 'edit_post_form';
            //         }
            //     }
            // },
            title: {
                required: true,
                noSpaces: true

            },
            description: {
                required: true,
                noSpaces: true

            },
            vertical: {
                required: true
            }
        },
        messages: {
            // image: {
            //     required: 'Please upload a image'
            // },
            title: {
                required: 'Please enter title'
            },
            description: {
                required: 'Please enter description'
            },
            vertical: {
                required: 'Please select vertical'
            }
        }, errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });
    $("#add_plan_form,#edit_plan_form").validate({
        rules: {
            // image: {
            //     required: {
            //         depends: function (elem) {
            //             var fomrs_id = $(this).parents("form").attr("id");
            //             return fomrs_id != 'edit_plan_form';
            //         }
            //     }
            // },
            name: {
                required: true,
                noSpaces: true

            },
            tier1_image: {
                required: true

            },
            tier2_image: {
                required: true

            },
            tier3_image: {
                required: true

            },
            arriving: {
                required: true
            },
            departing: {
                required: true
            },
            // tier: {
            //     required: true,
            //     minlength: 1,
            //     maxlength: 2,
            //     range: [1, 10]
            // },
            about_trip: {
                required: true,
                noSpaces: true

            },
            // link: {
            //     required: true,
            //     noSpaces: true

            // },
            // 'destinations[]': {
            //     required: true
            // },
            'vertical': {
                required: true
            }
        },
        messages: {
            // image: {
            //     required: 'Please upload a image'
            // },
            name: {
                required: 'Please enter plan name '
            },
            tier1_image: {
                required: 'Please upload a image'
            },
            tier2_image: {
                required: 'Please upload a image'
            },
            tier3_image: {
                required: 'Please upload a image'
            },
            arriving: {
                required: 'Please enter arriving date'
            },
            departing: {
                required: 'Please enter departing date'
            },

            'vertical': {
                required: 'Please select at least one vertical'
            },
            about_trip: {
                required: 'Please enter about trip'
            },
        }, errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });
    $("#change_password_admin").validate({
        rules: {
            current_password: {
                required: true,
                minlength: 8,
                noSpaces: true,
                current_password: true

            },
            password: {
                required: true,
                minlength: 8,
                noSpaces: true

            },
            password_confirmation: {
                required: true,
                equalTo: "#password",
                minlength: 8,
                noSpaces: true


            }
        },
        messages: {
            current_password: {
                required: 'Please enter current password'
            },
            password: {
                required: 'Please enter new password'
            },
            password_confirmation: {
                required: 'Please enter confirmation password',
                equalTo: 'Password not match'
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-sm-10').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });
    $("#admin_deatils").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                noSpaces: true
            },
            email: {
                required: true,
                email: true,
                customEmailValidation: true
            },
        },
        messages: {
            name: {
                required: 'Please enter name'
            },
            email: {
                required: 'Please enter email'
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-sm-10').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });
    $("#terms_conditions").validate({
        rules: {
            title: {
                required: true,
                minlength: 3,
                noSpaces: true
            },
            content: {
                required: true,
                minlength: 10,
                noSpaces: true
            },
        },
        messages: {
            title: {
                required: 'Please enter title'
            },
            content: {
                required: 'Please enter content'
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });
    $("#privacy_policy").validate({
        rules: {
            title: {
                required: true,
                minlength: 3,
                noSpaces: true
            },
            content: {
                required: true,
                minlength: 10,
                noSpaces: true
            },
        },
        messages: {
            title: {
                required: 'Please enter title'
            },
            content: {
                required: 'Please enter content'
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });
    $("#add_user_form,#edit_user_form").validate({
        rules: {
            full_name: {
                required: true,
                minlength: 3,
                noSpaces: true,
            },
            phone: {
                required: true,
                minlength: 10,
            },
            email: {
                required: true,
                email: true,
                // customEmailValidation: true,
                // email_existence:
                // {
                //     depends: function (elem) {
                //         var fomrs_id = $(this).parents("form").attr("id");
                //         return fomrs_id != 'edit_user_form';
                //     }
                // }
            },
            dob:{
                required: true,
                min: today,
            },
            class:{
                required: true,
            },
            profile_image: {
                required:
                {
                    depends: function (elem) {
                        var fomrs_id = $(this).parents("form").attr("id");
                        return fomrs_id != 'edit_user_form';
                    }
                }
            },
            password: {
                required: {
                    depends: function (elem) {
                        var fomrs_id = $(this).parents("form").attr("id");
                        return fomrs_id != 'edit_user_form';
                    }
                },
                minlength: 8
            }
        },
        messages: {
            full_name: {
                required: 'Please enter full name'
            },
            email: {
                required: "Email is required!",
                email: "Please enter a valid email address",
                email_existence: "This email is already in use"
            },
            dob:{
                required: "DOB is required",
                min: "take max today"
            },
            class:{
                required: "Class is required",
                
            },
            password: {
                required: 'Please enter password'
            },
            phone: {
                required: 'Please enter phone number'
            }
        }, errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });
    $("#add_creator_form,#edit_creator_form").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 3,
                noSpaces: true
            },
            last_name: {
                required: true,
                minlength: 3,
                noSpaces: true
            },
            email: {
                required: true,
                email: true,
                customEmailValidation: true,
                email_existence:
                {
                    depends: function (elem) {
                        var fomrs_id = $(this).parents("form").attr("id");
                        return fomrs_id != 'edit_creator_form';
                    }
                }
            },
            password: {
                required: {
                    depends: function (elem) {
                        var fomrs_id = $(this).parents("form").attr("id");
                        return fomrs_id != 'edit_creator_form';
                    }
                },
                minlength: 8
            }
        },
        messages: {
            first_name: {
                required: 'Please enter first name'
            },
            last_name: {
                required: 'Please enter last name'
            },
            email: {
                required: "This field is required",
                email: "Please enter a valid email address",
                email_existence: "This email is already in use"
            },
            password: {
                required: 'Please enter password'
            }
        }
        , errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });
    $("#vertical_store,#edit_verticale").validate({
        rules: {
            vertical_name: {
                required: true,
                minlength: 3,
                noSpaces: true
            },
            vertical_image: {
                required: {
                    depends: function (elem) {
                        var fomrs_id = $(this).parents("form").attr("id");
                        return fomrs_id != 'edit_verticale';
                    }
                }
            }
        },
        messages: {
            vertical_name: {
                required: 'Please enter vertical name'
            },
            vertical_image: {
                required: 'Please upload vertical image'
            }
        }, errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });
    //Instagram tongle button
    $(document).on('change', '.insta_status', function () {
        var status = $(this).is(':checked') ? 1 : 0;
        var id = $(this).data('id');
        var url = $(this).data('url');
        var checkbox = $(this);
        $.ajax({
            url: base_url + '/' + url,
            type: 'POST',
            data: {
                status: status,
                id: id
            },
            success: function (response) {
                if (response.status == 'success') {
                    // toastr.success(response.message);
                    toastr.success(response.message, "Success", {
                        closeButton: true,
                        progressBar: true
                    });
                }
                else
                    if (response.status == 'error') {
                        toastr.error(response.message, "Error", {
                            closeButton: true,
                            progressBar: true
                        });
                        // toastr.error(response.message);
                        checkbox.prop('checked', !status);
                    }
            },
            error: function (xhr, status, error) {
                toastr.error(response.message);
                checkbox.prop('checked', !status);
            }
        });
    });

    // --model for view block post----
    $(document).on('click', '.show-post-detail', function (event) {
        event.preventDefault(event)

        var post_title = $(this).data('post-title');
        var post_description = $(this).data('post-description');
        var post_img = $(this).data('post-image');
        var user_email = $(this).data('post-user_email');
        var img_path = $(this).data('image-path ');

        $('#exampleModalLong').modal('show');
        $('#exampleModalLong #title').html(post_title);
        $('#exampleModalLong #description').html(post_description);
        $('#exampleModalLong #imgPreview').attr('src', post_img);
        $('#exampleModalLong #posted_by').html(user_email);
    });

    // --model for view block users----
    $(document).on('click', '.show-user-detail', function (event) {
        event.preventDefault(event)
        var user_name = $(this).data('user-name');
        var user_email = $(this).data('user-email');
        var user_type = $(this).data('user-type');
        var user_image = $(this).data('user-image');


        $('#exampleModalLong').modal('show');
        $('#exampleModalLong #user_name').html(user_name);
        $('#exampleModalLong #user_email').html(user_email);
        $('#exampleModalLong #user_type').html(user_type);
        $('#exampleModalLong #imgPreview').attr('src', user_image);
    });

    // --block post----
    $(document).on('click', '.block-the-post', function (event) {
        event.preventDefault();
        const postStatus = $(this).data('post-status');

        Swal.fire({
            title: "Are you sure?",
            text: (postStatus == 'Active') ? "You want to inactive this post!" : "You want to active this post!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: (postStatus == 'Active') ? "Yes, inactive it!" : "Yes, active it!"
        }).then((result) => {
            if (result.isConfirmed) {

                const postId = $(this).data('post-id');
                $.ajax({
                    url: 'block-post',
                    type: 'POST',
                    data: { id: postId, status: postStatus },
                    success: function (response) {
                        Swal.fire({
                            title: (postStatus == 'Active') ? "Inactive!" : "Active!",
                            text: (postStatus == 'Active') ? "This post has been inactive." : "This post has been Active.",
                            icon: "success"
                        });
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: "There was an error blocking the post.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });

    // --block user----
    $(document).on('click', '.block-the-user', function (event) {
        event.preventDefault();
        const userStatus = $(this).data('user-status');

        Swal.fire({
            title: "Are you sure?",
            text: (userStatus == 'Active') ? "You want to inactive this user!" : "You want to active this user!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: (userStatus == 'Active') ? "Yes, inactive it!" : "Yes, active it!"
        }).then((result) => {
            if (result.isConfirmed) {

                const userId = $(this).data('user-id');
                $.ajax({
                    url: 'block-user',
                    type: 'POST',
                    data: { id: userId, status: userStatus },
                    success: function (response) {
                        Swal.fire({
                            title: (userStatus == 'Active') ? "Inactive!" : "Active!",
                            text: (userStatus == 'Active') ? "This user has been inactive." : "This user has been Active.",
                            icon: "success"
                        });
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: "There was an error inactive the user.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });

    // --approve instagram details update request----
    $(document).on('click', '.insta_approve_btn', function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "You want to approve this request!",
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, approve it!"
        }).then((result) => {
            if (result.isConfirmed) {

                const userId = $(this).data('user_id');
                $.ajax({
                    url: 'user-insta-request-approve',
                    type: 'post',
                    data: { id: userId },
                    success: function (response) {
                            location.reload();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: "User instgram details are not updated",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
    // --reject instagram details update request----
    $(document).on('click', '.insta_reject_btn', function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "You want to reject this request!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, reject it!"
        }).then((result) => {
            if (result.isConfirmed) {

                const userId = $(this).data('user_id');
                $.ajax({
                    url: 'user-insta-request-reject',
                    type: 'post',
                    data: { id: userId },
                    success: function (response) {
                            location.reload();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: "User instgram details are not updated",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
       // --approve kyc request----
       $(document).on('click', '.kyc_approve_btn', function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "You want to approve this request!",
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, approve it!"
        }).then((result) => {
            if (result.isConfirmed) {

                const userId = $(this).data('user_id');
                $.ajax({
                    url: 'user-kyc-approve',
                    type: 'post',
                    data: { id: userId },
                    success: function (response) {
                            location.reload();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: "something went wrong",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
    // --reject kyc request----
    $(document).on('click', '.kyc_reject_btn', function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "You want to reject this request!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, reject it!"
        }).then((result) => {
            if (result.isConfirmed) {

                const userId = $(this).data('user_id');
                $.ajax({
                    url: 'user-kyc-reject',
                    type: 'post',
                    data: { id: userId },
                    success: function (response) {
                            location.reload();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: "something went wrong",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
});
