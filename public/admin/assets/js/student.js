$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var baseUrl = window.location.origin + "/";  
    var assets = window.location.origin + "/assets/";  
    var reader = new FileReader();  
    var img = new Image();

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
    
      $(".StudentProfile").on('click', function(e) {
  

        $('#studentprofile').validate({
          rules: {
            first_name: {
              required: true,
            },
            last_name: {
              required: true,
            },
            student_country:{
              required:true
            },
            dateofbirth :{
              required:true,
            },
            program_type:{
              required:true,
            },
            mode_of_study:{
              required:true,
            },
            'qualification_id[]':{
              required:true,
            },
            'college_country[]':{
              required:true,
            },
            'grade[]':{
              required:true,
            },
            'medium[]':{
              required : true
            },
            'year[]':{
              required : true
            },
            contact_city:{
              required:true,
            },
           
              // "name[]":{
              //   required:true,
              // },
              // "college_country[]":{
              //   required:true,
              // },
          },
          messages:
          {
            first_name: {
              required:'Please enter first name',
            },
            last_name: {
              required: 'Please enter last name.',
            },
            student_country:{
              required:  'Please select country.',
            },
            dateofbirth :{
              required:  'Please enter date of birth.',
            },
            program_type:{
              required:'Please select program type.',
            },
            mode_of_study:{
              required:'Please select mode of study type.' ,
            },
            'qualification_id[]':{
              required:  'Please select education.',
            },
            'college_country[]':{
              required: 'Please enter country.',
            },
            'grade[]':{
              required:'Please enter grade.',
            },
            'medium[]':{
              required: 'Please enter study medium.',
            },
            'year[]':{
              required : 'Please enter passing year.',
            },
            contact_city:{
              required : 'Please enter city.',
            },
            // student_resume: {
            //   required: 'Please select an pdf file.'
            // },
          },
          submitHandler: function (form) {
              var formData = new FormData($("#studentprofile")[0]);
              var csrfToken = $("#csrf_token").val();
              $("#loader").fadeIn();
              $.ajax({
                type: 'POST',
                url:  baseUrl + 'student/studentprofile',
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
                      text: "",
                      icon: "success",
                  }).then(function () {
                    window.location.href= '/student-profile';
                  });
                  }else{
                    swal({
                      title: data.error,
                      text: "",
                      icon: "error",
                    }).then(function () {
                    window.location.href= '/student-profile';
    
                    });
                  }
                 
                  
             
                }   
            });
          }
          });
      });
    
      
});