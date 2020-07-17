<?php $__env->startSection('title','Contact us'); ?>
<?php $__env->startSection('content'); ?>
<style>
    @media  only screen and (max-width: 768px) {
            .custom_button {
                margin-bottom: 28px;
            }
            .column_inner img {
                margin-bottom: 22px;
            }
            .col-sm-6.full_width_img img {
                margin-bottom: 20px;
            }
            .second {
                margin-top: 32px;
            }
        }

        .custom_page_heading {
            background-image: url("public/images/about_bg.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 300px;
            margin-bottom: 50px;
        }

        .custom_page_heading.contact {
            background-image: url("public/images/5.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 300px;
            margin-bottom: 50px;
        }

        .page_heading {
            color: white;
            font-size: 35px;
            text-align: center;
            padding: 123px 0px;
        }

        .page {
            margin-top: -21px;
            margin-bottom: 60px;
        }

        .column_heading {
            font-size: 30px;
            font-weight: 600;
            line-height: 38px;
            margin-bottom: 20px;
        }

        .column_inner img {
            width: 100%;
        }
        .custom_pera {
            color: #575757;
            font-size: 15px;
        }
        .features_inner {
            text-align: center;
            padding: 25px;
        }
        .features_inner.contact {
            border: 2px solid #eaeaea;
        }
        .features_inner .fa {
            font-size: 28px;
            color: #f36523;
        }
        .feature_heading {
            font-size: 16px;
            margin: 12px 0px;
        }
        .feature_top_heading {
            font-size: 30px;
            text-align: center;
            color: #f36523;
            margin-bottom: 12px;
            font-weight: bold;
        }
        .feature_top_content {
            color: #575757;
            font-size: 15px;
            text-align: center;
            margin-bottom: 50px;
        }
        .custom_pera .fa {
            color: gray;
            margin: 9px;
        }
        .custom_pera .fa:hover {
            color: #f36523;
        }
</style>
<div class="page">
      <div class="custom_page_heading contact">
         <div class="page_heading">
               Contact Us
         </div>
      </div>
        <div class="full_width">
            <div class="container">                
                <div class="row">
                    <div class="feature_top_heading">How we can help</div><br>
                    <div class="col-sm-4">
                        <div class="features_inner contact">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <div class="feature_heading">
                                Address
                            </div>    
                            <p class="custom_pera">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="features_inner contact">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <div class="feature_heading">
                                Contact Us
                            </div>    
                            <p class="custom_pera">
                                Mob. : 9876543210, 9876543210 <br>
                                Mail : dummymail@gmail.com
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="features_inner contact">
                            <i class="fa fa-share-alt" aria-hidden="true"></i>
                            <div class="feature_heading">
                                Social Media
                            </div>    
                            <p class="custom_pera">
                                <a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-youtube-square" aria-hidden="true"></i></a>  
                            </p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>