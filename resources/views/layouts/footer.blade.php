
<?php $ASSET_PATH = env('ASSET_URL').'/' ?>

<!-- Log In Modal -->
<div class="modal fade" id="studentlogin" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
		<div class="modal-content" id="registermodal">
			<span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
			<div class="modal-body">
				<h4 class="modal-header-title"> Student Login</h4>
				<div class="login-form">
					<form id="student_login">

						<div class="form-group">
							<label>Email Address  <span  style="color:red"> *</span> </label>
							<input type="email" class="form-control" placeholder="Email Address" name="email" id="email">
						</div>

						<div class="form-group">
							<label>Password  <span  style="color:red"> *</span> </label>
							<input type="password" class="form-control" placeholder="*****"  name="password" id="password_login">
							<span toggle="#password_login" class="fa fa-fw fa-eye field-icon toggle-password" style="float: right;margin-right: 20px;margin-top: -15px;position: relative;z-index: 2;"></span>

						</div>

						<div class="form-group">
							<button type="submit" id="StudentLogin" class="btn btn-md full-width pop-login">Login</button>
						</div>

					</form>
				</div>

				<div class="social-login mb-3">
					<ul>
						<!-- <li>
							<input id="reg" class="checkbox-custom" name="reg" type="checkbox">
							<label for="reg" class="checkbox-custom-label">Save Password</label>
						</li> -->
						<li style="text-align: right;"><a data-toggle="modal" data-target="#studentforget" data-dismiss="modal" class="theme-cl" >Forgot Password?</a></li>
					</ul>
				</div>

				<div class="text-center">
					<p class="mt-2">New to Ustudious? 
						<!-- <button onclick="myFunction()"> -->
						<a href="#"  data-toggle="modal" data-target="#studentsignup" class="mod-close" data-dismiss="modal" style="color: #2b3990;">Register here</a>
					<!-- </button> -->
				</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="studentforget" tabindex="-1" role="dialog" aria-labelledby="forgetmodal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
		<div class="modal-content" id="forgetmodal">
			<span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
			<div class="modal-body">
				<h4 class="modal-header-title"> Student Login</h4>
				<div class="login-form">
					<form class="resetPassData">

						<div class="form-group">
							<label>Email Address</label>
							<input type="text" class="form-control" placeholder="Register Email Address" name="email" >
						</div>
						<input name="passtype" value="{{ base64_encode('student')}}" type="hidden" >

						<div class="form-group">
							<input type="submit" class="btn btn-md full-width pop-login" id="resetPass" value="Reset Password" fdprocessedid="jvftbh">
						</div>

					</form>
				</div>

				<div class="social-login mb-3">
					<ul>
						<!-- <li>
							<input id="reg" class="checkbox-custom" name="reg" type="checkbox">
							<label for="reg" class="checkbox-custom-label">Save Password</label>
						</li> -->
						<li style="text-align: right;"><a href="student-forget-password.php" class="theme-cl" >Forgot Password?</a></li>
					</ul>
				</div>

				<div class="text-center">
					<p class="mt-2">New to Ustudious? 
						<!-- <button onclick="myFunction()"> -->
						<a href="#"  data-toggle="modal" data-target="#studentsignup" class="mod-close" data-dismiss="modal" style="color: #2b3990;">Register here</a>
					<!-- </button> -->
				</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Modal -->

