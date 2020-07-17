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
     <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
      <link rel="stylesheet" href="{{asset('public/frontend/css/bootstrap.css')}}" id="bscss">
      <!-- FONT AWESOME-->
      <link rel="stylesheet" href="{{asset('public/backend/vendor/fontawesome/css/font-awesome.min.css')}}">
      <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300">
      <link rel="stylesheet" href="{{asset('public/backend/vendor/sweetalert/dist/sweetalert.css')}}">
      
      <link rel="stylesheet" href="{{asset('public/frontend/ztree/css/zTreeStyle/zTreeStyle.css')}}" type="text/css">
      <!-- =============== BOOTSTRAP STYLES ===============-->
      <!-- =============== APP STYLES ===============-->
      <link rel="stylesheet" href="{{asset('public/frontend/css/app.css')}}" id="maincss">
      <link rel="stylesheet" href="{{asset('public/frontend/css/theme-a.css')}}">
      <!-- <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/style.css')}}"> -->
      <!-- <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/new-style.css')}}"> -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

      <!-- Datatable Css -->
      <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
      <!-- <link rel="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> -->
      <link rel="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">

      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.css">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">     

      <link href="https://cdn.jsdelivr.net/npm/compass-mixins@0.12.10/lib/_compass.scss">

      <link href="https://printjs-4de6.kxcdn.com/print.min.css">

      	<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/daterangepicker.css')}}" />
	  	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
   
   	  	<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/dist/css/jquery.atwho.css')}}" />
   		<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/dist/css/jquery.atwho.min.css')}}" />
   
      <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jScrollPane/2.2.1/style/jquery.jscrollpane.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jScrollPane/2.2.1/style/jquery.jscrollpane.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jScrollPane/2.2.1/style/jquery.jscrollpane.min.css.map"> -->
	
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>	
   	  
   		<script type="text/javascript" src="{{asset('public/frontend/dist/js/jquery.atwho.js')}}"></script> 
   	  	<script type="text/javascript" src="{{asset('public/frontend/dist/js/jquery.atwho.min.js')}}"></script>
   		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/caret/1.3.7/jquery.caret.min.js"></script>
   
      <!-- Ztree Scripts -->
      <script type="text/javascript" src="{{asset('public/frontend/ztree/js/jquery.ztree.all.js')}}"></script>

      <script type="text/javascript" src="{{asset('public/frontend/ztree/js/jquery.ztree.core.js')}}"></script>
      
      <script type="text/javascript" src="{{asset('public/frontend/ztree/js/jquery.ztree.excheck.js')}}"></script>
      
      <script type="text/javascript" src="{{asset('public/frontend/ztree/js/jquery.ztree.exedit.js')}}"></script>
      
      <script type="text/javascript" src="{{asset('public/frontend/ztree/js/jquery.ztree.exhide.js')}}"></script>
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
      
