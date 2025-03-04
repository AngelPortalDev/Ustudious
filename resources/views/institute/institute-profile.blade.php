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
label.error{
    color: red!important;
}
.form-group .error {
    color: #4d5868;;
}
    </style>
@if(Session::get('institute_id'))
    <?php 

    $LoginID = Session::get('institute_id');
        $InstituteData = DB::table('institute')->select('institute_contactinfo.*','institute.*')->where(['institute.institute_id'=> $LoginID])
        ->leftjoin('institute_contactinfo','institute_contactinfo.institute_id','=','institute.institute_id')->first(); 
        $countryName = '';
        if($InstituteData->country){
            $country = DB::table('country_master')->where('CountryID',$InstituteData->country)->distinct()->first(); 
            $countryName = $country->CountryName;
        }

    
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
                       
                        <span>{{$countryName}}</span>
                    </div>

                    <div class="d-navigation">
                        <ul id="side-menu">
                            <li class="active"><a href="{{route('institute-profile')}}"><i class="ti-user"></i>Institute
                                    Profile</a></li>
                            <li><a href="{{route('institute-posted-course')}}"><i class="ti-heart"></i>Posted
                                    Course</a></li>
                            <li><a href="{{route('institute-saved-students')}}"><i class="ti-heart"></i>Saved
                                    Students</a></li>
                            <li><a href="{{route('student-applied-course')}}"><i class="ti-settings"></i>Applied Students</a>
                                    </li>
                            {{-- <li><a href="institute-transactions.php"><i class="ti-shopping-cart"></i>Transactions</a>
                            </li> --}}
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
                    <div class="dashboard_container_header">
                        <div class="dashboard_fl_1">
                            <h4>Institution Details</h4>
                        </div>
                    </div>
                    {{-- <div class="institute-info-edit-pencil-icon">
                        <i class="ti-pencil"></i>
                    </div> --}}
                    <div class="institute-info-edit-pencil-icon">
                        <div class="institute_view" id="institute_view" style="display: none;"><i class="ti-eye"></i></div>
                        <div class="institute_edit" id="institute_edit" style="display: block;"><i class="ti-pencil"></i></div>
                    </div>
                    <br><br><Br>
                    <div class="col-lg-12 col-md-12 col-sm-12" id="institute_show_edit"  >
                        <br><BR>
                        <div class="dashboard_container">
                            <div class="dashboard_container_body p-4">
                                <!-- Basic info -->
                                <div class="submit-section">
                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label>Full Name</label>
                                            <div class="form-control boxshadow" name="institute_id" value="<?= $InstituteData->institute_id ?>" disabled style="display:none;"></div>

                                            <div class="form-control boxshadow" name="company_name" ><?= $InstituteData->full_name ?></div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Institution  Email </label>
                                            <div class="form-control  boxshadow" name="company_type"><?= $InstituteData->institute_email; ?></div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label> Institution Mobile</label>
                                            <div class="form-control  boxshadow" name="company_type"><?= $InstituteData->country_code .' '.$InstituteData->institute_mobile ?></div>
                                        </div> 

                                        <div class="form-group col-md-6">
                                            <label> Institution Type</label>
                                            @php $InstitutionType = "" @endphp
                                            @if($InstituteData->type == 'university')
                                                @php $InstitutionType = "University" @endphp
                                            @elseif($InstituteData->type == 'school') 
                                                @php $InstitutionType = "School/Colleges"; @endphp
                                            @elseif($InstituteData->type == 'institute') 
                                                @php $InstitutionType = "Institute"; @endphp
                                            @endif
                                            <div class="form-control  boxshadow" name="company_type"><?= $InstitutionType ?></div>
                                        </div>



                                        <div class="form-group col-md-6">
                                            <label> Ownership</label>
                                            @php $Ownership = "" @endphp
                                            @if($InstituteData->ownership === 'private')
                                                @php $Ownership = "Private" @endphp
                                            @elseif($InstituteData->ownership === 'public') 
                                                @php $Ownership = "Public / Government"; @endphp
                                            @elseif($InstituteData->ownership === 'public_private') 
                                                @php $Ownership = "Public Private"; @endphp
                                            @endif
                                            <div class="form-control  boxshadow" name="Ownership"><?= $Ownership ?></div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Founded in</label>
                                            <div class="form-control boxshadow" class="form-control boxshadow" name="founded" ><?= $InstituteData->founded ?></div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Campus</label>
                                            <div class="form-control boxshadow" class="form-control boxshadow" name="institute_campus" ><?= $InstituteData->campus ?></div>
                                        </div>

                                        {{-- <div class="form-group col-md-6">
                                            <label>Current Intake Month</label>
                                            @if($InstituteData->intakemonth) 
                                            <?php  $intakemonthData=DB::table('intakemonth_master')->select('Intakemonth','IntakemonthID')->where('intakemonthID',$InstituteData->intakemonth)->distinct()->first(); ?>
                                            <div class="form-control st-country-code boxshadow" name="intakemonth">{{$intakemonthData->Intakemonth}}</div>
                                            @else
                                            <div class="form-control st-country-code boxshadow" name="intakemonth"></div>

                                            @endif
                                        </div> --}}

                                        <div class="form-group col-md-6">
                                            <label>Total Courses</label>
                                            <div class="form-control boxshadow" class="form-control boxshadow" name="total_courses" ><?= $InstituteData->total_courses ?></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Total Students</label>
                                            <div class="form-control boxshadow" class="form-control boxshadow" name="total_students"> <?= $InstituteData->total_students ?></div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>About Institution</label>
                                            <textarea class="form-control boxshadow" name="about_institute"  readonly  ><?= $InstituteData->about_institute ?></textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Institution Features</label>
                                            <textarea class="form-control boxshadow" name="features" readonly> <?= $InstituteData->features ?></textarea>
                                        </div>




                                    </div>
                                </div>
                                <!-- Basic info -->

                            </div>
                        </div>

                        

                        <!-- Contact Information -->

                        <div class="dashboard_container">
                            <div class="dashboard_container_header">
                                <div class="dashboard_fl_1">
                                    <h4>Contact Details</h4>
                                </div>
                            </div>

                            {{-- <div class="institute-info-edit-pencil-icon">
                                <i class="ti-pencil"></i>
                            </div> --}}

                            <div class="dashboard_container_body p-4">
                                <!-- Basic info -->
                                <div class="submit-section">
                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label>Contact Person Name</label>
                                            <div type="text" class="form-control boxshadow" name="contact_person_name"><?= $InstituteData->contact_person_name ?></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Email Address</label>
                                            <div type="text" class="form-control boxshadow" name="contact_email"><?= $InstituteData->contact_email ?></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Mobile Number</label>
                                            <div type="text" class="form-control boxshadow" name="contact_mobile"> <?= $InstituteData->country_code .' '. $InstituteData->contact_mobile ?></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Landline Number</label>
                                            <div type="text" class="form-control boxshadow" name="landline_no"> <?= $InstituteData->landline_no ?></div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label> Country</label>
                                          
                                            {{-- <select class="form-control boxshadow" name="institute_country" id="institute_country">
                                                <option value="">Select Country</option>
                                                @foreach ($country as $data)
                                                    <option value="{{ $data->CountryID }}" @if($data->CountryID == $InstituteData->country) selected @endif>{{ $data->CountryName }}</option>
                                                @endforeach
                                            </select>   --}}
                                            <div type="text" class="form-control boxshadow" name="institute_country"> <?= $countryName ?></div>
                                          
                                        </div>



                                        <div class="form-group col-md-6">
                                            <label> State</label>
                                            @if($InstituteData->state)
                                            {{-- <?php $state = DB::table('state_master')->where('StateID',$InstituteData->state)->distinct()->first();  ?> --}}
                                            <div type="text" class="form-control boxshadow" name="institute_country"> <?= $InstituteData->state ?></div>
                                            @else
                                            <div type="text" class="form-control boxshadow" name="institute_country">Not Disclosed</div>
                                            @endif
                                          
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>City</label>
                                            @if($InstituteData->city)
                                            {{-- <?php $cities = DB::table('city_master')->where('CityID',$InstituteData->city)->distinct()->first();  ?> --}}
                                            <div type="text" class="form-control boxshadow" name="institute_country"> <?= $InstituteData->city ?></div>
                                            @else
                                            <div type="text" class="form-control boxshadow" name="institute_country">Not Disclosed</div>
                                            @endif
                                        
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Postal Code</label>
                                            <div type="text" class="form-control boxshadow" name="pincode"><?= $InstituteData->pincode?></div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Address</label>
                                            <div type="text" class="form-control boxshadow"  name="address"><?= $InstituteData->address?></div>
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

                            {{-- <div class="institute-info-edit-pencil-icon">
                                <i class="ti-pencil"></i>
                            </div> --}}

                            <div class="dashboard_container_body p-4">
                                <!-- Basic info -->
                                <div class="submit-section">
                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label>Website</label>
                                            <div type="text" class="form-control boxshadow" name="website" ><?= $InstituteData->website_link ?></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Facebook</label>
                                            <div type="text" class="form-control boxshadow" name="facebook" ><?= $InstituteData->facebook ?></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Instagram</label>
                                            <div type="text" class="form-control boxshadow" name="instagram" ><?= $InstituteData->instagram ?></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>LinkedIn</label>
                                            <div type="text" class="form-control boxshadow" name="linkedin" ><?= $InstituteData->linkedin ?></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Twitter</label>
                                            <div type="text" class="form-control boxshadow" name="twitter" ><?= $InstituteData->twitter ?></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>YouTube</label>
                                            <div type="text" class="form-control boxshadow" name="youtube" ><?= $InstituteData->youtube ?></div>
                                        </div>


                                    </div>
                                </div>
                                <!-- Basic info -->

                            </div>

                        </div>


                        <!-- Brochure and Gallery Images -->
{{-- 
                        <div class="dashboard_container">
                            <div class="dashboard_container_header">
                                <div class="dashboard_fl_1">
                                    <h4>Brochure and Gallery Images</h4>
                                </div>
                            </div>

                            <div class="institute-info-edit-pencil-icon">
                                <i class="ti-pencil"></i>
                            </div>

                            <div class="dashboard_container_body p-4">
                                <!-- Basic info -->
                                <div class="submit-section">
                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label>Brochure</label>
                                            <input type="file" class="form-control boxshadow" name="brochure">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Muliple Gallery Images (Maximum 8 images)</label>
                                            <div action="#" class="dropzone dz-clickable primary-dropzone">
                                                <div class="dz-default dz-message">
                                                    <i class="ti-gallery"></i>
                                                    <span>Drag &amp; Drop To Change Logo</span>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                                <!-- Basic info -->

                            </div>

                        </div> --}}
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12" id="institute_profile_edit" style="display:none" >
                        <bR><BR>
                        <form action="#" enctype="multipart/form-data" id="instituteprofile" >

                            <div class="dashboard_container" >
                                <div class="dashboard_container_body p-4">
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">

                                            <div class="form-group col-md-6">
                                                <label>Institution Name <span  style="color:red"> *</span> </label>
                                                <input type="hidden" class="form-control" name="institute_id" value="<?= $LoginID ?>">
                                                <input type="hidden" class="form-control" name="user_id" value="<?= $InstituteData->user_id ?>">
                                                <input type="hidden" class="form-control" name="company_name" value="<?= $InstituteData->company_name ?>">

                                                <input type="text" class="form-control" name="company_name" value="<?= $InstituteData->company_name ?>" disabled>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label> Institution Type <span  style="color:red"> *</span> </label>
                                                <select class="form-control st-country-code" name="company_type">
                                                     <option value="">Select Institution Type</option>
                                                    <option value="university"  @if('university' == $InstituteData->type) selected @endif>University</option>
                                                    <option value="school" @if('school' == $InstituteData->type) selected @endif >School/Colleges</option>
                                                    <option value="institute" @if('institute' == $InstituteData->type) selected @endif>Institute</option>
                                                </select>
                                            </div>



                                            <div class="form-group col-md-6">
                                                <label>  Ownership <span  style="color:red"> *</span></label>
                                                <select class="form-control st-country-code" name="ownership">
                                                    <option value="">Select Ownership</option>
                                                    <option value="private" @if('private' == $InstituteData->ownership) selected @endif>Private</option>
                                                    <option value="public" @if('public' == $InstituteData->ownership) selected @endif>Public / Government</option>
                                                    <option value="public_private" @if('public_private' == $InstituteData->ownership) selected @endif>Public Private</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Founded in <span  style="color:red"> *</span>  </label>
                                                <input type="number" class="form-control" name="founded" value="<?= $InstituteData->founded ?>" placeholder="Founded In">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Campus <span  style="color:red"> *</span> </label>
                                                <input type="text" class="form-control" name="institute_campus" value="<?= $InstituteData->campus ?>" placeholder="Campus">
                                            </div>
                                            {{-- 
                                            <div class="form-group col-md-6">
                                                <label>Current Intake Month  <span  style="color:red"> *</span> </label>
                                            
                                                <?php  $intakemonthData=DB::table('intakemonth_master')->select('Intakemonth','IntakemonthID')->distinct()->get(); ?>
                                                <select class="form-control st-country-code" name="intakemonth">
                                                    <option value="">Select Intake Month</option>
                                                    @foreach ($intakemonthData as $data)
                                                        <option value="{{ $data->IntakemonthID }}" @if($data->IntakemonthID == $InstituteData->intakemonth) selected @endif>{{ $data->Intakemonth }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-6">
                                                <label>Total Courses</label>
                                                <input type="text" class="form-control" name="total_courses" value="<?= $InstituteData->total_courses ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Total Students</label>
                                                <input type="text" class="form-control" name="total_students" value="<?= $InstituteData->total_students ?>">
                                            </div> --}}

                                            <div class="form-group col-md-12">
                                                <label>About Institution  <span  style="color:red"> *</span></label>
                                                <textarea class="form-control" name="about_institute"  placeholder="About Institute"><?= $InstituteData->about_institute ?></textarea>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>Institution Features</label>
                                                <textarea class="form-control" name="features"  placeholder="Institution Features"><?= $InstituteData->features ?></textarea>
                                            </div>




                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                </div>
                            </div>

                            

                            <!-- Contact Information -->

                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>Contact Details</h4>
                                    </div>
                                </div>

                                {{-- <div class="institute-info-edit-pencil-icon">
                                    <i class="ti-pencil"></i>
                                </div> --}}

                                <div class="dashboard_container_body p-4">
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">

                                            <div class="form-group col-md-6">
                                                <label>Contact Person Name</label>
                                                <input type="text" class="form-control" name="contact_person_name" value="<?= $InstituteData->contact_person_name ?>" placeholder="Contact Person Name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Email Address <span  style="color:red"> *</span> </label>
                                                <input type="text" class="form-control" name="contact_email" value="<?= $InstituteData->contact_email ?>" placeholder="Contact Email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label> Select Country  <span  style="color:red"> *</span> </label>
                                                <?php $countryData = DB::table('country_master')->get(); ?>
                                                {{-- <input type="hidden" class="form-control institute_country" id="institute_country"  name="institute_country" value="<?= $InstituteData->country ?>"> --}}

                                               
                                                 {{-- <input type="text" class="form-control institute_countries" id="institute_countries"  name="institute_countries" value="<?= $country->CountryName ?>" disabled> --}}
                                                <select class="form-control" name="institute_country" id="institute_country" >
                                                    <option value="">Select Country</option>
                                                    @foreach ($countryData as $data)
                                                        <option value="{{ $data->CountryID }}" @if($data->CountryID == $InstituteData->country) selected @endif>{{ $data->CountryName }}</option>
                                                    @endforeach
                                                </select>  
                                            </div>
                                            <div class="form-group col-md-6">
                                                <div>
                                                    <label>Mobile Number</label>
                                                </div>
                                                <div style="display:flex;">
                                                   
                                                    <input type="text" class="form-control country_code" id="country_code" placeholder="Country Code" name="country_code" style="width: 23%;margin-right: 6PX;" value="<?= $InstituteData->country_code ?>" readonly>
                                                   <input type="number" class="form-control" name="contact_mobile" value="<?= $InstituteData->contact_mobile ?>" placeholder="Contact Mobile">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Landline Number</label>
                                                <input type="text" class="form-control" name="landline_no"  value="<?= $InstituteData->landline_no ?>" placeholder="Contact Landline Number">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>State  </label>
                                                <input type="text" class="form-control" name="institute_state"  value="<?= $InstituteData->state ?>" placeholder="State">
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label>City <span  style="color:red"> *</span> </label>
                                                <input type="text" class="form-control" name="institute_city"  value="<?= $InstituteData->city ?>" placeholder="City">
                                            </div>

                                            {{-- <div class="form-group col-md-6">
                                                <label> Select State</label>
                                                <?php $state = DB::table('state_master')->get(); ?>
                                                <select class="form-control" name="institute_state" id="institute_state">
                                                    @if($InstituteData->state || !empty($InstituteData->country))
                                                    @if(!empty($InstituteData->country))
                                                    <option value="">Select State</option>
                                                    @endif
                                                    @foreach ($state as $data)
                                                        <option value="{{ $data->StateID }}" @if($data->StateID ==$InstituteData->state) selected @endif>{{ $data->StateName }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>City</label>
                                                <?php $cities = DB::table('city_master')->get(); ?>
                                                <select class="form-control" name="institute_city"  id="institute_city" >
                                                    <option value="">Select City</option>

                                                    @if($InstituteData->city)
                                                    @foreach ($cities as $data)
                                                        <option value="{{ $data->CityID }}" @if($data->CityID ==$InstituteData->city) selected @endif>{{ $data->CityName }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div> --}}

                                            <div class="form-group col-md-6">
                                                <label>Postal Code</label>
                                                <input type="text" class="form-control" name="pincode" value="<?= $InstituteData->pincode ?>" placeholder="Postal Code">
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>Address</label>
                                                <input type="text" class="form-control"  name="address" value="<?= $InstituteData->address ?>" placeholder="Address">
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

                                {{-- <div class="institute-info-edit-pencil-icon">
                                    <i class="ti-pencil"></i>
                                </div> --}}

                                <div class="dashboard_container_body p-4">
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">

                                            <div class="form-group col-md-6">
                                                <label>Website</label>
                                                <input type="text" class="form-control" name="website" value="<?= $InstituteData->website_link ?>" placeholder="https://www.website.com">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Facebook</label>
                                                <input type="text" class="form-control" name="facebook" value="<?= $InstituteData->facebook ?>" placeholder="https://www.facebook.com/">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Instagram</label>
                                                <input type="text" class="form-control" name="instagram" value="<?= $InstituteData->instagram ?>" placeholder="https://www.instagram.com">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>LinkedIn</label>
                                                <input type="text" class="form-control" name="linkedin" value="<?= $InstituteData->linkedin ?>" placeholder="https://www.linkedin.com">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Twitter</label>
                                                <input type="text" class="form-control" name="twitter" value="<?= $InstituteData->twitter ?>" placeholder="https://www.twitter.com">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>YouTube</label>
                                                <input type="text" class="form-control" name="youtube" value="<?= $InstituteData->youtube ?>" placeholder="https://www.youtube.com">
                                            </div>


                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                </div>

                            </div>


                            <!-- Brochure and Gallery Images -->

                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4>Brochure and Gallery Images</h4>
                                    </div>
                                </div>

                                {{-- <div class="institute-info-edit-pencil-icon">
                                    <i class="ti-pencil"></i>
                                </div> --}}

                                <div class="dashboard_container_body p-4">
                                    <!-- Basic info -->
                                    <div class="submit-section">
                                        <div class="form-row">

                                         
                                            <div class="form-group col-md-6">
                                                <label>Brochure (Only PDFs < 3 MB allowed for upload.)</label>
                                              
                                      
                                                <br>
                                                <input type="file" class="form-control" name="brochure" >
                                                <br>
                                               
                                            </div>
                                            <?php
                                            $filePath =  Storage::url('institute/idproof/'.$InstituteData->institute_idproof);  
                                            if (isset($InstituteData->institute_idproof) && !empty($InstituteData->institute_idproof)){
                                            ?>
                                                <button class="download-brochure"  onclick="downloadBrochure('<?php echo $filePath ?>')"  style="margin-top:40px;"><i class="fa fa-download" aria-hidden="true" ></i> Brochure</button>
                                            <?php } ?>
                                        <br><br>
                                          
                                        <div class="form-group col-md-12">
                                            <label>Multiple Gallery Images (Max 6 images, JPG/PNG < 1 MB each)</label><br>
                                                {{-- <div action="#" id="myDropzone"  name="myDropzone" class="dropzone dz-clickable primary-dropzone">
                                                    <div class="dz-default dz-message">
                                                        <i class="ti-gallery"></i>
                                                        <span>Drag &amp; Drop To Change Logo</span>
                                                    </div>
                                                </div> --}}
                                                
                                               
                                                {{-- <input type="file" id="images" name="images[]" multiple> --}}

                                                @php $Images = DB::table('institute_images')->where('institute_id',$InstituteData->institute_id)->get(); @endphp 
                                                @if(count($Images)  < 8)
                                                  <input type="file" id="gallery_images" name="gallery_images[]" class="form-control" multiple>
                                                @else
                                                   <input type="file" id="gallery_images" name="gallery_images[]" class="form-control" multiple disabled>
                                                @endif
                                                <div class="grid-container">
                                                    @php $imagesCount=0; @endphp
                                                    @foreach($Images as $images)
                                                    @php $path = 'institute/gallery_images_'.$images->institute_id @endphp

                                                    <img src="{{Storage::url($path.'/'.$images->images)}}" class="dsd"  style="width:190px;height:190px;">
                                                    <a href="{{ route('remove.image', ['id' => $images->institute_images_id]) }}">
                                                        <span class="remove-icon">✖</span>
                                                    </a>
                                                    @php $imagesCount++; @endphp
                                                    @endforeach

                                                </div>
                                                {{-- <input type ='text' value="{{$imagesCount}}" id="images_count" > --}}

                                        </div>



                                        </div>
                                    </div>
                                    <!-- Basic info -->

                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12">
                                    <button class="btn btn-theme InstituteProfile" type="submit" id="InstituteProfile" >Submit</button>
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
@endif
@endsection
<!-- ============================ Dashboard: My Order Start End ================================== -->
@section('js')
<script>
$(document).ready(function(){
    
    $("#pencilIcon").click(function () {
            var formData = new FormData($('#profileInstitute')[0]);

            alert("ggfhgf");
        });
    $('#institute_country').on('change', function () {
        var idCountry = this.value;
        $("#institute_state").html('');
        $.ajax({
            url: "{{url('institute/fetch-states')}}",
            type: "POST",
            data: {
                country_id: idCountry,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                $("#country_code").val('+'+result.countrycode[0]['CountryCode']);
                $(".country_codes").val('+'+result.countrycode[0]['CountryCode']);
                $('#institute_state').html('<option value="">-- Select State --</option>');
                $.each(result.state, function (key, value) {
                    $("#institute_state").append('<option value="' + value
                        .StateID + '">' + value.StateName + '</option>');
                });
                $('#institute_city').html('<option value="">-- Select City --</option>');
            }
        });
  
    });
    $('#institute_state').on('change', function () {
            var idState = this.value;
            $("#institute_city").html('');
            $.ajax({
                url: "{{url('institute/fetch-city')}}",
                type: "POST",
                data: {
                    state_id: idState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#institute_city').html('<option value="">-- Select City --</option>');
                    $.each(res.cities, function (key, value) {
                        $("#institute_city").append('<option value="' + value
                            .CityID + '">' + value.CityName + '</option>');
                            // $('#cluster_id').append('<option value="'+data['cluster_id_primary']+'" '+ (area_id == data['cluster_id_primary'] ? ' selected ' : '') +'>'+data['cluster_name']+'</option>');


                    });
                }
            });
        });
});
</script>
@endsection
<!-- Footer file include -->
