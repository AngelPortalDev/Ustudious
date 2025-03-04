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

							{{-- <div class="dashboard_single_course_progress_1 mt-4">
								<label>82% Completed</label>
								<div class="progress">
									<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div> --}}

						</div>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>

<!-- ============================ Dashboard: My Order Start ================================== -->
@if(session()->has('student_id'))
<section class=" pt-4">
    <div class="container">

        <div class="row">

            <div class="col-lg-3 col-md-3">
                <div class="dashboard-navbar border">

                    <div class="d-navigation">
                        <ul id="side-menu">
                            <li ><a href="{{route('student-profile')}}"> <i class="ti-user"></i>My Profile</a></li>
                            <li><a href="{{route('student-enrolled-course')}}"><i class="ti-heart"></i>Applied Course</a></li>
                            <li class="active"><a href="{{route('student-saved-course')}}"><i class="ti-heart"></i>Saved Course</a></li>
                            <li><a href="{{route('student-change-password')}}"><i class="ti-settings"></i>Change Password</a></li>
                            <li><a href="{{route('institutelogout')}}"><i class="ti-power-off"></i>Log Out</a></li>
                        </ul>
                    </div>
                    
                    
                </div>
                
                
            </div>	
            <div class="col-lg-9 col-md-9 col-sm-12">
                @php
                    $SavedCourseData = DB::table('students_viewed_courses')->select('course.CourseID','course.CourseName','students_viewed_courses.is_saved','institute.company_name','course.TotalCost','course.created_by','institute.institute_id','course.Currency')
                            ->leftjoin('course','course.CourseID','=','students_viewed_courses.course_id')
                            ->leftjoin('institute','institute.institute_id','=','course.InstituteID')
                            ->where(['students_viewed_courses.student_id'=> session()->get('student_id')])
                            ->where(['is_saved'=>'Yes'])
                            ->get(); 
                @endphp
    
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="dashboard_container">
                            <div class="dashboard_container_header">
                                <div class="dashboard_fl_1">
                                    <h4>Saved Courses List</h4>
                                </div>
                            </div>
                            <div class="dashboard_container_body">
                                <div class="table-responsive">
                                    <table class="table" >
                                        <thead class="">
                                            <tr>
                                                <th scope="col" style="text-wrap: nowrap;">Sr. No.</th>
                                                <th scope="col" style="text-wrap: nowrap;">Institute Name</th>
                                                <th scope="col" style="text-wrap: nowrap;">Course Name</th>
                                                <th scope="col" style="text-wrap: nowrap;">Total Fees</th>
                                                <th scope="col" style="text-wrap: nowrap;">Status</th>
                                                {{-- <th scope="col" style="text-wrap: nowrap;">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i=1; @endphp
                                            @if(count($SavedCourseData) > 0)
                                            @foreach($SavedCourseData as $List)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td class="course-name-saved-course-table"><a href="{{route('college-details',base64_encode($List->institute_id))}}">{{$List->company_name}}</a></td>
                                                <td class="course-name-saved-course-table"><a href="{{route('course-details',base64_encode($List->CourseID))}}">{{$List->CourseName}}</a></td>
                                                <td class="course-name-saved-course-table">{{$List->Currency.' '.$List->TotalCost}}</td>
                                                <td class="save-btn">

                                                    {{-- <input type="checkbox" class="switch-input" checked> --}}
                                                    {{-- <a class="actions"  data-is_toggle="No" data-course_action="Saved" data-dashjs='0' data-course_id="{{ base64_encode($List->CourseID)}}" data-posted_by='{{base64_encode($List->created_by)}}'><i class="fa-bookmark fa" style="color: #11a1f5;"></i></a> --}}
                                                  
                                                    {{-- @php $exists = DB::table('students_viewed_courses')->where('course_id',$List->CourseID)->where('student_id',session()->has('student_id'))->where('is_saved','No')->count();   @endphp --}}

                                                    {{-- @if($exists != 0) --}}
                                                        <div class="save-btn">
                                                            <a class="actions"  data-is_toggle="No" data-course_action="Saved" data-dashjs='0' data-course_id="{{ base64_encode($List->CourseID)}}" data-posted_by='{{base64_encode($List->created_by)}}'><i class="fa-bookmark fa" style="color: #11a1f5;"></i></a>
                                                        </div>
                                                    {{-- @else
                                                        <div class="save-btn">
                                                            <a class="actions"  data-is_toggle="Yes" data-course_action="Unsaved" data-dashjs='0' data-course_id="{{ base64_encode($List->CourseID)}}" data-posted_by='{{base64_encode($List->created_by)}}'><i class="far fa-bookmark" style="color: #11a1f5;"></i></a>
                                                        </div>
                                                    @endif --}}
                                                </td>
                                            </tr>
                                            @php $i++; @endphp
                                            @endforeach
                                            @else
                                             <td colspan="4"s style="text-align:center">No Record Found</td>
                                            @endif
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- /Row -->

            </div>

        </div>
        <!-- Row -->

    </div>
</section>
@endif
@endsection
