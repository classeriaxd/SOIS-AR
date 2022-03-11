<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

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
    <link href="{{ asset('css/aboutUsCSS.css') }}" rel="stylesheet" type="text/css">
</head>
<body style="overflow: auto !important;">
    <div id="app">
        <a href="{{ route('welcome') }}">
        <header class="header"> Student Organization Accomplishment Report</header>
        </a>
        <div class="banner"> 
            <div class="banner-box">
                <img src="/images/aeces_logo.png" alt="AECES Logo">
            </div>
            <div class="banner-box">
                <img src="/images/cs_logo.png" alt="CS Logo">
            </div>
            <div class="banner-box">
                <img src="/images/jma_logo.png" alt="JMA Logo">
            </div>
            <div class="banner-box">
                <img src="/images/jpia_logo.png" alt="JPIA Logo">
            </div>
            <div class="banner-box">
                <img src="/images/jpmap_logo.png" alt="JPMAP Logo">
            </div>
            <div class="banner-box">
                <img src="/images/jpsme_logo.png" alt="JPSME Logo">
            </div>
            <div class="banner-box">
                <img src="/images/mentors_logo.png" alt="Mentors Logo">
            </div>
            <div class="banner-box">
                <img src="/images/pasoa_logo.png" alt="PASOA Logo">
            </div>
            <div class="banner-box">
                <img src="/images/csc_logo.png" alt="CSC Logo">
            </div>
            <div class="banner-box">
                <img src="/images/rec_logo.png" alt="REC Logo">
            </div>
            <div class="banner-box">
                <img src="/images/erg_logo.png" alt="ERG Logo">
            </div>
            <div class="banner-box">
                <img src="/images/irock_logo.png" alt="iRock Logo">
            </div>
            <div class="banner-box">
                <img src="/images/pupukaw_logo.png" alt="PUPUKAW Logo">
            </div>
            <div class="banner-box">
                <img src="/images/chronicler_logo.png" alt="The Chronicler Logo">
            </div>
        </div>

        <div class="container" style="
            grid-gap: 0rem !important; 
            grid-template-columns: none !important;">

            <div class="row justify-content-center">
                <div >
                    <h2 style="color:white !important; text-align: center !important;padding: 10px 0px !important; ">About Us</h2>
                    <p style="color:white !important; text-align: center !important; padding: 2em 20em; font-size:1.4em;">

                        When the university, PUP Taguig, started to operate during the Covid-19 pandemic, face-to-face transactions has been limited inside the university. The School Organizations had been affected by this implemented rule. With this situation, a group of BSIT students developed the Student Organization Information System – Accomplishment Module to help the PUP Taguig Student Organizations transpose their processes to an online platform. This system is an application that will maintain and manage the Accomplishment Reports submitted from each Student Organization.

                    </p>
                </div>
                
            </div>
            
            <div class="row DavidsAndGoliath figureRow">
                <div class="col">
                    <figure class="RusselClaveria snip1104 red">
                        <img src="images/about-us/DavidsAndGoliath/RusselClaveria.jpg" alt="Russel Claveria">
                        <figcaption>
                            <h2>Russel  <span> Claveria</span></h2>
                        </figcaption>
                        <a href="https://www.facebook.com/russel10032/"></a>
                    </figure>
                    <h3 class="effect-shine" style="color:white !important; text-align: center !important; padding: 10px;">Programmer</h3>
                        
                </div>
                <div class="col">
                    <figure class="JuanCarlosAmaguin snip1104 red">
                        <img src="images/about-us/DavidsAndGoliath/JuanCarlosAmaguin.jpg" alt="Juan Carlos Amaguin">
                        <figcaption>
                            <h2>Juan Carlos  <span> Amaguin</span></h2>
                        </figcaption>
                        <a href="https://www.facebook.com/jc.amaguin"></a>
                    </figure>
                    <h3 class="effect-shine" style="color:white !important; text-align: center !important; padding: 10px;">Web Designer / Document Analyst</h3>
                </div>
                <div class="col">
                    <figure class="BryanLaserna snip1104 red">
                        <img src="images/about-us/DavidsAndGoliath/BryanLaserna.jpg" alt="Bryan Laserna">
                        <figcaption>
                            <h2>Bryan  <span> Laserna</span></h2>
                        </figcaption>
                        <a href="https://www.facebook.com/brynlsrn"></a>
                    </figure>
                    <h3 class="effect-shine" style="color:white !important; text-align: center !important; padding: 10px;">Document Analyst / Tester</h3>
                </div>
            </div>
            <div class="row DavidsAndGoliath">
                <h2 class="effect-shine" style="color:white !important; text-align: center !important;padding: 10px 0px !important; ">Davids and Goliath Development Team</h2>
            </div>


            @guest
                <div class="row">
                    <div class="col" style="padding: 0em 10em;">
                        <a href="{{ route('welcome') }}">
                            <button class="btn btn-primary">Home</button>  
                        </a>
                    </div>
                </div>
            @else
                {{-- If logged-in and user opens landing page --}}
                <div class="row">
                    <div class="col">
                        @role('Super Admin')
                            <a href="{{ route('admin.home') }}">
                                <button class="btn btn-primary">Home</button>  
                            </a>
                        @elserole('Head of Student Services')
                            <a href="{{ route('admin.home') }}">
                                <button class="btn btn-primary">Home</button>  
                            </a>
                        @elserole('Director')
                            <a href="{{ route('admin.home') }}">
                                <button class="btn btn-primary">Home</button>  
                            </a>
                        @else
                            <a href="{{ route('home') }}">
                                <button class="btn btn-primary">Home</button>  
                            </a>
                        @endrole
                        
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
