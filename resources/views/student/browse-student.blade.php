<!-- Header file include -->
@extends('layouts.main')
@section('content')
<!-- ============================ Find Courses with Sidebar ================================== -->
<section class="pt-5 saved-students-page-main">
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

						<form class="left_filters_students">
							<div class="page_sidebar hide-23-23">
			
								<div class="filter-top-heading">
									<h6 class="side_title">
										Mode of Study
									</h6>
									<div>
										<a data-toggle="collapse" data-toggle="collapse" href="#content_modeofstudies1" aria-expanded="false" class="collapse-header">
											&nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> - </span>
										</a>
									</div>
			
								</div>
								<div class="collapse show" id="content_modeofstudies1">
									<ul class="no-ul-list mb-3">
										<li>
											<input id="aa-412" class="checkbox-custom" name="modeofstudstu[]"  type="checkbox" value="part_time">
											<label for="aa-412" class="checkbox-custom-label">Part Time</label>
										</li>
										<li>
											<input id="aa-22" class="checkbox-custom" name="modeofstudstu[]" type="checkbox" value="full_time">
											<label for="aa-22" class="checkbox-custom-label">Full Time</label>
										</li>
			
										<li>
											<input id="aa-712" class="checkbox-custom" name="modeofstudstu[]"  type="checkbox" value="distance"> 
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
										<input class="form-control se-input" type="search" placeholder="Search Location"  aria-label="Search" id="searchLocationstu">
										<button><i class="ti-search"></i></button>
									</div>
									<ul class="no-ul-list mb-3" id="locationContainer" >
												
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
										<input class="form-control se-input" type="search" placeholder="Search Program Type" aria-label="Search" id="searchProgramtypestu">
										<button><i class="ti-search"></i></button>
									</div>
									<ul class="no-ul-list mb-3" id="programtypeContainer">
										<?php  $CourseProgramtype =DB::table('course_types')->select('course_types_id','course_types')->distinct()->get()->take(5); ?>
										@foreach ($CourseProgramtype as $data)
										<li>
											{{-- <input id="aa-programtype-{{$data->course_types_id}}" class="checkbox-custom" name="programtype[]" type="checkbox"  value="{{$data->course_types_id}}"> --}}
											<input id="aa-programtypes-{{$data->course_types_id}}" class="checkbox-custom" name="programtype[]" type="checkbox" value="{{$data->course_types_id}}">
			
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
										<a data-toggle="collapse" data-toggle="collapse" href="#content_qualification1" aria-expanded="false" class="collapse-header">
											&nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> + </span>
										</a>
									</div>
								</div>
								<div class="collapse" id="content_qualification1">
									<div class="form-inline addons mb-2 course-filter-search-bar" >
										<input class="form-control se-input" type="search" placeholder="Search Qualification"  aria-label="Search" id="searchQualificationstu">
										<button><i class="ti-search"></i></button>
									</div>
									<ul class="no-ul-list mb-3" id="qualificationContainer" >
												
										<?php $Qualification =DB::table('qualification_master')->select('QualificationID','Qualification')->distinct()->get()->take(5); ?>
										@foreach ($Qualification as $data)
										<li>
											<input class="checkbox-custom" name="qualification[]" id="aa-qualifications-{{$data->QualificationID}}" type="checkbox" value="{{$data->QualificationID}}">
											<label for="aa-qualifications-{{$data->QualificationID}}" class="checkbox-custom-label" >{{$data->Qualification}}</label>
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

			<div class="col-lg-3 col-md-12 col-sm-12 order-2 order-lg-1 order-md-2">
				<input type = 'hidden' value="student_filter" id= "student_filter">
				<form class="left_filters_student">
				<div class="page_sidebar hide-23">

					<div class="filter-top-heading">
						<h6 class="side_title">
							Mode of Study
						</h6>
						<div>
							<a data-toggle="collapse" data-toggle="collapse" href="#content_modeofstudies" aria-expanded="false" class="collapse-header">
								&nbsp;&nbsp;&nbsp;&nbsp;<span   class="toggle-icon"> - </span>
							</a>
						</div>

					</div>
					<div class="collapse show" id="content_modeofstudies">
						<ul class="no-ul-list mb-3">
							<li>
								<input id="aa-41" class="checkbox-custom" name="modeofstudstu[]"  type="checkbox" value="part_time">
								<label for="aa-41" class="checkbox-custom-label">Part Time</label>
							</li>
							<li>
								<input id="aa-2" class="checkbox-custom" name="modeofstudstu[]" type="checkbox" value="full_time">
								<label for="aa-2" class="checkbox-custom-label">Full Time</label>
							</li>

							<li>
								<input id="aa-71" class="checkbox-custom" name="modeofstudstu[]"  type="checkbox" value="distance"> 
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
					<div class="collapse" id="content_location">
						<div class="form-inline addons mb-2 course-filter-search-bar" >
							<input class="form-control se-input searchLocationstu" type="search" placeholder="Search Location"  aria-label="Search">
							<button><i class="ti-search"></i></button>
						</div>
						<ul class="no-ul-list mb-3 locationContainer">
									
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
							<input class="form-control se-input searchProgramtypestu" type="search" placeholder="Search Program Type" aria-label="Search">
							<button><i class="ti-search"></i></button>
						</div>
						<ul class="no-ul-list mb-3 programtypeContainer">
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
							<input class="form-control se-input searchQualificationstu" type="search" placeholder="Search Qualification"  aria-label="Search">
							<button><i class="ti-search"></i></button>
						</div>
						<ul class="no-ul-list mb-3 qualificationContainer" >
									
							<?php $Qualification =DB::table('qualification_master')->select('QualificationID','Qualification')->distinct()->get()->take(5); ?>
							@foreach ($Qualification as $data)
							<li>
								<input class="checkbox-custom" name="qualification[]" id="aa-qualification-{{$data->QualificationID}}" type="checkbox" value="{{$data->QualificationID}}">
								<label for="aa-qualification-{{$data->QualificationID}}" class="checkbox-custom-label" >{{$data->Qualification}}</label>
							</li>
							@endforeach
							

						</ul>
					</div>

				</div>

				</form>

			</div>

			<div class="col-lg-9 col-md-12 col-sm-12 order-1 order-lg-2 order-md-1">
                <div id='StudentFilterDisplayList'></div>


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
        loadStudentList(page=1);
		
        function loadStudentList(page)
        {   
			
            // var course_title_search = $("#course_title_search").val();


            // var specialization =  $("#specialization").val();

            // var course_category = $("#course_category").val();


            $.ajax({
            type: 'POST',
            url: 'student/searchdatastudent',
            data: { 
                page:page,
                // course_title_search:course_title_search,
                // course_category:course_category,
                // specialization:specialization
            },
            headers: {
                "X-CSRF-TOKEN": "<?php echo csrf_token() ?>",
            },
            success: function(data) {
				
                $('#StudentFilterDisplayList').empty();
                $("#StudentFilterDisplayList").html(data.html);
            }
            });
        }
    });

    
    $(document).on("click", ".instlogincheck", function () {
        swal({
            title: "Please Login",
            text: "Click ok to Login",
            icon: "warning",
        }).then(function () {
            window.location.href='/institute-login'
        });
    });

</script>
@endsection