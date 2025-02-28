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
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="profile-bg-picture"
                                style="background-image:url('{{asset('img/bg-profile.jpg')}}')">
                                <span class="picture-bg-overlay"></span>
                                <!-- overlay -->
                            </div>
                            <!-- meta -->
                            <div class="profile-user-box">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="profile-user-img"><img src="{{asset('img/users/avatar-1.jpg')}}" alt=""
                                                class="avatar-lg rounded-circle"></div>
                                        <div class="">
                                            <h4 class="mt-4 fs-17 ellipsis">{{$user->name}}</h4>
                                            <p class="font-13">{{$user->user_type}}</p>
                                            <p class="text-muted mb-0"><small>{{$user->address}}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ meta -->
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card p-0">
                                <div class="card-body p-0">
                                    <div class="profile-content">
                                        <ul class="nav nav-underline nav-justified gap-0">
                                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                                    data-bs-target="#aboutme" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true" href="#aboutme">About</a>
                                            </li>

                                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#edit-profile" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#edit-profile">Edit Info</a></li>

                                        </ul>

                                        <div class="tab-content m-0 p-4">
                                            <div class="tab-pane active" id="aboutme" role="tabpanel"
                                                aria-labelledby="home-tab" tabindex="0">
                                                <div class="profile-desk">


                                                    <h5 class="mt-4 fs-17 text-dark">Basic Information</h5>
                                                    <table class="table table-condensed mb-0 border-top">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Name</th>
                                                                <td>
                                                                    
                                                                {{$user->name}}
                                                                    
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                <td>
                                                                {{$user->email}}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Phone</th>
                                                                <td class="ng-binding">{{$user->phone}}</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th scope="row">User Type</th>
                                                                <td class="ng-binding">{{$user->user_type}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Address</th>
                                                                <td class="ng-binding">{{$user->address}}</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div> <!-- end profile-desk -->
                                            </div> <!-- about-me -->


                                            <!-- settings -->
                                            <div id="edit-profile" class="tab-pane">
                                                <div class="user-profile-content">
                                                    <form class="ps-3 pe-3" action="#" enctype="multipart/form-data" id="editUserForm">
                                                        @csrf   
                                                        <div class="row row-cols-sm-2 row-cols-1">
                                                            <input type="hidden" value="{{$user->id}}" id="userid" class="form-control" name="userid" >
                                                            <div class="mb-2">
                                                                <label class="form-label" for="name"> Name</label>
                                                                <input type="text" value="{{$user->name}}" id="name" name="name" required  class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="Email">Email</label>
                                                                <input type="email" value=" {{$user->email}}" id="email" class="form-control" name="email" required >
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="phone">Phone</label>
                                                                <input type="number" value="{{$user->phone}}" class="form-control" name="phone" id="phone" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="designation">User Type</label>
                                                                <input type="text" value="{{$user->user_type}}" class="form-control" name="user_type" id="user_type">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="address">Address</label>
                                                                <input type="text" value="{{$user->address}}" class="form-control" name="address" id="address" required>
                                                            </div>
                                                        </div>
                                                        <input class="btn btn-primary" type="submit" id="editUserSubmit" value="Save">
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                </div>
                <!-- end row -->

            </div>
            <!-- container -->

        </div>
        <!-- content -->


    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/common.js')}}"></script>

@endsection
