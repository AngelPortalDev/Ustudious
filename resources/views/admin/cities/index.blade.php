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
                    $sub_title = "Cities";
                    $page_title = "All Cities";
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
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#add-cities-modal"><i class="ri-user-add-fill"></i> Add 
                                                </a>&nbsp;
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#delete-cities-modal"><i class="ri-delete-bin-fill"></i> Delete 
                                                </a>&nbsp;
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#approve-cities-modal"><i class="ri-user-follow-line"></i> Approve 
                                                </a>&nbsp;
                                                <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal" data-bs-target="#reject-cities-modal"><i class="ri-close-circle-fill"></i> Reject 
                                                </a>&nbsp;
                                                <div class="dropdown jobsee-dropdown">
                                                    <button class="btn dropdown-toggle" type="button"  id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: #03A9F4;"  > <i class="ri-file-excel-2-fill"></i> Excel 
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#import-cities-modal">Import</a>
                                                        <a class="dropdown-item" href="{{ route('cities.export') }}">Export</a>
                                                    </div>
                                                </div> 
                                            </div>   
                                        </div>
                                  
                                        <div class="card-body table-responsive">
                                            <div class="col-sm-12">
                                                    <table id="cities_table" class="table table-striped table-responsive nowrap w-100 text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th id="checkboxsorting"><input type="checkbox" class="" id="CheckCities"></th>
                                                                <th>ID</th>
                                                                <th>State Name</th>
                                                                <th>City Name</th>
                                                                <th>City Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(count($cities) > 0)
                                                        <?php $i=1;?>
                                                        @foreach($cities as $data)
                                                            <tr>
                                                                <td><input type="checkbox" class="sub_chk" data-id="{{$data->CityID}}"></td>
                                                                <td>{{$i}}</td>
                                                                <td>{{$data->StateName}}</td>
                                                                <td>{{$data->CityName}}</td>
                                                                <td><i class="ri-user-follow-line"></i><span class="badge bg-primary rounded-pill">{{$data->ApprovalStatus}}</span></td>
                                                                <td>
                                                                    <a href="#" class="text-reset fs-16 px-1 open-ViewCities"  data-bs-toggle="modal"  data-bs-target="#view-cities-modal" data-id="{{$data->CityID}}"><i class="ri-eye-fill"></i></a>
                                                                    <a href="#" class="text-reset fs-16 px-1 open-EditCities" data-bs-toggle="modal"   data-bs-target="#edit-cities-modal" data-id="{{$data->CityID}}" ><i class="ri-edit-2-line"></i></a>
                                                                    <a href="#" class="text-reset fs-16 px-1  open-DeleteCities" data-bs-toggle="modal" data-bs-target="#delete-cities-modal" data-id="{{$data->CityID}}"> <i class="ri-delete-bin-2-line"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php $i++ ?>
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
                                                        {{-- {!! $cities->links() !!} --}}
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add State modal content -->
                            <div id="add-cities-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">Add</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="ps-3 pe-3" action="#" id="addCities">
                                                @csrf
                                                    <div class="mb-3">
                                                        <label for="city_code" class="form-label">State</label>
                                                        <select class="form-select mb-2" name="state_id" id="state_id" required="">
                                                            <option value="">Select State</option>
                                                            @foreach ($state as $data)
                                                                <option value="{{ $data->StateID }}">{{ $data->StateName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="city_name" class="form-label">City Name</label>
                                                        <input class="form-control" type="text" id="city_name" name="city_name" placeholder="City Name" required>
                                                    </div>
                                                
                                                    <div class="mb-3">
                                                        <label for="city_status" class="form-label">City Status</label>
                                                        <select class="form-select mb-2" name="city_status" id="city_status" required="">
                                                            <option value="">Select Status</option>
                                                            <option value="Approved">Approved</option>
                                                            <option value="Rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" id="createCitiesSubmit"  value="Add">

                                        </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!-- Edit State modal content -->
                            <div id="edit-cities-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="editCities">
                                                @csrf   
                                                <input class="form-control" type="hidden" id="cityId" name="cityId" placeholder="City ID" required>
                                                
                                                    <div class="mb-3">
                                                        <label for="city_code" class="form-label">State</label>
                                                        <select class="form-select mb-2" name="edit_state_id" id="edit_state_id" required="">
                                                            <option value="">Select State</option>
                                                            @foreach ($state as $data)
                                                                <option value="{{ $data->StateID }}">{{ $data->StateName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="city_name" class="form-label">City Name</label>
                                                        <input class="form-control" type="text" id="edit_city_name" name="edit_city_name" placeholder="City Name" required>
                                                        <input class="form-control" type="hidden" id="city_name_edit" name="city_name_edit" placeholder="City Name" required>

                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="city_status" class="form-label">City Status</label>
                                                        <select class="form-select mb-2" name="edit_city_status" id="edit_city_status" reuqired="">
                                                            <option value="">Select Status</option>
                                                            <option value="Approved">Approved</option>
                                                            <option value="Rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" id="editCitiesSubmit"  value="Edit">

                                        </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->


                            <!-- View State modal content -->
                            <div id="view-cities-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">View</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="view_city">
                                            <input class="form-control" type="hidden" id="cityId" name="cityId" placeholder="City ID" required>
                                            <div class="row">
                                            <label for="state_name" class="form-label">State Name : </label><p id="view_state_name" ></p>
                                            </div>
                                            <div class="row">
                                                <label for="city_name" class="form-label">City Name : </label><p id="view_city_name"></p>
                                            </div>
                                            <div class="row">
                                                <label for="city_status" class="form-label">City Status : </label><p id="view_city_status"></p>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                               <!-- Delete manually Modal  -->
                            <div id="delete-cities-modal" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="DeleteCities">Delete</button>
                                                <input type="hidden" name="cityId" id="cityId" value=""/>
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            
                            
                             <!-- Approve Modal  -->
                             <div id="approve-cities-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"  id="ApprovedCities">Approved</button>
                                                <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->   
            
            
                            <!-- Reject Modal  -->
                            <div id="reject-cities-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal" id="RejectCities">Rejected</button>
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
                                        </div>
                                        <hr>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                                 
                            <!-- Import Modal  -->
                            <div id="import-cities-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-body p-2">
                                            <div style="float: right;">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="text-center">
                                                <h2 class="mb-4">Import File</h2>
                                                <form class="ps-3 pe-3" action="#" id="importCity">
                                                  @csrf
                                                    <div class="mb-3">
                                                        <label for="city_code" class="form-label">Choose File</label>
                                                        <input type="file" name="customfile" class="form-control" id="customfile">
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" id="ImportCities"  value="Import">
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
        var table = $('#cities_table').DataTable({
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
        $('#CheckCities').on('click', function(e) { 
            if($(this).is(':checked',true))    
            {  
                $(".sub_chk").prop('checked', true);    
            } else {    
                $(".sub_chk").prop('checked',false);    
            }    

        });  

    })
    $(document).on("click", ".open-DeleteCities", function () {
        var myCityId = $(this).data('id');
        $(".modal-body #cityId").val( myCityId );
    });
    </script>
 @endsection
