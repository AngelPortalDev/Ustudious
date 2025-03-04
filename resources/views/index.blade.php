@extends('layouts.main')
@section('content')
<?php $ASSET_PATH = env('ASSET_URL').'/' ?>

<div class="clearfix"></div>
<!-- ============================================================== -->
<!-- Top header  -->
<!-- ============================================================== -->

<!-- ============================ Hero Banner  Start================================== -->
@php $CourseListName = DB::table('course')->select("course.Specialization")
 ->leftjoin("institute","institute.institute_id","=","course.InstituteID")
 ->where('institute.institute_status','1')
 ->where('course.ApprovalStatus','Approved')
->where('CourseStatus','Active')
->whereNull('course.deleted_at')
->whereNull('institute.deleted_at')
->distinct('course.Specialization')
->get()->take(20); @endphp
<div class="image-cover half_banner" style="background-image: url('{{ $ASSET_PATH }}img/home-banner/home-banner-1-01.jpg')">
    <!-- Content here -->
	<div class="container">
		<!-- Type -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="banner-search-2">
					<h1 class="cl_2 f_2 mb-2">Master New Skills<br><span class="theme-cl">Enroll Today!</span></h1>
					<p>Register now to elevate your expertise and shape your future!</p>
					
					<form  action="{{route('browse-course')}}" method="GET"> 
						@csrf
						<div class="row">
							<div class="input-group mt-2">
								<input type="text" class="form-control se-input searchCoursetitle" placeholder="Search Courses, Colleges, Exams"> 
							
								<div class="input-group-append">
									<button type="submit" class="btn btn-outline-secondary" >
										<img src="{{ $ASSET_PATH }}img/search.svg" class="search-icon" alt="" />
									</button> 
								</div>
							
					
						{{-- <div class="input-group-append col-md-2"> --}}
							{{-- <button class="btn btn-outline-secondary" type="button" ><img src="{{$ASSET_PATH}}img/search.svg"
									class="search-icon" alt="" /></button> --}}
							{{-- <button type="submit" class="btn btn-outline-secondary" >
								<img src="{{ $ASSET_PATH }}img/search.svg" class="search-icon" alt="" />
							</button> --}}

						{{-- </div> --}}
					
						<br><br>
						<select name="course_title" id="course_title" class="form-control  mb-2 select2"  style='display:none;' >
							
						</select>
					</div>
					</form>
				
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ============================ Hero Banner End ================================== -->

<!-- ============================ Trips Facts Start ================================== -->
<div class="trips_wrap full colored">
	<div class="container">
		<div class="row m-0">

			<div class="col-lg-4 col-md-4 col-sm-12 d-flex">
				<div class="trips">
					<div class="trips_icons">
						<i class="fas fa-graduation-cap"></i>
					</div>
					<div class="trips_detail">
						<h4>Programs and Courses</h4>
						<p>Explore our extensive catalogue of 1560 programs and courses tailored to your academic and professional aspirations.</p>
					</div>
				</div>
			</div>

			<div class="col-lg-4 col-md-4 col-sm-12 d-flex">
				<div class="trips">
					<div class="trips_icons">
						<i class="fas fa-university"></i>
					</div>
					<div class="trips_detail">
						<h4>Top Colleges and Universities</h4>
						<p>Discover 200 prestigious colleges and universities featured on our platform, renowned for their excellence in education and research.</p>
					</div>
				</div>
			</div>

			<div class="col-lg-4 col-md-4 col-sm-12 d-flex">
				<div class="trips none">
					<div class="trips_icons">
						<i class="fas fa-briefcase"></i>
					</div>
					<div class="trips_detail">
						<h4>Career Development Resources</h4>
						<p>Empower your career journey with our comprehensive collection of 1520 career development resources.</p>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- ============================ Trips Facts Start ================================== -->






