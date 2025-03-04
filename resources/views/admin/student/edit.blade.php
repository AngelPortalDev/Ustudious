@extends('admin.layouts.main')
@section('css')
<style>  
.select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-selection__arrow {
    height: 34px !important;
}
.error{
    color:red;
}
 .card-header{
    background-color :#d8f3ff;
}
#pdfViewer {
    width: 100%;
    height: 100%;
    border: none; /* Remove the iframe border */
    overflow: scroll; /* Add both horizontal and vertical scrollbars */
}
.custom-file-button input[type=file] {
  margin-left: -2px !important;
}

.custom-file-button input[type=file]::-webkit-file-upload-button {
  display: none;
}

.custom-file-button input[type=file]::file-selector-button {
  display: none;
}

.custom-file-button:hover label {
  background-color: #dde0e3;
  cursor: pointer;
}
      
</style>
@endsection
@section('content')

<!-- Begin page -->
<div class="wrapper">
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="content-page student-pages">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <?php
                    $sub_title = "student";
                    $page_title = "Edit Student" ?>
                @include('admin.layouts.page-title')
                <!-- end row -->
                <div class="d-flex justify-content-sm-end"><a href="{{route('student')}}" class="btn btn-success" >Back</a></div>
                <BR>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h4 class="header-title">Edit Student   </h4>
                            </div>
                            <div class="card-body">
                                <form action="#" method="get" enctype="multipart/form-data" id="UpdateStudent">
                                    <input type="hidden" class="form-control" id="student_id" name="student_id" value="{{$StudentData->StudentID}}" placeholder="student id">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input class="form-control" type="text" id="first_name" name="first_name" value={{$StudentData->FirstName}} placeholder="First Name" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input class="form-control" type="text" id="last_name" name="last_name" required="" value={{$StudentData->LastName}} placeholder="Last Name">
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <label for="emailaddress" class="form-label">Email Address</label>
                                            <input class="form-control" type="email" id="student_email" name="student_email" required="" value={{$StudentData->Email}} placeholder="Email">
                                        </div>
                                       --}}
                                       <div class="col-md-4">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select st-country-code" name="gender">
                                            <option value="">Please select Gender </option>
                                            <option value="male" @if('male' == $StudentData->Gender) selected @endif>Male</option>
                                            <option value="female" @if('female' == $StudentData->Gender) selected @endif>Female</option>
                                        </select>
                                    </div>
                                    </div>
                                    <br>
                                    <div class="row g-2">
                                        
                                        <div class="col-md-4">
                                            <label>Date of Birth</label>
                                            <input type="date" class="form-control" name="dateofbirth" value="{{$StudentData->Dateofbirth}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="country_id" class="form-label">Country</label>
                                            <select class="form-select  mb-2 select2" name="country_id" id="country_id" required>
                                                <option value="">Select Country</option>
                                                @foreach ($countryData as $data)
                                                   <option value="{{ $data->CountryID }}" @if($data->CountryID == $StudentData->CountryID) selected @endif >{{ $data->CountryName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" class="form-control country_codes" id="country_codes" placeholder="Country Code" name="country_codes" value="{{$StudentData->CountryCode}}">
                                        <div class="col-md-4">
                                            <label for="mobile-number" class="form-label">Mobile Number</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control country_codes" id="country_code" placeholder="Country Code" name="country_code" value="{{$StudentData->CountryCode}}" disabled="">
                                                <input class="form-control" type="text" id="student_mobile" name="student_mobile" required="" placeholder="+1234567890" style="width: 70%;" value="{{$StudentData->Mobile}}">
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-3">
                                            <label for="current_location" class="form-label">Address</label>
                                            <input class="form-control" type="text" id="current_location" name="current_location" value="{{$StudentData->CurrentLocation}}" required="" placeholder="Location">
                                        </div> --}}

                                    </div>
                                    <br><br>
                                    <div class="card-header">
                                        <B class="header-title">Education Details</B>
                                    </div>
                                    <br>
                                    <table class="table table-bordered" id="dynamicTable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Highest Level of Education</th>
                                                <th>Specialization</th>
                                                <th>Name of College</th>
                                                <th>Country of Institution</th>
                                                <th>Study Medium</th>
                                                <th>Passing Year</th>
                                                <th>Grade/Percentage</th>
                                                <th><button type="button" name="add" id="addStudent" class="btn btn-success">Add More</button></th>
                                            </tr>
                                        <tbody>
                                            <?php
                                            if(count($StudentQualification) > 0){
                                            foreach ($StudentQualification as $key => $educData){
                                                
                                                ?>
                                            <tr>
                                                <td><input type="hidden" name="student_qualification_id[]" value="{{$educData->StudentQualificationID}}" data-id="145"></td>
                                                <td>
                                                    <select class="form-control select2 qualification" name="qualification_id[]"  id="qualification_id_{{$key}}" required>
                                                        <option value="">Select Qualification</option>
                                                        @foreach ($qualification_data as $data)
                                                        <option value="{{ $data->QualificationID }}" @if($data->QualificationID ==$educData->Qualification) selected @endif>{{ $data->Qualification }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="qualification_types_id[]" class="form-control select2 qualification_types" id="qualification_types_id_{{$key}}" required>
                                                        <option value="">Select Qualification</option>
                                                        <?php foreach ($qualification_types_data as $data){                                                                    
                                                                    if($data->QualificationID == $educData->Qualification){ ?>
                                                        <option value="{{ $data->QualificationTypesID }}" @if($data->QualificationTypesID == $educData->QualificationTypes) selected @endif>{{ $data->QualificationTypes }}</option>
                                                        <?php } }?>
                                                    </select></td>
                                                <td><input type="text" name="name[]" value="{{$educData->Name}}" placeholder="Enter your School/College/University Name" class="form-control" required /></td>
                                                <td>
													<select class="form-control select2 college_country" name="college_country[]" >
													@foreach ($countryData as $data)
													<option value="{{ $data->CountryID }}"  @if($data->CountryID == $educData->Country) selected @endif>{{ $data->CountryName }}</option>
													@endforeach
													</select>
                                                </td>
                                                <td><input type="text" name="medium[]" value="{{$educData->Medium}}" placeholder="Enter your Medium" class="form-control" required /></td>
                                                <td><input type="number" name="year[]" value="{{$educData->PassingYear}}" placeholder="Enter your Passing Year" class="form-control" required /></td>
                                                <td><input type="text" name="grade[]" value="{{$educData->PercentageGrade}}" placeholder="Enter your Grade" class="form-control" required /></td>
                                                <td><button type="button" class="btn btn-danger remove" id="removeStudent">Remove</button></td>
                                            </tr>

                                            <?php } }else{ ?>
                                            <tr>
                                                <td><input type="hidden" name="student_qualification_id[]" value=""></td>
                                                <td>
                                                    <select class="form-control select2 qualification" name="qualification_id[]" required>
                                                        <option value="">Select Education</option>
                                                        @foreach ($qualification_data as $data)
                                                        <option value="{{ $data->QualificationID }}">{{ $data->Qualification }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><select name="qualification_types_id[]" class="form-control select2 qualification_types" required></select></td>
                                                <td><input type="text" name="name[]" placeholder="School/College/University Name" class="form-control" required /></td>
                                                <td>
													<select class="form-control select2 college_country" name="college_country[]" required>
                                                        <option value="">Select Country</option>
													@foreach ($countryData as $data)
													<option value="{{ $data->CountryID }}" >{{ $data->CountryName }}</option>
													@endforeach
													</select>
                                                </td>
                                                <td><input type="text" name="medium[]" placeholder="Medium" class="form-control" value="" required /></td>
                                                <td><input type="text" name="year[]" placeholder="Passing Year" class="form-control" value="" required /></td>
                                                <td><input type="text" name="grade[]" placeholder="Grade" class="form-control" value="" required /></td>
                                               
                                                <td><button type="button" class="btn btn-danger remove" id="removeStudent">Remove</button></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                  
                                    {{-- <div class="row g-2">
                                        <div class="col-md-11">
                                            <label for="content">Overview:</label><br><br>
                                            <textarea id="profile_overview" name="profile_overview" rows="10" cols="50" required>{{$StudentData->ProfileOverview}}</textarea>
                                        </div>
                                    </div>
                                    <BR><br> --}}
                                    <div class="card-header">
                                        <B class="header-title">Contact Details</B>
                                    </div>
                                    <br>
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <label>Email Address</label>
                                            <input type="text" class="form-control" name="contact_email"  value="{{$StudentData->Email}}" >
                                        </div>

                                        <div class="col-md-3">
                                            <label> Preferred Select Country</label>
                                            <select class="form-control contact_countries" name="contact_countries" id="contact_countries">
                                                <option value="">Select Country</option>
                                                @foreach ($countryData as $data)
                                                <option value="{{ $data->CountryID }}" @if($data->CountryID == $StudentData->contact_country) selected @endif >{{ $data->CountryName }}</option>
                                             @endforeach
                                            </select>
                                        </div>
                                        
                                        {{-- <div class="form-group col-md-3">
                                            <div>
                                                <label>Mobile Number</label>
                                            </div>
                                            <div style="display:flex;">
                                                <input type="text" class="form-control contact_country_code"  placeholder="Country Code" name="contact_country_code" value="<?= $StudentData->contact_country_code ?>">
                                                <input type="text" class="form-control contact_country_code" placeholder="Country Code" name="contact_country_code" style="width: 23%;margin-right: 6PX;" value="<?= $StudentData->contact_country_code ?>" disabled>
                                               <input type="text" class="form-control" name="contact_mobile" value="<?= $StudentData->contact_mobile_no ?>">
                                            </div>
                                        </div> --}}
                                        {{-- <div class="form-group col-md-3">
                                            <label> Select State</label>
                                            <select class="form-control" name="contact_state" id="contact_state">
                                                <option value="">Select State</option>
                                                @foreach ($stateData as $data)
                                                    <option value="{{ $data->StateID }}" @if($data->StateID == $StudentData->state) selected @endif>{{ $data->StateName }}</option>
                                                @endforeach
                                            
                                            </select>
                                        </div> --}}
                                        <div class="form-group col-md-3">
                                            <label>City</label>
                                           
                                            <input type="text" class="form-control" name="contact_city"  value="{{$StudentData->city}}" >
                                            {{-- <select class="form-control" name="contact_city"  id="contact_city" >
                                                <option value="">Select City</option>
                                                @foreach ($cities as $data)
                                                    <option value="{{ $data->CityID }}" @if($data->CityID ==$StudentData->city) selected @endif>{{ $data->CityName }}</option>
                                                @endforeach
                                            
                                            </select> --}}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Zip Code</label>
                                            <input type="text" class="form-control" name="zipcode" value="{{$StudentData->zip_code}}" >
                                        </div>
                                    </div>
                                    <bR>
                                    <div class="row g-2">
                                        

                                        <div class="form-group col-md-3">
                                            <label>Zip Code</label>
                                            <input type="text" class="form-control" name="zipcode" value="{{$StudentData->zip_code}}" >
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address"  value="{{$StudentData->address}}">
                                        </div>
                                        
                                    </div>
                                    <br>
                                    <div class="card-header">
                                        <B class="header-title">Social Network </B>
                                    </div>
                                    <br>
                                    <div class="row g-2">
                                            <div class="col-md-4">
                                            <label>Facebook</label>
                                            <input type="text" class="form-control" name="facebook" value="{{$StudentData->facebook}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Instagram</label>
                                            <input type="text" class="form-control" name="instagram" value="{{$StudentData->instagram}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Linkedin</label>
                                            <input type="text" class="form-control" name="linkedin" value="{{$StudentData->linkedin}}">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="card-header">
                                        <h4 class="header-title">Documents</h4>
                                    </div>
                                    <br>
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <label for="idproof" class="form-label">Photo</label>
                                            <?php $filepath =  Storage::url('student/student_'.$StudentData->StudentID.'/'.$StudentData->Photo); ?>
                                            <img src="{{$filepath}}" alt="ID Proof" width="50%" height="50%">&nbsp;&nbsp;<br><br>
                                            <input type="file" id="student_photo" name="student_photo" class="form-control">

                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="col-md-5">
                                            <label for="idproof" class="form-label">Resume</label>
                                            <?php $filepath =  Storage::url('student/student_'.$StudentData->StudentID.'/'.$StudentData->Resume);
                                            $extension = pathinfo($filepath, PATHINFO_EXTENSION);
                                            if($StudentData->Resume){
                                            if($extension == 'pdf'){?>
                                            <iframe src="{{ $filepath }}" id="pdfViewers" frameborder="0"  width="100%" height="200px"></iframe>
                                            <?php }else{ ?>
                                              <img src="{{$filepath}}" width="50%" height="50%">
                                             <?php } ?>
                                            <?php } ?>
                                            &nbsp;&nbsp;<br><br>
                                            <input type="file" id="student_resume" name="student_resume" class="form-control">
                                                <span id="error-message" style="color: red;"></span>

                                        </div>
                                    </div>
                                    <br>

                                    <BR>
                                    <input type="submit" class="btn btn-primary" id="EditStudent" value="Submit">
                                </form>

                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
              
                <div id="delete-qualification-modal" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-body p-2">
                                <div style="float: right;">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="text-center">
                                    <i class="ri-information-line h1 text-info"></i>
                                    <h5 class="mt-2">Are you sure you want to delete this records?</h5>
                                    <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="DeleteQualification">Delete</button>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->     

            </div> <!-- container -->

        </div> <!-- content -->



    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

@endsection
@section('js')
<script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/common.js')}}"></script>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>



<!-- Initialize CKEditor on the textarea -->
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.select2').on('change', function() {
            $(this).valid();
        });
        $('.qualification').on('change', function() {
            var idQualification = $(this).val();
            var idName = $(this).attr('id');
            if(idName){
                var split_rowId = idName.split("_");
            }
            if (idQualification) {
                $.ajax({
                    type: "GET"
                    , url: "{{url('student/qualification_types')}}?qualification_id=" + idQualification
                    , success: function(res) {
                        if (res) {
                            if(split_rowId){
							    $('#qualification_types_id_' + split_rowId[2]).empty();
                            }else{
                                $(".qualification_types").empty();
                            }
                            $.each(res, function(key, value) {
                                if(split_rowId){
                                    $('#qualification_types_id_' + split_rowId[2] + '').append('<option value="' + key + '">' + value + '</option>');
                                    $('.qualification_types').valid();

                                }else{
                                    $(".qualification_types").append('<option value="' + key + '">' + value + '</option>');
                                    $('.qualification_types').valid();

                                }
                            });

                        } else {
                            $(".qualification_types").empty();
                        }
                    }.bind(this)
                });
            } else {
                $(".qualification_types").empty();

            }
        });
        $('#contact_countries').on('change', function () {
            var idCountry = this.value;
            $("#contact_state").html('');
            $.ajax({
                url: "{{url('institute/fetch-states')}}",
                type: "POST",
                data: {
                    country_id: idCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    console.log(result.countrycode[0]['CountryCode']);
                    $(".contact_country_code").val('+'+result.countrycode[0]['CountryCode']);
                    $('#contact_state').html('<option value="">-- Select State --</option>');
                    $.each(result.state, function (key, value) {
                        $("#contact_state").append('<option value="' + value
                            .StateID + '">' + value.StateName + '</option>');
                    });
                    $('#contact_city').html('<option value="">-- Select City --</option>');
                }
            });
  
        });
        $('#contact_state').on('change', function () {
            var idState = this.value;
            $("#contact_city").html('');
            $.ajax({
                url: "{{url('institute/fetch-city')}}",
                type: "POST",
                data: {
                    state_id: idState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#contact_city').html('<option value="">-- Select City --</option>');
                    $.each(res.cities, function (key, value) {
                        $("#contact_city").append('<option value="' + value
                            .CityID + '">' + value.CityName + '</option>');
                            // $('#cluster_id').append('<option value="'+data['cluster_id_primary']+'" '+ (area_id == data['cluster_id_primary'] ? ' selected ' : '') +'>'+data['cluster_name']+'</option>');


                    });
                }
            });
        });
        $('#country_id').on('change', function () {
            var idCountry = this.value;
            $.ajax({
                url: "{{url('institute/fetch-states')}}",
                type: "POST",
                data: {
                    country_id: idCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                  if(result.countrycode[0]['CountryCode']){
                    $("#country_code").val('+'+result.countrycode[0]['CountryCode']);
                     $(".country_codes").val('+'+result.countrycode[0]['CountryCode']);
                  }else{
                    $(".country_codes").val('');
                  }
                
                }
            });
        
        });

        $('#addStudent').on('click', function() {
            addRow();
        });


        var rowId = 0;

        function addRow() {
            rowId++;
            var tr = '<tr id="row_' + rowId + '">' + '<td><input type="hidden" name="student_qualification_id[]" value=""></td><td><select class="form-control select2 qualification_rowid" name="qualification_id[]"   id="qualification_id_' + rowId + '" ><option value="">-select-</option>@foreach ($qualification_data as $data)<option value="{{ $data->QualificationID  }}">{{ $data->Qualification }}</option>@endforeach</select></td>' +
                '<td><select name="qualification_types_id[]" id="qualification_types_id_' + rowId + '" class="form-control" required></select></td>' + '<td><input type="text" name="name[]" placeholder="School/College/University Name" id="name_' + rowId + '" class="form-control" required /></td>' + '<td><select class="form-control"  name="college_country[]" id="college_country_' + rowId + '" required><option value="">-select-</option>@foreach ($countryData as $data)<option value="{{ $data->CountryID  }}">{{ $data->CountryName }}</option>@endforeach</select></td>'+'<td><input type="text" name="medium[]" placeholder="Medium" class="form-control" required /></td>' + '<td><input type="text" name="year[]" placeholder="Passing Year" class="form-control" required /></td>' + '<td><input type="text" name="grade[]" placeholder="Grade" class="form-control"  required/></td>'  + '<td><button type="button" class="btn btn-danger remove" id="removeStudent">Remove</button></td>' + '</tr>';

            $('#dynamicTable').append(tr);
            $('#qualification_id_' + rowId).prop('required', true);
            $('#qualification_types_id_' + rowId + ', #qualification_id_' + rowId + ', #college_country_' + rowId).select2(); // Reinitialize Select2 for the new row

            $('#qualification_id_' + rowId + '').on('change', function() {
                var idQualification = $(this).val();
                var idName = $(this).attr('id');
                var split_rowId = idName.split("_");
               
                if (idQualification) {
                    $.ajax({
                        url: "{{url('student/qualification_types')}}?qualification_id=" + idQualification
                        , type: "GET"
                        , dataType: "json"
                        , success: function(data) {
                            $('#qualification_types_id_' + split_rowId[2] + '').empty();
                            // $('#qualification_types_id_' + rowId + '').append('<option>Qualification Types</option>');
                            $.each(data, function(key, value) {
                                $('#qualification_types_id_' + split_rowId[2] + '').append('<option value="' + key + '">' + value + '</option>');
                                $('.qualification_types').valid();


                            });
                        }
                    });
                } else {
                    $('#qualification_types_id_' + split_rowId[2] + '').empty();
                }
            });
        }

        $(document).on('click', '.remove', function() {

            if ($(this).parents('table').find('.remove').length > 1) { 
                
                var specificValue = $(this).closest('tr').find('td input').val();
                if(specificValue){
                    $("#delete-qualification-modal").modal('show');
                    
                    $('#DeleteQualification').on("click", function() {
                    
                        $.ajax({
                            url: "{{url('student/removequalification')}}",
                            type: "POST",
                            data: {
                                qualification_id: specificValue,
                                _token: '{{csrf_token()}}'
                            },
                            dataType: 'json',
                            success: function (result) {
                                toastr.error("Qualification Deleted Successfully.");  
                                setTimeout(function(){
                                    window.location.reload();
                                }, 500);
                            }
                        });

                    });     
                }    
                $(this).parent().parent().remove();
            } else {
                alert("Cannot remove the last element.");
            }
        });

   
    });


    document.addEventListener("DOMContentLoaded", function() {
        const canvases = document.querySelectorAll('.pdfCanvas');

        canvases.forEach(canvas => {
            const pdfData = atob(canvas.getAttribute('data-pdf'));
            const loadingTask = pdfjsLib.getDocument({ data: pdfData });

            loadingTask.promise.then(function(pdf) {
                pdf.getPage(1).then(function(page) {
                    const scale = 1.5;
                    const viewport = page.getViewport({ scale: scale });

                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };

                    page.render(renderContext);
                });
            });
        });
    });
    
     document.getElementById('student_resume').addEventListener('change', function() {
        const fileInput = this;
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes

        if (fileInput.files.length > 0) {
            const fileSize = fileInput.files[0].size;

            if (fileSize > maxSize) {
                document.getElementById('error-message').innerHTML = 'File size must be at most 5MB.';
                return false;
                // Optionally clear the file input
                // fileInput.value = '';
            } else {
                document.getElementById('error-message').innerHTML = '';
            }
        }
    });
    document.getElementById('UpdateStudent').addEventListener('submit', function(event) {
        const fileInputs = document.querySelectorAll('input[type="file"]');
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        let isValid = true;

        fileInputs.forEach(function(fileInput, index) {
            if (fileInput.files.length > 0) {
                const fileSize = fileInput.files[0].size;

                if (fileSize > maxSize) {
                    document.getElementById('error-message').innerHTML = `Error: File size of image ${index + 1} must be at most 5MB.`;
                    isValid = false;
                }
            }
        });

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if any file size exceeds the limit
        } else {
            document.getElementById('error-message').innerHTML = '';
        }
    });


</script>

@endsection
