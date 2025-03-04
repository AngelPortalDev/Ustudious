<!-- Header file include -->
@extends('layouts.main')
@section('content')
<style>
	.switcher-active {
		color: white;
	}

	#switchcolor_Active {
		background: #68bb0f;
	}
</style>
@if(Session::get('institute_id'))
<?php $ASSET_PATH = env('ASSET_URL').'/' ;
    $LoginID = Session::get('institute_id');
	$InstitutewiseCourse = DB::table('course')->select('course.*','institute.institute_idproof','institute.institute_banner')
    ->leftjoin('institute','course.InstituteID','=','institute.institute_id')
	->where(['course.InstituteID'=> $LoginID])                
	->whereNull('course.deleted_at')->orderby('CourseID','Desc')->get();

  	$InstituteData = DB::table('institute')->select('institute.institute_banner','institute.institute_logo','institute.company_name','country_master.CountryName','institute.institute_id')
	->leftjoin('institute_contactinfo','institute_contactinfo.institute_id','=','institute.institute_id')
	->leftjoin('country_master','country_master.CountryID','=','institute_contactinfo.country')
	->where(['institute.institute_id'=> $LoginID])->first();  
	
			?>
<div class="college-heading-top-section lg">
	<div class="container">
		<div class="row ">

			<div class="college-cover-img pb-4" style="position: relative;">
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
<section class=" pt-4">
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
							<li class="active"><a href="{{route('institute-posted-course')}}"><i
										class="ti-heart"></i>Posted
									Course</a></li>
							<li><a href="{{route('institute-saved-students')}}"><i class="ti-heart"></i>Saved
									Students</a></li>
							<li><a href="{{route('student-applied-course')}}"><i class="ti-settings"></i>Applied Students</a>
                                    </li>

						<!-- 	<li><a href="institute-transactions.php"><i class="ti-shopping-cart"></i>Transactions</a>
							</li> -->
							<li><a href="{{route('institute-change-password')}}"><i class="ti-settings"></i>Change Password</a>
							</li>
							<li><a href="{{route('institutelogout')}}"><i class="ti-power-off"></i>Log Out</a></li>
						</ul>
					</div>

				</div>


			</div>

			<div class="col-lg-9 col-md-9 col-sm-12">


				<!-- Row -->
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="dashboard_container">
							<div class="dashboard_container_header">
								<div class="dashboard_fl_1">
									<h4>Posted Courses List</h4>
								</div>
							</div>
							<div class="dashboard_container_body">
								<div class="table-responsive">
									<table class="table">
										<thead class="">
											<tr>
												<th scope="col" style="text-wrap: nowrap;">Sr. No.</th>
												<th scope="col" style="text-wrap: nowrap;">Course Name</th>
												<th scope="col" style="text-wrap: nowrap;">Specialization</th>
												<th scope="col" style="text-wrap: nowrap;">Total Fees</th>
												<th scope="col" style="text-wrap: nowrap;">Status</th>
												<th scope="col" style="text-wrap: nowrap;">Institute Status</th>
												<th scope="col" style="text-wrap: nowrap;">Action</th>
											</tr>
										</thead>
										<tbody>
											@php $i=1; @endphp
											@if(count($InstitutewiseCourse) > 0)
											@foreach($InstitutewiseCourse as $List)
											<tr>
												<td>{{$i}}</td>
												<td class="course-name-saved-course-table"><a
														href="{{route('course-details',base64_encode($List->CourseID))}}">{{$List->CourseName}}</a>
												</td>
												<td>{{$List->Specialization}}</td>
												<td>{{$List->Currency .' '.$List->TotalCost}}</td>
												<td>{{$List->ApprovalStatus}}</td>
												{{-- <td class="switcher-active">
													<input type="checkbox" id="switch" /><label
														for="switch">Toggle</label>
												</td> --}}
												{{-- <td class="switcher switcher-active"> --}}

													{{-- @if($List->ApprovalStatus == 'Approved')
													<input type="checkbox" class="switch-input" checked>
													<label class="switch-label course_status" for="switch"
														is_toggle="Rejected" data-course_action='StatusUpdate'
														data-course_status="Rejected"
														data-course_id="{{ base64_encode($List->CourseID)}}">Toggle</label>
													@else
													<input type="checkbox" class="switch-input" checked>
													<label class="switch-label course_status" for="switch"
														is_toggle="Approved" data-course_action='StatusUpdate'
														data-course_status="Approved"
														data-course_id="{{ base64_encode($List->CourseID)}}">Toggle</label>
													@endif --}}
												<td class="switcher-active">
													<input type="checkbox" class="toggle-switch"
														data-row="{{$List->CourseID}}" id="switch{{$List->CourseID}}">
													<label
														class="switch-label course_status_{{$List->CourseID}} courseStatus"
														for="switch{{$List->CourseID}}"
														data-is_toggle="{{$List->CourseStatus}}"
														data-course_action='StatusUpdate'
														data-course_status="{{$List->CourseStatus}}"
														data-course_id="{{ base64_encode($List->CourseID)}}"
														id="switchcolor_{{$List->CourseStatus}}">Toggle</label>
												</td>

												{{-- </td> --}}
												<td class="dash-action-main">
													<div class="dashboard_action circle">
														<a href="{{route('edit-post-course',base64_encode($List->CourseID))}}"
															class="btn edit"><i class="ti-pencil"></i></a>
														<a href="{{route('course-details',base64_encode($List->CourseID))}}"
															class="btn view"><i class="ti-eye"></i></a>
														<a class="btn delete courseStatus" is_toggle="delete"
															data-course_action='Delete' data-course_status=""
															data-course_id="{{ base64_encode($List->CourseID)}}"><i
																class="ti-trash"></i></a>
													</div>
												</td>
											</tr>

											@php $i++; @endphp
											@endforeach
											@else
											<td colspan="6" s style="text-align:center">No Record Found</td>
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

	<div id="deletecourse-modal" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
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
						<button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="deleteModalCourse">Delete</button>
						<input type = 'hidden'  id='course_id'>
						<input type = 'hidden'  id='course_action'>
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</section>

@endif
<!-- ============================ Dashboard: My Order Start End ================================== -->



<!-- Footer file include -->
@endsection
@section('js')
<script>
	$('.toggle-switch').change(function() {
        var checkbox = $(this);
		var rowNumber = checkbox.data('row');
        if (checkbox.is(':checked')) {
			$(".course_status_" + rowNumber + "").css('background-color', '#68bb0f');
        } else {
			$(".course_status_" + rowNumber + "").css('background-color', 'grey');
        }
    });
</script>
@endsection