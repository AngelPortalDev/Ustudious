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
	->leftjoin('country_master','country_master.CountryID',"=","student.CountryID")    
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
                            <li><a href="{{route('student-saved-course')}}"><i class="ti-heart"></i>Saved Course</a></li>
                            <li  class="active"><a href="{{route('student-change-password')}}"><i class="ti-settings"></i>Change Password</a></li>
                            <li><a href="{{route('institutelogout')}}"><i class="ti-power-off"></i>Log Out</a></li>
                        </ul>
                    </div>
                    
                    
                </div>
                
                
            </div>	
            <div class="col-lg-9 col-md-9 col-sm-9">
               

                    <div class="row">
                        <div class="dashboard_container_header">
                            <div class="dashboard_fl_1">
                                <h4>Change Password</h4>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12" id="institute_show_edit"  >
                            <br><BR>
                            <div class="dashboard_container">
                                <div class="dashboard_container_body p-4">
                                    
                                    <form id="changePassword">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Old Password</label>
                                                    <input type="password" name="old_pass" id="old_pass" class="form-control">
                                                    <span id="old_pass_error" style="color:red;display:none;">
                                                    <small>
                                                        <i>Please Provide Required Old Password </i>
                                                    </small></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>New Password </label>
                                                    <input type="text" name="new_pass" id="new_pass" class="form-control">
                                                    <span id="new_pass_error" style="color:red;display:none;">
                                                    <small>
                                                        <i>Please Provide Required New Password </i>
                                                    </small></span>
                                                    <span id="new_pass_error2" style="color:red;display:none;">
                                                    <small>
                                                        <i>Password Should be Atleas 8 Character with AlphaNumeric & Spec.Char (e.g Abc@12345) </i>
                                                    </small>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Confirm New Password</label>
                                                    <input type="password" name="confirm_pass" id="confirm_pass" class="form-control">
                                                    <span id="conf_pass_error1" style="color:red;display:none;">
                                                    <small>
                                                        <i>Please Provide Required Confirm Password </i>
                                                    </small>
                                                </span>
                                                <span id="conf_pass_error2" style="color:red;display:none;">
                                                    <small>
                                                        <i>Confirm Password Doesn't Match </i>
                                                    </small>
                                                </span>
                                                
                                                </div>
                                            </div>
                                            <div class="col-lg-12 m-b10">
                                                <button class="btn btn-theme UpdatePassword" type="submit" id="UpdatePassword" >UpdatePassword</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
           

            </div>

        </div>
        <!-- Row -->

    </div>
</section>
@endif
@endsection
