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
                    $sub_title = "Intakeyear";
                    $page_title = "All Intake Years";
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
                                            <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#add-intakeyear-modal"><i class="ri-user-add-fill"></i> Add 
                                            </a>&nbsp;
                                            <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#delete-intakeyear-modal"><i class="ri-delete-bin-fill"></i> Delete 
                                            </a>&nbsp;
                                            <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#approve-intakeyear-modal"><i class="ri-user-follow-line"></i> Approve 
                                            </a>&nbsp;
                                            <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#reject-intakeyear-modal"><i class="ri-close-circle-fill"></i> Reject 
                                            </a>&nbsp;
                                            <div class="dropdown jobsee-dropdown">
                                                <button class="btn dropdown-toggle" type="button"  id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #03A9F4;"  > <i class="ri-file-excel-2-fill"></i> Excel 
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#import-intakeyear-modal">Import</a>
                                                    <a class="dropdown-item" href="{{ route('intakeyear.export') }}">Export</a>
                                                </div>
                                            </div> 
                                        </div>   
                                    </div>
                                    <div class="card-body table-responsive">
                                        <div class="col-sm-12">
                                                <table id="intakeyear_table" class="table table-striped table-responsive nowrap w-100 text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th id="checkboxsorting"><input type="checkbox" class="" id="CheckIntakeyear"></th>
                                                            <th>ID</th>
                                                            <th>Intake Year</th>
                                                            <th> Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(count($intakeyears) > 0)
                                                    <?php $i=1; ?>
                                                    @foreach($intakeyears as $data)
                                                        <tr>
                                                            <td><input type="checkbox" class="sub_chk" data-id="{{$data->IntakeyearID}}"></td>
                                                            <td>{{$i}}</td>
                                                            <td>{{$data->Intakeyear}}</td>
                                                            <td><i class="ri-user-follow-line"></i><span class="badge bg-primary rounded-pill">{{$data->ApprovalStatus}}</span></td>
                                                            <td>
                                                                <a href="#" class="text-reset fs-16 px-1 open-ViewIntakeyear"  data-bs-toggle="modal"  data-bs-target="#view-intakeyear-modal" data-id="{{$data->IntakeyearID}}"> <i class="ri-eye-fill"></i></a>
                                                                <a href="#" class="text-reset fs-16 px-1 open-EditIntakeyear" data-bs-toggle="modal"   data-bs-target="#edit-intakeyear-modal" data-id="{{$data->IntakeyearID}}" ><i class="ri-edit-2-line"></i></a>
                                                                <a href="#" class="text-reset fs-16 px-1 open-DeleteIntakeyear" data-bs-toggle="modal" data-bs-target="#delete-intakeyear-modal" data-id="{{$data->IntakeyearID}}"> <i class="ri-delete-bin-2-line"></i></a>
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
                                                    {{-- {!! $intakeyears->links() !!} --}}
                                                </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add intakeyear modal content -->
                        <div id="add-intakeyear-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="topModalLabel">Add</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="addIntakeyear">
                                            @csrf
                                                <div class="mb-3">
                                                    <label for="intakeyear_name" class="form-label">Intake Year</label>
                                                    <input class="form-control" type="text" id="intakeyear_name" name="intakeyear_name" placeholder="Intake Year" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="intakeyear_approval_status" class="form-label">Intake Year Status</label>
                                                    <select class="form-select mb-2" name="intakeyear_approval_status" id="intakeyear_approval_status" required="">
                                                        <option value="">Select Approval Status</option>
                                                        <option value="Approved">Approved</option>
                                                        <option value="Rejected" >Rejected</option>
                                                    </select>
                                                </div>
                                                <input type="submit" class="btn btn-primary" id="createIntakeyearSubmit"  value="Add">

                                    </form>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <!-- Edit intakeyear modal content -->
                        <div id="edit-intakeyear-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="topModalLabel">Edit</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="editIntakeyear">
                                            @csrf   
                                            <input class="form-control" type="hidden" id="intakeyearId" name="intakeyearId" placeholder="Intakeyear ID" required>
                                                <div class="mb-3">
                                                    <label for="intakeyear_name" class="form-label">Intake Year</label>
                                                    <input class="form-control" type="text" id="edit_intakeyear_name" name="edit_intakeyear_name" placeholder="Intake Year" required>
                                                    <input class="form-control" type="hidden" id="intakeyear_name_edit" name="intakeyear_name_edit" placeholder="Intake Year" required>

                                                </div>
                                                <div class="mb-3">
                                                    <label for="approval_status" class="form-label">Intake Year Status</label>
                                                    <select class="form-select mb-2" name="edit_approval_status" id="edit_approval_status" required="">
                                                        <option value="">Select Approval Status</option>
                                                        <option value="Approved">Approved</option>
                                                        <option value="Rejected" >Rejected</option>
                                                    </select>
                                                </div>
                                                <input type="submit" class="btn btn-primary" id="editIntakeyearSubmit"  value="Edit">

                                    </form>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->


                        <!-- View intakeyear modal content -->
                        <div id="view-intakeyear-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="topModalLabel">View</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" id="view_intakeyear">
                                        <input class="form-control" type="hidden" id="intakeyearId" name="intakeyearId" placeholder="intakeyear ID" required>
                                        <div class="row">
                                        <label for="view_intakeyear_name" class="form-label">Intake Year  : </label><p id="view_intakeyear_name" ></p>
                                        </div>
                                        <div class="row">
                                            <label for="view_approval_status" class="form-label">Intake Year Status : </label><p id="view_approval_status"></p>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <!-- Delete manually Modal  -->
                        <div id="delete-intakeyear-modal" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
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
                                            <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="DeleteIntakeyear">Delete</button>
                                            <input type="hidden" name="intakeyearId" id="intakeyearId" value=""/>
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        
                        
                        <!-- Approve Modal  -->
                        <div id="approve-intakeyear-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                            <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"  id="ApprovedIntakeyear">Approved</button>
                                            <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->   
        
        
                        <!-- Reject Modal  -->
                        <div id="reject-intakeyear-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                            <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="RejectIntakeyear">Rejected</button>
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
                        <div id="import-intakeyear-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-body p-2">
                                        <div style="float: right;">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="text-center">
                                                <h2 class="mb-4">Import File </h2>
                                                <form class="ps-3 pe-3" action="#" id="importIntakeyear">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="city_code" class="form-label">Choose File</label>
                                                        <input type="file" name="customfile" class="form-control" id="customfile">
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" id="ImportIntakeyears"  value="Import">
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
        var table = $('#intakeyear_table').DataTable({
            'columnDefs': [{
                'targets': [0,4],
                'searchable': false,
                'orderable': false,
            }],
        });
        $("#checkboxsorting").removeClass("sorting_asc");
  
        $('.dataTables_length').after('<br>');   
    });
    $(document).on("click", ".open-DeleteIntakeyear", function () {
      var myintakeyearId = $(this).data('id');
      $(".modal-body #intakeyearId").val( myintakeyearId );       
    });
    $(function(e){
        $('#CheckIntakeyear').on('click', function(e) { 
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
