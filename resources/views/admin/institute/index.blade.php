@extends('admin.layouts.main')

 @section('css')

 <style>

 .error {

    color: red;

  }

  </style>

 @endsection

@section('content')

 

<div class="wrapper">

        <!-- ============================================================== -->

        <!-- Start Page Content here -->

        <!-- ============================================================== -->

        <div class="content-page">

            <div class="content">



                <!-- Start Content-->

                <div class="container-fluid jobseeker-view-page">



                    <?php

                    $sub_title = "Tables";

                    $page_title = "All Institutes";

                    ?>

                    @include('admin.layouts.page-title')

                  

                    <div class="row">

                        <div class="col-12">

                            <div class="card card-primary card-outline">

                                <div class="card-header jobseeker-header">

                                    <div class="btn-group mb-2 jobsee-header-tabs">

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#add-Institute-modal"><i class="ri-user-add-fill"></i> Add 

                                        </a>&nbsp;

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#delete-selected-modal"><i class="ri-delete-bin-fill"></i> Delete 

                                        </a>&nbsp;

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#approve-modal"><i class="ri-user-follow-line"></i> Approve 

                                        </a>&nbsp;

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#reject-modal"><i class="ri-close-circle-fill"></i> Reject 

                                        </a>&nbsp;

                                        <div class="dropdown jobsee-dropdown">

                                            <button class="btn dropdown-toggle" type="button"  id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"  style="color: #03A9F4;" aria-expanded="false" > <i class="ri-file-excel-2-fill"></i> Excel 

                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                <a class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#import-modal">Import</a>

                                                <a class="dropdown-item" href="{{ route('institute.export') }}">Export</a>

                                            </div>

                                        </div>

                                     

                                    </div>

                                </div>

                                

                                <div class="card-body table-responsive">

                                    <form action="{{ route('institute.search') }}" method="GET">

                                        {{-- <input type="text" name="query" value="" placeholder="Search...">

                                        <button type="submit">Search</button> --}}

                                    </form>

                                    <table id="institute_table" class="table table-striped table-responsive nowrap w-100 text-nowrap">

                                        <thead>

                                            <tr>

                                                <th id="checkboxsorting"><input type="checkbox" class="" id="chkCheckAll"></th>

                                                <th>ID</th>

                                                <th>Logo</th>

                                                <th>Full Name</th>

                                                <th>Institution Name</th>

                                                <th>Email</th>

                                                <th>Mobile</th>

                                                <th>Status</th>

                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @php $i= ''; @endphp

                                            @if(count($InstituteData) > 0)

                                            @php $i=1; @endphp

                                            @foreach($InstituteData as $data)

                                            <?php
                                            // $filePath = storage_path('institute/idproof/'.$data->institute_idproof);
                                            if($data->institute_logo){
                                                 $filePath =  Storage::url('institute/logo/'.$data->institute_logo); 
                                            }else{
                                                $filePath =  Storage::url('no-image.jpg'); 
                                            }
                                            ?>
                                            <tr>

                                                <td><input type="checkbox" class="sub_chk" data-id="{{$data->institute_id}}"></td>

                                                <td>{{$i}}</td>

                                                <td class="jobseeker-profile-photo">

                                                    <img src="{{$filePath}}" alt="ID Proof" width="30%">

                                                <td>{{$data->full_name}}</td>

                                                <td>{{$data->company_name}}</td>

                                                <td>{{$data->institute_email}}</td>

                                                <td>{{$data->country_code.' '.$data->institute_mobile}}</td>

                                                <td><i class="ri-user-follow-line"></i><span class="badge bg-primary rounded-pill"></i>@if($data->institute_status == '1') <?php echo "Approved"  ?> @else <?php echo "Rejected" ?>  @endif</span></td>

                                                <td>

                                                    <a href="{{ route('institute.show',$data->institute_id )}}" class="text-reset fs-16 px-1"> <i class="ri-eye-fill" ></i></a>

                                                    <a href="{{ route('institute.edit',$data->institute_id )}}" class="text-reset fs-16 px-1"> <i class="ri-edit-2-line" ></i></a>

                                                    <a href="#" class="text-reset fs-16 px-1 open-DeleteInstitute" data-bs-toggle="modal"   data-bs-target="#delete-selected-modal" data-id="{{$data->institute_id}}" > <i class="ri-delete-bin-2-line"></i></a>

                                                </td>

                                            </tr>
                                            @php $i++; @endphp
                                            @endforeach

                                            @else

                                            <tr>

                                                <th colspan="9" class="text-center"> No Data Found </th>

                                            </tr>

                                          

                                            @endif

                                        </tbody>

                                    </table>

                                    <br>

                                    {{-- Pagination --}}

                                    <div class="d-flex justify-content-sm-end">
                                            {{-- {!! $InstituteData->links() !!} --}}

                                    </div>

                            </div> <!-- end card body-->

                            </div> <!-- end card -->

                        </div><!-- end col-->

                    </div> <!-- end row-->



                      <!-- Add Institute modal content -->

                    <div id="add-institute-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

                     <div class="modal-dialog modal-md">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h4 class="modal-title" id="topModalLabel">Add Institute</h4>

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                            </div>

                            <div class="modal-body">

                                <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="addInstitute">
                                    @csrf
                                        <div class="mb-3">
                                            <label for="company_name" class="form-label">Institute Name</label>
                                            <input class="form-control" type="text" id="company_name" name="company_name" placeholder="Institute Name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">First Name</label>
                                            <input class="form-control" type="text" id="first_name" name="first_name"  required="" placeholder="First Name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input class="form-control" type="text" id="last_name" name="last_name"  required="" placeholder="Last Name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="emailaddress" class="form-label">Email Address</label>
                                            <input class="form-control" type="email" id="institute_email" name="institute_email"
                                                required="" placeholder="abc@gmail.com">
                                        </div>
                                        <div class="mb-3">
                                          <label for="country_id" class="form-label">Country</label>
                                          <select class="form-select  mb-2" name="country_id" id="country_id">
                                            <option value="">Select Country</option>
                                            @foreach ($countryData as $data)
                                                <option value="{{ $data->CountryID }}">{{ $data->CountryName }}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                        <div class="mb-3">
                                            <input type="hidden" class="form-control country_codes" id="country_codes" placeholder="Country Code" name="country_codes" >
                                            <label for="mobile-number" class="form-label">Mobile Number</label>
                                            <div class="input-group">
                                            <input type="text" class="form-control country_codes" id="country_code" placeholder="Country Code" name="country_code" disabled="">
                                            <input class="form-control" type="text" id="institute_mobile" name="institute_mobile"
                                                required="" placeholder="Mobile No" style="width: 70%;">
                                            </div>
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="rm_code" class="form-label">RM Code</label>
                                            <input class="form-control" type="text" id="institute_rmcode" name="institute_rmcode"
                                                required="" placeholder="RM code">
                                        </div> --}}
                                        <div class="mb-3">
                                            <label for="institute_password" class="form-label">Password</label>
                                            <input class="form-control" type="password" required="" name="institute_password"
                                                id="institute_password" placeholder="Enter Password">
                                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password show-password-eye"></span>

                                        </div>
                                        <div class="mb-3">
                                            <label for="institute_confirm_password" class="form-label">Confirm Password</label>
                                            <input class="form-control" type="password" required="" name="confirm_password"
                                                id="confirm_password" placeholder="Enter Confirm Password">
                                                <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password show-password-eye"></span>

                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="idproof" class="form-label">ID Proof</label>
                                            <input type="file" id="institute_idproof" name="institute_idproof"  class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="company_license" class="form-label">Company License</label>
                                            <input type="file" id="company_license" name="company_license"  class="form-control">
                                        </div> --}}
    
                                        <div class="modal-footer">
                                     
                                            <input type="submit" class="btn btn-primary" id="createInstituteSubmit"  value="Add">
                                            <button type="button" class="btn btn-light"  data-bs-dismiss="modal">Close</button>
                                        </div>
                                </form>



                            </div>

                         </div><!-- /.modal-content -->

                     </div><!-- /.modal-dialog -->

                    </div><!-- /.modal -->





                    <!-- Delete manually Modal  -->

                    <div id="delete-selected-modal" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">

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

                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="DeleteInstitute">Delete</button>

                                        <input type="hidden" name="instituteId" id="instituteId" value=""/>

                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>

                                    </div>

                                </div>

                            </div><!-- /.modal-content -->

                        </div><!-- /.modal-dialog -->

                    </div><!-- /.modal -->            



    

                    <!-- Approve Modal  -->

                    <div id="approve-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

                        <div class="modal-dialog modal-md">

                            <div class="modal-content">

                                <div class="modal-body p-2">

                                    <div style="float: right;">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"

                                            aria-label="Close"></button>

                                    </div>

                                    <div class="text-center">

                                        <i class="ri-information-line h1 text-info"></i>

                                        <h4 class="mt-2">Are you sure you want to the Approved Status?</h4>

                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"  id="ApprovedInstitute">Approved</button>

                                        <button type="button" class="btn btn-light"

                                                data-bs-dismiss="modal">Close</button>

                                    </div>

                                </div>

                            </div><!-- /.modal-content -->

                        </div><!-- /.modal-dialog -->

                    </div><!-- /.modal -->   

    

    

                    <!-- Reject Modal  -->

                    <div id="reject-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

                        <div class="modal-dialog modal-md">

                            <div class="modal-content">

                                <div class="modal-body p-2">

                                    <div style="float: right;">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"

                                            aria-label="Close"></button>

                                    </div>

                                    <div class="text-center">

                                        <i class="ri-information-line h1 text-info"></i>

                                        <h4 class="mt-2">Are you sure you want to the Rejected Status?</h4>

                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="RejectInstitute">Rejected</button>

                                        <button type="button" class="btn btn-light"

                                                data-bs-dismiss="modal">Close</button>

                                    </div>

                                </div>

                            </div><!-- /.modal-content -->

                        </div><!-- /.modal-dialog -->

                    </div><!-- /.modal -->  

                    

                    

                    <!-- Approve Modal  -->

                    <div id="import-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

                        <div class="modal-dialog modal-md">

                            <div class="modal-content">

                                <div class="modal-body p-2">

                                    <div style="float: right;">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"

                                            aria-label="Close"></button>

                                    </div>

                                    <div class="text-center">

                                            <h2 class="mb-4">Import File </h2>

                                            <form action="#" enctype="multipart/form-data" id="importInstitute">

                                                @csrf

                                                <div class="mb-3">

                                                    <label for="city_code" class="form-label">Choose File</label>

                                                    <input type="file" name="customfile" class="form-control" id="customfile" required>

                                                </div>

                                                <button class="btn btn-primary" id="ImportInstitute">Import data</button>

                                            </form>

                                        

                                    </div>

                                </div>

                            </div><!-- /.modal-content -->

                        </div><!-- /.modal-dialog -->

                    </div><!-- /.modal -->   



                    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

                    <div class="modal-dialog modal-md">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h4 class="modal-title" id="topModalLabel">Alert</h4>

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                            </div>

                            <div class="modal-body" >

                                <b>Please Select At Least One Record.</b>

                            </div>

                            <hr>

                        </div><!-- /.modal-content -->

                    </div><!-- /.modal-dialog -->

                    </div><!-- /.modal -->



                    



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

