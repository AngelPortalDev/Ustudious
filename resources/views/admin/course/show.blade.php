@extends('admin.layouts.main')
@section('css')
<style>
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

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    <?php
                    $sub_title = "Course";
                    $page_title = "Show Course";?>
                    @include('admin.layouts.page-title')
                    <!-- end row -->
                   
                    <div class="d-flex justify-content-sm-end"><a href="{{route('course')}}" class="btn btn-success" >Back</a></div>
                    <bR>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h4 class="header-title" >View Course</B>
                                   
                                </div>
                                <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2 ">
                                                <label for="fullname" class="form-label">Institute  :    </label>  {{$Courses->company_name}}
                                            </div>

                                            <div class="col-md-2">
                                                <label for="company_name" class="form-label">Course Name :   </label>  {{ $Courses->CourseName}}
                                            </div>

                                            <div class="col-md-2">
                                                <label for="specialization" class="form-label">Specialization  :   </label>  {{ $Courses->Specialization}}
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <label for="course_types" class="form-label">Program Type  :   </label>  {{ $Courses->course_types}}
                                            </div>
                                             <div class="col-md-2">
                                                <label for="country_id" class="form-label">ECTS  :  </label>  {{$Courses->Ects}}
                                            </div>
                                           
                                            
                                        </div>
                                        <br>
                                        <div class="row">
                                           
                                            <div class="col-md-2">
                                                <label for="country_id" class="form-label">MQF \ EQF Level  :  </label>  {{$Courses->MqfLevel}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="course_start_date" class="form-label">Course Start Date :   </label>  {{ $Courses->CoursestartDate}}
                                            </div>

                                            <div class="col-md-2">
                                                <label for="course_expire_date" class="form-label">Course Expire Date :   </label>  {{ $Courses->CourseendDate}}
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <label for="course_tag" class="form-label">Course Tag :   </label>  {{ $Courses->CourseTag }} 
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <label for="duration" class="form-label">Course Duration :   </label>  {{ $Courses->Duration }} 
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="languages" class="form-label">Language:   </label>  {{$Courses->Language}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="intake_month" class="form-label">Intake Month:   </label>  {{$Courses->Intakemonth}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="intake_year" class="form-label">Intake Year:   </label>  {{$Courses->Intakeyear}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="course_tag" class="form-label">Course Catgeory :   </label>  {{ $Courses->course_category }} 
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                @php $ModeofStudy = "";  @endphp
                                                @if($Courses->ModeofStudy ==  "part_time")
                                                   @php $ModeofStudy = "Part Time"; @endphp
                                                @elseif($Courses->ModeofStudy == "full_time") 
                                                   @php $ModeofStudy = "Full Time";  @endphp
                                                @elseif($Courses->ModeofStudy == "distance") 
                                                    @php $ModeofStudy = "Distance";  @endphp
                                                @endif
                                                <label for="country_id" class="form-label">Mode of Study  :  </label>  {{$ModeofStudy}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                        
                                            <!-- <div class="col-md-2">
                                                <label for="country_id" class="form-label">Country  :  </label>  {{$Courses->CountryName}}
                                            </div> -->
                                            <div class="col-md-2">
                                                <label for="course_fees" class="form-label"> Fees :  </label> {{ $Courses->Currency}} {{$Courses->CourseFees}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="administrative_cost" class="form-label">Administrative Cost  :   </label>{{ $Courses->Currency}} {{$Courses->AdministrativeCost}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="total_cost" class="form-label">Total Cost  :  </label>{{ $Courses->Currency}} {{$Courses->TotalCost}}
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card-header">
                                            <h4 class="header-title"><B>COURSE DETAILS</B></h4>
                                        </div>
                                        <br>
                                         <div class="row g-2">
                                            <div class="col-md-11 ">
                                                <?php  $html_overview = $Courses->CourseOverview ?>
                                                <label for="overview" class="form-label"> Overview :   <BR> </label>@php echo $html_overview @endphp
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-11">
                                                <?php $html_curriculum = $Courses->Curriculum ?>
                                                <label for="curriculum" class="form-label"> Curriculum  :  <BR> </label>@php echo $html_curriculum @endphp
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-11">
                                                <?php $html_requirements = $Courses->Features ?>
                                                <label for="requirements" class="form-label">Features  :  <BR> </label>@php  echo  $html_requirements @endphp
                                            </div>
                                       
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-11">
                                                <?php $html_opportunities = $Courses->Opportunities ?>
                                                <label for="requirements" class="form-label">Opportunities  :  <BR> </label>@php  echo  $html_opportunities @endphp
                                            </div>
                                       
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-11">
                                                <?php $html_requirements = $Courses->Requirements ?>
                                                <label for="requirements" class="form-label">Application Procedure  :  <BR> </label>@php  echo  $html_requirements @endphp
                                            </div>
                                       
                                        </div>
                                        <br>
                                        <div class="card-header">
                                            <h4 class="header-title"><b>ELIGIBILITY
                                            </b></h4>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-2">
                                                <label for="course_tag" class="form-label">Qualification :   </label>  {{ $Courses->Qualification }} 
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <label for="duration" class="form-label">Age Limit :   </label>  {{ $Courses->AgeLimit }} 
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                      
                                        <div class="card-header">
                                            <h4 class="header-title"><B>DOCUMENTS</B></h4>
                                        </div>
                                        
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label for="brochure" class="form-label">Brochure :  </label>
                                                <?php $filePath =  Storage::url('course/brochure/'.$Courses->Brochure);
                                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                    if($Courses->Brochure){
                                                    if($extension == 'pdf'){?>
                                                        <button onclick="downloadPdf('<?php echo $filePath ?>')" class="btn btn-primary" download>Download</button><br><br>
                                                        <iframe src="{{ $filePath }}" id="pdfViewers" frameborder="0"  width="100%" height="200px"></iframe>
                                                    <?php }else{ ?>
                                                        <img src="{{$filePath}}" class="avatar-md rounded-circle bx-s"   width="50%" height="50%">
                                                    <?php } } ?>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="application_form" class="form-label">Application Form  :  </label>
                                                <?php $filePath =  Storage::url('course/application_form/'.$Courses->ApplicationForm); 
                                                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                if($Courses->ApplicationForm){
                                                if($extension == 'pdf'){?>
                                                <button onclick="downloadPdf('<?php echo $filePath ?>')" class="btn btn-primary" download>Download</button><br><br>
                                                <iframe src="{{ $filePath }}" id="pdfViewers" frameborder="0"  width="100%" height="200px"></iframe>
                                                <?php }else{ ?>
                                                  <img src="{{$filePath}}" class="avatar-md rounded-circle bx-s"   width="50%" height="50%">
                                                 <?php } } ?>



                                                Courses
                                            </div>
                                         
                                          
                                        </div>
                                        <br>
                                    
                                      
                                        <br>
                                    
                            

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
<script type="text/javascript" src="{{asset('js/common.js')}}"></script>
<script>

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