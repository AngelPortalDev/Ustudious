@extends('layouts.main')
@section('content')
<!-- ============================ Agency List Start ================================== -->
<section class="bg-light">

    <div class="container">

        <!-- row Start -->
        <div class="row">
            <div class="col-lg-12 col-md-12">

                <div class="breadcrumbs-wrap">
                    <h1 class="breadcrumb-title">Contact Us</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact</li>
                        </ol>
                    </nav>
                </div>

            </div>

            <div class="col-lg-8 col-md-7 d-flex">
                <div class="prc_wrap">
            
                        <div class="prc_wrap-body">
                            <form id="contactForm">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control simple" name="name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control simple" name="email"> 
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" class="form-control simple" name="subject">
                            </div>

                            <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control simple" name="message"></textarea>
                            </div>

                            <div class="form-group">
                                {{-- <input type="submit" class="btn btn-primary" class="ContactSubmit" value="Submit">
                                <button class="btn btn-theme"  class="ContactSubmit" type="submit">Submit Request</button> --}}
                                <div class="form-group col-lg-12 col-md-12">
                                    <button class="btn btn-theme ContactSubmit" type="submit" id="ContactSubmit" >Submit Request</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    
                </div>

            </div>

            <div class="col-lg-4 col-md-5 d-flex">

                <div class="prc_wrap">

                    <div class="prc_wrap_header">
                        <h4 class="property_block_title">Reach Us</h4>
                    </div>

                    <div class="prc_wrap-body">
                        <div class="contact-info">


                            <div class="cn-info-detail">
                                <div class="cn-info-icon">
                                    <i class="ti-home"></i>
                                </div>
                                <div class="cn-info-content">
                                    <h4 class="cn-info-title">Address</h4>
                                    <p>503, 5th Floor, Chandak Chambers, Near Western Express Highway, Andheri East, Mumbai - 400069</p>
                                </div>
                            </div>

                            <div class="cn-info-detail">
                                <div class="cn-info-icon">
                                    <i class="ti-email"></i>
                                </div>
                                <div class="cn-info-content">
                                    <h4 class="cn-info-title">Drop a Mail</h4>
                                    <p>info@ustudious.com</p>
                                </div>
                            </div>

                            <div class="cn-info-detail">
                                <div class="cn-info-icon">
                                    <i class="ti-mobile"></i>
                                </div>
                                <div class="cn-info-content">
                                    <h4 class="cn-info-title">Call Us</h4>
                                    <p>+123 4567 890</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- /row -->

    </div>

</section>
<!-- ============================ Agency List End ================================== -->
@endsection