<script>



$(function(e){

    $('#chkCheckAll').on('click', function(e) { 

    

        if($(this).is(':checked',true))    

        {  

            $(".sub_chk").prop('checked', true);    

        } else {    

            $(".sub_chk").prop('checked',false);    

        }    



    });  



});

var mySelect2 = $('.select2')



mySelect2.on("change", function(e) {

  $('.error').css('display','none'); //remove label

});

$(document).on("click", ".open-DeleteInstitute", function () {

    

     var myInstituteId = $(this).data('id');

     $(".modal-body #instituteId").val( myInstituteId );

});



$(document).ready(function(){

    $('.select2').select2();

    

    $('#country_id').on('change', function () {

        var idCountry = this.value;

        $.ajax({

            url: "{{url('institute/fetch-states')}}",

            type: "POST",

            data: {

                country_id: idCountry,

                _token: '{{csrf_token()}}'

            },

            dataType: 'json',

            success: function (result) {

                $(".country_codes").val('+'+result.countrycode[0]['CountryCode']);



            }

        });

    

    });



    var table = $('#institute_table').DataTable({

        'columnDefs': [{

            'targets': [0,8],

            'searchable': false,

            'orderable': false,

        }],

    });

    $("#checkboxsorting").removeClass("sorting_asc");



    $('.dataTables_length').after('<br>');   



});





</script>



@endsection





