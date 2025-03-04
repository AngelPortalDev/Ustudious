@extends('admin.layouts.main')

@section('css')
    <style>
        .error {

            color: red;

        }

        .title {

            font-size: 25px;

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
                    
                    $sub_title = 'Tables';
                    
                    $page_title = 'All Courses';
                    
                    ?>

                    @include('admin.layouts.page-title')



                    <div class="row">

                        <div class="col-12">

                            <div class="card card-primary card-outline">

                                <div class="card-header jobseeker-header">



                                    <div class="btn-group mb-2 jobsee-header-tabs">

                                        <a class="btn btn-primary main-button" role="button"
                                            href="{{ route('course.create') }}"><i class="ri-user-add-fill"></i> Add</a>
                                        <a class="btn btn-primary main-button" role="button"
                                            href="{{ route('create-new') }}"><i class="ri-user-add-fill"></i> Add-new</a>




                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal"
                                            data-bs-target="#delete-course-modal"><i class="ri-delete-bin-fill"></i> Delete

                                        </a>&nbsp;

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal"
                                            data-bs-target="#approve-course-modal"><i class="ri-user-follow-line"></i>
                                            Approve

                                        </a>&nbsp;

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal"
                                            data-bs-target="#reject-course-modal"><i class="ri-close-circle-fill"></i>
                                            Reject

                                        </a>&nbsp;

                                        <div class="dropdown jobsee-dropdown">

                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                style="color: #03A9F4;"> <i class="ri-file-excel-2-fill"></i> Excel

                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                <a class="dropdown-item" role="button" data-bs-toggle="modal"
                                                    data-bs-target="#import-course-modal">Import</a>

                                                <a class="dropdown-item" href="{{ route('course.export') }}">Export</a>

                                            </div>

                                        </div>
                                        <!--<div class="dropdown jobsee-dropdown" id="search-dropdown">

                                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButtonfilter"

                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"

                                                        style="color: #03A9F4;"> <i class="ri-filter-2-fill"></i> Filter

                                                    </button>

                                                    

                                                </div> -->

                                    </div>



                                </div>





                                <div class="card-body table-responsive">



                                    <div class="dropdown-menu" id="searchbox">

                                        {{-- <div class="card-body">



                                            <div class="col-sm-12">

                                                <form action="#" enctype="multipart/form-data"  href="{{ route('course.search') }}">

                                            

                                                    <label for="fullname" class="form-label">Institute</label>

                                                    <select class="form-select  mb-2 select2" name="institute_id" id="institute_id">

                                                        <option value="">Select Institute</option>

                                                        @foreach ($instituteData as $data)

                                                            <option value="{{ $data->institute_id }}">{{ $data->full_name }}</option>

                                                        @endforeach

                                                    </select>  



                                                <button type="button" class="btn btn-success">Submit</button>

                                                </form>

                                            </div>

                                        </div> --}}

                                    </div>


                                    <div class="col-sm-12" id="course_tables">

                                        {{-- <input type="text" class="form-control col-md-4 float-left" name="searchInstitute" id="searchInstitute" placeholder="Search..."> --}}

                                        <!-- <table id="course_table" -->

                                        <table id="course_table"
                                            class="table table-striped table-responsive nowrap w-100 text-nowrap">

                                            <thead>

                                                <tr>

                                                    <th id="checkboxsorting"><input type="checkbox" class=""
                                                            id="CheckCourse"></th>

                                                    <th>ID</th>

                                                    <th>Course Name</th>

                                                    <th>Subheading</th>

                                                    <th>Program Type</th>

                                                    <th>Mode Of Study</th>

                                                    <th>Course Category</th>

                                                    <th>Status</th>

                                                    <th>Action</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                @if (count($courses) > 0)
                                                    @php $i=1; 
                                                    
                                                    @endphp

                                                    @foreach ($courses as $data)
                                                    @php
                                                        $data->id = $data->CourseID
                                                    @endphp
                                                        <tr>

                                                            <td><input type="checkbox" class="sub_chk"
                                                                    data-id="{{ base64_encode($data->id) }}"></td>

                                                            <td>{{ $loop->iteration }}</td>

                                                            <td>{{ $data->CourseName }}</td>

                                                            <td>{{ $data->subheading }}</td>

                                                            <td>{{ $data->programType->course_types }}</td>

                                                            <td>{{ ucwords(str_replace('_', ' ',$data->mode_of_study)) }}</td>

                                                            <td>{{ $data->coursecategory->course_category }}</td>

                                                            <td><i class="ri-user-follow-line"></i><span
                                                                    class="badge bg-primary rounded-pill"></i>{{ $data->ApprovalStatus }}</span>
                                                            </td>

                                                            <td>

                                                                <a href="{{ route('course.show', base64_encode($data->id)) }}"
                                                                    class="text-reset fs-16 px-1"> <i
                                                                        class="ri-eye-fill"></i></a>

                                                                <a href="{{ route('course.edit', base64_encode($data->id)) }}"
                                                                    class="text-reset fs-16 px-1"> <i
                                                                        class="ri-edit-2-line"></i></a>

                                                                <a href="#"
                                                                    class="text-reset fs-16 px-1 open-DeleteCourse"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#delete-course-modal"
                                                                    data-id="{{ base64_encode($data->id) }}"> <i
                                                                        class="ri-delete-bin-2-line"></i></a>

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

                                            {{-- {!! $courses->links() !!} --}}

                                        </div>

                                    </div>

                                </div> <!-- end card body-->

                            </div> <!-- end card -->

                        </div><!-- end col-->

                    </div> <!-- end row-->







                    <!-- Delete manually Modal  -->

                    <div id="delete-course-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

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

                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"
                                            id="DeleteCourse">Delete</button>

                                        <input type="hidden" name="courseId" id="courseId" value="" />

                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>

                                    </div>

                                </div>

                            </div><!-- /.modal-content -->

                        </div><!-- /.modal-dialog -->

                    </div><!-- /.modal -->





                    <!-- Approve Modal  -->

                    <div id="approve-course-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

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

                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"
                                            id="ApprovedCourse">Approved</button>

                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>

                                    </div>

                                </div>

                            </div><!-- /.modal-content -->

                        </div><!-- /.modal-dialog -->

                    </div><!-- /.modal -->





                    <!-- Reject Modal  -->

                    <div id="reject-course-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

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

                                        <button type="button" class="btn btn-info my-2" data-bs-dismiss="modal"
                                            id="RejectCourse">Rejected</button>

                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>

                                    </div>

                                </div>

                            </div><!-- /.modal-content -->

                        </div><!-- /.modal-dialog -->

                    </div><!-- /.modal -->





                    <!-- Import Modal  -->

                    <div id="import-course-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">

                        <div class="modal-dialog modal-md">

                            <div class="modal-content">

                                <div class="modal-body p-2">

                                    <div style="float: right;">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>

                                    </div>

                                    <div class="text-center">

                                        <h2 class="mb-4">Import File </h2>

                                        <form class="ps-3 pe-3" action="#" id="importCourse">

                                            @csrf

                                            <div class="mb-3">

                                                <label for="city_code" class="form-label">Choose File</label>

                                                <input type="file" name="customfile" class="form-control"
                                                    id="customfile">

                                            </div>

                                            <input type="submit" class="btn btn-primary" id="ImportCourses"
                                                value="Import">

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

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>

                                </div>

                                <div class="modal-body">

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
    <script type="text/javascript" src="{{ asset('js/common.js') }}"></script>

    <script>
        $(document).ready(function() {

            var table = $('#course_table').DataTable({

                'columnDefs': [{

                    'targets': [0, 7],

                    'searchable': false,

                    'orderable': false,

                }],

            });

            $("#checkboxsorting").removeClass("sorting_asc");



            $('.dataTables_length').after('<br>');



        });



        $(function(e) {

            $('#CheckCourse').on('click', function(e) {

                if ($(this).is(':checked', true))

                {

                    $(".sub_chk").prop('checked', true);

                } else {

                    $(".sub_chk").prop('checked', false);

                }



            });



        })



        $(document).on("click", ".open-DeleteCourse", function() {



            var myCourseId = $(this).data('id');

            $(".modal-body #courseId").val(myCourseId);

        });



        $("#search-dropdown").on('click', function(e) {

            $("#searchbox").css('display', 'block');

            $("#course_tables").css('margin-top', "65px");

        });
    </script>
@endsection
