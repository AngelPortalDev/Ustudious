@extends('layouts.main')
@section('content')
<?php $ASSET_PATH = env('ASSET_URL').'/' ?>


        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper" class="py-5">
		
            <!-- ========================== SignUp Elements ============================= -->
			<section class="log-space">
				<div class="container">
					<form  class="resetPassData">
					<div class="row justify-content-center">
						
						<div class="col-lg-11 col-md-11">

							<div class="row no-gutters position-relative log_rads">
								<div class="col-lg-6 col-md-5 bg-cover" style="background:#1f2431 url({{$ASSET_PATH}}img/log.png)no-repeat;">

								</div>
								
									<div class="col-lg-6 col-md-7 position-static p-4">
										<div class="log_wraps">
											<div class="log__heads">
												<h4 class="mt-0 logs_title">Password <span class="theme-cl">Recovery</span></h4>
											</div>
											
											<div class="form-group">
												<label>Email Address</label>
												<input type="text" class="form-control" placeholder="Register Email Address" name="email" >
											</div>
											<input name="passtype" value="{{ base64_encode('institute')}}" type="hidden" >
											<div class="form-group">
												{{-- <a href="index.php" class="btn btn_apply w-100">Reset Password</a>
												<button class="btn btn_apply w-100"  id="resetPass">Reset Password</button> --}}
												<input type="submit" class="btn btn-md full-width pop-login" id="resetPass" value="Reset Password">

											</div>
											
										</div>
									</div>
								
							</div>
						
						</div>
						
					</div>
				</form>
				</div>
			</section>
			<!-- ========================== Login Elements ============================= -->
			

		</div>
		<!-- ============================================================== -->
		<!-- End Wrapper -->
		<!-- ============================================================== -->

		
				
<!-- Footer file include -->
@endsection