<!--       <script src="{{asset('public/dist/pspdfkit.js')}}"></script> -->
   <script src="http://web.etabella.com:5000/pspdfkit.js"></script>
      <!-- For Datatable Js -->
      <!-- <script src=" https://code.jquery.com/jquery-3.3.1.js"></script> -->
      <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>

      <!-- jqury scrol -->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

      <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

      <!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script> -->

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

      <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
      
      <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
      
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jScrollPane/2.2.1/script/jquery.jscrollpane.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jScrollPane/2.2.1/script/jquery.jscrollpane.min.js"></script> -->
      <!-- <script src="{{asset('node_modules/pspdfkit/dist/pspdfkit.js')}}"></script> -->
      @yield('css')
      <style>
		section > div > div > .jobs-dd {
			display: none;
		}
		section > div > div > .case_icon{
			display:none;
		}
        ul.footer_fa_icon .fa {
            margin-left: 17px !important;
            margin-top: 9px !important;
            font-size: 20px !important;
        }
        ul {
          list-style-type: none;
        }
		.nav > li > a {
			position: relative;
			display: block;
			padding: 10px 10px;
		}
		.page-101{
			height:500px;
		}
      	span.select2-selection.select2-selection--single {
    		width: 200px;
		}
      
      .page_overlay{
      	 width: 100%;
    	 height: 100%;
    	 background: #fff;
    	 position: absolute;
    	 z-index: 1;
      }
	  .page_container
	  {
		  min-height:90%;
	  }
	  .notification_icon > ul > li {
		float: left;
		margin-left: 27px;
	}
	.notification_icon > ul >li > a {
		color: #f06524;
	}
      </style>
   </head>
   <body>
   <div class="wrapper">
   <div id="page_overlay"></div>
   <script>
   var api_url="http://66.206.3.50:6062/get_token/";
   </script>
        <!-- top navbar-->
  <div id="loader" style="display: none;"><img src="{{asset('public/images/ajax-loader.gif')}}"></div>
  @if(Request::segment(3)!='dashboard' && Request::segment(2)!='shared')
   <header class="topnavbar-wrapper">
      <nav class="navbar navbar-inverse">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-7">
                  <div class="navbar-header" style="margin-left: 71%;">
                   <a href="{{ url('clients/dashboard'.'/'.Session::get('job_id')) }}">
                     <img src="{{asset('public/frontend/img/imgpsh_fullsize_anim.png')}}" alt="eTabella" class="img-responsive" style="margin-top:13px;">
                   </a>
                  </div>
               </div>
			   <div class="col-md-5">
                  <div class="notification_icon" style="margin-left: 65%;position: absolute;top: 14px;">
                   <ul>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
							<i class="fa fa-comments"></i> <span style="color:#f06524" class="badge">{{ count($notifications['message_notification']) > 0 ? count($notifications['message_notification']) : 0 }}</span>
						</a>
						<ul class="dropdown-menu notify-drop" style="left: -337px; top: 31px; " >
                           <div class="notify-drop-title">
                              <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                  <a href="{{ url('clients/read_message_notification/'.Session::get('job_id')) }}" class="rIcon">Read all</a> 
                                 </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                                  <a href="{{ url('clients/groups/'.Session::get('job_id')) }}" class="rIcon">Go To Messenger</a> 
                                </div>
								<div class="col-md-3 col-sm-3 col-xs-3 text-right">
                                  
								  <a href="{{ url('clients/message_notification/'.Session::get('job_id')) }}" class="rIcon">See all</a>
                                </div>
                              </div>
                           </div>
                           <hr id="noti-hr" style="margin-bottom: 15px;">
                           <!-- end notify title -->
                           <div id="notifications-container1">
                             <!-- notify content -->
                             @if(count($notifications['message_notification']) > 0)
                             @foreach($notifications['message_notification'] as $nkey => $notification)
                             <div class="drop-content" id="row-{{$notification->id}}">
                               <li style="cursor: pointer;display: inline-block;">
                                    @if($notification->is_annotation == 1)
                                    <div class="col-md-9 pd-l0"> 
                                      <a style="cursor: pointer;" href="{{ url('clients/shared/'.$notification->id) }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 2)
									 <?php 
									 $url="javascript:;";
									  if($notification->type==1)
							    	   $url = url('clients/groups/'.$notification->job_id.'/'.$notification->file_id);
								     else if($notification->type==2)
							    	   $url = url('clients/topics/'.$notification->job_id.'/'.$notification->file_id);
								     else if($notification->type==3)
							    	   $url = url('clients/user/'.$notification->job_id.'/'.$notification->file_id);
								    ?> 
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ $url }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 3)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/user/'.$notification->job_id.'/'.$notification->sender) }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 0)
                                    <div class="col-md-9 pd-l0"> 
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>  
                                    </div>
                                    @endif 
                                  <div class="col-md-3 col-sm-3 col-xs-3">
                                      <!-- <div class="notify-img"> -->
                                      <a href="javascript:void(0)" onclick="mark_read(<?=$notification->id?>)" data-notif_id="{{$notification->id}}" type="button" class="btn btn-xs btn-default mark_read_btn">Mark read</a>
                                      <!-- </div> -->
                                  </div>

                                   <div class="col-md-12 pd-l0">
                                   
                                   </div>
                                </li>
                             </div>
                             @endforeach
                             @else
                             <div class="drop-content" id="row-else">
                                <li>
                                  <div class="col-md-12">
                                   No new message found
                                  </div>
                                </li>
                             </div>
                             @endif
                         </div>
                         </ul>
					</li> 
					<li class="dropdown dropdown-toggle"> 
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
							<i class="fa fa-bell"></i> <span style="color:#f06524" class="badge">{{ count($notifications['all_notification']) > 0 ? count($notifications['all_notification']) : 0 }}
