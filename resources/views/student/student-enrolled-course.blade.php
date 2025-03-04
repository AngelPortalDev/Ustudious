<!-- Header file include -->
@extends('layouts.main')
@section('content')
<?php $ASSET_PATH = env('ASSET_URL').'/' ?>
<style>
    .boxshadow{
        box-shadow: 1px 1px 3px #0000004a;
        border: none;
        display: flex;
        align-items: center;
    }
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
   }

   /* Firefox */
   input[type=number] {
   -moz-appearance: textfield;
   }
   input[type=password] {
      font-size:24px;
   }
   .remove-icon {
    color: red; /* Adjust the color as needed */
    cursor: pointer;
    font-size:20px;
}
    </style>
    <?php 
	$LoginID = Session::get('student_id');
	$StudentData = DB::table('student')->select('student.*','student_contactinfo.*','country_master.CountryName')
	->leftjoin('student_contactinfo','student_contactinfo.student_id',"=","student.StudentID")
	->leftjoin('country_master','country_master.CountryID',"=","student_contactinfo.contact_country")    
    ->where(['student.StudentID'=> $LoginID])
	->first(); 
	$country = DB::table('country_master')->whereNull('deleted_at')->distinct()->get(); ?>

	<!-- ============================ Instructor header Start================================== -->
	<div class="image-cover ed_detail_head invers" style="background:#f4f5f7;">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-12 col-md-12">
					<div class="viewer_detail_wraps">
                        <div class="d-user-avater mb-3 mt-0">
							<div class="insti-prof-img" style="position: relative;">
							{{-- <img src="assets/img/user-3.jpg" class="img-fluid" alt="" /> --}}
							<?php 
							if($StudentData->Photo){ 
                               $filePath =  Storage::url('student/student_'.$StudentData->StudentID.'/'.$StudentData->Photo); ?>
								
							<img src="{{$filePath}}" class="img-fluid avater" >
							<?php }else{ 
								$filePaths =  Storage::url('no-image.jpg'); ?>
								<img src="{{$filePaths}}" class="img-fluid avater" >
							<?php } ?>
                            </div>
                        </div>
						<div class="caption">
							<div class="viewer_header">
								<h4 class="mb-2">{{$StudentData->FirstName .' '.$StudentData->LastName}}</h4>
								<span class="viewer_location"><i class="ti-location-pin mr-1"></i>{{$StudentData->CountryName}}</span>

								<ul class="mt-2">
									<li><i class="ti-email mr-1"></i>{{$StudentData->Email}}</li>
									<li><i class="ti-mobile mr-1"></i>{{$StudentData->CountryCode.' '.$StudentData->Mobile}}</li>
								</ul>

							</div>

						</div>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>

    <!-- ============================ Dashboard: My Order Start ================================== -->
    @if(session()->get('student_id'))
    <section class="pt-5 browse-courses-page-main">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-3">
                    <div class="dashboard-navbar border">

                        <div class="d-navigation">
                            <ul id="side-menu">
                                <li ><a href="{{route('student-profile')}}"> <i class="ti-user"></i>My Profile</a></li>
                                <li class="active"><a href="{{route('student-enrolled-course')}}"><i class="ti-heart"></i>Applied Course</a></li>
                                <li ><a href="{{route('student-saved-course')}}"><i class="ti-heart"></i>Saved Course</a></li>
                                <li><a href="{{route('student-change-password')}}"><i class="ti-settings"></i>Change Password</a></li>
                                <li><a href="{{route('institutelogout')}}"><i class="ti-power-off"></i>Log Out</a></li>
                            </ul>
                        </div>
                        
                        
                    </div>
                    
                    
                </div>	
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <div class="dashboard_container_header">
                        <div class="dashboard_fl_1">
                            <h4>Applied Courses List</h4>
                        </div>
                    </div>
                    
                    @php $CourseList = DB::table('student_applied_course')->select("course.CourseName","institute.company_name",
                    "duration_master.Duration","intakemonth_master.Intakemonth","intakeyear_master.Intakeyear","course.TotalCost",
                    "course.Brochure","course.CourseID","course.created_by","country_master.CountryName","course.Currency",
                    "institute.institute_id","institute.institute_logo","institute_contactinfo.founded","institute_contactinfo.total_courses","student_applied_course.*")
                    
                                ->leftjoin('course','course.CourseID','=','student_applied_course.course_id')
                                ->leftjoin('institute','institute.institute_id','=','course.InstituteID')
                                ->leftjoin("institute_contactinfo","institute_contactinfo.institute_id","=","course.InstituteID")
                                ->leftjoin("country_master","country_master.CountryID","=","institute_contactinfo.country")  

                                ->leftjoin("duration_master","duration_master.DurationID","=","course.CourseDuration")
                                ->leftjoin("intakemonth_master","intakemonth_master.IntakemonthID","=","course.IntakeMonth")
                                ->leftjoin("intakeyear_master","intakeyear_master.IntakeyearID","=","course.IntakeYear")
                                ->where(['student_applied_course.student_id'=> session()->get('student_id')])->get(); 
                    @endphp
                    
                    
                    @if(count($CourseList) > 0)
                            @foreach($CourseList as $list)
                            <!-- Cource Grid 1 -->
                                <div class="education_block_list_layout style-2">
                                    <div class="list_layout_ecucation_caption">
                                        <div class="cb-college-name-section">
                                            <div class="education_block_thumb n-shadow">
                                                <a href="{{route('college-details',base64_encode($list->institute_id))}}">
                                                    <?php 
                                                    if($list->institute_logo){ 
                                                        $filePath =  Storage::url('institute/logo/'.$list->institute_logo); 
                                                        ?>
                                                        <img src="{{$filePath}}" class="img-fluid" alt="">
                                                    <?php }else{
                                                        $filePath =  Storage::url('no-image.jpg'); ?>
                                                        <img src="{{$filePath}}" class="img-fluid" alt="">
                                                    <?php } ?>
                                                    
                                                    </a>
                                            </div>

                                            <div class="list_layout_ecucation_caption">

                                                <div class="education_block_body">
                                                    <h4 class="bl-title college-name"><a href="{{route('college-details',base64_encode($list->institute_id))}}">{{$list->company_name}}</a></h4>
                                                    <div class="_course_admin_ol12">
                                                        <span><i
                                                                class="fas fa-map-marker-alt mr-1"></i>
                                                            {{$list->CountryName}} &nbsp;|&nbsp; </span>
                                                        {{-- <span><i class="fas fa-award mr-1"></i><strong>Scholarship: </strong>
                                                            Yes &nbsp;|&nbsp; </span> --}}
                                                        <span>Total
                                                                Courses:</strong> {{$list->total_courses}} </span>|&nbsp; </span>
                                                                {{-- <span><i class="fas fa-award mr-1"></i><strong>Scholarship: </strong>
                                                                    Yes &nbsp;|&nbsp; </span> --}}
                                                                <span>Founded In:</strong> {{$list->founded}} </span>
    
                                                    </div>


                                                </div>


                                            </div>
                                        </div>


                                        <div class="education_block_body">
                                            <h4 class="bl-title course-name pt-2"><a href="{{route('course-details',base64_encode($list->CourseID))}}">{{$list->CourseName}}
                                                </a></h4>

                                        </div>
                                    
                                        <div class="row">
                                            <div class="col-md-8 course-details-h-2">

                                                <div class="course-details-1">
                                                    <div class="c-d-2">
                                                        <label class="abcd"> Intake Month:</label>
                                                        <div class="cou-value">{{$list->Intakemonth}}</div>
                                                    </div>
                                                    <div class="c-d-2">
                                                        <label class="abcd">Course Duration:</label>
                                                        <div class="cou-value">{{$list->Duration}}</div>
                                                    </div>
                                                </div>

                                                <div class="course-details-1">
                                                    <div class="c-d-2">
                                                        <label class="abcd">Applied On :</label>
                                                        <div class="cou-value">{{$list->applied_on }}</div>
                                                    </div>
                                                    <div class="c-d-2">
                                                        <label class="abcd">Fees:</label>
                                                        <div class="cou-value"><?= $list->Currency.' '.$list->TotalCost ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="cou-buttons">

                                                    @if (session()->has('student_id'))
                                                    @php $exists = DB::table('student_applied_course')->where('course_id',$list->CourseID)->where('student_id',session()->get('student_id'))->where('is_applied','yes')->count();  @endphp
                    
                                                        @if($exists != 0)
                                                            <button class="apply-btn" style=" cursor: default; "><i class="fa fa-arrow-right"></i> Applied</button>
                                                        @endif
                                                    @endif
                                                    
                                                    <?php
                                                        $filePath =  Storage::url('course/brochure/'.$list->Brochure);  
                                                        if($list->Brochure) {
                                                        ?>
                                                        <button class="download-brochure"  onclick="downloadBrochure('<?php echo $filePath ?>')" ><i class="fa fa-download" aria-hidden="true"></i> Brochure</button>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                        </div>


                                    </div>

                                </div>
                            @endforeach
                    @else	
                    <div class="education_block_list_layout style-2">
                        <div class="cb-college-name-section">
                            <h5 class="font-weight-700 float-start text-uppercase"> Course Not Found </h5>
                        </div>
                    </div>
                                      
				    @endif

                </div>

            </div>
        </div>
    </section>        
 

    @endif
@endsection