<!-- ========================== Featured Category Section =============================== -->
<section class="bg-light">
	<div class="container">

		<div class="row justify-content-center">
			<div class="col-lg-5 col-md-6 col-sm-12">
				<div class="sec-heading center">
					<!-- <p>Popular Category</p> -->
					<h2>Course Categories</h2>
				</div>
			</div>
		</div>


		<div class="row">
			@php  $CourseCategory =DB::table('course_category')->select('id','course_category','course_category_image')->distinct()->get(); @endphp
            @foreach ($CourseCategory as $data)
			<div class="col-lg-4 col-md-4 col-sm-6">
				<div class="edu_cat_2 cat-1">
					<div class="edu_cat_icons">
						<a class="pic-main" href="#"><img src="{{$ASSET_PATH}}img/icons/{{$data->course_category_image}}"
								class="img-fluid" alt="" /></a>
					</div>
					<div class="edu_cat_data">

					
							<a href="{{route('browse-course', ['_token'=> csrf_token(),'course_category' => $data->id])}}"><h4 class="title">{{$data->course_category}}</h4></a>
							
						<ul class="meta">
							@php $CourseCount = DB::table('course')
								 ->leftjoin("institute","institute.institute_id","=","course.InstituteID")
								 ->where('institute.institute_status','1')
								->where('course.ApprovalStatus','Approved')
								->where('CourseStatus','Active')
								->where('CourseCategory',$data->id)
								->whereNull('course.deleted_at')
								->whereNull('institute.deleted_at')->count(); @endphp

							<li class="video">{{$CourseCount}}</li>
						</ul>
					</div>
				</div>
			</div>
			@endforeach
		<!-- 	<div class="col-lg-4 col-md-4 col-sm-6">
				<div class="edu_cat_2 cat-2">
					<div class="edu_cat_icons">
						<a class="pic-main" href="#"><img src="{{$ASSET_PATH}}img/icons/business-icon-01.png" class="img-fluid"
								alt="" /></a>
					</div>
					<div class="edu_cat_data">
						<h4 class="title"><a href="#">Business</a></h4>
						<ul class="meta">
							<li class="video"> 58 Courses</li>
						</ul>
					</div>
				</div>
			</div> -->

		<!-- 	<div class="col-lg-4 col-md-4 col-sm-6">
				<div class="edu_cat_2 cat-3">
					<div class="edu_cat_icons">
						<a class="pic-main" href="#"><img src="{{$ASSET_PATH}}img/icons/accounting-icon-01.png"
								class="img-fluid" alt="" /></a>
					</div>
					<div class="edu_cat_data">
						<h4 class="title"><a href="#">Accounting</a></h4>
						<ul class="meta">
							<li class="video"> 74 Courses</li>
						</ul>
					</div>
				</div>
			</div>
 -->
		<!-- 	<div class="col-lg-4 col-md-4 col-sm-6">
				<div class="edu_cat_2 cat-4">
					<div class="edu_cat_icons">
						<a class="pic-main" href="#"><img src="{{$ASSET_PATH}}img/icons/hospitality-icon-01.png"
								class="img-fluid" alt="" /></a>
					</div>
					<div class="edu_cat_data">
						<h4 class="title"><a href="#">Hospitality</a></h4>
						<ul class="meta">
							<li class="video"> 65 Courses</li>
						</ul>
					</div>
				</div>
			</div>
 -->
			<!-- <div class="col-lg-4 col-md-4 col-sm-6">
				<div class="edu_cat_2 cat-10">
					<div class="edu_cat_icons">
						<a class="pic-main" href="#"><img src="{{$ASSET_PATH}}img/icons/art-and-design-icon-01.png"
								class="img-fluid" alt="" /></a>
					</div>
					<div class="edu_cat_data">
						<h4 class="title"><a href="#">Art & Design</a></h4>
						<ul class="meta">
							<li class="video"> 43 Courses</li>
						</ul>
					</div>
				</div>
			</div> -->

		<!-- 	<div class="col-lg-4 col-md-4 col-sm-6">
				<div class="edu_cat_2 cat-6">
					<div class="edu_cat_icons">
						<a class="pic-main" href="#"><img src="{{$ASSET_PATH}}img/icons/marketing-icon-01.png" class="img-fluid"
								alt="" /></a>
					</div>
					<div class="edu_cat_data">
						<h4 class="title"><a href="#">Marketing</a></h4>
						<ul class="meta">
							<li class="video"> 82 Courses</li>
						</ul>
					</div>
				</div>
			</div> -->

		</div>

	</div>
</section>
<!-- ========================== Featured Category Section =============================== -->