</span>
						</a>
						<ul class="dropdown-menu notify-drop" style="left: -337px; top: 31px; ">
                           <div class="notify-drop-title">
                              <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                   <a href="#" class="rIcon allRead">Mark all read</a>
                                 </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                  <a href="{{ url('clients/notifications') }}" class="rIcon allRead">See all</a>
                                </div>
                              </div>
                           </div>
                           <hr id="noti-hr" style="margin-bottom: 15px;">
                           <!-- end notify title -->
                           <div id="notifications-container">
                             <!-- notify content -->
                             @if(count($notifications['all_notification']) > 0)
                             @foreach($notifications['all_notification'] as $nkey => $notification)
                             <div class="drop-content" id="row-{{$notification->id}}">
                                <li>
                                    @if($notification->is_annotation == 1)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/shared/'.$notification->id) }}">
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 2)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/groups/'.$notification->job_id.'/'.$notification->file_id) }}">
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 3)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/user/'.$notification->job_id.'/'.$notification->sender) }}">
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 0)
                                    <div class="col-md-9 pd-l0"> 
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>  
                                    </div>
                                    @endif 
                                  <div class="col-md-3 col-sm-3 col-xs-3">
                                      <!-- <div class="notify-img"> -->
                                      <a href="javascript:void(0)" onclick="mark_read(<?=$notification->id?>)" data-notif_id="{{$notification->id}}" type="button" class="btn btn-xs btn-default mark_read_btn">Mark read</a>
                                      <!-- </div> -->
                                  </div>

                                   <div class="col-md-12 pd-l0">
                                   <p>{{$notification->message}}</p>
                                   </div>
                                </li>
                             </div>
                             @endforeach
                             @else
                             <div class="drop-content" id="row-else">
                                <li>
                                  <div class="col-md-12">
                                   No new message found
                                  </div>
                                </li>
                             </div>
                             @endif
                         </div>
                         </ul>
					</li>
				   </ul>
                  </div>
               </div>
			 </div>
			 <div class="row">
			   <div class="col-sm-2">
			   <p class="header_user_name">Hello {{Session::get('client_display_name')}}</p>
			   </div>
			   <div class="col-sm-8">
			   </div>
			   <div class="col-sm-2"> 
			   <li class="dropdown dropdown-toggle" id="notification_popup" style="list-style:none">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"></a>
                         <ul class="dropdown-menu notify-drop notification_dropdown notification_popup_layout">
                           <div class="notify-drop-title">
                              <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                   <a href="#" class="rIcon allRead">Mark all read</a>
                                 </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                  <a href="{{ url('clients/notifications') }}" class="rIcon allRead">See all</a>
                                </div>
                              </div>
                           </div>
                           <hr id="noti-hr" style="margin-bottom: 15px;">
                           <!-- end notify title -->
                           <div id="notifications-container">
                             <!-- notify content -->
                             @if(count($notifications['all_notification']) > 0)
                             @foreach($notifications['all_notification'] as $nkey => $notification)
                             <div class="drop-content" id="row-{{$notification->id}}">
                                <li>
                                    @if($notification->is_annotation == 1)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/shared/'.$notification->id) }}">
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 2)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/groups/'.$notification->job_id.'/'.$notification->file_id) }}">
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 3)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/user/'.$notification->job_id.'/'.$notification->sender) }}">
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 0)
                                    <div class="col-md-9 pd-l0"> 
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>  
                                    </div>
                                    @endif 
                                  <div class="col-md-3 col-sm-3 col-xs-3">
                                      <!-- <div class="notify-img"> -->
                                      <a href="javascript:void(0)" onclick="mark_read(<?=$notification->id?>)" data-notif_id="{{$notification->id}}" type="button" class="btn btn-xs btn-default mark_read_btn">Mark read</a>
                                      <!-- </div> -->
                                  </div>

                                   <div class="col-md-12 pd-l0">
                                   <p>{{$notification->message}}</p>
                                   </div>
                                </li>
                             </div>
                             @endforeach
                             @else
                             <div class="drop-content" id="row-else">
                                <li>
                                  <div class="col-md-12">
                                   No new message found
                                  </div>
                                </li>
                             </div>
                             @endif
                         </div>
                         </ul>
                       </li>
					   
					   
					     <li class="dropdown" id="message_notification_popup"style="list-style:none" >
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"></a>
                         <ul class="dropdown-menu notify-drop message_drop_down message_popup_layout" >
                           <div class="notify-drop-title">
                              <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                  <a href="{{ url('clients/read_message_notification/'.Session::get('job_id')) }}" class="rIcon">Read all</a> 
                                 </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                                  <a href="{{ url('clients/groups/'.Session::get('job_id')) }}" class="rIcon">Go To Messenger</a> 
                                </div>
								<div class="col-md-3 col-sm-3 col-xs-3 text-right">
                                  
								  <a href="{{ url('clients/message_notification/'.Session::get('job_id')) }}" class="rIcon">See all</a>
                                </div>
                              </div>
                           </div>
                           <hr id="noti-hr" style="margin-bottom: 15px;">
                           <!-- end notify title -->
                           <div id="notifications-container1">
                             <!-- notify content -->
                             @if(count($notifications['message_notification']) > 0)
                             @foreach($notifications['message_notification'] as $nkey => $notification)
                             <div class="drop-content" id="row-{{$notification->id}}">
                               <li style="cursor: pointer;display: inline-block;">
                                    @if($notification->is_annotation == 1)
                                    <div class="col-md-9 pd-l0"> 
                                      <a style="cursor: pointer;" href="{{ url('clients/shared/'.$notification->id) }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 2)
									 <?php 
									 $url="javascript:;";
									  if($notification->type==1)
							    	   $url = url('clients/groups/'.$notification->job_id.'/'.$notification->file_id);
								     else if($notification->type==2)
							    	   $url = url('clients/topics/'.$notification->job_id.'/'.$notification->file_id);
								     else if($notification->type==3)
							    	   $url = url('clients/user/'.$notification->job_id.'/'.$notification->file_id);
								    ?> 
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ $url }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 3)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/user/'.$notification->job_id.'/'.$notification->sender) }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 0)
                                    <div class="col-md-9 pd-l0"> 
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>  
                                    </div>
                                    @endif 
                                  <div class="col-md-3 col-sm-3 col-xs-3">
                                      <!-- <div class="notify-img"> -->
                                      <a href="javascript:void(0)" onclick="mark_read(<?=$notification->id?>)" data-notif_id="{{$notification->id}}" type="button" class="btn btn-xs btn-default mark_read_btn">Mark read</a>
                                      <!-- </div> -->
                                  </div>

                                   <div class="col-md-12 pd-l0">
                                   
                                   </div>
                                </li>
                             </div>
                             @endforeach
                             @else
                             <div class="drop-content" id="row-else">
                                <li>
                                  <div class="col-md-12">
                                   No new message found
                                  </div>
                                </li>
                             </div>
                             @endif
                         </div>
                         </ul>
                       </li>
					  <?php 
						$whchjobs=Session::get('client_id'); 
						$jobs=Helper::getJobs(Session::get('jobs'));
					  ?>					  
					  <div class="dropdown jobs-dd" data-toggle="tooltip" title="Jobs" style="position: absolute;margin-left: 25px;">
						 <label class="btn  dropdown-toggle" type="button" data-toggle="dropdown" style="font-weight: 700;">Current Job :  <span class="header_current_job">{{ Helper::getjObName(Session::get('job_id')) }}</span>
						 <span class="fa fa-chevron-down" style="color: #f36523"></span></label>
						 <ul class="dropdown-menu job-dropdown menu_case">
							@if($jobs)
							   @foreach($jobs as $jkey => $job)
							   <li><a href="{{ url('/clients/dashboard/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active  @endif">{{ $job->job_name }}</a></li>
							   
							   @if($job->job_id == $whchjobs)
							   <input type="hidden" value="{{ $job->job_name }}" class="active_jobname">
							   @endif
							   
							   @endforeach
							@endif
						 </ul>
					  </div>	
                  </ul>
			   </div>
               <div class="col-md-1" style="padding: 0px;display:none;">
                  <ul class="nav navbar-nav">
                     <li style="display:none"></li>
					 
					 </ul>

                  
                  
                  
                  	
                  <!-- <ul class="nav navbar-nav navbar-right" style="float: left !important; margin-top: 9px;">
                      
                     </ul> -->
                    <?php 
                    if(isset($_COOKIE['time_zone']))
                    {
                        $time_zone=$_COOKIE['time_zone'];     
                    }
                    else 
                    {
                        $time_zone='america/los_angeles'; 
                    }
                    ?>
                  <div style="padding-top:5px;">
                     <div class="dropdown user_dd">
                        <button class="btn btn-primary dropdown-toggle user_drop" type="button" data-toggle="dropdown"><span id="time_zone_display"><?php echo $time_zone; ?></span><br>{{Session::get('client_display_name')}} <span class="fa fa-caret-down"></span></button>
                        <div class="dropdown-menu logout-dropdown">
                           <!-- <li><a class="dropdown-item" href="#">Action</a></li>
                           <li><a class="dropdown-item" href="#">Another action</a></li>
                           <li><a class="dropdown-item" href="#">Something else here</a></li>
                           <li><a class="dropdown-item" href="#">Separated link</a></li> -->
                           <li><a class="dropdown-item text-center-custom" href="{{route('clientlogout')}}">Logout</a></li>
                        </div>
                     </div>
                      <!--<div class="fa_icon" style="font-size: 20px;padding:4px;color:#fff;">
                     
                     <i class="fa fa-search" onclick="toggleSearchBox()" aria-hidden="true" style="margin-left:5px;"></i>
                  </div>-->
                  </div>
               </div>
               
                  
                 
               
            </div>
            <!--   end row -->
         </div>
      </nav>
      <!-- END Top Navbar-->
   </header>
   @endif
   <!-- sidebar--> 