<!-- Sign Up Modal -->
<div class="modal fade student-register-sec" id="studentsignup" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
		<div class="modal-content" id="sign-up">
			<span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
			<div class="modal-body">
				<h4 class="modal-header-title">Student Register</h4>
				<div class="login-form">
					<form id="studentregister">

						<div class="form-group">
							<input type="text" class="form-control" placeholder="First Name (*) " name="first_name">
						</div>

						<div class="form-group">
							<input type="text" class="form-control" placeholder="Last Name (*)" name="last_name">
						</div>

						<div class="form-group">
							<input type="email" class="form-control" placeholder="Email Address (*)" name="email" id="email_address">
						</div>

						<div class="form-group">
						<?php $countryData = DB::table('country_master')->get(); ?>
							<select class="form-control"name="student_country_id" id="student_country_id" required>
								<option value="">Select Country (*)</option>
								@foreach ($countryData as $data)
									<option value="{{ $data->CountryID }}">{{ $data->CountryName }}</option>
								@endforeach
							</select>										</div>

						<div class="form-group" style="display: flex;">
							<div style="margin-right: 5px; width: 125px;">
								<input type="text" class="form-control student_country_code" id="student_country_code" placeholder="Country Code  (*)" name="student_country_code">
							</div>
							
							<div style="width: 100%; margin-left: 7px;">
								<input type="text" class="form-control" placeholder="Mobile Number  (*) " name="mobile" id="mobile" required>
							</div>
						</div>


						<div class="form-group">
							<input type="password" placeholder="Password (*) " name="password" id="password" class="form-control" required>
							<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" style="float: right;margin-right: 20px;margin-top: -15px;position: relative;z-index: 2;"></span>

						</div>

						<div class="form-group">
							<input type="password" placeholder="Confirm Password (*)" name="confirm_password" id="confirm_password" class="form-control" required>
							<span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password" style="float: right;margin-right: 20px;margin-top: -15px;position: relative;z-index: 2;"></span>
							<span id="passwordError" class="error"></span>
						</div>


						<div class="form-group">
							<button type="submit" id="StudentRegister" class="btn btn-md full-width pop-login">Register</button>
						</div>

					</form>
				</div>
				<div class="text-center">
					<p class="mt-3"><i class="ti-user mr-1"></i>Already have an account? 
						<!-- <button onclick="myFunction()"> -->
						<a href="#" data-toggle="modal" data-target="#studentlogin" class="mod-close" data-dismiss="modal" style="color: #2b3990;">Login Here</a>
						<!-- </button> -->
						</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Modal -->
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


<!-- ============================ Footer Start ================================== -->
<footer class="dark-footer skin-dark-footer">
	<div>
		<div class="container">
			<div class="row">

				<div class="col-lg-3 col-md-3">
					<div class="footer-widget">
						<img src="{{$ASSET_PATH}}img/ustudious-logo-white.png" class="img-footer" alt="" />
						<div class="footer-add">
							<p>At USTUDIOUS, we are more than just an educational portal; we are a catalyst for transformation, inspiring individuals to reach new heights and achieve their dreams.

							</p>
							<!-- <p>503, 5th Floor, Chandak Chambers, Near Western Express Highway, Andheri East, Mumbai - 400069</p> -->
							<!-- <p>+123 4567 890</p> -->
							<p><a href="mailto:info@ustudious.com">info@ustudious.com</a></p>
						</div>

					</div>
				</div>
				<div class="col-lg-3 col-md-3">
					<div class="footer-widget">
						<h4 class="widget-title">Navigations</h4>
						<ul class="footer-menu">
							<li><a href="{{route('about')}}">About Us</a></li>
							{{-- <li><a href="faq.html">FAQs Page</a></li>
							<li><a href="checkout.html">Checkout</a></li> --}}
							{{-- <li><a href="blog.html">Blog</a></li> --}}
						</ul>
					</div>
				</div>

				<div class="col-lg-3 col-md-3">
					<div class="footer-widget">
						<h4 class="widget-title">New Categories</h4>
						<?php $InstitutewiseCourse = DB::table('course')->select('course.*')->select('CourseName','CourseID')->whereNull('course.deleted_at')->where('CourseStatus', 'Active')->where('course.ApprovalStatus', 'Approved')->whereNull('course.deleted_at')
                			->orderby('CourseID','Desc')->take(5)->get(); ?>
						<ul class="footer-menu">
							@foreach($InstitutewiseCourse as $List)
							<li><a href="{{route('course-details',base64_encode($List->CourseID))}}">{{$List->CourseName}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>

				<div class="col-lg-3 col-md-3">
					<div class="footer-widget">
						<h4 class="widget-title">Help & Support</h4>
						<ul class="footer-menu">
							{{-- <li><a href="#">Documentation</a></li>
							<li><a href="#">Live Chat</a></li>
							<li><a href="#">Mail Us</a></li>
							<li><a href="#">Privacy</a></li>
							<li><a href="#">Faqs</a></li> --}}
							<li><a href="{{route('contact')}}">Contact</a></li>
						</ul>
					</div>
				</div>



			</div>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="container">
			<div class="row align-items-center">

				<div class="col-lg-6 col-md-6">
					<p class="mb-0">© @php echo date("Y"); @endphp Ustudious.</p>
				</div>

				<div class="col-lg-6 col-md-6 text-right">
					<ul class="footer-bottom-social">
						<li><a><i class="ti-facebook"></i></a></li>
						<li><a>
							{{-- <i class="ti-twitter-alt"></i> --}}
							<i class="bi bi-twitter-x"></i>
						</a></li>
						<li><a><i class="ti-instagram"></i></a></li>
						<li><a><i class="ti-linkedin"></i></a></li>
					</ul>
				</div>

			</div>
		</div>
	</div>
</footer>
<!-- ============================ Footer End ================================== -->


<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>


</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{$ASSET_PATH}}js/jquery.min.js"></script>
<script src="{{$ASSET_PATH}}js/popper.min.js"></script>
<script src="{{$ASSET_PATH}}js/bootstrap.min.js"></script>
<script src="{{$ASSET_PATH}}js/select2.min.js"></script>
<script src="{{$ASSET_PATH}}js/slick.js"></script>
<script src="{{$ASSET_PATH}}js/jquery.counterup.min.js"></script>
<script src="{{$ASSET_PATH}}js/counterup.min.js"></script>
<script src="{{$ASSET_PATH}}js/custom.js"></script>


