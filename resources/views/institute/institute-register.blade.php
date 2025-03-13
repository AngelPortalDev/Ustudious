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
								<div class="col-lg-6 col-md-5 bg-cover" style="background:#2b3990 url({{$ASSET_PATH}}img/institite-signup-bg.png)no-repeat;border-radius: 10px;">

								</div>
								<div class="col-lg-6 col-md-7 position-static p-4">
                                    <form href="#" id="instituteregister">
									<div class="log_wraps">
										<div class="log__heads">
											<h4 class="mt-0 logs_title">Institute <span class="theme-cl">Register</span></h4>
										</div>
										
										<div class="form-group">
											<input type="text" class="form-control" placeholder="Institute Name (*)"  name="institute_name" required>
										</div>
										<div class="form-group">
											<input type="text" class="form-control" placeholder="First Name  (*)" name="first_name" required>
										</div>
				
										<div class="form-group">
											<input type="text" class="form-control" placeholder="Last Name  (*)" name="last_name" required>
										</div>
				
										<div class="form-group">
											<input type="email" class="form-control" placeholder="Email Address  (*)" name="email_address" id="email_address" required>
										</div>

										<div class="form-group">
											<?php $countryData = DB::table('country_master')->get(); ?>
											<select class="form-control"name="country_id" id="country_id" required>
												<option value="">Select Country (*)</option>
												@foreach ($countryData as $data)
													<option value="{{ $data->CountryID }}">{{ $data->CountryName }}</option>
												@endforeach
											</select>										</div>
				
										<div class="form-group" style="display: flex;">
											<div style="margin-right: 5px; width: 125px;">
												<input type="text" class="form-control country_code" id="country_code" placeholder="Country Code  (*)" name="country_code">
										    </div>
											
											<div style="width: 100%; margin-left: 7px;">
												<input type="number" class="form-control" placeholder="Mobile Number  (*) " name="mobile" id="mobile" required>
												<span id="mob_exists_error" style="color:red;display:none;">
													<small><i>Mobile no is already exist</i></small>
												</span>
											</div>
										</div>
				
				
				
										<div class="form-group" style="position: relative">
                                            <input type="password" placeholder="Password  (*)" name="password" id="password" class="form-control" required>
                                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password show-password-eye"  ></span>

										</div>
				
										<div class="form-group"  style="position: relative">
                                            <input type="password" placeholder="Confirm Password  (*)" name="confirm_password" id="confirm_password" class="form-control" required>
                                            <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password show-password-eye"></span>
                                            <span id="passwordError" class="error"></span>
										</div>

                                         <br>
										<div class="form-group">
											<button type="submit" class="btn btn-md full-width pop-login" id="InstituteRegister">Register</button>
										</div>

									</div>
                                    </form>
                                    <div class="form-group text-center mb-0 mt-3">
                                        Already have an account? <a href="{{route('institute-login')}}" class="theme-cl">Login Here</a>
                                    </div>
								</div>
                               
							</div>
						
						</div>
					</div>
				</div>
			</section>
			<!-- ========================== Login Elements ============================= -->
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

		</div>
		<!-- ============================================================== -->
		<!-- End Wrapper -->
		<!-- ============================================================== -->

		
<!-- Footer file include -->
@endsection
@section('js')
<script>
$(document).ready(function(){
 

	$('#country_id').on('change', function () {
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
                $(".country_code").val('+'+result.countrycode[0]['CountryCode']);

            }
        });
	});


});
</script>
@endsection