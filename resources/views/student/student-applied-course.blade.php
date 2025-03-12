<!-- Header file include -->
@extends('layouts.main')
@section('content')
<?php 
$ASSET_PATH = env('ASSET_URL').'/';
  $LoginID = Session::get('institute_id');
  $InstituteData = DB::table('institute')->select('institute.institute_banner','institute.country_id','institute.institute_logo','institute.company_name','country_master.CountryName','institute.institute_id')
	->leftjoin('institute_contactinfo','institute_contactinfo.institute_id','=','institute.institute_id')
	->leftjoin('country_master','country_master.CountryID','=','institute.country_id')
	->where(['institute.institute_id'=> $LoginID])->first();  
	
	$StudentData = DB::table('student_applied_course')->select('student_applied_course.*','student.updated_at','student.StudentID','student.Photo','student.Email','student.Mobile','student.FirstName','student.LastName','student.Resume','student.CountryID','country_master.CountryName','student.CountryCode','course.CourseID','course.InstituteID','course.CourseName','course.ModeofStudy')
	->leftjoin('student','student.StudentID','=','student_applied_course.student_id')
	->leftjoin('course','course.CourseID','=','student_applied_course.course_id')
	->leftjoin('student_contactinfo','student_contactinfo.student_id','=','student.StudentID')
	->leftjoin('country_master','country_master.CountryID','=','student.CountryID')
	->where('student.ApprovalStatus','Approved')          
	->whereNull('student.deleted_at')       
	->where(['student_applied_course.institute_id'=> $LoginID])
	->orderBy('applied_on','DESC')
	->get();  
// print_r($StudentData);
	?>
<div class="college-heading-top-section lg">
	<div class="container">
		<div class="row ">

			<div class="college-cover-img pb-4" style="position: relative;">
				{{-- <img alt="Great Lakes Institute of Management Chennai" src="{{$ASSET_PATH}}img/college-de-paris-cover.png"
					width="1200" height="200">

				<div class="institute-cover-photo-edit-pencil-icon">
					<input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
					<label for="imageUpload"><i class="ti-pencil"></i></label>
				</div> --}}
				<?php 
				if($InstituteData->institute_banner){ 
					$filePath =  Storage::url('institute/banner/'.$InstituteData->institute_banner); 
					?>
				<img src="{{$filePath}}" class="img-fluid avater" alt="">
				<?php }else{ 
					$filePaths =  Storage::url('no-image.jpg'); ?>
					<img src="{{$filePaths}}" class="img-fluid avater" alt="">
				<?php } ?>
		   
				<label class="institute-cover-photo-edit-pencil-icon" title="update" data-bs-toggle="tooltip" data-placement="right" id="editImageIcon">
					<form class="bannerImage" enctype="multipart/form-data">
						<input type="file" class="update-flie image bannerPic" name='institute_banner' id="institute_banner" accept=".png,.jpg,.jpeg">
						<input type='hidden' class="banner_type" value="bannerpic" name="banner_type">
						<input type="text" class='curr_img' value="{{$InstituteData->institute_banner}}" name='old_img_name'  hidden>
						<i class="ti-pencil"></i>
					</form>
				</label>
			</div>

			<!-- <div class="avatar-upload">
				<div class="avatar-edit">
					<input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
					<label for="imageUpload"></label>
				</div>
				<div class="avatar-preview">
					<div id="imagePreview" style="background-image: url('http://i.pravatar.cc/500?img=7');">
					</div>
				</div>
			</div> -->

		</div>
	</div>
</div>

