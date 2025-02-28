@extends('admin.layouts.main')
@section('css')
    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single {
            height: 35px !important;
        }

        .select2-selection__arrow {
            height: 34px !important;
        }

        .error {
            color: red;
        }

        .content .header-title {
            font-size: 15px;
        }

        .card-header {
            background-color: #d8f3ff;
        }
    </style>
@endsection
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page course-pages">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <?php
                    $sub_title = 'Course';
                    $page_title = 'Create Course'; ?>
                    @include('admin.layouts.page-title')
                    <!-- end row -->
                    <div class="d-flex justify-content-sm-end"><a href="{{ route('course') }}" class="btn btn-success">Back</a>
                    </div>
                    <bR>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h4 class="header-title">Create Course</h4>
                                </div>
                                <br>
                                <div class="card-body">
                                    <form action="#" enctype="multipart/form-data" id="addCourse">
                                        <div class="row g-2">

                                            <div class="col-md-3">
                                                <label for="fullname" class="form-label">Institute Name <span
                                                        style="color:red"> *</span> </label>
                                                <select class="form-select  mb-2 select2" name="institute_id"
                                                    id="institute_id">
                                                    <option value="">Select Institute</option>
                                                    @foreach ($instituteData as $data)
                                                        <option value="{{ $data->institute_id }}">{{ $data->company_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="course_name" class="form-label">Course Name <span
                                                        style="color:red"> *</span> </label>
                                                <input type="text" class="form-control" id="course_name"
                                                    placeholder="Course Name " name="course_name">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="specialization" class="form-label">Specialization <span
                                                        style="color:red"> *</span> </label>
                                                <input type="text" class="form-control" id="specialization"
                                                    placeholder="Specialization" name="specialization">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="course_types" class="form-label">Program Type <span
                                                        style="color:red"> *</span> </label>
                                                <?php $courseTypeData = DB::table('course_types')->select('course_types_id', 'course_types')->distinct()->get(); ?>
                                                <select class="form-control" name="course_types" id="course_types" required>
                                                    <option value="">Select Program Type </option>
                                                    @foreach ($courseTypeData as $data)
                                                        <option value="{{ $data->course_types_id }}">
                                                            {{ $data->course_types }}</option>
                                                    @endforeach
                                                </select>
                                            </div>




                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-2">
                                                <label for="course_start_date" class="form-label">Mode of Study <span
                                                        style="color:red"> *</span></label>
                                                <select class="form-control mode_of_study" name="mode_of_study" required>
                                                    <option value="">Select Mode of Study </option>
                                                    <option value="part_time">Part Time</option>
                                                    <option value="full_time">Full Time</option>
                                                    <option value="distance">Distance </option>

                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="ects" class="form-label">ECTS </label>
                                                <input type="text" class="form-control" name="ects">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="mqf_level" class="form-label">MQF / EQF Level </label>
                                                <input type="text" class="form-control" name="mqf_level">
                                            </div>


                                            <div class="col-md-3">
                                                <label for="course_start_date" class="form-label">Course Start Date<span
                                                        style="color:red"> *</span></label>
                                                <input type="date" class="form-control" name="course_start_date">
                                            </div>


                                            <div class="col-md-3">
                                                <label for="course_expire_date" class="form-label">Course Expire Date<span
                                                        style="color:red"> *</span> </label>
                                                <input type="date" class="form-control" name="course_expire_date">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-2">
                                                <label for="course_tag" class="form-label">Course Tag</label>
                                                <input type="text" class="form-control" placeholder="Course Tag"
                                                    name="course_tag">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="course_duration" class="form-label">Course Duration <span
                                                        style="color:red"> *</span> </label>
                                                <select class="form-select mb-2 select2" name="course_duration"
                                                    id="course_duration" required>
                                                    <option value="">Select Course Duration</option>
                                                    @foreach ($durationData as $data)
                                                        <option value="{{ $data->DurationID }}">{{ $data->Duration }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="course_language" class="form-label">Language <span
                                                        style="color:red"> *</span> </label>
                                                <select class="form-select mb-2 select2" name="course_language">
                                                    <option value="">Select Language</option>
                                                    @foreach ($languageData as $data)
                                                        <option value="{{ $data->LanguageID }}">{{ $data->Language }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="intake_month" class="form-label">Intake Month <span
                                                        style="color:red"> *</span> </label>
                                                <select class="form-select mb-2 select2" name="course_intakemonth">
                                                    <option value="">Select Intake Month</option>
                                                    @foreach ($intakemonthData as $data)
                                                        <option value="{{ $data->IntakemonthID }}">
                                                            {{ $data->Intakemonth }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="intake_year" class="form-label">Intake Year <span
                                                        style="color:red"> *</span> </label>
                                                <select class="form-select mb-2 select2" name="course_intakeyear">
                                                    <option value="">Select Intake year</option>
                                                    @foreach ($intakeyearData as $data)
                                                        <option value="{{ $data->IntakeyearID }}">{{ $data->Intakeyear }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="course_category" class="form-label">Course Category <span
                                                        style="color:red"> *</span> </label>
                                                <?php $categoryData = DB::table('course_category')->select('id', 'course_category')->distinct()->get();
                                                ?>
                                                <select class="form-control" name="course_category" required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($categoryData as $data)
                                                        <option value="{{ $data->id }}">{{ $data->course_category }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <br>
                                        <div class="row g-2">

                                            <div class="col-md-2">
                                                <label for="country_id" class="form-label">Currency <span
                                                        style="color:red"> *</span> </label>
                                                <select class="form-select  mb-2 select2" name="country_id"
                                                    id="country_id">
                                                    <option value="">Select Currency</option>
                                                    @foreach ($countryData as $data)
                                                        <option value="{{ $data->CurrencySymbol }}">
                                                            {{ $data->CurrencySymbol }}</option>
                                                    @endforeach
                                                </select>
                                            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <div class="col-md-3">
                                                <input type="hidden" class="form-control currency_symbol"
                                                    id="currency_symbols" placeholder="Currency Symbols"
                                                    name="currency_symbols" style="width:20%">
                                                <label for="course_fees" class="form-label">Fees <span style="color:red">
                                                        *</span> </label>
                                                <div class="row">
                                                    <input type="text" class="form-control currency_symbol"
                                                        id="currency_symbol" placeholder="Currency Symbol"
                                                        name="currency_symbol" disabled=""
                                                        style="width:20%">&nbsp;&nbsp;
                                                    <input type="text" class="form-control" id="course_fees"
                                                        placeholder="Course Fees " name="course_fees" style="width:70%">
                                                </div>
                                            </div>&nbsp;&nbsp;
                                            <div class="col-md-3">
                                                <label for="administrative_cost" class="form-label">Administrative Cost
                                                    <span style="color:red"> *</span> </label>
                                                <div class="row">
                                                    <input type="text" class="form-control currency_symbol"
                                                        id="currency_symbol" placeholder="Currency Symbol"
                                                        name="currency_symbol" disabled=""
                                                        style="width:20%">&nbsp;&nbsp;
                                                    <input type="text" class="form-control" id="administrative_cost"
                                                        placeholder="Administrative Cost" name="administrative_cost"
                                                        style="width:70%">
                                                </div>
                                            </div>&nbsp;&nbsp;
                                            <div class="col-md-3">
                                                <label for="administrative_cost" class="form-label">Total Cost </label>
                                                <div class="row">
                                                    <input type="text" class="form-control currency_symbol"
                                                        id="currency_symbol" placeholder="Currency Symbol"
                                                        name="currency_symbol" disabled=""
                                                        style="width:20%">&nbsp;&nbsp;
                                                    <input type="text" class="form-control" id="total_cost"
                                                        placeholder="Total Cost " name="total_cost" style="width:70%">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- <div class="card-header">
                                            <B class="header-title">COURSE DETAILS</B>
                                            <HR><br> --}}
                                        <div class="row">
                                            <div class="col-md-11">
                                                <label for="content"> Overview:<span style="color:red"> *</span>
                                                </label><br><br>
                                                <textarea id="course_overview" name="course_overview" required></textarea>
                                                <label id="course_overview-error" class="error" for="course_overview"
                                                    style="display:none;">Please enter Overview.</label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-11">
                                                <label for="content"> Curriculum:<span style="color:red">
                                                        *</span></label><br><br>
                                                <textarea name="course_curriculum" id="course_curriculum" required></textarea>
                                                <label id="course_curriculum-error" class="error"
                                                    for="course_curriculum" style="display:none;">Please enter
                                                    Crriculum.</label>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-11">
                                                <label for="content"> Features:</label><br><br>
                                                <textarea name="course_features" id="course_features" required></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-11">
                                                <label for="content"> Opportunities: </label><br><br>
                                                <textarea name="course_opportunities" id="course_opportunities" rows="10" cols="50" required></textarea>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row">
                                            <div class="col-md-11">
                                                <label for="content">Application Procedure: <span style="color:red">
                                                        *</span> </label><br><br>
                                                <textarea name="course_requirements" id="course_requirements" rows="10" cols="50" required></textarea>
                                                <label id="course_requirements-error" class="error"
                                                    for="course_requirements" style="display:none;">Please enter the
                                                    Application Procedure.</label>
                                            </div>
                                        </div>

                                        {{-- </div> --}}

                                        <br>
                                        <br>
                                        <div class="card-header">
                                            <h4 class="header-title">Eligibility </h4>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label for="" class="form-label">Required Qualification <span
                                                        style="color:red"> *</span></label>
                                                <?php $QualificationData = DB::table('qualification_master')->select('QualificationID', 'Qualification')->distinct()->get(); ?>
                                                <select class="form-control" name="qualification" id="qualification"
                                                    required>
                                                    <option value="">Select Qualification </option>
                                                    @foreach ($QualificationData as $data)
                                                        <option value="{{ $data->QualificationID }}">
                                                            {{ $data->Qualification }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="" class="form-label">Age Limit (Years) <span
                                                        style="color:red"> *</span></label>
                                                <input type="text" class="form-control" name="age_limit" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card-header">
                                            <h4 class="header-title">Documents</h4>
                                        </div>
                                        <br>
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <label for="" class="form-label">Application Form
                                                </label>
                                                <div class="" style="position: relative;">
                                                    <input type="file" id="application_form" name="application_form"
                                                        class="form-control"></a>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="brochure" class="form-label">Brochure
                                                </label>
                                                <div class="" style="position: relative;">
                                                    <input type="file" id="brochure" name="brochure"
                                                        class="form-control"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        {{-- <div class="card-header">
                                            <B class="header-title">FEES DETAIL</B>
                                        </div>
                                        <br><br> --}}
                                        {{-- <div class="row g-2">
                                                <div class="col-md-2">
                                                    <label for="country_id" class="form-label">Country</label>
                                                    <select class="form-select  mb-2 select2" name="country_id" id="country_id">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countryData as $data)
                                                            <option value="{{ $data->CountryID }}">{{ $data->CountryName }}</option>
                                                        @endforeach
                                                    </select>  
                                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <div class="col-md-3">
                                                    <input type="hidden" class="form-control currency_symbol" id="currency_symbols" placeholder="Currency Symbols" name="currency_symbols" style="width:20%">
                                                    <label for="course_fees" class="form-label">Fees</label>
                                                    <div class="row">
                                                        <input type="text" class="form-control currency_symbol" id="currency_symbol" placeholder="Currency Symbol" name="currency_symbol" disabled="" style="width:20%">&nbsp;&nbsp;
                                                        <input type="text" class="form-control" id="course_fees" placeholder="Course Fees "  name="course_fees"  style="width:70%">
                                                    </div>
                                                </div>&nbsp;&nbsp;
                                                <div class="col-md-3">
                                                    <label for="administrative_cost" class="form-label">Administrative Cost </label>
                                                    <div class="row">
                                                        <input type="text" class="form-control currency_symbol" id="currency_symbol" placeholder="Currency Symbol" name="currency_symbol" disabled="" style="width:20%">&nbsp;&nbsp;
                                                        <input type="text" class="form-control" id="administrative_cost" placeholder="Administrative Cost"  name="administrative_cost" style="width:70%">
                                                    </div>                                            
                                                </div>&nbsp;&nbsp;
                                                <div class="col-md-3">
                                                    <label for="administrative_cost" class="form-label">Total Cost </label>
                                                    <div class="row">
                                                        <input type="text" class="form-control currency_symbol" id="currency_symbol" placeholder="Currency Symbol" name="currency_symbol" disabled="" style="width:20%">&nbsp;&nbsp;
                                                        <input type="text" class="form-control" id="total_cost" placeholder="Total Cost "  name="total_cost" style="width:70%">
                                                    </div>
                                                </div>
                                            </div> --}}

                                        <br><br>

                                        <input type="submit" class="btn btn-primary" id="CreateCourse" value="Save">
                                    </form>

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>


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
    <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/common.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <!-- Initialize CKEditor on the textarea -->


    <script>
        // $(document).ready(function(){

        CKEDITOR.replace('course_overview');
        CKEDITOR.replace('course_curriculum');
        CKEDITOR.replace('course_requirements');
        CKEDITOR.replace('course_opportunities');
        CKEDITOR.replace('course_features');
        CKEDITOR.instances.course_overview.on('focus', function() {
            $("#course_overview-error").hide();
        });
        CKEDITOR.instances.course_curriculum.on('focus', function() {
            $("#course_curriculum-error").hide();
        });
        CKEDITOR.instances.course_requirements.on('focus', function() {
            $("#course_requirements-error").hide();
        });
        $('.select2').select2();

        $('#country_id').on('change', function() {
            var idCountry = this.value;
            $(".currency_symbol").val(idCountry);
            // $("#institute_state").html('');
            // $.ajax({
            //     url: "{{ url('institute/fetch-states') }}",
            //     type: "POST",
            //     data: {
            //         country_id: idCountry,
            //         _token: '{{ csrf_token() }}'
            //     },
            //     dataType: 'json',
            //     success: function (result) {
            //         $(".currency_symbol").val(result.countrycode[0]['CurrencySymbol']);

            //     }
            // });

        });

        $("#administrative_cost").on('input', function() {
            course_fees = $("#course_fees").val();
            administrative_cost = $("#administrative_cost").val();
            total_cost = parseInt(course_fees) + parseInt(administrative_cost);
            $("#total_cost").val(total_cost);
        });

        // });
    </script>
@endsection
