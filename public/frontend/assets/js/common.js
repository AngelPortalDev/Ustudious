
$(document).ready(function () {

  
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var baseUrl = window.location.origin + "/";
    var assets = window.location.origin + "/assets/";
    var reader = new FileReader();
    var img = new Image();
    // user submit operatiom
   
  

    $('#student_country_id').on('change', function () {
      var idCountry = this.value;
      $.ajax({
          url: baseUrl + "institute/fetch-states",
          type: "POST",
          data: {
              country_id: idCountry
          },
          headers: {
            "X-CSRF-TOKEN": csrfToken,
          },
          dataType: 'json',
          success: function (result) {
              $(".student_country_code").val('+'+result.countrycode[0]['CountryCode']);

          }
      }); 
    });

    // $(document).on('click', '#browsecourselist .pagination a', function(event) {
    //     event.preventDefault();
    //     var page = $(this).attr('href').split('page=')[1];
    //     return window.location.href='/browse-course?page='+page;
    // });


    // $("#PostCourse").on('click', function(e) {
    //   var formData = new FormData($("#postcourse")[0]);
     
  
    //   $('#postcourse').validate({
    //     rules: {
    //       course_title:{
    //         required: true,
    //       },
    //       course_types:{
    //         required:true,
    //       },
    //       course_price:{
    //         required:true,
    //       },
    //       administrative_price:{
    //         required:true,
    //       },
    //       course_start_date:{
    //         required:true,
    //       },
    //       course_expire_date:{
    //         required:true,
    //       },
    //       currency_symbols:{
    //         required:true,
    //       },
    //     },
    //     messages: {
    //       course_title:{
    //         required: 'Please enter Course Title.',
    //       },
    //       course_types:{
    //         required: 'Please select Course Type',
    //       },
    //       course_price:{
    //         required : 'Please enter Course Price',
    //       },
    //       administrative_price:{
    //         required : 'Please enter Administrative Price',
    //       },
    //       course_start_date:{
    //         required : 'Please enter Course Date',
    //       },
    //       course_expire_date:{
    //         required : 'Please enter Course Expire Date',
    //       },
    //       currency_symbols:{
    //         required : 'Please enter Currency',
    //       }
          
         
    //     },
    //     submitHandler: function (form) {
    //           $.ajax({
    //               type: 'POST',
    //               url:  baseUrl + 'postcourse',
    //               data: formData,
    //               contentType: false,
    //               processData:false,
    //               headers: {
    //                   "X-CSRF-TOKEN": csrfToken,
    //               },
    //               success:function(data) {
                  
    //                 if(data){
    //                   var operation = $("#operation").val();
    //                   // return window.location.href = baseUrl + 'institute-profile';
    //                   if(operation == 'edit'){
    //                       swal({
    //                         title: "Course Updated Successfully.",
    //                         icon: "success",
    //                       }).then(function () {
    //                         return  window.location.href = '/institute-posted-course';
    //                       });
    //                   }else{
    //                     swal({
    //                       title: "Post Course Created Successfully.",
    //                       icon: "success",
    //                     }).then(function () {
    //                       return  window.location.href = '/institute-posted-course';
    //                     });
    //                   }
    //                 }
    //               }
    //           });
    //     }
    //   });
    // });
      
    // $("#PostCourse").on('click', function(e) {
    //   var formData = new FormData($("#addCourse")[0]);
    //   debugger
    //   $.validator.addMethod('maxFileSize', function(value, element) {
    //     var maxSize = 2 * 1024 * 1024; // 2 MB in bytes
    //     if (element.files.length > 0) {
    //         return element.files[0].size <= maxSize;
    //     }
    //     return true; // No file selected, so consider it valid
    //     }, 'File size must be less than 2 MB.');
    //     $.validator.addMethod('fileExtension', function(value, element, param) {
    //       param = typeof param === 'string' ? param.replace(/,/g, '|') : 'png|jpe?g';
    //       return this.optional(element) || value.match(new RegExp('.(' + param + ')$', 'i'));    
    //     }, 'Please choose a file jpeg,jpg,png with a valid extension.');
    //     $('#addCourse').validate({
          
    //     rules: {
    //       course_title:{
    //         required: true,
    //       },
    //       // course_types:{
    //       //   required:true,
    //       // },
    //       // course_price:{
    //       //   required:true,
    //       // },
    //       // administrative_price:{
    //       //   required:true,
    //       // },
        
    //       // currency_symbols:{
    //       //   required:true,
    //       // },
    //       // brochure: {
    //       //   maxFileSize: true, // Custom rule for max file size
    //       //   fileExtension: 'jpg,png,jpeg' // Custom rule for allowed extensions
    //       // },

    //       // qualification: {
    //       //   required: true
    //       // },
    //       // course_types: {
    //       //   required: true
    //       // },
    //       // age_limit: {
    //       //   required:true
    //       // },
    //       // course_duration: {
    //       //   required: true,
    //       // },
    //       // specialization: {
    //       //   required: true
    //       // },
    //       // course_start_date: {
    //       //   required: true
    //       // },
    //       // course_expire_date :{
    //       //   required: true
    //       // },
    //       // course_intakemonth: {
    //       //   required: true
    //       // },
    //       // course_intakeyear : {
    //       //   required : true
    //       // },
    //       // mode_of_study : {
    //       //   required : true
    //       // },
    //       // course_language : {
    //       //   required : true
    //       // },
    //       // course_types:{
    //       //   required : true,
    //       // },
    //       // course_category:{
    //       //   required : true
    //       // },


    //     },
    //     messages: {
    //       course_title:{
    //         required: 'Please enter Course Nane.',
    //       },
    //       // course_types:{
    //       //   required: 'Please select Program Type',
    //       // },
    //       // course_price:{
    //       //   required : 'Please enter Course Price',
    //       // },
    //       // administrative_price:{
    //       //   required : 'Please enter Administrative Price',
    //       // },
    //       // currency_symbols:{
    //       //   required : 'Please Select Currency',
    //       // },
    //       // brochure: {
    //       //   required: 'Please select an image file.'
    //       // },
    //       // qualification: {
    //       //   required: 'Please enter Qualification.'
    //       // },
    //       // course_types: {
    //       //   required: 'Please enter Program Types.'
    //       // },
    //       // age_limit: {
    //       //   required: 'Please enter Age Limit.'
    //       // },
    //       // course_duration: {
    //       //   required: 'Please select Duration.',
    //       // },
    //       // specialization: {
    //       //   required: 'Please enter Specialization.',
    //       // },
    //       // course_start_date: {
    //       //   required: 'Please enter Course Start Date.'
    //       // },
    //       // course_expire_date :{
    //       //   required: 'Please enter Course Expire Date.',
    //       // },
    //       // course_intakemonth: {
    //       //   required: 'Please select Intake Month.',
    //       // },
    //       // course_intakeyear : {
    //       //   required: 'Please select Intake Year.',
    //       // },
      
    //       // mode_of_study : {
    //       //   required : 'Please select Mode of Study.'
    //       // },
    //       // course_language : {
    //       //   required : 'Please select Language.'
    //       // },
    //       // course_types: {
    //       //   required: 'Please select Program Types.',
    //       // },
    //       // course_category:{
    //       //   required : 'Please select Course Category.'
    //       // },
    //     },
    //     submitHandler: function (form) {
    //           $.ajax({
    //               type: 'POST',
    //               url:  baseUrl + 'postcourse',
    //               data: formData,
    //               contentType: false,
    //               processData:false,
    //               headers: {
    //                   "X-CSRF-TOKEN": csrfToken,
    //               },
    //               success:function(data) {
    //                 var operation = $("#operation").val();
  
    //               if (data.code === 200) {
    //                   swal({
    //                       title: data.message,
    //                       text: "",
    //                       icon: "success",
    //                     }).then(function () {
    //                       return  window.location.href = '/institute-posted-course';
    //                     });
                    
    //                 } else {
    //                     swal({
    //                         title: data.message,
    //                         text: "Please Try Again",
    //                         icon: "error",
    //                       }).then(function () {
    //                         return  window.location.href = '/institute-posted-course';
    //                       });
    //                 }
    //               }
    //           });
    //     }
    //     });
    // });
    $("#deleteModalCourse").on('click', function(e) {
        $("#deletecourse-modal").modal('hide');
        var course = $("#course_id").val();
        var action_txt = $("#course_action").val();
        var is_toggle = 'delete';
        $.ajax({
            url: baseUrl + "students/course-delete",
            type: "POST",
            dataType: "json",
            data: {
                course_id: course,
                action: action_txt,
                is_toggle: is_toggle,
            },
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            context: $(".action"),
            success: function (res) {
                if (res.code === 200) {
                    swal({
                        title: res.message,
                        text: "",
                        icon: "success",
                    }).then(function () {
                      return  window.location.href = '/institute-posted-course';
                    });
                } else {
                    swal({
                        title: res.message,
                        text: "Please Try Again",
                        icon: "error",
                    }).then(function () {
                      return  window.location.href = '/institute-posted-course';
                    });
                }
            }.bind(this),
            error: function (xhr, status, error) {
                $("#result").html("An error occurred.");
            },
        });
    });
      
    $(document).on("click", ".courseStatus", function () {
      var course = $(this).data("course_id");
      var action_txt = $(this).data("course_action");
      var is_toggle = $(this).data("is_toggle");
      if (action_txt != "" && (course !== null) & (course !== 0)) {
        if(action_txt == 'Delete'){
            $("#deletecourse-modal").modal('show');
            $("#course_id").val(course);
            $("#course_action").val(action_txt);
        }else{
          $.ajax({
              url: baseUrl + "students/course-delete",
              type: "POST",
              dataType: "json",
              data: {
                  course_id: course,
                  action: action_txt,
                  is_toggle: is_toggle,
              },
              headers: {
                  "X-CSRF-TOKEN": csrfToken,
              },
              context: $(".action"),
              success: function (res) {
                  if (res.code === 200) {
                      swal({
                          title: res.message,
                          text: "",
                          icon: "success",
                      }).then(function () {
                        return  window.location.href = '/institute-posted-course';
                      });
                  } else {
                      swal({
                          title: res.message,
                          text: "Please Try Again",
                          icon: "error",
                      }).then(function () {
                        return  window.location.href = '/institute-posted-course';
                      });
                  }
              }.bind(this),
              error: function (xhr, status, error) {
                  $("#result").html("An error occurred.");
              },
          });
        }
      } else {
          swal({
              title: "Something Went Wrong",
              text: "Please Try Again",
              icon: "error",
          });
      }
    });

    $("#student_view").on('click',function(){

      $("#student_profile_show").css('display','block');
      $("#student_view").css('display','none');
      $("#student_profile_edit").css('display','none');
      $("#student_edit").css('display','block');
    });
    $("#student_edit").on('click',function(){
      $("#student_profile_show").css('display','none');
      $("#student_edit").css('display','none');
      $("#student_profile_edit").css('display','block');
      $("#student_view").css('display','block');
    });
   
    $(document).on("click", ".stlogincheck", function () {
        swal({
            title: "Please Login",
            text: "Click ok to Login",
            icon: "warning",
        }).then(function () {
            $("#studentlogin").modal('show');
        });
    });

    $(document).on("click", ".institute_actions", function () {

        var student = $(this).data("student_id");
        var action_txt = $(this).data("student_action");
        var is_toggle = $(this).data("is_toggle");
        var posted_by = $(this).data("posted_by");
        var dashjs = $(this).data("dashjs");
        var action = $(this).data("action");
    
        if (action_txt != "" && (student !== null) & (student !== 0)) {
            $.ajax({
                url: baseUrl + "institute/student-action",
                type: "POST",
                dataType: "json",
                data: {
                    student_id: student,
                    action: action_txt,
                    is_toggle: is_toggle,
                    posted_by: posted_by,
                },
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                context: $(".action"),
                success: function (res) {
                    
                    if (res.code === 200) {
                        swal({
                            title: res.message,
                            text: "",
                            icon: "success",
                        }).then(function () {
                          return  window.location.href = '/browse-student';
                        });
                    } else {
                        swal({
                            title: res.message,
                            text: "Please Try Again",
                            icon: "error",
                        }).then(function () {
                          return  window.location.href = '/browse-student';
                        });
                    }
                }.bind(this),
                error: function (xhr, status, error) {
                    $("#result").html("An error occurred.");
                },
            });
        } else {
            swal({
                title: "Something Went Wrong",
                text: "Please Try Again",
                icon: "error",
            });
        }
    });
  
    
    $(".instlogincheck").on("click", function () {
        swal({
            title: "Please Login",
            text: "Click ok to Login",
            icon: "warning",
        }).then(function () {
            return  window.location.href = '/institute-login';
        });
      });

      $(".UpdatePassword").on("click", function (e) {
        e.preventDefault();
        $("#old_pass_error").hide();
        $("#new_pass_error").hide();
        $("#new_pass_error2").hide();
        $("#conf_pass_error1").hide();
        $("#conf_pass_error2").hide();
    
        var old_pass = $("#old_pass").val();
        var new_pass = $("#new_pass").val();
        var confirm_pass = $("#confirm_pass").val();
        var passwordRegex =
            /^(?=.*[a-zA-Z0-9])(?=.*[!@#$%^&*])(?=.{8,})[a-zA-Z0-9!@#$%^&*]+$/;
        if (old_pass === "") {
            $("#old_pass_error").show();
            return;
        }
        if (new_pass === "") {
            $("#new_pass_error").show();
            return;
        }
        if (!passwordRegex.test(new_pass)) {
            $("#new_pass_error2").show();
            return;
        }
        if (confirm_pass === "") {
            $("#conf_pass_error1").show();
            return;
        }
        if (confirm_pass != new_pass) {
            $("#conf_pass_error2").show();
            return;
        }
    
        var form = $("#changePassword").serialize();
        if (old_pass != "" && confirm_pass != "") {
            $("#loader").fadeIn();
            $.ajax({
                url: baseUrl + "pass-change",
                type: "POST",
                data: form,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    $("#loader").fadeOut();
                    if (response.code == 200) {
                        $("#changePassword")[0].reset();
                        swal({
                            title: response.message,
                            // text: "Please Login",
                            icon: "success",
                        });
                    } else {
                        swal({
                            title: response.message,
                            text: "Please Try Again",
                            icon: "error",
                        });
                    }
                },
            });
        }
    });
    

    $("#ContactSubmit").click(function (e) {
        $("#contactForm").validate({
            rules: {
                name: {
                   required: true,
                },
                email: {
                   required: true,
                   email: true,
                },
                subject: {
                   required: true,
                },
                message: {
                    required: true
                },
                country_code: {
                    required: true
                },
                contact_mobile: {
                    required: true
                },
    
            },
            messages: {
                name: {
                    required: 'Name is required',
                },
                email: {
                    required:'Email address is required',
                },
                subject: {
                    required: 'Subject is required.',
                },
                message: {
                    required: 'Message is required',
                },
                country_code: {
                    required: 'country code is required',
                },
                contact_mobile: {
                    required: 'mobile no. is required',
                },
            },
            submitHandler: function (form) {
                
                var formData = new FormData($("#contactForm")[0]);
                $('#loader').fadeIn();
                $.ajax({
                    type:"POST",
                    url: baseUrl + "mailEnquiry",
                    data: formData,
                    contentType: false,
                    processData:false,
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    success:function(data) {
                        $('#loader').fadeOut();
                      if (data.success) {
                        swal({
                           title: data.success,
                           icon: "success",
                         }).then(function () {
                             return  window.location.reload();
                         });
                    
                   } else {
       
                       swal({
                           title: data.error,
                           icon: "error",
                        }).then(function () {
                             return window.location.reload();
                         });
                   }
                  }
                });
            }
        });
    
    
    });

    $(document).on('click', '#pagination-college-course .pagination a', function(e) {
    
        const collegeidPageElement = document.getElementById('collegeid_page');
        const collegeId = collegeidPageElement.textContent.trim();
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var form = false; // Initialize form as false
        // form.append('page',page);
            loadCollegeCourseList(page,collegeId);
        
      });
    
      $("#newsletterSend").on("click", function (e) {
        e.preventDefault();
 
        $(".newmail_error").hide();

        var newsemail = $(".newsemail").val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (newsemail.trim() === "") {
            $(".newmail_error").show();
            return;
        }
        if (!emailRegex.test(newsemail)) {
            $(".newmail_error").show();
            return;
        }
        if (newsemail.trim() != "") {
            $("#loader").fadeIn();
            var form = $(".newsLetter").serialize();
            $.ajax({
                url: baseUrl + "newLetter",
                type: "POST",
                dataType: "json",
                data: form,
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (res) {
                    $("#loader").fadeOut();
                    if (res.code == 200) {
                        $(".newsemail").val("");
                        // console.log(res.message);
                        swal({
                            title: res.message,
                            text: "We will Send you our Newsletters Update.",
                            icon: "success",
                        });
                    } else {
                        swal({
                            title: res.message,
                            text: "Please Try Again with Valid Email !!!",
                            icon: "error",
                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error(error);
                    $("#result").html("An error occurred.");
                },
            });
        } else {
            $(".newmail_error").show();
            return;
        }
    });
  
    
    
});
function loadCollegeCourseList(page,collegeId)
{   
  
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $('.college-courses-page-main').empty();
   
    $.ajax({
        type: 'GET',
        url: collegeId+'?page='+page,
        contentType: false,
        processData:false,
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function(data) {
            
          console.log(data.html);   
           $(".college-courses-page-main").html(data.html);
        }
    });
}