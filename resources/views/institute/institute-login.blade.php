<!-- Header file include -->
@extends('layouts.main')
@section('content')
<?php $ASSET_PATH = env('ASSET_URL').'/' ?>


<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper " class="py-5">

    <!-- ========================== SignUp Elements ============================= -->
    <section class="log-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-md-11">

                    <div class="row no-gutters position-relative log_rads">
                        <div class="col-lg-6 col-md-5 bg-cover"
                            style="background:#2b3990 url({{$ASSET_PATH}}img/institite-signup-bg.png)no-repeat;border-radius: 10px;">

                        </div>

                        <div class="col-lg-6 col-md-7 position-static p-4">
                            
                            <form href="#" id="institute_login">
                                <div class="log_wraps">
                                    <div class="log__heads">
                                        <h4 class="mt-0 logs_title">Institute <span class="theme-cl">Login</span></h4>
                                    </div>

                                    <div class="form-group">
                                        <label>Email Address <span  style="color:red"> *</span> </label>
                                        <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                                    </div>
                                    <div class="form-group" style="position: relative">
                                        <label>Password <span  style="color:red"> *</span> </label>
                                        <input type="password" class="form-control" placeholder="*******" name="password" id="password"  required>
                                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password show-password-eye" style="top:50px;" ></span>
                                    </div>

                                    <div class="form-group">
                                        
                                        <button type="submit" class="btn btn-md full-width pop-login" id="InstituteLogin">Login</button>
                                        <a href="{{route('institute-forgot-password')}}" class="elio_right pt-1">Forgot
                                            Password?</a>
                                    </div>

                                </div>
                            </form>
                            
                            <div class="form-group text-center mb-0 mt-3">
                                Don't have an account? <a href="{{route('institute-register')}}" class="theme-cl"> Register
                                    Here</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-md" style="top:20%;">
                <div class="modal-content">
                    <div class="modal-body" >
                     <br>
                        <div id="checkicon" style="font-size:65px;text-align: center;color:green"></div>
                        <div id="checkiconcross" style="font-size:65px;text-align: center;color:red"></div>
                        <br><br>
                        <div id="message" style="text-align: center;font-size:35px;"></div>
                    </div>
                    <br><br>
                    <div class="text-end"  style="margin-left:80%">
                     <button type="button" class="btn btn-primary"  id="CloseModal" style="width:65px;margin-right:30%">Ok</button>
                    </div>
                    <br><br>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->
    </section>
    <!-- ========================== Login Elements ============================= -->


</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->


<!-- Footer file include -->
@endsection