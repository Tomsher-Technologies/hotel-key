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
                            <h3 class="title">Sign In</h3>
                            <p>Sign in to your account to start using Hotel Key</p>
                        </div>
                        @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login.custom') }}" autocomplete="off">
                            @csrf
                            <div class="mb-4">
                                <label class="mb-1 text-dark">Email</label>
                                <input type="email" class="form-control form-control"  value="{{ old('email') }}" name="email" id="email" >
                            </div>
                            <div class="mb-4 position-relative">
                                <label class="mb-1 text-dark">Password</label>
                                <input type="password"  autocomplete="new-password" id="dz-password" class="form-control form-control"  value="{{ old('password') }}" type="password" name="password">
                                <span class="show-pass eye">
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                            <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                <div class="mb-4">
                                    <div class="form-check custom-checkbox mb-3">
                                        <input type="checkbox" class="form-check-input" id="customCheckBox1">
                                        <label class="form-check-label mt-1" for="customCheckBox1">Remember my
                                            preference</label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <a href="{{ route('forget.password.get') }}" class="btn-link text-primary">Forgot
                                        Password?</a>
                                </div>
                            </div>
                            <div class="justify-content-between align-items-center mb-1">
                                @if ($errors->has('email'))
                                <div class="alert alert-danger"><strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                                
                                @if ($errors->has('password'))
                                    <div class="alert alert-danger"><strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                                @if(session()->has('status'))
                                    <div class="alert alert-danger">
                                        <strong>{{ session()->get('status') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-primary light btn-block">Sign In</button>
                            </div>
<!--                            
                            <p class="text-center">Not registered?
                                <a class="btn-link text-primary" href="page-register.html">Register</a>
                            </p> -->
                        </form>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="pages-left h-100">
                        <div class="login-content">
                            <a href="{{ route('login') }}"><img src="{{ asset('assets/images/logo.png') }}" class="mb-3 logo-size" alt=""></a>

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