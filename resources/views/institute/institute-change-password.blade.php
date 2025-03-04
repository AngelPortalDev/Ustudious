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
@if(Session::get('institute_id'))
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
                            <li ><a href="{{route('institute-profile')}}"><i class="ti-user"></i>Institute
                                    Profile</a></li>
                            <li><a href="{{route('institute-posted-course')}}"><i class="ti-heart"></i>Posted
                                    Course</a></li>
                            <li><a href="{{route('institute-saved-students')}}"><i class="ti-heart"></i>Saved
                                    Students</a></li>
                            <li><a href="{{route('student-applied-course')}}"><i class="ti-settings"></i>Applied Students</a>
                                    </li>
                            {{-- <li><a href="institute-transactions.php"><i class="ti-shopping-cart"></i>Transactions</a>
                            </li> --}}
                            <li class="active"><a href="{{route('institute-change-password')}}"><i class="ti-settings"></i>Change Password</a>
                            </li>
                            <li><a href="{{route('institutelogout')}}"><i class="ti-power-off"></i>Log Out</a></li>
                        </ul>
                    </div>

                </div>


            </div>

            <div class="col-lg-9 col-md-9 col-sm-12">
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
<!--                                             <button class="btn btn-theme UpdatePassword" type="submit"  >UpdatePassword</button>
 -->                                          <button class="btn btn-theme UpdatePassword" type="submit"  >Submit</button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
             
    </div>
      
</section>
@endif
@endsection
<!-- ============================ Dashboard: My Order Start End ================================== -->
