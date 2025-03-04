<!-- Header file include -->
@extends('layouts.main')
@section('content')
<?php $ASSET_PATH = env('ASSET_URL').'/' ?>
		<div class="college-heading-top-section lg">
			<div class="container">
				<div class="row">

					<div class="college-cover-img">
						
							<?php 
						
							if (isset($Colleges->institute_banner) && !empty($Colleges->institute_banner)){
								$filePath =  Storage::url('institute/banner/'.$Colleges->institute_banner); 
								?>
							<img src="{{$filePath}}" class="img-fluid avater" alt="" width="1200" height="200">
							<?php }else{ 
								$filePaths =  Storage::url('no-image.jpg'); ?>
								<img src="{{$filePaths}}" class="img-fluid avater" alt="" width="1200" height="200">
							<?php } ?>

					</div>


					<div class="col-lg-12 col-md-12">

						<div class="college-logo">
							
							<?php 
							if (isset($Colleges->institute_logo) && !empty($Colleges->institute_logo)){
							$filePath =  Storage::url('institute/logo/'.$Colleges->institute_logo); 
							?>
							<img src="{{$filePath}}" class="img-fluid avater" width="120" height="120" >
							<?php }else{
								$filePath =  Storage::url('no-image.jpg'); ?>
								<img src="{{$filePath}}" class="img-fluid avater" width="120" height="120" >
							<?php } ?>

						</div>


						<div class="inline_edu_wraps mb-2 course-name-section">
							<h2 class="college-name-heading"><?= $Colleges->company_name ?></h2>



							<div class="college-name mb-3">
							<i class="ti-location-pin mr-1"></i> {{$Colleges->CountryName}}
							</div>

							<!-- <div class="ed_header_caption">
								<ul>
									<li><i class="ti-calendar"></i>10 - 20 weeks</li>
									<li><i class="ti-control-forward"></i>102 Lectures</li>
									<li><i class="ti-user"></i>502 Student Enrolled</li>
								</ul>
							</div> -->

							{{-- <div class="ed_rate_info">
								<div class="star_info">
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star"></i>
								</div>
								<div class="review_counter">
									<strong class="good">4.0 </strong> (3572 Reviews)
								</div>
							</div> --}}

							<div class="course-btn-sec">

									<div class="btns-ma">
										<!-- <button class="apply-btn"><i class="fa fa-bookmark" aria-hidden="true"></i> Save</button> -->
										<?php
									$filePath =  Storage::url('institute/idproof/'.$Colleges->institute_idproof);  
									if (isset($Colleges->institute_idproof) && !empty($Colleges->institute_idproof)){
									?>
										<button class="download-brochure"  onclick="downloadBrochure('<?php echo $filePath ?>')" ><i class="fa fa-download" aria-hidden="true"></i> Brochure</button>
									<?php } ?>
										{{-- <button class="download-brochure"> <i class="fa fa-download" aria-hidden="true"></i> Brochure</button>
										</div> --}}
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- ============================ Course Detail ================================== -->
		<section class="border college-details-page-main">
			<div class="container">


				<div class="row">

					<div class="col-lg-4 col-md-4">

						<!-- Course info -->
						<div class="ed_view_box style_3 border ">


							<div class="p-4 b-b">
								<ul class="edu_list right">
									@php $InstitutionType = "Not Disclosed" @endphp
									@if($Colleges->type == 'university')
										@php $InstitutionType = "University" @endphp
									@elseif($Colleges->type == 'school') 
										@php $InstitutionType = "School/Colleges"; @endphp
									@elseif($Colleges->type == 'institute') 
										@php $InstitutionType = "Institute"; @endphp
									@endif

									@php $Ownership = "Not Disclosed" @endphp
									@if($Colleges->ownership === 'private')
										@php $Ownership = "Private" @endphp
									@elseif($Colleges->ownership === 'public') 
										@php $Ownership = "Public / Government"; @endphp
									@elseif($Colleges->ownership === 'public_private') 
										@php $Ownership = "Public Private"; @endphp
									@endif
									<li><i class="ti-user"></i>Campus:<strong>{{ !empty($Colleges->campus) ? $Colleges->campus : 'Not Disclosed' }}</strong></li>
									<li><i class="ti-files"></i>Ownership:<strong><?= $Ownership ?></strong></li>
									<li><i class="ti-game"></i>Institution Type :<strong><?= $InstitutionType ?></strong></li>
									<li><i class="ti-time"></i>Total Courses:<strong>{{ !empty($Colleges->total_courses) ? $Colleges->total_courses : 'Not Disclosed' }}</strong></li>
									<li><i class="ti-time"></i>Total Students:<strong>{{ !empty($Colleges->total_students) ? $Colleges->total_students : 'Not Disclosed' }}</strong></li>
									<li><i class="ti-tag"></i>Founded In:<strong>{{ !empty($Colleges->founded) ? $Colleges->founded : 'Not Disclosed' }}</strong></li>

								</ul>
							</div>


							@if($Colleges->twitter || $Colleges->website_link || $Colleges->linkedin || $Colleges->instagram || $Colleges->youtube || $Colleges->facebook)
							<div class="px-4 pt-4 pb-0 b-t">
								<h5 class="mb-3">Follow Us</h5>
								@if($Colleges->website_link)
								<div class="mb-1">Website: <strong><a href="{{$Colleges->website_link}}" target="_blank">{{$Colleges->website_link}}</a></strong></div>
								@endif
								<div class="inline_edu_wrap ">

									<ul class="social_info">
										@if($Colleges->facebook)
										<li><a href="{{$Colleges->facebook}}" target="_blank"><i class="ti-facebook"></i></a></li>
										@endif
										{{-- <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
											<a class="a2a_button_facebook"></a>
											<a class="a2a_button_whatsapp"></a>
											<a class="a2a_button_telegram"></a>
											<a class="a2a_button_email"></a>
										</div>
										<script async src="https://static.addtoany.com/menu/page.js"></script> --}}
											<!-- AddToAny END -->
										@if($Colleges->twitter)
										<li><a href="{{$Colleges->twitter}}" target="_blank"><i class="ti-twitter"></i></a></li>
										@endif
										@if($Colleges->linkedin)
										<li><a href="{{$Colleges->linkedin}}" target="_blank"><i class="ti-linkedin"></i></a></li>
										@endif
										@if($Colleges->instagram)
										<li><a href="{{$Colleges->instagram}}" target="_blank"><i class="ti-instagram"></i></a></li>
										@endif
										@if($Colleges->youtube)
										<li><a href="{{$Colleges->youtube}}" target="_blank"><i class="ti-youtube"></i></a></li>
										@endif
									</ul>
								</div>
							</div>
							@endif



						</div>

					</div>


					<div class="col-lg-8 col-md-8">
						@php $Images = DB::table('institute_images')->where('institute_id',$Colleges->institute_id)->get(); 
						$currentUrl = Request::url();$parts = explode('/', $currentUrl);

						@endphp 
						<!-- All Info Show in Tab -->
						<div class="tab_box_info  border p-3">
							<ul class="nav nav-pills mb-3 light" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="overview-tab" data-toggle="pill" href="#overview"
										role="tab" aria-controls="overview" aria-selected="true">Overview</a>
								</li>
								{{-- @if(count($CoursesList) > 0) --}}
								<li class="nav-item">
									<a class="nav-link" id="courses-tab" data-toggle="pill" href="#courses"
										role="tab" aria-controls="courses" aria-selected="false">Courses</a>
								</li>
								{{-- @endif --}}
								@if(count($Images) > 0)
								<li class="nav-item">
									<a class="nav-link" id="gallery-main-tab" data-toggle="pill" href="#gallery-main"
										role="tab" aria-controls="gallery-main" aria-selected="true">Gallery</a>
								</li>
								@endif

							</ul>

							<div class="tab-content" id="pills-tabContent">

								<!-- Overview Detail -->
								<div class="tab-pane fade show active" id="overview" role="tabpanel"
									aria-labelledby="overview-tab">
									<!-- About Institution -->
									<div class="edu_wraper">
										<h4 class="edu_title">About Institution</h4>
										<p>{{ !empty($Colleges->about_institute) ? $Colleges->about_institute : 'Not Disclosed' }}</p>
										
									</div>

									<!-- Institution Details-->
									<div class="edu_wraper instutution-details">
										<h4 class="edu_title">Institution Details</h4>
										<ul>
											<li><strong>Contact Person:</strong>{{ !empty($Colleges->contact_person_name) ? $Colleges->contact_person_name : 'Not Disclosed' }}</li>
											<li><strong>Email:</strong>{{ !empty($Colleges->contact_email) ? $Colleges->contact_email : 'Not Disclosed' }} </li>
											<li><strong>Mobile:</strong>{{ !empty($Colleges->contact_mobile) ? $Colleges->country_code.' '.$Colleges->contact_mobile : 'Not Disclosed' }}  </li>
											<li><strong>Address:</strong> {{ !empty($Colleges->city) ? $Colleges->address.' '.$Colleges->city.' '.$Colleges->state.' '. $Colleges->pincode : 'Not Disclosed' }}</li>

										</ul>
										
									</div>

									<!-- Facilities -->
									<div class="ed_view_features ">
										<h4 class="edu_title">Institution Features</h4>

										<ul>{{ !empty($Colleges->features) ? $Colleges->features : 'Not Disclosed' }}
											
											{{-- <li><i class="ti-angle-right"></i>Fully Programming</li>
											<li><i class="ti-angle-right"></i>Help Code to Code</li>
											<li><i class="ti-angle-right"></i>Free Trial 7 Days</li>
											<li><i class="ti-angle-right"></i>Unlimited Videos</li>
											<li><i class="ti-angle-right"></i>24x7 Support</li> --}}
										</ul>
									</div>
								</div>

								<!-- Gallery Detail -->
								<div class="tab-pane fade " id="gallery-main" role="tabpanel"
									aria-labelledby="gallery-main-tab">
									<!-- About Institution -->
									{{-- <div class="grid-container">
										<div class="container__img-holder">
										<img src="{{$ASSET_PATH}}img/cdp-campus-1.png" class=""></div>
								  
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-2.png" class=""></div>
								  
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-5.jpeg" class=""></div>
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-3.png" class=""></div>
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-4.png" class=""></div>
								  
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-6.jpg" class=""></div>
								  
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-7.png" class=""></div>
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-8.jpeg" class=""></div>


										
									</div> --}}
									@php $Images = DB::table('institute_images')->where('institute_id',$Colleges->institute_id)->get(); @endphp 
									<div class="grid-container">
										@foreach($Images as $images)
										@php $path = 'institute/gallery_images_'.$images->institute_id @endphp
										<div class="container__img-holder"><img src="{{Storage::url($path.'/'.$images->images)}}" class=""></div>
										{{-- <div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-2.png" class=""></div>
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-5.jpeg" class=""></div>
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-3.png" class=""></div>
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-4.png" class=""></div>
									
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-6.jpg" class=""></div>
									
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-7.png" class=""></div>
										<div class="container__img-holder"><img src="{{$ASSET_PATH}}img/cdp-campus-8.jpeg" class=""></div> --}}
										@endforeach
									</div>
									  
									  <div class="img-popup">
										<img src="" alt="Popup Image">
										<div class="close-btn">
										  <div class="bar"></div>
										  <div class="bar"></div>
										</div>
									  </div>
								</div>

								<!-- courses Detail -->
								<div class="tab-pane fade courses-tab-college-details-page" id="courses" role="tabpanel"
									aria-labelledby="courses-tab">
									
										
									<div class="row browse-courses-page-main">
										{{-- @foreach ($CoursesList as $data ) --}}
										<!-- Cource Grid 1 -->
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 college-courses-page-main">
											<?=  $html; ?>
										</div>
					
										<!-- Cource Grid 1 -->
										{{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
											<div class="education_block_list_layout style-2">
					
												
					
												<div class="list_layout_ecucation_caption">

									
							
													<div class="education_block_body">
														<h4 class="bl-title course-name  "><a href="course-detail.html">Discontinued (July 2024)- M. Sc. in Biotechnology</a></h4>
							
													</div>
													<div class="save-btn">
														<a href=""><i class="fa fa-bookmark" aria-hidden="true"></i></a>
													</div>
															
													<div class="row">
														<div class="col-md-8 course-details-h-2">
							
															<div class="course-details-1">
																<div class="c-d-2">
																	<label class="abcd"> Intake:</label>
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
																	<div class="cou-value">Delhi</div>
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
					
										<!-- Cource Grid 1 -->
										{{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
											<div class="education_block_list_layout style-2">
					
												
					
												<div class="list_layout_ecucation_caption">

									
							
													<div class="education_block_body">
														<h4 class="bl-title course-name  "><a href="course-detail.html">B.Sc. (Hons.) in Mathematics</a></h4>
							
													</div>
													<div class="save-btn">
														<a href=""><i class="fa fa-bookmark" aria-hidden="true"></i></a>
													</div>
															
													<div class="row">
														<div class="col-md-8 course-details-h-2">
							
															<div class="course-details-1">
																<div class="c-d-2">
																	<label class="abcd"> Intake:</label>
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
																	<div class="cou-value">Delhi</div>
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
					 --}}
										<!-- Cource Grid 1 -->
										{{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
											<div class="education_block_list_layout style-2">
					
												
					
												<div class="list_layout_ecucation_caption">

									
							
													<div class="education_block_body">
														<h4 class="bl-title course-name  "><a href="course-detail.html">Discontinued (Apr 2023)- M. Sc. in Biotechnology</a></h4>
							
													</div>
													<div class="save-btn">
														<a href=""><i class="fa fa-bookmark" aria-hidden="true"></i></a>
													</div>
															
													<div class="row">
														<div class="col-md-8 course-details-h-2">
							
															<div class="course-details-1">
																<div class="c-d-2">
																	<label class="abcd"> Intake:</label>
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
																	<div class="cou-value">Delhi</div>
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
					
										<!-- Cource Grid 1 -->
										{{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
											<div class="education_block_list_layout style-2">
					
												
					
												<div class="list_layout_ecucation_caption">
									
							
													<div class="education_block_body">
														<h4 class="bl-title course-name  "><a href="course-detail.html">M.Sc. in Food Technology</a></h4>
							
													</div>
													<div class="save-btn">
														<a href=""><i class="fa fa-bookmark" aria-hidden="true"></i></a>
													</div>
															
													<div class="row">
														<div class="col-md-8 course-details-h-2">
							
															<div class="course-details-1">
																<div class="c-d-2">
																	<label class="abcd"> Intake:</label>
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
																	<div class="cou-value">Delhi</div>
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
					
										<!-- Cource Grid 1 -->
										{{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
											<div class="education_block_list_layout style-2">
					
												
					
												<div class="list_layout_ecucation_caption">

									
							
													<div class="education_block_body">
														<h4 class="bl-title course-name  "><a href="course-detail.html">Doctor of Philosophy (Ph.D.)</a></h4>
							
													</div>
													<div class="save-btn">
														<a href=""><i class="fa fa-bookmark" aria-hidden="true"></i></a>
													</div>
															
													<div class="row">
														<div class="col-md-8 course-details-h-2">
							
															<div class="course-details-1">
																<div class="c-d-2">
																	<label class="abcd"> Intake:</label>
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
																	<div class="cou-value">Delhi</div>
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
					
										<!-- Cource Grid 1 -->
										{{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
											<div class="education_block_list_layout style-2">
					
												
					
												<div class="list_layout_ecucation_caption">
									
							
													<div class="education_block_body">
														<h4 class="bl-title course-name  "><a href="course-detail.html">Master of Business Administration (MBA)
															</a></h4>
							
													</div>
													<div class="save-btn">
														<a href=""><i class="fa fa-bookmark" aria-hidden="true"></i></a>
													</div>
															
													<div class="row">
														<div class="col-md-8 course-details-h-2">
							
															<div class="course-details-1">
																<div class="c-d-2">
																	<label class="abcd"> Intake:</label>
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
																	<div class="cou-value">Delhi</div>
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
										{{-- @endforeach --}}
					
					
									</div>
									
									<!-- Row -->
									{{-- <div class="row"> --}}
										{{-- <div class="col-lg-12 col-md-12 col-sm-12"> --}}
					
											<!-- Pagination -->
											{{-- <div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12">
												<ul class="courselist pagination p-center">
														{{ $CoursesList->links() }} --}}
														{{-- <li class="page-item">
															<a class="page-link" href="#" aria-label="Previous">
																<span class="ti-arrow-left"></span>
																<span class="sr-only">Previous</span>
															</a>
														</li>
														<li class="page-item active"><a class="page-link" href="#">1</a></li>
														<li class="page-item"><a class="page-link" href="#">2</a></li>
														<li class="page-item "><a class="page-link" href="#">3</a></li>
														<li class="page-item"><a class="page-link" href="#">...</a></li>
														<li class="page-item"><a class="page-link" href="#">18</a></li>
														<li class="page-item">
															<a class="page-link" href="#" aria-label="Next">
																<span class="ti-arrow-right"></span>
																<span class="sr-only">Next</span>
															</a>
														</li> --}}
													{{-- </ul>
												</div>
											</div>
					
										</div>
									</div> --}}
									<!-- /Row -->
								{{-- </div> --}}



								

							</div>
						</div>

					</div>

					
				</div>

			</div>
		</section>
		<!-- ============================ Course Detail ================================== -->

				
<!-- Footer file include -->
@endsection
@section('js')
<script>
	// const changeUrlButton = document.getElementById('gallery-main-tab');
	// changeUrlButton.addEventListener('click', function() {
	// 	// Change the URL using window.location
	// 	window.location.href = 'https://www.ustudious.com/college-details/112';
	// });
	
</script>
@endsection

