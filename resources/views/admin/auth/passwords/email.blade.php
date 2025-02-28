<html>
  <head>
    <link href="{{asset('css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />
    </head>
    <?php
     $_SESSION['error'] = null;
    ?>
    <body class="authentication-bg position-relative">
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-8 col-lg-10">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6 d-none d-lg-block p-2">
                                    <img src="{{asset('img/login-bg.png')}}" alt="" class="img-fluid rounded h-100">
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex flex-column h-100">
                                        <div class="auth-brand p-4">
                                          
                                                <img src="{{asset('img/angel-jobs-malta-logo.png')}}" alt="logo" height="80">
                                     
                                        </div>
                                        <div class="p-4 my-auto">
                                        <h4 class="fs-20">Forgot Password?</h4>
                                            <p class="text-muted mb-3">Enter your email address and we'll send you an email with instructions to reset your password.</p>


                                            <!-- form -->
                                            <form method="POST" action="{{ route('password.email') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="emailaddress" class="form-label">Email address</label>
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                
                                              
                                                <div class="mb-0 text-start">
                                                    <button class="btn btn-soft-primary w-100" type="submit" style="background-color: #e2f6ff; color: #03A9F4;"><i class="ri-loop-left-line me-1 fw-bold"></i> <span class="fw-bold">Reset Password</span> </button>
                                                </div>

                                            </form>
                                            <!-- end form-->
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

     @include ('layouts.footer')
    </body>

</html>