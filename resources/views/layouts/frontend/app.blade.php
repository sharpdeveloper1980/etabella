<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="shortcut icon" href="{{ asset('public/images/icon.png') }}">
      <title>@yield('title') - eTabella</title>
      <!-- =============== VENDOR STYLES ===============-->
      <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
      <!-- FONT AWESOME-->
      <link rel="stylesheet" href="{{asset('public/backend/vendor/fontawesome/css/font-awesome.min.css')}}">
      <link rel="stylesheet" href="{{asset('public/backend/vendor/sweetalert/dist/sweetalert.css')}}">
      <!-- =============== BOOTSTRAP STYLES ===============-->
      <link rel="stylesheet" href="{{asset('public/frontend/css/bootstrap.css')}}" id="bscss">
      <!-- =============== APP STYLES ===============-->
      <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
      <style type="text/css">
        /* Style the navigation menu */
.topnav {
  overflow: hidden;
  background-color: #333;
  /*position: relative;*/
}

/* Hide the links inside the navigation menu (except for logo/home) */
.topnav #myLinks {
  display: none;
}
.topnav #myLinks a {
  color: #000;
}
/* Style navigation menu links */
.topnav a {
  color: #fff;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
  display: block;
  border-bottom: 1px solid #ccc;

}

/* Style the hamburger menu */
.topnav a.icon {
  /*background: black;*/
  display: block;
  position: absolute;
  right: 0;
  top: 0;
}

/* Add a grey background color on mouse-over */
.topnav a:hover {
  background-color: #f36523;
  color: #fff;
}

/* Style the active link (or home/logo) */
.active {
  background-color: #4CAF50;
  color: white;
}
      </style>
   </head>
   <body>
      <div class="wrapper">
         <!-- top navbar-->
         <header class="topnavbar-wrapper">
            <nav class="navbar navbar-inverse">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-md-3">
                        <div class="navbar-header">
                           <img src="{{asset('public/img/logo.png')}}" alt="eTabella" class="img-responsive" style="margin-top:13px;">
                        </div>
                     </div>
                     <div class="col-md-7 hide_on_mobile">
                        <ul class="nav navbar-nav" style="margin-top: 9px; ">
                           <li class="active"><a href="#">HOME</a></li>
                           <li><a href="{{url('about')}}" >ABOUT US</a></li>
                           <li><a href="{{url('/')}}">DOWNLOADS</a></li>
                           <li><a href="{{url('features')}}">FEATURES</a></li>
                           <li><a href="{{url('contact_us')}}">CONTACT</a></li>
                        </ul>
                     </div>
                     <!-- Top Navigation Menu -->
                      <div class="topnav">
                       
                        <!-- Navigation links (hidden by default) -->
                        <div id="myLinks" style="position: absolute;right: 0px;background: #fff;top:54px;z-index: 999">
                          <a href="{{url('/')}}">HOME</a>
                          <a href="{{url('about')}}" >ABOUT US</a>
                          <a href="{{url('/')}}">DOWNLOADS</a>
                          <a href="{{url('features')}}">FEATURES</a>
                          <a href="{{url('contact_us')}}">CONTACT</a>
                          <a href="{{ url('/clients/login') }}">LOGIN</a>
                        </div>
                        <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
                        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                          <i class="fa fa-bars"></i>
                        </a>
                      </div>
                     <div class="col-md-2 hide_on_mobile" id="fa_div">
                      @if(Session::has('type'))
                          @if(Session::get('type') == "admin")
                            <a href="{{ url('/home') }}"><i class="fa fa-user fa-ic" aria-hidden="true"></i></a>&nbsp;&nbsp;
                            <a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-ic" aria-hidden="true"></i></a>
                          @endif
                          @if(Session::has('client_id'))
                             <a href="{{ url('/clients/dashboard') }}"><i class="fa fa-user fa-ic" aria-hidden="true"></i></a>&nbsp;&nbsp;
                            <a href="{{ url('/clients/logout') }}"><i class="fa fa-sign-out fa-ic" aria-hidden="true"></i></a>
                            @endif   
                      @else
                        <a href="{{ url('/clients/login') }}"><i class="fa fa-sign-in fa-ic" aria-hidden="true"></i></a>&nbsp;&nbsp;
                      @endif
                  </div>
               </div>
            </nav>
            <!-- END Top Navbar-->
         </header>
         @yield('content')
              <footer style="background-color: #424141;color: white;height:45px;line-height:45px">
                  <center><span>&copy; 2019 - eTabella - Powered by LegalWare</span></center>
         <div  style="background-color: #424141;color: white;margin-top:120px;display:none">
         <section id="contact" class="section-padding wow fadeInUp delay-05s">
            <div class="container">
               <div class="row">
                  <div class="col-md-2 footer_icon">
                     <img src="{{asset('public/frontend/img/logo.png')}}" alt="eTabella" class="img-responsive" style="margin-top:50px;"> 
                  </div>
                  <div class="col-md-3 col_cate" style="margin-top: 30px;border-left:1px solid #f36523;">
                     <ul class="ul">
                        <li>
                           <h4 style="font-size: 21px;color:#929598;">
                           Category</h5>
                        </li>
                        <li><a href="{{url('/')}}">Products</a> </li>
                        <li><a href="{{url('about')}}">About Us</a></li>
                        <li><a href="{{url('/')}}">Downloads</a></li>
                        <li><a href="{{url('/')}}">Team</a></li>
                     </ul>
                  </div>
                  <div class="col-md-3 col_manage"  style="margin-top: 30px;border-right:1px solid #f36523;">
                     <ul class="ul">
                        <li>
                           <h4 style="font-size: 21px;color:#929598;">Management</h4>
                        </li>
                        <li><a href="{{url('/')}}">Resources</a></li>
                        <li><a href="{{url('/')}}">Institutions</a></li>
                        <li><a href="{{url('/')}}">Location</a></li>
                        <li><a href="{{url('contact_us')}}">Contact</a></li>
                     </ul>
                  </div>
                  <div class="col-md-2">
                     <button class="col_manage_btn" id="backtotop">Back To Top</button>
                     <button style="margin-top: 62px;" class="col_manage_btn">Subscribe</button>
                  </div>
                  <div class="col-md-2 play_icon">
                     <img src="{{asset('public/frontend/img/2.jpg')}}" alt="eTabella" class="img-responsive" style="margin-top:37px;height: 41px;width: 126px;border-radius: 5px;float: right;">
                     <img src="{{asset('public/frontend/img/1.png')}}" alt="eTabella" class="img-responsive" style="margin-top:15px;height: 41px;width: 126px;border-radius: 5px;float: right;">
                     <ul class="footer_fa_icon">
                        <i class="fa fa-facebook-square fa_face" aria-hidden="true"></i>
                        <i class="fa fa-twitter fa_twit" aria-hidden="true" ></i>
                        <i class="fa fa-instagram fa_ins" aria-hidden="true" ></i>
                     </ul>
                  </div>
               </div>
            </div>
         </section>
      </div>
              </footer>
      </div>
      <!-- =============== VENDOR SCRIPTS ===============-->
      <!-- JQUERY-->
      <script src="{{ asset('public/backend/vendor/jquery/dist/jquery.js') }}"></script>
      <!-- Latest compiled JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
      <!-- SWEET ALERT-->
        <script src="{{ asset('public/backend/vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        {!! Toastr::message() !!}

    <script type="text/javascript">
      var baseurl = "{{url('/')}}";
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}','Error',{
                    "debug": false,
                });
            @endforeach
        @endif

      $('#backtotop').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 500);
        return false;
      });

      function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
    </script>  
    @yield('js')
   </body>
</html>