@if(Request::segment(3)!='render' && Request::segment(2)!='examination_schedule_render' && Request::segment(3)!='dashboard' && Request::segment(2)!='shared') 
<aside class="aside">
    <!-- START Sidebar (left)-->
    <div class="aside-inner">
        <nav data-sidebar-anyclick-close="" class="sidebar">
            <!-- START sidebar nav-->
            <ul class="nav">
                <!-- Iterates over all sidebar items-->

                <li class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ url('clients/dashboard/'.Session::get('job_id')) }}" title="Dashboard">
                        <em class="fa fa-tachometer"></em>
                        <span> Dashboard</span>
                    </a>
                </li>
				 <li class="{{ Request::segment(2) == 'myfiles' ? 'active' : '' }}">
                    <a href="{{ url('clients/myfiles/'.Session::get('job_id')) }}" title="My Files">
                        <em class="fa fa-download"></em>
                        <span> My Files</span>
                    </a>
                </li>
				 <li class="{{ Request::segment(2) == 'examination_schedule' ? 'active' : '' }}">
                    <a href="{{ url('clients/examination_schedule/'.Session::get('job_id')) }}" title="Examination Schedule">
                        <em class="fa fa-file"></em>
                        <span> Examination Schedule</span>
                    </a>
                </li>
				
				<li class="dropdown {{ Request::segment(2) == 'notifications' ? 'active' : '' }}" style="float:none;display:none">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" href="javascript:;" title="Notification">
                        <em class="fa fa-bell"></em> 
                        <span>Notification  (<b class="count_notif">{{ count($notifications['all_notification']) > 0 ? count($notifications['all_notification']) : 0 }}</b>)</span>
                    </a>
					<ul class="dropdown-menu notify-drop">
                           <div class="notify-drop-title">
                              <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                   <a href="#" class="rIcon allRead">Mark all read</a>
                                 </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                  <a href="{{ url('clients/notifications') }}" class="rIcon allRead">See all</a>
                                </div>
                              </div>
                           </div>
                           <hr id="noti-hr" style="margin-bottom: 15px;">
                           <!-- end notify title -->
                           <div id="notifications-container">
                             <!-- notify content -->
                             @if(count($notifications['all_notification']) > 0)
                             @foreach($notifications['all_notification'] as $nkey => $notification)
                             <div class="drop-content" id="row-{{$notification->id}}">
                                <li>
                                    @if($notification->is_annotation == 1)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/shared/'.$notification->id) }}">
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 2)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/groups/'.$notification->job_id.'/'.$notification->file_id) }}">
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 3)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/user/'.$notification->job_id.'/'.$notification->sender) }}">
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 0)
                                    <div class="col-md-9 pd-l0"> 
                                      <label>
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>  
                                    </div>
                                    @endif 
                                  <div class="col-md-3 col-sm-3 col-xs-3">
                                      <!-- <div class="notify-img"> -->
                                      <a href="javascript:void(0)" onclick="mark_read(<?=$notification->id?>)" data-notif_id="{{$notification->id}}" type="button" class="btn btn-xs btn-default mark_read_btn">Mark read</a>
                                      <!-- </div> -->
                                  </div>

                                   <div class="col-md-12 pd-l0">
                                   <p>{{$notification->message}}</p>
                                   </div>
                                </li>
                             </div>
                             @endforeach
                             @else
                             <div class="drop-content" id="row-else">
                                <li>
                                  <div class="col-md-12">
                                   <p style="color:black">No new message found</p>
                                  </div>
                                </li>
                             </div>
                             @endif
                         </div> 
                         </ul>
                </li>
				<li style="float: none;display:none" class="dropdown {{ Request::segment(2) == 'groups' ? 'active' : '' }} {{ Request::segment(2) == 'message_notification' ? 'active' : '' }}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" title="Notification">
                        <em class="fa fa-comments"></em>
                        <span>Messenger  (<b class="count_mnotif">{{ count($notifications['message_notification']) > 0 ? count($notifications['message_notification']) : 0 }}</b>)</span>
                    </a>
					<ul class="dropdown-menu notify-drop">
                           <div class="notify-drop-title">
                              <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                  <a href="{{ url('clients/read_message_notification/'.Session::get('job_id')) }}" class="rIcon">Read all</a> 
                                 </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                                  <a href="{{ url('clients/groups/'.Session::get('job_id')) }}" class="rIcon">Go To Messenger</a> 
                                </div>
								<div class="col-md-3 col-sm-3 col-xs-3 text-right">
                                  
								  <a href="{{ url('clients/message_notification/'.Session::get('job_id')) }}" class="rIcon">See all</a>
                                </div>
                              </div>
                           </div>
                           <hr id="noti-hr" style="margin-bottom: 15px;">
                           <!-- end notify title -->
                           <div id="notifications-container1">
                             <!-- notify content -->
                              @if(count($notifications['message_notification']) > 0)
                             @foreach($notifications['message_notification'] as $nkey => $notification)
                             <div class="drop-content" id="row-{{$notification->id}}">
                               <li style="cursor: pointer;display: inline-block;">
                                    @if($notification->is_annotation == 1)
                                    <div class="col-md-9 pd-l0"> 
                                      <a style="cursor: pointer;" href="{{ url('clients/shared/'.$notification->id) }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 2)
									 <?php 
									 $url="javascript:;";
									  if($notification->type==1)
							    	   $url = url('clients/groups/'.$notification->job_id.'/'.$notification->file_id);
								     else if($notification->type==2)
							    	   $url = url('clients/topics/'.$notification->job_id.'/'.$notification->file_id);
								     else if($notification->type==3)
							    	   $url = url('clients/user/'.$notification->job_id.'/'.$notification->file_id);
								    ?> 
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ $url }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 3)
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="{{ url('clients/user/'.$notification->job_id.'/'.$notification->sender) }}">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>
                                      </a> 
                                    </div>
                                    @elseif($notification->is_annotation == 0)
                                    <div class="col-md-9 pd-l0"> 
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           {{$notification->title}}
                                      </label>  
                                    </div>
                                    @endif 
                                  <div class="col-md-3 col-sm-3 col-xs-3">
                                      <!-- <div class="notify-img"> -->
                                      <a href="javascript:void(0)" onclick="mark_read(<?=$notification->id?>)" data-notif_id="{{$notification->id}}" type="button" class="btn btn-xs btn-default mark_read_btn">Mark read</a>
                                      <!-- </div> -->
                                  </div>

                                   <div class="col-md-12 pd-l0">
                                   
                                   </div>
                                </li>
                             </div>
                             @endforeach
                             @else
                             <div class="drop-content" id="row-else">
                                <li>
                                  <div class="col-md-12">
                                   <p style="color:black">No new message found</p>
                                  </div>
                                </li>
                             </div>
                             @endif
                         </div>
                         </ul>
                </li>
				 <li class="{{ Request::segment(2) == 'reports' ? 'active' : '' }}">
                    <a href="{{ route('Reports') }}" title="Reports">
                        <em class="fa fa-file-text"></em>
                        <span> Reports</span>
                    </a>
                </li>
				<li class="{{ Request::segment(2) == 'activity-log' ? 'active' : '' }}">
                    <a href="{{ route('myActivityLog') }}" title="Activity log">
                        <em class="fa fa-list"></em>
                        <span> Activity log</span>
                    </a>
                </li> 
				<li>
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <em class="fa fa-file"></em>Quick access <span class="fa fa-caret-down"></span></a>
					<ul class="collapse list-unstyled homeSubmenu" id="homeSubmenu">
						<li>
							<a href="{{ url('/clients/get-recent-opened/'.Session::get('job_id')) }}"><i class="fa fa-circle-o"></i> Recent Opened Files</a>
						</li>
						<li>
							<a href="{{ url('/clients/get-recent-commented/'.Session::get('job_id'))  }}"><i class="fa fa-circle-o"></i> Recent annotated files</a>
						</li>
						<li>
							<a href="{{ url('/clients/get-recent-commented/'.Session::get('job_id'))  }}"><i class="fa fa-circle-o"></i> Recent commented files</a>
						</li>
						<li>
							<a href="{{ url('/clients/get-recent-shared/'.Session::get('job_id'))  }}"><i class="fa fa-circle-o"></i> Recent shared files</a>
						</li>
					</ul>
				</li>
				<li>
                    <a href="{{route('clientlogout')}}" title="Logout">
                        <em class="fa fa-sign-out"></em>
                        <span>Logout</span>
                    </a>
                </li>
			</ul>
		</nav>
	</div>
