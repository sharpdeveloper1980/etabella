@extends('layouts.frontend.app')
@section('title','About us')
@section('content')
<style>
        @media only screen and (max-width: 768px) {
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

        .custom_page_heading.features {
            background-image: url("public/images/4.jpg");
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
    </style>
<div class="page">
        <div class="custom_page_heading features">
            <div class="page_heading">
                Features
            </div>
        </div>
        <div class="full_width">
            <div class="container">
                <div class="row">
                    <div class="feature_top_heading">
                        The easiest litigation prep software for cases of any size
                    </div>
                    <div class="feature_top_content">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="feature_top_heading">We are delivering beautiful features</div><br>
                    <div class="col-sm-4">
                        <div class="features_inner">
                            <i class="fa fa-university" aria-hidden="true"></i>
                            <div class="feature_heading">
                                Custom Feature 1
                            </div>    
                            <p class="custom_pera">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum standard dummy text.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="features_inner">
                            <i class="fa fa-university" aria-hidden="true"></i>
                            <div class="feature_heading">
                                Custom Feature 2
                            </div>    
                            <p class="custom_pera">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum standard dummy text.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="features_inner">
                            <i class="fa fa-university" aria-hidden="true"></i>
                            <div class="feature_heading">
                                Custom Feature 3
                            </div>    
                            <p class="custom_pera">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum standard dummy text.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="features_inner">
                            <i class="fa fa-university" aria-hidden="true"></i>
                            <div class="feature_heading">
                                Custom Feature 4
                            </div>    
                            <p class="custom_pera">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum standard dummy text.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="features_inner">
                            <i class="fa fa-university" aria-hidden="true"></i>
                            <div class="feature_heading">
                                Custom Feature 5
                            </div>    
                            <p class="custom_pera">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum standard dummy text.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="features_inner">
                            <i class="fa fa-university" aria-hidden="true"></i>
                            <div class="feature_heading">
                                Custom Feature 6
                            </div>    
                            <p class="custom_pera">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum standard dummy text.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection