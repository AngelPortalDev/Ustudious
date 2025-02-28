$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var baseUrl = window.location.origin;
    var assets = window.location.origin + "/assets/";
    var reader = new FileReader();
    var img = new Image();


    $(".updateCourseBasicAdd").on("click", function (event) {
        event.preventDefault();

        $("#course_name_error").hide();
        $("#subheading_error").hide();
        $("#course_types_error").hide();
        $("#mode_of_study_error").hide();
        $("#course_category_error").hide();
        $("#course_fees_error").hide();
        $("#administrative_cost_error").hide();


        var course_name = $("#course_name").val();
        var subheading = $("#subheading").val();
        var course_types = $("#course_types").val();
        var mode_of_study = $("#mode_of_study").val();
        var course_category = $("#course_category").val();
        var course_fees = $("#course_fees").val();
        var administrative_cost = $("#administrative_cost").val();
        var total_cost = $("#total_cost").val();
        //console.log(course_name);
        if (course_name === "") {
            $("#course_name_error").show();
            return;
        } if (subheading === "") {
            $("#subheading_error").show();
            return;
        } if (course_types === "") {
            $("#course_types_error").show();
            return;
        } if (mode_of_study === "") {
            $("#mode_of_study_error").show();
            return;
        } if (course_category === "") {
            $("#course_category_error").show();
            return;
        } if (course_fees === "") {
            $("#course_fees_error").show();
            return;
        } if (administrative_cost === "") {
            $("#administrative_cost_error").show();
            return;
        }

        var form = new FormData($(".basicCourseFormAdd")[0]);

        $.ajax({
            url: baseUrl + "/admin/add-course-main",
            type: "POST",
            data: form,
            contentType: false,
            processData: false,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {


                if (response.code === 200) {
                    $(".course_id").val(response.data);
                    $(".errors").remove();
                    swal({
                        title: response.title,
                        text: response.message,
                        icon: response.icon,
                    }).then(function () {
                        $("#nav-home-tab").removeClass("active");
                        $("#nav-home").removeClass("active");
                        $("#nav-profile-tab").addClass("active");
                        $("#nav-profile").addClass("show active");

                    });
                }
                if (response.code === 202) {
                    var data = Object.keys(response.data);
                    var values = Object.values(response.data);

                    data.forEach(function (key) {
                        var value = response.data[key];
                        $(".errors").remove();
                        $("form")
                            .find("[name='" + key + "']")
                            .after(
                                "<div class='invalid-feedback errors d-block'><i>" +
                                value +
                                "</i></div>"
                            );
                    });
                }
                if (response.code === 201) {
                    var data = Object.keys(response.data);
                    var values = Object.values(response.data);

                    swal({
                        title: response.title,
                        text: response.message,
                        icon: response.icon,
                    });
                }
            },
        });
    });

    $(".updateCourseOthers").on("click", function (event) {
        event.preventDefault();
        var course_check = $(".course_id").val();
        console.log(course_check);
        if (course_check != "") {
            $("#course_overview_error").hide();
            $("#course_curriculum_error").hide();
            $("#course_opportunities_error").hide();
            $("#application_procedure_error").hide();

            var course_overview = $("#course_overview .ql-editor").html();
            var text = $(course_overview).text();
            var charCount = text.length;

            if (charCount > 1500) {
                $("#course_overview_error").val("Course overview must be between 5-1500 characters.");
                $('#course_overview_error').show(); // Show error message
                return '';
            }
            var course_curriculum = $("#course_curriculum .ql-editor").html();
            var text1 = $(course_curriculum).text();
            var charCount1 = text1.length;
            if (charCount1 > 1500) {
                $("#course_curriculum_error").val("Course Curriculum must be between 5-1500 characters.");
                $('#course_curriculum_error').show(); // Show error message
                return '';
            }
            var course_opportunities = $("#course_opportunities .ql-editor").html();
            var text2 = $(course_opportunities).text();
            var charCount2 = text2.length;
            if (charCount2 > 1500) {
                $("#course_opportunities_error").val("Entry Requirement must be between 5-1500 characters.");
                $('#course_opportunities_error').show(); // Show error message
                return '';
            }
            var application_procedure = $("#application_procedure .ql-editor").html();
            var text3 = $(application_procedure).text();
            var charCount3 = text3.length;
            if (charCount3 > 500) {
                $("#application_procedure_error").val("Assessment must be between 5-500 characters.");
                $('#application_procedure_error').show(); // Show error message
                return '';
            }
            var form = new FormData($(".basicCourseOtherForm")[0]);
            form.append("course_overview", course_overview);
            form.append("course_curriculum", course_curriculum);
            form.append("course_opportunities", course_opportunities);
            form.append("application_procedure", application_procedure);
            $.ajax({
                url: baseUrl + "/admin/add-course-others",
                type: "POST",
                data: form,
                dataType: "json",
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    $(".save_loader").fadeOut();
                    if (response.code === 200) {
                        // $(".course_id").val(response.data);

                        swal({
                            title: response.title,
                            text: response.message,
                            icon: response.icon,
                        }).then(function () {
                            $("#nav-profile-tab").removeClass("active");
                            $("#nav-profile").removeClass("show active");
                            $("#nav-contact-tab").addClass("active");
                            $("#nav-contact").addClass("show active");
                        });
                        $(".errors").remove();
                    }
                    if (response.code === 202) {
                        var data = Object.keys(response.data);
                        var values = Object.values(response.data);

                        data.forEach(function (key) {
                            var value = response.data[key];
                            $(".errors").remove();
                            $("form")
                                .find("[name='" + key + "']")
                                .after(
                                    "<div class='invalid-feedback errors d-block'><i>" +
                                    value +
                                    "</i></div>"
                                );
                        });
                    }
                },
            });
        } else {
            swal({
                title: "Course Details Not Found",
                text: "Kindly start from beginning",
                icon: "warning",
            }).then(function () {
                $("#nav-home-tab").addClass("active");
                $("#nav-home").addClass("active show");
                $("#nav-profile-tab").removeClass("active");
                $("#nav-profile").removeClass("show active");

            });
        }

    });


    //Image & video Preview
    $(".imageprv").on("change", function () {
        var img = this.files[0];
        var size = img.size / 1024;
        if (img) {
            reader.onload = function (e) {
                img.src = e.target.result;
                e.preventDefault();
                $(".image-preview")
                    .removeClass("d-none")
                    .attr("src", img.src)
                    .addClass("d-block");
                $("#thumbnail_file_name").text(img.name);

            };
            reader.readAsDataURL(img);
        }
    });
    $(".trailor_thumbnail").on("change", function () {
        var img = this.files[0];
        var size = img.size / 1024;
        if (img) {
            reader.onload = function (e) {
                img.src = e.target.result;
                e.preventDefault();
                $(".trailor_thumbnail_preview")
                    .removeClass("d-none")
                    .attr("src", img.src)
                    .addClass("d-block");
                $("#trailor_thumbnail_file_name").text(img.name);

            };
            reader.readAsDataURL(img);
        }
    });
    $(".course_trailor").on("change", function (event) {
        var file = event.target.files[0];
        if (file) {
            var videoSrc = URL.createObjectURL(file);
            $(".previouseVideo").addClass("d-none");
            $(".video-preview-trailor")
                .removeClass("d-none")
                .attr("src", videoSrc)
                .addClass("d-block");
            $("#course_trailor").text(file.name);
        }
    });
    //Image & video Preview

    $(".updateCourseMediaAdd").on("click", function (event) {
        event.preventDefault();

        var course_check = $(".course_id").val();
        if (course_check != "") {

            $("#thumbnail_error").hide();
            $("#trailor_error").hide();
            $("#trailor_thumbnail_error").hide();

            var thumbnail_img = $("#thumbnail_img").val();
            // var course_trailor = $("#course_trailor").val();
            var trailor_thumbnail = $("#trailor_thumbnail").val();
           
            if (thumbnail_img == "") {
                $("#thumbnail_error").show();
                return;
            }
            // if (course_trailor == "") {
            //     $("#trailor_error").show();
            //     return;
            // }
            if (trailor_thumbnail == "") {
                $("#trailor_thumbnail_error").show();
                return;
            }

            var form = new FormData($(".CourseMediaForm")[0]);


            //$(".save_loader").removeClass("d-none").addClass("d-block");

            $.ajax({
                url: baseUrl + "/admin/add-course-media-main",
                type: "POST",
                data: form,
                contentType: false,
                processData: false,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    $(".save_loader").addClass("d-none").removeClass("d-block");
                    if (response.code === 200) {
                        $(".course_id").val(response.data);
                        $(".errors").remove();
                        swal({
                            title: response.title,
                            text: response.message,
                            icon: response.icon,
                        }).then(function () {

                            return (window.location.href = "/admin/course");

                        });
                    }
                    if (response.code === 202) {
                        var data = Object.keys(response.data);
                        var values = Object.values(response.data);

                        data.forEach(function (key) {
                            var value = response.data[key];
                            $(".errors").remove();
                            $("form")
                                .find("[name='" + key + "']")
                                .after(
                                    "<div class='invalid-feedback errors d-block'><i>" +
                                    value +
                                    "</i></div>"
                                );
                        });
                    }
                },
            });
        } else {
            swal({
                title: "Course Details Not Found",
                text: "Kindly start from beginning",
                icon: "warning",
            }).then(function () {
                $("#nav-home-tab").addClass("active");
                $("#nav-home").addClass("show active");
                $("#nav-contact-tab").removeClass("active");
                $("#nav-contact").removeClass("show active");

            });
        }
    });

    $('#DeleteCourse').on('click', function (e) {
        var allVals = [];
        $(".sub_chk:checked").each(function () {

            allVals.push($(this).attr('data-id'));
        });

        if ($(this).attr('data-id') == undefined) {
            var deletevalue = $("#courseId").val();

            if (deletevalue) {
                allVals.push(deletevalue);
            }
        }

        if (allVals.length <= 0) {

            $('#alert-modal').modal("show");

            return false;
        }
        else {
            var join_selected_values = allVals.join(",");
            $.ajax({

                url: baseUrl + "course/delete",

                type: 'POST',

                headers: {

                    "X-CSRF-TOKEN": csrfToken,

                },

                data: 'course_ids=' + join_selected_values,

                success: function (data) {

                    if (data == 1) {

                        toastr.success("Course Deleted Successfully.");

                        setTimeout(function () {

                            window.location.reload();

                        }, 5000);

                    } else {

                        toastr.error("Something Went wrong");

                        setTimeout(function () {

                            window.location.reload();

                        }, 1000);

                    }

                },

                error: function (data) {

                }

            });

        }

    });

    $("#editcourse").on("click", function (event) {
        var courseId = $(this).data("id");
        if(courseId != ""){
            $.ajax({
                url: '/your-controller-route', 
                type: 'POST',
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                data: {
                    id: courseId,                  
                },
                success: function (response) {
                    // Handle success response
                    alert('Success: ' + response.message);
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    alert('Error: ' + xhr.responseText);
                }
            });
        }else {
            swal({
                title: "Something went wrong.",
                text: "Kindly Check or refresh",
                icon: "warning",
            })
        }
    });


    $('#ApprovedCourse').on('click', function (e) {

        var allVals = [];

        $(".sub_chk:checked").each(function () {

            allVals.push($(this).attr('data-id'));

        });

        if (allVals.length <= 0) {

            $('#alert-modal').modal("show");

            return false;

        }

        else {

            var join_selected_values = allVals.join(",");

            $.ajax({

                url: baseUrl + "course/approvedcourse",

                type: 'POST',

                headers: {

                    "X-CSRF-TOKEN": csrfToken,

                },

                data: 'course_id=' + join_selected_values,

                success: function (data) {

                    toastr.success(" Course Status Approved Successfully.");

                    setTimeout(function () {

                        window.location.reload();

                    }, 1000);

                }

            });

        }

    });

    $('#RejectCourse').on('click', function (e) {

        var allVals = [];

        $(".sub_chk:checked").each(function () {

            allVals.push($(this).attr('data-id'));

        });

        if (allVals.length <= 0) {

            $('#alert-modal').modal("show");

            return false;

        }

        else {

            var join_selected_values = allVals.join(",");

            $.ajax({

                url: baseUrl + "course/rejectcourse",

                type: 'POST',

                headers: {

                    "X-CSRF-TOKEN": csrfToken,

                },

                data: 'course_id=' + join_selected_values,

                success: function (data) {

                    toastr.error(" Course Status Rejected Successfully.");

                    setTimeout(function () {

                        window.location.reload();

                    }, 1000);

                }

            });

        }

    });

    $("#ImportCourses").on('click', function (e) {

        $('#importCourse').validate({

            rules: {

                customfile: {

                    required: true

                },

            },

            messages: {

                customfile: {

                    required: 'Please select File.',

                },

            },

            submitHandler: function (form) {

                var formData = new FormData($("#importCourse")[0]);

                $.ajax({

                    type: "POST",

                    url: baseUrl + "course/importcourse",

                    data: formData,

                    contentType: false,

                    processData: false,

                    headers: {

                        "X-CSRF-TOKEN": csrfToken,

                    },

                    success: function (data) {

                        if (data == 'true') {

                            toastr.success(" Course Data Import Successfully.");

                            setTimeout(function () {

                                window.location.reload();

                            }, 1000);

                        } else {

                            toastr.error("Something went wrong.");

                            setTimeout(function () {

                                window.location.reload();

                            }, 1000);

                        }

                    }

                });

            }

        });

    });
    // $("#CreateCourse").on('click', function (e) {

    //     $('#addCourse').validate({

    //         highlight: function (element, errorClass, validClass) {
    //             $(element).parents('.select2').removeClass('has-success').addClass('has-error');
    //         },

    //         errorPlacement: function (error, element) {
    //             if (element.hasClass('select2') && element.next('.select2-container').length) {
    //                 error.insertAfter(element.next('.select2-container'));
    //             } else if (element.parent('.input-group').length) {
    //                 error.insertAfter(element.parent());
    //             }
    //             else {
    //                 error.insertAfter(element);
    //             }
    //             console.log(error.insertAfter(element));
    //         },
    //         ignore: [],  // Validate hidden elements

    //         rules: {

    //             course_name: {
    //                 required: true
    //             },
    //             specialization: {
    //                 required: true
    //             },

    //             course_types: {
    //                 required: true,
    //             },
    //             mode_of_study: {
    //                 required: true
    //             },
    //             course_category: {
    //                 required: true
    //             },

    //             course_fees: {
    //                 required: true
    //             },

    //             administrative_cost: {
    //                 required: true
    //             },

    //             course_overview_error: {

    //                 required: true
    //             },
    //             course_language: {
    //                 required: true
    //             },


    //         },

    //         messages: {

    //             institute_id: {

    //                 required: 'Please  Institute.',
    //             },
    //             course_name: {
    //                 required: 'Please enter Course.',
    //             },

    //             course_duration: {
    //                 required: 'Please select Duration.',
    //             },

    //             country_id: {
    //                 required: 'Please select Currency.',
    //             },

    //             course_fees: {
    //                 required: 'Please enter Course Fees.',
    //             },

    //             administrative_cost: {
    //                 required: 'Please enter Administrative Cost.',
    //             },
    //             specialization: {
    //                 required: 'Please enter Specialization.',
    //             },
    //             course_start_date: {
    //                 required: 'Please enter Course Start Date.',
    //             },

    //             course_expire_date: {
    //                 required: 'Please enter Course Expire Date.',
    //             },
    //             qualification: {
    //                 required: 'Please enter Qualification.',
    //             },
    //             course_intakemonth: {
    //                 required: 'Please select Intake Month.',
    //             },
    //             age_limit: {
    //                 required: 'Please enter Age Limit.',
    //             },
    //             course_intakeyear: {
    //                 required: 'Please select Intake Year.',
    //             },
    //             course_overview: {
    //                 required: "Please enter the course overview."
    //             },
    //             course_curriculum: {
    //                 required: "Please enter the course curriculum."
    //             },
    //             course_requirements: {
    //                 required: "Please enter the application procedure."
    //             },
    //             mode_of_study: {
    //                 required: 'Please select Mode of Study.'
    //             },
    //             course_language: {
    //                 required: 'Please select Language.'
    //             },
    //             course_types: {
    //                 required: 'Please select Program Types.',
    //             },
    //             course_category: {
    //                 required: 'Please select Course Category.'
    //             },
    //             unhighlight: function (element, errorClass, validClass) {

    //                 if ($(element).hasClass('select2') && $(element).next('.select2-container').length) {

    //                     $(element).next('.select2-container').removeClass('select2-container-error');

    //                 }

    //             },

    //         },

    //         submitHandler: function (form) {
    //             var formData = new FormData($("#addCourse")[0]);

    //             $.ajax({

    //                 type: 'POST',
    //                 url: baseUrl + 'course/store',
    //                 data: formData,
    //                 contentType: false,
    //                 processData: false,
    //                 dataType: "json",
    //                 headers: {
    //                     "X-CSRF-TOKEN": csrfToken,
    //                 },

    //                 success: function (res) {
    //                     console.log(res);
    //                     console.log(res.code);
    //                     if (res.code === 200) {
    //                         swal({
    //                             title: res.message,
    //                             text: "",
    //                             icon: "success",
    //                         }).then(function () {
    //                             return window.location.href = '/course';
    //                         });
    //                     } else {
    //                         swal({
    //                             title: res.message,
    //                             text: "Please Try Again",
    //                             icon: "error",
    //                         }).then(function () {
    //                             return window.location.href = '/course';
    //                         });
    //                     }
    //                 }

    //             });

    //         }

    //     });

    //     // });

    // });

    // $("#EditCourse").on('click', function (e) {

    //     $('#UpdateCourse').validate({

    //         highlight: function (element, errorClass, validClass) {

    //             $(element).parents('.select2').removeClass('has-success').addClass('has-error');

    //         },

    //         errorPlacement: function (error, element) {

    //             if (element.hasClass('select2') && element.next('.select2-container').length) {

    //                 error.insertAfter(element.next('.select2-container'));

    //             } else if (element.parent('.input-group').length) {

    //                 error.insertAfter(element.parent());

    //             }
    //             else {
    //                 error.insertAfter(element);
    //             }
    //         },

    //         ignore: [],  // Validate hidden elements
    //         rules: {

    //             institute_id: {

    //                 required: true,

    //             },

    //             course_name: {

    //                 required: true

    //             },

    //             course_duration: {

    //                 required: true

    //             },

    //             country_id: {

    //                 required: true

    //             },

    //             course_fees: {

    //                 required: true

    //             },

    //             administrative_cost: {

    //                 required: true

    //             },
    //             course_types: {

    //                 required: true

    //             },
    //             specialization: {

    //                 required: true

    //             },
    //             course_start_date: {

    //                 required: true
    //             },
    //             course_expire_date: {

    //                 required: true
    //             },
    //             qualification: {

    //                 required: true

    //             },
    //             age_limit: {

    //                 required: true

    //             },
    //             course_intakemonth: {

    //                 required: true

    //             },
    //             course_intakeyear: {

    //                 required: true
    //             },
    //             course_overview: {
    //                 required: function () {
    //                     CKEDITOR.instances.course_overview.updateElement();
    //                     var editorContent = $('#course_overview').val();
    //                     return editorContent.length === 0 || editorContent.trim() === '';
    //                 }
    //             },
    //             course_curriculum: {
    //                 required: function () {
    //                     CKEDITOR.instances.course_curriculum.updateElement();
    //                     var editorContent = $('#course_curriculum').val();
    //                     return editorContent.length === 0 || editorContent.trim() === '';
    //                 }
    //             },
    //             course_requirements: {
    //                 required: function () {
    //                     CKEDITOR.instances.course_requirements.updateElement();
    //                     var editorContent = $('#course_requirements').val();
    //                     return editorContent.length === 0 || editorContent.trim() === '';
    //                 }
    //             },
    //             mode_of_study: {
    //                 required: true
    //             },
    //             course_language: {
    //                 required: true
    //             },
    //             course_category: {
    //                 required: true,
    //             },


    //         },

    //         messages: {

    //             institute_id: {

    //                 required: 'Please  Institute.',

    //             },

    //             course_name: {

    //                 required: 'Please enter Course.',

    //             },

    //             course_duration: {

    //                 required: 'Please select Duration.',

    //             },

    //             country_id: {

    //                 required: 'Please select Currency.',

    //             },

    //             course_fees: {

    //                 required: 'Please enter Course Fees.',

    //             },

    //             administrative_cost: {

    //                 required: 'Please enter Administrative Cost.',

    //             },
    //             specialization: {

    //                 required: 'Please enter Specialization.',

    //             },
    //             course_start_date: {

    //                 required: 'Please enter Course Start Date.',

    //             },
    //             course_expire_date: {

    //                 required: 'Please enter Course Expire Date.',

    //             },
    //             qualification: {

    //                 required: 'Please enter Qualification.',

    //             },
    //             course_intakemonth: {

    //                 required: 'Please select Intake Month.',

    //             },
    //             age_limit: {

    //                 required: 'Please enter Age Limit.',

    //             },
    //             course_intakeyear: {

    //                 required: 'Please select Intake Year.',
    //             },
    //             course_overview: {

    //                 required: "Please enter the course overview."
    //             },
    //             course_curriculum: {

    //                 required: "Please enter the course curriculum."
    //             },
    //             course_requirements: {

    //                 required: "Please enter the application procedure."
    //             },
    //             mode_of_study: {
    //                 required: 'Please select Mode of Study.'
    //             },
    //             course_language: {
    //                 required: 'Please select Language.'
    //             },
    //             course_types: {
    //                 required: 'Please select Program Types.',
    //             },
    //             course_category: {
    //                 required: 'Please select Course Category.'
    //             },

    //         },

    //         submitHandler: function (form) {

    //             var formData = new FormData($("#UpdateCourse")[0]);

    //             $.ajax({

    //                 type: 'POST',

    //                 url: baseUrl + 'course/update',

    //                 data: formData,

    //                 contentType: false,

    //                 processData: false,

    //                 dataType: "json",

    //                 headers: {

    //                     "X-CSRF-TOKEN": csrfToken,

    //                 },

    //                 success: function (res) {
    //                     // console.log(res.code);
    //                     if (res.code === 200) {
    //                         swal({
    //                             title: res.message,
    //                             text: "",
    //                             icon: "success",
    //                         }).then(function () {
    //                             return window.location.href = '/course';
    //                         });
    //                     } else {
    //                         swal({
    //                             title: res.message,
    //                             text: "",
    //                             icon: "error",
    //                         }).then(function () {
    //                             return window.location.href = '/course';
    //                         });
    //                     }


    //                 }

    //             });

    //         }

    //     });

    //     // });

    // });

});