<?php $ASSET_PATH = env('ASSET_URL').'/' ?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <link rel="icon" type="image/x-icon" href="" sizes="16x16">
		<meta charset="utf-8" />
		<meta name="author" content="www.angel-portal.com" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/x-icon" href="{{$ASSET_PATH}}img/ustudious-favicon.png" sizes="16x16">
		
        <title>Ustudious - Educational Portal</title>
		 		
		<!-- Custom Color Option -->
		<link href="{{$ASSET_PATH}}css/colors.css" rel="stylesheet">
        
        <!-- Custom CSS -->
        <link href="{{$ASSET_PATH}}css/styles.css" rel="stylesheet">

		<script type="text/javascript" src="{{ asset('js/sweetalert.min.js')}}"></script>


		<style>
			.field-icon {
                /* float: right; */
                /* margin-right: 20px; */
                position: absolute;
                z-index: 1;
                right: 18px;
                bottom: 18px;
			}

			/* .container{
			padding-top:50px;
			margin: auto;
			} */
		</style>
    </head>
	<?php $LoginID = Session::get('institute_id'); ?>

    <body class="red-skin">
	
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div id="preloader"><div class="preloader"><span></span><span></span></div></div>
		
		
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
		
            <!-- ============================================================== -->
            <!-- Top header  -->
            <!-- ============================================================== -->
            <!-- Start Navigation -->
			<div class="header header-light">
				<div class="container">
					<nav id="navigation" class="navigation navigation-landscape">
						<div class="nav-header">
							<a class="nav-brand" href="{{url('/')}}">
								<img src="{{$ASSET_PATH}}img/ustudious-logo.png" class="logo" alt="" />
							</a>
							<div class="nav-toggle"></div>
						</div>
						<div class="nav-menus-wrapper" style="transition-property: none;">

                            {{-- <ul class="nav-menu">
                                <li><a href="{{route('institute-post-course',['add',$LoginID])}}">Post Courses </a> </li>

                            </ul>	 --}}
                            <ul class="nav-menu nav-menu-social align-to-right">
								<li><a href="{{route('browse-student')}}">Browse Student </a> </li>


								<li><a href="{{route('institute-post-course',[base64_encode($LoginID)])}}">Post Courses </a> </li>
                                <li><a href="#">Profile<span class="submenu-indicator"></span></a>
									<ul class="nav-dropdown nav-submenu  align-to-right" >
										
										<li><a href="{{route('institute-profile')}}">My Profile </a></li></li>
										<li><a href="{{route('institutelogout')}}">Logout</a></li>
									</ul>
								</li>
							</ul>
							{{-- <ul class="nav-menu">
							
								<li ><a href="{{url('/')}}">Home</a>

								</li>
								
								<li><a href="{{route('browse-course')}}">Browse Courses </a> </li>
								@php $LoginID = Session::get('institute_id'); @endphp
								@if($LoginID)
								<li><a href="{{route('institute-post-course',[$LoginID])}}">Post Course </a> </li>
								@endif
								<!-- <li><a href="#">Courses -->
									<!-- <span class="submenu-indicator"></span> -->
								<!-- </a> -->
									<!-- <ul class="nav-dropdown nav-submenu">
										<li><a href="#">Courses Grid Sidebar<span class="submenu-indicator"></span></a>
											<ul class="nav-dropdown nav-submenu">
												<li><a href="grid-with-sidebar.html">Courses grid 1</a></li>
												<li><a href="grid-with-sidebar-2.html">Courses grid 1</a></li>
												<li><a href="grid-with-sidebar-3.html">Courses grid 1</a></li>
											</ul>
										</li>

										<li><a href="find-instructor.html">Find Instructor</a></li>
										<li><a href="instructor-detail.html">Instructor Detail</a></li>
									</ul> -->
								<!-- </li> -->
								

								
								<li><a href="{{route('about')}}">About</a></li>
								<li><a href="{{route('contact')}}">Contact</a></li>
								
							</ul> --}}
							
							{{-- <ul class="nav-menu nav-menu-social align-to-right">
								
								<li class="login_click light">
									<a href="#" data-toggle="modal" data-target="#login">Login</a>
								</li>
								<li class="login_click theme-bg">
									<a href="#" data-toggle="modal" data-target="#signup">Register</a>
								</li>


								<li class="login_click theme-bg institute-header-btn">
									<a href="{{route('institute-login')}}">Institute</a>
								</li>
							</ul> --}}
						</div>
					</nav>
				</div>
			</div>
			<!-- End Navigation -->

