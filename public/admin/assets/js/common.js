

$(document).ready(function () {

  var csrfToken = $('meta[name="csrf-token"]').attr("content");

  var baseUrl = window.location.origin + "/";

  var assets = window.location.origin + "/assets/";

  var reader = new FileReader();

  var img = new Image();

  // user submit operatiom
  $(document).on("click", ".stlogincheck", function () {
    swal({
        title: "Please Login",
        text: "Click ok to Login",
        icon: "warning",
    }).then(function () {
        $("#studentlogin").modal('show');
    });
});


  $("#editUserSubmit").on('click', function (e) {

    $('#editUserForm').validate({

      rules: {

        name: {

          required: true,

        },

        email: {

          required: true,

          email: true

        },

        phone: {

          required: true,

          rangelength: [10, 12],

          number: true

        },

        address: {

          required: true,

        },

        user_type: {

          required: true,

        }



      },

      messages: {

        name: {

          required: 'Please enter Name.'

        },

        email: {

          required: 'Please enter Email Address.',

          email: 'Please enter a valid Email Address.',

        },

        phone: {

          required: 'Please enter Mobile No.',

          rangelength: 'Contact should be 10 digit number.'

        },

        address: {

          required: 'Please enter Address.'

        },

        user_type: {

          required: 'Please enter Address.'

        },



      },

      submitHandler: function (form) {

        var formData = new FormData($("#editUserForm")[0]);

        $.ajax({

          type: "POST",

          url: baseUrl + "user/update",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            return window.location.reload();

          }

        });

      }

    });

  });

  // institute submit operatiom

  $("#createInstituteSubmit").on('click', function(e) {   


    $.validator.addMethod('mypassword', function(value, element) {
      return this.optional(element) || (value.match(/[a-zA-Z]/) && value.match(/[0-9]/));
    },
     'Password should be Like e.g Abc@1234.');

      $('#addInstitute').validate({
          highlight: function (element, errorClass, validClass) {
              $(element).parents('.select2').removeClass('has-success').addClass('has-error'); 
          },
          unhighlight: function (element, errorClass, validClass) {
              $(element).parents('.select2').removeClass('has-error').addClass('has-success');
          },
          errorPlacement: function (error, element) {
              if(element.hasClass('select2') && element.next('.select2-container').length) {
                  error.insertAfter(element.next('.select2-container'));
              } else if (element.parent('.input-group').length) {
                  error.insertAfter(element.parent());
              }
              else {
                  error.insertAfter(element);
              }
          },
          rules: {
            company_name: {
              required: true,
            },
            first_name: {
              required: true
            },
            last_name: {
              required: true
            },
            institute_email: {
              required: true,
              email: true,
              remote: {
                url: baseUrl + "user/checkemailunique",
                type: 'POST',
                headers: {
                  "X-CSRF-TOKEN": csrfToken,
                },
                data: {
                    email: function () {
                        return $('#institute_email').val();
                    },
                }
              }
            },
            institute_mobile: {
              required: true,
              number: true,
              remote: {
              url: baseUrl + "user/checkmobileunique",
              type: 'POST',
              headers: {
                "X-CSRF-TOKEN": csrfToken,
              },
              data: {
                  mobile: function () {
                      return $('#mobile').val();
                  },
              }
          }
            },
            institute_password: {
              required: true,
              minlength: 8,
              mypassword: true
            },
            confirm_password:{
              required: true,
              equalTo :"#institute_password"
            },
            country_id: {
              required: true
            },
          },
          messages: {
            company_name: {
              required: 'Please enter Institute Name.',
            },
            first_name: {
              required:'Please enter First Name.',
            },
            last_name: {
              required: 'Please enter Last Name.',
            },
            institute_email: {
              remote: 'Email is already taken.',
              required:'Please enter Email',
            },
            institute_mobile: {
              required: 'Please enter Mobile No.',
              remote: 'Mobile No. is already taken.',
            },
            institute_password: {
              required: 'Please enter Password.',
              minlength: 'Password should be Like e.g Abc@1234.',
              
            },
            confirm_password: {
              required: 'Please enter Confirm Password',
              equalTo: "Passwords do not match"
            },
            country_id:{
              required:'Please Select Country'
            }
          },
          submitHandler: function (form) {
              var formData = new FormData($("#addInstitute")[0]);
              $.ajax({
                  type:"POST",
                  url: baseUrl + "institute/store",
                  data: formData,
                  contentType: false,
                  processData:false,
                  headers: {
                      "X-CSRF-TOKEN": csrfToken,
                  },
                  success:function(data) {
                    $("#add-institute-modal").modal('hide');
                    if(data.success){
                      swal({
                        title: data.success,
                        icon: "success",
                      }).then(function () {
                        return  window.location.href = '/institute';
                      });
                    }else{
                      swal({
                        title: data.error,
                        icon: "error",
                      }).then(function () {
                        return  window.location.href = '/institute';
                      });
                    }
                   
                  }
              });
          }
      });
  }); 

  $('#DeleteInstitute').on('click', function (e) {

    var allVals = [];



    $(".sub_chk:checked").each(function () {

      allVals.push($(this).attr('data-id'));

    });

    if ($(this).attr('data-id') == undefined) {

      var deletevalue = $("#instituteId").val();

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

        url: baseUrl + "institute/deleteall",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'institute_ids=' + join_selected_values,

        success: function (data) {

          toastr.error(" Institute Deleted Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        },

        error: function (data) {

        }

      });

    }



  });

  $('#ApprovedInstitute').on('click', function (e) {

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

        url: baseUrl + "institute/approvedinstitute",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'institute_ids=' + join_selected_values,

        success: function (data) {

          toastr.success(" Institute Status Approved Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $('#RejectInstitute').on('click', function (e) {

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

        url: baseUrl + "institute/rejectinstitute",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'institute_ids=' + join_selected_values,

        success: function (data) {

          toastr.error(" Institute  Status Rejected Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $("#ImportInstitute").on('click', function (e) {

    $('#importInstitute').validate({

      rules: {

        customfile: {

          required: true,

        },

      },

      messages: {

        customfile: {

          required: 'Please select File.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#importInstitute")[0]);

        console.log(formData);

        $.ajax({

          type: "POST",

          url: baseUrl + "institute/importinstitute",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            return window.location.reload();

          }

        });

      }

    });

  });

  $("#EditInstitute").on('click', function (e) {

    $.validator.addMethod('brochureImage', function(value, element) {
      var maxSize = 2 * 1024 * 1024; 
      if (element.files.length > 0) {
          return element.files[0].size <= maxSize;
      }
      return true; // No file selected, so consider it valid
      }, 'File size must be less than 3  MB.');
      $.validator.addMethod('fileExtension', function(value, element, param) {
        param = typeof param === 'string' ? param.replace(/,/g, '|') : 'pdf';
        return this.optional(element) || value.match(new RegExp('.(' + param + ')$', 'i'));    
    }, 'Please choose a file pdf with a valid extension.');

    $('#editInstitute').validate({

      highlight: function (element, errorClass, validClass) {

        $(element).parents('.select2').removeClass('has-success').addClass('has-error');

      },

      unhighlight: function (element, errorClass, validClass) {

        $(element).parents('.select2').removeClass('has-error').addClass('has-success');

      },

      errorPlacement: function (error, element) {

        if (element.hasClass('select2') && element.next('.select2-container').length) {

          error.insertAfter(element.next('.select2-container'));

        } else if (element.parent('.input-group').length) {

          error.insertAfter(element.parent());

        }

        else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {

          error.insertAfter(element.parent().parent());

        }

        else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {

          error.appendTo(element.parent().parent());

        }

        else {

          error.insertAfter(element);

        }

      },

      rules: {

        company_name: {

          required: true

        },
        ownership:{

          required:true,
        },
        founded:{

          required:true
        },
        institute_campus : {

          required : true
        },
        institute_country : {

          required : true,
        },

        // full_name: {

        //   required: true

        // },

        // institute_email: {

        //   required: true,

        //   email: true

        // },

        // institute_mobile: {

        //   required: true,

        //   rangelength: [10, 12],

        //   number: true

        // },

        // institute_rmcode: {

        //   required: true

        // },

        company_type: {

          required: true

        },
        about_institute :{

          required : true
          
        },
        brochure: {
          brochureImage: true, // Custom rule for max file size
          fileExtension: 'pdf' // Custom rule for allowed extensions
        }

        
        // brochure :{

        //   required :true
        // }

      },

      messages: {

        company_name: {

          required: 'Please enter Institute Name.',

        },
        ownership : {

          required : 'Please select Ownership.',
        },
        founded :{

          required : 'Please enter Founded In'
        },
        institute_campus:{

          required : 'Please enter Campus' 
        },
        institute_country:{

          required : 'Please select Country'
        },

        // full_name: 'Please enter Name.',

        // institute_email: {

        //   required: 'Please enter Email Address.',

        //   email: 'Please enter a valid Email Address.',

        // },

        // institute_mobile: {

        //   required: 'Please enter Mobile No.',

        //   rangelength: 'Contact should be 10 digit number.'

        // },

        // institute_rmcode: {

        //   required: 'Please enter RM Code.',

        // },

        company_type: {

          required: 'Please select Institution Type.',

        },
        about_institute :{

          required : 'Please enter About Institute',

        },
        brochure :{

          required : 'Please select Brochure',
        }

      },

      submitHandler: function (form) {

        e.preventDefault();

        var formData = new FormData($("#editInstitute")[0]);

        $.ajax({

          type: "POST",

          url: baseUrl + "institute/update",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            swal({
              title: "Institute Updated Successfully.",
              icon: "success",
            }).then(function () {
              return  window.location.href = '/institute';
            });

          }

        });

      }



    });

  });

  $("#searchInstitute").keyup(function () {

    var keyword = $("#searchInstitute").val();

    $.ajax({

      url: baseUrl + "institute/index",

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      data: 'searchKeyword=' + keyword,

      success: function (data) {

        window.location.reload();

      }

    });

  });



  // country crud operation    

  $("#createCountrySubmit").on('click', function (e) {

    $("[class*='modal-backdrop in']").remove();

    $('#addCountry').validate({

      rules: {

        country_name: {

          required: true,

          remote: {

            url: baseUrl + "country/checkcountry",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              country_name: function () {

                return $('#country_name').val();

              },

            }

          }

        },

        country_code: {

          required: true,

          remote: {

            url: baseUrl + "country/checkcountry",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              country_code: function () {

                return $('#country_code').val();

              },

            }

          }

        },

        country_status: {

          required: true,

        },

        currency_symbol: {

          required: true

        },

      },

      messages: {

        country_name: {

          required: 'Please enter Country Name.',

          remote: 'Country Name is already taken.',

        },

        country_code: {

          required: 'Please enter Country Code.',

          remote: 'Country Code is already taken.',

        },

        country_status: {

          required: 'Please select Country Status.',

        },

        currency_symbol: {

          required: 'Please enter Currency Symbol.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#addCountry")[0]);

        const resourceUrl = baseUrl + 'country/store';

        $.ajax({

          type: 'POST',

          url: resourceUrl,

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {



            toastr.success(" Country Created Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 500);



          }

        });

      }

    });

  });

  $(document).on("click", ".open-EditCountry", function () {

    var countryId = $(this).data('id');

    $(".modal-body #countryId").val(countryId);

    $.ajax({

      url: baseUrl + "country/edit/" + countryId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #edit_country_name").val(data.CountryName);

        $(".modal-body #country_name_edit").val(data.CountryName);

        $(".modal-body #edit_country_code").val(data.CountryCode);

        $(".modal-body #country_code_edit").val(data.CountryCode);

        $(".modal-body #edit_currency_symbol").val(data.CurrencySymbol);

        $(".modal-body #edit_country_status option[value='" + data.ApprovalStatus + "']").attr("selected", true);



      }

    });



  });

  $("#editCountrySubmit").on('click', function (e) {

    $('#editCountry').validate({

      rules: {

        edit_country_name: {

          required: true,

          remote: {

            url: baseUrl + "country/checkcountry",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              country_name: function () {

                return $('#edit_country_name').val();

              },

              country_name_edit: function () {

                return $('#country_name_edit').val();

              },

            },

          }

        },

        edit_country_code: {

          required: true,

          remote: {

            url: baseUrl + "country/checkcountry",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              country_code: function () {

                return $('#edit_country_code').val();

              },

              country_code_edit: function () {

                return $('#country_code_edit').val();

              },

            },

          }

        },

        edit_country_status: {

          required: true

        },

        edit_currency_symbol: {

          required: true

        },

      },

      messages: {

        edit_country_name: {

          required: 'Please enter Country Name.',

          remote: 'Country Name is already taken.',



        },

        edit_country_code: {

          // required: 'Please enter Country Code.',

          remote: 'Country Code is already taken.',

        },

        edit_country_status: {

          required: 'Please select Country Status.',

        },

        edit_currency_symbol: {

          required: 'Please enter Currency Symbol.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#editCountry")[0]);

        $.ajax({

          type: 'POST',

          url: baseUrl + 'country/update',

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            toastr.success(" Country Edited Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 1000);

          }

        });

      }

    });

  });

  $(document).on("click", ".open-ViewCountry", function () {

    var countryId = $(this).data('id');

    $(".modal-body #countryId").val(countryId);

    $.ajax({

      url: baseUrl + "country/show/" + countryId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #view_country_name").html(data.CountryName);

        $(".modal-body #view_country_code").html(data.CountryCode);

        $(".modal-body #view_country_status").html(data.ApprovalStatus);

        $(".modal-body #view_currency_symbol").html(data.CurrencySymbol);



      }

    });



  });

  $('#DeleteCountry').on('click', function (e) {

    var allVals = [];



    $(".sub_chk:checked").each(function () {

      allVals.push($(this).attr('data-id'));

    });

    if ($(this).attr('data-id') == undefined) {

      var deletevalue = $("#countryId").val();

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

        url: baseUrl + "country/delete",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'country_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" Country Deleted Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        },

        error: function (data) {

        }

      });

    }

  });

  $('#ApprovedCountry').on('click', function (e) {

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

        url: baseUrl + "country/approvedcountry",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'country_id=' + join_selected_values,

        success: function (data) {

          toastr.success(" Country Status Approved Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $('#RejectCountry').on('click', function (e) {

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

        url: baseUrl + "country/rejectcountry",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'country_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" Country  Status Rejected Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $("#ImportCountry").on('click', function (e) {

    $('#importCountry').validate({

      rules: {

        customfile: {

          required: true,

        },

      },

      messages: {

        customfile: {

          required: 'Please select File.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#importCountry")[0]);

        console.log(formData);

        $.ajax({

          type: "POST",

          url: baseUrl + "country/importcountry",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 'true') {

              toastr.success(" Country Data Import Successfully.");

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





  // city crud operation



  $("#createCitiesSubmit").on('click', function (e) {

    $('#addCities').validate({

      rules: {

        city_name: {

          required: true,

          remote: {

            url: baseUrl + "cities/checkcities",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              city_name: function () {

                return $('#city_name').val();

              },

            }

          }

        },

        state_name: {

          required: true

        },

        city_status: {

          required: true

        },

      },

      messages: {

        city_name: {

          required: 'Please enter City Name.',

          remote: 'City Name is already taken.',

        },

        state_name: {

          required: 'Please select State Name.',

        },

        city_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#addCities")[0]);

        const resourceUrl = baseUrl + 'cities/store';

        $.ajax({

          type: 'POST',

          url: resourceUrl,

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {



            toastr.success(" Cities Created Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 500);



          }

        });

      }

    });

  });

  $(document).on("click", ".open-EditCities", function () {

    var cityId = $(this).data('id');

    $(".modal-body #cityId").val(cityId);

    $.ajax({

      url: baseUrl + "cities/edit/" + cityId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #edit_city_name").val(data.CityName);

        $(".modal-body #city_name_edit").val(data.CityName);

        $(".modal-body #edit_state_id option[value='" + data.StateID + "']").attr("selected", true);

        $(".modal-body #edit_city_status option[value='" + data.ApprovalStatus + "']").attr("selected", true);

      }

    });



  });

  $("#editCitiesSubmit").on('click', function (e) {

    $('#editCities').validate({

      rules: {

        edit_city_name: {

          required: true,

          remote: {

            url: baseUrl + "cities/checkcities",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              city_name: function () {

                return $('#edit_city_name').val();

              },

              city_name_edit: function () {

                return $('#city_name_edit').val();

              },

            },

          }

        },

        edit_state_id: {

          required: true

        },

        edit_city_status: {

          required: true

        },

      },

      messages: {

        edit_city_name: {

          required: 'Please enter City Name.',

          remote: 'City Name is already taken.',

        },

        edit_state_id: {

          required: 'Please select State.',

        },

        edit_city_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#editCities")[0]);

        $.ajax({

          type: 'POST',

          url: baseUrl + 'cities/update',

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 1) {

              toastr.success(" Cities Updated Successfully.");

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

  $(document).on("click", ".open-ViewCities", function () {

    var cityId = $(this).data('id');

    $(".modal-body #cityId").val(cityId);

    $.ajax({

      url: baseUrl + "cities/show/" + cityId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #view_city_name").html(data.CityName);

        $(".modal-body #view_state_name").html(data.StateName);

        $(".modal-body #view_city_status").html(data.ApprovalStatus);

      }

    });



  });

  $('#DeleteCities').on('click', function (e) {

    var allVals = [];

    $(".sub_chk:checked").each(function () {

      allVals.push($(this).attr('data-id'));

    });

    if ($(this).attr('data-id') == undefined) {

      var deletevalue = $("#cityId").val();

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

        url: baseUrl + "cities/delete",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'cities_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" Cities Deleted Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        },

        error: function (data) {

        }

      });

    }

  });

  $('#ApprovedCities').on('click', function (e) {

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

        url: baseUrl + "cities/approvedcities",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'cities_id=' + join_selected_values,

        success: function (data) {

          toastr.success(" Cities Status Approved Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $('#RejectCities').on('click', function (e) {

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

        url: baseUrl + "cities/rejectcities",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'cities_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" Cities Status Rejected Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $("#ImportCities").on('click', function (e) {

    $('#importCity').validate({

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

        var formData = new FormData($("#importCity")[0]);

        $.ajax({

          type: "POST",

          url: baseUrl + "cities/importcities",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 'true') {

              toastr.success(" Cities Data Import Successfully.");

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





  // state crud operation 

  $("#createStateSubmit").on('click', function (e) {

    $('#addState').validate({

      rules: {

        state_name: {

          required: true,

          remote: {

            url: baseUrl + "state/checkstate",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              state_name: function () {

                return $('#state_name').val();

              },

            }

          }

        },

        country_id: {

          required: true

        },

        state_status: {

          required: true

        },

      },

      messages: {

        country_id: {

          required: 'Please select Country.',

        },

        state_name: {

          required: 'Please enter State Name.',

          remote: 'State Name is already taken.',

        },

        state_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#addState")[0]);

        const resourceUrl = baseUrl + 'state/store';

        $.ajax({

          type: 'POST',

          url: resourceUrl,

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {



            toastr.success(" States Created Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 500);



          }

        });

      }

    });

  });

  $(document).on("click", ".open-EditState", function () {

    var stateId = $(this).data('id');

    $(".modal-body #stateId").val(stateId);

    $.ajax({

      url: baseUrl + "state/edit/" + stateId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #edit_state_name").val(data.StateName);

        $(".modal-body #state_name_edit").val(data.StateName);

        $(".modal-body #edit_country_id option[value='" + data.CountryID + "']").attr("selected", true);

        $(".modal-body #edit_state_status option[value='" + data.ApprovalStatus + "']").attr("selected", true);

      }

    });

  });


  $(document).on("click", ".fees_details", function () {
    var course_id = $(this).data('id');    
    $(".modal-body #course_id").val(course_id);

    $.ajax({
        url: baseUrl + "fees-details/" + course_id,
        type: 'GET',
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function (data) {              
            $(".modal-body #CourseFees").html(data.CourseFees);  
           // $(".modal-body #accommodation_certificate_cost").html(data.accommodation_certificate_cost);  
            $(".modal-body #AdministrativeCost").html(data.AdministrativeCost);  
            if (data.accommodation_certificate_cost) {
              $(".modal-body #accommodation_certificate_cost").html(data.accommodation_certificate_cost);
              $(".modal-body #accommodation_certificate_cost").closest('tr').show();  // Show the row
          } else {
              $(".modal-body #accommodation_certificate_cost").closest('tr').hide();  // Hide the row if no data
          }
            $(".modal-body #TotalCost").html(data.Currency + " " +  data.TotalCost);  
        },
        error: function(xhr, status, error) {
            console.error("Error fetching fee details:", error);
        }
    }); 
    $('#fess_details').modal('show');
});

  $("#editStateSubmit").on('click', function (e) {



    $('#editState').validate({

      rules: {

        edit_state_name: {

          required: true,

          remote: {

            url: baseUrl + "state/checkstate",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              state_name: function () {

                return $('#edit_state_name').val();

              },

              state_name_edit: function () {

                return $('#state_name_edit').val();

              },

            },

          }

        },

        edit_country_id: {

          required: true

        },

        edit_state_status: {

          required: true

        },

      },

      messages: {

        edit_country_id: {

          required: 'Please select Country.',

        },

        edit_state_name: {

          required: 'Please enter State Name.',

          remote: 'State Name is already taken.',



        },

        edit_state_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#editState")[0]);

        $.ajax({

          type: 'POST',

          url: baseUrl + 'state/update',

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 1) {

              toastr.success(" States Updated Successfully.");

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

  $(document).on("click", ".open-ViewState", function () {

    var stateId = $(this).data('id');

    $(".modal-body #stateId").val(stateId);

    $.ajax({

      url: baseUrl + "state/show/" + stateId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #view_state_name").html(data.StateName);

        $(".modal-body #view_country_id").html(data.CountryName);

        $(".modal-body #view_state_status").html(data.ApprovalStatus);

      }

    });



  });

  $('#DeleteStates').on('click', function (e) {

    var allVals = [];



    $(".sub_chk:checked").each(function () {

      allVals.push($(this).attr('data-id'));

    });

    if ($(this).attr('data-id') == undefined) {

      var deletevalue = $("#StateId").val();

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

        url: baseUrl + "state/delete",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'state_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" States Deleted Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        },

        error: function (data) {

        }

      });

    }

  });

  $('#ApprovedStates').on('click', function (e) {

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

        url: baseUrl + "state/approvedstate",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'state_id=' + join_selected_values,

        success: function (data) {

          toastr.success(" State Status Approved Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $('#RejectStates').on('click', function (e) {

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

        url: baseUrl + "state/rejectstate",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'state_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" State Status Rejected Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $("#ImportStates").on('click', function (e) {

    $('#importState').validate({

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

        var formData = new FormData($("#importState")[0]);

        $.ajax({

          type: "POST",

          url: baseUrl + "state/importstate",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 'true') {

              toastr.success(" State Data Import Successfully.");

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





  // student crud operation

  // $("#createStudentSubmit").on('click', function (e) {

  //   $.validator.addMethod('mypassword', function (value, element) {

  //     return this.optional(element) || (value.match(/[a-zA-Z]/) && value.match(/[0-9]/) && value.match(/[@#$%^&*!]/));

  //   },

  //     'Password should be Like e.g Abc@1234.');



  //   $('#addStudent').validate({

  //     highlight: function (element, errorClass, validClass) {

  //       $(element).parents('.select2').removeClass('has-success').addClass('has-error');

  //     },

  //     unhighlight: function (element, errorClass, validClass) {

  //       $(element).parents('.select2').removeClass('has-error').addClass('has-success');

  //     },

  //     errorPlacement: function (error, element) {

  //       if (element.hasClass('select2') && element.next('.select2-container').length) {

  //         error.insertAfter(element.next('.select2-container'));

  //       } else if (element.parent('.input-group').length) {

  //         error.insertAfter(element.parent());

  //       }

  //       else {

  //         error.insertAfter(element);

  //       }

  //     },

  //     rules: {

  //       first_name: {

  //         required: true,

  //       },

  //       last_name: {

  //         required: true

  //       },

  //       student_email: {

  //         required: true,

  //         email: true,

  //         remote: {

  //           url: baseUrl + "user/checkemailunique",

  //           type: 'POST',

  //           headers: {

  //             "X-CSRF-TOKEN": csrfToken,

  //           },

  //           data: {

  //             email: function () {

  //               return $('#student_email').val();

  //             },

  //           }

  //         }

  //       },

  //       student_mobile: {

  //         required: true,

  //         number: true

  //       },

  //       student_password: {

  //         required: true,

  //         minlength: 8,

  //         mypassword: true

  //       },

  //       student_photo: {

  //         required: true

  //       },

  //       current_location: {

  //         required: true

  //       },

  //       country_id: {

  //         required: true

  //       }



  //     },

  //     messages: {

  //       first_name: {

  //         required: 'Please enter First Name.',

  //       },

  //       last_name: {

  //         required: 'Please enter Last Name.',

  //       },

  //       student_email: {

  //         remote: 'Email is already taken.',

  //         required: 'Please enter email address',

  //       },

  //       student_mobile: {

  //         required: 'Please enter Mobile No.',

  //       },

  //       student_password: {

  //         required: 'Please enter Password.',

  //         minlength: 'Password should be Like e.g Abc@1234.',

  //       },

  //       student_photo: {

  //         required: 'Please Select File.',

  //       },

  //       current_location: {

  //         required: 'Please enter address.',

  //       },

  //       country_id: {

  //         required: 'Please select Country.',

  //       }



  //     },

  //     submitHandler: function (form) {

  //       var formData = new FormData($("#addStudent")[0]);

  //       $.ajax({

  //         type: "POST",

  //         url: baseUrl + "student/store",

  //         data: formData,

  //         contentType: false,

  //         processData: false,

  //         dataType: "json",

  //         headers: {

  //           "X-CSRF-TOKEN": csrfToken,

  //         },

  //         success: function (res) {

  //           if (res.code === 200) {
  //             swal({
  //                 title: res.message,
  //                 text: "",
  //                 icon: "success",
  //             }).then(function () {
  //               return  window.location.href = '/student';
  //             });
  //           } else {
  //             swal({
  //                 title: res.message,
  //                 text: "Please Try Again",
  //                 icon: "error",
  //             }).then(function () {
  //               return  window.location.href = '/student';
  //             });
  //           }

  //         }

  //       });

  //     }

  //   });

  // });
    // student crud operation
    $("#createStudentSubmit").on('click', function(e) {
      $.validator.addMethod('mypassword', function(value, element) {
        return this.optional(element) || (value.match(/[a-zA-Z]/) && value.match(/[0-9]/) && value.match(/[@#$%^&*!]/));
      },
       'Password should be Like e.g Abc@1234.');

      $('#addStudent').validate({
        highlight: function (element, errorClass, validClass) {
          $(element).parents('.select2').removeClass('has-success').addClass('has-error'); 
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).parents('.select2').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function (error, element) {
          if(element.hasClass('select2') && element.next('.select2-container').length) {
              error.insertAfter(element.next('.select2-container'));
          } else if (element.parent('.input-group').length) {
              error.insertAfter(element.parent());
          }
          else {
              error.insertAfter(element);
          }
        },
          rules: {
            first_name: {
              required: true,
            },
            last_name: {
              required: true
            },
            student_email: {
              required: true,
              email: true,
              remote: {
                url: baseUrl + "user/checkemailunique",
                type: 'POST',
                headers: {
                  "X-CSRF-TOKEN": csrfToken,
                },
                data: {
                    email: function () {
                        return $('#student_email').val();
                    },
                }
            }
            },
            student_mobile: {
              required: true,
              number: true
            },
            student_password: {
              required: true,
              minlength: 8,
              mypassword:true
            },
            confirm_password: {
              required: true,
              equalTo: "#student_password"
            },
            country_id:{
              required: true
            }
    
          },
          messages: {
            first_name: {
              required: 'Please enter First Name.',
            },
            last_name: {
              required: 'Please enter Last Name.',
            },
            student_email: {
                remote: 'Email is already taken.',
                required:'Please enter email address',
            },
            student_mobile: {
              required: 'Please enter Mobile No.',
            },
            student_password: {
              required: 'Please enter Password.',
              minlength: 'Password should be Like e.g Abc@1234.',
            },
            confirm_password: {
              required: 'Please enter Confirm Password',
              equalTo: "Passwords do not match"
            },
            country_id:{
              required: 'Please select Country.',
            }
          
          },
          submitHandler: function (form) {
              var formData = new FormData($("#addStudent")[0]);
              $.ajax({
                  type:"POST",
                  url: baseUrl + "student/store",
                  data: formData,
                  contentType: false,
                  processData:false,
                  headers: {
                      "X-CSRF-TOKEN": csrfToken,
                  },
                  dataType: "json",
                  success:function(data) {
                    console.log(data.code);
                    if (data.code == 200) {
                      swal({
                          title: data.message,
                          text: "",
                          icon: "success",
                        }).then(function () {
                          return  window.location.href = '/student';
                        });
                    
                    } else {
                        swal({
                          title: data.message,
                          text: "Please Try Again",
                          icon: "error",
                        }).then(function () {
                          return  window.location.href = '/student';
                        });
                    }
                  }
              });
          }
      });
    }); 
//   $("#EditStudent").on('click', function(e) {
//     debugger
//     var validator = $('#UpdateStudent').validate({
//       highlight: function (element, errorClass, validClass) {
//         $(element).parents('.select2').removeClass('has-success').addClass('has-error'); 
//       },
//       unhighlight: function (element, errorClass, validClass) {
//         $(element).parents('.select2').removeClass('has-error').addClass('has-success');
//       },
//       errorPlacement: function (error, element) {
//         if(element.hasClass('select2') && element.next('.select2-container').length) {
//             error.insertAfter(element.next('.select2-container'));
//         } else if (element.parent('.input-group').length) {
//             error.insertAfter(element.parent());
//         }
//         else {
//             error.insertAfter(element);
//         }
//       },
//         rules: {
//           first_name: {
//             required: true,
//           },
//           last_name: {
//             required: true
//           },
//           student_mobile: {
//             required: true,
//             number: true
//           },
//           country_id:{
//             required: true
//           },
//           // gender:{
//           //   required: true
//           // },
//           // "qualification_id[]":{
//           //   required:true,
//           // },
//           // "qualification_types_id[]":{
//           //   required:true,
//           // },
//           // "name[]":{
//           //   required:true,
//           // },
//           // "college_country[]":{
//           //   required:true,
//           // },
//           // "medium[]":{
//           //   required:true,
//           // },
//           // "year[]":{
//           //   required:true,
//           // },
//           // "grade[]":{
//           //   required:true,
//           // }
  
  
//         },
//         messages: {
//           first_name: {
//             required: 'Please enter First Name.',
//           },
//           last_name: {
//             required: 'Please enter Last Name.',
//           },

//           student_mobile: {
//             required: 'Please enter Mobile No.',
//           },
//           country_id:{
//             required: 'Please select Country.',
//           },
//           // gender:{
//           //   required: 'Please select Gender.',
//           // },
//           // "qualification_id[]":{
//           //   required: 'Please select Education.',
//           // },
//           // "qualification_types_id[]":{
//           //   required: 'Please select Specialization.',
//           // },
//           // "name[]":{
//           //   required: 'Please enter Name.',
//           // },
//           // "college_country[]":{
//           //   required: 'Please select Country.',
//           // },
//           // "medium[]":{
//           //   required: 'Please enter Medium.',
//           // },
//           // "year[]":{
//           //   required: 'Please enter Year.',
//           // },
//           // "grade[]":{
//           //   required: 'Please enter Gender.',
//           // }
//         },
//       });
//         // submitHandler: function (form) {
//           if (validator.valid()) {

//               var formData = new FormData($("#UpdateStudent")[0]);
//               $.ajax({
//                   type:"POST",
//                   url: baseUrl + "student/update",
//                   data: formData,
//                   contentType: false,
//                   processData:false,
//                   headers: {
//                       "X-CSRF-TOKEN": csrfToken,
//                   },
//                   dataType: "json",
//                   success:function(data) {
              
        
//                   }
//               });
//         }
       
//     // });
//   // if($("#UpdateStudent").validate()){
    
//   //   var errorMessageElement = document.getElementById('error-message');
//   //   if (errorMessageElement.textContent) {
//   //       return false;
//   //   } else {
    
//   //       var profile_overviews = CKEDITOR.instances.profile_overview.getData();
//   //       var formData = new FormData($("#UpdateStudent")[0]);
//   //       formData.append('profile_overviews', profile_overviews);
//   //       $.ajax({
//   //           type:"POST",
//   //           url: baseUrl + "student/update",
//   //           data: formData,
//   //           contentType: false,
//   //           processData:false,
//   //           headers: {
//   //               "X-CSRF-TOKEN": csrfToken,
//   //           },
//   //           success:function(data) {
//   //             // return "gdf";
//   //             return  window.location.href = '/student';

//   //           }
//   //       });
//   //   }
//   // }
// });
$("#EditStudent").on('click', function(e) {

  $('#UpdateStudent').validate({
    highlight: function (element, errorClass, validClass) {
      $(element).parents('.select2').removeClass('has-success').addClass('has-error'); 
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents('.select2').removeClass('has-error').addClass('has-success');
    },
    errorPlacement: function (error, element) {
      if(element.hasClass('select2') && element.next('.select2-container').length) {
          error.insertAfter(element.next('.select2-container'));
      } else if (element.parent('.input-group').length) {
          error.insertAfter(element.parent());
      }
      else {
          error.insertAfter(element);
      }
    },
      rules: {
        first_name: {
          required: true,
        },
        last_name: {
          required: true
        },
        student_mobile: {
          required: true,
          number: true
        },
        country_id:{
          required: true
        },
        gender:{
          required: true
        },
        "qualification_id[]":{
          required:true,
        },
        "qualification_types_id[]":{
          required:true,
        },
        "name[]":{
          required:true,
        },
        "college_country[]":{
          required:true,
        },
        "medium[]":{
          required:true,
        },
        "year[]":{
          required:true,
        },
        "grade[]":{
          required:true,
        }


      },
      messages: {
        first_name: {
          required: 'Please enter First Name.',
        },
        last_name: {
          required: 'Please enter Last Name.',
        },

        student_mobile: {
          required: 'Please enter Mobile No.',
        },
        country_id:{
          required: 'Please select Country.',
        },
        gender:{
          required: 'Please select Gender.',
        },
        "qualification_id[]":{
          required: 'Please select Education.',
        },
        "qualification_types_id[]":{
          required: 'Please select Specialization.',
        },
        "name[]":{
          required: 'Please enter Name.',
        },
        "college_country[]":{
          required: 'Please select Country.',
        },
        "medium[]":{
          required: 'Please enter Medium.',
        },
        "year[]":{
          required: 'Please enter Year.',
        },
        "grade[]":{
          required: 'Please enter Gender.',
        }
      },
      submitHandler: function (form) {
     
            var formData = new FormData($("#UpdateStudent")[0]);
            $.ajax({
                type:"POST",
                url: baseUrl + "student/update",
                data: formData,
                contentType: false,
                processData:false,
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                dataType: "json",
                success:function(data) {
                   if (data.code == 200) {
                    swal({
                        title: data.message,
                        text: "",
                        icon: "success",
                      }).then(function () {
                        return  window.location.href = '/students';
                      });
                  
                  } else {
                      swal({
                        title: data.message,
                        text: "Please Try Again",
                        icon: "error",
                      }).then(function () {
                        return  window.location.href = '/students';
                      });
                  }

                }
            });
        }
     
  });
// if($("#UpdateStudent").validate()){
  
//   var errorMessageElement = document.getElementById('error-message');
//   if (errorMessageElement.textContent) {
//       return false;
//   } else {
  
//       var profile_overviews = CKEDITOR.instances.profile_overview.getData();
//       var formData = new FormData($("#UpdateStudent")[0]);
//       formData.append('profile_overviews', profile_overviews);
//       $.ajax({
//           type:"POST",
//           url: baseUrl + "student/update",
//           data: formData,
//           contentType: false,
//           processData:false,
//           headers: {
//               "X-CSRF-TOKEN": csrfToken,
//           },
//           success:function(data) {
//             // return "gdf";
//             return  window.location.href = '/student';

//           }
//       });
//   }
// }
});
  $('#DeleteStudent').on('click', function (e) {

    var allVals = [];



    $(".sub_chk:checked").each(function () {

      allVals.push($(this).attr('data-id'));

    });

    if ($(this).attr('data-id') == undefined) {

      var deletevalue = $("#studentId").val();

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

        url: baseUrl + "student/delete",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'studentId=' + join_selected_values,

        success: function (data) {



          toastr.error("Students Deleted Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);



        },

        error: function (data) {

        }

      });

    }

  });

  $('#ApprovedStudent').on('click', function (e) {

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

        url: baseUrl + "student/approvedstudent",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'student_id=' + join_selected_values,

        success: function (data) {

          toastr.success(" Student Status Approved Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $('#RejectStudent').on('click', function (e) {

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

        url: baseUrl + "student/rejectstudent",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'student_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" Student Status Rejected Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $("#ImportStudents").on('click', function (e) {

    $('#importStudent').validate({

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

        var formData = new FormData($("#importStudent")[0]);

        $.ajax({

          type: "POST",

          url: baseUrl + "student/importstudent",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 'true') {

              toastr.success(" Student Data Import Successfully.");

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





  // language crud operation    

  $("#createLanguageSubmit").on('click', function (e) {

    $('#addLanguage').validate({

      rules: {

        language_name: {

          required: true,

          remote: {

            url: baseUrl + "language/checklanguage",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              language_name: function () {

                return $('#language_name').val();

              },

            }

          }

        },

        language_approval_status: {

          required: true

        },

      },

      messages: {

        language_name: {

          required: 'Please enter language.',

          remote: 'Language is already taken.',

        },

        language_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#addLanguage")[0]);

        const resourceUrl = baseUrl + 'language/store';

        $.ajax({

          type: 'POST',

          url: resourceUrl,

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            toastr.success(" Language Created Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 1000);

          }

        });

      }

    });

  });

  $(document).on("click", ".open-EditLanguage", function () {

    var languageId = $(this).data('id');

    $(".modal-body #languageId").val(languageId);

    $.ajax({

      url: baseUrl + "language/edit/" + languageId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #edit_language_name").val(data.Language);

        $(".modal-body #language_name_edit").val(data.Language);

        $(".modal-body #edit_approval_status option[value='" + data.ApprovalStatus + "']").attr("selected", true);

      }

    });

  });

  $("#editLanguageSubmit").on('click', function (e) {



    $('#editLanguage').validate({

      rules: {

        edit_language_name: {

          required: true,

          remote: {

            url: baseUrl + "language/checklanguage",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              language_name: function () {

                return $('#edit_language_name').val();

              },

              language_name_edit: function () {

                return $('#language_name_edit').val();

              },

            },

          }

        },

        edit_approval_status: {

          required: true

        },

      },

      messages: {

        edit_language_name: {

          required: 'Please enter Language .',

          remote: 'Language is already taken.'

        },

        edit_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#editLanguage")[0]);

        $.ajax({

          type: 'POST',

          url: baseUrl + 'language/update',

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 1) {

              toastr.success(" Language Updated Successfully.");

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

  $(document).on("click", ".open-ViewLanguage", function () {

    var languageId = $(this).data('id');

    $(".modal-body #languageId").val(languageId);

    $.ajax({

      url: baseUrl + "language/show/" + languageId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #view_language_name").html(data.Language);

        $(".modal-body #view_approval_status").html(data.ApprovalStatus);

      }

    });



  });

  $('#DeleteLanguage').on('click', function (e) {

    var allVals = [];

    $(".sub_chk:checked").each(function () {

      allVals.push($(this).attr('data-id'));

    });

    if ($(this).attr('data-id') == undefined) {

      var deletevalue = $('#languageId').val();

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

        url: baseUrl + "language/delete",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'languageId=' + join_selected_values,

        success: function (data) {

          toastr.error(" Language Deleted Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        },

        error: function (data) {

        }

      });

    }

  });

  $('#ApprovedLanguage').on('click', function (e) {

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

        url: baseUrl + "language/approvedlanguage",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'language_id=' + join_selected_values,

        success: function (data) {

          toastr.success(" Language Status Approved Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $('#RejectLanguage').on('click', function (e) {

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

        url: baseUrl + "language/rejectlanguage",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'language_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" Language Status Rejected Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $("#ImportLanguages").on('click', function (e) {

    $('#importLanguage').validate({

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

        var formData = new FormData($("#importLanguage")[0]);

        $.ajax({

          type: "POST",

          url: baseUrl + "language/importlanguage",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 'true') {

              toastr.success(" Language Data Import Successfully.");

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







  // duration crud operation    

  $("#createDurationSubmit").on('click', function (e) {

    $('#addDuration').validate({

      rules: {

        duration_name: {

          required: true,

          remote: {

            url: baseUrl + "duration/checkduration",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              duration_name: function () {

                return $('#duration_name').val();

              },

            }

          }

        },

        duration_approval_status: {

          required: true

        },

      },

      messages: {

        duration_name: {

          required: 'Please enter Durtion.',

          remote: 'Duration is already taken.',

        },

        duration_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#addDuration")[0]);

        const resourceUrl = baseUrl + 'duration/store';

        $.ajax({

          type: 'POST',

          url: resourceUrl,

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {



            toastr.success(" Duration Created Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 1000);

          }

        });

      }

    });

  });

  $(document).on("click", ".open-EditDuration", function () {

    var durationId = $(this).data('id');

    $(".modal-body #durationId").val(durationId);

    $.ajax({

      url: baseUrl + "duration/edit/" + durationId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #edit_duration_name").val(data.Duration);

        $(".modal-body #duration_name_edit").val(data.Duration);

        $(".modal-body #edit_approval_status option[value='" + data.ApprovalStatus + "']").attr("selected", true);

      }

    });

  });

  $("#editDurationSubmit").on('click', function (e) {

    $('#editDuration').validate({

      rules: {

        edit_duration_name: {

          required: true,

          remote: {

            url: baseUrl + "duration/checkduration",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              duration_name: function () {

                return $('#edit_duration_name').val();

              },

              duration_name_edit: function () {

                return $('#duration_name_edit').val();

              },

            },

          }

        },

        edit_approval_status: {

          required: true

        },

      },

      messages: {

        edit_duration_name: {

          required: 'Please enter Duration .',

          remote: 'Duration is already taken.'

        },

        edit_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#editDuration")[0]);

        $.ajax({

          type: 'POST',

          url: baseUrl + 'duration/update',

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 1) {

              toastr.success(" Duration Updated Successfully.");

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

  $(document).on("click", ".open-ViewDuration", function () {

    var durationId = $(this).data('id');

    $(".modal-body #durationId").val(durationId);

    $.ajax({

      url: baseUrl + "duration/show/" + durationId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #view_duration_name").html(data.Duration);

        $(".modal-body #view_approval_status").html(data.ApprovalStatus);

      }

    });



  });

  $('#DeleteDuration').on('click', function (e) {

    var allVals = [];

    $(".sub_chk:checked").each(function () {

      allVals.push($(this).attr('data-id'));

    });

    if ($(this).attr('data-id') == undefined) {

      var deletevalue = $('#durationId').val();

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

        url: baseUrl + "duration/delete",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'durationId=' + join_selected_values,

        success: function (data) {

          toastr.error(" Duration Deleted Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        },

        error: function (data) {

        }

      });

    }

  });

  $('#ApprovedDuration').on('click', function (e) {

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

        url: baseUrl + "duration/approvedduration",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'duration_id=' + join_selected_values,

        success: function (data) {

          toastr.success(" Duration Status Approved Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $('#RejectDuration').on('click', function (e) {

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

        url: baseUrl + "duration/rejectduration",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'duration_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" Duration Status Rejected Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $("#ImportDuration").on('click', function (e) {

    $('#importDuration').validate({

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

        var formData = new FormData($("#importDuration")[0]);

        $.ajax({

          type: "POST",

          url: baseUrl + "duration/importduration",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 'true') {

              toastr.success(" Duration Data Import Successfully.");

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



  // IntakeMonth crud operation    

  $("#createIntakemonthSubmit").on('click', function (e) {

    $('#addIntakemonth').validate({

      rules: {

        intakemonth_name: {

          required: true,

          remote: {

            url: baseUrl + "intakemonth/checkintakemonth",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              intakemonth_name: function () {

                return $('#intakemonth_name').val();

              },

            }

          }

        },

        intakemonth_approval_status: {

          required: true

        },

      },

      messages: {

        intakemonth_name: {

          required: 'Please enter Intake Month.',

          remote: 'Intakemonth is already taken.'

        },

        intakemonth_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#addIntakemonth")[0]);

        const resourceUrl = baseUrl + 'intakemonth/store';

        $.ajax({

          type: 'POST',

          url: resourceUrl,

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            toastr.success(" Intake Month Created Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 500);

          }

        });

      }

    });

  });

  $(document).on("click", ".open-EditIntakemonth", function () {

    var intakemonthId = $(this).data('id');

    $(".modal-body #intakemonthId").val(intakemonthId);

    $.ajax({

      url: baseUrl + "intakemonth/edit/" + intakemonthId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #edit_intakemonth_name").val(data.Intakemonth);

        $(".modal-body #intakemonth_name_edit").val(data.Intakemonth);

        $(".modal-body #edit_approval_status option[value='" + data.ApprovalStatus + "']").attr("selected", true);

      }

    });

  });

  $("#editIntakemonthSubmit").on('click', function (e) {

    $('#editIntakemonth').validate({

      rules: {

        edit_intakemonth_name: {

          required: true,

          remote: {

            url: baseUrl + "intakemonth/checkintakemonth",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              intakemonth_name: function () {

                return $('#edit_intakemonth_name').val();

              },

              intakemonth_name_edit: function () {

                return $('#intakemonth_name_edit').val();

              },

            },

          }

        },

        edit_approval_status: {

          required: true

        },

      },

      messages: {

        edit_intakemonth_name: {

          required: 'Please enter Intake Month .',

          remote: 'Intakemonth is already taken.'



        },

        edit_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#editIntakemonth")[0]);

        $.ajax({

          type: 'POST',

          url: baseUrl + 'intakemonth/update',

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 1) {

              toastr.success(" Intake Month Updated Successfully.");

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

  $(document).on("click", ".open-ViewIntakemonth", function () {

    var intakemonthId = $(this).data('id');

    $(".modal-body #intakemonthId").val(intakemonthId);

    $.ajax({

      url: baseUrl + "intakemonth/show/" + intakemonthId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #view_intakemonth_name").html(data.Intakemonth);

        $(".modal-body #view_approval_status").html(data.ApprovalStatus);

      }

    });



  });

  $('#DeleteIntakemonth').on('click', function (e) {

    var allVals = [];

    $(".sub_chk:checked").each(function () {

      allVals.push($(this).attr('data-id'));

    });

    if ($(this).attr('data-id') == undefined) {

      var deletevalue = $('#intakemonthId').val();

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

        url: baseUrl + "intakemonth/delete",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'intakemonthId=' + join_selected_values,

        success: function (data) {

          if (data == 1) {

            toastr.error(" intakemonth Deleted Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 1000);

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

  $('#ApprovedIntakemonth').on('click', function (e) {

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

        url: baseUrl + "intakemonth/approvedintakemonth",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'intakemonth_id=' + join_selected_values,

        success: function (data) {

          toastr.success(" Intakemonth Status Approved Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $('#RejectIntakemonth').on('click', function (e) {

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

        url: baseUrl + "intakemonth/rejectintakemonth",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'intakemonth_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" Intakemonth Status Rejected Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $("#ImportIntakemonths").on('click', function (e) {

    $('#importIntakemonth').validate({

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

        var formData = new FormData($("#importIntakemonth")[0]);

        $.ajax({

          type: "POST",

          url: baseUrl + "intakemonth/importintakemonth",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 'true') {

              toastr.success(" Intakemonth Data Import Successfully.");

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





  // IntakeYear  crud operation    

  $("#createIntakeyearSubmit").on('click', function (e) {

    $('#addIntakeyear').validate({

      rules: {

        intakeyear_name: {

          required: true,

          remote: {

            url: baseUrl + "intakeyear/checkintakeyear",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              intakeyear_name: function () {

                return $('#intakeyear_name').val();

              },

            }

          }

        },

        intakeyear_approval_status: {

          required: true

        },

      },

      messages: {

        intakeyear_name: {

          required: 'Please enter Intake Year.',

          remote: 'Intakeyear is already taken.'

        },

        intakeyear_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#addIntakeyear")[0]);

        const resourceUrl = baseUrl + 'intakeyear/store';

        $.ajax({

          type: 'POST',

          url: resourceUrl,

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {



            toastr.success(" Intake Year Created Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 1000);



          }

        });

      }

    });

  });

  $(document).on("click", ".open-EditIntakeyear", function () {

    var intakeyearId = $(this).data('id');

    $(".modal-body #intakeyearId").val(intakeyearId);

    $.ajax({

      url: baseUrl + "intakeyear/edit/" + intakeyearId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #edit_intakeyear_name").val(data.Intakeyear);

        $(".modal-body #intakeyear_name_edit").val(data.Intakeyear);

        $(".modal-body #edit_approval_status option[value='" + data.ApprovalStatus + "']").attr("selected", true);

      }

    });

  });

  $("#editIntakeyearSubmit").on('click', function (e) {

    $('#editIntakeyear').validate({

      rules: {

        edit_intakeyear_name: {

          required: true,

          remote: {

            url: baseUrl + "intakeyear/checkintakeyear",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              intakeyear_name: function () {

                return $('#edit_intakeyear_name').val();

              },

              intakeyear_name_edit: function () {

                return $('#intakeyear_name_edit').val();

              },

            },

          }

        },

        edit_approval_status: {

          required: true

        },

      },

      messages: {

        edit_intakeyear_name: {

          required: 'Please enter Intake Year .',

          remote: 'Intakeyear is already taken.'

        },

        edit_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#editIntakeyear")[0]);

        $.ajax({

          type: 'POST',

          url: baseUrl + 'intakeyear/update',

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 1) {

              toastr.success(" Intake Year Updated Successfully.");

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

  $(document).on("click", ".open-ViewIntakeyear", function () {

    var intakeyearId = $(this).data('id');

    $(".modal-body #intakeyearId").val(intakeyearId);

    $.ajax({

      url: baseUrl + "intakeyear/show/" + intakeyearId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #view_intakeyear_name").html(data.Intakeyear);

        $(".modal-body #view_approval_status").html(data.ApprovalStatus);

      }

    });



  });

  $('#DeleteIntakeyear').on('click', function (e) {

    var allVals = [];

    $(".sub_chk:checked").each(function () {

      allVals.push($(this).attr('data-id'));

    });

    if ($(this).attr('data-id') == undefined) {

      var deletevalue = $('#intakeyearId').val();

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

        url: baseUrl + "intakeyear/delete",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'intakeyearId=' + join_selected_values,

        success: function (data) {

          if (data == 1) {

            toastr.error(" Intakeyear Deleted Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 1000);

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

  $('#ApprovedIntakeyear').on('click', function (e) {

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

        url: baseUrl + "intakeyear/approvedintakeyear",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'intakeyear_id=' + join_selected_values,

        success: function (data) {

          toastr.success(" Intakeyear Status Approved Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $('#RejectIntakeyear').on('click', function (e) {

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

        url: baseUrl + "intakeyear/rejectintakeyear",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'intakeyear_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" Intakeyear Status Rejected Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $("#ImportIntakeyears").on('click', function (e) {

    $('#importIntakeyear').validate({

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

        var formData = new FormData($("#importIntakeyear")[0]);

        $.ajax({

          type: "POST",

          url: baseUrl + "intakeyear/importintakeyear",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 'true') {

              toastr.success(" Intakeyear Data Import Successfully.");

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



  // Course  crud operation    
 
  $("#CreateCourse").on('click', function (e) {
  
    $('#addCourse').validate({

      highlight: function (element, errorClass, validClass) {
        $(element).parents('.select2').removeClass('has-success').addClass('has-error');
      },
      
      errorPlacement: function (error, element) {
        if (element.hasClass('select2') && element.next('.select2-container').length) {
          error.insertAfter(element.next('.select2-container'));
        } else if (element.parent('.input-group').length) {
          error.insertAfter(element.parent());
        }
        else {
          error.insertAfter(element);
        }
        console.log(error.insertAfter(element));
      },
      ignore: [],  // Validate hidden elements

      rules: {

        // institute_id: {

        //   required: true,

        // },

        course_name: {

          required: true

        },
        specialization: {

          required: true

        },

        // course_duration: {

        //   required: true

        // },

        // country_id: {

        //   required: true

        // },

        course_fees: {

          required: true

        },

        administrative_cost: {

          required: true

        },
       
        // course_start_date: {

        //   required: true
        // },
        // course_expire_date :{

        //   required: true
        // },
        // qualification:{

        //   required:true 

        // },
        // age_limit: {

        //   required: true

        // },
        // course_intakemonth: {

        //   required: true

        // },
        // course_intakeyear : {

        //   required : true
        // },
        course_overview: {
          required: function() {
            CKEDITOR.instances.course_overview.updateElement();
            var editorContent = $('#course_overview').val();
            return editorContent.length === 0 || editorContent.trim() === '';
          }
        },
        course_curriculum: {
          required: function() {
            CKEDITOR.instances.course_curriculum.updateElement();
            var editorContent = $('#course_curriculum').val();
            return editorContent.length === 0 || editorContent.trim() === '';
          }
        },
        course_requirements: {
          required: function() {
            CKEDITOR.instances.course_requirements.updateElement();
            var editorContent = $('#course_requirements').val();
            return editorContent.length === 0 || editorContent.trim() === '';
          }
        },
        mode_of_study : {
          required : true
        },
        course_language : {
          required : true
        },
        course_types:{
          required : true,
        },
        course_category:{
          required : true
        },

      },

      messages: {

        institute_id: {

          required: 'Please  Institute.',

        },

        course_name: {

          required: 'Please enter Course.',

        },

        course_duration: {

          required: 'Please select Duration.',

        },

        country_id: {

          required: 'Please select Currency.',

        },

        course_fees: {

          required: 'Please enter Course Fees.',

        },

        administrative_cost: {

          required: 'Please enter Administrative Cost.',

        },
        specialization: {

          required: 'Please enter Specialization.',

        },
        course_start_date: {

          required: 'Please enter Course Start Date.',

        },
        course_expire_date :{

          required: 'Please enter Course Expire Date.',

        },
        qualification: {

          required: 'Please enter Qualification.',

        },
        course_intakemonth: {

          required: 'Please select Intake Month.',

        },
        age_limit: {

          required: 'Please enter Age Limit.',

        },
        course_intakeyear : {

          required: 'Please select Intake Year.',
        },
        course_overview: {

          required: "Please enter the course overview."
        },
        course_curriculum: {

          required: "Please enter the course curriculum."
        },
        course_requirements: {

          required: "Please enter the application procedure."
        },
        mode_of_study : {
          required : 'Please select Mode of Study.'
        },
        course_language : {
          required : 'Please select Language.'
        },
        course_types: {
          required: 'Please select Program Types.',
        },
        course_category:{
          required : 'Please select Course Category.'
        },
        unhighlight: function (element, errorClass, validClass) {

          if ($(element).hasClass('select2') && $(element).next('.select2-container').length) {

            $(element).next('.select2-container').removeClass('select2-container-error');

          }

        },

      },

      submitHandler: function (form) {
        var formData = new FormData($("#addCourse")[0]);
        
        $.ajax({

          type: 'POST',
          url: baseUrl + 'course/store',
          data: formData,
          contentType: false,
          processData: false,
          dataType: "json",
          headers: {
            "X-CSRF-TOKEN": csrfToken,
          },

          success: function (res) {
            console.log(res);
            console.log(res.code);
            if (res.code === 200) {
              swal({
                  title: res.message,
                  text: "",
                  icon: "success",
              }).then(function () {
                return  window.location.href = '/course';
              });
            } else {
              swal({
                  title: res.message,
                  text: "Please Try Again",
                  icon: "error",
              }).then(function () {
                return  window.location.href = '/course';
              });
            }
          }

        });

      }

    });

    // });

  });

  $("#EditCourse").on('click', function (e) {
 
    $('#UpdateCourse').validate({
      
      highlight: function (element, errorClass, validClass) {

        $(element).parents('.select2').removeClass('has-success').addClass('has-error');

      },

      errorPlacement: function (error, element) {

        if (element.hasClass('select2') && element.next('.select2-container').length) {

          error.insertAfter(element.next('.select2-container'));

        } else if (element.parent('.input-group').length) {

          error.insertAfter(element.parent());

        }
        else {
          error.insertAfter(element);
        }
      },
     
      ignore: [],  // Validate hidden elements
      rules: {

        institute_id: {

          required: true,

        },

        course_name: {

          required: true

        },

        course_duration: {

          required: true

        },

        country_id: {

          required: true

        },

        course_fees: {

          required: true

        },

        administrative_cost: {

          required: true

        },
        course_types: {

          required: true

        },
        specialization: {

          required: true

        },
        course_start_date: {

          required: true
        },
        course_expire_date :{

          required: true
        },
        qualification:{

          required:true 

        },
        age_limit: {

          required: true

        },
        course_intakemonth: {

          required: true

        },
        course_intakeyear : {

          required : true
        },
        course_overview: {
          required: function() {
            var quillContent = quill3.root.innerHTML.trim();
            return quillContent === "<p><br></p>" || quillContent === "";
        }
        },
        course_curriculum: {
          required: function() {
            var quillContent = quill4.root.innerHTML.trim();
            return quillContent === "<p><br></p>" || quillContent === "";
        }
        },
        course_requirements: {
          required: function() {
            var quillContent = quill4.root.innerHTML.trim();
            return quillContent === "<p><br></p>" || quillContent === "";
        }
        },
        mode_of_study : {
          required : true
        },
        course_language : {
          required : true
        },
        course_category:{
          required : true,
        },


      },

      messages: {

        institute_id: {

          required: 'Please  Institute.',

        },

        course_name: {

          required: 'Please enter Course.',

        },

        course_duration: {

          required: 'Please select Duration.',

        },

        country_id: {

          required: 'Please select Currency.',

        },

        course_fees: {

          required: 'Please enter Course Fees.',

        },

        administrative_cost: {

          required: 'Please enter Administrative Cost.',

        },
        specialization: {

          required: 'Please enter Specialization.',

        },
        course_start_date: {

          required: 'Please enter Course Start Date.',

        },
        course_expire_date :{

          required: 'Please enter Course Expire Date.',

        },
        qualification: {

          required: 'Please enter Qualification.',

        },
        course_intakemonth: {

          required: 'Please select Intake Month.',

        },
        age_limit: {

          required: 'Please enter Age Limit.',

        },
        course_intakeyear : {

          required: 'Please select Intake Year.',
        },
        course_overview: {

          required: "Please enter the course overview."
        },
        course_curriculum: {

          required: "Please enter the course curriculum."
        },
        course_requirements: {

          required: "Please enter the application procedure."
        },
        mode_of_study : {
          required : 'Please select Mode of Study.'
        },
        course_language : {
          required : 'Please select Language.'
        },
        course_types: {
          required: 'Please select Program Types.',
        },
        course_category:{
          required : 'Please select Course Category.'
        },

      },

      submitHandler: function (form) {
        $("#loader").fadeIn();
        var formData = new FormData($("#UpdateCourse")[0]);

        $.ajax({

          type: 'POST',

          url: baseUrl + 'course/update',

          data: formData,

          contentType: false,

          processData: false,
          
          dataType: "json",

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (res) {
            // console.log(res.code);
            $("#loader").fadeOut();
            if (res.code === 200) {
              swal({
                  title: res.message,
                  text: "",
                  icon: "success",
              }).then(function () {
                return  window.location.href = '/admin/course';
              });
            } else {
              swal({
                  title: res.message,
                  text: "",
                  icon: "error",
              }).then(function () {
                return  window.location.href = '/admin/course';
              });
            }


          }

        });

      }

    });

    // });

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

            toastr.error("Course Deleted Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 1000);

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

  // $("#SearchCourse").on('click', function(e) { 

  //     var institute_id = $("#institute_id").val();

  //     var requestData = {

  //       institute_id: institute_id

  //     };

  //         // var formData = new FormData($("#UpdateCourse")[0]);

  //         $.ajax({

  //             type: 'POST',

  //             url:  baseUrl + 'course/search',

  //             data: JSON.stringify(requestData), // Convert the object to a JSON string

  //             contentType: 'application/json', // Set the content type to JSON

  //             processData:false,

  //             headers: {

  //                 "X-CSRF-TOKEN": csrfToken,

  //             },

  //             success:function(data) {

  //               return  window.location.href = '/course';

  //             }

  //         });





  //   // });

  // }); 







  // qualification crud operation

  $("#createQualificationSubmit").on('click', function (e) {

    $('#addQualification').validate({

      rules: {

        qualification_name: {

          required: true,

          remote: {

            url: baseUrl + "qualification/checkqualification",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              qualification_name: function () {

                return $('#qualification_name').val();

              },

            }

          }

        },

        qualification_approval_status: {

          required: true

        },

      },

      messages: {

        qualification_name: {

          required: 'Please enter Qualification.',

          remote: 'Qualification Name is already taken.'

        },

        qualification_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#addQualification")[0]);

        const resourceUrl = baseUrl + 'qualification/store';

        $.ajax({

          type: 'POST',

          url: resourceUrl,

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {



            toastr.success(" Qualification Created Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 1000);



          }

        });

      }

    });

  });

  $(document).on("click", ".open-EditQualification", function () {

    var qualificationId = $(this).data('id');

    $(".modal-body #qualificationId").val(qualificationId);

    $.ajax({

      url: baseUrl + "qualification/edit/" + qualificationId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #edit_qualification_name").val(data.Qualification);

        $(".modal-body #qualification_name_edit").val(data.Qualification);

        $(".modal-body #edit_approval_status option[value='" + data.ApprovalStatus + "']").attr("selected", true);

      }

    });

  });

  $("#editQualificationSubmit").on('click', function (e) {

    $('#editQualification').validate({

      rules: {

        edit_qualification_name: {

          required: true,

          remote: {

            url: baseUrl + "qualification/checkqualification",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              qualification_name: function () {

                return $('#edit_qualification_name').val();

              },

              qualification_name_edit: function () {

                return $('#qualification_name_edit').val();

              },

            },

          }

        },

        edit_approval_status: {

          required: true

        },

      },

      messages: {

        edit_qualification_name: {

          required: 'Please enter Qualification .',

          remote: 'Qualification Name is already taken.'

        },

        edit_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#editQualification")[0]);

        $.ajax({

          type: 'POST',

          url: baseUrl + 'qualification/update',

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 1) {

              toastr.success(" Qualification Updated Successfully.");

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

  $(document).on("click", ".open-ViewQualification", function () {

    var qualificationId = $(this).data('id');

    $(".modal-body #qualificationId").val(qualificationId);

    $.ajax({

      url: baseUrl + "qualification/show/" + qualificationId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #view_qualification_name").html(data.Qualification);

        $(".modal-body #view_approval_status").html(data.ApprovalStatus);

      }

    });



  });

  $('#DeleteQualification').on('click', function (e) {

    var allVals = [];

    $(".sub_chk:checked").each(function () {

      allVals.push($(this).attr('data-id'));

    });

    if ($(this).attr('data-id') == undefined) {

      var deletevalue = $('#qualificationId').val();

      if (deletevalue) {

        allVals.push(deletevalue);

      }

    }

    if (allVals.length <= 0) {
      
      $("#alert-modal").modal('show');
      $(".modal-body #checkiconcross").html("<i class='fa fa-times-circle'>");
      $(".modal-body #message").html(data.error);

      return false;

    }

    else {

      var join_selected_values = allVals.join(",");

      $.ajax({

        url: baseUrl + "qualification/delete",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'qualificationId=' + join_selected_values,

        success: function (data) {

          toastr.error(" Qualification Deleted Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        },

        error: function (data) {

        }

      });

    }

  });

  $('#ApprovedQualification').on('click', function (e) {

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

        url: baseUrl + "qualification/approvedqualification",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'qualification_id=' + join_selected_values,

        success: function (data) {

          toastr.success(" Qualification Status Approved Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $('#RejectQualification').on('click', function (e) {

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

        url: baseUrl + "qualification/rejectqualification",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'qualification_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" Qualification Status Rejected Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $("#ImportQualifications").on('click', function (e) {

    $('#importQualification').validate({

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

        var formData = new FormData($("#importQualification")[0]);

        $.ajax({

          type: "POST",

          url: baseUrl + "qualification/importqualification",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 'true') {

              toastr.success(" Qualification Data Import Successfully.");

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





  // qualification types crud operation
  $("#createQualificationTypesSubmit").on('click', function (e) {

    $('#addQualificationTypes').validate({

      rules: {

        qualification_id: {

          required: true,

        },

        qualificationtypes_name: {

          required: true,

          remote: {

            url: baseUrl + "qualificationtypes/checkqualificationtypes",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              qualificationtypes_name: function () {

                return $('#qualificationtypes_name').val();

              },

            }

          }

        },

        qualificationtypes_approval_status: {

          required: true

        },

      },

      messages: {

        qualification_id: {

          required: 'Please select Qualification.',

        },

        qualificationtypes_name: {

          required: 'Please enter Qualification Types.',

          remote: 'Qualification Types Name is already taken.'



        },

        qualificationtypes_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#addQualificationTypes")[0]);

        const resourceUrl = baseUrl + 'qualificationtypes/store';

        $.ajax({

          type: 'POST',

          url: resourceUrl,

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {



            toastr.success(" Qualification Types Created Successfully.");

            setTimeout(function () {

              window.location.reload();

            }, 1000);



          }

        });

      }

    });

  });

  $(document).on("click", ".open-EditQualificationTypes", function () {

    var qualificationtypesId = $(this).data('id');

    $(".modal-body #qualificationtypesId").val(qualificationtypesId);

    $.ajax({

      url: baseUrl + "qualificationtypes/edit/" + qualificationtypesId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #edit_qualification_id option[value='" + data.QualificationID + "']").attr("selected", true);

        $(".modal-body #edit_qualificationtypes_name").val(data.QualificationTypes);

        $(".modal-body #qualificationtypes_name_edit").val(data.QualificationTypes);

        $(".modal-body #edit_approval_status option[value='" + data.ApprovalStatus + "']").attr("selected", true);

      }

    });

  });

  $("#editQualificationTypesSubmit").on('click', function (e) {

    $('#editQualificationTypes').validate({

      rules: {

        edit_qualification_id: {

          required: true,

        },

        edit_qualificationtypes_name: {

          required: true,

          remote: {

            url: baseUrl + "qualificationtypes/checkqualificationtypes",

            type: 'POST',

            headers: {

              "X-CSRF-TOKEN": csrfToken,

            },

            data: {

              qualificationtypes_name: function () {

                return $('#edit_qualificationtypes_name').val();

              },

              qualificationtypes_name_edit: function () {

                return $('#qualificationtypes_name_edit').val();

              },

            },

          }

        },

        edit_approval_status: {

          required: true

        },

      },

      messages: {

        edit_qualification_id: {

          required: 'Please select Qualification.',

        },

        edit_qualificationtypes_name: {

          required: 'Please enter Qualification Types.',

          remote: 'Qualification Types Name is already taken.'

        },

        edit_approval_status: {

          required: 'Please select Status.',

        },

      },

      submitHandler: function (form) {

        var formData = new FormData($("#editQualificationTypes")[0]);

        $.ajax({

          type: 'POST',

          url: baseUrl + 'qualificationtypes/update',

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 1) {

              toastr.success(" Qualification Types Updated Successfully.");

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

  $(document).on("click", ".open-ViewQualificationTypes", function () {

    var qualificationtypesId = $(this).data('id');

    $(".modal-body #qualificationtypesId").val(qualificationtypesId);

    $.ajax({

      url: baseUrl + "qualificationtypes/show/" + qualificationtypesId,

      type: 'GET',

      headers: {

        "X-CSRF-TOKEN": csrfToken,

      },

      success: function (data) {

        $(".modal-body #view_qualification_id").html(data.Qualification);

        $(".modal-body #view_qualificationtypes_name").html(data.QualificationTypes);

        $(".modal-body #view_approval_status").html(data.ApprovalStatus);

      }

    });



  });

  $('#DeleteQualificationTypes').on('click', function (e) {

    var allVals = [];

    $(".sub_chk:checked").each(function () {

      allVals.push($(this).attr('data-id'));

    });

    if ($(this).attr('data-id') == undefined) {

      var deletevalue = $('#qualificationtypesId').val();

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

        url: baseUrl + "qualificationtypes/delete",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'qualificationtypesId=' + join_selected_values,

        success: function (data) {

          toastr.error(" Qualification Types Deleted Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        },

        error: function (data) {

        }

      });

    }

  });

  $('#ApprovedQualificationTypes').on('click', function (e) {

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

        url: baseUrl + "qualificationtypes/approvedqualificationtypes",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'qualificationtypes_id=' + join_selected_values,

        success: function (data) {

          toastr.success(" Qualification Types Status Approved Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $('#RejectQualificationTypes').on('click', function (e) {

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

        url: baseUrl + "qualificationtypes/rejectqualificationtypes",

        type: 'POST',

        headers: {

          "X-CSRF-TOKEN": csrfToken,

        },

        data: 'qualificationtypes_id=' + join_selected_values,

        success: function (data) {

          toastr.error(" Qualification Types Status Rejected Successfully.");

          setTimeout(function () {

            window.location.reload();

          }, 1000);

        }

      });

    }

  });

  $("#ImportQualificationTypes").on('click', function (e) {

    $('#importQualificationtypes').validate({

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

        var formData = new FormData($("#importQualificationtypes")[0]);

        $.ajax({

          type: "POST",

          url: baseUrl + "qualificationtypes/importqualificationtypes",

          data: formData,

          contentType: false,

          processData: false,

          headers: {

            "X-CSRF-TOKEN": csrfToken,

          },

          success: function (data) {

            if (data == 'true') {

              toastr.success(" Qualification Types Data Import Successfully.");

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


  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });


  $("#InstituteProfile").on('click', function(e) {
 
   
    $.validator.addMethod('maxFilesAndSize', function(value, element, params) {
    
      if (element.files.length > params.maxFiles) {
          return false;
      }         
      for (var i = 0; i < element.files.length; i++) {
          var fileSize = element.files[i].size;
          var maxSize = 1 * 1024 * 1024;        
          if (fileSize > maxSize) {
              return false;
          }
      }
      return true;
  }, function(params, element) {
      return 'You can only upload up to 6 files, and each file must be less than 1MB in size.';
  });
  
  
      $.validator.addMethod('fileExtension', function(value, element, param) {
        param = typeof param === 'string' ? param.replace(/,/g, '|') : 'png|jpe?g';
        return this.optional(element) || value.match(new RegExp('.(' + param + ')$', 'i'));    
      }, 'Please choose a file jpeg,jpg,png with a valid extension.');

      $.validator.addMethod('brochureImage', function(value, element) {
            var maxSize = 2 * 1024 * 1024; // 2 MB in bytes
            if (element.files.length > 0) {
                return element.files[0].size <= maxSize;
            }
            return true; // No file selected, so consider it valid
            }, 'File size must be less than 2  MB.');

      $.validator.addMethod('fileExtensionbro', function(value, element, param) {
              param = typeof param === 'string' ? param.replace(/,/g, '|') : 'pdf';
              return this.optional(element) || value.match(new RegExp('.(' + param + ')$', 'i'));    
      }, 'Please choose a file pdf with a valid extension.');

      
  
    $('#instituteprofile').validate({

      rules: {  
        // 'gallery_images[]': {
        //     required: true,
        //     minlength: 1,
        // }
        company_name: {

          required: true

        },
        ownership:{

          required:true,
        },
        founded:{

          required:true
        },
        institute_campus : {

          required : true
        },
        institute_country : {

          required : true,
        },
        company_type: {

          required: true,
        },
        about_institute:{
          required : true
        },
        "gallery_images[]": {
          maxFilesAndSize: {
            maxFiles: 6
          },
          fileExtension: 'jpg,png,jpeg', // Custom rule for allowed extensions
        },
        brochure: {
            brochureImage: true, // Custom rule for max file size
            fileExtensionbro: 'pdf' // Custom rule for allowed extensions
        },
        institute_city:{
          required : true
        },
        contact_email:{
          required : true
        }
    },
    messages: {
        // 'gallery_images[]': {
        //     required: "Please select at least one image.",
        //     minlength: "Please select at least one image.",

        // }
        company_name: {

          required: 'Please enter Institute Name.',

        },
        ownership : {

          required : 'Please select Ownership.',
        },
        founded :{

          required : 'Please enter Founded In'
        },
        institute_campus:{

          required : 'Please enter Campus' 
        },
        institute_country:{

          required : 'Please select Country'
        },
        company_type: {

          required: 'Please select Institution Type.',

        },
        about_institute:{

          required : 'Please enter About  Institute.'

        },
        "gallery_images[]": {
          required: 'Please select an image file.',
          maxFiles: "You can only upload up to 6 images."
        },
        brochure: {
            required: 'Please select an pdf file.'
        },
        institute_city:{
          required : 'Please enter city'
        },
        contact_email:{
          required : 'Please enter Contact Email.'
        }
    },
    errorPlacement: function(error, element) {
        error.appendTo(element.parent()); // Display error message next to the file input
    },
    submitHandler: function (form) {
      $("#loader").fadeIn();
        var formData = new FormData($("#instituteprofile")[0]);
        $.ajax({
          type: 'POST',
          url:  baseUrl + 'instituteprofile',
          data: formData,
          contentType: false,
          processData:false,
          headers: {
              "X-CSRF-TOKEN": csrfToken,
          },
          success:function(data) {
            $("#loader").fadeOut();
            console.log(data);
            console.log('Code:', data.code);
            console.log('Type of Code:', typeof data.code);
            if (parseInt(data.code) === 200) {
              swal({
                  title: data.message,
                  text: "",
                  icon: "success",
              }).then(function () {
                return  window.location.href = '/institute-profile';
              });
            } else {
                swal({
                    title: 'Something went wrong',
                    text: "Please Try Again",
                    icon: "error",
                }).then(function () {
                  window.location.reload();
                });
            }
          }
        });
    }
    });
  });



  $("#InstituteRegister").on('click', function(e) {
    
    $("#passwordError").text("");
    $.validator.addMethod('mypassword', function(value, element) {
        return this.optional(element) || (value.match(/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/));
    },
    'Password should be Like e.g Abc@1234.');

    $.validator.addMethod('validEmail', function(value, element) {
      // Regular expression pattern to check for special characters
      var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      return this.optional(element) || pattern.test(value);
    }, 'Please enter a valid email address.');

    $('#instituteregister').validate({
      rules: {
        institute_name: {
          required: true,
        },
        first_name: {
          required: true
        },
        last_name: {
          required: true
        },
        email_address: {
          required: true,
          email: true,
          validEmail: true, 
          remote: {
            url: baseUrl + "user/checkemailunique",
            type: 'POST',
            headers: {
              "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                email: function () {
                    return $('#email_address').val();
                },
            }
          }
        },
        mobile: {
          required: true,
          number: true,
          remote: {
            url: baseUrl + "user/checkmobileunique",
            type: 'POST',
            headers: {
              "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                mobile: function () {
                    return $('#mobile').val();
                },
            },
            dataType: 'json',

          }
        },
        password: {
          required: true,
          minlength: 8,
          mypassword: true
        },
        country_id:{
          required:true,
        },
        confirm_password: {
          required: true,
          equalTo: "#password"
      },
      },
      messages: {
        institute_name: {
          required: 'Please enter Institute Name.',
        },
        first_name: {
          required:'Please enter First Name.',
        },
        last_name: {
          required:'Please enter Last Name.',
        },
        email_address: {
          remote: 'Email is already taken.',
          required:'Please enter Email',
          email: 'Please enter a valid email address.',
        },
        mobile: {
          remote: 'Mobile No. is already taken.',
          required: 'Please enter Mobile No.',
        },
        password: {
          required: 'Please enter Password.',
          minlength: 'Password should be Like e.g Abc@1234.',
        },
        confirm_password: {
          required: 'Please enter Confirm Password',
          equalTo: "Passwords do not match"
        },
        country_id: {
          required:'Please select Country.',
        },
      },
      submitHandler: function (form) {
        $(".modal-body #checkicon").html("");
        $(".modal-body #checkiconcross").html("");
        var formData = new FormData($("#instituteregister")[0]);
        $("#loader").fadeIn();
        $.ajax({
            type: 'POST',
            url:  baseUrl + 'institutesignup',
            data: formData,
            contentType: false,
            processData:false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success:function(data) {
              $("#loader").fadeOut();
              if(data.success){
                swal({
                  title: data.success,
                  icon: "success",
                }).then(function () {
                  return  window.location.href = '/institute-login';
                });
              }else{
                swal({
                  title: data.error,
                  icon: "error",
                }).then(function () {
                  return  window.location.href = '/institute-login';
                });
              }
            },
          
            
        });
      }
    });
   
  });

  $("#InstituteLogin").on('click', function(e) {
  
    $('#institute_login').validate({
      rules: {
        email: {
          required: true,
          email: true,
        },
        password: {
          required: true,
        },
      },
      messages:
      {
        email: {
          required:'Please enter Email',
        },
        password: {
          required: 'Please enter Password.',
        },
      },
      submitHandler: function (form) {
        $(".modal-body #checkicon").html("");
        $(".modal-body #checkiconcross").html("");
        var formData = new FormData($("#institute_login")[0]);
        $("#loader").fadeIn();
        $.ajax({
            type: 'POST',
            url:  baseUrl + 'institutelogin',
            data: formData,
            contentType: false,
            processData:false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success:function(data) {
              $("#loader").fadeOut();
              if(data.success){
                swal({
                  title: "Successfully Login.",
                  icon: "success",
                }).then(function () {
                  return  window.location.href = '/institute-profile';
                });
              }else{
                swal({
                  title: data.error,
                  icon: "error",
                }).then(function () {
                  return  window.location.href = '/institute-login';
                });
              }
            },
          
            
        });
      }
    });
   
  });


  $("#StudentRegister").on('click', function(e) {
   
    $("#passwordError").text("");
    $.validator.addMethod('mypassword', function(value, element) {
        return this.optional(element) || (value.match(/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/));
    },
    'Password should be Like e.g Abc@1234.');

    $.validator.addMethod('validEmail', function(value, element) {
      // Regular expression pattern to check for special characters
      var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      return this.optional(element) || pattern.test(value);
    }, 'Please enter a valid email address.');
    $('#studentregister').validate({
      rules: {
        first_name: {
          required: true,
          maxlength: 20,
        },
        last_name: {
          required: true,
          maxlength: 20,
        },
        email: {
          required: true,
          email: true,
          validEmail: true, // Custom rule for email validation
          remote: {
            url: baseUrl + "user/checkemailunique",
            type: 'POST',
            headers: {
              "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                email: function () {
                    return $('#email_address').val();
                },
            }
          }
        },
        
        mobile: {
          required: true,
          number: true,
          minlength:6,
          remote: {
            url: baseUrl + "user/stucheckmobileunique",
            type: 'POST',
            headers: {
              "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                mobile: function () {
                    return $('#mobile').val();
                },
            }
          }
        },
        password: {
          required: true,
          minlength: 8,
          mypassword: true
        },
        confirm_password: {
          required: true,
          equalTo: "#password"
        },
        student_country_id:{
          required:true,
        } 
      },
      messages: {
        first_name: {
          required:'Please enter First Name.',
          maxlength:"first name should be less than 20 characters."
        },
        last_name:{
          required:'Please enter Last Name.',
          maxlength:"Last name should be less than 20 characters."
        },
        email: {
          remote: 'Email is already taken.',
          email: 'Please enter a valid email address.',
          required:'Please enter Email',
        },
        mobile: {
          required: 'Please enter Mobile No.',
          remote: 'Mobile No. is already taken.'
        },
        password: {
          required: 'Please enter Password.',
          minlength: 'Password should be Like e.g Abc@1234.',
        },
        confirm_password: {
          required: 'Please enter Confirm Password.',
          equalTo: "Passwords do not match"
        },
        student_country_id: {
          required:'Please select Country.',
        }
      },
      submitHandler: function (form) {
        $(".modal-body #checkicon").html("");
        $(".modal-body #checkiconcross").html("");

        var formData = new FormData($("#studentregister")[0]);
        $("#loader").fadeIn();
        $.ajax({
            type: 'POST',
            url:  baseUrl + 'studentsignup',
            data: formData,
            contentType: false,
            processData:false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success:function(data) {
              $("#studentsignup").modal('hide');
              $("#loader").fadeOut();
              if(data.success){
                swal({
                  title: data.success,
                  text: "",
                  icon: "success",
                }).then(function () {
                $("#studentlogin").modal('show');
                });
              }else{
                swal({
                  title: data.error,
                  text: "",
                  icon: "success",
                }).then(function () {
                $("#studentsignup").modal('show');
                });
              }
            },
          
            
        });
      }
    });
   
  });
  // $("#CloseModal").on('click',function(){
  //   window.location.reload();
  // });

  $("#institute_view").on('click',function(){
    $("#institute_show_edit").css('display','block');
    $("#institute_view").css('display','none');
    $("#institute_profile_edit").css('display','none');
    $("#institute_edit").css('display','block');
  });
  $("#institute_edit").on('click',function(){
    $("#institute_profile_edit").css('display','block');
    $("#institute_edit").css('display','none');
    $("#institute_show_edit").css('display','none');
    $("#institute_view").css('display','block');
  });

    $("#PostCourse").on('click', function(e) {
     
      $.validator.addMethod('maxFileSize', function(value, element) {
      var maxSize = 3 * 1024 * 1024; // 2 MB in bytes
      if (element.files.length > 0) {
          return element.files[0].size <= maxSize;
      }
      return true; // No file selected, so consider it valid
      }, 'File size must be less than 3 MB.');
      $.validator.addMethod('fileExtension', function(value, element, param) {
        param = typeof param === 'string' ? param.replace(/,/g, '|') : 'pdf';
        return this.optional(element) || value.match(new RegExp('.(' + param + ')$', 'i'));    
      }, 'Please choose a file pdf with a valid extension.');

      $.validator.addMethod('maxFileSizeApp', function(valueApp, elementApp) {
        var maxSize = 2 * 1024 * 1024; // 2 MB in bytes
        if (elementApp.files.length > 0) {
            return elementApp.files[0].size <= maxSize;
        }
        return true; // No file selected, so consider it valid
        }, 'File size must be less than 2 MB.');
        $.validator.addMethod('fileExtensionApp', function(valueApp, elementApp, paramApp) {
          paramApp = typeof paramApp === 'string' ? paramApp.replace(/,/g, '|') : 'png|jpe?|pdf';
          
          return this.optional(elementApp) || valueApp.match(new RegExp('.(' + paramApp + ')$', 'i'));    
        }, 'Please choose a file jpeg,jpg,png,pdf with a valid extension.');


      $('#postcourse').validate({
        course_overview: {
          required: function() {
            var quillContent = quill3.root.innerHTML.trim();
            return quillContent === "<p><br></p>" || quillContent === "";
        }
        },
        course_curriculum: {
          required: function() {
            var quillContent = quill4.root.innerHTML.trim();
            return quillContent === "<p><br></p>" || quillContent === "";
        }
        },
        course_requirements: {
          required: function() {
            var quillContent = quill5.root.innerHTML.trim();
            return quillContent === "<p><br></p>" || quillContent === "";
        }

      },
        rules: {
          course_title:{
            required: true,
          },
          course_types:{
            required:true,
          },
          course_price:{
            required:true,
          },
          administrative_price:{
            required:true,
          },
          course_start_date:{
            required:true,
          },
          course_expire_date:{
            required:true,
          },
          currency_symbols:{
            required:true,
          },
          specialization:{
            required:true
          },
          mode_of_study :{
            required : true
          },
          course_duration :{
            required : true
          },
          course_intakemonth : {
            required : true
          },
          course_intakeyear :{
            required : true
          },
          course_language:{
            required : true
          },
          course_description :{
            required: true
          },
          course_category:{
            required : true
          },
          brochure: {
            maxFileSize: true, // Custom rule for max file size
            fileExtension: 'pdf' // Custom rule for allowed extensions
          },
          // },
          qualification :{
            required : true
          },
          application_form:{
            maxFileSizeApp : true,
            fileExtensionApp: 'jpg,png,jpeg,pdf' // Custom rule for allowed extensions
          },
          age_limit :{
            required : true
          },
          course_curriculum :{
            required : true
          },
          application_procedure:{
            required : true
          },
        },
        messages: {
          course_title:{
            required: 'Please enter Course Title.',
          },
          course_types:{
            required: 'Please select Program Type',
          },
          course_price:{
            required : 'Please enter Course Price',
          },
          administrative_price:{
            required : 'Please enter Administrative Price',
          },
          course_start_date:{
            required : 'Please enter Application Start Date',
          },
          course_expire_date:{
            required : 'Please enter Application Expire Date',
          },
          currency_symbols:{
            required : 'Please enter Currency',
          },
          specialization:{
            required: 'Please enter Specialization',
          },
          mode_of_study:{
            required: 'Please Select Mode Of Study'
          },
          course_duration :{
            required : 'Please select Course Duration'
          },
          course_intakemonth : {
            required : 'Please select Course Intake Month'
          },
          course_intakeyear :{
            required : 'Please select Course Intake Year'
          },
          course_language:{
            required : 'Please select Course Language'
          },
          course_description :{
            required : 'Please enter Course Description'
          },
          course_category:{
            required : 'Please select Course Category'
          },
           brochure: {
            required: 'Please select an image file.'
          },
          qualification :{
            required : 'Please select Qualification'
          },
          application_form:{
            required : 'Please select Application Form'
          },
          age_limit :{
            required : "Please enter Age Limit"
          },
          course_curriculum :{
            required : 'Please enter Course Curriculum'
          },
          application_procedure :{
            required : 'Please enter Application Procedure'
          },
        },
        submitHandler: function (form) {
          var formData = new FormData($("#postcourse")[0]);
          $('#loader').fadeIn();
              $.ajax({
                  type: 'POST',
                  url:  baseUrl + 'postcourse',
                  data: formData,
                  contentType: false,
                  processData:false,
                  headers: {
                      "X-CSRF-TOKEN": csrfToken,
                  },
                  success:function(data) {
                    $('#loader').fadeOut();
                    if(data.success){
                      swal({
                        title: data.success,
                        icon: "success",
                      }).then(function () {
                        return  window.location.href = '/institute-posted-course';
                      });
                    }else{
                      swal({
                        title: data.error,
                        icon: "error",
                      }).then(function () {
                        return false;
                      });
                    }
                  }
              });
        }
      });
    });

    $(".EditPostCourse").on('click', function(e) {
      $.validator.addMethod('maxFileSize', function(value, element) {
      var maxSize = 2 * 1024 * 1024; // 2 MB in bytes
      if (element.files.length > 0) {
          return element.files[0].size <= maxSize;
      }
      return true; // No file selected, so consider it valid
      }, 'File size must be less than 2 MB.');
      $.validator.addMethod('fileExtension', function(value, element, param) {
        param = typeof param === 'string' ? param.replace(/,/g, '|') : 'pdf';
        
        return this.optional(element) || value.match(new RegExp('.(' + param + ')$', 'i'));    
      }, 'Please choose a file pdf with a valid extension.');

      $.validator.addMethod('maxFileSizeApp', function(valueApp, elementApp) {
        var maxSize = 2 * 1024 * 1024; // 2 MB in bytes
        if (elementApp.files.length > 0) {
            return elementApp.files[0].size <= maxSize;
        }
        return true; // No file selected, so consider it valid
        }, 'File size must be less than 2 MB.');
        $.validator.addMethod('fileExtensionApp', function(valueApp, elementApp, paramApp) {
          paramApp = typeof paramApp === 'string' ? paramApp.replace(/,/g, '|') : 'png|jpe?|pdf';
          
          return this.optional(elementApp) || valueApp.match(new RegExp('.(' + paramApp + ')$', 'i'));    
        }, 'Please choose a file jpeg,jpg,png,pdf with a valid extension.');
  
        
      $('#editpostcourse').validate({
        rules: {
          course_title:{
            required: true,
          },
          course_types:{
            required:true,
          },
          course_price:{
            required:true,
          },
          administrative_price:{
            required:true,
          },
          course_start_date:{
            required:true,
          },
          course_expire_date:{
            required:true,
          },
          currency_symbols:{
            required:true,
          },
          specialization :{
            required:true
          },
          mode_of_study :{
            required : true
          },
          course_duration :{
            required : true
          },
          course_intakemonth : {
            required : true
          },
          course_language:{
            required : true
          },
          course_category:{
            required : true
          },
          course_intakeyear :{
            required : true
          },
          course_description :{
            required : true
          },
          qualification :{
            required : true
          },
          age_limit :{
            required : true
          },
          course_curriculum:{
            required : true
          },
          application_procedure:{
            required : true
          },
          brochure: {
            maxFileSize: true, // Custom rule for max file size
            fileExtension: 'pdf' // Custom rule for allowed extensions
          },
          application_form:{
            maxFileSizeApp : true,
            fileExtensionApp: 'jpg,png,jpeg,pdf' // Custom rule for allowed extensions
          },
        },
        messages: {
          course_title:{
            required: 'Please enter Course Title.',
          },
          course_types:{
            required: 'Please select Course Type',
          },
          course_price:{
            required : 'Please enter Course Price',
          },
          administrative_price:{
            required : 'Please enter Administrative Price',
          },
          course_start_date:{
            required : 'Please enter Course Date',
          },
          course_expire_date:{
            required : 'Please enter Course Expire Date',
          },
          currency_symbols:{
            required : 'Please enter Currency',
          },
          specialization :{
            required : 'Please enter Specialization'
          },
          mode_of_study:{
            required: 'Please Select Mode Of Study'
          },
          course_duration :{
            required : 'Please select Course Duration'
          },
          course_intakemonth : {
            required : 'Please select Course Intakemonth'
          },
          course_language:{
            required : 'Please select Course Language'
          },
          course_category:{
            required : 'Please select Course Category'
          },
          course_intakeyear :{
            required : 'Please select Course Intakeyear'
          },
          course_description :{
            required : 'Please enter Course Description'
          },
          qualification :{
            required : 'Please select Qualification'
          },
          age_limit :{
            required : "Please enter Age Limit"
          },
          course_curriculum:{
            required : "Please enter Course Curriculum"
          },
          application_procedure :{
            required : "Please enter Application Procedure"
          },
          brochure: {
            required: 'Please select an image file.'
          },
          application_form:{
            required : 'Please select Application Form'
          },
        },
        submitHandler: function (form) {
       
            var formData = new FormData($("#editpostcourse")[0]);
              $.ajax({
                  type: 'POST',
                  url:  baseUrl + 'edit_postcourse',
                  data: formData,
                  contentType: false,
                  processData:false,
                  headers: {
                      "X-CSRF-TOKEN": csrfToken,
                  },
                  success:function(data) {
                    if(data.success){
                      swal({
                        title: data.success,
                        icon: "success",
                      }).then(function () {
                        return  window.location.href = '/institute-posted-course';
                      });
                    }else{
                      swal({
                        title: data.error,
                        icon: "error",
                      }).then(function () {
                        return  window.location.href = '/institute-posted-course';
                      });
                    }
                
                  }
              });
        }
      });
    });
    
  

  $("#StudentLogin").on('click', function(e) {

    $('#student_login').validate({
      rules: {
        email: {
          required: true,
          email: true,
        },
        password: {
          required: true,
        },
      },
      messages:
      {
        email: {
          required:'Please enter Email',
        },
        password: {
          required: 'Please enter Password.',
        },
      },
      submitHandler: function (form) {
        $(".modal-body #checkicon").html("");
        $(".modal-body #checkiconcross").html("");
        var formData = new FormData($("#student_login")[0]);
        $("#loader").fadeIn();
        $.ajax({
            type: 'POST',
            url:  baseUrl + 'studentlogin',
            data: formData,
            contentType: false,
            processData:false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success:function(data) {
              $("#loader").fadeOut();
              $("#studentlogin").modal('hide');

              if(data.success){
                swal({
                  title: data.success,
                  icon: "success",
                }).then(function () {
                  return  window.location.href = '/student-profile';
                });           
              }else{
                swal({
                  title: data.error,
                  icon: "error",
                }).then(function () {
                  $("#studentlogin").modal('show');

                }); 
              }
            },
          
            
        });
      }
    });
   
  });



 
  


   
   
  $(document).on("click", ".actions", function () {

    var course = $(this).data("course_id");
    var action_txt = $(this).data("course_action");
    var is_toggle = $(this).data("is_toggle");
    var posted_by = $(this).data("posted_by");
    var dashjs = $(this).data("dashjs");
    var action = $(this).data("action");
    if (action_txt != "" && (course !== null) & (course !== 0)) {
      $("#loader").fadeIn();
        $.ajax({
            url: baseUrl + "students/course-action",
            type: "POST",
            dataType: "json",
            data: {
                course_id: course,
                action: action_txt,
                is_toggle: is_toggle,
                posted_by: posted_by,
            },
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            context: $(".action"),
            success: function (res) {
              $('#loader').fadeOut();
                if (res.code === 200) {
                  swal({
                      title: res.message,
                      text: "",
                      icon: "success",
                  }).then(function () {
                    return  window.location.reload();
                  });
                } else {
                    swal({
                        title: res.message,
                        text: "Please Try Again",
                        icon: "error",
                    }).then(function () {
                      return  window.location.reload();
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

  $('.collapse-header').click(function() {
    $(this).find('.toggle-icon').text(function(_, text) {
        return text === '-' ? '+' : '-'; // Change icon from "-" to "+" and vice versa
    });
  });
  



   $(".left_filters_course,.left_filters_courses").on(
    "change",
    "input[type='checkbox'], input[type='radio']",
    function (e) {
    e.preventDefault();
    if ($(window).width() <= 991) {
      var form = new FormData($(".left_filters_courses")[0]);
    }else{
    var form = new FormData($(".left_filters_course")[0]);
     }
    loadCourseList(form);

   });

  $(".profilePic").on("change", function () {
    $("#loader").fadeIn();
    var form = new FormData($(".proflilImage")[0]);
    var csrfTokens = $("#token_csrf").val();
    if(csrfTokens){
      csrfToken = csrfTokens;
    }
    $.ajax({
        url: "add-brochure-image",
        type: "POST",
        dataType: "json",
        data: form,
        contentType: false,
        processData: false,
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function (response) {
          $("#loader").fadeOut();
            if (response.code == 200) {
                swal({
                    title: response.message,
                    text: response.text,
                    icon: "success",
                  }).then(function () {
                      return  window.location.reload();
                  });
            } else {
                swal({
                    title: response.message,
                    text: response.text,
                    icon: "error",
                }).then(function () {
                  return  window.location.reload();
                });
            }
        },
        error: function (xhr, status, error) {
            // Handle errors
            console.error(error);
            $("#result").html("An error occurred.");
        },
    });
  });
  $(".bannerPic").on("change", function () {
    $("#loader").fadeIn();
    var form = new FormData($(".bannerImage")[0]);
    $.ajax({
        url: "add-brochure-image",
        type: "POST",
        dataType: "json",
        data: form,
        contentType: false,
        processData: false,
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function (response) {
          $("#loader").fadeOut();
            if (response.code == 200) {
                swal({
                    title: response.message,
                    text: response.text,
                    icon: "success",
                  }).then(function () {
                      return  window.location.href = '/institute-profile';
                  });
            } else {
                swal({
                    title: response.message,
                    text: response.text,
                    icon: "error",
                }).then(function () {
                    return  window.location.href = '/institute-profile';
                });
            }
        },
        error: function (xhr, status, error) {
            // Handle errors
            console.error(error);
            $("#result").html("An error occurred.");
        },
    });
  });

  // $(document).on('click', '#pagination-links .pagination a', function(e) {
 
  //   e.preventDefault();
  //   var page = $(this).attr('href').split('page=')[1];
  
  //   var form = false; // Initialize form as false
  //   var student_filter = $("#student_filter").val();
    
  //   if ($(".left_filters_course").length != 0) {
     
  //     var form = new FormData($(".left_filters_course")[0]);  
      
  //   }
  //   if ($(".left_filters_courses").length != 0) {
  //     var form = new FormData($(".left_filters_courses")[0]);
  //   }
  //   if ($(".left_filters_student").length != 0) {
  //     var form = new FormData($(".left_filters_student")[0]);
  //   }
  //   if ($(".left_filters_students").length != 0) {
  //     var form = new FormData($(".left_filters_students")[0]);
  //   }
  //   form.append('page',page);
    
  //   if (student_filter == undefined) {
     
  //     loadCourseList(form);
  //   }else{
  //     loadStudentList(form);
  //   }
  // });
  $(document).on('click', '#pagination-links .pagination a', function(e) {
    e.preventDefault();
    
    var page = $(this).attr('href').split('page=')[1];
  
    var form = null; 
    var student_filter = $("#student_filter").val();
     
    if ($(window).width() <= 991) {  
        if ($(".left_filters_courses").length != 0) {
            form = new FormData($(".left_filters_courses")[0]);
        }
    } else {  
        if ($(".left_filters_course").length != 0) {
            form = new FormData($(".left_filters_course")[0]);
        }
    }
    if ($(window).width() <= 991) { 
      if ($(".left_filters_students").length != 0) {
        var form = new FormData($(".left_filters_students")[0]);
      }
  } else {  
      if ($(".left_filters_student").length != 0) {
        var form = new FormData($(".left_filters_student")[0]);
      }
  }
   
    if (form) {
      form.append('page', page); 
  }

    if (student_filter == undefined) {
        loadCourseList(form);  
    } else {
        loadStudentList(form); 
    }
});

  $(".left_filters_student,.left_filters_students").on(
    "change",
    "input[type='checkbox'], input[type='radio']",
    function (e) {
    e.preventDefault();
   
    // if(form == ''){
      
    // }
    if ($(window).width() <= 991) {
      var form = new FormData($(".left_filters_students")[0]);
    }else{
      var form = new FormData($(".left_filters_student")[0]);
     }
    // console.log(form);
    loadStudentList(form);

   });

   
  $('#searchLocation,#searchDuration,#searchCategory,#searchProgramtype,#searchQualification,.searchCoursetitle').on('input', function() {
      searchLocation = $("#searchLocation").val();
      searchDuration = $("#searchDuration").val();
      searchCategory = $("#searchCategory").val();
      searchProgramtype = $("#searchProgramtype").val();
      searchQualification = $("#searchQualification").val();
      searchCoursetitle = $(".searchCoursetitle").val();


      $.ajax({
        type: 'POST',
        url: 'course/searchdata_filter',
        data: { 
            searchLocation: searchLocation,
            searchDuration:searchDuration,
            searchCategory:searchCategory,
            searchProgramtype:searchProgramtype,
            searchQualification:searchQualification,
            searchCoursetitle:searchCoursetitle
        },
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function(data) {
       
       
          $('#locationContainer').empty(); // Clear previous content
          $.each(data.Country, function(index, item) {
          
    
              $('#locationContainer').append('<li><input id="aa-location-'+item.CountryID+ '" class="checkbox-custom" name="location[]" value='+item.CountryID+' type="checkbox"</li><label for="aa-location-'+item.CountryID+'" class="checkbox-custom-label">'+item.CountryName+'</label>');
    
          });
          $('#durationContainer').empty(); // Clear previous content
          $.each(data.Duration, function(index, item) {
            
              $('#durationContainer').append('<li><input id="aa-duration-'+item.DurationID+ '" class="checkbox-custom" name="duration[]" value='+item.DurationID+' type="checkbox" </li><label for="aa-duration-'+item.DurationID+'" class="checkbox-custom-label">'+item.Duration+'</label>');
          });
          $('#programtypeContainer').empty(); // Clear previous content
          //console.log(data.Programtype);
          $.each(data.Programtype, function(index, item) {
              $('#programtypeContainer').append('<li><input id="aa-programtype-'+item.course_types_id+ '" class="checkbox-custom" name="programtype[]" value='+item.course_types_id+' type="checkbox"</li><label for="aa-programtype-'+item.course_types_id+'" class="checkbox-custom-label">'+item.course_types+'</label>');
          }); 

          $('#qualificationContainer').empty(); // Clear previous content
          $.each(data.Qualification, function(index, item) {
              $('#qualificationContainer').append('<li><input id="aa-qualification-'+item.QualificationID+ '" class="checkbox-custom" name="qualification[]" value='+item.QualificationID+' type="checkbox"</li><label for="aa-qualification-'+item.QualificationID+'" class="checkbox-custom-label">'+item.Qualification+'</label>');
          }); 
          
          $('#categoryContainer').empty(); // Clear previous content
          $.each(data.Category, function(index, item) {
              $('#categoryContainer').append('<li><input id="aa-category-'+item.id+ '" class="checkbox-custom" name="category[]" value='+item.id+' type="checkbox"</li><label for="aa-category-'+item.id+'" class="checkbox-custom-label">'+item.course_category+'</label>');
          }); 


          $('#course_title').css('display','block'); // Clear previous content
          $('#course_title').css('display','block'); // Clear previous content

          $("#course_title").empty();
          $.each(data.CourseTitle, function(index, item) {
            $("#course_title").append('<option value="' + item.CourseID + '">' + item.CourseName + '</option>');
          }); 
          
        }
     });
  });
 
  $('.searchLocation, .searchDuration, .searchCategory, .searchProgramtype , .searchQualification,.searchCoursetitle').on('input', function() {
      
    let searchLocation = $(".searchLocation").val();

    let searchDuration = $(".searchDuration").val();
 
    let searchCategory = $(".searchCategory").val();

    let searchProgramtype = $(".searchProgramtype").val();

    let searchQualification = $(".searchQualification").val();

    let searchCoursetitle = $(".searchCoursetitle").val();

    $.ajax({
        type: 'POST',
        url: 'course/searchdata_filter',
        data: { 
            searchLocation: searchLocation,
            searchDuration:searchDuration,
            searchCategory:searchCategory,
            searchProgramtype:searchProgramtype,
            searchQualification:searchQualification,
            searchCoursetitle:searchCoursetitle
        },
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function(data) {
       
          
          $('.locationContainer').empty(); // Clear previous content
          $.each(data.Country, function(index, item) {
          

              $('.locationContainer').append('<li><input id="aa-locations-'+item.CountryID+ '" class="checkbox-custom" name="location[]" value='+item.CountryID+' type="checkbox"</li><label for="aa-locations-'+item.CountryID+'" class="checkbox-custom-label">'+item.CountryName+'</label>');
         
          });
          $('.durationContainer').empty(); // Clear previous content
          $.each(data.Duration, function(index, item) {
            
              $('.durationContainer').append('<li><input id="aa-durations-'+item.DurationID+ '" class="checkbox-custom" name="duration[]" value='+item.DurationID+' type="checkbox" </li><label for="aa-durations-'+item.DurationID+'" class="checkbox-custom-label">'+item.Duration+'</label>');
          });

          $('.programtypeContainer').empty(); // Clear previous content
         // console.log(data.Programtype);
          $.each(data.Programtype, function(index, item) {
              $('.programtypeContainer').append('<li><input id="aa-programtype-'+item.course_types_id+ '" class="checkbox-custom" name="programtype[]" value='+item.course_types_id+' type="checkbox"</li><label for="aa-programtype-'+item.course_types_id+'" class="checkbox-custom-label">'+item.course_types+'</label>');
          }); 

          $('.qualificationContainer').empty(); // Clear previous content
          $.each(data.Qualification, function(index, item) {
              $('.qualificationContainer').append('<li><input id="aa-qualification-'+item.QualificationID+ '" class="checkbox-custom" name="qualification[]" value='+item.QualificationID+' type="checkbox"</li><label for="aa-qualification-'+item.QualificationID+'" class="checkbox-custom-label">'+item.Qualification+'</label>');
          }); 
          
          $('.categoryContainer').empty(); // Clear previous content
          $.each(data.Category, function(index, item) {
              $('.categoryContainer').append('<li><input id="aa-category-'+item.id+ '" class="checkbox-custom" name="category[]" value='+item.id+' type="checkbox"</li><label for="aa-category-'+item.id+'" class="checkbox-custom-label">'+item.course_category+'</label>');
          }); 


          $('#course_title').css('display','block'); // Clear previous content
          $('#course_title').css('display','block'); // Clear previous content

          $("#course_title").empty();
          // if(data.CourseTitle){
          //   $("#searchdiv").css('display','block');
          // }
          // $.each(data.CourseTitle, function(index, item) {
          //   $("#course_title").append('<li value="' + item.CourseID + '">' + item.CourseName + '</li>');
          // }); 
          $.each(data.CourseTitle, function(index, item) {
            $("#course_title").append('<option value="' + item.CourseID + '">' + item.CourseName + '</option>');
          }); 
          
        }
    });
  });

  $('.searchLocationstu, .searchProgramtypestu , .searchQualificationstu').on('input', function() {
        
    let searchLocation = $(".searchLocationstu").val().toLowerCase();
    let searchProgramtype = $(".searchProgramtypestu").val();
    let searchQualification = $(".searchQualificationstu").val();

    $.ajax({
        type: 'POST',
        url: 'student/searchdatastudent',
        data: { 
            searchLocation: searchLocation,
            searchProgramtype:searchProgramtype,
            searchQualification:searchQualification
        },
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function(data) {
       
          
          $('.locationContainer').empty(); // Clear previous content
          $.each(data.Country, function(index, item) {
              $('.locationContainer').append('<li><input id="aa-location-'+item.CountryID+ '" class="checkbox-custom" name="location[]" value='+item.CountryID+' type="checkbox"</li><label for="aa-location-'+item.CountryID+'" class="checkbox-custom-label">'+item.CountryName+'</label>');
          });
      
         $('.programtypeContainer').empty(); // Clear previous content
          $.each(data.Programtype, function(index, item) {
              $('.programtypeContainer').append('<li><input id="aa-programtype-'+item.course_types_id+ '" class="checkbox-custom" name="programtype[]" value='+item.course_types_id+' type="checkbox"</li><label for="aa-programtype-'+item.course_types_id+'" class="checkbox-custom-label">'+item.course_types+'</label>');
          }); 

          $('.qualificationContainer').empty(); // Clear previous content
          $.each(data.Qualification, function(index, item) {
              $('.qualificationContainer').append('<li><input id="aa-qualification-'+item.QualificationID+ '" class="checkbox-custom" name="qualification[]" value='+item.QualificationID+' type="checkbox"</li><label for="aa-qualification-'+item.QualificationID+'" class="checkbox-custom-label">'+item.Qualification+'</label>');
          }); 
          
        }
    });
  });

 $('#searchLocationstu, #searchProgramtypestu , #searchQualificationstu').on('input', function() {
        
    let searchLocation = $("#searchLocationstu").val().toLowerCase();
    let searchProgramtype = $("#searchProgramtypestu").val();
    let searchQualification = $("#searchQualificationstu").val();

    $.ajax({
        type: 'POST',
        url: 'student/searchdatastudent',
        data: { 
            searchLocation: searchLocation,
            searchProgramtype:searchProgramtype,
            searchQualification:searchQualification
        },
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function(data) {
       
          
          $('#locationContainer').empty(); // Clear previous content
          $.each(data.Country, function(index, item) {
              $('#locationContainer').append('<li><input id="aa-locations-'+item.CountryID+ '" class="checkbox-custom" name="location[]" value='+item.CountryID+' type="checkbox"</li><label for="aa-locations-'+item.CountryID+'" class="checkbox-custom-label">'+item.CountryName+'</label>');
          });
      
          $('#programtypeContainer').empty(); // Clear previous content
          $.each(data.Programtype, function(index, item) {
              $('#programtypeContainer').append('<li><input id="aa-programtypes-'+item.course_types_id+ '" class="checkbox-custom" name="programtype[]" value='+item.course_types_id+' type="checkbox"</li><label for="aa-programtypes-'+item.course_types_id+'" class="checkbox-custom-label">'+item.course_types+'</label>');
          }); 


          $('#qualificationContainer').empty(); // Clear previous content
          $.each(data.Qualification, function(index, item) {
              $('#qualificationContainer').append('<li><input id="aa-qualifications-'+item.QualificationID+ '" class="checkbox-custom" name="qualification[]" value='+item.QualificationID+' type="checkbox"</li><label for="aa-qualifications-'+item.QualificationID+'" class="checkbox-custom-label">'+item.Qualification+'</label>');
          }); 
          
        }
    });
  });

//   $("#resetPass").on("click", function () {
//     debugger
//     var form = $(".resetPassData").serialize();
//     $.ajax({
//         url: "reset-password-link",
//         type: "POST",
//         data: form,
//         dataType: "json",
//         headers: {
//             "X-CSRF-TOKEN": csrfToken,
//         },
//         success: function (res) {
//             if (res.code === 200) {
//               $(".resetPassData")[0].reset();    
//                 swal({
//                     title: res.message,
//                     text: "Please Check your mail Inbox",
//                     icon: "success",
//                 });
//             } else {

//                 swal({
//                     title: res.message,
//                     text: res.text,
//                     icon: "error",
//                  }).then(function () {
//                       return  window.location.href = '/institute-login';
//                   });
//             }
//         },
       
//     });
// });
$("#resetPass").on("click", function (e) {
  e.preventDefault(); 
  var formData  = $(this).closest(".resetPassData");
  var form = formData.serialize();;
  $("#loader").fadeIn();
  $.ajax({
      url: "reset-password-link",
      type: "POST",
      data: form,
      dataType: "json",
      headers: {
          "X-CSRF-TOKEN": csrfToken,
      },
      success: function (res) {
        $("#loader").fadeOut();
       
          if (res.code === 200) {

              $(".resetPassData")[0].reset();    
              swal({
                  title: res.message,
                  text: "Please Check your mail Inbox",
                  icon: "success",
              }).then(function () {

                window.location.href = '/institute-login';
            });
          } else {
              swal({
                  title: res.message,
                  text: res.text,
                  icon: "error",
              });
          }
      },
      error: function(xhr, status, error) {
          // Optionally handle AJAX errors here
          console.error(error);
      }
  });
});

$(".resetNewPassword").on("click", function () {
    $("#new_pass_error").hide();
    $("#new_pass_error2").hide();
    $("#conf_pass_error1").hide();
    $("#conf_pass_error2").hide();

    var new_pass = $("#new_pass").val();
    var confirm_pass = $("#confirm_pass").val();
    var passwordRegex =
        /^(?=.*[a-zA-Z0-9])(?=.*[!@#$%^&*])(?=.{8,})[a-zA-Z0-9!@#$%^&*]+$/;

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

    var form = $(".ChangePasswordData").serialize();
    $("#loader").fadeIn();
    $.ajax({
        url: baseUrl + "reset-password",
        type: "POST",
        dataType: "json",
        data: form,
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function (res) {
          console.log(res);
            $("#loader").fadeOut();
            if (res.code === 200) {
                swal({
                    title: res.message,
                    text: "Click Ok to Login",
                    icon: "success",
                }).then(function () {
                   
                    if (res.url == "institute-login") {
                      window.location = baseUrl + res.url; 
                  } else {
                      
                    $('#studentlogin').modal('show'); 
                  }
                });
            } else {
                swal({
                    title: res.message,
                    text: res.text,
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
});




});
function downloadBrochure(pdfUrl)
{
    var filename = pdfUrl.split('/').pop();
    fetch(pdfUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.blob();
    })
    .then(blob => {
        // Create a blob URL and initiate the download
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error('Error during download:', error);
    });
}
function loadCourseList(form)
{   
 
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $('#CourseFilterDisplayList').empty();
    $.ajax({
        type: 'POST',
        url: 'course/searchdata',
        data: form,
        contentType: false,
        processData:false,
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
        success: function(data) {         
        
           $("#CourseFilterDisplayList").html(data.html);
        }
    });
}
// function loadStudentList(form)
// {   
  
//     var csrfToken = $('meta[name="csrf-token"]').attr("content");
//     $('#StudentFilterDisplayList').empty();
//     $.ajax({
//         type: 'POST',
//         url: 'student/searchdatastudent',
//         data: form,
//         contentType: false,
//         processData:false,
//         headers: {
//             "X-CSRF-TOKEN": csrfToken,
//         },
//         success: function(data) {
          
         
//            $("#StudentFilterDisplayList").html(data.html);
//         }
//     });
// }
function loadStudentList(form) {   
  var csrfToken = $('meta[name="csrf-token"]').attr("content");
  $('#StudentFilterDisplayList').empty();

  // Log the form to ensure data is correct
  console.log("Sending Form Data: ", form);
  
  $.ajax({
      type: 'POST',
      url: 'student/searchdatastudent', // Ensure this URL is correct for student search
      data: form,
      contentType: false,
      processData: false,
      headers: {
          "X-CSRF-TOKEN": csrfToken,
      },
      success: function(data) {
          // Log the response to check what data we are getting back
          console.log("Response Data: ", data);
          
          // Replace the HTML with the returned data
          $("#StudentFilterDisplayList").html(data.html);
      },
      error: function(xhr, status, error) {
          console.error("Error during AJAX request:", error);
      }
  });
}
