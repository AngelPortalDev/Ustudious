<!-- Header file include -->
@extends('layouts.main')
@section('content')
<?php $ASSET_PATH = env('ASSET_URL').'/' ?>
<div class="course-heading-top-section lg">
    <div class="container">
        <div class="row">

            <div class="college-cover-img">
                <?php 
                if($Courses->institute_banner){ 
                    $filePath =  Storage::url('institute/banner/'.$Courses->institute_banner); 
                    ?>
                <img src="{{$filePath}}" class="img-fluid avater" alt="" width="1200" height="200">
                <?php }else{ 
                    $filePaths =  Storage::url('no-image.jpg'); ?>
                    <img src="{{$filePaths}}" class="img-fluid avater" alt="" width="1200" height="200">
                <?php } ?>
            </div>


            <div class="col-lg-12 col-md-12">

                <div class="college-logo">
                    <?php 
                    if($Courses->institute_logo){ 
                    $filePath =  Storage::url('institute/logo/'.$Courses->institute_logo); 
                    ?>
                    <img src="{{$filePath}}" class="img-fluid avater" width="120" height="120" >
                    <?php }else{
                        $filePath =  Storage::url('no-image.jpg'); ?>
                        <img src="{{$filePath}}" class="img-fluid avater" width="120" height="120" >
                    <?php } ?>
                </div>


                <div class="inline_edu_wraps mb-2 course-name-section">
                    <h2><?= $Courses->CourseName  ?></h2>



                    <div class="college-name mb-3">at&nbsp;
                        <a class="" href="{{route('college-details',$Courses->InstituteID)}}"> <?= $Courses->company_name  ?>
                        </a>
                    </div>

                    <div class="ed_header_caption">
                        <ul>
                            <li><i class="ti-control-forward"></i> <strong>Program Type: </strong><?= $Courses->course_types ?></li>
                            {{-- <li><i class="ti-user"></i> <strong>Student Enrolled: </strong>52 </li> --}}
                        </ul>
                    </div>

                    {{-- <div class="ed_rate_info">
                        <div class="star_info">
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star"></i>
                        </div> --}}
                        {{-- <div class="review_counter">
                            <strong class="good">4.0 </strong> (3572 Reviews)
                        </div> --}}
                    {{-- </div> --}}

                    <div class="course-btn-sec">

                        <div class="btns-ma">

                            {{-- <button class="apply-btn stlogincheck"><i class="fa fa-arrow-right"></i> Apply</button> --}}
                           
                            <?php
                              $filePath =  Storage::url('course/brochure/'.$Courses->Brochure);  
                              if($Courses->Brochure) {
                              ?>
                                <button class="download-brochure"  onclick="downloadBrochure('<?php echo $filePath ?>')" ><i class="fa fa-download" aria-hidden="true"></i> Brochure</button>
                            <?php } ?>
                            <?php
                            $filePath =  Storage::url('course/application_form/'.$Courses->ApplicationForm);  
                            if($Courses->ApplicationForm) {
                            ?>
                              <button class="download-applicationform"  onclick="downloadBrochure('<?php echo $filePath ?>')" ><i class="fa fa-download" aria-hidden="true"></i> Application Form</button>
                          <?php } ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================ Course Detail ================================== -->
