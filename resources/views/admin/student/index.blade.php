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

                    $page_title = "All Students";

                    ?>

                    @include('admin.layouts.page-title')

                  

                    <div class="row">

                        <div class="col-12">

                            <div class="card card-primary card-outline">

                                <div class="card-header jobseeker-header">

                                    <div class="btn-group mb-2 jobsee-header-tabs">

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#add-student-modal"><i class="ri-user-add-fill"></i> Add 

                                        </a>

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#delete-student-modal"><i class="ri-delete-bin-fill"></i> Delete 

                                        </a>&nbsp;

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#approve-student-modal"><i class="ri-user-follow-line"></i> Approve 

                                        </a>&nbsp;

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#reject-student-modal"><i class="ri-close-circle-fill"></i> Reject 

                                        </a>&nbsp;

                                        <div class="dropdown jobsee-dropdown">

                                            <button class="btn dropdown-toggle" type="button"  id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: #03A9F4;"  > <i class="ri-file-excel-2-fill"></i> Excel 

                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                <a class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#import-student-modal">Import</a>

                                                <a class="dropdown-item" href="{{ route('student.export') }}">Export</a>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="card-body table-responsive">

                                    <!-- <table id="alternative-page-datatable" -->

                                    <table id="student_table" class="table table-striped dt-responsive nowrap w-100 text-nowrap">

                                        <thead>

                                            <tr>

                                                <th id="checkboxsorting"><input type="checkbox" class="" id="CheckStudent"></th>

                                                <th>ID</th>

                                                <th>Photo</th>

                                                <th>Name</th>

                                                <th>Email</th>

                                                <th>Mobile</th>

                                                <th>Status</th>

                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @if(count($StudentData) > 0)

                                            @php $i=1; @endphp

                                            @foreach($StudentData as $data)

                                         

                                            <?php $filepath =  Storage::url('student/student_'.$data->StudentID.'/'.$data->Photo); ?>



                                            <tr>

                                                <td><input type="checkbox" class="sub_chk" data-id="{{$data->StudentID}}"></td>

                                                <td>{{$i}}</td>

                                                <td class="jobseeker-profile-photo">

                                                    <img src="{{$filepath}}" alt="ID Proof">

                                                

                                                <td>{{$data->FirstName}}</td>

                                                <td>{{$data->Email}}</td>

                                                <td>{{$data->CountryCode.' '.$data->Mobile}}</td>

                                                <td><i class="ri-user-follow-line"></i><span class="badge bg-primary rounded-pill"></i>{{$data->ApprovalStatus}}</span></td>

                                                <td>

                                                    <a href="{{ route('student.show',$data->StudentID)}}" class="text-reset fs-16 px-1"> <i class="ri-eye-fill" ></i></a>

                                                    <a href="{{ route('student.edit',$data->StudentID)}}" class="text-reset fs-16 px-1"> <i class="ri-edit-2-line" ></i></a>

                                                    <a href="#" class="text-reset fs-16 px-1 open-DeleteStudent" data-bs-toggle="modal"   data-bs-target="#delete-student-modal" data-id="{{$data->StudentID }}" > <i class="ri-delete-bin-2-line"></i></a>

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

                                        {{-- {!! $StudentData->links() !!} --}}

                                    </div>

                            </div> <!-- end card body-->

                            </div> <!-- end card -->

                        </div><!-- end col-->

                    </div> <!-- end row-->



                      <!-- Add Institute modal content -->

                         <!-- Add Institute modal content -->
                         <div id="add-student-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                               <div class="modal-content">
                                   <div class="modal-header">
                                       <h4 class="modal-title" id="topModalLabel">Add Student</h4>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                   </div>
                                   <div class="modal-body">
                                   <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="addStudent">
                                       @csrf
                                           <div class="mb-3">
                                               <label for="first_name" class="form-label">First Name</label>
                                               <input class="form-control" type="text" id="first_name" name="first_name" placeholder="First Name" required>
                                           </div>
                                           <div class="mb-3">
                                               <label for="last_name" class="form-label">Last Name</label>
                                               <input class="form-control" type="text" id="last_name" name="last_name" required="" placeholder="Last Name">
                                           </div>
                                           <div class="mb-3">
                                               <label for="emailaddress" class="form-label">Email Address</label>
                                               <input class="form-control" type="email" id="student_email" name="student_email"  required="" placeholder="Email">
                                           </div>
                                           <div class="mb-3">
                                               <label for="country_id" class="form-label">Country</label>
                                               <select class="form-select  mb-2 " name="country_id" id="country_id">
                                                   <option value="">Select Country</option>
                                                   <?php foreach ($countryDatas as $countries){ ?>
                                                       <option value="<?= $countries->CountryID ?>"><?= $countries->CountryName ?></option>
                                                   <?php } ?>
                                                    </select>
                                           </div>
                                           <input type="hidden" class="form-control country_codes" id="country_codes" placeholder="Country Code" name="country_codes">
                                           <div class="mb-3">
                                               <label for="mobile-number" class="form-label">Mobile Number</label>
                                               <div class="input-group">
                                               <input type="text" class="form-control country_codes" id="country_code" placeholder="Country Code" name="country_code" disabled="">
                                               <input class="form-control" type="text" id="student_mobile" name="student_mobile"
                                                   required="" placeholder="Mobile" style="width: 70%;">
                                               </div>
                                           </div>
                                          
                                           <div class="mb-3" style="position: relative">
                                               <label for="mobile-number" class="form-label">Password</label>
                                               <input type="student_password" placeholder="Password" name="student_password" id="student_password" class="form-control" required>
                                               <span toggle="#student_password" class="fa fa-fw fa-eye field-icon toggle-password show-password-eye"></span>
                                           </div>
       
                                           <div class="mb-3"  style="position: relative">
                                               <label for="mobile-number" class="form-label">Confirm Password</label>
                                               <input type="password" placeholder="Confirm Password" name="confirm_password" id="confirm_password" class="form-control" required>
                                               <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password show-password-eye"></span>
                                               <span id="passwordError" class="error"></span>
                                           </div>
                                           {{-- <div class="mb-3">
                                               <label for="current_location" class="form-label">Address</label>
                                               <input class="form-control" type="text" id="current_location" name="current_location" required="" placeholder="Location">
                                           </div> --}}
                                           {{-- <div class="mb-3">
                                               <label for="idproof" class="form-label">Photo</label>
                                               <input type="file" id="student_photo" name="student_photo"  class="form-control">
                                           </div> --}}
                                           <div class="modal-footer">
                                               <input type="submit" class="btn btn-primary" id="createStudentSubmit"  value="Add">
                                               <button type="button" class="btn btn-light"  data-bs-dismiss="modal">Close</button>
                                           </div>
                                   </form>
       
                                   </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                           </div><!-- /.modal -->
       




                    <!-- Delete manually Modal  -->

                    <div id="delete-student-modal" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">

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

                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="DeleteStudent">Delete</button>

                                        <input type="hidden" name="studentId" id="studentId" value=""/>

                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>

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





                    <!-- Approve Modal  -->

                    <div id="approve-student-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

                        <div class="modal-dialog modal-md">

                            <div class="modal-content">

                                <div class="modal-body p-2">

                                    <div style="float: right;">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"

                                            aria-label="Close"></button>

                                    </div>

                                    <div class="text-center">

                                        <i class="ri-information-line h1 text-info"></i>

                                        <h5 class="mt-2">Are you sure you want to the Approved Status?</h5>

                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"  id="ApprovedStudent">Approved</button>

                                        <button type="button" class="btn btn-light"

                                                data-bs-dismiss="modal">Close</button>

                                    </div>

                                </div>

                            </div><!-- /.modal-content -->

                        </div><!-- /.modal-dialog -->

                    </div><!-- /.modal -->   





                    <!-- Reject Modal  -->

                    <div id="reject-student-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

                        <div class="modal-dialog modal-md">

                            <div class="modal-content">

                                <div class="modal-body p-2">

                                    <div style="float: right;">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"

                                            aria-label="Close"></button>

                                    </div>

                                    <div class="text-center">

                                        <i class="ri-information-line h1 text-info"></i>

                                        <h5 class="mt-2">Are you sure you want to the Rejected Status?</h5>

                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="RejectStudent">Rejected</button>

                                        <button type="button" class="btn btn-light"

                                                data-bs-dismiss="modal">Close</button>

                                    </div>

                                </div>

                            </div><!-- /.modal-content -->

                        </div><!-- /.modal-dialog -->

                    </div><!-- /.modal -->  





                     <!-- Import Modal  -->

                     <div id="import-student-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

                        <div class="modal-dialog modal-md">

                            <div class="modal-content">

                                <div class="modal-body p-2">

                                    <div style="float: right;">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"

                                            aria-label="Close"></button>

                                    </div>

                                    <div class="text-center">

                                            <h2 class="mb-4">Import File </h2>

                                            <form class="ps-3 pe-3" action="#" id="importStudent">

                                                @csrf

                                                <div class="mb-3">

                                                    <label for="city_code" class="form-label">Choose File</label>

                                                    <input type="file" name="customfile" class="form-control" id="customfile">

                                                </div>

                                                <input type="submit" class="btn btn-primary" id="ImportStudents"  value="Import">

                                            </form>

                                        

                                    </div>

                                </div>

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



<script>

 $(document).ready(function(){



        $('.select2').select2();

        var table = $('#student_table').DataTable({

            'columnDefs': [{

                'targets': [0,7,2,5],

                'searchable': false,

                'orderable': false,

            }],

        });

        $("#checkboxsorting").removeClass("sorting_asc");

  

        $('.dataTables_length').after('<br>');   



       



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

    });



    $(function(e){

        $('#CheckStudent').on('click', function(e) { 

            if($(this).is(':checked',true))    

            {  

                $(".sub_chk").prop('checked', true);    

            } else {    

                $(".sub_chk").prop('checked',false);    

            }    



        });  



    })



    $(document).on("click", ".open-DeleteStudent", function () {

        

        var mystudentId = $(this).data('id');

        $(".modal-body #studentId").val( mystudentId );

    });



</script>



@endsection





