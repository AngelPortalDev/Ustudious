@extends('admin.layouts.main')
@section('content')

<div class="wrapper">
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <?php
                    $sub_title = "Dashboards";
                    $page_title = "Welcome!";
                ?>
                @include('admin.layouts.page-title')
        
                <div class="row">
                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-pink">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="ri-user-line widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Customers">Registered Student</h6>
                                <h2 class="my-2">1000</h2>
                                <p class="mb-0">
                                    <!-- <span class="badge bg-white bg-opacity-10 me-1">2.97%</span> -->
                
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-purple">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class=" ri-user-2-fill widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Customers">Registered Employers</h6>
                                <h2 class="my-2">500</h2>
                                <p class="mb-0">
                                    <!-- <span class="badge bg-white bg-opacity-10 me-1">18.25%</span> -->
                                    
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-info">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class="ri-list-check widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Customers">Jobs Listing</h6>
                                <h2 class="my-2">753</h2>
                                <p class="mb-0">
                                    <!-- <span class="badge bg-white bg-opacity-25 me-1">-5.75%</span> -->
                            
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card widget-flat text-bg-primary">
                            <div class="card-body">
                                <div class="float-end">
                                    <i class=" ri-thumb-up-line widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Customers">Total Jobs Applied</h6>
                                <h2 class="my-2">63,154</h2>
                                <p class="mb-0">
                                    <!-- <span class="badge bg-white bg-opacity-10 me-1">8.21%</span> -->
                                    
                                </p>
                            </div>
                        </div>
                    </div> <!-- end col-->
                </div>


                <div class="row">
                

                    <div class="col-xl-12 jobseeker-view-page">
                        <!-- Todo-->
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="p-3">
                                    <div class="card-widgets">
                                        <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                                        <a data-bs-toggle="collapse" href="#yearly-sales-collapse" role="button" aria-expanded="false" aria-controls="yearly-sales-collapse"><i class="ri-subtract-line"></i></a>
                                        <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                                    </div>
                                    <h5 class="header-title mb-0">LATEST JOBSEEKER</h5>
                                </div>

                                <div id="yearly-sales-collapse" class="collapse show">

                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 40px;">#</th>
                                                    <th>Photo</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Industry</th>
                                                    <th>Registered On</th>
                                                    <th>Plan</th>
                                                    <th>Status</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="jobseeker-profile-photo">
                                                        <img src="{{asset('img/users/avatar-1.jpg')}}" alt="" width="20%"></td>
                                                    <td>Haresh Gurav</td>
                                                    <td>jobseeker@gmail.com</td>
                                                    <td>1234567890</td>                                            
                                                    <td>Select All</td>                                            
                                                    <td>14 February, 2024 05:59 PM</td>                                            
                                                    <td>Active</td>
                                                    <td><i class="ri-user-follow-line"></i> <span class="badge bg-primary rounded-pill">Approved</span></td>

                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td class="jobseeker-profile-photo">
                                                        <img src="{{asset('img/users/avatar-5.jpg')}}" alt=""  width="20%"></td>
                                                    <td>Haresh Gurav</td>
                                                    <td>jobseeker@gmail.com</td>
                                                    <td>1234567890</td>                                            
                                                    <td>Select All</td>                                            
                                                    <td>14 February, 2024 05:59 PM</td>                                            
                                                    <td>Active</td>
                                                    <td><i class="ri-user-follow-line"></i> <span class="badge bg-danger rounded-pill">Rejected</span></td>

                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td class="jobseeker-profile-photo">
                                                        <img src="{{asset('img/users/avatar-4.jpg')}}" alt=""></td>
                                                    <td>Haresh Gurav</td>
                                                    <td>jobseeker@gmail.com</td>
                                                    <td>1234567890</td>                                            
                                                    <td>Select All</td>                                            
                                                    <td>14 February, 2024 05:59 PM</td>                                            
                                                    <td>Active</td>
                                                    <td><i class="ri-user-follow-line"></i> <span class="badge bg-primary rounded-pill">Approved</span></td>

                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td class="jobseeker-profile-photo">
                                                        <img src="{{asset('img/users/avatar-3.jpg')}}" alt=""></td>
                                                    <td>Haresh Gurav</td>
                                                    <td>jobseeker@gmail.com</td>
                                                    <td>1234567890</td>                                            
                                                    <td>Select All</td>                                            
                                                    <td>14 February, 2024 05:59 PM</td>                                            
                                                    <td>Active</td>
                                                    <td><i class="ri-user-follow-line"></i> <span class="badge bg-primary rounded-pill">Approved</span></td>

                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td class="jobseeker-profile-photo">
                                                        <img src="{{asset('img/users/avatar-2.jpg')}}" alt=""></td>
                                                    <td>Haresh Gurav</td>
                                                    <td>jobseeker@gmail.com</td>
                                                    <td>1234567890</td>                                            
                                                    <td>Select All</td>                                            
                                                    <td>14 February, 2024 05:59 PM</td>                                            
                                                    <td><i class="ri-shield-star-fill"></i> Active</td>
                                                    <td><i class="ri-user-follow-line"></i> <span class="badge bg-danger rounded-pill">Rejected</span></td>

                                                </tr>
                                                
                                            

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Todo-->
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="p-3">
                                    <div class="card-widgets">
                                        <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                                        <a data-bs-toggle="collapse" href="#yearly-sales-collapse" role="button" aria-expanded="false" aria-controls="yearly-sales-collapse"><i class="ri-subtract-line"></i></a>
                                        <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                                    </div>
                                    <h5 class="header-title mb-0">LATEST EMPLOYER</h5>
                                </div>

                                <div id="yearly-sales-collapse" class="collapse show">

                                    <div class="table-responsive jobseeker-view-page">
                                        <table class="table table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Photo</th>
                                                    <th>Name</th>
                                                    <th>Company Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Registered On</th>
                                                    <th>Plan</th>
                                                    <th>Status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="jobseeker-profile-photo">
                                                        <img src="{{asset('img/angel-jobs-malta-logo.png')}}" alt=""  width="10%"></td>
                                                    <td>Sumit Khanna</td>
                                                    <td>Angel Jobs Malta</td>                                            
                                                    <td>sumitkhanna@gmail.com</td>
                                                    <td>85845847584</td>
                                                    <td>27 October, 2023 12:31 PM</td>
                                                    <td>Active</td>
                                                    <td><i class="ri-user-follow-line"></i> <span class="badge bg-primary rounded-pill">Approved</span></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td class="jobseeker-profile-photo">
                                                        <img src="{{asset('img/angel-jobs-malta-logo.png')}}" alt=""  width="10%"></td>
                                                    <td>Sumit Khanna</td>
                                                    <td>Angel Jobs Malta</td>                                            
                                                    <td>sumitkhanna@gmail.com</td>
                                                    <td>85845847584</td>
                                                    <td>27 October, 2023 12:31 PM</td>
                                                    <td>Active</td>
                                                    <td><i class="ri-user-follow-line"></i> <span class="badge bg-primary rounded-pill">Approved</span></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td class="jobseeker-profile-photo">
                                                        <img src="{{asset('img/angel-jobs-malta-logo.png')}}" alt=""  width="10%"></td>
                                                    <td>Sumit Khanna</td>
                                                    <td>Angel Jobs Malta</td>                                            
                                                    <td>sumitkhanna@gmail.com</td>
                                                    <td>85845847584</td>
                                                    <td>27 October, 2023 12:31 PM</td>
                                                    <td>Active</td>
                                                    <td><i class="ri-user-follow-line"></i> <span class="badge bg-danger rounded-pill">Rejected</span></td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td class="jobseeker-profile-photo">
                                                        <img src="{{asset('img/angel-jobs-malta-logo.png')}}" alt=""  width="10%"></td>
                                                    <td>Sumit Khanna</td>
                                                    <td>Angel Jobs Malta</td>                                            
                                                    <td>sumitkhanna@gmail.com</td>
                                                    <td>85845847584</td>
                                                    <td>27 October, 2023 12:31 PM</td>
                                                    <td>Active</td>
                                                    <td><i class="ri-user-follow-line"></i> <span class="badge bg-primary rounded-pill">Approved</span></td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td class="jobseeker-profile-photo">
                                                        <img src="{{asset('img/angel-jobs-malta-logo.png')}}" alt=""  width="10%"></td>
                                                    <td>Sumit Khanna</td>
                                                    <td>Angel Jobs Malta</td>                                            
                                                    <td>sumitkhanna@gmail.com</td>
                                                    <td>85845847584</td>
                                                    <td>27 October, 2023 12:31 PM</td>
                                                    <td>Active</td>
                                                    <td><i class="ri-user-follow-line"></i> <span class="badge bg-danger rounded-pill">Rejected</span></td>
                                                </tr>
                                                

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
            </div>
            <!-- container -->

        </div>
    </div>
</div>
@endsection