<section class="border course-details-page-main">
    <div class="container">


        <div class="row">

            <div class="col-lg-8 col-md-8">

                <!-- All Info Show in Tab -->
                <div class="tab_box_info  border p-3">
                    <ul class="nav nav-pills mb-3 light course_details_pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active mt-2" id="overview-tab" data-toggle="pill" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mt-2" id="curriculum-tab" data-toggle="pill" href="#curriculum" role="tab" aria-controls="curriculum" aria-selected="false">Curriculum</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mt-2" id="procedure-tab" data-toggle="pill" href="#procedure" role="tab" aria-controls="procedure" aria-selected="false">Procedure</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="reviews-tab" data-toggle="pill" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                        </li> --}}
                    </ul>

                    <div class="tab-content" id="pills-tabContent">

                        <!-- Overview Detail -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <!-- Overview -->
                            <div class="edu_wraper">
                                <h4 class="edu_title">Course Overview</h4>
                                {{-- <p>The FinTech and Blockchain track is a multi disiplinary course focusing on the application of Computer Science into the financial sector in order to make transactions and data research more practical and efficient. Students are given a deep dive into financial modelling and the application of Digital Ledger technology into financial applications.</p>

                                <p>Graduates of the Master of Science (MSc) in Computer Science (FinTech and Blockchain) program will develop a deep understanding of the fundamental concepts and principles of fintech, including digital currencies, smart contracts, and blockchain technology, as well as financial technologies such as robo-advisors, mobile payments, and online lending. Upon completion of the program, students will be able to design and implement fintech and blockchain systems, using a range of programming languages, software development methodologies, and tools. </p> --}}
                                {{-- {{ !empty($Courses->CourseOverview) ? $Courses->CourseOverview : 'Not Disclosed' }} --}}

                                {!! !empty($Courses->CourseOverview) ?  html_entity_decode($Courses->CourseOverview) : 'Not Disclosed' !!}

                            </div>

                            <!-- Overview -->
                            <div class="edu_wraper">
                                <h4 class="edu_title"> Course Specialization</h4>
                                <ul class="">
                                    <li> <strong>{{ !empty($Courses->Specialization) ? $Courses->Specialization : 'Not Disclosed' }}</strong> </li>
                                </ul>
                            </div>

                            <div class="edu_wraper">
                                <h4 class="edu_title">Course Tag</h4>
                                <ul class="">
                                    <li> <strong>{{ !empty($Courses->CourseTag) ? $Courses->CourseTag : 'Not Disclosed' }}</strong> </li>
                                </ul>
                            </div>

                            <div class="edu_wraper">
                                <h4 class="edu_title">Course Category</h4>
                                <ul class="">
                                    <li> <strong>{{ !empty($Courses->course_category) ? $Courses->course_category : 'Not Disclosed' }}</strong> </li>
                                </ul>
                            </div>

                         
                            <!-- Overview -->
                            <div class="edu_wraper">
                                <h4 class="edu_title">Eligibility</h4>
                                <ul class="">
                                    <li> <strong>Required Qualification : </strong>{{ !empty($Courses->Qualification) ? $Courses->Qualification : 'Not Disclosed' }} </li>
                                    <li> <strong>Required Specialization : </strong>{{ !empty($Courses->EduSpecialization) ? $Courses->EduSpecialization : 'Not Disclosed' }} </li>
                                    <li><strong>Age Limit : </strong>{{ !empty($Courses->AgeLimit) ? $Courses->AgeLimit : 'Not Disclosed' }}</li>
                                </ul>
                            </div>

                            <!-- Priority Deadline -->
                            <div class="edu_wraper">
                                <h4 class="edu_title">Priority Deadline</h4>
                                <ul class="">
                                    <li> <strong>
                                    <?php
                                    $CourseStart = $Courses->CoursestartDate;
                                    if($CourseStart){
                                        $CourseStart = $Courses->CoursestartDate;
                                        $CourseEnd = $Courses->CourseendDate;
                                        echo $CourseStart.' to '.$CourseEnd;
                                    }else{
                                        echo 'Not Disclosed';
                                    }
                                    ?></strong> </li>
                                </ul>
                            </div>

                            <!-- Course Features -->
                            <div class="edu_wraper">
                                <h4 class="edu_title">Course Features</h4>
                                <ul class="course-features-lists">
                                    {{-- <li>A simple light alert</li>
                                    <li>A simple light alert</li>
                                    <li>A simple light alert</li>
                                    <li>A simple light alert</li> --}}
                                    {{-- {{ !empty($Courses->Features) ? $Courses->Features : 'Not Disclosed' }} --}}
                                {!! !empty($Courses->Features) ?  html_entity_decode($Courses->Features) : 'Not Disclosed' !!}

                                </ul>
                            </div>

                            <!-- OPPORTUNITIES -->
                            <div class="edu_wraper">
                                <h4 class="edu_title">Opportunities</h4>
                                <ul class="course-features-lists">
                                    {{-- <li>A simple light alert</li>
                                    <li>A simple light alert</li>
                                    <li>A simple light alert</li>
                                    <li>A simple light alert</li> --}}
                                    {{-- {{ !empty($Courses->Opportunities) ? $Courses->Opportunities : 'Not Disclosed' }} --}}
                                    {!! !empty($Courses->Opportunities) ?  html_entity_decode($Courses->Opportunities) : 'Not Disclosed' !!}
                                    

                                </ul>
                            </div>

                        </div>

                        <!-- Curriculum Detail -->
                        <div class="tab-pane fade" id="curriculum" role="tabpanel" aria-labelledby="curriculum-tab">
                            <div class="edu_wraper">
                                <div id="accordionExample" class="accordion shadow circullum">
                                    {{-- {{ !empty($Courses->Curriculum) ?   ($Courses->Curriculum)  : 'Not Disclosed' }} --}}

                                    {!! !empty($Courses->Curriculum) ?  html_entity_decode($Courses->Curriculum) : 'Not Disclosed' !!}

                                   
                                    {{-- <div class="card">
                                        <div id="headingOne" class="card-header bg-white shadow-sm border-0">
                                            <h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark collapsible-link py-2">Part
                                                    01: How To Learn Web Designing Step by Step</a></h6>
                                        </div>
                                        <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample" class="collapse show">
                                            <div class="card-body pl-3 pr-3">
                                                <ul class="lectures_lists">
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 01</div>Web
                                                        Designing Beginner
                                                    </li>
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 02</div>
                                                        Startup Designing with HTML5 & CSS3
                                                    </li>
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 03</div>How
                                                        To Call Google Map iFrame
                                                    </li>
                                                    <li class="unview">
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 04</div>
                                                        Create Drop Down Navigation Using CSS3
                                                    </li>
                                                    <li class="unview">
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 05</div>How
                                                        to Create Sticky Navigation Using JS
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div id="headingTwo" class="card-header bg-white shadow-sm border-0">
                                            <h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="d-block position-relative collapsed text-dark collapsible-link py-2">Part
                                                    02: Learn Web Designing in Basic Level</a></h6>
                                        </div>
                                        <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionExample" class="collapse">
                                            <div class="card-body pl-3 pr-3">
                                                <ul class="lectures_lists">
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 01</div>Web
                                                        Designing Beginner
                                                    </li>
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 02</div>
                                                        Startup Designing with HTML5 & CSS3
                                                    </li>
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 03</div>How
                                                        To Call Google Map iFrame
                                                    </li>
                                                    <li class="unview">
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 04</div>
                                                        Create Drop Down Navigation Using CSS3
                                                    </li>
                                                    <li class="unview">
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 05</div>How
                                                        to Create Sticky Navigation Using JS
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                 
                                    <div class="card">
                                        <div id="headingThree" class="card-header bg-white shadow-sm border-0">
                                            <h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="d-block position-relative collapsed text-dark collapsible-link py-2">Part
                                                    03: Learn Web Designing in Advance Level</a></h6>
                                        </div>
                                        <div id="collapseThree" aria-labelledby="headingThree" data-parent="#accordionExample" class="collapse">
                                            <div class="card-body pl-3 pr-3">
                                                <ul class="lectures_lists">
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 01</div>Web
                                                        Designing Beginner
                                                    </li>
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 02</div>
                                                        Startup Designing with HTML5 & CSS3
                                                    </li>
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 03</div>How
                                                        To Call Google Map iFrame
                                                    </li>
                                                    <li class="unview">
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 04</div>
                                                        Create Drop Down Navigation Using CSS3
                                                    </li>
                                                    <li class="unview">
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 05</div>How
                                                        to Create Sticky Navigation Using JS
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div id="headingFour" class="card-header bg-white shadow-sm border-0">
                                            <h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" class="d-block position-relative collapsed text-dark collapsible-link py-2">Part
                                                    04: How To Become Succes in Designing & Development?</a>
                                            </h6>
                                        </div>
                                        <div id="collapseFour" aria-labelledby="headingFour" data-parent="#accordionExample" class="collapse">
                                            <div class="card-body pl-3 pr-3">
                                                <ul class="lectures_lists">
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 01</div>Web
                                                        Designing Beginner
                                                    </li>
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 02</div>
                                                        Startup Designing with HTML5 & CSS3
                                                    </li>
                                                    <li>
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 03</div>How
                                                        To Call Google Map iFrame
                                                    </li>
                                                    <li class="unview">
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 04</div>
                                                        Create Drop Down Navigation Using CSS3
                                                    </li>
                                                    <li class="unview">
                                                        <div class="lectures_lists_title"><i class="ti-control-play"></i>Lecture: 05</div>How
                                                        to Create Sticky Navigation Using JS
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> --}}

                                </div>
                            </div>
                        </div>

                        <!-- Application Procedure Detail -->
                        <div class="tab-pane fade" id="procedure" role="tabpanel" aria-labelledby="procedure-tab">
                            <div class="edu_wraper">

                                <h4 class="edu_title">Application Procedure</h4>
                                <ul class="lists-3">
                                    {{-- {{ !empty($Courses->Requirements) ? $Courses->Requirements : 'Not Disclosed' }} --}}

                                    {!! !empty($Courses->Requirements) ?  html_entity_decode($Courses->Requirements) : 'Not Disclosed' !!}

                                    {{-- <li>Application form</li>
                                    <li>Passport Size Photograph</li>
                                    <li>Passport Copy</li>
                                    <li>Updated Resume</li>
                                    <li>All educational marksheets and certificates</li>
                                    <li>Semester wise marksheets / transcripts if any</li>
                                    <li>IELTS score card</li>
                                    <li>Work experience if any</li>
                                    <li>Visa copy if any</li>
                                    <li>Any other additional documents if exists</li> --}}
                                </ul>
                            </div>
                        </div>

                        <!-- Reviews Detail -->
                        {{-- <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

                            <!-- Overall Reviews -->
                            <div class="rating-overview">
                                <div class="rating-overview-box">
                                    <span class="rating-overview-box-total">4.2</span>
                                    <span class="rating-overview-box-percent">out of 5.0</span>
                                    <div class="star-rating" data-rating="5"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i>
                                    </div>
                                </div>

                                <div class="rating-bars">
                                    <div class="rating-bars-item">
                                        <span class="rating-bars-name">5 Star</span>
                                        <span class="rating-bars-inner">
                                            <span class="rating-bars-rating high" data-rating="4.7">
                                                <span class="rating-bars-rating-inner" style="width: 85%;"></span>
                                            </span>
                                            <strong>85%</strong>
                                        </span>
                                    </div>
                                    <div class="rating-bars-item">
                                        <span class="rating-bars-name">4 Star</span>
                                        <span class="rating-bars-inner">
                                            <span class="rating-bars-rating good" data-rating="3.9">
                                                <span class="rating-bars-rating-inner" style="width: 75%;"></span>
                                            </span>
                                            <strong>75%</strong>
                                        </span>
                                    </div>
                                    <div class="rating-bars-item">
                                        <span class="rating-bars-name">3 Star</span>
                                        <span class="rating-bars-inner">
                                            <span class="rating-bars-rating mid" data-rating="3.2">
                                                <span class="rating-bars-rating-inner" style="width: 52.2%;"></span>
                                            </span>
                                            <strong>53%</strong>
                                        </span>
                                    </div>
                                    <div class="rating-bars-item">
                                        <span class="rating-bars-name">1 Star</span>
                                        <span class="rating-bars-inner">
                                            <span class="rating-bars-rating poor" data-rating="2.0">
                                                <span class="rating-bars-rating-inner" style="width:20%;"></span>
                                            </span>
                                            <strong>20%</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews -->
                            <div class="list-single-main-item fl-wrap">
                                <div class="list-single-main-item-title fl-wrap">
                                    <h3>Item Reviews - <span> 3 </span></h3>
                                </div>
                                <div class="reviews-comments-wrap">
                                    <!-- reviews-comments-item -->
                                    <div class="reviews-comments-item">
                                        <div class="review-comments-avatar">
                                            <img src="https://via.placeholder.com/500x500" class="img-fluid" alt="">
                                        </div>
                                        <div class="reviews-comments-item-text">
                                            <h4><a href="#">Josaph Manrty</a><span class="reviews-comments-item-date"><i class="ti-calendar theme-cl"></i>27 Oct 2019</span></h4>

                                            <div class="listing-rating high" data-starrating2="5"><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><span class="review-count">4.9</span> </div>
                                            <div class="clearfix"></div>
                                            <p>" Commodo est luctus eget. Proin in nunc laoreet justo volutpat
                                                blandit enim. Sem felis, ullamcorper vel aliquam non, varius
                                                eget justo. Duis quis nunc tellus sollicitudin mauris. "</p>
                                            <div class="pull-left reviews-reaction">
                                                <a href="#" class="comment-like active"><i class="ti-thumb-up"></i> 12</a>
                                                <a href="#" class="comment-dislike active"><i class="ti-thumb-down"></i> 1</a>
                                                <a href="#" class="comment-love active"><i class="ti-heart"></i>
                                                    07</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--reviews-comments-item end-->

                                    <!-- reviews-comments-item -->
                                    <div class="reviews-comments-item">
                                        <div class="review-comments-avatar">
                                            <img src="https://via.placeholder.com/500x500" class="img-fluid" alt="">
                                        </div>
                                        <div class="reviews-comments-item-text">
                                            <h4><a href="#">Rita Chawla</a><span class="reviews-comments-item-date"><i class="ti-calendar theme-cl"></i>2 Nov May 2019</span>
                                            </h4>

                                            <div class="listing-rating mid" data-starrating2="5"><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star"></i><span class="review-count">3.7</span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <p>" Commodo est luctus eget. Proin in nunc laoreet justo volutpat
                                                blandit enim. Sem felis, ullamcorper vel aliquam non, varius
                                                eget justo. Duis quis nunc tellus sollicitudin mauris. "</p>
                                            <div class="pull-left reviews-reaction">
                                                <a href="#" class="comment-like active"><i class="ti-thumb-up"></i> 12</a>
                                                <a href="#" class="comment-dislike active"><i class="ti-thumb-down"></i> 1</a>
                                                <a href="#" class="comment-love active"><i class="ti-heart"></i>
                                                    07</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--reviews-comments-item end-->

                                    <!-- reviews-comments-item -->
                                    <div class="reviews-comments-item">
                                        <div class="review-comments-avatar">
                                            <img src="https://via.placeholder.com/500x500" class="img-fluid" alt="">
                                        </div>
                                        <div class="reviews-comments-item-text">
                                            <h4><a href="#">Adam Wilsom</a><span class="reviews-comments-item-date"><i class="ti-calendar theme-cl"></i>10 Nov 2019</span></h4>

                                            <div class="listing-rating good" data-starrating2="5"><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star"></i> <span class="review-count">4.2</span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <p>" Commodo est luctus eget. Proin in nunc laoreet justo volutpat
                                                blandit enim. Sem felis, ullamcorper vel aliquam non, varius
                                                eget justo. Duis quis nunc tellus sollicitudin mauris. "</p>
                                            <div class="pull-left reviews-reaction">
                                                <a href="#" class="comment-like active"><i class="ti-thumb-up"></i> 12</a>
                                                <a href="#" class="comment-dislike active"><i class="ti-thumb-down"></i> 1</a>
                                                <a href="#" class="comment-love active"><i class="ti-heart"></i>
                                                    07</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--reviews-comments-item end-->

                                </div>
                            </div>

                            <!-- Submit Reviews -->
                            <div class="edu_wraper">
                                <h4 class="edu_title">Submit Reviews</h4>
                                <div class="review-form-box form-submit">
                                    <form>
                                        <div class="row">

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input class="form-control" type="text" placeholder="Your Name">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input class="form-control" type="email" placeholder="Your Email">
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>Review</label>
                                                    <textarea class="form-control ht-140" placeholder="Review"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-theme">Submit
                                                        Review</button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div> --}}

                    </div>
                </div>

            </div>

            <div class="col-lg-4 col-md-4">

                <!-- Course info -->
                <div class="ed_view_box style_3 border py-3">

                    <div class="ed_view_price pl-4 b-b pb-3">
                        <span>Course Price</span>
                        <h2 class="theme-cl mb-0">{{ !empty($Courses->Currency) ? $Courses->Currency.'  '.$Courses->TotalCost : 'Not Disclosed' }}</h2>

                    </div>
                    <?php
                        $modeofstudy = "Not Disclosed";
                        if($Courses->ModeofStudy === 'full_time'){
                                $modeofstudy = "Full Time" ;
                        }else if($Courses->ModeofStudy === 'part_time'){ 
                                $modeofstudy = "Part Time"; 
                        }else if($Courses->ModeofStudy === 'distance'){
                                $modeofstudy = "Distance"; 
                        }
                    ?>

                    <div class="p-4">
                        <ul class="edu_list right">
                            <li><i class="ti-user"></i>MQF / EQF Level:<strong>{{ !empty($Courses->MqfLevel) ? $Courses->MqfLevel : 'Not Disclosed' }}</strong></li>
                            <li><i class="ti-files"></i>ECTS:<strong>{{ !empty($Courses->Ects) ? $Courses->Ects : 'Not Disclosed' }}</strong></li>
                            <li><i class="ti-user"></i>Duration:<strong>{{ !empty($Courses->Duration) ? $Courses->Duration : 'Not Disclosed' }}</strong></li>
                            <li><i class="ti-game"></i>Intake Month :<strong>{{ !empty($Courses->Intakemonth) ? $Courses->Intakemonth.' - '.$Courses->Intakeyear : 'Not Disclosed' }}</strong></li>

                            <li><i class="ti-flag-alt"></i>Language:<strong>{{ !empty($Courses->Language) ? $Courses->Language : 'Not Disclosed' }}</strong></li>
                            <li><i class="ti-shine"></i>Mode of Study:<strong>{{$modeofstudy}}</strong></li>
                        </ul>
                    </div>
                    <div class="ed_view_link pb-3">

                        @if (session()->has('student_id'))
                        @php $exists = DB::table('student_applied_course')->where('course_id',$Courses->CourseID)->where('student_id',session()->get('student_id'))->where('is_applied','yes')->count();  @endphp

                            @if($exists != 0)
                                <button class="btn btn-outline-theme enroll-btn" style=" cursor: default; "> Applied</button>
                            @else
                                <button class="btn btn-outline-theme enroll-btn actions"  data-is_toggle="yes" data-course_action="apply" data-dashjs='0' data-course_id="{{ base64_encode($Courses->CourseID)}}" data-posted_by='{{base64_encode($Courses->created_by)}}'> Apply <i class="ti-angle-right"></i></a>
                            @endif
                        @else
                            @if (session()->has('institute_id'))  
                                  
                            @else
                                <button class="btn btn-outline-theme enroll-btn stlogincheck"> Apply <i class="ti-angle-right"></i></button>
                            @endif
                        @endif
                    </div>



                </div>

            </div>

        </div>

    </div>
</section>
<!-- ============================ Course Detail ================================== -->
@endsection
@section('js')
<script>

    function downloadBrochure(pdfUrl)
    {
        var filename = pdfUrl.split('/').pop();
        fetch(pdfUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.blob();
        })
        .then(blob => {
            // Create a blob URL and initiate the download
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error('Error during download:', error);
        });
    }

</script>
@endsection