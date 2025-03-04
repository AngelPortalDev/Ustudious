<?php $ASSET_PATH = env('ASSET_URL') . '/'; ?>

<!DOCTYPE html>

<html lang="en">

<head>

    <link rel="icon" type="image/x-icon" href="" sizes="16x16">

    <meta charset="utf-8" />

    <meta name="author" content="www.angel-portal.com" />

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <meta name="csrf-token" content="{{ csrf_token() }}">



    <link rel="icon" type="image/x-icon" href="{{ $ASSET_PATH }}img/ustudious-favicon.png" sizes="16x16">



    <title>Ustudious - Educational Portal</title>



    <!-- Custom Color Option -->

    <link href="{{ $ASSET_PATH }}css/colors.css" rel="stylesheet">

    <link href="{{ $ASSET_PATH }}css/colors.css" rel="stylesheet">


    <link href="{{ $ASSET_PATH }}css/plugins/font-awesome.css" rel="stylesheet">


    <link rel="stylesheet" href="{{ $ASSET_PATH }}css/fonts/fa-solid-900.woff2">

    <link rel="stylesheet" href="{{ $ASSET_PATH }}css/fonts/themify.woff">


    <link rel="stylesheet" href="{{ $ASSET_PATH }}css/fonts/fa-solid-900.woff">

    <link href="{{ $ASSET_PATH }}css/plugins/themify.css" rel="stylesheet">
    <link href="{{ $ASSET_PATH }}css/plugins/morris.css" rel="stylesheet">
    <link href="{{ $ASSET_PATH }}css/plugins/line-icons.css" rel="stylesheet">
    <link href="{{ $ASSET_PATH }}css/plugins/iconfont.css" rel="stylesheet">
    <link href="{{ $ASSET_PATH }}css/plugins/font-awesome.css" rel="stylesheet">
    <link href="{{ $ASSET_PATH }}css/plugins/flaticon.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>


    <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>


    <!-- Custom CSS -->

    <link href="{{ $ASSET_PATH }}css/styles.css" rel="stylesheet">


    <style>
        .field-icon {
            position: absolute;
            z-index: 1;
            right: 18px;
            bottom: 18px;
        }
        .bi-twitter-x::before {
            content: "𝕏";
            font-size: 1.2em;
            font-family: sans-serif;
            font-style: normal;
            }
        .dots-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
            position: fixed;
            z-index: 99999;
            background-color: rgba(0, 0, 0, 0.2);
        }


        .dot {
            height: 20px;
            width: 20px;
            margin-right: 10px;
            border-radius: 10px;
            background-color: #9e1f63;
            animation: pulse 1.5s infinite ease-in-out;
        }

        .dot:last-child {
            margin-right: 0;
        }

        .dot:nth-child(1) {
            animation-delay: -0.3s;
        }

        .dot:nth-child(2) {
            animation-delay: -0.1s;
        }

        .dot:nth-child(3) {
            animation-delay: 0.1s;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.8);
                background-color: #9e1f63;
                box-shadow: 0 0 0 0 rgba(178, 212, 252, 0.7);
            }

            50% {
                transform: scale(1.2);
                background-color: #9e1f63;
                box-shadow: 0 0 0 10px rgba(178, 212, 252, 0);
            }

            100% {
                transform: scale(0.8);
                background-color: #9e1f63;
                box-shadow: 0 0 0 0 rgba(178, 212, 252, 0.7);
            }
        }
    </style>


</head>



<body class="red-skin">



    <!-- ============================================================== -->

    <!-- Preloader - style you can find in spinners.css -->

    <!-- ============================================================== -->
	<section class="bglaoder p-0">
		<div class="dots-container" id="loader" style="display: none;">
		  <div class="dot"></div>
		  <div class="dot"></div>
		  <div class="dot"></div>
		  <div class="dot"></div>
		  <div class="dot"></div>
		</section>
        <div id="preloader">
            <div class="preloader"><span></span><span></span></div>
        </div>





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

                            <a class="nav-brand" href="{{ url('/') }}">

                                <img src="{{ $ASSET_PATH }}img/ustudious-logo.png" class="logo" alt="" />

                            </a>

                            <div class="nav-toggle"></div>

                        </div>

                        <div class="nav-menus-wrapper" style="transition-property: none;">

                            <ul class="nav-menu">



                                {{-- <li ><a href="{{url('/')}}">Home</a> --}}

                                {{-- 

								</li> --}}



                                <li><a href="{{ route('browse-course') }}">Browse Courses </a> </li>

                                {{-- <li><a href="{{route('browse-student')}}">Browse Student </a> </li> --}}


                                @php $LoginID = Session::get('institute_id'); @endphp
                                @if ($LoginID)
                                    <li><a href="{{ route('institute-post-course', ['add', $LoginID]) }}">Post Course
                                        </a> </li>
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







                                <li><a href="{{ route('about') }}">About</a></li>

                                <li><a href="{{ route('contact') }}">Contact</a></li>



                            </ul>



                            <ul class="nav-menu nav-menu-social align-to-right">



                                <li class="login_click light">

                                    <a href="#" data-toggle="modal" data-target="#studentlogin">Login</a>

                                </li>

                                <li class="login_click theme-bg">

                                    <a href="#" data-toggle="modal" data-target="#studentsignup">Register</a>

                                </li>





                                <li class="login_click theme-bg institute-header-btn">

                                    <a href="{{ route('institute-login') }}">Institute</a>

                                </li>

                            </ul>

                        </div>

                    </nav>

                </div>

            </div>

            <!-- End Navigation -->
