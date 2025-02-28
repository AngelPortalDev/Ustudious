@extends('layouts.main')
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
                    $sub_title = "Site Setting";
                    $page_title = "Country";?>
                    @include('layouts.page-title')

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header jobseeker-header">
                                    <div class="btn-group mb-2 jobsee-header-tabs">

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal"
                                            data-bs-target="#add-country-modal">
                                            <i class="bi bi-person-plus-fill"></i> Add
                                        </a>

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal"
                                            data-bs-target="#delete-selected-modal">
                                            <i class="ri-delete-bin-fill"></i> Delete
                                        </a>

                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal"
                                            data-bs-target="#approve-modal">
                                            <i class="ri-user-follow-line"></i> Approve
                                        </a>
                                        <a class="btn btn-primary main-button" role="button" data-bs-toggle="modal"
                                            data-bs-target="#reject-modal">
                                            <i class="ri-close-circle-fill"></i> Reject
                                        </a>

                                        <div class="dropdown jobsee-dropdown">
                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                style="color: #03A9F4;"> <i class="ri-file-excel-2-fill"></i> Excel
                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Import</a>
                                                <a class="dropdown-item" href="#">Export</a>
                                            </div>
                                        </div>

                                        <div class="dropdown jobsee-dropdown">
                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                style="color: #03A9F4;"> <i class="ri-filter-2-fill"></i> Filter
                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Approved</a>
                                                <a class="dropdown-item" href="#">Rejected</a>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <!-- <table id="alternative-page-datatable" -->
                                    <table id="" class="table table-striped dt-responsive nowrap w-100 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;" class="check-box-1">
                                                    <div class="form-check "> <input type="checkbox"
                                                            class="form-check-input" id="customCheckcolor1"> </div>
                                                </th>
                                                <th>Sr. No.</th>
                                                <th>Country Name</th>
                                                <th>Country Code</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            <tr>
                                                <td class="check-box-1">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input "
                                                            id="customCheckcolor1">
                                                    </div>
                                                </td>

                                                <td>1</td>
                                                <td>Malta</td>
                                                <td>+356</td>
                                                <td><i class="ri-user-follow-line"></i> <span
                                                        class="badge bg-primary rounded-pill">Approved</span></td>
                                                <td>
                                                    <a href="javascript: void(0);" class="text-reset fs-16 px-1">
                                                        <i class="bi bi-eye-fill" data-bs-toggle="modal"
                                                        data-bs-target="#edit-country-modal"></i></a>
                                                    <a href="javascript: void(0);" class="text-reset fs-16 px-1">
                                                        <i class="mdi mdi-pencil" data-bs-toggle="modal"
                                                        data-bs-target="#edit-country-modal"></i></a>
                                                    <a href="javascript: void(0);" class="text-reset fs-16 px-1">
                                                        <i class="ri-delete-bin-2-line" data-bs-toggle="modal"
                                                            data-bs-target="#delete-single-modal"></i></a>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="check-box-1">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input "
                                                            id="customCheckcolor1">
                                                    </div>
                                                </td>

                                                <td>2</td>
                                                <td>France</td>
                                                <td>+56</td>
                                                <td><i class="ri-user-follow-line"></i> <span
                                                        class="badge bg-primary rounded-pill">Approved</span></td>
                                                <td>
                                                    <a href="javascript: void(0);" class="text-reset fs-16 px-1">
                                                        <i class="bi bi-eye-fill" data-bs-toggle="modal"
                                                        data-bs-target="#edit-country-modal"></i></a>
                                                    <a href="javascript: void(0);" class="text-reset fs-16 px-1">
                                                        <i class="mdi mdi-pencil" data-bs-toggle="modal"
                                                        data-bs-target="#edit-country-modal"></i></a>
                                                    <a href="javascript: void(0);" class="text-reset fs-16 px-1">
                                                        <i class="ri-delete-bin-2-line" data-bs-toggle="modal"
                                                            data-bs-target="#delete-single-modal"></i></a>
                                                </td>

                                            </tr>


                                        </tbody>
                                    </table>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->

                    <!-- add-country-modal content -->
                    <div id="add-country-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title" id="topModalLabel">Add Country</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">

                                    <form class="ps-3 pe-3" action="#">

                                        <div class="mb-3">
                                            <label for="companyname" class="form-label">Country Name</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Country Code</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Nationality</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Currency Name</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>


                                        <div class="mb-3">
                                            <label for="username" class="form-label">Currency Symbol</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>


                                        <div class="mb-3">
                                            <label for="username" class="form-label">Currency Abbreviation</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio3" name="customRadio1"
                                                    class="form-check-input">
                                                <label class="form-check-label" for="customRadio3">Approved</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio4" name="customRadio1"
                                                    class="form-check-input">
                                                <label class="form-check-label" for="customRadio4">Rejected</label>
                                            </div>
                                        </div>





                                    </form>

                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-primary">Add</button>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                </div>

                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                    <!-- edit-country-modal content -->
                    <div id="edit-country-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title" id="topModalLabel">Edit Country</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">

                                    <form class="ps-3 pe-3" action="#">

                                        <div class="mb-3">
                                            <label for="companyname" class="form-label">Country Name</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Country Code</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Nationality</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Currency Name</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>


                                        <div class="mb-3">
                                            <label for="username" class="form-label">Currency Symbol</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>


                                        <div class="mb-3">
                                            <label for="username" class="form-label">Currency Abbreviation</label>
                                            <input class="form-control" type="text" id="username" required=""
                                                placeholder="">
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio3" name="customRadio1"
                                                    class="form-check-input">
                                                <label class="form-check-label" for="customRadio3">Approved</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="customRadio4" name="customRadio1"
                                                    class="form-check-input">
                                                <label class="form-check-label" for="customRadio4">Rejected</label>
                                            </div>
                                        </div>





                                    </form>

                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                </div>

                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                    <!-- Delete manually Modal  -->
                    <div id="delete-selected-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-2">
                                    <div style="float: right;">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="text-center">
                                        <i class="ri-information-line h1 text-info"></i>
                                        <h5 class="mt-2">Delete records?</h5>
                                        <p class="mt-3">Cras mattis consectetur purus sit amet fermentum. Cras justo
                                            odio, dapibus ac facilisis in, egestas eget quam.</p>
                                        <button type="button" class="btn btn-info my-2"
                                            data-bs-dismiss="modal">Delete</button>
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- Delete Single Modal  -->
                    <div id="delete-single-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-2">
                                    <div style="float: right;">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="text-center">
                                        <i class="ri-information-line h1 text-info"></i>
                                        <h4 class="mt-2">Delete record?</h4>
                                        <p class="mt-3">Cras mattis consectetur purus sit amet fermentum. Cras justo
                                            odio, dapibus ac facilisis in, egestas eget quam.</p>
                                        <button type="button" class="btn btn-info my-2"
                                            data-bs-dismiss="modal">Delete</button>
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->



                    <!-- Approve Modal  -->
                    <div id="approve-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-2">
                                    <div style="float: right;">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="text-center">
                                        <i class="ri-information-line h1 text-info"></i>
                                        <h4 class="mt-2">Approve records?</h4>
                                        <p class="mt-3">Cras mattis consectetur purus sit amet fermentum. Cras justo
                                            odio, dapibus ac facilisis in, egestas eget quam.</p>
                                        <button type="button" class="btn btn-info my-2"
                                            data-bs-dismiss="modal">Delete</button>
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                    <!-- Reject Modal  -->
                    <div id="reject-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body p-2">
                                    <div style="float: right;">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="text-center">
                                        <i class="ri-information-line h1 text-info"></i>
                                        <h4 class="mt-2">Reject records?</h4>
                                        <p class="mt-3">Cras mattis consectetur purus sit amet fermentum. Cras justo
                                            odio, dapibus ac facilisis in, egestas eget quam.</p>
                                        <button type="button" class="btn btn-info my-2"
                                            data-bs-dismiss="modal">Delete</button>
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>
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


</body>

</html>