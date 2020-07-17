<?php $__env->startSection('title','About us'); ?>
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

        .line {
            width: 160px;
            background: black;
            height: 8px;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .custom_button {
            background: #f36523;
            width: 125px;
            color: white;
            padding: 7px;
            text-align: center;
            border-radius: 2px;
            margin-top: 20px;
        }

        .custom_pera {
            color: #575757;
            font-size: 15px;
        }

        .col-sm-6.full_width_img img {
            width: 100%;
        }

        .custom_sub_heading {
            margin-bottom: 6px;
            font-size: 16px;
            color: #f36523;
        }

        .full_width {

            background: #dfdfdf;
            margin-bottom: 55px;
            padding: 65px 20px;
            font-size: 30px;
            color: #404040;
            text-align: center;
        }
    </style>
<div class="page">
        <div class="custom_page_heading">

            <div class="page_heading">
                About Us
            </div>
        </div>
        <div class="full_width">
            The collaborative case analysis and transcript management<br> workspace that is revolutionizing the practice
            of<br>
            litigation… again.
        </div>
        <div class="container">
            <div class="row three_columns">
                <div class="col-sm-4">
                    <div class="column_inner">
                        <div class="column_heading">
                            Lorem Ipsum is simply dummy text of the printing
                        </div>
                        <div class="line"></div>
                        <p class="custom_pera">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                            galley of type and scrambled it to make a type specimen book. It has survived not only five
                            centuries
                        </p>
                        <a href="<?php echo e(url('contact_us')); ?>">
                            <div class="custom_button">Contact Us</div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="column_inner">
                        <img src="<?php echo e(url('public/images/1.jpg')); ?>">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="column_inner">
                        <img src="<?php echo e(url('public/images/2.jpg')); ?>">
                    </div>
                </div>
            </div>
            <br><br><br>
            <div class="row section_two">
                <div class="col-sm-6 full_width_img">
                    <img src="<?php echo e(url('public/images/3.jpg')); ?>">
                </div>
                <div class="col-sm-6 section_two_right">
                    <div class="column_heading">
                        Some reasons to work together
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom_sub_heading">
                                01. We believe in creativity
                            </div>
                            <p class="custom_pera">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown
                                printer took a galley of type and scrambled
                            </p>
                        </div>
                        <div class="col-md-6 second">
                            <div class="custom_sub_heading">
                                02. We believe in quality
                            </div>
                            <p class="custom_pera">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown
                                printer took a galley of type and scrambled
                            </p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom_sub_heading">
                                03. We believe in abilities
                            </div>
                            <p class="custom_pera">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown
                                printer took a galley of type and scrambled
                            </p>
                        </div>
                        <div class="col-md-6 second">
                            <div class="custom_sub_heading">
                                04. We believe in relation
                            </div>
                            <p class="custom_pera">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown
                                printer took a galley of type and scrambled
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>