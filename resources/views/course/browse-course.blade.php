@extends('layouts.main')
@section('content')
<!-- ============================ Find Courses with Sidebar ================================== -->
<section class="pt-5 browse-courses-page-main">
    <div class="container">

        <!-- Onclick Sidebar -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div id="filter-sidebar" class="filter-sidebar hide-23-23">
                    <div class="filt-head">
                        <h4 class="filt-first">Advance Options</h4>
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">Close <i
                                class="ti-close"></i></a>
                    </div>
                    <div class="show-hide-sidebar">
                        <form class="left_filters_courses">
                            <div class="page_sidebar ">
        
                                <div class="filter-top-heading">
                                    <h6 class="side_title">
                                        Education Type
                                    </h6>
                                    <div>
                                        <a data-toggle="collapse" data-toggle="collapse" href="#content_education_type1" aria-expanded="false" class="collapse-header">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> - </span>
                                        </a>
                                    </div>
        
                                </div>
                                <div class="collapse show" id="content_education_type1">
                                    <ul class="no-ul-list mb-3">
                                        <li>
                                            <input id="aa-universities" class="checkbox-custom" name="education[]" type="checkbox" value="university" >
                                            <label for="aa-universities" class="checkbox-custom-label">University</label>
                                        </li>
                                        <li>
                                            <input id="aa-schooles" class="checkbox-custom" name="education[]" type="checkbox"  value="school" >
                                            <label for="aa-schooles" class="checkbox-custom-label">Schools/Colleges</label>
                                        </li>
                                        <li>
                                            <input id="aa-institutes" class="checkbox-custom" name="education[]" type="checkbox" value="institute">
                                            <label for="aa-institutes" class="checkbox-custom-label">Institute</label>
                                        </li>
        
                                    </ul>
                                </div>
                                <hr>
                              
                                <div class="filter-top-heading">
                                    <h6 class="side_title">
                                        Mode of Study
                                    </h6>
                                    <div>
                                        <a data-toggle="collapse" data-toggle="collapse" href="#content_modeofstudy1" aria-expanded="false" class="collapse-header">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                        </a>
                                    </div>
        
                                </div>
                                <div class="collapse" id="content_modeofstudy1">
                                    <ul class="no-ul-list mb-3">
                                        <li>
                                            <input id="aa-412" class="checkbox-custom" name="modeofstudy[]"  type="checkbox" value="part_time">
                                            <label for="aa-412" class="checkbox-custom-label">Part Time</label>
                                        </li>
                                        <li>
                                            <input id="aa-22" class="checkbox-custom" name="modeofstudy[]" type="checkbox" value="full_time">
                                            <label for="aa-22" class="checkbox-custom-label">Full Time</label>
                                        </li>
        
                                        <li>
                                            <input id="aa-712" class="checkbox-custom" name="modeofstudy[]"  type="checkbox" value="distance"> 
                                            <label for="aa-712" class="checkbox-custom-label">Distance</label>
                                        </li>
        
                                    </ul>
                                </div>
                                <hr>
        
                            
                                <div class="filter-top-heading">
                                    <h6 class="side_title">
                                        Location
                                    </h6>
                                    <div>
                                        <a data-toggle="collapse" data-toggle="collapse" href="#content_location1" aria-expanded="false" class="collapse-header">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                        </a>
                                    </div>
        
                                </div>
                                <div class="collapse" id="content_location1">
                                    <div class="form-inline addons mb-2 course-filter-search-bar" >
                                        <input class="form-control se-input searchLocation" type="search" placeholder="Search Location"  aria-label="Search">
                                        <button><i class="ti-search"></i></button>
                                    </div>
                                    <ul class="no-ul-list mb-3 locationContainer" >
                                        
                                    <?php $Location =DB::table('country_master')->select('CountryID','CountryName')->distinct()->get()->take(5); ?>
                                        @foreach ($Location as $data)
                                        <li>
                                            <input class="checkbox-custom" name="location[]" id="aa-locations-{{$data->CountryID}}" type="checkbox" value="{{$data->CountryID}}">
                                            <label for="aa-locations-{{$data->CountryID}}" class="checkbox-custom-label" >{{$data->CountryName}}</label>
                                        </li>
                                        @endforeach
                                        
        
                                    </ul>
                                </div>
        
                                <hr>
                              
                                <div class="filter-top-heading">
                                    <h6 class="side_title">
                                        Duration
                                    </h6>
                                    <div>
                                        <a data-toggle="collapse" data-toggle="collapse" href="#content_duration1" aria-expanded="false" class="collapse-header">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                        </a>
                                    </div>
        
                                </div>
                                <div class="collapse" id="content_duration1">
                                    
                                    <div class="form-inline addons mb-2 course-filter-search-bar" >
                                        <input class="form-control se-input searchDuration" type="search" placeholder="Search Duration" aria-label="Search">
                                        <button><i class="ti-search"></i></button>
                                    </div>
                                    <ul class="no-ul-list mb-3 durationContainer">
                                        
                                        <?php  $Duration =DB::table('duration_master')->select('DurationID','Duration')->whereNull('deleted_at')->distinct()->get()->take(5); ?>
                                        @foreach ($Duration as $data)
                                        <li>
                                            <input id="aa-durations-{{$data->DurationID}}" class="checkbox-custom" name="duration[]" type="checkbox" value="{{$data->DurationID}}">
                                            <label for="aa-durations-{{$data->DurationID}}" class="checkbox-custom-label">{{$data->Duration}}</label>
                                        </li>
                                        @endforeach
                                    
        
                                    </ul> 
                                </div>
        
                                <hr>
                                <div class="filter-top-heading">
                                    <h6 class="side_title">
                                        Category
                                    </h6>
                                    <div>
                                        <a data-toggle="collapse" data-toggle="collapse" href="#content_category1" aria-expanded="false" class="collapse-header">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                        </a>
                                    </div>
        
                                </div>
        
                                <div class="collapse" id="content_category1">
                                    
                                    <div class="form-inline addons mb-2 course-filter-search-bar" >
                                        <input class="form-control se-input searchCategory" type="search" placeholder="Search Category" aria-label="Search">
                                        <button><i class="ti-search"></i></button>
                                    </div>
                                    <ul class="no-ul-list mb-3 categoryContainer">
                                        <?php  $CourseCategory =DB::table('course_category')->select('id','course_category')->distinct()->get()->take(5); ?>
                                        @foreach ($CourseCategory as $data)
                                         <?php $checked = ''; if(!empty($_GET['course_category'])){ if($_GET['course_category'] == $data->id){ $checked = "checked";}else{ $checked = '';} }?>
                                        <li>
                                           
                                            
                                            <input id="aa-categories-{{$data->id}}" class="checkbox-custom" name="category[]" type="checkbox"  value="{{$data->id}}" {{$checked}}>
                                            <label for="aa-categories-{{$data->id}}" class="checkbox-custom-label">{{$data->course_category}}</label>
                                        </li>
                                        @endforeach
                                
                                    </ul>
                                </div>
                                <hr>
                            
                                <div class="filter-top-heading">
                                    <h6 class="side_title">
                                        Program Type
                                    </h6>
                                    <div>
                                        <a data-toggle="collapse" data-toggle="collapse" href="#content_programtype1" aria-expanded="false" class="collapse-header">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse" id="content_programtype1">
                                    
                                    <div class="form-inline addons mb-2 course-filter-search-bar" >
                                        <input class="form-control se-input searchProgramtype" type="search" placeholder="Search Program Type" aria-label="Search">
                                        <button><i class="ti-search"></i></button>
                                    </div>
                                    <ul class="no-ul-list mb-3 programtypeContainer" >
                                        <?php  $CourseProgramtype =DB::table('course_types')->select('course_types_id','course_types')->distinct()->get()->take(5); ?>
                                        @foreach ($CourseProgramtype as $data)
                                        <li>
                                            {{-- <input id="aa-programtype-{{$data->course_types_id}}" class="checkbox-custom" name="programtype[]" type="checkbox"  value="{{$data->course_types_id}}"> --}}
                                            <input id="aa-programtypes-{{$data->course_types_id}}" class="checkbox-custom" name="programtype[]" type="checkbox" value="{{$data->course_types_id}}">
        
                                            <label for="aa-programtypes-{{$data->course_types_id}}" class="checkbox-custom-label">{{$data->course_types}}</label>
                                        </li>
                                        @endforeach
                                
                                    </ul>
                                </div>
        
                                <hr>
                                <div class="filter-top-heading">
                                    <h6 class="side_title">
                                       Qualification
                                    </h6>
                                    <div>
                                        <a data-toggle="collapse" data-toggle="collapse" href="#content_qualification1" aria-expanded="false" class="collapse-header">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse" id="content_qualification1">
                                    
                                    <div class="form-inline addons mb-2 course-filter-search-bar" >
                                        <input class="form-control se-input searchQualification" type="search" placeholder="Search Qualification" aria-label="Search">
                                        <button><i class="ti-search"></i></button>
                                    </div>
                                    <ul class="no-ul-list mb-3 qualificationContainer" >
                                        <?php  $CourseQualification =DB::table('qualification_master')->select('QualificationID','Qualification')->distinct()->get()->take(5); ?>
                                        @foreach ($CourseQualification as $data)
                                        <li>
                                            <input id="aa-qualifications-{{$data->QualificationID}}" class="checkbox-custom" name="qualification[]" type="checkbox"  value="{{$data->QualificationID}}">
                                            <label for="aa-qualifications-{{$data->QualificationID}}" class="checkbox-custom-label">{{$data->Qualification}}</label>
                                        </li>
                                        @endforeach
                                
                                    </ul>
                                </div>
        
        
        
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

      
        <!-- Row -->
        <div class="row">

            <div class="col-lg-3 col-md-12 col-sm-12 order-2 order-lg-1 order-md-2" >
                <form class="left_filters_course">
                    <div class="page_sidebar hide-23">

                        <div class="filter-top-heading">
                            <h6 class="side_title">
                                Education Type
                            </h6>
                            <div>
                                <a data-toggle="collapse" data-toggle="collapse" href="#content_education_type" aria-expanded="false" class="collapse-header">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> - </span>
                                </a>
                            </div>

                        </div>
                        <div class="collapse show" id="content_education_type">
                            <ul class="no-ul-list mb-3">
                                <li>
                                    <input id="aa-university" class="checkbox-custom" name="education[]" type="checkbox" value="university" >
                                    <label for="aa-university" class="checkbox-custom-label">University</label>
                                </li>
                                <li>
                                    <input id="aa-school" class="checkbox-custom" name="education[]" type="checkbox"  value="school" >
                                    <label for="aa-school" class="checkbox-custom-label">Schools/Colleges</label>
                                </li>
                                <li>
                                    <input id="aa-institute" class="checkbox-custom" name="education[]" type="checkbox" value="institute">
                                    <label for="aa-institute" class="checkbox-custom-label">Institute</label>
                                </li>

                            </ul>
                        </div>
                        <hr>
                      
                        <div class="filter-top-heading">
                            <h6 class="side_title">
                                Mode of Study
                            </h6>
                            <div>
                                <a data-toggle="collapse" data-toggle="collapse" href="#content_modeofstudy" aria-expanded="false" class="collapse-header">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                </a>
                            </div>

                        </div>
                        <div class="collapse show" id="content_modeofstudy">
                            <ul class="no-ul-list mb-3">
                                <li>
                                    <input id="aa-41" class="checkbox-custom" name="modeofstudy[]"  type="checkbox" value="part_time">
                                    <label for="aa-41" class="checkbox-custom-label">Part Time</label>
                                </li>
                                <li>
                                    <input id="aa-2" class="checkbox-custom" name="modeofstudy[]" type="checkbox" value="full_time">
                                    <label for="aa-2" class="checkbox-custom-label">Full Time</label>
                                </li>

                                <li>
                                    <input id="aa-71" class="checkbox-custom" name="modeofstudy[]"  type="checkbox" value="distance"> 
                                    <label for="aa-71" class="checkbox-custom-label">Distance</label>
                                </li>

                            </ul>
                        </div>
                        <hr>

                    
                        <div class="filter-top-heading">
                            <h6 class="side_title">
                                Location
                            </h6>
                            <div>
                                <a data-toggle="collapse" data-toggle="collapse" href="#content_location" aria-expanded="false" class="collapse-header">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                </a>
                            </div>

                        </div>
                        <div class="collapse show" id="content_location">
                            <div class="form-inline addons mb-2 course-filter-search-bar" >
                                <input class="form-control se-input" type="search" placeholder="Search Location"  aria-label="Search" id="searchLocation">
                                <button><i class="ti-search"></i></button>
                            </div>
                            <ul class="no-ul-list mb-3" id="locationContainer"  >
                                
                            <?php $Location =DB::table('country_master')->select('CountryID','CountryName')->distinct()->get()->take(5); ?>
                                @foreach ($Location as $data)
                                <li>
                                    <input class="checkbox-custom" name="location[]" id="aa-location-{{$data->CountryID}}" type="checkbox" value="{{$data->CountryID}}">
                                    <label for="aa-location-{{$data->CountryID}}" class="checkbox-custom-label" >{{$data->CountryName}}</label>
                                </li>
                                @endforeach
                                

                            </ul>
                            
                        </div>

                        <hr>
                      
                        <div class="filter-top-heading">
                            <h6 class="side_title">
                                Duration
                            </h6>
                            <div>
                                <a data-toggle="collapse" data-toggle="collapse" href="#content_duration" aria-expanded="false" class="collapse-header">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                </a>
                            </div>

                        </div>
                        <div class="collapse" id="content_duration">
                            
                            <div class="form-inline addons mb-2 course-filter-search-bar" >
                                <input class="form-control se-input" type="search" placeholder="Search Duration" aria-label="Search" id="searchDuration">
                                <button><i class="ti-search"></i></button>
                            </div>
                            <ul class="no-ul-list mb-3"  id="durationContainer" >
                                
                                <?php  $Duration =DB::table('duration_master')->select('DurationID','Duration')->whereNull('deleted_at')->distinct()->get()->take(5); ?>
                                @foreach ($Duration as $data)
                                <li>
                                    <input id="aa-duration-{{$data->DurationID}}" class="checkbox-custom" name="duration[]" type="checkbox" value="{{$data->DurationID}}">
                                    <label for="aa-duration-{{$data->DurationID}}" class="checkbox-custom-label">{{$data->Duration}}</label>
                                </li>
                                @endforeach
                            

                            </ul> 
                        </div>

                        <hr>
                        <div class="filter-top-heading">
                            <h6 class="side_title">
                                Category
                            </h6>
                            <div>
                                <a data-toggle="collapse" data-toggle="collapse" href="#content_category" aria-expanded="false" class="collapse-header">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                </a>
                            </div>

                        </div>

                        <div class="collapse" id="content_category">
                            
                            <div class="form-inline addons mb-2 course-filter-search-bar" >
                                <input class="form-control se-input" type="search" placeholder="Search Category" aria-label="Search" id="searchCategory">
                                <button><i class="ti-search"></i></button>
                            </div>
                            <ul class="no-ul-list mb-3" id="categoryContainer" >
                                <?php  $CourseCategory =DB::table('course_category')->select('id','course_category')->distinct()->get()->take(5); ?>
                                @foreach ($CourseCategory as $data)
                                 <?php $checked = ''; if(!empty($_GET['course_category'])){ if($_GET['course_category'] == $data->id){ $checked = "checked";}else{ $checked = '';} }?>
                                <li>
                                   
                                    
                                    <input id="aa-category-{{$data->id}}" class="checkbox-custom" name="category[]" type="checkbox"  value="{{$data->id}}" {{$checked}}>
                                    <label for="aa-category-{{$data->id}}" class="checkbox-custom-label">{{$data->course_category}}</label>
                                </li>
                                @endforeach
                        
                            </ul>
                        </div>
                        <hr>
                    
                        <div class="filter-top-heading">
                            <h6 class="side_title">
                                Program Type
                            </h6>
                            <div>
                                <a data-toggle="collapse" data-toggle="collapse" href="#content_programtype" aria-expanded="false" class="collapse-header">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                </a>
                            </div>
                        </div>
                        <div class="collapse" id="content_programtype">
                            
                            <div class="form-inline addons mb-2 course-filter-search-bar" >
                                <input class="form-control se-input" type="search" placeholder="Search Program Type" aria-label="Search" id="searchProgramtype">
                                <button><i class="ti-search"></i></button>
                            </div>
                            <ul class="no-ul-list mb-3" id="programtypeContainer">
                                <?php  $CourseProgramtype =DB::table('course_types')->select('course_types_id','course_types')->distinct()->get()->take(5); ?>
                                @foreach ($CourseProgramtype as $data)
                                <li>
                                    {{-- <input id="aa-programtype-{{$data->course_types_id}}" class="checkbox-custom" name="programtype[]" type="checkbox"  value="{{$data->course_types_id}}"> --}}
                                    <input id="aa-programtype-{{$data->course_types_id}}" class="checkbox-custom" name="programtype[]" type="checkbox" value="{{$data->course_types_id}}">

                                    <label for="aa-programtype-{{$data->course_types_id}}" class="checkbox-custom-label">{{$data->course_types}}</label>
                                </li>
                                @endforeach
                        
                            </ul>
                        </div>

                        <hr>
                        <div class="filter-top-heading">
                            <h6 class="side_title">
                               Qualification
                            </h6>
                            <div>
                                <a data-toggle="collapse" data-toggle="collapse" href="#content_qualification" aria-expanded="false" class="collapse-header">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
                                </a>
                            </div>
                        </div>
                        <div class="collapse" id="content_qualification">
                            
                            <div class="form-inline addons mb-2 course-filter-search-bar" >
                                <input class="form-control se-input" type="search" placeholder="Search Qualification" aria-label="Search" id="searchQualification">
                                <button><i class="ti-search"></i></button>
                            </div>
                            <ul class="no-ul-list mb-3" id="qualificationContainer">
                                <?php  $CourseQualification =DB::table('qualification_master')->select('QualificationID','Qualification')->distinct()->get()->take(5); ?>
                                @foreach ($CourseQualification as $data)
                                <li>
                                    <input id="aa-qualification-{{$data->QualificationID}}" class="checkbox-custom" name="qualification[]" type="checkbox"  value="{{$data->QualificationID}}">
                                    <label for="aa-qualification-{{$data->QualificationID}}" class="checkbox-custom-label">{{$data->Qualification}}</label>
                                </li>
                                @endforeach
                        
                            </ul>
                        </div>



                    </div>
                </form>
            </div>
     
            <div class="col-lg-9 col-md-12 col-sm-12 order-1 order-lg-2 order-md-1 ">
                <div id="CourseFilterDisplayList">
                    <?php
                    if(!empty($_GET['course_title'])){
                        $course_title = $_GET['course_title'];
                    }else{
                        $course_title = '';
                    }
                    
                    if(!empty($_GET['specialization'])){
                        $specialization = $_GET['specialization'];
                    }else{
                        $specialization = '';
                    }

                    if(!empty($_GET['course_category'])){
                        $course_category = $_GET['course_category'];
                    }else{
                        $course_category = '';
                    }
                    if(!empty($_GET['course_coutry'])){
                        $course_coutry = $_GET['course_coutry'];
                    }else{
                        $course_coutry = '';
                    }

                    ?>
                    <input type='hidden' name="course_title_search" value="<?= $course_title ?>" id="course_title_search">
                    <input type='hidden' name="specialization" value="<?= $specialization ?>" id="specialization">
                    <input type='hidden' name="course_category" value="<?= $course_category ?>" id="course_category">
                    <input type='hidden' name="course_coutry" value="<?= $course_coutry ?>" id="course_coutry">
                </div>
            </div>

        </div>
        <!-- Row -->

    </div>
</section>
<!-- ============================ Find Courses with Sidebar End ================================== -->
@endsection
@section('js')
<script>
    
    $(document).ready(function () {
        loadCourseList(page=1);
       
        function loadCourseList(page)
        {   
            var course_title_search = $("#course_title_search").val();
            

            var specialization =  $("#specialization").val();

            var course_category = $("#course_category").val();
           

            $.ajax({
            type: 'POST',
            url: 'course/searchdata',
            data: { 
                page:page,
                course_title_search:course_title_search,
                course_category:course_category,
                specialization:specialization,
                
            },
            headers: {
                "X-CSRF-TOKEN": "<?php echo csrf_token() ?>",
            },
            success: function(data) {
               
                $('#CourseFilterDisplayList').empty();
                $("#CourseFilterDisplayList").html(data.html);
            }
            });
        }
    });

    
    // $(document).on("click", ".stlogincheck", function () {
    //     swal({
    //         title: "Please Login",
    //         text: "Click ok to Login",
    //         icon: "warning",
    //     }).then(function () {
    //         $("#login").modal('show');
    //     });
    // });

</script>
@endsection