<!-- ============================ Featured College Start ================================== -->
<section class="light-2 featured-college-section">
	<div class="container">

		<div class="row justify-content-center">
			<div class="col-lg-5 col-md-6 col-sm-12">
				<div class="sec-heading center">
					<!-- <p>New &amp; Trending</p> -->
					<h2>Featured Colleges</h2>
				</div>
			</div>
		</div>

		<div class="row">

			<!-- Cource Grid 1 -->
            @php $CollegeList = DB::table('institute')
			->select('institute.institute_id','institute.*','institute_contactinfo.campus','institute_contactinfo.total_courses','country_master.CountryName')
			->leftjoin("institute_contactinfo","institute_contactinfo.institute_id","=","institute.institute_id")
			->leftjoin("country_master","country_master.CountryID","=","institute.country_id")
			->whereNull('institute.deleted_at')
			->where('institute.institute_status','1')
			->get(); @endphp
            @foreach($CollegeList as $list)
		
			<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 d-flex">
				{{-- @if(count($list) > 3) --}}
				<div class="education_block_list_layout style-2">

					<div class="education_block_thumb n-shadow">

						<a href="{{route('college-details',$list->institute_id)}}">
							@if($list->institute_logo)
							<img src="{{Storage::url('institute/logo/'.$list->institute_logo)}}" class="img-fluid" alt=""></a>
							@else
							<img src="{{Storage::url('no-image.jpg')}}" class="img-fluid" alt=""></a>
							@endif
					</div>

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="{{route('college-details',$list->institute_id)}}">{{ $list->company_name }}</a></h4>
							<div class="_course_admin_ol12"><i class="ti-location-pin mr-1"></i>{{$list->CountryName}}</div>

							<div class="_course_less_infor">
								<ul>
									<li><i class="fas fa-graduation-cap mr-1"></i>{{ !empty($list->total_courses) ? $list->total_courses : '0' }} Courses</li>
									{{-- <li><i class="ti-star text-warning mr-2"></i>4.7 (453)</li> --}}
								</ul>
							</div>

						</div>

						<div class="education_block_footer">
							<div class="cources_info_style3">
								<a href="{{route('college-details',$list->institute_id)}}" class="_cr_detail_arrow"><i
										class="fa fa-arrow-right"></i></a>
							</div>
						</div>

					</div>

				</div>
              
			</div>
			{{-- @endif --}}
            @endforeach
			{{-- <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 d-flex">
				<div class="education_block_list_layout style-2">

					<div class="education_block_thumb n-shadow">
						<a href="course-detail.html"><img src="{{asset('img/CDP_Logo_PNG.png')}}" class="img-fluid"
								alt=""></a>
					</div>

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="course-detail.html">Collège de Paris</a></h4>
							<div class="_course_admin_ol12"><i class="ti-location-pin mr-1"></i>France</div>

							<div class="_course_less_infor">
								<ul>
									<li><i class="fas fa-graduation-cap mr-1"></i>14 Courses</li>
									<li><i class="ti-star text-warning mr-2"></i>4.7 (453)</li>
								</ul>
							</div>

						</div>

						<div class="education_block_footer">
							<div class="cources_info_style3">
								<a href="course-detail.html" class="_cr_detail_arrow"><i
										class="fa fa-arrow-right"></i></a>
							</div>
						</div>

					</div>

				</div>
			</div> --}}
			{{-- <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 d-flex">
				<div class="education_block_list_layout style-2">

					<div class="education_block_thumb n-shadow">
						<a href="course-detail.html"><img src="{{asset('img/Ascencia-Malta-Logo-01.png')}}" class="img-fluid"
								alt=""></a>
					</div>

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="course-detail.html">Ascencia Malta</a></h4>
							<div class="_course_admin_ol12"><i class="ti-location-pin mr-1"></i> Malta</div>

							<div class="_course_less_infor">
								<ul>
									<li><i class="fas fa-graduation-cap mr-1"></i>14 Courses</li>
									<li><i class="ti-star text-warning mr-2"></i>4.7 (453)</li>
								</ul>
							</div>

						</div>

						<div class="education_block_footer">
							<div class="cources_info_style3">
								<a href="course-detail.html" class="_cr_detail_arrow"><i
										class="fa fa-arrow-right"></i></a>
							</div>
						</div>

					</div>

				</div>
			</div> --}}
			{{-- <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 d-flex">
				<div class="education_block_list_layout style-2">

					<div class="education_block_thumb n-shadow">
						<a href="course-detail.html"><img src="{{asset('img/Ascencia-Valencia Logo.png')}}" class="img-fluid"
								alt=""></a>
					</div>

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="course-detail.html">Ascencia Valencia</a></h4>
							<div class="_course_admin_ol12"><i class="ti-location-pin mr-1"></i> Spain</div>

							<div class="_course_less_infor">
								<ul>
									<li><i class="fas fa-graduation-cap mr-1"></i>14 Courses</li>
									<li><i class="ti-star text-warning mr-2"></i>4.7 (453)</li>
								</ul>
							</div>

						</div>

						<div class="education_block_footer">
							<div class="cources_info_style3">
								<a href="course-detail.html" class="_cr_detail_arrow"><i
										class="fa fa-arrow-right"></i></a>
							</div>
						</div>

					</div>

				</div>
			</div> --}}
			{{-- <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 d-flex">
				<div class="education_block_list_layout style-2">

					<div class="education_block_thumb n-shadow">
						<a href="course-detail.html"><img src="{{asset('img/logo-2.jpeg')}}" class="img-fluid" alt=""></a>
					</div>

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="course-detail.html">Jagan Institute of Management Studies
									Technical Campus</a></h4>
							<div class="_course_admin_ol12"><i class="ti-location-pin mr-1"></i> India</div>

							<div class="_course_less_infor">
								<ul>
									<li><i class="fas fa-graduation-cap mr-1"></i>14 Courses</li>
									<li><i class="ti-star text-warning mr-2"></i>4.7 (453)</li>
								</ul>
							</div>

						</div>

						<div class="education_block_footer">
							<div class="cources_info_style3">
								<a href="course-detail.html" class="_cr_detail_arrow"><i
										class="fa fa-arrow-right"></i></a>
							</div>
						</div>

					</div>

				</div>
			</div> --}}
			{{-- <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 d-flex">
				<div class="education_block_list_layout style-2">

					<div class="education_block_thumb n-shadow">
						<a href="course-detail.html"><img src="{{asset('img/logo-3.jpeg')}}" class="img-fluid" alt=""></a>
					</div>

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="course-detail.html">International Institute of Business
									Studies</a></h4>
							<div class="_course_admin_ol12"><i class="ti-location-pin mr-1"></i> India</div>

							<div class="_course_less_infor">
								<ul>
									<li><i class="fas fa-graduation-cap mr-1"></i>14 Courses</li>
									<li><i class="ti-star text-warning mr-2"></i>4.7 (453)</li>
								</ul>
							</div>

						</div>

						<div class="education_block_footer">
							<div class="cources_info_style3">
								<a href="course-detail.html" class="_cr_detail_arrow"><i
										class="fa fa-arrow-right"></i></a>
							</div>
						</div>

					</div>



				</div>
			</div> --}}





		</div>
		{{-- <div class="row justify-content-center">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="text-center">
					<a href="#" class="btn btn-theme btn-browse-btn btn-blue">Browse More</a>
				</div>
			</div>
		</div> --}}

	</div>
