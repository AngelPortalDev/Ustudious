@extends('admin.layouts.main')
@section('css')
 <style>
 .error {
    color: red;
  }

  input[type=number] {
        -moz-appearance: textfield;
    }
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
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
                <div class="container-fluid jobseeker-view-page">

                    <?php
                    $sub_title = "Country";
                    $page_title = "All Countries";
                    ?>
                    @include('admin.layouts.page-title')
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header jobseeker-header">
                                    <div class="btn-group mb-2 jobsee-header-tabs">

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#add-country-modal"><i class="ri-user-add-fill"></i> Add 
                                        </a>&nbsp;
                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#delete-country-modal"><i class="ri-delete-bin-fill"></i> Delete 
                                        </a>&nbsp;
                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#approve-country-modal"><i class="ri-user-follow-line"></i> Approve 
                                        </a>&nbsp;
                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#reject-country-modal"><i class="ri-close-circle-fill"></i> Reject 
                                        </a>&nbsp;
                                        <div class="dropdown jobsee-dropdown">
                                            <button class="btn dropdown-toggle" type="button"  id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #03A9F4;" > <i class="ri-file-excel-2-fill"></i> Excel 
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#import-country-modal">Import</a>
                                                <a class="dropdown-item" href="{{ route('country.export') }}">Export</a>
                                            </div>
                                        </div> 


                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                        <table id="country_table" class="table table-striped table-responsive nowrap w-100 text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th id="checkboxsorting"><input type="checkbox"  id="chkCheckCountry"></th>
                                                    <th>ID</th>
                                                    <th>Country Name</th>
                                                    <th>Country Code</th>
                                                    <th>Currency Symbol</th>
                                                    <th>Country Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($countries) > 0)
                                            <?php $i=1;?>
                                            @foreach($countries as $data)
                                                <tr>
                                                    <td><input type="checkbox" class="sub_chk" data-id="{{$data->CountryID}}"></td>
                                                    <td>{{$i}}</td>
                                                    <td>{{$data->CountryName}}</td>
                                                    <td>{{$data->CountryCode}}</td>
                                                    <td>{{$data->CurrencySymbol}}</td>
                                                    <td><i class="ri-user-follow-line"></i><span class="badge bg-primary rounded-pill">{{$data->ApprovalStatus}}</span></td>
                                                    <td>
                                                        <a href="#" class="text-reset fs-16 px-1 open-ViewCountry"  data-bs-toggle="modal"  data-bs-target="#view-country-modal" data-id="{{$data->CountryID}}"> <i class="ri-eye-fill"></i></a>
                                                        <a href="#" class="text-reset fs-16 px-1 open-EditCountry" data-bs-toggle="modal"   data-bs-target="#edit-country-modal" data-id="{{$data->CountryID}}" ><i class="ri-edit-2-line"></i></a>
                                                        <a href="#" class="text-reset fs-16 px-1 open-DeleteCountry" data-bs-toggle="modal" data-bs-target="#delete-country-modal" data-id="{{$data->CountryID}}"> <i class="ri-delete-bin-2-line"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                            @else
                                            <tr>
                                                <th colspan="9" class="text-center"> No Data Found </th>
                                            </tr>
                                            @endif
                                            </tbody>
                                        </table>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->

                    <!-- Add Country modal content -->
                    <div id="add-country-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="topModalLabel">Add</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="addCountry">
                                        @csrf
                                            <div class="mb-3">
                                                <label for="country_name" class="form-label">Country Name</label>
                                                <input class="form-control" type="text" id="country_name" name="country_name" placeholder="Country Name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="country_code" class="form-label">Country Code</label>
                                                <input class="form-control" type="number" id="country_code" name="country_code" required="" placeholder="Country Code">
                                            </div>
                                            <div class="mb-3">
                                                <label for="currency_symbol" class="form-label">Currency Symbol</label>
                                                <input class="form-control" type="text" id="currency_symbol" name="currency_symbol" required="" placeholder="Currency Symbol">
                                            </div>
                                            <div class="mb-3">
                                                <label for="country_status" class="form-label">Country Status</label>
                                                <select class="form-select mb-2" name="country_status" id="country_status" required="">
                                                    <option value="">Select Status</option>
                                                    <option value="Approved">Approved</option>
                                                    <option value="Rejected" >Rejected</option>
                                                </select>
                                            </div>
                                        
                                            <input type="submit" class="btn btn-primary" id="createCountrySubmit"  value="Add">

                                </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- Edit Country modal content -->
                    <div id="edit-country-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="topModalLabel">Edit</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="editCountry">
                                        @csrf   
                                        <input class="form-control" type="hidden" id="countryId" name="countryId" placeholder="Country ID" required>


                                            <div class="mb-3">
                                                <label for="country_name" class="form-label">Country Name</label>
                                                <input class="form-control" type="text" id="edit_country_name" name="edit_country_name" placeholder="Country Name" required>
                                                <input class="form-control" type="hidden" id="country_name_edit" name="country_name_edit" placeholder="Country Name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="country_code" class="form-label">Country Code</label>
                                                <input class="form-control" type="number" id="edit_country_code" name="edit_country_code" required="" placeholder="Country Code">
                                                <input class="form-control" type="hidden" id="country_code_edit" name="country_code_edit" placeholder="Country  Code" required>

                                            </div>
                                            <div class="mb-3">
                                                <label for="currency_symbol" class="form-label">Currency Symbol</label>
                                                <input class="form-control" type="text" id="edit_currency_symbol" name="edit_currency_symbol" required="" placeholder="Currency Symbol">
                                            </div>
                                            <div class="mb-3">
                                                <label for="country_status" class="form-label">Country Status</label>
                                                <select class="form-select mb-2" name="edit_country_status" id="edit_country_status" required="">
                                                    <option value="">Select Status</option>
                                                    <option value="Approved">Approved</option>
                                                    <option value="Rejected" >Rejected</option>
                                                </select>
                                            </div>
                                            <input type="submit" class="btn btn-primary" id="editCountrySubmit"  value="Edit">

                                </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                    <!-- View Country modal content -->
                    <div id="view-country-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="topModalLabel">View</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="view_country">
                                    <input class="form-control" type="hidden" id="countryId" name="countryId" placeholder="Country ID" required>
                                    <div class="row">
                                    <label for="country_name" class="form-label">Country Name : </label><p id="view_country_name" ></p>
                                    </div>
                                    <div class="row">
                                        <label for="country_code" class="form-label">Country Code : </label><p id="view_country_code"></p>
                                    </div>
                                    <div class="row">
                                        <label for="view_country_status" class="form-label">Country Status : </label><p id="view_country_status"></p>
                                    </div>
                                    <div class="row">
                                        <label for="currency_symbol" class="form-label">Currency Symbol : </label><p id="view_currency_symbol"></p>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- Delete manually Modal  -->
                    <div id="delete-country-modal" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="DeleteCountry">Delete</button>
                                        <input type="hidden" name="countryId" id="countryId" value=""/>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal --> 
                    
                    
                    
                    <!-- Approve Modal  -->
                    <div id="approve-country-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"  id="ApprovedCountry">Approved</button>
                                        <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->   
    
    
                    <!-- Reject Modal  -->
                    <div id="reject-country-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="RejectCountry">Rejected</button>
                                        <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->  


                    <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="topModalLabel">Alert</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" >
                                    <b>Please Select At Least One Record.</b>
                                </div>
                                <hr>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                            
                    <!-- Import Modal  -->
                    <div id="import-country-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-body p-2">
                                    <div style="float: right;">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="text-center">
                                            <h4 class="mb-4">Import File </h4>
                                            <form action="#" method="POST" enctype="multipart/form-data" id="importCountry">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="city_code" class="form-label">Choose File</label>
                                                    <input type="file" name="customfile" class="form-control" id="customfile">
                                                </div>
                                                <input type="submit" class="btn btn-primary" id="ImportCountry"  value="Import">
                                            </form>
                                        
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->  
                            
                </div>
                <!-- End Page container -->
                <!-- ============================================================== -->
            </div>
            <!-- End Page content -->
         </div>
         <!-- End Page content Page -->
    </div>
    <!-- END wrapper -->
@endsection
@section('js')
<script type="text/javascript" src="{{asset('js/common.js')}}"></script>

<script>

    $(document).ready(function(){
        var table = $('#country_table').DataTable({
      
        'columnDefs': [{
            'targets': [0,6],
            'searchable': false,
            'orderable': false,
        }],
        "pagingType": "full_numbers",
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }

        });
        $("#checkboxsorting").removeClass("sorting_asc");
  
        $('.dataTables_length').after('<br>');   
    });

  
    $(function(e){
        $('#chkCheckCountry').on('click', function(e) { 
            if($(this).is(':checked',true))    
            {  
                $(".sub_chk").prop('checked', true);    
            } else {    
                $(".sub_chk").prop('checked',false);    
            }    

        });  

    });

    $(document).on("click", ".open-DeleteCountry", function () {
        var mycountryId = $(this).data('id');
        $(".modal-body #countryId").val( mycountryId );
    });
</script>
 @endsection
