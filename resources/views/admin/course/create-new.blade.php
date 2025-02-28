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

        .input-container {
            display: inline-block;
            height: 40px;
            margin-bottom: 8px;
            position: relative;
            width: 100%;
        }


        /* Section tabe style */

        section .section-title {
            text-align: center;
            color: #007b5e;
            margin-bottom: 50px;
            text-transform: uppercase;
        }

        #tabs {
            background: #f5f5f5 !important;
            color: #000;
            max-width: 1000px;
            display: flex;
            margin: 0 auto;
            margin-bottom: 1rem;
            padding: 20px 24px;
        }

        nav .nav-tabs {
            display: flex;
            justify-content: space-between;
        }

        #tabs .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #000;
            background-color: transparent;
            border-color: transparent transparent #f3f3f3;
            border-bottom: 4px solid !important;
            font-size: 18px;
            font-weight: bold;
        }

        #tabs .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            color: #03A9F4;
            font-size: 16px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('plugins/dist/quill.snow.css') }}">
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
                    <br>

                    <div class="container">
                        <section id="tabs">
                            <div class="container">

                                <div class="row">
                                    <div class="col-xs-12">
                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab stepper" role="tablist">
                                                <a class="nav-item nav-link active" id="nav-home-tab"
                                                    data-target="#nav-home" data-bs-toggle="tab" href="#nav-home"
                                                    role="tab" aria-controls="nav-home"
                                                    aria-selected="true"><span>1</span>. Create
                                                    Course</a>
                                                <a class="nav-item nav-link" id="nav-profile-tab" data-target="#nav-profile"
                                                    data-bs-toggle="tab" href="#nav-profile" role="tab"
                                                    aria-controls="nav-profile" aria-selected="false">2. Others</a>
                                                <a class="nav-item nav-link" id="nav-contact-tab" data-target="#nav-contact"
                                                    data-bs-toggle="tab" href="#nav-contact" role="tab"
                                                    aria-controls="nav-contact" aria-selected="false">3. Course Media</a>
                                            </div>
                                        </nav>
                                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                                aria-labelledby="nav-home-tab">
                                                <div class="row g-2">
                                                    <form class="basicCourseFormAdd">
                                                        <input type='hidden' class="course_id" name='course_id'
                                                            value="{{ isset($CourseData[0]['id']) ? base64_encode($CourseData[0]['id']) : '' }}">

                                                        <div class="col-12">
                                                            <label for="course_name" class="form-label">Course Name <span
                                                                    class="text-danger">*</span> </label>
                                                            <input type="text" class="form-control" id="course_name"
                                                                placeholder="Course Name " name="course_name">
                                                            <div class="invalid-feedback" id="course_name_error">Please
                                                                enter course
                                                                name</div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="specialization"
                                                                class="form-label">Subheading</label>
                                                            <input type="text" class="form-control" id="subheading"
                                                                placeholder="Subheading" name="subheading">
                                                            <div class="invalid-feedback" id="subheading_error">Please enter
                                                                Subheading
                                                                name</div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="course_types" class="form-label">Program Type
                                                            </label>
                                                            <?php $courseTypeData = DB::table('course_types')->select('course_types_id', 'course_types')->distinct()->get(); ?>

                                                            <select class="form-control" name="course_types"
                                                                id="course_types" required>
                                                                <option value="">Select Program Type </option>
                                                                @foreach ($courseTypeData as $data)
                                                                    <option value="{{ $data->course_types_id }}">
                                                                        {{ $data->course_types }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback" id="course_types_error">Please
                                                                select Program
                                                                Type</div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="course_start_date" class="form-label">Mode of
                                                                Study</label>
                                                            <select class="form-control" name="mode_of_study"
                                                                id="mode_of_study" required>
                                                                <option value="">Select Mode of Study </option>
                                                                <option value="part_time">Part Time</option>
                                                                <option value="full_time">Full Time</option>
                                                                <option value="distance">Distance </option>
                                                            </select>
                                                            <div class="invalid-feedback" id="mode_of_study_error">Please
                                                                select mode of
                                                                Study</div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="course_category" class="form-label">Course
                                                                Category</label>
                                                            <?php $categoryData = DB::table('course_category')->select('id', 'course_category')->distinct()->get();
                                                            ?>
                                                            <select class="form-control" name="course_category"
                                                                id ="course_category" required>
                                                                <option value="">Select Category</option>
                                                                @foreach ($categoryData as $data)
                                                                    <option value="{{ $data->id }}">
                                                                        {{ $data->course_category }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback" id="course_category_error">
                                                                Please
                                                                select
                                                                course category</div>
                                                        </div>
                                                        <div class="col-12">
                                                            <input type="hidden" class="form-control currency_symbol"
                                                                id="currency_symbols" placeholder="Currency Symbols"
                                                                name="currency_symbols">
                                                            <label for="course_fees" class="form-label">Course Final
                                                                Price</label>
                                                            <input type="text" class="form-control" id="course_fees"
                                                                placeholder="Course Final Price" name="course_fees">
                                                            <div class="invalid-feedback" id="course_fees_error">Please
                                                                enter Final
                                                                Price</div>

                                                        </div>
                                                        <div class="col-12">
                                                            <label for="administrative_cost" class="form-label">Course Old
                                                                Price</label>
                                                            <input type="text" class="form-control"
                                                                id="administrative_cost" placeholder="Course Old Price"
                                                                name="administrative_cost">

                                                        </div>
                                                        <div class="col-12">
                                                            <label for="administrative_cost"
                                                                class="form-label">Scholarship
                                                                (%)</label>
                                                            <input type="text" class="form-control" id="total_cost"
                                                                placeholder="Scholarship " name="total_cost">
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <button type="submit"
                                                                class="btn btn-primary updateCourseBasicAdd">Save &
                                                                Next
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                                aria-labelledby="nav-profile-tab">
                                                <div class="row">
                                                    <form class="basicCourseOtherForm">
                                                        <input type='hidden' class="course_id" name='course_id'
                                                            value="{{ isset($CourseData[0]['id']) ? base64_encode($CourseData[0]['id']) : '' }}">

                                                        <div class="col-12 mt-2">
                                                            <label for="content mb-1"> Overview:<span style="color:red">
                                                                    *</span>
                                                            </label><br>

                                                            <div id="course_overview" name="course_overview"
                                                                class="form-control w-100" style="height: 200px" required>
                                                                <div class="invalid-feedback" id="course_overview_error">
                                                                </div>
                                                            </div>
                                                            <small>Enter course overview up to 1500 characters.</small>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <label for="content mb-1"> Curriculum:<span style="color:red">
                                                                    *</span></label><br>
                                                            <div id="course_curriculum" name="course_curriculum"
                                                                class="form-control w-100" style="height: 200px" required>
                                                            </div>
                                                            <small>Enter Curriculam up to 1500 characters.</small>
                                                            <div class="invalid-feedback" id="course_curriculum_error">
                                                                Enter course overview up to 1500 characters</div>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <label for="content mb-1"> Opportunities: </label><br>
                                                            <div id="course_opportunities" name="course_opportunities"
                                                                class="form-control w-100" style="height: 200px" required>
                                                            </div>
                                                            <small>Enter opportunities up to 1500 characters.</small>
                                                            <div class="invalid-feedback" id="course_opportunities_error">
                                                                Enter course overview up to 1500 characters</div>

                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <label for="content mb-1">Application Procedure: <span
                                                                    style="color:red">
                                                                    *</span> </label><br>
                                                            <div id="application_procedure" name="application_procedure"
                                                                class="form-control w-100" style="height: 200px" required>
                                                            </div>
                                                            <small>Enter application procedure up to 1500
                                                                characters.</small>
                                                            <div class="invalid-feedback"
                                                                id="application_procedure_error">Enter course overview up
                                                                to 1500 characters</div>


                                                        </div>
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <button type="submit"
                                                                class="btn btn-secondary">Previous</button>
                                                            <button type="submit"
                                                                class="btn btn-primary updateCourseOthers">Save &
                                                                Next</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                                aria-labelledby="nav-contact-tab">
                                                <form class="CourseMediaForm">
                                                    <div>

                                                        <input type='hidden' class="course_id" name='course_id'
                                                            value="{{ isset($CourseData[0]['id']) ? base64_encode($CourseData[0]['id']) : '' }}">

                                                        <div class="label-container">
                                                            <label class="form-label">Upload Course Thumbnail</label>
                                                        </div>

                                                        <div class="input-group mb-3">
                                                            <input type="file" accept=".jpeg,.png,.jpg,.svg"
                                                                class="form-control imageprv" id="thumbnail_img"
                                                                name="thumbnail_img">
                                                            <label class="input-group-text"
                                                                for="thumbnail_img">Upload</label> 
                                                                                                                      
                                                            <div class="invalid-feedback" id="thumbnail_error">Please Upload Thumbnail</div> 
                                                        </div>
                                                        <div class="d-block">
                                                            <img class="image-preview img-fluid mb-4" src=""
                                                            style="display:none;width: 400px;height: 230px;">
                                                        </div>

                                                        <div class="label-container">
                                                            <label class="form-label">Upload Course Trailer</label>
                                                        </div>

                                                        <div class="input-group mb-3">
                                                            <input type="file" class="form-control course_trailor" accept=".mp4"
                                                                id="course_trailor" name="course_trailor">
                                                            <label class="input-group-text"
                                                                for="course_trailor">Upload</label>
                                                                <div class="invalid-feedback" id="trailor_error">Please Upload Thumbnail</div>
                                                        </div>
                                                        <div class="d-block mb-4">
                                                            @if (isset($CourseData[0]['bn_course_trailer_url']) && !empty($CourseData[0]['bn_course_trailer_url']))
                                                            @php
                                                            $videUrl=  $CourseData[0]['bn_course_trailer_url'];
                                                            @endphp
                                                            <div class="previouseVideo mb-4" style="position:relative;padding-top:56.25%;"><iframe src="https://iframe.mediadelivery.net/embed/{{env('MASTER_LIBRARY_ID')}}/{{$videUrl}}?autoplay=false&loop=false&muted=true&preload=false&responsive=true" loading="lazy" style="border:0;position:absolute;top:0;height:100%;width:100%;" allow="accelerometer;gyroscope;autoplay;encrypted-media;picture-in-picture;" allowfullscreen="true"></iframe></div>
                                                            @endif
                                                            <video controlslist="nodownload" controls="" oncontextmenu="return false;" class="mb-6 d-flex justify-content-center align-items-center position-relative rounded py-16 border-white border rounded bg-cover video-preview-trailor d-none" height="400px;" width="800px;" src=""></video>

                                                        </div>

                                                        <div class="label-container">
                                                            <label class="form-label">Upload Trailer Thumbnail</label>
                                                        </div>
                                                        

                                                        <div class="input-group mb-3">
                                                            <input type="file" class="form-control thumbnail_preview" accept=".jpeg,.png,.jpg,.svg" name="trailor_thumbnail"
                                                                id="trailor_thumbnail">
                                                            <label class="input-group-text"
                                                                for="trailor_thumbnail">Upload</label>
                                                                <div class="invalid-feedback" id="trailor_thumbnail_error">Please Upload Thumbnail</div>
                                                        </div>
                                                        <div class="d-block">
                                                            <img class="trailor_thumbnail_preview img-fluid mb-4" src=""
                                                            style="display:none;width: 400px;height: 230px;">
                                                        </div>
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <button type="submit"
                                                                class="btn btn-secondary">Previous</button>
                                                            <button type="submit"
                                                                class="btn btn-primary updateCourseMediaAdd">Save</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>
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

    <script src="{{ asset('plugins/dist/quill.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/editor.js') }}"></script>
   
    <!-- Initialize CKEditor on the textarea -->


    <script>
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



        // });
    </script>
    <script>
        $(document).ready(function() {
            $("#course_fees, #administrative_cost").on("input", function() {
                var price = parseFloat($("#course_fees").val()) || 0;
                var old_price = parseFloat($("#administrative_cost").val()) || 0;
                if (old_price > 0 && price > 0) {
                    var scholarship_percent = ((old_price - price) / old_price) * 100;
                    $("#total_cost").val(scholarship_percent.toFixed(2));
                } else {
                    $("#total_cost").val(0);
                }
            });
        });
    </script>
@endsection
