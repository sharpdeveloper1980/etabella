@extends('layouts.frontend.app')
@section('title','Home')
@section('content')
<div><img src="{{asset('public/frontend/img/image.png')}}" style="width:100%"> </div>
<div>
   <section id="service" class="section-padding wow fadeInUp delay-05s">
      <div class="container">
         <div class="row" style="margin-bottom: 43px;">
            <div class="col-md-12 text-center" style="margin-bottom: 43px;">
               <h2 class="service-title pad-bt15">Our Team</h2>
               <center>
                  <p class="sub-title pad-bt15">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod<br>tempor incididunt ut labore et dolore magna aliqua.</p>
               </center>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12" >
               <div class="service-item">
                  <center><img src="{{asset('public/frontend/img/female_8.png')}}" style="height: 70px;width: 70px;/*! alingn: cem; */"></center>
                  <center>jane doe</center>
                  <center>
                     <h6>chief HR</h6>
                  </center>
                  <center>
                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  </center>
               </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
               <div class="service-item">
                  <center><img src="{{asset('public/frontend/img/face_human_blank_user_avatar_mannequin_dummy-128.png')}}" style="height: 70px;width: 70px;/*! alingn: cem; */"></center>
                  <center>jane doe</center>
                  <center>
                     <h6>chief Marketion</h6>
                  </center>
                  <center>
                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  </center>
               </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
               <div class="service-item">
                  <center><img src="{{asset('public/frontend/img/face_human_blank_user_avatar_mannequin_dummy-128.png')}}" style="height: 70px;width: 70px;/*! alingn: cem; */"></center>
                  <center>jane doe</center>
                  <center>
                     <h6>chief Design</h6>
                  </center>
                  <center>
                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  </center>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
@endsection