</section>
<!-- ============================ Featured College End ================================== -->


<!-- ============================ Featured Courses Start ================================== -->
<section class="featured-course-section">
	<div class="container">

		<div class="row justify-content-center">
			<div class="col-lg-5 col-md-6 col-sm-12">
				<div class="sec-heading center">
					<!-- <p>New &amp; Trending</p> -->
					<h2>Top Courses</h2>
				</div>
			</div>
		</div>

		<div class="row">
			@php $CourseList = DB::table('course')->select("course.CourseName","institute.company_name","duration_master.Duration","intakemonth_master.Intakemonth","intakeyear_master.Intakeyear","course.TotalCost","course.CourseID","course.Brochure","institute.institute_id","course.created_by")
			->leftjoin("institute","institute.institute_id","=","course.InstituteID")
			->leftjoin("duration_master","duration_master.DurationID","=","course.CourseDuration")
			->leftjoin("intakemonth_master","intakemonth_master.IntakemonthID","=","course.IntakeMonth")
			->leftjoin("intakeyear_master","intakeyear_master.IntakeyearID","=","course.IntakeYear")
			->whereNull('course.deleted_at')
			->whereNull('institute.deleted_at')
			->where('course.ApprovalStatus','Approved')                    
			->where('CourseStatus','Active')   
			->take(6)
			->get();
			@endphp
			
			@foreach($CourseList as $list)
			<!-- Cource Grid 1 -->
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex">
				<div class="education_block_list_layout style-2">

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="{{route('course-details',base64_encode($list->CourseID))}}">{{$list->CourseName}}
								</a></h4>
							<div class="_course_admin_ol12">
								<i class="fa fa-university"></i>
								<a href="{{route('college-details',$list->institute_id)}}" target="_blank">{{$list->company_name}}</a>
							</div>


						</div>
						{{-- <div class="save-btn"> --}}
							{{-- <a href=""><i class="far fa-bookmark" aria-hidden="true"></i></a> --}}
							{{-- <a class='stlogincheck'><i class='far fa-bookmark' aria-hidden='true' style='color: #11a1f5;'></i></a> --}}
							@if (session()->get('student_id'))
								<?php $exists = DB::table('students_viewed_courses')->where('course_id',$list->CourseID)->where('student_id',session()->get('student_id'))->where('is_saved','Yes')->count();  

								if($exists != 0){ ?>
									<div class="save-btn"><a class="actions"  data-is_toggle="No" data-course_action="Saved" data-dashjs="0" data-course_id="{{base64_encode($list->CourseID)}}" data-posted_by="{{base64_encode($list->created_by)}}"><i class="fa-bookmark fa" style="color: #11a1f5;"></i></a></div>
									
								<?php }else{ ?>

									<div class="save-btn"><a class="actions"  data-is_toggle="Yes" data-course_action="Unsaved" data-dashjs="0" data-course_id="{{base64_encode($list->CourseID)}}" data-posted_by="{{base64_encode($list->created_by)}}"><i class="far fa-bookmark" style="color: #11a1f5;"></i></a></div>

								<?php } ?>
									
							@else
								@if (session()->get('institute_id') == '')

								  <div class='save-btn'><a class='stlogincheck'><i class='far fa-bookmark' aria-hidden='true' style='color: #11a1f5;'></i></a></div>
								  
								@endif
							@endif
						{{-- </div> --}}

						<div class="row">
							<div class="col-md-8 course-details-h-2">

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Intake:</label>
										<div class="cou-value">{{ $list->Intakemonth }}</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Duration:</label>
										<div class="cou-value">{{ $list->Duration }}</div>
									</div>
								</div>

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Campus:</label>
										<div class="cou-value">Paris</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Fees:</label>
										<div class="cou-value">€ <?= $list->TotalCost ?>
											 {{-- <a class="fee-details" href="#"> Fee Details</a> --}}
										</div>
									</div>
								</div>

							</div>

							<div class="col-md-4">
								<div class="cou-buttons">

									
									{{-- <div class="save-btn"> --}}
										{{-- <button class="apply-btn stlogincheck"><i class="fa fa-arrow-right"></i> Apply</button> --}}


										@if(session()->has('student_id'))
											<?php $exists = DB::table('student_applied_course')->where('course_id',$list->CourseID)->where('student_id',session()->get('student_id'))->where('is_applied','yes')->count();
		   
											    if($exists != 0){ ?>
												   <button class="apply-btn" style=" cursor: default; "><i class="fa fa-arrow-right"></i> Applied</button>
											    <?php }else{ ?>
												   <button class="apply-btn actions"  data-is_toggle="yes" data-course_action="apply" data-dashjs="0" data-course_id="{{base64_encode($list->CourseID)}}" data-posted_by="{{base64_encode($list->created_by)}}"><i class="fa fa-arrow-right"></i> Apply</a>
											    <?php } ?>
										@else
											@if (session()->get('institute_id') == '')		
											   <button class="apply-btn stlogincheck"><i class="fa fa-arrow-right"></i> Apply</button>
											@endif
										@endif
									{{-- </div> --}}

									{{-- <button class="download-brochure"> <i class="fa fa-download" aria-hidden="true"></i>
										Brochure</button> --}}
									<?php
									$filePath =  Storage::url('course/brochure/'.$list->Brochure);  
									if (isset($list->Brochure) && !empty($list->Brochure)){
									?>
										<button class="download-brochure"  onclick="downloadBrochure('<?php echo $filePath ?>')" ><i class="fa fa-download" aria-hidden="true"></i> Brochure</button>
									<?php } ?>
								</div>
							</div>

						</div>


					</div>

				</div>
			</div>
			@endforeach


			{{-- <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex">
				<div class="education_block_list_layout style-2">

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="course-detail.html">Doctor of Philosophy (Ph.D.) </a></h4>
							<div class="_course_admin_ol12">
								<i class="fa fa-university"></i>
								<a href="https://www.collegedeparis.com/" target="_blank">Tata College</a>
							</div>


						</div>
						<div class="save-btn">
							<a href=""><i class="fa fa-bookmark" aria-hidden="true"></i></a>
						</div>

						<div class="row">
							<div class="col-md-8 course-details-h-2">

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Intake:</label>
										<div class="cou-value">July</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Duration:</label>
										<div class="cou-value">12 Months</div>
									</div>
								</div>

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Campus:</label>
										<div class="cou-value">Mumbai</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Fees:</label>
										<div class="cou-value">₹8 L <a class="fee-details" href="#"> Fee Details</a>
										</div>
									</div>
								</div>

							</div>

							<div class="col-md-4">
								<div class="cou-buttons">

									<button class="apply-btn"><i class="fa fa-arrow-right"></i> Apply</button>

									<button class="download-brochure"> <i class="fa fa-download" aria-hidden="true"></i>
										Brochure</button>
								</div>
							</div>

						</div>


					</div>

				</div>
			</div>



			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex">
				<div class="education_block_list_layout style-2">

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="course-detail.html">B.Sc. (Hons.) in Mathematics </a></h4>
							<div class="_course_admin_ol12">
								<i class="fa fa-university"></i>
								<a href="https://www.collegedeparis.com/" target="_blank">Ascencia Valencia</a>
							</div>


						</div>
						<div class="save-btn">
							<a href=""><i class="fa fa-bookmark" aria-hidden="true"></i></a>
						</div>

						<div class="row">
							<div class="col-md-8 course-details-h-2">

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Intake:</label>
										<div class="cou-value">July</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Duration:</label>
										<div class="cou-value">12 Months</div>
									</div>
								</div>

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Campus:</label>
										<div class="cou-value">Valencia</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Fees:</label>
										<div class="cou-value">₹8 L <a class="fee-details" href="#"> Fee Details</a>
										</div>
									</div>
								</div>

							</div>

							<div class="col-md-4">
								<div class="cou-buttons">

									<button class="apply-btn"><i class="fa fa-arrow-right"></i> Apply</button>

									<button class="download-brochure"> <i class="fa fa-download" aria-hidden="true"></i>
										Brochure</button>
								</div>
							</div>

						</div>


					</div>

				</div>
			</div> --}}