<script src="{{$ASSET_PATH}}js/dropzone.js"></script>

<script src="{{asset('js/common.js')}}"></script>
<script src="{{$ASSET_PATH}}js/common.js"></script>

<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
<script src="{{asset('js/student.js')}}"></script>
{{-- <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script> --}}

<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->

<!-- Browse courses filter responsive -->
<script>
	function openNav() {
	  document.getElementById("filter-sidebar").style.width = "320px";
	}

	function closeNav() {
	  document.getElementById("filter-sidebar").style.width = "0";
	}

	
</script>


<!-- Date Booking Script -->
<script src="{{$ASSET_PATH}}js/moment.min.js"></script>
<script src="{{$ASSET_PATH}}js/daterangepicker.js"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<script src="{{$ASSET_PATH}}js/metisMenu.min.js"></script>	
<script>
	$('#side-menu').metisMenu();
</script>

<script>
		// Course Expire and Start Daterange Script
	$(function() {
		$('input[name="edu-expire"]').daterangepicker({
		singleDatePicker: true,
		});
		$('input[name="edu-expire"]').val('');
		$('input[name="edu-expire"]').attr("placeholder","Course Expire");
	});
	$(function() {
		$('input[name="edu-start"]').daterangepicker({
		singleDatePicker: true,
		
		});
		$('input[name="start"]').val('');
		$('input[name="start"]').attr("placeholder","Course Start");
	});
</script>


<!-- College Gallery Campus Photos Pop-up Gallery JS  -->
<script>
	$(document).ready(function() {

	// required elements
	var imgPopup = $('.img-popup');
	var imgCont  = $('.container__img-holder');
	var popupImage = $('.img-popup img');
	var closeBtn = $('.close-btn');

	// handle events
	imgCont.on('click', function() {
	var img_src = $(this).children('img').attr('src');
	imgPopup.children('img').attr('src', img_src);
	imgPopup.addClass('opened');
	});

	$(imgPopup, closeBtn).on('click', function() {
	imgPopup.removeClass('opened');
	imgPopup.children('img').attr('src', '');
	});

	popupImage.on('click', function(e) {
	e.stopPropagation();

	
	

	});

});
</script>





