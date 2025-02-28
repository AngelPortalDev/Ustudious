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
</style>
@endsection
@section('content')

    <!-- Begin page -->
    <div class="wrapper">
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page course-pages">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <?php
                    $sub_title = "Course";
                    $page_title = "Edit Course";?>
                    @include('admin.layouts.page-title')
                    <!-- end row -->
                    <div class="d-flex justify-content-sm-end"><a href="{{route('course')}}" class="btn btn-success" >Back</a></div>
                    <bR>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h4 class="header-title">Course Info</h4>
                                   
                                </div>
                                <div class="card-body">
                                <form action="#" enctype="multipart/form-data" id="UpdateCourse" >
                                        <div class="row g-2">
                                            <input type="hidden" class="form-control" id="course_id" name="course_id"  value="{{$Courses->CourseID}}" placeholder="institute id">

                                            <div class="col-md-3">
                                                <label for="fullname" class="form-label">Institute Name <span  style="color:red"> *</span></label>
                                                <select class="form-select  mb-2 select2" name="institute_id" id="institute_id">
                                                    <option value="">Select Institute</option>
                                                    @foreach ($instituteData as $data)
                                                        <option value="{{ $data->institute_id }}"  @if($data->institute_id ==$Courses->InstituteID) selected @endif>{{ $data->company_name }}</option>
                                                    @endforeach
                                                </select>  
                                            </div>
                                            <div class="col-md-3">
                                                <label for="course_name" class="form-label">Course Name <span  style="color:red"> *</span></label>
                                                <input type="text" class="form-control" id="course_name" placeholder="Course Name "  value="{{$Courses->CourseName}}" name="course_name">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="specialization" class="form-label">Specialization <span  style="color:red"> *</span> </label>
                                                <input type="text" class="form-control" id="specialization" placeholder="Specialization"  value="{{$Courses->Specialization}}" name="specialization">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="course_types" class="form-label">Program Type <span  style="color:red"> *</span> </label>
                                                <?php $courseTypeData =DB::table('course_types')->select('course_types_id','course_types')->distinct()->get();?>
                                                <select class="form-control" name="course_types" id="course_types">
                                                    <option value="">Select Program Type </option>
                                                    @foreach ($courseTypeData as $data)
                                                        <option value="{{ $data->course_types_id }}"  @if($data->course_types_id == $Courses->CourseType) selected @endif>{{ $data->course_types }}</option>
                                                    @endforeach
                                                </select>                                         
                                            </div>
                                        
                                        </div>
                                        
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-2">
                                                <label for="course_start_date" class="form-label">Mode of Study <span  style="color:red"> *</span></label>
                                                <select class="form-control mode_of_study" name="mode_of_study" required>
                                                    <option value="">Select Mode of Study</option>
                                                    <option value="part_time" @if($Courses->ModeofStudy ==  "part_time") selected @endif>Part Time</option>
                                                    <option value="full_time" @if($Courses->ModeofStudy == "full_time") selected @endif>Full Time</option>
                                                    <option value="distance" @if($Courses->ModeofStudy == "distance") selected @endif>Distance </option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="ects" class="form-label">ECTS</label>
                                                <input type="text" class="form-control" name="ects"  value="{{$Courses->Ects}}">
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <label for="mqf_level" class="form-label">MQF / EQF Level</label>
                                                <input type="text" class="form-control" name="mqf_level"  value="{{$Courses->MqfLevel}}">
                                            </div>
    
                                            <div class="col-md-3">
                                                <label>Course Start Date <span  style="color:red"> *</span> </label>
                                                <input type="date" class="form-control" name="course_start_date"  value="{{$Courses->CoursestartDate}}" required>
                                            </div>


                                            <div class="col-md-3">
                                                <label>Course Expire Date <span  style="color:red"> *</span></label>
                                                <input type="date" class="form-control" name="course_expire_date"  value="{{$Courses->CourseendDate}}" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-2">
                                                <label>Course Tag</label>
                                                <input type="text" class="form-control" placeholder="Course Tag" name="course_tag" value="{{$Courses->CourseTag}}">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="course_duration" class="form-label">Course Duration <span  style="color:red"> *</span></label>
                                                <select class="form-select mb-2 select2" name="course_duration" id="course_duration">
                                                    <option value="">Select Course Duration</option>
                                                    @foreach ($durationData as $data)
                                                        <option value="{{ $data->DurationID }}"  @if($data->DurationID ==$Courses->CourseDuration) selected @endif >{{ $data->Duration }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="course_language" class="form-label">Language <span  style="color:red"> *</span></label>
                                                <select class="form-select mb-2 select2" name="course_language" required>
                                                    <option value="">Select Language</option>
                                                    @foreach ($languageData as $data)
                                                        <option value="{{ $data->LanguageID }}"  @if($data->LanguageID ==$Courses->Language) selected @endif>{{ $data->Language }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="intake_month" class="form-label">Intake Month <span  style="color:red"> *</span> </label>
                                                <select class="form-select mb-2 select2" name="course_intakemonth" required>
                                                    <option value="">Select Intake Month</option>
                                                    @foreach ($intakemonthData as $data)
                                                        <option value="{{ $data->IntakemonthID }}"  @if($data->IntakemonthID ==$Courses->IntakeMonth) selected @endif>{{ $data->Intakemonth }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="intake_year" class="form-label">Intake Year <span  style="color:red"> *</span></label>
                                                <select class="form-select mb-2 select2" name="course_intakeyear" required>
                                                    <option value="">Select Intake year</option>
                                                    @foreach ($intakeyearData as $data)
                                                        <option value="{{ $data->IntakeyearID }}"  @if($data->IntakeyearID ==$Courses->IntakeYear) selected @endif>{{ $data->Intakeyear }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                           
                                            <div class="col-md-2">
                                                <label> Course Category <span  style="color:red"> *</span> </label>
                                                <?php  $categoryData =DB::table('course_category')->select('id','course_category')->distinct()->get();
                                                ?>
                                               <select class="form-control" name="course_category" required>
                                                   <option value="">Select Category</option>
                                                   @foreach ($categoryData as $data)
                                                       <option value="{{ $data->id }}"  @if($data->id == $Courses->CourseCategory) selected @endif>{{ $data->course_category }}</option>
                                                   @endforeach
                                               </select>
                                            </div>
                                        </div>
                                        <br>
                                        
                                        <div class="row g-2">
                                            <div class="col-md-2">
                                                <label for="country_id" class="form-label">Currency <span  style="color:red"> *</span></label>
                                                <select class="form-select  mb-2 select2" name="country_id" id="country_id">
                                                    <option value="">Select Currency</option>
                                                    @foreach ($countryData as $data)
                                                        <option value="{{ $data->CurrencySymbol }}"  @if($data->CurrencySymbol == $Courses->Currency) selected @endif>{{ $data->CurrencySymbol }}</option>
                                                    @endforeach
                                                </select>  
                                            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <div class="col-md-3">
                                                <input type="hidden" class="form-control currency_symbols" id="currency_symbols" placeholder="Currency Symbols" name="currency_symbols" style="width:20%" value="{{$Courses->Currency}}" >
                                                <label for="course_fees" class="form-label">Fees <span  style="color:red"> *</span> </label>
                                                <div class="row">
                                                    <input type="text" class="form-control currency_symbol" id="" placeholder="Currency Symbol" name="" disabled=""  value="{{$Courses->Currency}}"  style="width:20%" value="{{$Courses->Currency}}">&nbsp;&nbsp;
                                                    <input type="text" class="form-control" id="course_fees" placeholder="Course Fees "  name="course_fees"  style="width:70%"  value="{{$Courses->CourseFees}}">
                                                </div>
                                            </div>&nbsp;&nbsp;
                                            <div class="col-md-3">
                                                <label for="administrative_cost" class="form-label">Administrative Cost <span  style="color:red"> *</span> </label>
                                                <div class="row">
                                                    <input type="text" class="form-control currency_symbol" id="" placeholder="Currency Symbol" name="" disabled="" style="width:20%"  value="{{$Courses->Currency}}" >&nbsp;&nbsp;
                                                    <input type="text" class="form-control" id="administrative_cost" placeholder="Administrative Cost"  name="administrative_cost"  value="{{$Courses->AdministrativeCost}}" style="width:70%">
                                                </div>                                            
                                            </div>&nbsp;&nbsp;
                                            <div class="col-md-3">
                                                <label for="administrative_cost" class="form-label">Total Cost </label>
                                                <div class="row">
                                                    <input type="text" class="form-control currency_symbol " id="" placeholder="Currency Symbol" name="" disabled="" style="width:20%"  value="{{$Courses->Currency}}">&nbsp;&nbsp;
                                                    <input type="text" class="form-control" id="total_cost" placeholder="Total Cost "  name="total_cost"  value="{{$Courses->TotalCost}}" style="width:70%">
                                                </div>
                                            </div>
                                        </div>
                                        <BR>
                                        {{-- <div class="card-header">
                                            <B class="header-title">Course Details</B>
                                            <HR><br> --}}
                                        <div class="row">
                                            <div class="col-md-11">
                                                <label for="content"> Overview: <span  style="color:red"> *</span> </label><br><br>
                                                <textarea id="course_overview" name="course_overview" rows="10" cols="50" required>{{$Courses->CourseOverview}}</textarea>
                                                <label id="course_overview-error" class="error" for="course_overview" style="display:none;">Please enter Overview.</label>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-11">
                                                <label for="content"> Curriculum:  <span  style="color:red"> *</span></label><br><br>
                                                <textarea name="course_curriculum" id="course_curriculum"  rows="10" cols="50" required >{{$Courses->Curriculum}}</textarea>
                                                <label id="course_curriculum-error" class="error" for="course_curriculum" style="display:none;">Please enter Curriculum.</label>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-11">
                                                <label for="content">Features:</label><br><br>
                                                <textarea name="course_features" id="course_features"  rows="10" cols="50" required>{{$Courses->Features}}</textarea>
                                            </div>
                                        </div>
                                        <BR>
                                        <div class="row">
                                            <div class="col-md-11">
                                                <label for="content">Opportunities:</label><br><br>
                                                <textarea name="course_opportunities" id="course_opportunities"  rows="10" cols="50" required>{{$Courses->Opportunities}}</textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <label for="content">Application Procedure:  <span  style="color:red"> *</span></label><br><br>
                                                    <textarea name="course_requirements" id="course_requirements"  rows="10" cols="50" required>{{$Courses->Requirements}}</textarea>
                                                    <label id="course_requirements-error" class="error" for="course_requirements" style="display:none;">Please enter Application Procedure.</label>

                                                </div>
                                            </div>
                                       
                                        <br>
                                        <div class="card-header">
                                            <h4 class="header-title">Eligibility </h4>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label for="" class="form-label">Required Qualification</label>
                                                <?php $QualificationData =DB::table('qualification_master')->select('QualificationID','Qualification')->distinct()->get();?>
                                                <select class="form-control" name="qualification" id="qualification" >
                                                    <option value="">Select Course Type </option>
                                                    @foreach ($QualificationData as $data)
                                                        <option value="{{ $data->QualificationID }}" @if($data->QualificationID == $Courses->Qualification) selected @endif>{{ $data->Qualification }}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label for="" class="form-label">Age Limit (Years)</label>
                                                <input type="text" class="form-control" name="age_limit" value="{{$Courses->AgeLimit}}">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card-header">
                                            <h4 class="header-title">Documents</h4>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label for="" class="form-label">Application Form</label>
                                                <div class="" style="position: relative;">

                                                    <a class="me-3" href="#"><?php $filePath =  Storage::url('course/application_form/'.$Courses->ApplicationForm); 
                                                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                        if($Courses->ApplicationForm){
                                                        if($extension == 'pdf'){?>
                                                        <button onclick="downloadPdf('<?php echo $filePath ?>')" class="btn btn-primary" download>Download</button><br><br>
                                                        <iframe src="{{ $filePath }}" id="pdfViewers" frameborder="0"  width="100%" height="200px"></iframe>
                                                        <?php }else{ ?>
                                                          <img src="{{$filePath}}" class="avatar-md rounded-circle bx-s"   width="50%" height="50%">
                                                         <?php } } ?>
                                                    </a>
                                                    
                                                    <br><br>
                                                    <input type="file" id="application_form" name="application_form"  class="form-control">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="brochure" class="form-label">Brochure  </label>
                                                <div class="" style="position: relative;">
                                                    <a class="me-3" href="#"><?php $filePath =  Storage::url('course/brochure/'.$Courses->Brochure); 
                                                        if($Courses->Brochure){
                                                            if($extension == 'pdf'){?>
                                                            <button onclick="downloadPdf('<?php echo $filePath ?>')" class="btn btn-primary" download>Download</button><br><br>
                                                            <iframe src="{{ $filePath }}" id="pdfViewers" frameborder="0"  width="100%" height="200px"></iframe>
                                                            <?php }else{ ?>
                                                              <img src="{{$filePath}}" class="avatar-md rounded-circle bx-s"   width="50%" height="50%">
                                                        <?php } } ?>
                                                    </a>
                                                    <br><br>
                                                    <input type="file" id="brochure" name="brochure" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                    
                                        <br>
                                   
                                        {{-- <div class="card-header">
                                            <h4 class="header-title">Fees Detail</h4>
                                        </div>
                                        <br> --}}
                                        {{-- <div class="row g-2">
                                            <div class="col-md-2">
                                                <label for="country_id" class="form-label">Country</label>
                                                <select class="form-select  mb-2 select2" name="country_id" id="country_id">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countryData as $data)
                                                        <option value="{{ $data->CountryID }}"  @if($data->CountryID ==$Courses->CountryID) selected @endif>{{ $data->CountryName }}</option>
                                                    @endforeach
                                                </select>  
                                            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <div class="col-md-3">
                                                <input type="hidden" class="form-control currency_symbols" id="currency_symbols" placeholder="Currency Symbols" name="currency_symbols" style="width:20%">
                                                <label for="course_fees" class="form-label">Fees</label>
                                                <div class="row">
                                                    <input type="text" class="form-control currency_symbol" id="" placeholder="Currency Symbol" name="" disabled=""  value="{{$Courses->Currency}}"  style="width:20%" value="{{$Courses->Currency}}">&nbsp;&nbsp;
                                                    <input type="text" class="form-control" id="course_fees" placeholder="Course Fees "  name="course_fees"  style="width:70%"  value="{{$Courses->CourseFees}}">
                                                </div>
                                            </div>&nbsp;&nbsp;
                                            <div class="col-md-3">
                                                <label for="administrative_cost" class="form-label">Administrative Cost </label>
                                                <div class="row">
                                                    <input type="text" class="form-control currency_symbol" id="" placeholder="Currency Symbol" name="" disabled="" style="width:20%"  value="{{$Courses->Currency}}" >&nbsp;&nbsp;
                                                    <input type="text" class="form-control" id="administrative_cost" placeholder="Administrative Cost"  name="administrative_cost"  value="{{$Courses->AdministrativeCost}}" style="width:70%">
                                                </div>                                            
                                            </div>&nbsp;&nbsp;
                                            <div class="col-md-3">
                                                <label for="administrative_cost" class="form-label">Total Cost </label>
                                                <div class="row">
                                                    <input type="text" class="form-control currency_symbol " id="" placeholder="Currency Symbol" name="" disabled="" style="width:20%"  value="{{$Courses->Currency}}">&nbsp;&nbsp;
                                                    <input type="text" class="form-control" id="total_cost" placeholder="Total Cost "  name="total_cost"  value="{{$Courses->TotalCost}}" style="width:70%">
                                                </div>
                                            </div>
                                        </div>
                                        --}}
                                        <br><br>
    
                                        <input type="submit" class="btn btn-primary" id="EditCourse" value="Edit">
                                    </form>

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>


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
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<!-- Initialize CKEditor on the textarea -->
<script>
    

    
    $(document).ready(function(){
        CKEDITOR.replace('course_overview');
        CKEDITOR.replace('course_curriculum');
        CKEDITOR.replace('course_requirements');
        CKEDITOR.replace('course_opportunities');
        CKEDITOR.replace('course_features');
        $('.select2').select2();
           
        CKEDITOR.instances.course_overview.on('focus', function() {
            $("#course_overview-error").hide();
        });
        CKEDITOR.instances.course_curriculum.on('focus', function() {
            $("#course_curriculum-error").hide();
        });
        CKEDITOR.instances.course_requirements.on('focus', function() {
            $("#course_requirements-error").hide();
        });

        $('#country_id').on('change', function () {
            var idCountry = this.value;
            $(".currency_symbol").val(idCountry);
            $("#currency_symbols").val(idCountry);


            // $("#institute_state").html('');
            // $.ajax({
            //     url: "{{url('institute/fetch-states')}}",
            //     type: "POST",
            //     data: {
            //         country_id: idCountry,
            //         _token: '{{csrf_token()}}'
            //     },
            //     dataType: 'json',
            //     success: function (result) {
            //       if(result.countrycode[0]['CurrencySymbol']){
            //          $("#currency_symbols").val(result.countrycode[0]['CurrencySymbol']);
            //          $(".currency_symbol").val(result.countrycode[0]['CurrencySymbol']);
            //       }else{
            //         $(".currency_symbol").val('');
            //       }
            //     }
            // });
      
        });


        $("#administrative_cost").on('input',function(){
            course_fees = $("#course_fees").val();
            administrative_cost = $("#administrative_cost").val();
            total_cost = parseInt(course_fees) + parseInt(administrative_cost);
            $("#total_cost").val(total_cost);
        });

        
      
    });
    function downloadPdf(pdfUrl)
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
</script>

@endsection