{{-- 
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex">
				<div class="education_block_list_layout style-2">

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="course-detail.html">M.Sc. in Food Technology </a></h4>
							<div class="_course_admin_ol12">
								<i class="fa fa-university"></i>
								<a href="https://www.collegedeparis.com/" target="_blank">ASP College</a>
							</div>


						</div>
						<div class="save-btn">
							<a href=""><i class="fa fa-bookmark" aria-hidden="true"></i></a>
						</div>

						<div class="row">
							<div class="col-md-8 course-details-h-2">

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Intake:</label>
										<div class="cou-value">July</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Duration:</label>
										<div class="cou-value">12 Months</div>
									</div>
								</div>

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Campus:</label>
										<div class="cou-value">Paris</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Fees:</label>
										<div class="cou-value">₹8 L <a class="fee-details" href="#"> Fee Details</a>
										</div>
									</div>
								</div>

							</div>

							<div class="col-md-4">
								<div class="cou-buttons">

									<button class="apply-btn"><i class="fa fa-arrow-right"></i> Apply</button>

									<button class="download-brochure"> <i class="fa fa-download" aria-hidden="true"></i>
										Brochure</button>
								</div>
							</div>

						</div>


					</div>

				</div>
			</div> --}}



			{{-- <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex">
				<div class="education_block_list_layout style-2">

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="course-detail.html"> Discontinued (July 2024)- M. Sc. in
									Biotechnology </a></h4>
							<div class="_course_admin_ol12">
								<i class="fa fa-university"></i>
								<a href="https://www.collegedeparis.com/" target="_blank">Ecole Conte</a>
							</div>


						</div>
						<div class="save-btn">
							<a href=""><i class="fa fa-bookmark" aria-hidden="true"></i></a>
						</div>

						<div class="row">
							<div class="col-md-8 course-details-h-2">

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Intake:</label>
										<div class="cou-value">July</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Duration:</label>
										<div class="cou-value">12 Months</div>
									</div>
								</div>

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Campus:</label>
										<div class="cou-value">Lyon</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Fees:</label>
										<div class="cou-value">₹8 L <a class="fee-details" href="#"> Fee Details</a>
										</div>
									</div>
								</div>

							</div>

							<div class="col-md-4">
								<div class="cou-buttons">

									<button class="apply-btn"><i class="fa fa-arrow-right"></i> Apply</button>

									<button class="download-brochure"> <i class="fa fa-download" aria-hidden="true"></i>
										Brochure</button>
								</div>
							</div>

						</div>


					</div>

				</div>
			</div> --}}



			{{-- <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex">
				<div class="education_block_list_layout style-2">

					<div class="list_layout_ecucation_caption">

						<div class="education_block_body">
							<h4 class="bl-title"><a href="course-detail.html">Discontinued (Apr 2023)- M. Sc. in
									Biotechnology </a></h4>
							<div class="_course_admin_ol12">
								<i class="fa fa-university"></i>
								<a href="https://www.collegedeparis.com/" target="_blank">Ascencia Malta</a>
							</div>


						</div>
						<div class="save-btn">
							<a href=""><i class="fa fa-bookmark" aria-hidden="true"></i></a>
						</div>

						<div class="row">
							<div class="col-md-8 course-details-h-2">

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Intake:</label>
										<div class="cou-value">July</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Duration:</label>
										<div class="cou-value">12 Months</div>
									</div>
								</div>

								<div class="course-details-1">
									<div class="c-d-2">
										<label class="abcd">Campus:</label>
										<div class="cou-value">Valletta</div>
									</div>
									<div class="c-d-2">
										<label class="abcd">Fees:</label>
										<div class="cou-value">₹8 L <a class="fee-details" href="#"> Fee Details</a>
										</div>
									</div>
								</div>

							</div>

							<div class="col-md-4">
								<div class="cou-buttons">

									<button class="apply-btn"><i class="fa fa-arrow-right"></i> Apply</button>

									<button class="download-brochure"> <i class="fa fa-download" aria-hidden="true"></i>
										Brochure</button>
								</div>
							</div>

						</div>


					</div>

				</div>
			</div> --}}



		</div>


		<div class="row justify-content-center">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="text-center">
					<a href="{{route('browse-course')}}" class="btn btn-theme btn-browse-btn btn-blue">Browse More</a>
				</div>
			</div>
		</div>

	</div>