</aside>
@endif
<section <?php if(Request::segment(3)=='render' || Request::segment(2)=='file' || Request::segment(2)=='examination_schedule_render' || Request::segment(3)=='dashboard' || Request::segment(2)=='shared') { ?> style=" left: -220px !important; width: 100%;" <?php  } ?>>
   <div class="<?php if(Request::segment(2)=='activity-log') { ?>page_container<?php } ?>">
   @yield('content')
</section>
   </div>
      <div  style="background-color: #424141;color: white;margin-top:120px;padding-bottom:30px;display:none;">
         <section id="contact" class="section-padding wow fadeInUp delay-05s">
            <div class="container">
               <div class="row">
				  <div class="col-md-2 footer_icon">
				  
                     <img src="{{asset('public/frontend/img/logo.png')}}" alt="eTabella" class="img-responsive" style="margin-top:50px;"> 
                  </div>
                  <div class="col-md-3 col_cate" style="margin-top: 30px;border-left:1px solid #f36523;">
                     <ul class="ul">
                        <li>
                           <h4 style="font-size: 23px;color:#929598;">
                           Category</h5>
                        </li>
                        <li><a href="#">Products</a> </li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Downloads</a></li>
                        <li><a href="#">Team</a></li>
                     </ul>
                  </div>
                  <div class="col-md-3 col_manage"  style="margin-top: 30px;border-right:1px solid #f36523;">
                     <ul class="ul">
                        <li>
                           <h4 style="font-size: 23px;color:#929598;">Management</h4>
                        </li>
                        <li><a href="#">Resources</a></li>
                        <li><a href="#">Institutions</a></li>
                        <li><a href="#">Location</a></li>
                        <li><a href="#">Contact</a></li>
                     </ul>
                  </div>
                  <div class="col-md-2">
                     <button style="border:1px solid #f36532;margin-top: 30px;background: unset;border-radius: 16px; font-size: 19px; margin-left: 44px;color:#929598;width:135px;">Back To Top</button>
                     <button style="border:1px solid #f36532;margin-top: 96px;background: unset;border-radius: 16px; font-size: 19px; margin-left: 44px;color:#929598;width:135px;">Subscribe</button>
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
	  
	  
	  
	  <div  style="background-color: #424141;color: white;padding-bottom:30px;height: 45px;bottom: 0;width: 100%;line-height: 45px;">
         <section id="contact" class="section-padding wow fadeInUp delay-05s">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12">
					<p align="center">&copy; {{ date('Y') }} - eTabella - Powered by LegalWare</p>
				  </div>
               </div>
            </div>
         </section>
      </div>
	  
	  
   </div>
   </div>

	<div class="modal fade doc-display-mdl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!--<div class="modal-header">
          <div class="form-groupsearch_sorting" id="">
            <h4><img src="http://66.206.3.18/etabellaweb/public/images/move-icon.png" height="30" width="30"> Move file</h4> 
          </div>
        </div>-->
        <div class="modal-body">
            <iframe style="width: 100%;height: 500px;" class="ifram_src"></iframe>
      	</div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancel-doc-display-mdl">Cancel</button>
          </div>  <!---->
      </div>
    </div>
  	</div>
   </div>
   <!-- end wrapper -->
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
   <!-- SWEET ALERT-->
   <script src="{{ asset('public/backend/vendor/sweetalert/dist/sweetalert.min.js') }}"></script>

   <script src="{{ asset('public/frontend/js/jquery-dateformat.js') }}"></script>
   <script src="{{ asset('public/js/timezone.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        {!! Toastr::message() !!}

    <script type="text/javascript">
	$(document).on('click','#notification_menu_new',function(){
		$('.message_drop_down').css({'display':'none'});
		$('.notification_dropdown').css({'display':'block'});
	});
	$('body').on('click',function(){
		$('.notification_dropdown').css({'display':'none'});
		$('.message_drop_down').css({'display':'none'});
	});
	
	

	$(document).on('click','#message_menu',function(){
		$('.notification_dropdown').css({'display':'none'});
		$('.message_drop_down').css({'display':'block'});
	});
      $(document).ready(function(){
         var baseurl = "{{url('/')}}";
         var timezone =  show_timezone_info();
          $.post(baseurl+'/clients/update_timezone',{_token:"{{ csrf_token() }}","timezone":timezone},function(fb){ 
          });
      });
      $('[data-tooltip="tooltip"]').tooltip()
      var baseurl = "{{url('/')}}";
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}','Error',{
                    "debug": false,
                });
            @endforeach
        @endif

        var active_job = $('.active_jobname').val();

        setTimeout(function(){
          $('.case_jobname').text(' '+active_job+' ');  
        },2000);

        setTimeout(function(){
          $("a.level0").removeAttr("title");
          $("a.level1").removeAttr("title");	
        },2000)
  

  // PSPDFKit.preloadWorker({
  //   disableWebAssemblyStreaming: true,
  //       baseUrl: 'http://66.206.3.18/etabellaweb/public/dist/',
  //       licenseKey: "cGkYwLdqZExV0U8GRe-xvjcO5dXdtO41bbmckEX0NS50WhxH-sJqgZuQ8ShnRZrn_bkTptrPl_Ck6Qj1ZsQq28HoXOt14rTRJa4p_v-lBuadzRZP8F_69ua-l0lmqHMUFFL4E6CHC2LnmmTMUCZpp9OA4-el9r2cl-k3dbbRoJBxggCggF50DrvQCNDib6c8pHP1JcKZqdFfW8PzrCnKvVLkGtTrhzM8aHf2HeCqts_adumZm5G_v8Gwg2_93Lbn5sD7_VpVVhnw-NsEfmY4ldVAGbPY3mg2Xl4_8XzkUA0mk1Iza_Ft9ETMww_3p6IltyqbQgOIvwfkPzgZvTqqP_-8tpgrAbzzBl1LHSDXk7ZTjaaXhEPxUYDf37AEgv4XGMRnPwDQ11-gmQCiIHPZbASQLO6wg81XBZP5sWmBFQ7_C9Iw1nCwxpc8vN9bL5LU"
  // });

   function mark_read(id){
      $.ajax({
           type: "Get",
           url: baseurl+"/clients/mark_read/"+id,
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              if(data.message == true){
               $("#row-"+id).remove();
               $(".count_notif").text(data.count);
              }
           }
      });
   };

  $(".allRead").click(function(){
    $.ajax({
           type: "Get",
           url: baseurl+"/clients/mark_all_read",
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              if(data.message == true){
                $(".drop-content").remove();
                $("#noti-hr").after('<div class="drop-content"><li><div class="col-md-12">No new message found</div></li></div>');
                $(".count_notif").text(0);
              }
           }
      });
  });

