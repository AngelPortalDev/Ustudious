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
                    $sub_title = "Qualification";
                    $page_title = "All Qualifications";
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
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#add-qualification-modal"><i class="ri-user-add-fill"></i> Add 
                                                </a>&nbsp;
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#delete-qualification-modal"><i class="ri-delete-bin-fill"></i> Delete 
                                                </a>&nbsp;
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#approve-qualification-modal"><i class="ri-user-follow-line"></i> Approve 
                                                </a>&nbsp;
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#reject-qualification-modal"><i class="ri-close-circle-fill"></i> Reject 
                                                </a>&nbsp;
                                                <div class="dropdown jobsee-dropdown">
                                                    <button class="btn dropdown-toggle" type="button"  id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: #03A9F4;" > <i class="ri-file-excel-2-fill"></i> Excel 
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#import-qualification-modal">Import</a>
                                                        <a class="dropdown-item" href="{{ route('qualification.export') }}">Export</a>
                                                    </div>
                                                </div> 
                                            </div>   
                                        </div>
                                        <div class="card-body table-responsive">
                                            <div class="col-sm-12">

                                                    <table id="qualification_table" class="table table-striped table-responsive nowrap w-100 text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th id="checkboxsorting"><input type="checkbox" class="" id="CheckQualification"></th>
                                                                <th>ID</th>
                                                                <th>Qualification</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(count($Qualifications) > 0)
                                                        <?php $i=1;?>
                                                        @foreach($Qualifications as $data)
                                                            <tr>
                                                                <td><input type="checkbox" class="sub_chk" data-id="{{$data->QualificationID}}"></td>
                                                                <td>{{$i}}</td>
                                                                <td>{{$data->Qualification}}</td>
                                                                <td><i class="ri-user-follow-line"></i><span class="badge bg-primary rounded-pill">{{$data->ApprovalStatus}}</span></td>
                                                                <td>
                                                                    <a href="" class="text-reset fs-16 px-1 open-ViewQualification"  data-bs-toggle="modal"  data-bs-target="#view-qualification-modal" data-id="{{$data->QualificationID}}"> <i class="ri-eye-fill"></i></a>
                                                                    <a href="#" class="text-reset fs-16 px-1 open-EditQualification" data-bs-toggle="modal"   data-bs-target="#edit-qualification-modal" data-id="{{$data->QualificationID}}" ><i class="ri-edit-2-line"></i></a>
                                                                    <a href="#" class="text-reset fs-16 px-1 open-DeleteQualification" data-bs-toggle="modal" data-bs-target="#delete-qualification-modal" data-id="{{$data->QualificationID}}"> <i class="ri-delete-bin-2-line"></i></a>
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
                                                    {{-- Pagination --}}
                                                    <div class="d-flex justify-content-sm-end">
                                                        {{-- {!! $Qualifications->links() !!} --}}
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add qualification modal content -->
                            <div id="add-qualification-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">Add</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="addQualification">
                                            @csrf
                                                <div class="mb-3">
                                                    <label for="qualification_name" class="form-label">Qualification</label>
                                                    <input class="form-control" type="text" id="qualification_name" name="qualification_name" placeholder="Qualification" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="qualification_approval_status" class="form-label">Status</label>
                                                    <select class="form-select mb-2" name="qualification_approval_status" id="qualification_approval_status" required="">
                                                        <option value="">Select Status</option>
                                                        <option value="Approved">Approved</option>
                                                        <option value="Rejected" >Rejected</option>
                                                    </select>
                                                </div>
                                                    <input type="submit" class="btn btn-primary" id="createQualificationSubmit"  value="Add">

                                        </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!-- Edit qualification modal content -->
                            <div id="edit-qualification-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="editQualification">
                                                @csrf   
                                                <input class="form-control" type="hidden" id="qualificationId" name="qualificationId" placeholder="qualification ID" required>
                                                    <div class="mb-3">
                                                        <label for="qualification_name" class="form-label">Qualification</label>
                                                        <input class="form-control" type="text" id="edit_qualification_name" name="edit_qualification_name" placeholder="Qualification" required>
                                                        <input class="form-control" type="hidden" id="qualification_name_edit" name="qualification_name_edit" placeholder="Qualification" required>

                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="approval_status" class="form-label">Status</label>
                                                        <select class="form-select mb-2" name="edit_approval_status" id="edit_approval_status" required="">
                                                            <option value="">Select Status</option>
                                                            <option value="Approved">Approved</option>
                                                            <option value="Rejected" >Rejected</option>
                                                        </select>
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" id="editQualificationSubmit"  value="Edit">

                                        </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->


                            <!-- View qualification modal content -->
                            <div id="view-qualification-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">View</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="view_qualification">
                                            <input class="form-control" type="hidden" id="qualificationId" name="qualificationId" placeholder="qualification ID" required>
                                            <div class="col-md-6">
                                                <label for="view_qualification_name" class="form-label">Qualification : </label><p id="view_qualification_name" ></p>
                                            </div>
                                            <div class="row">
                                                <label for="view_approval_status" class="form-label">Status : </label><p id="view_approval_status"></p>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!-- Delete manually Modal  -->
                            <div id="delete-qualification-modal" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="DeleteQualification">Delete</button>
                                                <input type="hidden" name="qualificationId" id="qualificationId" value=""/>
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->    

                             <!-- Approve Modal  -->
                             <div id="approve-qualification-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"  id="ApprovedQualification">Approved</button>
                                                <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->   
            
            
                            <!-- Reject Modal  -->
                            <div id="reject-qualification-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="RejectQualification">Rejected</button>
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
                            <div id="import-qualification-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-body p-2">
                                            <div style="float: right;">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="text-center">
                                                    <h2 class="mb-4">Import File </h2>
                                                    <form class="ps-3 pe-3" action="#" id="importQualification">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="city_code" class="form-label">Choose File</label>
                                                            <input type="file" name="customfile" class="form-control" id="customfile">
                                                        </div>
                                                        <input type="submit" class="btn btn-primary" id="ImportQualifications"  value="Import">
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
        var table = $('#qualification_table').DataTable({
            'columnDefs': [{
                'targets': [0,4],
                'searchable': false,
                'orderable': false,
            }],
        });
        $("#checkboxsorting").removeClass("sorting_asc");
  
        $('.dataTables_length').after('<br>');   
    });
    $(document).on("click", ".open-DeleteQualification", function () {
        var myqualificationId = $(this).data('id');
        $(".modal-body #qualificationId").val( myqualificationId );
    });
    $(function(e){
        $('#CheckQualification').on('click', function(e) { 
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
