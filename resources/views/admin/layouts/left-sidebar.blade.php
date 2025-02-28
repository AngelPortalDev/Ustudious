<!-- ========== Left Sidebar Start ========== -->
<?php
    $ASSET_PATH = env('ASSET_URL').'/'
?>
<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="index.php" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{$ASSET_PATH}}img/ustudious-logo.png" width="80%" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{$ASSET_PATH}}img/ustudious-logo.png" width="80%" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="index.php" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{$ASSET_PATH}}img/ustudious-logo.png" width="80%" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{$ASSET_PATH}}img/ustudious-logo.png"width="80%" alt="small logo">
        </span>
    </a>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Main</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                    <i class="ri-dashboard-3-line"></i>
  
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPagesAuth" aria-expanded="false" aria-controls="sidebarPagesAuth" class="side-nav-link">
                    <i class="ri-group-2-line"></i>
                    <span>  Masters </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPagesAuth">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('country') }}">Country</a>
                        </li>
                        <li>
                            <a href="{{ route('states') }}">State</a>
                        </li>
                        <li>
                            <a href="{{ route('cities') }}">Cities</a>
                        </li>
                        <li>
                            <a href="{{ route('language') }}">Language</a>
                        </li>
                        <li>
                            <a href="{{ route('duration') }}">Duration</a>
                        </li>
                        <li>
                            <a href="{{ route('intakemonth') }}">Intake Month</a>
                        </li>
                        <li>
                            <a href="{{ route('intakeyear') }}">Intake Year</a>
                        </li>
                        <li>
                            <a href="{{ route('qualification') }}">Qualification</a>
                        </li>
                        <li>
                            <a href="{{ route('qualificationtypes') }}">Qualification Types</a>
                        </li>
                  
                    </ul>
                </div>
            </li>



            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarExtendedUIS" aria-expanded="false" aria-controls="sidebarExtendedUIS" class="side-nav-link">
                    <i class="ri-briefcase-line"></i>
                    <span> Student</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarExtendedUIS">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('student') }}">All Student</a>
                        </li>
                        
                        
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarExtendedUI" aria-expanded="false" aria-controls="sidebarExtendedUI" class="side-nav-link">
                    <i class="ri-compasses-2-line"></i>
                    <span>  University </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarExtendedUI">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('institute') }}" >All Institute</a>
                        </li>
                        <li>
                            <a href="{{ route('course') }}" >All Course</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->