/** start get realtime notifications **/
  function get_notifications(){
    $.ajax({
           type: "Get",
           url: baseurl+"/clients/get_notifications",
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              if(data.success == true){
                console.log(data);
                $(".count_notif").text(data.notif_count);
				$(".count_mnotif").text(data.notif_count1);
              console.log('a');
              console.log(data.notif_html1);
               $("#notifications-container").html(data.notif_html);
                $("#notifications-container1").html(data.notif_html1);
              }
           }
      });
  }
/** end get realtime notifications **/

    function popupwindow(url,type) {
    	if(type == 'doc'){
        	var src_val = "https://docs.google.com/gview?url="+url+"&embedded=true";
        	$(".ifram_src").attr("src",src_val);
    		$(".doc-display-mdl").modal('show');    
        	return false;
        }
    
    	var w = 500;
        var h =400;
        var left = Number((screen.width/2)-(w/2));
        var tops = Number((screen.height/2)-(h/2));
		// var screenwidth = $(window).width();
		// var screenheight = $(window).height();
		
		// var y = window.outerHeight / 2 + window.screenY - ( screenwidth / 2)
		// var x = window.outerWidth / 2 + window.screenX - ( screenheight / 2)
    	return window.open(url,'new',"width=500,height=400,top="+tops+",left="+left+"");
	} 
    
    $("#cancel-doc-display-mdl").click(function(){
    	$(".doc-display-mdl").modal('hide');  
    });
    
   setInterval(function(){ get_notifications(); }, 5000);
/*  $(document).ready(function(){ */
    $('[data-toggle="tooltip"]').tooltip();
/*  }); */
//$('#time_zone_display').html(Intl.DateTimeFormat().resolvedOptions().timeZone);
console.log(Intl.DateTimeFormat().resolvedOptions().timeZone)
    </script>  
    @yield('js')
   </body>
</html>