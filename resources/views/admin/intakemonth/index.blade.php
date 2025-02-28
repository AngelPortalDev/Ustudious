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
                    $sub_title = "Intakemonth";
                    $page_title = "All Intake Months";
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
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#add-intakemonth-modal"><i class="ri-user-add-fill"></i> Add 
                                                </a>&nbsp;
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#delete-intakemonth-modal"><i class="ri-delete-bin-fill"></i> Delete 
                                                </a>&nbsp;
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#approve-intakemonth-modal"><i class="ri-user-follow-line"></i> Approve 
                                                </a>&nbsp;
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#reject-intakemonth-modal"><i class="ri-close-circle-fill"></i> Reject 
                                                </a>&nbsp;
                                                <div class="dropdown jobsee-dropdown">
                                                    <button class="btn dropdown-toggle" type="button"  id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #03A9F4;" > <i class="ri-file-excel-2-fill"></i> Excel 
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#import-intakemonth-modal">Import</a>
                                                        <a class="dropdown-item" href="{{ route('intakemonth.export') }}">Export</a>
                                                    </div>
                                                </div> 
                                            </div>   
                                        </div>
                                  
                                        <div class="card-body table-responsive">
                                            <div class="col-sm-12">
                                                    <table id="intakemonth_table" class="table table-striped table-responsive nowrap w-100 text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th id="checkboxsorting"><input type="checkbox" class="" id="CheckIntakemonth"></th>
                                                                <th>ID</th>
                                                                <th>Intake Month</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(count($intakemonths) > 0)
                                                        <?php $i=1; ?>
                                                        @foreach($intakemonths as $data)
                                                            <tr>
                                                                <td><input type="checkbox" class="sub_chk" data-id="{{$data->IntakemonthID}}"></td>
                                                                <td>{{$i}}</td>
                                                                <td>{{$data->Intakemonth}}</td>
                                                                <td><i class="ri-user-follow-line"></i><span class="badge bg-primary rounded-pill">{{$data->ApprovalStatus}}</span></td>
                                                                <td>
                                                                    <a href="#" class="text-reset fs-16 px-1 open-ViewIntakemonth"  data-bs-toggle="modal"  data-bs-target="#view-intakemonth-modal" data-id="{{$data->IntakemonthID}}"> <i class="ri-eye-fill"></i></a>
                                                                    <a href="#" class="text-reset fs-16 px-1 open-EditIntakemonth" data-bs-toggle="modal"   data-bs-target="#edit-intakemonth-modal" data-id="{{$data->IntakemonthID}}" ><i class="ri-edit-2-line"></i></a>
                                                                    <a href="#" class="text-reset fs-16 px-1 open-DeleteIntakemonth" data-bs-toggle="modal" data-bs-target="#delete-intakemonth-modal" data-id="{{$data->IntakemonthID}}"> <i class="ri-delete-bin-2-line"></i></a>
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
                                                    {{-- Pagination --}}
                                                    <div class="d-flex justify-content-sm-end">
                                                        {{-- {!! $intakemonths->links() !!} --}}
                                                    </div>
                                           
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add intakemonth modal content -->
                            <div id="add-intakemonth-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">Add</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="addIntakemonth">
                                                @csrf
                                                    <div class="mb-3">
                                                        <label for="intakemonth_name" class="form-label">Intake Month</label>
                                                        <input class="form-control" type="text" id="intakemonth_name" name="intakemonth_name" placeholder="Intake Month" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="intakemonth_approval_status" class="form-label">Intake Month Status</label>
                                                        <select class="form-select mb-2" name="intakemonth_approval_status" id="intakemonth_approval_status" required="">
                                                            <option value="">Select Approval Status</option>
                                                            <option value="Approved">Approved</option>
                                                            <option value="Rejected" >Rejected</option>
                                                        </select>
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" id="createIntakemonthSubmit"  value="Add">

                                        </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!-- Edit intakemonth modal content -->
                            <div id="edit-intakemonth-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="editIntakemonth">
                                                @csrf   
                                                <input class="form-control" type="hidden" id="intakemonthId" name="intakemonthId" placeholder="Intakemonth ID" required>
                                                    <div class="mb-3">
                                                        <label for="intakemonth_name" class="form-label">Intake Month</label>
                                                        <input class="form-control" type="text" id="edit_intakemonth_name" name="edit_intakemonth_name" placeholder="Intake Month" required>
                                                        <input class="form-control" type="hidden" id="intakemonth_name_edit" name="intakemonth_name_edit" placeholder="Intake Month" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="approval_status" class="form-label">Intake Month Status</label>
                                                        <select class="form-select mb-2" name="edit_approval_status" id="edit_approval_status" required="">
                                                            <option value="">Select Approval Status</option>
                                                            <option value="Approved">Approved</option>
                                                            <option value="Rejected" >Rejected</option>
                                                        </select>
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" id="editIntakemonthSubmit"  value="Edit">

                                        </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->


                                    <!-- Edit intakemonth modal content -->
                            <div id="view-intakemonth-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">View</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="view_intakemonth">
                                            <input class="form-control" type="hidden" id="intakemonthId" name="intakemonthId" placeholder="intakemonth ID" required>
                                            <div class="row">
                                            <label for="view_intakemonth_name" class="form-label">Intake Month  : </label><p id="view_intakemonth_name" ></p>
                                            </div>
                                            <div class="row">
                                                <label for="view_approval_status" class="form-label">Intake Month Status : </label><p id="view_approval_status"></p>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!-- Delete manually Modal  -->
                            <div id="delete-intakemonth-modal" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="DeleteIntakemonth">Delete</button>
                                                <input type="hidden" name="intakemonthId" id="intakemonthId" value=""/>
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->    
                            
                            <!-- Approve Modal  -->
                            <div id="approve-intakemonth-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"  id="ApprovedIntakemonth">Approved</button>
                                                <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->   
            
            
                            <!-- Reject Modal  -->
                            <div id="reject-intakemonth-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="RejectIntakemonth">Rejected</button>
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
                            <div id="import-intakemonth-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-body p-2">
                                            <div style="float: right;">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="text-center">
                                                    <h2 class="mb-4">Import File </h2>
                                                    <form class="ps-3 pe-3" action="#" id="importIntakemonth">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="city_code" class="form-label">Choose File</label>
                                                            <input type="file" name="customfile" class="form-control" id="customfile">
                                                        </div>
                                                        <input type="submit" class="btn btn-primary" id="ImportIntakemonths"  value="Import">
                                                    </form>
                                                
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->  


                    </div>

                </div>
        <!-- End Page content -->
        <!-- ============================================================== -->
            </div>
         </div>
    <!-- END wrapper -->
    </div>
@endsection
@section('js')
<script type="text/javascript" src="{{asset('js/common.js')}}"></script>
<script>
     $(document).ready(function(){
        var table = $('#intakemonth_table').DataTable({
            'columnDefs': [{
                'targets': [0,4],
                'searchable': false,
                'orderable': false,
            }],
        });
        $("#checkboxsorting").removeClass("sorting_asc");
  
        $('.dataTables_length').after('<br>');   
    });
    $(document).on("click", ".open-DeleteIntakemonth", function () {
        var myintakemonthId = $(this).data('id');
        $(".modal-body #intakemonthId").val( myintakemonthId );
    });
    $(function(e){
        $('#CheckIntakemonth').on('click', function(e) { 
            if($(this).is(':checked',true))    
            {  
                $(".sub_chk").prop('checked', true);    
            } else {    
                $(".sub_chk").prop('checked',false);    
            }    

        });  

    });
</script>
 @endsection