<!-- ============================ Dashboard: My Order Start ================================== -->
<section class=" pt-4 saved-students-page-main">
	<div class="container">

		<div class="row">

			<div class="col-lg-3 col-md-3">
				<div class="dashboard-navbar border">

					<div class="d-user-avater mb-3 mt-0">
						<div class="insti-prof-img" style="position: relative;">
							  
							<?php 
							if($InstituteData->institute_logo){ 
							$filePath =  Storage::url('institute/logo/'.$InstituteData->institute_logo); 
							?>
							<img src="{{$filePath}}" class="img-fluid avater" alt="">
							<?php }else{
								$filePath =  Storage::url('no-image.jpg'); ?>
								<img src="{{$filePath}}" class="img-fluid avater" alt="">
							<?php } ?>
							<label class="institute-profile-photo-edit-pencil-icon" title="update" data-bs-toggle="tooltip" data-placement="right" id="editImageIcon">
								<form class="proflilImage" enctype="multipart/form-data">
									<input type="file" class="update-flie image profilePic" name='logo_image' id="logo_image" accept=".png,.jpg,.jpeg">
									<input type='hidden' class="banner_type" value="brochurepic" name="banner_type">
									<input type="text" class='curr_img' value="{{$InstituteData->institute_logo}}" name='old_img_name'  hidden>
									<i class="ti-pencil"></i>
								</form>
							</label>
						</div>

						<h4><a href="{{route('college-details',base64_encode($InstituteData->institute_id))}}"><?= $InstituteData->company_name  ?></a></h4>
                       
                        <span>{{$InstituteData->CountryName}}</span>
					</div>

					<div class="d-navigation">
						<ul id="side-menu">
							<li><a href="{{route('institute-profile')}}"><i class="ti-user"></i>Institute
								Profile</a></li>
							<li><a href="{{route('institute-posted-course')}}"><i class="ti-heart"></i>Posted
									Course</a></li>
							<li><a href="{{route('institute-saved-students')}}"><i class="ti-heart"></i>Saved
									Students</a></li>
							<li class="active"><a href="{{route('student-applied-course')}}"><i class="ti-settings"></i>Applied Students</a>
                                    </li>
							{{-- <li><a href="institute-transactions.php"><i class="ti-shopping-cart"></i>Transactions</a>
							</li> --}}
							<li><a href="{{route('institute-change-password')}}"><i class="ti-settings"></i>Change Password</a>
							</li>
							<li><a href="{{route('institutelogout')}}web.php"><i class="ti-power-off"></i>Log Out</a></li>
						</ul>
					</div>

				</div>


			</div>

			<div class="col-lg-9 col-md-9 col-sm-12">

				<div class="row ">

					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
					<div class="dashboard_container_header">

						<div class="dashboard_fl_1">
							<h4>Applied Students</h4>
						</div>

						{{-- <div class="dashboard_fl_2">
							<ul class="mb0">
								
								<li class="list-inline-item">
									<form class="form-inline my-2 my-lg-0">
										<input class="form-control" type="search" placeholder="Search Courses" aria-label="Search">
										<button class="btn my-2 my-sm-0" type="submit"><i class="ti-search"></i></button>
									</form>
								</li>
							</ul>
						</div> --}}
					</div>
				</div>
				@if(count($StudentData) > 0)

				@foreach($StudentData as $list)
					<!-- Cource Grid 1 -->
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="education_block_list_layout style-2">
							


							<div class="list_layout_ecucation_caption">
								<div class="cb-college-name-section">
									<div class="education_block_thumb n-shadow">
									
											<?php 
												if($list->Photo){ 
													$filePath =  Storage::url('student/student_'.$list->StudentID.'/'.$list->Photo); 
													?>
												<img src="{{$filePath}}" class="img-fluid avater" alt="">
												<?php }else{ 
													$filePaths =  Storage::url('no-image.jpg'); ?>
													<img src="{{$filePaths}}" class="img-fluid avater" alt="">
												<?php } ?>
									</div>

									<div class="list_layout_ecucation_caption">

										<div class="education_block_body" style="width:400px;">
											@php
											 if(session()->get('institute_id')){
												$institute_id = session()->get('institute_id');
											 }else{
												$institute_id = '0';
											 }
											$dateTime = new DateTime($list->updated_at);
											// Get the current date and time
											$now = new DateTime();
											// Calculate the difference between the two dates
											$diff = $now->diff($dateTime);

											if ($diff->days == 0) {
												if ($diff->h > 0) {
													// Difference is in hours
													$diffDays =  $diff->h . " hours ago";
												} else if ($diff->i > 0) {
													// Difference is in minutes
													$diffDays =  $diff->i . " minutes ago";
												} else {
													// Difference is in seconds
													$diffDays = "Just now";
												}
											} else {
												// Difference is in days
												$diffDays = $diff->days . " days ago";
											}



											$Qualification = DB::table('student_qualifications')->select('qualification_master.Qualification')
												->leftjoin("qualification_master","qualification_master.QualificationID","=","student_qualifications.Qualification") 
												->whereNull('student_qualifications.deleted_at')   
												->where('StudentID',$list->StudentID)
												->orderBy('StudentQualificationID','DESC')
												->first();     
											if($Qualification){
												$Qualification = $Qualification->Qualification;
											}else{
												$Qualification = 'Not Disclosed';
											}
											@endphp
											<h4 class="bl-title college-name"><a href="{{route("student-details",[base64_encode($list->StudentID),base64_encode($institute_id)])}}">{{$list->FirstName.' '.$list->LastName}}</a></h4>
											<div class="_course_admin_ol12">
												<span><i class="fas fa-graduation-cap mr-1"></i>{{$Qualification}} &nbsp;&nbsp; </span>
												<span><i class="fas fa-map-marker-alt mr-1"></i>{{$list->CountryName}} &nbsp;&nbsp; </span>
												<span><i class="ti-calendar mr-1"></i>Active: {{$diffDays}}&nbsp;&nbsp;</span>

											</div>


										</div>
										

									</div>
								</div>

								<div class="row py-2">
									<div class="col-md-12 col-lg-12 course-details-h-2">

										<div class="course-details-1">
											<div class="c-d-2">
												<label class="abcd"> Mobile:</label>
												<div class="cou-value">{{$list->CountryCode.' '.$list->Mobile}}</div>
											</div>
											<div class="c-d-2">
												<label class="abcd">Email:</label>
												<div class="cou-value">{{$list->Email}}</div>
											</div>
											<div class="c-d-2">
												<label class="abcd">Applied for</label>
												<div class="cou-value"><a target="_blank" href="{{route('course-details',base64_encode($list->CourseID))}}">{{$list->CourseName}}</a></div>
											</div>
											<div class="c-d-2">
												<label class="abcd"> Applied Date</label>
												<div class="cou-value">{{$list->applied_on}}</div>
											</div>
										</div>

									</div>

									<div class="col-md-12 col-lg-4">
										<div class="cou-buttons">
											
											{{-- <button class="download-brochure"> <i class="fa fa-download" aria-hidden="true"></i> Resume</button> --}}
											<?php
											$filePath =  Storage::url('student/student_'.$list->StudentID.'/'.$list->Resume); 
											if (isset($list->Resume) && !empty($list->Resume)){
											?>
												<button class="download-brochure"  onclick="downloadBrochure('<?php echo $filePath ?>')" ><i class="fa fa-download" aria-hidden="true"></i> Resume</button>
											<?php } ?>

											<br>
										
										</div>
									</div>

								</div>

								
						
							</div>


						</div>
					</div>
				@endforeach
				@else	

				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
					<div class="education_block_list_layout style-2">
						
							<div class="cb-college-name-section">
								<h5 class="font-weight-700 float-start text-uppercase"> Student Not Found </h5>
							</div>
						
					</div>
				</div>
				@endif


				</div>

			</div>

		</div>
		<!-- Row -->

	</div>
</section>
<!-- ============================ Dashboard: My Order Start End ================================== -->
@endsection