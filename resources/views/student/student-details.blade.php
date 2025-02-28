<!-- Header file include -->
@extends('layouts.main')
@section('content')
<?php $ASSET_PATH = env('ASSET_URL').'/' ?>
<style>
    .education_list {
        list-style-type: disc; /* Sets the bullet style to a filled circle */
    }
</style>
<div class="college-heading-top-section lg">
    <div class="container">
        <div class="row">

          <div class="viewer_detail_thumb">
							<?php 
							if($Students->Photo){ 
                               $filePath =  Storage::url('student/student_'.$Students->StudentID.'/'.$Students->Photo); ?>
								
							<img src="{{$filePath}}" class="img-fluid avater"  width="120" height="120" >
							<?php }else{ 
								$filePaths =  Storage::url('no-image.jpg'); ?>
								<img src="{{$filePaths}}" class="img-fluid avater"  width="120" height="120" >
							<?php } ?>
						</div>
						<div class="caption">
							<div class="viewer_header">
								<h4 class="mb-2">{{$Students->FirstName .' '.$Students->LastName}}</h4>
								<span class="viewer_location"><i class="ti-location-pin mr-1"></i>{{$Students->CountryName}}</span>

								<ul class="mt-2">
									<li><i class="ti-email mr-1"></i>{{$Students->Email}}</li>
									<li><i class="ti-mobile mr-1"></i>{{$Students->CountryCode.' '.$Students->Mobile}}</li>
								</ul>

							</div>

							<!-- <div class="dashboard_single_course_progress_1 mt-4">
								<label>82% Completed</label>
								<div class="progress">
									<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div> -->
							<br>
							<?php
							$filePath =  Storage::url('student/student_'.$Students->StudentID.'/'.$Students->Resume); 
							if (isset($Students->Resume) && !empty($Students->Resume)){
							?>
							<button class="download-brochure"  onclick="downloadBrochure('<?php echo $filePath ?>')" ><i class="fa fa-download" aria-hidden="true"></i> Resume</button>
							<?php } ?>

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
                                    <?php 
									$address=''; $city=''; $country=''; $zipcode='';
								
                                    if($Students->address){
                                       $address = $Students->address;
                                    }
                                    if($Students->city){
                                       $city = $Students->city;
                                    }
                                    if($Students->CountryName){
                                       $country = $Students->CountryName;
                                    }
                                    if($Students->zip_code){
                                       $zipcode = $Students->zip_code.'.'; 
                                    }

									$modeofstudy = "Not Disclosed";
									if($Students->mode_of_study === 'full_time'){
										 $modeofstudy = "Full Time" ;
									}else if($Students->mode_of_study === 'part_time'){ 
										 $modeofstudy = "Part Time"; 
									}else if($Students->mode_of_study === 'distance'){
										 $modeofstudy = "Distance"; 
									}
									
                                    ?>
                                    
									<li><i class="ti-calendar"></i>Date of Birth:<strong>{{ !empty($Students->Dateofbirth) ? $Students->Dateofbirth : 'Not Disclosed' }}</strong></li>
									<li><i class="ti-search"></i>Gender :<strong>{{!empty($Students->Gender) ? $Students->Gender : 'Not Disclosed'}}</strong></li>
									{{-- <li><i class="ti-email mr-1"></i>Contact Email :<strong>{{!empty($Students->contact_email) ? $Students->contact_email: 'Not Disclosed'}}</strong></li>
									<li><i class="ti-mobile mr-1"></i>Contact MobileNo. :<strong> {{ !empty($Students->contact_mobile_no) ? $Students->contact_country_code.' '.$Students->contact_mobile_no: 'Not Disclosed' }}</strong></li> --}}
									<li><i class="ti-location-pin"></i>Address :<strong>{{ !empty($address) ?  $address.' , ' : '' }} {{ !empty($city) ? $city.' , ' : ''}}{{!empty($country) ? $country : '' }} {{!empty($zipcode) ? ' , '.$zipcode : '' }}</strong></li>
									@if($Students->CountryID) 
									<?php $PreferredCountry = DB::table('country_master')->where('CountryID',$Students->CountryID)->first(); ?>
									<li><i class="ti-location-pin"></i>Preferred Country :<strong>{{ $PreferredCountry->CountryName }}</strong></li>
									@else
									<li><i class="ti-location-pin"></i>Preferred Country :<strong>Not Disclosed</strong></li>
									@endif
									<li><i class="ti-search"></i>Program Type :<strong>{{!empty($Students->course_types) ? $Students->course_types : 'Not Disclosed'}}</strong></li>
									<li><i class="ti-shine"></i>Mode of Study :<strong>{{$modeofstudy}}</strong></li>



								</ul>
							</div>


							@if( $Students->linkedin || $Students->instagram || $Students->facebook)
							<div class="px-4 pt-4 pb-0 b-t">
								<h5 class="mb-3">Follow Us</h5>
							
								<div class="inline_edu_wrap ">

									<ul class="social_info">
										@if($Students->facebook)
										<li><a href="{{$Students->facebook}}" target="_blank"><i class="ti-facebook"></i></a></li>
										@endif
										{{-- <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
											<a class="a2a_button_facebook"></a>
											<a class="a2a_button_whatsapp"></a>
											<a class="a2a_button_telegram"></a>
											<a class="a2a_button_email"></a>
										</div>
										<script async src="https://static.addtoany.com/menu/page.js"></script> --}}
											<!-- AddToAny END -->
										@if($Students->instagram)
                                        <li><a target="_blank" href="{{ $Students->instagram }}" ><i  class="ti-instagram"></i></a></li>
										@endif
										@if($Students->linkedin)
										<li><a href="{{$Students->linkedin}}" target="_blank"><i class="ti-linkedin"></i></a></li>
										@endif
										
									</ul>
								</div>
							</div>
							@endif



						</div>

					</div>


					<div class="col-lg-8 col-md-8">
						
						
						<!-- All Info Show in Tab -->
						<div class="tab_box_info  border p-3">
							<ul class="nav nav-pills mb-3 light" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="education-tab" data-toggle="pill" href="#education"
										role="tab" aria-controls="education" aria-selected="true">Education</a>
								</li>
							
								@if(count($EnrolledCourseData) != 0)
								<li class="nav-item">
									<a class="nav-link" id="courses-tab" data-toggle="pill" href="#courses"
										role="tab" aria-controls="courses" aria-selected="false">Courses</a>
								</li>
								@endif
						

							</ul>

							<div class="tab-content" id="pills-tabContent">

								<!-- education Detail -->
								<div class="tab-pane fade show active" id="education" role="tabpanel"
									aria-labelledby="education-tab">
                                  

									<!-- Institution Details-->
									<div class="edu_wraper instutution-details">
										<h4 class="edu_title"></h4>
										@if(count($StudentQualification) > 0)
                                        @foreach ($StudentQualification as $data )
										<ul  class="education_list edu_wraper">
											<li><b>{{ !empty($data->Qualification) ?  '   Education :  '. $data->Qualification : '' }} {{ !empty($data->QualificationTypes) ? '    ,      Specialization  :   '.$data->QualificationTypes : ''}}{{ !empty($data->PercentageGrade) ? '  , Grade/Percentage :  '.$data->PercentageGrade  : ''}}{{!empty($data->PassingYear) ? ' ,  Passing Year  : '.$data->PassingYear : '' }} </b></li>
										</ul>
                                        @endforeach
										@else
										Not Disclosed
										@endif
										
									</div>

									
								</div>

							

								<!-- courses Detail -->
								<div class="tab-pane fade courses-tab-college-details-page" id="courses" role="tabpanel"
									aria-labelledby="courses-tab">
									
										
									<div class="row browse-courses-page-main">
										@foreach ($EnrolledCourseData as $data )
										<!-- Cource Grid 1 -->
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
											<div class="education_block_list_layout style-2">
					
												<div class="list_layout_ecucation_caption">

													<div class="education_block_body">
														<h4 class="bl-title course-name  ">{{$data->CourseName}}
															</h4>
													</div>
													<div class="row">
														<div class="col-md-8 course-details-h-2">
							
															<div class="course-details-1">
																<div class="c-d-2">
																	<label class="abcd"> Intake Month :</label>
																	<div class="cou-value">{{$data->Intakemonth}}</div>
																</div>
																<div class="c-d-2">
																	<label class="abcd">Course Duration :</label>
																	<div class="cou-value">{{$data->Duration}}</div>
																</div>
															</div>
							
															<div class="course-details-1">
																<div class="c-d-2">
																	<label class="abcd">Applied On :</label>
																	<div class="cou-value">{{$data->applied_on}}</div>
																</div>
																<div class="c-d-2">
																	<label class="abcd">Fees :</label>
																	<div class="cou-value">{{$data->Currency.' '.$data->TotalCost}}</div>
																</div>
															</div>
							
														</div>
							
														<div class="col-md-4">
															<div class="cou-buttons">
							
															
							
																{{-- <button class="download-brochure"> <i class="fa fa-download" aria-hidden="true"></i>
																	Brochure</button> --}}
																<?php
																// $filePath =  Storage::url('course/brochure/'.$data->Brochure);  
																// if (isset($data->Brochure) && !empty($data->Brochure)){
																?>
																	{{-- <button class="download-brochure"  onclick="downloadBrochure('<?php echo $filePath ?>')" ><i class="fa fa-download" aria-hidden="true"></i> Brochure</button> --}}
																<?php // } ?>
															</div>
														</div>
							
													</div>
							
							
												</div>
							
											</div>
										</div>
										@endforeach
					
					
									</div>
									
									<!-- Row -->
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12">
					
											<!-- Pagination -->
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12">
												<ul class="courselist pagination p-center">
														{{-- {{ $EnrolledCourseData->links() }} --}}
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
													</ul>
												</div>
											</div>
					
										</div>
									</div>
									<!-- /Row -->
								</div>



								

							</div>
						</div>

					</div>

					
				</div>

			</div>
		</section>
		<!-- ============================ Course Detail ================================== -->

				
<!-- Footer file include -->
@endsection

