@extends('admin.layouts.main')
@section('css')
 <style>
 .error {
    color: red;
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
                    $sub_title = "State";
                    $page_title = "All States";
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
                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#add-state-modal"><i class="ri-user-add-fill"></i> Add 
                                        </a>&nbsp;
                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#delete-state-modal"><i class="ri-delete-bin-fill"></i> Delete 
                                        </a>&nbsp;
                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#approve-state-modal"><i class="ri-user-follow-line"></i> Approve 
                                        </a>&nbsp;
                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#reject-state-modal"><i class="ri-close-circle-fill"></i> Reject 
                                        </a>&nbsp;
                                        <div class="dropdown jobsee-dropdown">
                                            <button class="btn dropdown-toggle" type="button"  id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: #03A9F4;"  > <i class="ri-file-excel-2-fill"></i> Excel 
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#import-state-modal">Import</a>
                                                <a class="dropdown-item" href="{{ route('state.export') }}">Export</a>
                                            </div>
                                        </div> 
                                    </div>   
                                </div>
                                <div class="card-body card-success table-responsive">
                                    <div class="col-sm-12">
                                            <table id="state_table" class="table table-striped table-responsive nowrap w-100 text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th id="checkboxsorting"><input type="checkbox" class="" id="CheckState"></th>
                                                        <th>ID</th>
                                                        <th>Country Name</th>
                                                        <th>State Name</th>
                                                        <th>State Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if(count($states) > 0)
                                                <?php $i=1;?>
                                                @foreach($states as $data)
                                                    <tr>
                                                        <td><input type="checkbox" class="sub_chk" data-id="{{$data->StateID}}"></td>
                                                        <td>{{$i}}</td>
                                                        <td>{{$data->CountryName}}</td>
                                                        <td>{{$data->StateName}}</td>
                                                        <td><i class="ri-user-follow-line"></i><span class="badge bg-primary rounded-pill">{{$data->ApprovalStatus}}</span></td>
                                                        <td>
                                                            <a href="#" class="text-reset fs-16 px-1 open-ViewState"  data-bs-toggle="modal"  data-bs-target="#view-State-modal" data-id="{{$data->StateID}}"> <i class="text-reset fs-16 px-1 ri-eye-fill"></i></a>
                                                            <a href="#" class="text-reset fs-16 px-1 open-EditState" data-bs-toggle="modal"   data-bs-target="#edit-state-modal" data-id="{{$data->StateID}}" ><i class="text-reset fs-16 px-1 ri-edit-2-line"></i></a>
                                                            <a href="#" class="text-reset fs-16 px-1 open-DeleteState" data-bs-toggle="modal" data-bs-target="#delete-state-modal" data-id="{{$data->StateID}}"> <i class="ri-delete-bin-2-line"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php $i++;?>
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
                                                {{-- {!! $states->links() !!} --}}
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add State modal content -->
                    <div id="add-state-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="topModalLabel">Add</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="addState">
                                        @csrf
                                            <div class="mb-3">
                                                <label for="country_id" class="form-label">Country</label>
                                                <select class="form-select mb-2" name="country_id" id="country_id" required="">
                                                    <option value="">Select Country</option>
                                                    @foreach ($country as $data)
                                                        <option value="{{ $data->CountryID }}">{{ $data->CountryName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="state_name" class="form-label">State Name</label>
                                                <input class="form-control" type="text" id="state_name" name="state_name" placeholder="State Name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="state_status" class="form-label">State Status</label>
                                                <select class="form-select mb-2" name="state_status" id="state_status" required="">
                                                    <option value="">Select Status</option>
                                                    <option value="Approved">Approved</option>
                                                    <option value="Rejected" >Rejected</option>
                                                </select>
                                            </div>
                                        
                                            <input type="submit" class="btn btn-primary" id="createStateSubmit"  value="Add">

                                </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- Edit State modal content -->
                    <div id="edit-state-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="topModalLabel">Edit</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="editState">
                                        @csrf   
                                        <input class="form-control" type="hidden" id="stateId" name="stateId" placeholder="State ID" required>

                                            <div class="mb-3">
                                                <label for="edit_country_id" class="form-label">Country</label>
                                                <select class="form-select mb-2" name="edit_country_id" id="edit_country_id" required="">
                                                    <option value="">Select Country</option>
                                                    @foreach ($country as $data)
                                                        <option value="{{ $data->CountryID }}">{{ $data->CountryName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="state_name" class="form-label">State Name</label>
                                                <input class="form-control" type="text" id="edit_state_name" name="edit_state_name" placeholder="State Name" required>
                                                <input class="form-control" type="hidden" id="state_name_edit" name="state_name_edit" placeholder="State Name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_state_status" class="form-label">State Status</label>
                                                <select class="form-select mb-2" name="edit_state_status" id="edit_state_status" required="">
                                                    <option value="">Select Status</option>
                                                    <option value="Approved">Approved</option>
                                                    <option value="Rejected" >Rejected</option>
                                                </select>
                                            </div>
                                            <input type="submit" class="btn btn-primary" id="editStateSubmit"  value="Edit">

                                </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                    <!-- View State modal content -->
                    <div id="view-state-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="topModalLabel">View</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="view_State">
                                    <input class="form-control" type="hidden" id="StateId" name="StateId" placeholder="State ID" required>
                                    <div class="row">
                                        <label for="country_id" class="form-label">Country Name : </label><p id="view_country_id"></p>
                                    </div>
                                    <div class="row">
                                    <label for="State_name" class="form-label">State Name : </label><p id="view_state_name" ></p>
                                    </div>
                                    <div class="row">
                                        <label for="State_status" class="form-label">State Status : </label><p id="view_state_status"></p>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                        <!-- Delete manually Modal  -->
                    <div id="delete-state-modal" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="DeleteStates">Delete</button>
                                        <input type="hidden" name="StateId" id="StateId" value=""/>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    
                    
                        <!-- Approve Modal  -->
                        <div id="approve-state-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"  id="ApprovedStates">Approved</button>
                                        <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->   
    
    
                    <!-- Reject Modal  -->
                    <div id="reject-state-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="RejectStates">Rejected</button>
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

                            
                    <!-- Import Modal  -->
                    <div id="import-state-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-body p-2">
                                    <div style="float: right;">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="text-center">
                                            <h4 class="mb-4">Import File </h4>
                                            <form class="ps-3 pe-3" action="#" id="importState">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="city_code" class="form-label">Choose File</label>
                                                    <input type="file" name="customfile" class="form-control" id="customfile">
                                                </div>
                                                <input type="submit" class="btn btn-primary" id="ImportStates"  value="Import">
                                            </form>
                                        
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->  

                    </div>
                </div>
            </div>
        <!-- End Page content -->
        <!-- ============================================================== -->
        </div>
    <!-- END wrapper -->
    </div>
@endsection
@section('js')
<script type="text/javascript" src="{{asset('js/common.js')}}"></script>


<script>
    $(document).ready(function(){
        var table = $('#state_table').DataTable({
            'columnDefs': [{
                'targets': [0,5],
                'searchable': false,
                'orderable': false,
            }],
        });
        $("#checkboxsorting").removeClass("sorting_asc");
  
        $('.dataTables_length').after('<br>');   
    });

    $(function(e){
        $('#CheckState').on('click', function(e) { 
            if($(this).is(':checked',true))    
            {  
                $(".sub_chk").prop('checked', true);    
            } else {    
                $(".sub_chk").prop('checked',false);    
            }    

        });  

    })
    $(document).on("click", ".open-DeleteState", function () {
        var myStateId = $(this).data('id');
        $(".modal-body #StateId").val( myStateId );
    });
    </script>
 @endsection
