@extends('layouts.main')
@section('content')

<?php $ASSET_PATH = env('ASSET_URL').'/';
 $LoginID = Session::get('institute_id');
    $InstituteData = DB::table('institute')->where('institute_id',$LoginID)->first();

?>

    <div class="college-heading-top-section lg">
        <div class="container">
            <div class="row ">

                <div class="college-cover-img pb-4" style="position: relative;">
                    {{-- <img alt="Great Lakes Institute of Management Chennai"
                        src="{{$ASSET_PATH}}img/college-de-paris-cover.png" width="1200" height="200"> --}}
                        <?php 
                        if($InstituteData->institute_banner){ 
                            $filePath =  Storage::url('institute/banner/'.$InstituteData->institute_banner); 
                            ?>
                        <img src="{{$filePath}}" class="img-fluid avater" alt=""  width="1200" height="200">
                        <?php }else{ 
                            $filePaths =  Storage::url('no-image.jpg'); ?>
                            <img src="{{$filePaths}}" class="img-fluid avater" alt=""  width="1200" height="200">
                        <?php } ?>
                        
                        <div class="institute-cover-photo-edit-pencil-icon">
                            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                            <label for="imageUpload"><i class="ti-pencil"></i></label>
                        </div>
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
{{--             
                <div class="col-lg-3 col-md-3">
                    <div class="dashboard-navbar border">
                        
                        <div class="d-user-avater mb-3 mt-0" >
                            <div class="insti-prof-img" style="position: relative;">
                                <img src="{{$ASSET_PATH}}img/CDP_Logo_PNG.png" class="img-fluid avater" alt="">

                                <div class="institute-profile-photo-edit-pencil-icon">
                                    <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"><i class="ti-pencil"></i></label>
                                </div>
                            </div>	




                            <h4>College de Paris</h4>
                            <span>France</span>
                        </div>
                        
                        <div class="d-navigation">
                            <ul id="side-menu">
                                <li class=""><a href="{{route('institute-profile')}}"><i class="ti-user"></i>Institute Profile</a></li>
                                <li ><a href="{{route('institute-posted-course')}}"><i class="ti-heart"></i>Posted Course</a></li>
                                <li><a href="{{route('institute-saved-students')}}"><i class="ti-heart"></i>Saved Students</a></li>

                                <li><a href="institute-transactions.php"><i class="ti-shopping-cart"></i>Transactions</a></li>
                                <li><a href="institute-change-password.php"><i class="ti-settings"></i>Change Password</a></li>
                                <li><a href="#"><i class="ti-power-off"></i>Log Out</a></li>
                            </ul>
                        </div>
                        
                    </div>
                    
                    
                </div>	 --}}
                @php
                    $courseTypeData =DB::table('course_types')->select('course_types_id','course_types')->whereNull('deleted_at')->distinct()->get();
                    $countryData =DB::table('country_master')->select('CountryID','CurrencySymbol')->where('CurrencySymbol','!=','')->whereNull('deleted_at')->distinct()->get();
                    $durationData=DB::table('duration_master')->select('Duration','DurationID')->whereNull('deleted_at')->distinct()->get(); 
                    $intakemonthData=DB::table('intakemonth_master')->select('Intakemonth','IntakemonthID')->whereNull('deleted_at')->distinct()->get(); 
                    $intakeyearData=DB::table('intakeyear_master')->select('Intakeyear','IntakeyearID')->whereNull('deleted_at')->orderBy('Intakeyear','ASC')->distinct()->get(); 
                    $languageData =DB::table('language_master')->select('Language','LanguageID')->whereNull('deleted_at')->distinct()->get();
                    $categoryData =DB::table('course_category')->select('id','course_category')->distinct()->get();  
                    $QualificationData =DB::table('qualification_master')->select('QualificationID','Qualification')->whereNull('deleted_at')->distinct()->get();
                           
                @endphp
              
                <div class="col-lg-12 col-md-12 col-sm-12">    
                    <!-- Row -->
                    <div class="row">
                       
                        <div class="col-lg-12 col-md-12 col-sm-12">
                        <form enctype="multipart/form-data" id="editpostcourse" >
                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>Post a Course</h4>
                                    </div>
                                </div>

                                <div class="institute-info-edit-pencil-icon">
                                    {{-- <i class="ti-pencil"></i> --}}
                                </div>

                                <div class="dashboard_container_body p-4">
                                    <!-- Course Details -->
                                    <div class="submit-section">
                                        <div class="form-row" >
                                         
                                            <input type="hidden" class="form-control" name="operation" value="edit" id="operation">
                                            <input type="hidden" class="form-control" name="institute_id" value="{{$LoginID}}">
                                            <input type="hidden" class="form-control" name="course_id" value="{{$Courses->CourseID}}">


                                            <div class="form-group col-md-6">
                                                <label>Course Name <span  style="color:red"> *</span>  </label>
                                                <input type="text" class="form-control" name="course_title" value="{{$Courses->CourseName}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Specialization<span  style="color:red"> *</span>  </label>
                                                <input type="text" class="form-control"  name="specialization" value="{{$Courses->Specialization}}">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label> MQF/EQF Level </label>
                                                <input type="text" class="form-control" name="mqf_level" value="{{$Courses->MqfLevel}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>ECTS </label>
                                                <input type="text" class="form-control" name="ects" value="{{$Courses->Ects}}">
                                            </div> 

                                            <div class="form-group col-md-6">
                                                <label> Program Type <span  style="color:red"> *</span>  </label>
                                                <select class="form-control" name="course_types" id="course_types">
                                                    <option value="">Select Program Type </option>
                                                    @foreach ($courseTypeData as $data)
                                                        <option value="{{ $data->course_types_id }}"  @if($data->course_types_id == $Courses->CourseType) selected @endif>{{ $data->course_types }}</option>
                                                    @endforeach
                                                </select> 
                                               
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label> Mode of Study <span  style="color:red"> *</span> </label>
                                                <select class="form-control mode_of_study" name="mode_of_study">
                                                    <option value="">Select Mode of Study</option>
                                                    <option value="part_time" @if($Courses->ModeofStudy ==  "part_time") selected @endif>Part Time</option>
                                                    <option value="full_time" @if($Courses->ModeofStudy == "full_time") selected @endif>Full Time</option>
                                                    <option value="distance" @if($Courses->ModeofStudy == "distance") selected @endif>Distance </option>

                                                </select>
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label>Course Price <span  style="color:red"> *</span>  </label>
                                                <input type="text" class="form-control" name="course_price" value="{{$Courses->CourseFees}}">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Administrative Price <span  style="color:red"> *</span>  </label>
                                                <input type="text" class="form-control" name="administrative_price"  value="{{$Courses->AdministrativeCost}}"> 
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label> Currency <span  style="color:red"> *</span>  </label>
                                                <select class="form-control" name="currency_symbols" id="currency_symbols">
                                                    <option value="">Select Currency</option>
                                                    @foreach ($countryData as $data)
                                                        <option value="{{ $data->CurrencySymbol }}"  @if($data->CurrencySymbol == $Courses->Currency) selected @endif>{{ $data->CurrencySymbol }}</option>
                                                    @endforeach
                                                </select> 
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Course Start Date <span  style="color:red"> *</span>  </label>
                                                <input type="date" class="form-control" name="course_start_date"  value="{{$Courses->CoursestartDate}}" >
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label>Course Expire Date <span  style="color:red"> *</span>  </label>
                                                <input type="date" class="form-control" name="course_expire_date"  value="{{$Courses->CourseendDate}}">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Course Duration <span  style="color:red"> *</span>  </label>
                                                <select class="form-control" name="course_duration"  required>
                                                    <option value="">Select Course Duration</option>
                                                    @foreach ($durationData as $data)
                                                        <option value="{{ $data->DurationID }}" @if($data->DurationID == $Courses->CourseDuration) selected @endif>{{ $data->Duration }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> Intake Month <span  style="color:red"> *</span> </label>
                                                <select class="form-control" name="course_intakemonth">
                                                    <option value="">Select Intake Month</option>
                                                    @foreach ($intakemonthData as $data)
                                                        <option value="{{ $data->IntakemonthID }}" @if($data->IntakemonthID == $Courses->IntakeMonth) selected @endif>{{ $data->Intakemonth }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>  Intake Year <span  style="color:red"> *</span>  </label>
                                                <select class="form-control" name="course_intakeyear">
                                                    <option value="">Select Intake Year</option>
                                                    @foreach ($intakeyearData as $data)
                                                        <option value="{{ $data->IntakeyearID }}" @if($data->IntakeyearID == $Courses->IntakeYear) selected @endif>{{ $data->Intakeyear }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label> Language <span  style="color:red"> *</span> </label>
                                                <select class="form-control" name="course_language" >
                                                    <option value="">Select Language</option>
                                                    @foreach ($languageData as $data)
                                                        <option value="{{ $data->LanguageID }}" @if($data->LanguageID == $Courses->Language) selected @endif>{{ $data->Language }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            

                                            
                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                </div>

                                
                            </div>

                            <!-- Course Description -->

                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>Course Description</h4>
                                    </div>
                                </div>

                                <div class="institute-info-edit-pencil-icon">
                                    {{-- <i class="ti-pencil"></i> --}}
                                </div>

                                <div class="dashboard_container_body p-4">
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">
                                            
                                            <div class="form-group col-md-12">
                                                <label>Course Overview <span  style="color:red"> *</span>  </label>
                                                <textarea class="form-control" name="course_description">{{$Courses->CourseOverview}}</textarea>
                                                <label class="course_description-error"  for="course_description" style="display:none;color:red;">Please enter Overview.</label>

                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Course Features</label>
                                                <textarea class="form-control" name="course_features">{{$Courses->Features}}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Opportunities</label>
                                                <textarea class="form-control" name="course_opportunities">{{$Courses->Opportunities}}</textarea>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>Course Tag</label>
                                                <input type="text" class="form-control" placeholder="Course Tag" name="course_tag" value="{{$Courses->CourseTag}}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label> Course Category <span  style="color:red"> *</span> </label>
                                               <select class="form-control" name="course_category" >
                                                   <option value="">Select Category</option>
                                                   @foreach ($categoryData as $data)
                                                       <option value="{{ $data->id }}"  @if($data->id == $Courses->CourseCategory) selected @endif>{{ $data->course_category }}</option>
                                                   @endforeach
                                               </select>
                                                {{-- <input type="text" class="form-control" placeholder="Ex. Science, Physics, Maths.." name="course_category" value="{{$Courses->CourseCategory}}"> --}}
                                            </div>
                                            
                                            

                                            
                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                </div>

                            </div>

                            <!-- Education Eligibility Qualification -->

                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>Eligibility</h4>
                                    </div>
                                </div>

                                <div class="institute-info-edit-pencil-icon">
                                    {{-- <i class="ti-pencil"></i> --}}
                                </div>

                                <div class="dashboard_container_body p-4">
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">	
                                            <div class="form-group col-md-6">
                                                <label> Qualification <span  style="color:red"> *</span> </label>
                                                <select class="form-control" name="qualification" id="qualification" >
                                                    <option value="">Select Qualification</option>
                                                    @foreach ($QualificationData as $data)
                                                        <option value="{{ $data->QualificationID }}" @if($data->QualificationID == $Courses->Qualification) selected @endif>{{ $data->Qualification }}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                            
                                            <div class="form-group col-md-6">
                                                <label>Age Limit (Years) <span  style="color:red"> *</span> </label>
                                                <input type="text" class="form-control" name="age_limit" value="{{$Courses->AgeLimit}}">
                                            </div>

                                            
                                            

                                            
                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                </div>

                            </div>



                            <!-- Curriculum -->

                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>Curriculum</h4>
                                    </div>
                                </div>

                                <div class="institute-info-edit-pencil-icon">
                                    {{-- <i class="ti-pencil"></i> --}}
                                </div>

                                <div class="dashboard_container_body p-4">
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">	
                                            <div class="form-group col-md-12">
                                                <label>Curriculum <span  style="color:red"> *</span> </label>
                                                <textarea class="form-control" name="course_curriculum">{{$Courses->Curriculum}}</textarea>
                                                <label class="course_curriculum-error" for="course_curriculum" style="display:none;color:red;">Please enter Curriculum.</label>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                </div>

                            </div>


                            <!-- Application Procedure -->

                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>Application Procedure</h4>
                                    </div>
                                </div>

                                <div class="institute-info-edit-pencil-icon">
                                    {{-- <i class="ti-pencil"></i> --}}
                                </div>

                                <div class="dashboard_container_body p-4">
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">	
                                            <div class="form-group col-md-12">
                                                <label>Application Procedure <span  style="color:red"> *</span> </label>
                                                <textarea class="form-control" name="application_procedure">{{$Courses->Requirements}}</textarea>
                                                <label class="application_procedure-error"  for="application_procedure" style="display:none;color:red;">Please enter Application Procedure.</label>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                </div>

                            </div>


                            <!-- Brochure and Application Form -->

                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>Brochure and Application Form</h4>
                                    </div>
                                </div>

                                <div class="institute-info-edit-pencil-icon">
                                    {{-- <i class="ti-pencil"></i> --}}
                                </div>

                                <div class="dashboard_container_body p-4">
                                    <div class="submit-section">
                                        <div class="form-row">
                                        
                                            <div class="form-group col-md-12">
                                                <label>Brochure</label>
                                                <input type="file" id="brochure" name="brochure" class="form-control"></a><BR>
                                                <a class="me-3" href="#">
                                                <?php $filePath =  Storage::url('course/brochure/'.$Courses->Brochure); 
                                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                    if($Courses->Brochure){
                                                    if($extension == 'pdf'){?>
                                                    <iframe src="{{ $filePath }}" id="pdfViewers" frameborder="0"  width="100%" height="200px"></iframe>
                                                    <?php }else{ ?>
                                                      <img src="{{$filePath}}"    width="20%" height="50%">
                                                     <?php } } ?>
                                                </a>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Application Form</label>
                                                <input type="file" id="application_form" name="application_form"  class="form-control"></a><BR>
                                                <?php $filePath =  Storage::url('course/application_form/'.$Courses->ApplicationForm); 
                                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                    if($Courses->ApplicationForm){
                                                    if($extension == 'pdf'){?>
                                                    <iframe src="{{ $filePath }}" id="pdfViewers" frameborder="0"  width="300px" height="200px"></iframe>
                                                    <?php }else{ ?>
                                                      <img src="{{$filePath}}"    width="20%" height="50%">
                                                     <?php } } ?>
                                                </a>

                                            </div>


                                            
                                            
                                        </div>
                                    </div>
                                    
                                </div>



                            </div>

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12">
                                    <button class="btn btn-theme EditPostCourse" type="submit" >Edit Course</button>
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
    <!-- ============================ Dashboard: My Order Start End ================================== -->
@endsection

