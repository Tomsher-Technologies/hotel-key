<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="robots" content="noindex" />
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/font/iconsmind-s/css/iconsminds.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-css.css') }}">
    <link rel="shortcut icon" href="img/favicon.ico" />
</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-lg-6 col-md-12 col-sm-12 mx-auto align-self-center">
                    <div class="login-form">
                        <div class="text-center">
                        <i class="iconsminds-lock-2" style="font-size: 50px;"></i>
                            <h3 class="title">Reset Password</h3>
                            <!-- <p>Sign in to your account to start using Hotel Key</p> -->
                        </div>
                        @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('reset.password.post.app') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-4">
                                <label class="mb-1 text-dark">Email</label>
                                <input type="text" id="email_address" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                  @if ($errors->has('email'))
                                  <div class="alert alert-danger"><strong>{{ $errors->first('email') }}</strong></div>
                                  @endif
                            </div>

                            
                            <div class="mb-4">
                                <label class="mb-1 text-dark">Password</label>
                                <input type="password" id="password" class="form-control" name="password" required autofocus>
                                 
                                  @if ($errors->has('password'))
                                  <div class="alert alert-danger"><strong>{{ $errors->first('password') }}</strong></div>
                                  @endif
                            </div>

                            <div class="mb-4">
                                <label class="mb-1 text-dark">Confirm Password</label>
                                <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                                  @if ($errors->has('password_confirmation'))
                                  <div class="alert alert-danger"><strong>{{ $errors->first('password_confirmation') }}</strong></div>
                                  @endif
                            </div>
                           
                            
                            <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary light btn-block">
                            Reset Password
                              </button>
                                
                            </div>
                        
                        </form>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="pages-left h-100">
                        <div class="login-content">
                            <a href="#"><img src="{{ asset('assets/images/logo.png') }}" class="mb-3 logo-size" alt=""></a>

                            <p>Your true value is determined by how much more you give in value than you take in
                                payment. ...</p>
                        </div>
                        <div class="login-media text-center">
                            <img src="{{ asset('assets/images/login.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
	Scripts
***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('assets/js/global.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/deznav-init.js') }}"></script>
</body>

</html>