</section>
<!-- ============================ Featured Courses End ================================== -->




<!-- ========================== Articles Section =============================== -->
<section class="bg-light">
	<div class="container">

		<div class="row justify-content-center">
			<div class="col-lg-5 col-md-6 col-sm-12">
				<div class="sec-heading center">
					<!-- <p>Our Story</p> -->
					<h2>Colleges by Countries</h2>
				</div>
			</div>
		</div>

		<div class="row">

			<!-- Single Article -->
			<div class="col-lg-3 col-md-4 col-sm-12 d-flex">
				{{-- <a href="{{route('browse-course', ['_token'=> csrf_token(),'course_coutry' => base64_encode('17')])}}"> --}}
				<div class="articles_grid_style">
					<div class="articles_grid_thumb">
						<img src="{{$ASSET_PATH}}img/france-thumbnail.jpg" class="img-fluid"
								alt="" />
					</div>
					@php $CollegewiseCount = DB::table('institute')
						->leftjoin("institute_contactinfo","institute.institute_id","=","institute_contactinfo.institute_id")
						->where('institute.institute_status','1')
						->where('country','17')
						->whereNull('institute.deleted_at')->count(); @endphp
					<div class="articles_grid_caption">
						<h4>Top {{$CollegewiseCount}} Colleges in France</h4>

					</div>
				</div>
				{{-- </a> --}}
			</div>
			<div class="col-lg-3 col-md-4 col-sm-12 d-flex">
				<div class="articles_grid_style">
					<div class="articles_grid_thumb">
						<img src="{{$ASSET_PATH}}img/spain-thumbnail.jpg" class="img-fluid"
								alt="" />
					</div>
					@php $CollegewiseCount = DB::table('institute')
						->leftjoin("institute_contactinfo","institute.institute_id","=","institute_contactinfo.institute_id")
						->where('institute.institute_status','1')
						->where('country','10')
						->whereNull('institute.deleted_at')->count(); @endphp
					<div class="articles_grid_caption">
						<h4>Top {{$CollegewiseCount}} Colleges in Spain</h4>

					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-12 d-flex">
				<div class="articles_grid_style">
					<div class="articles_grid_thumb">
						<img src="{{$ASSET_PATH}}img/malta-thumbnail.jpg" class="img-fluid"
								alt="" />
					</div>
					@php $CollegewiseCount = DB::table('institute')
					->leftjoin("institute_contactinfo","institute.institute_id","=","institute_contactinfo.institute_id")
					->where('institute.institute_status','1')
					->where('country','58')
					->whereNull('institute.deleted_at')->count(); @endphp
					<div class="articles_grid_caption">
						<h4>Top {{$CollegewiseCount}} Colleges in Malta</h4>

					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-12 d-flex">
				<div class="articles_grid_style">
					<div class="articles_grid_thumb">
						<img src="{{$ASSET_PATH}}img/belgium-photo-new.jpg" class="img-fluid"
								alt="" />
					</div>
					@php $CollegewiseCount = DB::table('institute')
					->leftjoin("institute_contactinfo","institute.institute_id","=","institute_contactinfo.institute_id")
					->where('institute.institute_status','1')
					->where('country','59')
					->whereNull('institute.deleted_at')->count(); @endphp
					<div class="articles_grid_caption">
						<h4>Top {{$CollegewiseCount}} Colleges in Belgium</h4>

					</div>
				</div>
			</div>


		</div>
	</div>
