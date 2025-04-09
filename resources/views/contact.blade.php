@extends('layouts.main')
@section('content')
<script async src="https://www.google.com/recaptcha/api.js"></script>
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
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
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
                                            <label>Name<span style="color:red"> *</span></label>
                                            <input type="text" class="form-control simple" name="name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Email <span style="color:red"> *</span></label>
                                            <input type="email" class="form-control simple" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="form-group col-md-6">
                                        <label> Select Country  <span  style="color:red"> *</span> </label>
                                        <?php $countryData = DB::table('country_master')->get(); ?>
                                       <select class="form-control" name="institute_country" id="institute_country" >
                                            <option value="">Select Country</option>
                                            @foreach ($countryData as $data)
                                                <option value="{{ $data->CountryID }}">{{ $data->CountryName }}</option>
                                            @endforeach
                                        </select>  
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div>
                                            <label>Mobile Number</label>
                                        </div>
                                        <div style="display:flex;">
                                           
                                            <input type="text" class="form-control country_code" id="country_code" placeholder="Country Code" name="country_code" style="width: 23%;margin-right: 6PX;" value="" readonly>
                                           <input type="number" class="form-control" name="contact_mobile" value="" placeholder="Contact Mobile">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label>Subject <span style="color:red"> *</span></label>
                                    <input type="text" class="form-control simple" name="subject">
                                </div>

                                <div class="form-group">
                                    <label>Message <span style="color:red"> *</span></label>
                                    <textarea class="form-control simple" name="message"></textarea>
                                </div>

                                <div class="g-recaptcha mt-4 mb-3" data-sitekey={{env('GOOGLE_SITE_KEY')}}></div>

                                <div class="form-group">
                                    {{-- <input type="submit" class="btn btn-primary" class="ContactSubmit" value="Submit">
                                <button class="btn btn-theme"  class="ContactSubmit" type="submit">Submit Request</button> --}}
                                    <div class="form-group col-lg-12 col-md-12">
                                        <button class="btn btn-theme ContactSubmit" type="submit" id="ContactSubmit">Submit
                                            Request</button>
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
                                        <p>503, 5th Floor, Chandak Chambers, Near Western Express Highway, Andheri East,
                                            Mumbai - 400069</p>
                                    </div>
                                </div>

                                <div class="cn-info-detail">
                                    <div class="cn-info-icon">
                                        <i class="ti-email"></i>
                                    </div>
                                    <div class="cn-info-content">
                                        <h4 class="cn-info-title">Drop a Mail</h4>
                                        <p><a href="mailto:info@ustudious.com">info@ustudious.com</a></p>
                                    </div>
                                </div>

                                <div class="cn-info-detail">
                                    <div class="cn-info-icon">
                                        <i class="ti-mobile"></i>
                                    </div>
                                    <div class="cn-info-content">
                                        <h4 class="cn-info-title">Call Us</h4>
                                        <p><a href="tel:+123 4567 890">+123 4567 890</a></p>
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
@section('js')

<script>
     $('#institute_country').on('change', function () {
        var idCountry = this.value;
        $.ajax({
            url: "{{url('institute/fetch-states')}}",
            type: "POST",
            data: {
                country_id: idCountry,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                $("#country_code").val('+'+result.countrycode[0]['CountryCode']);
                $(".country_codes").val('+'+result.countrycode[0]['CountryCode']);
              
            }


     });

    });
</script>
@endsection