@extends('layouts.main')
@section('content')

<!-- Content -->
<div class="page-content bg-white">

        <!-- contact area -->
        <div class="section-full content-inner browse-job bg-white shop-account">
            <!-- Product -->
            <div class="container">
                <div class="row">
					<div class="col-md-12 m-b30">
						<div class="card max-w500 radius-sm m-auto">
							<div class="tab-content">
								<form class="tab-pane active ChangePasswordData">
									<h4 class="font-weight-700 m-b5">RESET YOUR PASSWORD  </h4>
									<p class="font-weight-600"></p>
								
									<div class="form-group">
										<label class="font-weight-700">New Password *</label>
										<input name="newpass" id="new_pass" required="" class="form-control " placeholder="New Password" type="password">
										<span id="new_pass_error" style="color:red;display:none;">
										<small>
											<i>Please Provide Required New Password </i>
										</small></span>
										<span id="new_pass_error2" style="color:red;display:none;">
										<small>
											<i>Password Should be Atleast 8 Character with AlphaNumeric & Spec.Char (e.g Abc@12345) </i>
										</small>
									</span>
										<input name="passType1" required="" type="text" value="{{$data['enc_cat']}}" hidden>
										<input name="passType2" required="" type="text" value="{{$data['enc_email']}}" hidden>
										<input name="passType3" required="" type="text" value="{{$data['token']}}" hidden>
									</div>
									<div class="form-group">
										<label class="font-weight-700">Confirm New Password *</label>
										<input name="newpasscon" required="" id="confirm_pass" class="form-control " placeholder="Confirm New Password" type="password">
											<span id="conf_pass_error1" style="color:red;display:none;">
												<small>
													<i>Please Provide Required Confirm Password </i>
												</small>
											</span>
											<span id="conf_pass_error2" style="color:red;display:none;">
												<small>
													<i>Confirm Password Doesn't Match </i>
												</small>
											</span>
									</div>
									<div class="text-left">
										<button class="site-button button-lg outline outline-2 resetNewPassword" type="button" >Reset</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
            <!-- Product END -->
		</div>
		<!-- contact area  END -->



<!-- Import footer  -->
@endsection()