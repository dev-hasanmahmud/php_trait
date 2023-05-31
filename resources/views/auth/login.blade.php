<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EMCRP | Login</title>

    <!-- FONTAWESOME -->
    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" /-->
    <link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/font-awesome.min.css') }}" />
    <!-- FONTAWESOME -->

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="{{ custom_asset('assets/css/cdn/bootstrap.min.css') }}" />
    <!-- BOOTSTRAP -->

    <link rel="stylesheet" href="{{ custom_asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ custom_asset('assets/css/responsive.css') }}" />
</head>

<body>
    <div class="login-bg">
        <div class="login-box">
            <div class="row justify-content-center">

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pad-right">

                    <div class="left-box">
                        <div class="logo-box">
                            <img src="{{ custom_asset('assets/images/logo.png') }}" alt="" />
                        </div>
                        <div class="login-title">
                            <h2>Welcome To <span>EMCRP (DPHE Part)</span></h2>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="">Email *</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" autofocus placeholder="example@gmail.com" />
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password *</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="********" />
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group form-check d-flex w-100">
                                <div class="remember-box w-50">
                                    <label class="">Remember me
                                        <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                                {{-- @if (Route::has('password.request'))
                                    <div class="forget-pwd-box w-50 text-right">
                                        <a href="{{ route('password.request') }}">Forget Password?</a>
                            </div>
                            @endif --}}

                    </div>
                    <button type="submit" class="btn">Login</button>


                    <div style="padding-left: 0px!important;" class="mb-0 mt-4 form-group form-check d-flex w-100">
                        <div class=" w-50">
                            <label style="display: flex; margin-bottom: 0px;">Download Now
                                <!-- <a href="http://139.59.91.209/EMCRP_release_v1.1.0.apk" class="g-play-icon"> </a>
                     -->
                                <a download href="{{ asset('/android/EMCRP_release_new_v1.1.0.apk')}}" class="g-play-icon"> </a>
                            </label>
                        </div>
                        <!--div class="w-50 text-right">
                    <label style="display: flex; margin-bottom: 0px; float: right;" >Developed by : 
                      <a href="https://www.creativesofttechnology.com/" target="_blank"> <img class="ml-1" src="{{ custom_asset('assets/images/cst-logo.png') }}" alt="" /> </a>
                    </label>
                  </div-->

                    </div>


                    </form>

                    <div class="lock-box">
                        <img src="{{ custom_asset('assets/images/lock.png') }}" alt="" />
                        <!-- <i class="fa fa-lock"></i> -->
                    </div>

                    <!-- <p class="copy-right">Copyright &copy; All Rights Reserved</p> -->
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pl-0 small-none">
                <div class="right-box text-center">
                    <div class="logo-box">
                        <img src="{{ custom_asset('assets/images/logo.png') }}" alt="" />
                    </div>

                    <p>
                        Emergency Multi-Sector Rohingya Crisis Response Project (EMCRP)
                    </p>

                    <div class="content-img">
                        <img src="{{ custom_asset('assets/images/login.png') }}" alt="" />
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- ///////////////////////////////////// CDN ///////////////////////////////////////// 
    <script src="{{ custom_asset('js/cdn/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ custom_asset('js/cdn/popper.min.js') }}"></script>
    <script src="{{ custom_asset('js/cdn/bootstrap.min.js') }}"></script>
     ///////////////////////////////////// CDN ///////////////////////////////////////// -->

    <!--script src="{{ custom_asset('js/main.js') }}"></script-->
</body>

</html>