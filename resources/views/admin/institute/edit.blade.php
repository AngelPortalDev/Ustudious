@extends('admin.layouts.main')
@section('css')
<style>
    .select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-selection__arrow {
    height: 34px !important;
}
.error{
    color:red;
}
.card-header{
    background-color :#d8f3ff;
}
.remove-icon {
    color: red; /* Adjust the color as needed */
    cursor: pointer;
    font-size:20px;
    top:30px;
   }

</style>
@endsection
@section('content')

    <!-- Begin page -->
    <div class="wrapper">
        <!-- ============================================================== -->
    <!-- Start Page Content here 
        <-- ============================================================== -->
        <div class="content-page institute-pages">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <?php
                    $sub_title = "Institute";
                    $page_title = "Edit Institute";?>
                    @include('admin.layouts.page-title')
                    <!-- end row -->
                    <div class="d-flex justify-content-sm-end"><a href="{{route('institute')}}" class="btn btn-success" >Back</a></div>
                    <br>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h4 class="header-title">Institute Info</h4>
                                   
                                </div>
                                <div class="card-body">
                                <form action="#" enctype="multipart/form-data" id="editInstitute">
                                        <div class="row g-2">
                                           <input type="hidden" class="form-control" id="institute_id" name="institute_id"  value="{{$InstituteData->institute_id}}" placeholder="institute id">

                                            {{-- <div class="col-md-3">
                                                <label for="fullname" class="form-label">Full Name </label>
                                                <input type="text" class="form-control" id="full_name" name="full_name"  value="{{$InstituteData->full_name}}" placeholder="Full Name">
                                            </div> --}}

                                            <div class="col-md-4">
                                                <label for="company_name" class="form-label">Institute Name <span  style="color:red"> *</span> </label>
                                                <input type="text" class="form-control" id="company_name" placeholder="Institute Name " value="{{ $InstituteData->company_name}}" name="company_name">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="company_type" class="form-label">Institution Type <span  style="color:red"> *</span> </label>
                                                <select class="form-select mb-2" name="company_type">
                                                    <option value="">Select Institution Type</option>
                                                    <option value="university"  @if('university' == $InstituteData->type) selected @endif>University</option>
                                                    <option value="school" @if('school' == $InstituteData->type) selected @endif >School/Colleges</option>
                                                    <option value="institute" @if('institute' == $InstituteData->type) selected @endif>Institute</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="company_type" class="form-label">Ownership <span  style="color:red"> *</span></label>
                                                <select class="form-select mb-2" name="ownership">
                                                    <option value="">Select Ownership</option>
                                                    <option value="private" @if('private' == $InstituteData->ownership) selected @endif>Private</option>
                                                    <option value="public" @if('public' == $InstituteData->ownership) selected @endif>Public / Government</option>
                                                    <option value="public_private" @if('public_private' == $InstituteData->ownership) selected @endif>Public Private</option>
                                                </select>
                                            </div>
                                            
                                            <!-- <div class="col-md-3">
                                                <label for="company_size" class="form-label">Company Size</label>
                                                <select class="form-select mb-2"  name="company_size">
                                                    <option value="">Select Company Size</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div> -->
                                            <!-- <div class="col-md-4">
                                                <label for="company_industry" class="form-label">Industry</label>
                                                <select class="form-select mb-2"  name="company_industry">
                                                    <option value="">Select Industry</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>

                                            <div class="  col-md-4">
                                                <label for="company_license" class="form-label">Company License Number </label>
                                                <input type="text" class="form-control" id="company_license" value="{{$InstituteData->company_license}}"  placeholder="Company License Number" name="company_license">
                                            </div> -->

                                         
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                           
                                            <div class="col-md-4">
                                                <label for="company_type" class="form-label">Founded in <span  style="color:red"> *</span> </label>
                                                <input type="number" class="form-control" name="founded" value="<?= $InstituteData->founded ?>">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Campus <span  style="color:red"> *</span> </label>
                                                <input type="text" class="form-control" name="institute_campus" value="<?= $InstituteData->campus ?>">
                                            </div>
                                            {{--
                                            <div class="form-group col-md-4">
                                                <label>Current Intake Month <span  style="color:red"> *</span> </label>
                                            
                                                <?php  $intakemonthData=DB::table('intakemonth_master')->select('Intakemonth','IntakemonthID')->distinct()->get(); ?>
                                                <select class="form-control st-country-code" name="intakemonth">
                                                    <option value="">Select Intake Month</option>
                                                    @foreach ($intakemonthData as $data)
                                                        <option value="{{ $data->IntakemonthID }}" @if($data->IntakemonthID == $InstituteData->intakemonth) selected @endif>{{ $data->Intakemonth }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            
                                            <div class="form-group col-md-3">
                                                <label>Total Courses</label>
                                                <input type="text" class="form-control" name="total_courses" value="<?= $InstituteData->total_courses ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Total Students</label>
                                                <input type="text" class="form-control" name="total_students" value="<?= $InstituteData->total_students ?>">
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>About Institution</label>
                                                <textarea class="form-control" name="about_institute"  ><?= $InstituteData->about_institute ?></textarea>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>Institution Features</label>
                                                <textarea class="form-control" name="features"> <?= $InstituteData->features ?></textarea>
                                            </div> --}}

    
                                            {{-- <div class="col-md-32">
                                                <label>About Institution</label>
                                                <textarea class="form-control boxshadow" name="about_institute"  style="pointer-events: none;"  ><?= $InstituteData->about_institute ?></textarea>
                                            </div>
    
                                            <div class="col-md-32">
                                                <label>Institution Features</label>
                                                <textarea class="form-control boxshadow" name="features" style="pointer-events: none;"> <?= $InstituteData->features ?></textarea>
                                            </div> --}}
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                           
                                            <div class="form-group col-md-6">
                                                <label>About Institution <span  style="color:red"> *</span> </label>
                                                <textarea class="form-control" name="about_institute"  ><?= $InstituteData->about_institute ?></textarea>
                                            </div>
                                            <BR>
                                            <div class="form-group col-md-6">
                                                <label>Institution Features</label>
                                                <textarea class="form-control" name="features"> <?= $InstituteData->features ?></textarea>
                                            </div>

                                        </div>
                                        <br>
                                        <div class="card-header">
                                            <h4 class="header-title"><B>CONTACT INFORMATION</B></h4>
                                        </div>
                                        <bR>
                                     
                                        <div class="row g-2">

                                            <div class="form-group col-md-3">
                                                <label>Contact Person Name</label>
                                                <input type="text" class="form-control" name="contact_person_name" value="<?= $InstituteData->contact_person_name ?>">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Email Address</label>
                                                <input type="text" class="form-control" name="contact_email" value="<?= $InstituteData->contact_email ?>">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="institute_country" class="form-label">Country  <span  style="color:red"> *</span> </label>
                                                <select class="form-select  mb-2 select2" name="institute_country" id="institute_country">
                                                    <option value="">Select Country</option>
                                                    @foreach ($country as $data)
                                                        <option value="{{ $data->CountryID }}" @if($data->CountryID == $InstituteData->country) selected @endif>{{ $data->CountryName }}</option>
                                                    @endforeach
                                                </select>  
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Mobile Number</label>
                                                <div style="display:flex;">
                                                    <input type="text" class="form-control country_code" id="country_code" placeholder="Country Code" name="country_code" style="width: 23%;margin-right: 6PX;" value="<?= $InstituteData->country_code ?>">
                                                   <input type="text" class="form-control" name="contact_mobile" value="<?= $InstituteData->contact_mobile ?>">
                                                </div>
                                            </div>
                                           

                                        </div>
                                        <br>
                                        <div class="row g-2">

                                            <div class="form-group col-md-3">
                                                <label>Landline Number</label>
                                                <input type="text" class="form-control" name="landline_no"  value="<?= $InstituteData->landline_no ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="institute_state" class="form-label">State</label>
                                                <select class="form-select mb-2 select2" name="institute_state" id="institute_state">
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
                                       
                                       
                                            <div class="col-md-3">
                                                <label for="institute_city" class="form-label">City</label>
                                                <select class="form-select mb-2 select2" name="institute_city"  id="institute_city" >
                                                    @if($InstituteData->city)
                                                        @foreach ($cities as $data)
                                                            <option value="{{ $data->CityID }}" @if($data->CityID ==$InstituteData->city) selected @endif>{{ $data->CityName }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                           
                                          
                                            <div class="col-md-3">
                                                <label for="institute_pincode" class="form-label">Postal Code</label>
                                                <input type="text" class="form-control" id="institute_pincode" name="institute_pincode" placeholder="Postal Code" value="{{$InstituteData->pincode}}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="institute_address" class="form-label">Full Address</label>
                                                <input type="text" class="form-control" id="institute_address" name="institute_address" placeholder="Full Address" value="{{$InstituteData->address}}">
                                            </div>
                                            
                                            {{-- <div class="col-md-3">
                                                <label for="institute_campus" class="form-label">Campus</label>
                                                <input type="text" class="form-control" id="institute_campus" name="institute_campus" placeholder="Campus" value="{{$InstituteData->campus}}">
                                            </div> --}}
                                        
                                        </div>
                                        
                                       
                                        <br>

                                        <div class="card-header">
                                            <h4 class="header-title"><B>SOCIAL LINKS</B></h4>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <label for="institute_website" class="form-label">Website Link</label>
                                                <input type="text" class="form-control" id="institute_website" name="institute_website" placeholder="https://www.ustudious.com/" value="{{$InstituteData->website_link}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="facebook" class="form-label">Facebook</label>
                                                <input type="text" class="form-control" id="facebook" name="facebook" value="{{$InstituteData->facebook}}" placeholder="https://www.facebook.com/">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="instagram" class="form-label">Instagram</label>
                                                <input type="text" class="form-control" id="instagram" name="instagram" value="{{$InstituteData->instagram}}"  placeholder="https://www.instagram.com/">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <label for="twitter" class="form-label">Twitter</label>
                                                <input type="text" class="form-control" id="twitter" name="twitter" value="{{$InstituteData->twitter}}"  placeholder="https://www.twitter.com/">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="linkedin" class="form-label">Linkedin</label>
                                                <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{$InstituteData->linkedin}}"  placeholder="https://www.linkedin.com/">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="youtube" class="form-label">YouTube</label>
                                                <input type="text" class="form-control" name="youtube" value="<?= $InstituteData->youtube ?>" placeholder="https://www.youtube.com/">
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="card-header">
                                            <h4 class="header-title"><B>Documents</B></h4>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label for="institute_idproof" class="form-label">Brochure
                                                </label>
                                                <div class="" style="position: relative;">
                                                    <a class="me-3" href="#"><?php $filePath =  Storage::url('institute/idproof/'.$InstituteData->institute_idproof); ?>
                                                    <?php if($InstituteData->institute_idproof){ ?>
                                                        <img class="avatar-md rounded-circle bx-s" src="{{$filePath}}" alt="">
                                                    <?php } ?>
                                                    </a><br><br>
                                                    <input type="file" id="institute_idproof" name="institute_idproof"  class="form-control"></a>
                                                </div>
                                            </div>
                                           
                                            {{-- <div class="col-md-3">
                                                <label for="company_license" class="form-label">Company License
                                                </label>
                                                <div class="" style="position: relative;">
                                                    <a class="me-3" href="#">
                                                        <?php $filepath =  Storage::url('institute/license/'.$InstituteData->company_license);
                                                        $extension = pathinfo($filepath, PATHINFO_EXTENSION);
                                                        if($InstituteData->company_license){
                                                        if($extension == 'pdf'){?>
                                                        <iframe src="{{ $filepath }}" id="pdfViewers" frameborder="0"  width="100%" height="200px"></iframe>
                                                        <?php }else{ ?>
                                                          <img src="{{$filepath}}" width="50%" height="50%">
                                                         <?php } ?>
                                                        <?php } ?>
                                                    </a><br><br>
                                                    <input type="file" id="images" name="images[]" multiple>                                                
                                                </div>
                                            </div> --}}
                                            <div class="col-md-8">
                                                <label for="institute_logo" class="form-label">Multiple Gallery Images (Maximum 8 images)
                                                </label>
                                                <div class="" style="position: relative;">
                                                    <bR><BR>
                                                    {{-- <input type="file" id="gallery_images" name="gallery_images[]" class="form-control" multiple> --}}
                                                    @php $Images = DB::table('institute_images')->where('institute_id',$InstituteData->institute_id)->get(); @endphp 
                                                    @if(count($Images)  < 8)
                                                      <input type="file" id="gallery_images" name="gallery_images[]" class="form-control" multiple>
                                                    @else
                                                       <input type="file" id="gallery_images" name="gallery_images[]" class="form-control" multiple disabled>
                                                    @endif
                                                    <BR>
                                                        <div class="grid-container">
                                                        @foreach($Images as $images)
                                                        @php $path = 'institute/gallery_images_'.$images->institute_id @endphp
    
                                                        <img src="{{Storage::url($path.'/'.$images->images)}}" class="dsd"  style="width:120px;height:120px;">
                                                        <a href="{{ route('remove.image', ['id' => $images->institute_images_id]) }}">
                                                            <span class="remove-icon">✖</span>
                                                        </a>
                                                        @endforeach
    
                                                        </div>
                                                </div>
                                            </div>
                                            &nbsp;&nbsp;
                                            {{-- <div class="col-md-3">
                                                <label for="institute_logo" class="form-label">Logo
                                                </label>
                                                <div class="" style="position: relative;">
                                                    <a class="me-3" href="#"><?php $filePath =  Storage::url('institute/logo/'.$InstituteData->institute_logo); ?>
                                                    <?php if($InstituteData->institute_logo){ ?>
                                                        <img class="avatar-md rounded-circle bx-s" src="{{$filePath}}" alt="">
                                                    <?php } ?>
                                                    </a><br><br>
                                                    <input type="file" id="institute_logo" name="institute_logo"  class="form-control"></a>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label for="institute_idproof" class="form-label">Logo
                                                </label>
                                                <div class="" style="position: relative;">
                                                    <a class="me-3" href="#">
                                                    <?php $filePath =  Storage::url('institute/logo/'.$InstituteData->institute_logo); ?>
                                                    <?php if($InstituteData->institute_logo){ ?>
                                                        <img class="avatar-md rounded-circle bx-s" src="{{$filePath}}" alt="">
                                                    <?php } ?></a><br>
                                                    <input type="file" id="institute_logo" name="institute_logo"  class="form-control"></a>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="institute_idproof" class="form-label">Banner
                                                </label>
                                                <div class="" style="position: relative;">
                                                    <a class="me-3" href="#"><?php $filePath =  Storage::url('institute/banner/'.$InstituteData->institute_banner); ?>
                                                    <?php if($InstituteData->institute_banner){ ?>
                                                        <img class="avatar-md rounded-circle bx-s" src="{{$filePath}}" alt="">
                                                    <?php } ?>
                                                    </a><br>
                                                    <input type="file" id="institute_banner" name="institute_banner"  class="form-control"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <input type="submit" class="btn btn-primary" id="EditInstitute" value="Submit">
                                    </form>

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>


                </div> <!-- container -->

            </div> <!-- content -->

    

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

@endsection
@section('js')
<script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/common.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.select2').select2();

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
                    console.log(result.countrycode[0]['CountryCode']);
                    $("#country_code").val('+'+result.countrycode[0]['CountryCode']);
                    $(".country_codes").val(result.countrycode[0]['CountryCode']);
                    $('#institute_state').html('<option value="">-- Select State --</option>');
                    $.each(result.state, function (key, value) {
                        console.log(value.StateName);
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
