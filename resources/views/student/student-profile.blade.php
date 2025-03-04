@extends('layouts.main')
@section('content')
    <style>
        .boxshadow {
            box-shadow: 1px 1px 3px #0000004a;
            border: none;
            display: flex;
            align-items: center;
        }
    </style>
    <?php
    $LoginID = Session::get('student_id');
    $StudentData = DB::table('student')
        ->select('student.*', 'student_contactinfo.*', 'country_master.CountryName')
        ->leftjoin('student_contactinfo', 'student_contactinfo.student_id', '=', 'student.StudentID')
        ->leftjoin('country_master', 'country_master.CountryID', '=', 'student.CountryID')
        ->where(['student.StudentID' => $LoginID])
        ->first();
    $country = DB::table('country_master')->orderBy('CountryName', 'ASC')->get();
    
    ?>
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

                                <img src="{{ $filePath }}" class="img-fluid avater">
                                <?php }else{ 
								$filePaths =  Storage::url('no-image.jpg'); ?>
                                <img src="{{ $filePaths }}" class="img-fluid avater">
                                <?php } ?>
                                <label class="institute-profile-photo-edit-pencil-icon" title="update"
                                    data-bs-toggle="tooltip" data-placement="right" id="editImageIcon">
                                    <form class="proflilImage" enctype="multipart/form-data">
                                        <input type="file" class="update-flie image profilePic" name='profile_student'
                                            id="profile_student" accept=".png,.jpg,.jpeg">
                                        <input type="hidden" class="form-control" value="{{ csrf_token() }}"
                                            name="token_csrf" id="token_csrf">
                                        <input type='hidden' class="banner_type" value="studentpic" name="banner_type">
                                        <input type="text" class='curr_img' value="{{ $StudentData->Photo }}"
                                            name='old_img_name' hidden>
                                        <i class="ti-pencil"></i>
                                    </form>
                                </label>
                            </div>
                            <!-- <div class="viewer_status">Verified</div> -->
                        </div>
                        <div class="caption">
                            <div class="viewer_header">
                                <h4 class="mb-2">{{ $StudentData->FirstName . ' ' . $StudentData->LastName }}</h4>
                                <span class="viewer_location"><i
                                        class="ti-location-pin mr-1"></i>{{ $StudentData->CountryName }}</span>

                                <ul class="mt-2">
                                    <li><i class="ti-email mr-1"></i>{{ $StudentData->Email }}</li>
                                    <li><i
                                            class="ti-mobile mr-1"></i>{{ $StudentData->CountryCode . ' ' . $StudentData->Mobile }}
                                    </li>
                                </ul>

                            </div>

                            <!-- <div class="dashboard_single_course_progress_1 mt-4">
            <label>82% Completed</label>
            <div class="progress">
             <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
           </div>

     -->
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- ============================ Instructor header End ================================== -->

    <!-- ============================ Dashboard: My Order Start ================================== -->
    <section class=" pt-4">
        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-md-3">
                    <div class="dashboard-navbar border">

                        <div class="d-navigation">
                            <ul id="side-menu">
                                <li class="active"><a href="{{ route('student-profile') }}"> <i class="ti-user"></i>My
                                        Profile</a></li>
                                <li><a href="{{ route('student-enrolled-course') }}"><i class="ti-heart"></i>Applied
                                        Course</a></li>
                                <li><a href="{{ route('student-saved-course') }}"><i class="ti-heart"></i>Saved Course</a>
                                </li>
                                <li><a href="{{ route('student-change-password') }}"><i class="ti-settings"></i>Change
                                        Password</a></li>
                                <li><a href="{{ route('institutelogout') }}"><i class="ti-power-off"></i>Log Out</a></li>
                            </ul>
                        </div>


                    </div>


                </div>

                <div class="col-lg-9 col-md-9 col-sm-12">

                    <div class="dashboard_container_header">
                        <div class="dashboard_fl_1">
                            <h4>Personal Details</h4>
                        </div>
                    </div>
                    <div class="institute-info-edit-pencil-icon">
                        <div class="student_view" id="student_view" style="display: none;"><i class="ti-eye"></i></div>
                        <div class="student_edit" id="student_edit" style="display: block;"><i class="ti-pencil"></i></div>
                    </div>
                    <br>
                    <!-- Row -->
                    <div class="row" id="student_profile_show" style="display:block">
                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <div class="dashboard_container">
                                <div class="dashboard_container_body p-4">
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">

                                            <div class="form-group col-md-6">
                                                <label>First Name</label>
                                                <div class="form-control boxshadow" name="first_name">
                                                    {{ $StudentData->FirstName }}</div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Last Name</label>
                                                <div class="form-control boxshadow" name="last_name">
                                                    {{ $StudentData->LastName }}</div>
                                            </div>
                                            {{-- <div class="form-group col-md-6">
												<label>Email</label>
												<div class="form-control boxshadow" name="dateofbirth">{{$StudentData->Email}}</div>
											</div>
											<div class="form-group col-md-6">
												<label>Mobile</label>
												<div class="form-control boxshadow" name="dateofbirth">{{$StudentData->CountryCode.' '.$StudentData->Mobile}}</div>
											</div> --}}
                                            <div class="form-group col-md-6">
                                                <label>Date of Birth</label>
                                                <div class="form-control boxshadow" name="dateofbirth">
                                                    {{ $StudentData->Dateofbirth }}</div>
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label> Gender</label>
                                                @php $Gender = '' @endphp
                                                @if ($StudentData->Gender == 'male')
                                                    @php $Gender = "Male" @endphp
                                                @elseif($StudentData->Gender == 'male')
                                                    @php $Gender = "Male" @endphp
                                                @endif
                                                <div class="form-control boxshadow" name="gender">
                                                    {{ $StudentData->Gender }}</div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Preferred Country</label>
                                                @if ($StudentData->contact_country)
                                                    <?php $countryDatas = DB::table('country_master')
                                                        ->where('CountryID', $StudentData->contact_country)
                                                        ->first(); ?>
                                                    <div type="text" class="form-control boxshadow"
                                                        name="student_country"> <?= $countryDatas->CountryName ?></div>
                                                @else
                                                    <div type="text" class="form-control boxshadow"
                                                        name="student_country"></div>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Preferred Program Type</label>
                                                @if ($StudentData->program_type)
                                                    <?php $ProgramDatas = DB::table('course_types')
                                                        ->where('course_types_id', $StudentData->program_type)
                                                        ->first(); ?>
                                                    <div type="text" class="form-control boxshadow"
                                                        name="program_type"> <?= $ProgramDatas->course_types ?></div>
                                                @else
                                                    <div type="text" class="form-control boxshadow"
                                                        name="program_type"></div>
                                                @endif
                                            </div>
                                            @php $ModeofStudy = ""; @endphp
                                            @if ($StudentData->mode_of_study == 'part_time')
                                                <?php $ModeofStudy = 'Part Time'; ?>
                                            @elseif($StudentData->mode_of_study == 'full_time')
                                                <?php $ModeofStudy = 'Full Time'; ?>
                                            @elseif($StudentData->mode_of_study == 'distance')
                                                <?php $ModeofStudy = 'Distance'; ?>
                                            @endif
                                            <div class="form-group col-md-6">
                                                <label>Mode of Study</label>
                                                <div class="form-control boxshadow" name="gender">{{ $ModeofStudy }}
                                                </div>
                                            </div>
                                            {{-- <div class="form-group col-md-6">
												<label>ID Proof</label>
												<input type="file" class="form-control" >
											</div> --}}



                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                </div>
                            </div>
                            <!-- Education Information -->
                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>Education Details</h4>
                                    </div>
                                </div>
                                <br>
                                @php
                                    $StudentQualification = DB::table('student_qualifications')
                                        ->select(
                                            'student_qualifications.*',
                                            'qualification_master.Qualification as QualificationName',
                                            'qualification_types_master.qualificationTypes as QualificationTypesName',
                                            'country_master.CountryName',
                                        )
                                        ->leftjoin(
                                            'qualification_master',
                                            'qualification_master.QualificationID',
                                            '=',
                                            'student_qualifications.Qualification',
                                        )
                                        ->leftjoin(
                                            'qualification_types_master',
                                            'qualification_types_master.QualificationTypesID',
                                            '=',
                                            'student_qualifications.QualificationTypes',
                                        )
                                        ->leftjoin(
                                            'country_master',
                                            'country_master.CountryID',
                                            '=',
                                            'student_qualifications.Country',
                                        )
                                        ->where('StudentID', $LoginID)
                                        ->whereNull('student_qualifications.deleted_at')
                                        ->get();

                                    $qualification_data = DB::table('qualification_master')
                                        ->select('Qualification', 'QualificationID')
                                        ->where('ApprovalStatus', 'Approved')
                                        ->whereNull('deleted_at')
                                        ->distinct()
                                        ->get();

                                    // $qualification_types_data = DB::table('qualification_types_master')->select('QualificationTypes','QualificationTypesID','QualificationID')->where('ApprovalStatus','Approved')->whereNull('deleted_at')->distinct()->get();

                                @endphp
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Education</th>
                                            <th>Specialization</th>
                                            <th>Institute /College Name</th>
                                            <th>Country</th>
                                            <th>Study Medium</th>
                                            <th>Passing Year</th>
                                            <th>Grade/Percentage </th>
                                        </tr>
                                    <tbody>

                                        <?php
										if(count($StudentQualification) > 0){
										foreach ($StudentQualification as $educData){?>
                                        <tr>
                                            <td> {{ !empty($educData->QualificationName) ? $educData->QualificationName : 'Not Disclosed' }}
                                            </td>
                                            <td>{{ !empty($educData->QualificationTypes) ? $educData->QualificationTypes : 'Not Disclosed' }}
                                            </td>
                                            <td width="60%">
                                                {{ !empty($educData->Name) ? $educData->Name : 'Not Disclosed' }}</td>
                                            <td> {{ !empty($educData->CountryName) ? $educData->CountryName : 'Not Disclosed' }}
                                            </td>
                                            <td> {{ !empty($educData->Medium) ? $educData->Medium : 'Not Disclosed' }}</td>
                                            <td> {{ !empty($educData->PassingYear) ? $educData->PassingYear : 'Not Disclosed' }}
                                            </td>
                                            <td> {{ !empty($educData->PercentageGrade) ? $educData->PercentageGrade : 'Not Disclosed' }}
                                            </td>

                                        </tr>
                                        <?php  } }else{?>
                                        <tr>
                                            <td colspan="7" style="text-align: center">No Record Found.</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <!-- Basic info -->

                            </div>
                            <!-- Contact Information -->
                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>Contact Details</h4>
                                    </div>
                                </div>

                                <!-- <div class="institute-info-edit-pencil-icon">
             <i class="ti-pencil"></i>
            </div> -->

                                <div class="dashboard_container_body p-4">
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">


                                            <div class="form-group col-md-6">
                                                <label>Email Address</label>
                                                <div class="form-control boxshadow" name="contact_email">
                                                    {{ $StudentData->Email }} </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Mobile Number</label>
                                                <div class="form-control boxshadow" name="contact_mobile">
                                                    {{ $StudentData->CountryCode . ' ' . $StudentData->Mobile }} </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label> Select Country</label>
                                                @if ($StudentData->CountryID)
                                                    <?php $countryContact = DB::table('country_master')
                                                        ->where('CountryID', $StudentData->CountryID)
                                                        ->first(); ?>
                                                    <div type="text" class="form-control boxshadow"
                                                        name="contact_country"> <?= $countryContact->CountryName ?></div>
                                                @else
                                                    <div type="text" class="form-control boxshadow"
                                                        name="contact_country"></div>
                                                @endif
                                            </div>

                                            {{-- <div class="form-group col-md-6">
												<label> Select State</label>
												<?php $state = DB::table('state_master')->get(); ?>
												@if ($StudentData->state)
                                            	<?php $stateContact = DB::table('state_master')
                                                ->where('StateID', $StudentData->state)
                                                ->first(); ?>
												<div type="text" class="form-control boxshadow" name="contact_state"> <?= $stateContact->StateName ?></div>
												@else
												<div type="text" class="form-control boxshadow" name="contact_state"></div>
												@endif
											</div> --}}

                                            <div class="form-group col-md-6">
                                                <label>City</label>
                                                @if ($StudentData->city)
                                                    <div type="text" class="form-control boxshadow"
                                                        name="contact_city"> <?= $StudentData->city ?></div>
                                                @else
                                                    <div type="text" class="form-control boxshadow"
                                                        name="contact_city"></div>
                                                @endif
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label>Address</label>
                                                <div class="form-control boxshadow" name="address">
                                                    {{ $StudentData->address }}</div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Postal Code</label>
                                                <div class="form-control boxshadow" name="zipcode">
                                                    {{ $StudentData->zip_code }}</div>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                </div>

                            </div>
                            <!-- Social Media Information -->
                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>Social Network</h4>
                                    </div>
                                </div>

                                <!-- <div class="institute-info-edit-pencil-icon">
             <i class="ti-pencil"></i>
            </div> -->

                                <div class="dashboard_container_body p-4">
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">

                                            <div class="form-group col-md-6">
                                                <label>Facebook</label>
                                                <div class="form-control boxshadow">{{ $StudentData->facebook }}</div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Instagram</label>
                                                <div class="form-control boxshadow">{{ $StudentData->instagram }}</div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>LinkedIn</label>
                                                <div class="form-control boxshadow">{{ $StudentData->linkedin }}</div>
                                            </div>



                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                </div>

                            </div>
                            <!-- Upload Resume -->
                            {{-- <div class="dashboard_container">
								<div class="dashboard_container_header">
									<div class="dashboard_fl_1">
										<h4>Resume</h4>
									</div>
								</div>

								<!-- <div class="institute-info-edit-pencil-icon">
									<i class="ti-pencil"></i>
								</div> -->

								<div class="dashboard_container_body p-4">
									<!-- Basic info -->
									<div class="submit-section">
										<div class="form-row">
										
											<div class="form-group col-md-6">
												<label>Resume</label>
												<?php
            $filepath = Storage::url('student/student_' . $StudentData->StudentID . '/' . $StudentData->Resume); ?>
												
												<?php 
												if($StudentData->Resume){
												$extension = pathinfo($filepath, PATHINFO_EXTENSION);
												if($extension == 'pdf'){
												?>
												 <iframe src="{{ $filepath }}" id="pdfViewer" ></iframe>
												 <?php }else{ ?>
												  <img src="{{$filepath}}">
												 <?php } ?>
												 <?php } ?>
											</div>

											
										</div>
									</div>
									<!-- Basic info -->

								</div>

							</div> --}}


                        </div>
                    </div>
                    <!-- /Row -->

                    <!-- Row -->
                    <div class="row" id="student_profile_edit" style="display: none;">
                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <form enctype="multipart/form-data" id="studentprofile">
                                <div class="dashboard_container">
                                    <div class="dashboard_container_body p-4">
                                        <!-- Basic info -->
                                        <div class="submit-section">
                                            <div class="form-row">
                                                <input type="hidden" class="form-control"
                                                    value="{{ $StudentData->StudentID }}" name="student_id">
                                                <input type="hidden" class="form-control" value="{{ csrf_token() }}"
                                                    name="csrf_token" id="csrf_token">

                                                <div class="form-group col-md-6">
                                                    <label>First Name <span style="color:red"> *</span> </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $StudentData->FirstName }}" placeholder="First Name"
                                                        name="first_name">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Last Name <span style="color:red"> *</span> </label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $StudentData->LastName }}" placeholder="Last Name"
                                                        name="last_name">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Date of Birth <span style="color:red"> *</span> </label>
                                                    <input type="date" class="form-control"
                                                        value="{{ $StudentData->Dateofbirth }}" name="dateofbirth">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label> Gender</label>
                                                    <select class="form-control st-country-code" name="gender">
                                                        <option value="">Please select Gender </option>
                                                        <option value="male"
                                                            @if ('male' == $StudentData->Gender) selected @endif>Male</option>
                                                        <option value="female"
                                                            @if ('female' == $StudentData->Gender) selected @endif>Female
                                                        </option>

                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Preferred Country <span style="color:red"> *</span> </label>

                                                    <select class="form-control boxshadow" name="student_country"
                                                        id="student_country">
                                                        <option value="">Select Country</option>
                                                        @foreach ($country as $data)
                                                            <option value="{{ $data->CountryID }}"
                                                                @if ($data->CountryID == $StudentData->contact_country) selected @endif>
                                                                {{ $data->CountryName }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Preferred Program Type <span style="color:red"> *</span>
                                                    </label>
                                                    @php $courseTypeData =DB::table('course_types')->select('course_types_id','course_types')->whereNull('deleted_at')->distinct()->get(); @endphp
                                                    <select class="form-control" name="program_type" id="program_type">
                                                        <option value="">Select Program Type </option>
                                                        @foreach ($courseTypeData as $data)
                                                            <option value="{{ $data->course_types_id }}"
                                                                @if ($data->course_types_id == $StudentData->program_type) selected @endif>
                                                                {{ $data->course_types }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label> Mode of Study <span style="color:red"> *</span> </label>
                                                    <select class="form-control mode_of_study" name="mode_of_study">
                                                        <option value="">Select Mode of Study</option>
                                                        <option value="part_time"
                                                            @if ($StudentData->mode_of_study == 'part_time') selected @endif>Part Time
                                                        </option>
                                                        <option value="full_time"
                                                            @if ($StudentData->mode_of_study == 'full_time') selected @endif>Full Time
                                                        </option>
                                                        <option value="distance"
                                                            @if ($StudentData->mode_of_study == 'distance') selected @endif>Distance
                                                        </option>

                                                    </select>
                                                </div>


                                                {{-- <div class="form-group col-md-6">
													<label>ID Proof</label>
													<input type="file" class="form-control" name="student_photo" >
												</div> --}}



                                            </div>
                                        </div>
                                        <!-- Basic info -->

                                    </div>
                                </div>
                                <!-- Education Information -->
                                <div class="dashboard_container">
                                    <div class="dashboard_container_header">
                                        <div class="dashboard_fl_1">
                                            <h4>Education Details</h4>
                                        </div>
                                    </div>

                                    <!-- 	<div class="institute-info-edit-pencil-icon">
              <i class="ti-pencil"></i>
             </div>
     -->


                                    <div class="dashboard_container_body p-4 QualificationList">
                                        <!-- Basic info -->
                                        @php $key_row = 0; @endphp
                                        @if (count($StudentQualification) > 0)
                                            @foreach ($StudentQualification as $key => $educData)
                                                <div class="submit-section">

                                                    <div class="form-row qualification_list">

                                                        <div><input type="hidden" name="student_qualification_id[]"
                                                                value="{{ $educData->StudentQualificationID }}"
                                                                id="student_qualification_id"></div>

                                                        <div class="form-group col-md-6">
                                                            <label> Highest Level of Education <span style="color:red">
                                                                    *</span> </label>
                                                            <select class="form-control qualification"
                                                                name="qualification_id[]"
                                                                id="qualification_id_{{ $key }}" required>
                                                                <option value="">Select Education</option>
                                                                @foreach ($qualification_data as $data)
                                                                    <option value="{{ $data->QualificationID }}"
                                                                        @if ($data->QualificationID == $educData->Qualification) selected @endif>
                                                                        {{ $data->Qualification }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label> Specialization</label>
                                                            {{-- <select class="form-control qualification_types" name="qualification_types_id[]" id="qualification_types_id_{{$key}}" required>
														<option value="">Select Specialization</option>
														<?php foreach ($qualification_types_data as $data){ 
														if($data->QualificationID == $educData->Qualification){ ?>                                                                  
														<option value="{{ $data->QualificationTypesID }}" @if ($data->QualificationTypesID == $educData->QualificationTypes) selected @endif>{{ $data->QualificationTypes }}</option>
														<?php } } ?>

													</select> --}}
                                                            <input type="text" class="form-control"
                                                                name="qualification_types_id[]"
                                                                value="{{ $educData->QualificationTypes }}"
                                                                placeholder="Enter Specialization">

                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Name of School/College </label>
                                                            <input type="text" class="form-control" name="name[]"
                                                                value="{{ $educData->Name }}" placeholder="Enter Name">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Country of Institution </label>
                                                            <select class="form-control st-country-code"
                                                                name="college_country[]">
                                                                @foreach ($country as $data)
                                                                    <option value="{{ $data->CountryID }}"
                                                                        @if ($data->CountryID == $educData->Country) selected @endif>
                                                                        {{ $data->CountryName }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>


                                                        <div class="form-group col-md-6">
                                                            <label> Study Medium <span style="color:red"> *</span> </label>
                                                            <input type="text" name="medium[]"
                                                                value="{{ $educData->Medium }}"
                                                                placeholder="Enter Study Medium" class="form-control"
                                                                required />
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label> Passing Year <span style="color:red"> *</span> </label>
                                                            <input type="text" name="year[]"
                                                                value="{{ $educData->PassingYear }}"
                                                                placeholder="Enter Passing Year" class="form-control"
                                                                required />

                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Grade/Percentage <span style="color:red"> *</span>
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $educData->PercentageGrade }}"
                                                                placeholder="Enter your Grade" name="grade[]">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label></label>
                                                            @if ($key != 0)
                                                                <button type="button" class="btn btn-danger remove"
                                                                    id="removeStudent">Remove</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @php $key_row++; @endphp

                                                </div>
                                                <input type="hidden" class="form-control" value="{{ $key_row }}"
                                                    id="key_row">
                                            @endforeach
                                        @else
                                            <div class="submit-section">

                                                <div class="form-row">

                                                    <div><input type="hidden" name="student_qualification_id[]"></div>

                                                    <div class="form-group col-md-6">
                                                        <label> Highest Level of Education <span style="color:red">
                                                                *</span> </label>
                                                        <select class="form-control qualification"
                                                            name="qualification_id[]" required>
                                                            <option value="">Select Education</option>
                                                            @foreach ($qualification_data as $data)
                                                                <option value="{{ $data->QualificationID }}">
                                                                    {{ $data->Qualification }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label> Specialization </label>
                                                        {{-- <select class="form-control qualification_types" name="qualification_types_id[]" required>  
														<option value="">Select Specialization</option>
														<?php foreach ($qualification_types_data as $data){  ?>                                                                  
														<option value="{{ $data->QualificationTypesID }}">{{ $data->QualificationTypes }}</option>
														<?php } ?>

													</select> --}}
                                                        <input type="text" class="form-control"
                                                            name="qualification_types_id[]"
                                                            placeholder="Enter Specialization">

                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label>Name of School/College </label>
                                                        <input type="text" class="form-control" name="name[]"
                                                            placeholder="Enter Name">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label>Country of Institution </label>
                                                        <select class="form-control st-country-code"
                                                            name="college_country[]">
                                                            @foreach ($country as $data)
                                                                <option value="{{ $data->CountryID }}">
                                                                    {{ $data->CountryName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <div class="form-group col-md-6">
                                                        <label> Study Medium <span style="color:red"> *</span> </label>
                                                        <input type="text" name="medium[]"
                                                            placeholder="Enter Study Medium" class="form-control"
                                                            required />
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label> Passing Year <span style="color:red"> *</span> </label>
                                                        <input type="text" name="year[]"
                                                            placeholder="Enter Passing Year" class="form-control"
                                                            required />

                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label>Grade/Percentage <span style="color:red"> *</span> </label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Grade" class="form-control"
                                                            name="grade[]" />
                                                    </div>

                                                    {{-- <div class="form-group col-md-6">
													<label></label>
													<button type="button" class="btn btn-danger remove" id="removeStudent" style="margin-top:30px;margin-left:260px;">Remove</button>
												</div> --}}
                                                </div>

                                            </div>
                                            <input type="hidden" class="form-control" value="0" id="key_row">
                                        @endif

                                        <!-- Basic info -->
                                    </div>

                                    <div class="form-group col-md-12">
                                        <a class="btn add-items" id="addEducation"><i class="fa fa-plus-circle"></i>Add
                                            Education</a>
                                    </div>
                                    <!-- Basic info -->

                                </div>
                                <!-- Contact Information -->
                                <div class="dashboard_container">
                                    <div class="dashboard_container_header">
                                        <div class="dashboard_fl_1">
                                            <h4>Contact Details</h4>
                                        </div>
                                    </div>

                                    <!-- 	<div class="institute-info-edit-pencil-icon">
              <i class="ti-pencil"></i>
             </div> -->

                                    <div class="dashboard_container_body p-4">
                                        <!-- Basic info -->
                                        <div class="submit-section">
                                            <div class="form-row">



                                                <div class="form-group col-md-6">
                                                    <label> Select Country</label>
                                                    {{-- <select class="form-control st-country-code" name="contact_country" id="contact_country">
														
														<?php $country = DB::table('country_master')->distinct()->get(); ?>
														<option value="">Select Country</option>
														@foreach ($country as $data)
															<option value="{{ $data->CountryID }}" @if ($data->CountryID == $StudentData->CountryID) selected @endif>{{ $data->CountryName }}</option>
														@endforeach
													</select> --}}
                                                    <?php if (empty($StudentData)) {
                                                        $contact_country = 'Not Disclosed';
                                                    } else {
                                                        $contact_country = $StudentData->CountryID;
                                                    }
                                                    ?>
                                                    <input type="hidden" class="form-control" name="contact_country"
                                                        value="{{ $contact_country }}">
                                                    <?php if (empty($countryContact)) {
                                                        $CountryNames = 'Not Disclosed';
                                                    } else {
                                                        $CountryNames = $countryContact->CountryName;
                                                    }
                                                    ?>
                                                    <input type="text" class="form-control" name="contact_countries"
                                                        value="{{ $CountryNames }}" disabled>

                                                </div>


                                                {{-- <div class="form-group col-md-6">
													<label> Select State</label>
													<?php $state = DB::table('state_master')->get(); ?>
													<select class="form-control" name="contact_state" id="contact_state">
														
														<option value="">Select State</option>
														@foreach ($state as $data)
															<option value="{{ $data->StateID }}" @if ($data->StateID == $StudentData->state) selected @endif>{{ $data->StateName }}</option>
														@endforeach
													
													</select>
												</div> --}}

                                                <div class="form-group col-md-6">
                                                    <label>City <span style="color:red"> *</span> </label>
                                                    {{-- <select class="form-control" name="contact_city"  id="contact_city" > --}}
                                                    <input type="text" class="form-control" name="contact_city"
                                                        value="{{ $StudentData->city }}" placeholder="city">
                                                    {{-- @foreach ($cities as $data)
															<option value="{{ $data->CityID }}" @if ($data->CityID == $StudentData->city) selected @endif>{{ $data->CityName }}</option>
														@endforeach --}}

                                                    {{-- </select> --}}
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label>Postal Code</label>
                                                    <input type="text" class="form-control" name="zipcode"
                                                        value="{{ $StudentData->zip_code }}" placeholder="postal code">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label>Address</label>
                                                    <input type="text" class="form-control" name="address"
                                                        value="{{ $StudentData->address }}" placeholder="address">
                                                </div>



                                            </div>
                                        </div>
                                        <!-- Basic info -->

                                    </div>

                                </div>
                                <!-- Social Media Information -->
                                <div class="dashboard_container">
                                    <div class="dashboard_container_header">
                                        <div class="dashboard_fl_1">
                                            <h4>Social Network</h4>
                                        </div>
                                    </div>

                                    <!-- 	<div class="institute-info-edit-pencil-icon">
              <i class="ti-pencil"></i>
             </div> -->

                                    <div class="dashboard_container_body p-4">
                                        <!-- Basic info -->
                                        <div class="submit-section">
                                            <div class="form-row">

                                                <div class="form-group col-md-6">
                                                    <label>Facebook</label>
                                                    <input type="text" class="form-control" name="facebook"
                                                        value="{{ $StudentData->facebook }}"
                                                        placeholder="https://www.facebook.com/">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Instagram</label>
                                                    <input type="text" class="form-control" name="instagram"
                                                        value="{{ $StudentData->instagram }}"
                                                        placeholder="https://www.instagram.com">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>LinkedIn</label>
                                                    <input type="text" class="form-control" name="linkedin"
                                                        value="{{ $StudentData->linkedin }}"
                                                        placeholder="https://www.linkedin.com">
                                                </div>



                                            </div>
                                        </div>
                                        <!-- Basic info -->

                                    </div>

                                </div>
                                <!-- Upload Resume -->
                                {{-- <div class="dashboard_container">
                                    <div class="dashboard_container_header">
                                        <div class="dashboard_fl_1">
                                            <h4>Upload Resume</h4>
                                        </div>
                                    </div> --}}

                                    <!-- <div class="institute-info-edit-pencil-icon">
              <i class="ti-pencil"></i>
             </div> -->

                                    {{-- <div class="dashboard_container_body p-4">
                                        <!-- Basic info -->
                                        <div class="submit-section">
                                            <div class="form-row">

                                                <div class="form-group col-md-6">
                                                    <label>Upload Resume (Only PDFs < 1 MB allowed for upload.)</label>
                                                            <input type="file" class="form-control"
                                                                name="student_resume">
                                                </div>
                                                <div style="margin-top:40px">
                                                    <?php
												$filePath =  Storage::url('student/student_'.$StudentData->StudentID.'/'.$StudentData->Resume); 
												if (isset($StudentData->Resume) && !empty($StudentData->Resume)){
												?>
                                                    <button class="download-brochure"
                                                        onclick="downloadBrochure('<?php echo $filePath; ?>')"><i
                                                            class="fa fa-download" aria-hidden="true"></i> Resume</button>
                                                    <?php } ?>
                                                </div>
                                            </div>


                                        </div>
                                        <!-- Basic info -->

                                    </div> --}}

                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12">
                                        <button class="btn btn-theme StudentProfile" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- /Row -->

                </div>

            </div>
            <!-- Row -->

        </div>
    </section>


    <div id="delete-qualification-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div style="float: right;">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="text-center">
                        <i class="ri-information-line h1 text-info"></i>
                        <h5 class="mt-2">Are you sure you want to delete this records?</h5>
                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"
                            id="DeleteEducation">Delete</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" style="top:20%;">
            <div class="modal-content">
                <div class="modal-body">
                    <br>
                    <div id="checkicon" style="font-size:65px;text-align: center;color:green"></div>
                    <div id="checkiconcross" style="font-size:65px;text-align: center;color:red"></div>
                    <br><br>
                    <div id="message" style="text-align: center;font-size:35px;"></div>
                </div>
                <br><br>
                <div class="text-end" style="margin-left:80%">
                    <button type="button" class="btn btn-primary" id="CloseModalStudent"
                        style="width:65px;margin-right:30%">Ok</button>
                </div>
                <br><br>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- ============================ Dashboard: My Order Start End ================================== -->
@endsection
@section('js')
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>

    <script>
        $('#contact_country').on('change', function() {
            var idCountry = this.value;
            $("#contact_state").html('');
            $.ajax({
                url: "{{ url('institute/fetch-states') }}",
                type: "POST",
                data: {
                    country_id: idCountry,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    console.log(result.countrycode[0]['CountryCode']);
                    $("#contact_country_code").val('+' + result.countrycode[0]['CountryCode']);
                    $(".contact_country_codes").val('+' + result.countrycode[0]['CountryCode']);
                    $('#contact_state').html('<option value="">-- Select State --</option>');
                    $.each(result.state, function(key, value) {
                        $("#contact_state").append('<option value="' + value
                            .StateID + '">' + value.StateName + '</option>');
                    });
                    $('#contact_city').html('<option value="">-- Select City --</option>');
                }
            });

        });
        $('#contact_state').on('change', function() {
            var idState = this.value;
            $("#contact_city").html('');
            $.ajax({
                url: "{{ url('institute/fetch-city') }}",
                type: "POST",
                data: {
                    state_id: idState,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(res) {
                    $('#contact_city').html('<option value="">-- Select City --</option>');
                    $.each(res.cities, function(key, value) {
                        $("#contact_city").append('<option value="' + value
                            .CityID + '">' + value.CityName + '</option>');
                        // $('#cluster_id').append('<option value="'+data['cluster_id_primary']+'" '+ (area_id == data['cluster_id_primary'] ? ' selected ' : '') +'>'+data['cluster_name']+'</option>');


                    });
                }
            });
        });



        $('#addEducation').on('click', function() {

            addRow();
        });


        // $('.qualification').on('change', function() {
        // 	var idQualification = $(this).val();
        // 	var idName = $(this).attr('id');
        // 	if(idName){
        // 		var split_rowId = idName.split("_");
        // 	}
        // 	if (idQualification) {
        // 		$.ajax({
        // 			type: "GET"
        // 			, url: "{{ url('student/qualification_types') }}?qualification_id=" + idQualification
        // 			, success: function(res) {

        // 				if (res) {
        // 					if(split_rowId){
        // 						$('#qualification_types_id_' + split_rowId[2]).empty();
        // 						$('#qualification_types_id_' + split_rowId[2]).append('<option value="">select</option>');
        // 					}else{
        // 						$(".qualification_types").empty();
        // 						$(".qualification_types").append('<option value="">Select</option>');
        // 					}
        // 					$.each(res, function(key, value) {
        // 						if(split_rowId){
        // 							$('#qualification_types_id_' + split_rowId[2]).append('<option value="' + key + '">' + value + '</option>');
        // 						}else{

        // 							$(".qualification_types").append('<option value="' + key + '">' + value + '</option>');
        // 						}
        // 					});

        // 				} else {
        // 					$(".qualification_types").empty();
        // 				}
        // 			}.bind(this)
        // 		});
        // 	} else {
        // 		$(".qualification_types").empty();

        // 	}
        // });

        var rowId = $("#key_row").val();

        function addRow() {

            // <div class="form-group col-md-6"><label> Specialization</label><select class="form-control"  name="qualification_types_id[]" id="qualification_types_id_' + rowId + '"  required></select></div>
            rowId++;
            var tr =
                '<div class="submit-section"><div class="form-row qualification_list"><div><input type="hidden" name="student_qualification_id[]" ></div><div class="form-group col-md-6"><label> Education</label><select class="form-control"  name="qualification_id[]" id="qualification_id_' +
                rowId +
                '" required><option value="">-select-</option>@foreach ($qualification_data as $data)<option value="{{ $data->QualificationID }}">{{ $data->Qualification }}</option>@endforeach</select></div>' +
                '<div class="form-group col-md-6"><label> Specialization</label><input type="text" class="form-control" name="qualification_types_id[]" placeholder="Enter Specialization"></div>' +
                '<div class="form-group col-md-6"><label>Country of Institution</label><select class="form-control"  name="college_country[]" id="college_country_' +
                rowId +
                '" ><option value="">-select-</option>@foreach ($country as $data)<option value="{{ $data->CountryID }}">{{ $data->CountryName }}</option>@endforeach</select></div>' +
                '<div class="form-group col-md-6"><label>Name of School/College</label><input type="text" name="name[]" placeholder="Enter Name" class="form-control"  /></div>' +
                '<div class="form-group col-md-6"><label> Study Medium</label><input type="text" name="medium[]" placeholder="Enter Study Medium" class="form-control" required /></div>' +
                '<div class="form-group col-md-6"><label>Enter Passing Year</label><input type="text" name="year[]" placeholder="Passing Year" class="form-control" required /></div>' +
                '<div class="form-group col-md-6"><label>Grade/Percentage</label><input type="text" name="grade[]" placeholder="Enter Grade" class="form-control"  /></div>' +
                '<div class="form-group col-md-6">' +
                '<div class="form-group col-md-6"><label></label><button type="button" class="btn btn-danger remove" id="removeStudent" >Remove</button></div></div></div>';
            $('.QualificationList').append(tr);
            $("#UpdateStudent").validate();

            // $('#qualification_types_id_' + rowId + ', #qualification_id_' + rowId).select2(); // Reinitialize Select2 for the new row

            // $('#qualification_id_' + rowId + '').on('change', function() {

            // 	var idQualification = $(this).val();
            // 	var idName = $(this).attr('id');
            //     var split_rowId = idName.split("_");
            // 	if (idQualification) {
            // 		$.ajax({
            // 			url: "{{ url('student/qualification_types') }}?qualification_id=" + idQualification
            // 			, type: "GET"
            // 			, dataType: "json"
            // 			, success: function(data) {
            // 				console.log(data);
            // 				$('#qualification_types_id_' + split_rowId[2] + '').empty();
            // 				// $('#qualification_types_id_' + rowId + '').append('<option>Qualification Types</option>');
            // 				$.each(data, function(key, value) {
            // 					$('#qualification_types_id_' + split_rowId[2] + '').append('<option value="' + key + '">' + value + '</option>');


            // 				});
            // 			}
            // 		});
            // 	} else {
            // 		$('#qualification_types_id_' + split_rowId[2] + '').empty();
            // 	}
            // });
        }

        $("#CloseModalStudent").on('click', function() {
            return window.location.reload();
        });

        $(document).on('click', '.remove', function() {

            var formRowCount = $('.qualification_list').length;

            if (formRowCount > 1) {
                var studentQualificationId = $(this).closest('.qualification_list').find(
                    'input[name="student_qualification_id[]"]').val();
                if (studentQualificationId) {
                    $("#delete-qualification-modal").modal('show');

                    $('#DeleteEducation').on("click", function() {
                        $.ajax({
                            url: "{{ url('student/removequalification') }}",
                            type: "POST",
                            data: {
                                qualification_id: studentQualificationId,
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(result) {
                                $("#delete-qualification-modal").modal('hide');
                                swal({
                                    title: " Education Deleted Successfully.",
                                    text: "",
                                    icon: "success",
                                }).then(function() {
                                    return window.location.href = '/student-profile';
                                });
                            }
                        });

                    });
                }
                $(this).closest('.qualification_list').remove();
            } else {
                $("#alert-modal").modal('show');
                $(".modal-body #checkiconcross").html("<i class='fa fa-times-circle'>");
                $(".modal-body #message").html("Cannot remove the last element");
                // alert("Cannot remove the last element.");
            }
        });
    </script>
@endsection

