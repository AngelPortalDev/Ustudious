@extends('admin.layouts.main')
@section('css')
<style>
.card-header{
    background-color :#d8f3ff;
}
</style>
@endsection
@section('content')
    <!-- Begin page -->
    <div class="wrapper">


        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <?php
                    $sub_title = "Institute";
                    $page_title = "Show Institute";?>
                    @include('admin.layouts.page-title')
                    <!-- end row -->
                    <div class="d-flex justify-content-sm-end"><a href="{{route('institute')}}" class="btn btn-success" >Back</a></div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h4 class="header-title">View Institute</h4>
                                </div>
                                <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2 ">
                                                <label for="fullname" class="form-label">Full Name :    </label>  {{$InstituteData->full_name}}
                                            </div>

                                            <div class="col-md-2">
                                                <label for="company_name" class="form-label">Institute Name :   </label>  {{ $InstituteData->company_name}}
                                            </div>

                                            <div class="col-md-2">
                                                @php $InstitutionType = "" @endphp
                                                @if($InstituteData->type == 'university')
                                                    @php $InstitutionType = "University" @endphp
                                                @elseif($InstituteData->type == 'school') 
                                                    @php $InstitutionType = "School/Colleges"; @endphp
                                                @elseif($InstituteData->type == 'institute') 
                                                    @php $InstitutionType = "Institute"; @endphp
                                                @endif
                                                <label for="company_type" class="form-label">Education Type :   </label>  {{ $InstitutionType }} 
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="institute_email" class="form-label">Email Address:   </label>  {{$InstituteData->institute_email}}
                                            </div>
                                            
                                            <div class="col-md-2">
                                                @php
                                                    $countrydata=getData('country_master',['CountryID','CountryName'],['CountryID'=>$InstituteData->country_id]);
                                                    // print_r($countrydata);
                                                @endphp
                                                <label for="institute_email" class="form-label">Country:   </label>  {{$countrydata[0]->CountryName}}
                                            </div>
                                            <div class="col-md-2 ">
                                                <label for="institute_mobile" class="form-label">Mobile :    </label> {{$InstituteData->rm_code.' '.$InstituteData->institute_mobile}}
                                            </div>
                                           
                                        </div>
                                       
                                        <bR>
                                        <div class="row">
                                            <div class="col-md-2">
                                                @php $Ownership = "" @endphp
                                                @if($InstituteData->ownership === 'private')
                                                    @php $Ownership = "Private" @endphp
                                                @elseif($InstituteData->ownership === 'public') 
                                                    @php $Ownership = "Public / Government"; @endphp
                                                @elseif($InstituteData->ownership === 'public_private') 
                                                    @php $Ownership = "Public Private"; @endphp
                                                @endif
                                                <label for="institute_email" class="form-label">Ownership:   </label>  {{$Ownership}}
                                            </div>
                                                <div class="col-md-2">
                                                    <label for="institute_email" class="form-label">Founded In:   </label>  {{$InstituteData->founded}}
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="institute_email" class="form-label">Campus:   </label>  {{$InstituteData->campus}}
                                                </div>
                                               
                                                <div class="col-md-2">
                                                    <label for="institute_email" class="form-label">Total Courses:   </label>  {{$InstituteData->total_courses}}
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="institute_email" class="form-label">Total Students:   </label>  {{$InstituteData->total_students}}
                                                </div>
                                               
                                        </div>
                                   
                                        <bR>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="institute_email" class="form-label">About Institute:   </label> {{$InstituteData->about_institute}}
                                            </div>
                                            <div class="col-md-6">
                                                <label for="institute_email" class="form-label">Features :   </label> {{$InstituteData->features}}
                                            </div>
                                        </div>
                                        <bR>
                                        <div class="card-header">
                                            <h4 class="header-title"><B>CONTACT INFORMATION</B></h4>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label for="contact_person_name" class="form-label" >Contact Person Name :  </label>{{$InstituteData->contact_person_name}}
                                            </div>
                                            <div class="col-md-3">
                                                <label for="contact_email" class="form-label" >Contact Email :  </label>{{$InstituteData->contact_email}}
                                            </div>
                                            <div class="col-md-3">
                                                <label for="contact_mobile" class="form-label" >Contact Mobile Number :  </label>{{$InstituteData->contact_mobile}}
                                            </div>
                                            <div class="col-md-3">
                                                <label for="landline_no" class="form-label">Landline Number :   </label>{{$InstituteData->landline_no}}
                                            </div>

                                           
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                           
                                        
                                            <div class="col-md-2">
                                                <label for="institute_country" class="form-label">Country  :   </label>  {{ $InstituteData->CountryName }}
                                            </div>
                                           
                                            <div class="col-md-2">
                                                <label for="institute_state" class="form-label">State  :   </label>  {{ $InstituteData->state }}
                                            </div>
                                       
                                       
                                            <div class="col-md-2">
                                                <label for="institute_city" class="form-label">City  :  </label>  {{$InstituteData->state}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="institute_pincode" class="form-label">Postal Code  :  </label>{{$InstituteData->pincode}} 
                                            </div>
                                            <div class="col-md-2">
                                                <label for="institute_address" class="form-label">Full Address  : </label>  {{$InstituteData->address}}
                                            </div>
                                          
                                         
                                        
                                        </div>
                                        
                                        <br>
                                        <div class="card-header">
                                            <h4 class="header-title"><B>SOCIAL LINKS</B></h4>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-2">
                                                <label for="institute_website" class="form-label">Website Link :   </label> {{ $InstituteData->website_link}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="facebook" class="form-label">Facebook  :  </label>  {{$InstituteData->facebook}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="instagram" class="form-label">Instagram :  </label>  {{$InstituteData->instagram}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="twitter" class="form-label">Twitter  :   </label> {{$InstituteData->twitter}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="linkedin" class="form-label">Linkedin  :  </label>  {{$InstituteData->linkedin}}
                                            </div>
                                            <div class="col-md-2">
                                                <label for="linkedin" class="form-label">YouTube  :  </label>  {{$InstituteData->youtube}}
                                            </div>
                                        </div>
                                        <br>
                             
                                        <div class="card-header">
                                            <h4 class="header-title"><B>Documents</B></h4>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label for="institute_idproof" class="form-label">Brochure  :  </label>
                                                <?php  if($InstituteData->institute_idproof){
                                                 $filePath =  Storage::url('institute/idproof/'.$InstituteData->institute_idproof); 
                                                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                                if($InstituteData->institute_idproof){
                                                if($extension == 'pdf'){?>
                                                   <iframe src="{{ $filePath }}" id="pdfViewers" frameborder="0"  width="100%" height="200px"></iframe>
                                                <?php }else{ ?>
                                                   <img class="avatar-md rounded-circle bx-s" src="{{$filePath}}" alt="">
                                                 <?php } ?>
                                                <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="institute_logo" class="form-label">Logo :   </label>
                                                <?php  if($InstituteData->institute_logo){
                                                    $filePath =  Storage::url('institute/logo/'.$InstituteData->institute_logo); ?>
                                                    <img class="avatar-md rounded-circle bx-s" src="{{$filePath}}" alt="">
                                                <?php } ?>
                                            </div> 
                                            <div class="col-md-3">
                                                <label for="company_license" class="form-label">Banner :  </label>
                                                 <?php $filePath =  Storage::url('institute/banner/'.$InstituteData->institute_banner); 
                                                 if($InstituteData->institute_banner){ ?>
                                                    <img class="avatar-md rounded-circle bx-s" src="{{$filePath}}" alt="">
                                                 <?php } ?>
                                                    
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <label for="company_license" class="form-label">Gallery Images :  </label>

                                            <div class="grid-container">
                                                @foreach($Images as $images)
                                                @php $path = 'institute/gallery_images_'.$images->institute_id @endphp

                                                <img src="{{Storage::url($path.'/'.$images->images)}}" class="dsd"  style="width:120px;height:120px;">
                                               
                                                @endforeach

                                                </div>
                                        </div>
                                        <br>

                                     

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
<script type="text/javascript" src="{{asset('js/common.js')}}"></script>