</section>
<!-- ========================== Articles Section =============================== -->






<!-- ========================== Articles Section =============================== -->
<section class="">
	<div class="container">

		<div class="row justify-content-center">
			<div class="col-lg-5 col-md-6 col-sm-12">
				<div class="sec-heading center">
					<!-- <p>Our Story</p> -->
					<h2>Trending on Ustudious</h2>
				</div>
			</div>
		</div>

		<div class="row">

			<!-- Single Article -->
			<div class="col-lg-12">

				<div class="trending-container">
					<div>
						<div class="cap-sec">
							<div class="content-main-cap">
								<ul class="taglist">
									@foreach($CourseListName as $list)

									@if($list->Specialization)
									<li><a class="capsule capsule--purple ripple dark specialization" href="{{route('browse-course', ['_token'=> csrf_token(),'specialization' => $list->Specialization])}}"
											href="#">{{$list->Specialization}}</a></li>
									@endif
									@endforeach
									<!-- <li><a class="capsule capsule--purple ripple dark"
											href="#">VIT Vellore</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">DTU</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">Galgotias
											University</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">BHU</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">JEE Main</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">MHT CET</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">TS EAMCET</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">COMEDK UGET</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">IMUCET</a>
									</li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">B. Tech</a></li>
									<li><a class="capsule capsule--purple ripple dark" href="#">Ph.D.</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">Computer Science
											Engineering</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">Engineering</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">M.E./M.Tech</a></li>

											
									<li><a class="capsule capsule--purple ripple dark"
											href="#">COMEDK UGET</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">IMUCET</a>
									</li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">B. Tech</a></li>
									<li><a class="capsule capsule--purple ripple dark" href="#">Ph.D.</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">Computer Science
											Engineering</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">Engineering</a></li>
									<li><a class="capsule capsule--purple ripple dark"
											href="#">M.E./M.Tech</a></li> -->
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</section>
<!-- ========================== Articles Section =============================== -->



