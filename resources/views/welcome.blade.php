<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome to SOIS - Accomplishment Report</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('fontawesome-free-5.15.4/js/all.min.js') }}" defer></script>
    
    <!-- Icons -->
    <link href="{{ asset('fontawesome-free-5.15.4/css/all.min.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/master.css') }}" rel="stylesheet" type="text/css">
    
</head>
<body>
    <div id="app">
        <header class="header"> Student Organization Accomplishment Report</header>
        <div class="banner"> 
            <div class="banner-box">
                <img src="/images/erg_logo.png" alt="ERG Logo">
            </div>
            <div class="banner-box">
                <img src="/images/pupukaw_logo.png" alt="PUPUKAW Logo">
            </div>
            <div class="banner-box">
                <img src="/images/mentors_logo.png" alt="Mentors Logo">
            </div>
            <div class="banner-box">
                <img src="/images/jpmap_logo.png" alt="JPMAP Logo">
            </div>
            <div class="banner-box">
                <img src="/images/jma_logo.png" alt="JMA Logo">
            </div>
           <div class="banner-box">
                <img src="/images/aeces_logo.png" alt="AECES Logo">
            </div>
            <div class="banner-box">
                <img src="/images/csc_logo.png" alt="CSC Logo">
            </div>
            <div class="banner-box">
                <img src="/images/cs_logo.png" alt="CS Logo">
            </div>
            <div class="banner-box">
                <img src="/images/jpia_logo.png" alt="JPIA Logo">
            </div>
            <div class="banner-box">
                <img src="/images/jpsme_logo.png" alt="JPSME Logo">
            </div>
            <div class="banner-box">
                <img src="/images/pasoa_logo.png" alt="PASOA Logo">
            </div>
            <div class="banner-box">
                <img src="/images/rec_logo.png" alt="REC Logo">
            </div>
            <div class="banner-box">
                <img src="/images/irock_logo.png" alt="iRock Logo">
            </div>
        </div>
        <div class="container">
                <div class="greeting"> 
                    <div>
                        <img src="/images/pupt_logo.png" alt="PUP Taguig Logo">
                        <h2 class="welcome">Welcome</h2>
                        <h1 class="welcome">PUPTIAN</h1>
                        <div class="tutorial">
                            <i class="fab fa-youtube"></i>
                            <a href="#">Guide on how to use the Student Organization <br>Accomplishment Report System.</a>
                        </div>
                    </div>
                </div>
                @guest
                <div class="login-content">
                    <form method="POST" action="{{ route('login') }}">
                    @csrf
                        <h2 class="title">Sign In</h2>
                        <div class="input-div one">
                           <div class="i">
                                <i class="fas fa-user"></i>
                           </div>
                           <div class="div">
                                <h5>Username</h5>
                                <input id="email" type="email" class="input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" >
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="input-div pass">
                           <div class="i"> 
                                <i class="fas fa-lock"></i>
                           </div>
                           <div class="div">
                                <h5>Password</h5>
                                <input id="password" type="password" class="input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                     @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                           </div>
                        </div>
                        <button type="submit" class="btn" value="Continue">
                            {{ __('Continue') }}
                        </button>
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </form>
                </div>
                @else
                <div class="row">
                    <div class="col">
                        <a href="/home">
                            <button class="btn btn-primary">Home</button>  
                        </a>
                    </div>
                </div>
                @endguest
        </div>
        
    </div>
    <footer class="footer">
        <p>By using this service, you understood and agree to the PUP Taguig Online Services<br> 
            <a href="#" class="text-primary">Terms of Use</a> 
            and 
            <a href="#" class="text-primary">Privacy Statement.</a>
        </p>
    </footer>

    <script type="text/javascript" src="js/login.js"></script>
    
</body>
</hmtl>
