<html>
  <head>
    <link href="{{asset('css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />
    </head>
    <?php
     $_SESSION['error'] = null;
     $ASSET_PATH = env('ASSET_URL').'/'
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
                                          
                                                <img src="{{$ASSET_PATH}}img/ustudious-logo.png" alt="logo" height="80">
                                     
                                        </div>
                                        <div class="p-4 my-auto">
                                            <h4 class="fs-20">Log In</h4>
                                            <p class="text-muted mb-3">Enter your email address and password to access
                                                account.
                                            </p>

                                            <!-- form -->
                                            <form method="POST" action="{{ route('admin.login') }}">
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
                                                <div class="mb-3">
                                                    @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}" class="text-muted float-end"><small>{{ __('Forgot Your Password?') }}</small></a>
                                                    @endif
                                                    <label for="password" class="form-label">Password</label>
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                                        <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                                        <label class="form-check-label" for="checkbox-signin">{{ old('remember') ? 'checked' : '' }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-0 text-start">
                                                    <button class="btn btn-soft-primary w-100" type="submit" style="background-color: #e2f6ff; color: #03A9F4;"><i class="ri-login-circle-fill me-1"></i> <span class="fw-bold"> {{ __('Login') }}</span> </button>
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

       @include ('admin.layouts.footer')


    </body>

</html>