<!-- ============================ Working Process Start ================================== -->
<section>
	<div class="container">
	
		<div class="row justify-content-center">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="sec-heading center">
					<p>Exploring Paths to Success</p>
					<h2>Explore Limitless Learning</h2>
				</div>
			</div>
		</div>
		
		<div class="row">
			
			<!-- Cource Grid 1 -->
			<div class="col-lg-4 col-md-4 col-sm-12">
				<div class="_wrk_prc_wrap" style="cursor: default;">
					<div class="_wrk_prc_thumb">
						<img src="{{$ASSET_PATH}}img/course-steps-icon-01.png" class="img-fluid" alt="" />
					</div>
					<div class="_wrk_prc_caption">
						<h4>Explore Opportunities and Courses</h4>
						<p>Explore our website to discover the diverse wide range of courses available from various colleges and countries. From traditional academic programs to high-quality courses and trending future-oriented programs, we have everything you need to enhance your skills and ensure success in various fields.</p>
					</div>
				</div>
			</div>
			
			<!-- Cource Grid 1 -->
			<div class="col-lg-4 col-md-4 col-sm-12">
				<div class="_wrk_prc_wrap" style="cursor: default;">
					<div class="_wrk_prc_thumb">
						<img src="{{$ASSET_PATH}}img/course-steps-icon-02.png" class="img-fluid" alt="" />
					</div>
					<div class="_wrk_prc_caption">
						<h4>Register to Enroll into the Course</h4>
						<p>When students register on our platform, they gain access to enrolling in desired courses or colleges and exclusive features and personalized recommendations aligned with their academic and career objectives. It is crucial to complete their profile with details such as education, interests, skills, and career objectives.</p>
					</div>
				</div>
			</div>
			
			<!-- Cource Grid 1 -->
			<div class="col-lg-4 col-md-4 col-sm-12">
				<div class="_wrk_prc_wrap" style="cursor: default;">
					<div class="_wrk_prc_thumb">
						<img src="{{$ASSET_PATH}}img/course-steps-icon-03.png" class="img-fluid" alt="" />
					</div>
					<div class="_wrk_prc_caption">
						<h4>Join our community to Succeed</h4>
						<p>Join our diverse global student community to connect with peers, mentors, and professionals worldwide. Engage in forums and events to share ideas, seek advice, and build valuable connections. Access exclusive resources and support on our platform to boost your academic success, personal growth, and career prospects.</p>
					</div>
				</div>	
			</div>						
			
		</div>
		
	</div>
</section>
<!-- ============================ Working Process End ================================== -->



<!-- ============================ Testimonial Start ================================== -->
<section style="background-image: url('{{$ASSET_PATH}}img/testimonial.png')">
	<div class="container">

		<div class="row justify-content-center">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="sec-heading center">
					<p>What Students Say?</p>
					<h2>Reviews by Our Success & Top Students</h2>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div id="testimonials_style" class="slick-carousel-3 arrow_middle">
					<div class="testimonial-detail">
						<div class="client-detail-box">
							<div class="pic">
								<img src="{{$ASSET_PATH}}img/student-face-01.png" alt="">
							</div>
							<div class="client-detail">
								<h3 class="testimonial-title">Mariya Suzain</h3>
								<span class="post">Student, College de Paris</span>
							</div>
						</div>
						<p class="description">
							"I am so grateful to have found this international education portal! The range of courses available is astounding – from traditional subjects to cutting-edge programs, there's something for everyone. Registering was a breeze, and I love the personalized recommendations. Being part of the global student community has opened up many networking and support opportunities."
						</p>
					</div>

					<div class="testimonial-detail">
						<div class="client-detail-box">
							<div class="pic">
								<img src="{{$ASSET_PATH}}img/student-face-02.png" alt="">
							</div>
							<div class="client-detail">
								<h3 class="testimonial-title">Tarque Faizan</h3>
								<span class="post">Student, Ascencia Valencia</span>
							</div>
						</div>
						<p class="description">
							"While searching for colleges, I stumbled upon this international education portal, and I'm so glad I did! The sheer number of programs and courses available is incredible – it's like having a world of educational opportunities at my fingertips. Registering was quick and easy, and the personalized recommendations made the process smoother. Being part of the global student community has given me access to invaluable resources and support."
						</p>
					</div>

					<div class="testimonial-detail">
						<div class="client-detail-box">
							<div class="pic">
								<img src="{{$ASSET_PATH}}img/student-face-03.png" alt="">
							</div>
							<div class="client-detail">
								<h3 class="testimonial-title">Yasmin Al-Abdullah</h3>
								<span class="post">Student, Ascencia Malta</span>
							</div>
						</div>
						<p class="description">
							" Signing up for this international education portal was one of the best decisions I've made! The array of courses catered to all interests and career paths, making it easy for me to find exactly what I was looking for. The registration process was straightforward, and the personalized recommendations helped me explore options I hadn't considered before. Plus, being part of the global student community has allowed me to connect with peers from diverse backgrounds, opening doors to endless networking opportunities."
						</p>
					</div>


				</div>
			</div>
		</div>

	</div>
</section>
<!-- ============================ Testimonial End ================================== -->

<!-- ============================== Start Newsletter ================================== -->
<section class="newsletter theme-bg inverse-theme">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-7 col-md-8 col-sm-12">
				<div class="text-center">
					<h2>Join Thousand of Happy Students!</h2>
					<p>Subscribe our newsletter & get latest news and updation!</p>
					<form class="sup-form newsLetter">
						@csrf
						<input type="email" class="form-control sigmup-me newsemail" name="email" placeholder="Your Email Address"
							required="required">
						<input type="button" class="btn btn-theme" value="Get Started" id="newsletterSend">
						<small class="newmail_error" style="color:white;display:none;">
							<i>Please provide valid email </i>
						</small>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ================================= End Newsletter =============================== -->




<!-- Footer file include -->

@endsection
@section('js')

<script>
$(document).ready(function(){
   
	$('.select2').select2();
});
</script>
@endsection