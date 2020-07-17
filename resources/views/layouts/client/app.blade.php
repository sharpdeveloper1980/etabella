<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title') - eTabella</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Font Awesome -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('public/images/icon.png') }}">
	<link rel="stylesheet" href="{{ url('') }}/public/client_assets/plugins/fontawesome-free/css/all.min.css?d={{ date('his') }}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css?d={{ date('his') }}">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="{{ url('') }}/public/client_assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css?d={{ date('his') }}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{ url('') }}/public/client_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css?d={{ date('his') }}">
	<!-- JQVMap -->
	<link rel="stylesheet" href="{{ url('') }}/public/client_assets/plugins/jqvmap/jqvmap.min.css?d={{ date('his') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ url('') }}/public/client_assets/dist/css/adminlte.css?d={{ date('his') }}">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{ url('') }}/public/client_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css?d={{ date('his') }}">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{ url('') }}/public/client_assets/plugins/daterangepicker/daterangepicker.css?d={{ date('his') }}">
	<!-- summernote -->
	<link rel="stylesheet" href="{{ url('') }}/public/client_assets/plugins/summernote/summernote-bs4.css?d={{ date('his') }}">
	<link rel="stylesheet" href="{{asset('public/backend/vendor/sweetalert/dist/sweetalert.css?d='.date('his'))}}">
	<link rel="stylesheet" href="{{asset('public/frontend/ztree/css/zTreeStyle/zTreeStyle.css?d='.date('his'))}}" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css?d={{ date('his') }}">
	<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css?d={{ date('his') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css?d={{ date('his') }}">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.css?d={{ date('his') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css?d={{ date('his') }}">
	<link href="https://cdn.jsdelivr.net/npm/compass-mixins@0.12.10/lib/_compass.scss?d={{ date('his') }}">
	<link href="https://printjs-4de6.kxcdn.com/print.min.css?d={{ date('his') }}">
	<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/daterangepicker.css?d='.date('his'))}}" />
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css?d={{ date('his') }}" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/dist/css/jquery.atwho.css?d='.date('his'))}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/dist/css/jquery.atwho.min.css?d='.date('his')) }}" />
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/app.css?d='.date('his'))}}" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/daterangepicker.css?d='.date('his'))}}" />
	
	<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/chat.css?d='.date('his'))}}" />
	@if(Request::segment(2)=='from' && Request::segment(3)=='dashboard')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/from_dashboard.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='file' || Request::segment(3)=='render')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/check.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='examination_schedule')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/examination_schedule.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='examination_schedule_inner')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/examination_schedule_inner.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='manage_docs')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/manage_docs.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='examination_schedule_render')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/examination_schedule_render.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='compare' || Request::segment(2)=='compare-file')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/compare.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='activity-log')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/activity_log.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='groups' || Request::segment(2)=='groups-single')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/groups.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='topics' || Request::segment(2)=='topics-single')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/topics.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='user' || Request::segment(2)=='user-single') 
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/user.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='shared')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/file_render.css?d='.date('his'))}}" />
	@endif
	@if(Request::segment(2)=='myfiles')
	<link rel="stylesheet" type="text/css" href="{{asset('public/client_assets/pages/css/myfiles.css?d='.date('his'))}}" />
	@endif 
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div id="page_overlay" class="page_overlay"></div>
	<script>
		var api_url="http://66.206.3.50:6062/get_token/";
		   var baseurl = "{{url('/')}}";
	</script>{{ csrf_field() }}
	<div class="wrapper">
		<div class="loader">
			<img src="{{ asset('public/images/ajax-loader.gif') }}">
		</div>
		@if(Request::segment(3)!='render' && Request::segment(2)!='examination_schedule_render' && Request::segment(2)!='compare' && Request::segment(2)!='compare-file')
		<!-- Navbar -->
		<div class="row">
			<div class="col-sm-12 text-center">
				<a href="<?php echo url('clients') ?>" >
				<img src="{{ url('') }}/public/frontend/img/logo_a.png" alt="eTabella" class="logo_center " > 
			</a>
			</div>
		</div>
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item notification_icon"> <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item  d-sm-inline-block">
					<?php $whchjobs=Session::get( 'client_id'); $jobs=Helper::getJobs(Session::get( 'jobs')); ?>
					<div class="dropdown">
						<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">{{ Helper::getjObName(Session::get('job_id')) }}</button>
						<div class="dropdown-menu">@foreach($jobs as $jkey => $job)	<a class="dropdown-item @if($job->job_id == $whchjobs) active  @endif" href="{{ url('/clients/dashboard/'.$job->job_id) }}">{{ $job->job_name }}
			@if($job->job_id == $whchjobs)
				<input type="hidden" value="{{ $job->job_name }}" class="active_jobname">
		    @endif
			</a>
							@endforeach</div>
					</div>
				</li>
			</ul>
			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- Messages Dropdown Menu -->
				<li class="nav-item dropdown notification_icon">
					<a class="nav-link" data-toggle="dropdown" href="#"> <i class="fa fa-comments"></i>  <span class="badge badge-danger navbar-badge count_mnotif">{{ count($notifications['message_notification']) > 0 ? count($notifications['message_notification']) : 0 }}</span>
					</a>
					<div class="dropdown-menu custom_width_for_popup dropdown-menu-right">
						<div class="row pr-2 pl-2 pt-2 pb-2">
							<div class="col-md-3 col-sm-3 col-xs-3 mobile_tabs left_popup"> <a href="{{ url('clients/read_message_notification/'.Session::get('job_id')) }}" class="rIcon">Read all</a> 
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 mobile_tabs center_popup"> <a href="{{ url('clients/groups/'.Session::get('job_id')) }}" class="rIcon">Go To Messenger</a> 
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 mobile_tabs right_popup"> <a href="{{ url('clients/message_notification/'.Session::get('job_id')) }}" class="rIcon">See all</a>
							</div>
						</div>
						<div class="dropdown-divider"></div>
						<div id="notifications-container1" class="notification_container">
							<!-- notify content -->@if(count($notifications['message_notification']) > 0) @foreach($notifications['message_notification'] as $nkey => $notification)
							<div class="drop-content" id="row-{{$notification->id}}">@if($notification->is_annotation == 1)
								<div class="col-md-9 pd-l0">
									<a style="cursor: pointer;" href="{{ url('clients/shared/'.$notification->id) }}">
										<label style="cursor: pointer;"> <i class="fa fa-bell" style="color: #f36523;"></i> {{$notification->title}}</label>
									</a>
								</div>@elseif($notification->is_annotation == 2)
								<?php $url="javascript:;" ; 
								if($notification->type==1) 
								{
									if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
									|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
									, $_SERVER["HTTP_USER_AGENT"]))
									{
										$url = url('clients/groups-single/'.$notification->job_id.'/'.$notification->file_id); 
									}
									else 
									{
										$url = url('clients/groups/'.$notification->job_id.'/'.$notification->file_id); 
									}
								}
								else if($notification->type==2)
								{
									if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
									|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
									, $_SERVER["HTTP_USER_AGENT"]))
									{
										$url = url('clients/topics-single/'.$notification->job_id.'/'.$notification->file_id); 
									}
									else 
									{
										$url = url('clients/topics/'.$notification->job_id.'/'.$notification->file_id); 
									}
									
									
								}
								else if($notification->type==3) 
								{
									if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
									|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
									, $_SERVER["HTTP_USER_AGENT"]))
									{
										$url = url('clients/user-single/'.$notification->job_id.'/'.$notification->file_id); 
									}
									else 
									{
										$url = url('clients/user/'.$notification->job_id.'/'.$notification->file_id);
									}
									 
								}
							    ?>
								<div class="col-md-9 pd-l0">
									<a href="{{ $url }}">
										<label style="cursor: pointer;"> <i class="fa fa-bell" style="color: #f36523;"></i> {{$notification->title}}</label>
									</a>
								</div>@elseif($notification->is_annotation == 3)
								<div class="col-md-9 pd-l0">
									<a href="{{ $url }}">
										<label style="cursor: pointer;"> <i class="fa fa-bell" style="color: #f36523;"></i> {{$notification->title}}</label>
									</a>
								</div>@elseif($notification->is_annotation == 0)
								<div class="col-md-9 pd-l0">
									<label style="cursor: pointer;"> <i class="fa fa-bell" style="color: #f36523;"></i> {{$notification->title}}</label>
								</div>@endif
								<div class="col-md-3 col-sm-3 col-xs-3">
									<!-- <div class="notify-img"> --> <a href="javascript:void(0)" onclick="mark_read(<?=$notification->id?>)" data-notif_id="{{$notification->id}}" type="button" class="btn btn-xs btn-default mark_read_btn">Mark read</a>
									<!-- </div> -->
								</div>
								<div class="col-md-12 pd-l0"></div>
							</div>@endforeach @else
							<div class="drop-content" id="row-else">
								<div class="col-md-12">No new message found</div>
							</div>@endif</div>
					</div>
				</li>
				<!-- Notifications Dropdown Menu -->
				<li class="nav-item dropdown notification_icon">
					<a class="nav-link" data-toggle="dropdown" href="#"> <i class="fa fa-bell"></i>  <span class="badge badge-warning navbar-badge count_notif">{{ count($notifications['all_notification']) > 0 ? count($notifications['all_notification']) : 0 }}</span>
					</a>
					<div class="dropdown-menu custom_width_for_popup dropdown-menu-right">
						<div class="notify-drop-title">
							<div class="row pr-2 pl-2 pt-2 pb-2">
								<div class="col-md-6 col-sm-6 col-xs-6 mobile_tabs left_popup"> <a href="#" class="rIcon allRead">Mark all read</a>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 mobile_tabs right_popup"> <a href="{{ url('clients/notifications') }}" class="rIcon allRead">See all</a>
								</div>
							</div>
						</div>
						<div class="dropdown-divider"></div>
						<div id="notifications-container"  class="notification_container">
							<!-- notify content -->@if(count($notifications['all_notification']) > 0) @foreach($notifications['all_notification'] as $nkey => $notification)
							<div class="drop-content" id="row-{{$notification->id}}">@if($notification->is_annotation == 1)
								<div class="col-md-9 pd-l0">
									<a href="{{ url('clients/shared/'.$notification->id) }}">
										<label> <i class="fa fa-bell" style="color: #f36523;"></i> {{$notification->title}}</label>
									</a>
								</div>@elseif($notification->is_annotation == 2)
								<div class="col-md-9 pd-l0">
									<a href="{{ url('clients/groups/'.$notification->job_id.'/'.$notification->file_id) }}">
										<label> <i class="fa fa-bell" style="color: #f36523;"></i> {{$notification->title}}</label>
									</a>
								</div>@elseif($notification->is_annotation == 3)
								<div class="col-md-9 pd-l0">
									<a href="{{ url('clients/user/'.$notification->job_id.'/'.$notification->sender) }}">
										<label> <i class="fa fa-bell" style="color: #f36523;"></i> {{$notification->title}}</label>
									</a>
								</div>@elseif($notification->is_annotation == 0)
								<div class="col-md-9 pd-l0">
									<label> <i class="fa fa-bell" style="color: #f36523;"></i> {{$notification->title}}</label>
								</div>@endif
								<div class="col-md-3 col-sm-3 col-xs-3">
									<!-- <div class="notify-img"> --> <a href="javascript:void(0)" onclick="mark_read(<?=$notification->id?>)" data-notif_id="{{$notification->id}}" type="button" class="btn btn-xs btn-default mark_read_btn">Mark read</a>
									<!-- </div> -->
								</div>
								<div class="col-md-12 pd-l0">
									<p>{{$notification->message}}</p>
								</div>
							</div>@endforeach @else
							<div class="drop-content" id="row-else">
								<div class="col-md-12">No new message found</div>
							</div>@endif</div>
					</div>
				</li>
			</ul>
		</nav>
		
		<!-- /.navbar -->
		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar_color elevation-4">
			<!-- Brand Logo -->
			
			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user panel (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="info text-center"> <a href="javascript:;" class="d-block"><font color="white">Hello {{Session::get('client_display_name')}}</font></a>
					</div>
				</div>
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<li class="nav-item">
							<a title="Dashboard" href="{{ url('clients/dashboard/'.Session::get('job_id')) }}" class="nav-link {{ Request::segment(2) == 'dashboard' ? 'active' : '' }} {{ Request::segment(2) == '' ? 'active' : '' }}"> <i class="nav-icon fas fa-tachometer-alt"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<li class="nav-item">
							<a title="My Files" href="{{ url('clients/myfiles/'.Session::get('job_id')) }}" class="nav-link {{ Request::segment(2) == 'myfiles' ? 'active' : '' }}"> <i class="nav-icon fas fa-download"></i>
								<p> My Files</p>
							</a>
						</li>
						<li class="nav-item">
							<a title="My Files" href="{{ url('clients/examination_schedule/'.Session::get('job_id')) }}" class="nav-link {{ Request::segment(2) == 'examination_schedule' ? 'active' : '' }}"> <i class="nav-icon fas fa-file"></i>
							
								<p> Examination Schedule</p>
							</a>
						</li>
						<li class="nav-item">
							<a title="My Files" href="{{ route('Reports') }}" class="nav-link {{ Request::segment(2) == 'reports' ? 'active' : '' }}"> <i class="nav-icon fas fa-file-alt"></i>
								<p> Reports</p>
							</a>
						</li>
						<li class="nav-item">
							<a title="Activity log" href="{{ route('myActivityLog') }}" class="nav-link {{ Request::segment(2) == 'activity-log' ? 'active' : '' }}"> <i class="nav-icon fas fa-th-list"></i>
								<p> Activity log</p>
							</a>
						</li>
						<li class="nav-item has-treeview <?php if(Request::segment(2)=='get-recent-opened' || Request::segment(2)=='get-recent-commented' || Request::segment(2)=='get-recent-annoted' || Request::segment(2)=='get-recent-shared') { ?>  menu-open <?php } ?>" >
							<a href="#" class="nav-link <?php if(Request::segment(2)=='get-recent-opened' || Request::segment(2)=='get-recent-commented' || Request::segment(2)=='get-recent-annoted' || Request::segment(2)=='get-recent-shared') { ?> active<?php } ?>  "> <i class="nav-icon fas fa-file"></i>
								<p>Quick access <i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="{{ url('/clients/get-recent-opened/'.Session::get('job_id')) }}" class="nav-link <?php if(Request::segment(2)=='get-recent-opened') {  ?>active <?php  } ?>"> <i class="far fa-circle nav-icon"></i>
										<p>Recent Opened Files</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ url('/clients/get-recent-annoted/'.Session::get('job_id'))  }}" class="nav-link <?php if(Request::segment(2)=='get-recent-annoted') {  ?>active <?php  } ?>"> <i class="far fa-circle nav-icon"></i>
										<p>Recent annotated files</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ url('/clients/get-recent-commented/'.Session::get('job_id'))  }}" class="nav-link <?php if(Request::segment(2)=='get-recent-commented') {  ?>active <?php  } ?>"> <i class="far fa-circle nav-icon"></i>
										<p>Recent commented files</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ url('/clients/get-recent-shared/'.Session::get('job_id'))  }}" class="nav-link <?php if(Request::segment(2)=='get-recent-shared') {  ?>active <?php  } ?>"> <i class="far fa-circle nav-icon"></i>
										<p>Recent shared files</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="{{ url('clients/logout') }}" class="nav-link"> <i class="fas fa-sign-out-alt ml-2"></i>
								<p class="pl-2">Logout</p>
							</a>
						</li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>
		@endif
		
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper" >
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark">@yield('title')</h1>
						</div>
						<!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="{{ url('clients') }}">Home</a>
								</li>
								<li class="breadcrumb-item active">@yield('title')</li>
							</ol>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</div>
				<!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->
			<!-- Main content -->@yield('content')
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">© {{ date('Y') }} - eTabella - Powered by LegalWare
		</footer>
		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->
	@if(Request::segment(2)=='dashboard' || Request::segment(2)=='')
	<script>
		var zNodes = {!! json_encode($all_nods) !!};
		var whchjobs = {!! json_encode($whchjobs) !!};
	</script>
	@if(Request::segment(2)=='dashboard' || Request::segment(2)=='')
	<script>
	@if(Request::segment(2)=='dashboard' || Request::segment(2)=='' || Request::segment(2)=='myfiles')
	function delete_export_file()
	{
	<?php 
	file_exists(public_path('export.zip')) ? unlink(public_path('export.zip')) : "";
	?>
	}
	@endif
	</script>
	@endif
	@endif
	@if(Request::segment(2)=='from' && Request::segment(3)=='dashboard')
	<script>
	var pspdf_file_id="{{ $file->pspdf_file_id }}";
	</script>
	@endif
	@if(Request::segment(2)=='myfiles')
	<script>
	var zNodes = {!! json_encode($all_nods) !!};
	var zNodes_move = {!! json_encode($all_nods_move) !!};
	var whchjobs = '<?=$whchjobs?>';
	</script>
	@endif
	<!-- jQuery -->
	<script src="{{ url('') }}/public/client_assets/plugins/jquery/jquery.min.js?d={{ date('his') }}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ url('') }}/public/client_assets/plugins/jquery-ui/jquery-ui.min.js?d={{ date('his') }}"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="{{ url('') }}/public/client_assets/plugins/bootstrap/js/bootstrap.bundle.min.js?d={{ date('his') }}"></script>
	<!-- ChartJS -->
	<script src="{{ url('') }}/public/client_assets/plugins/chart.js/Chart.min.js?d={{ date('his') }}"></script>
	<!-- Sparkline -->
	<script src="{{ url('') }}/public/client_assets/plugins/sparklines/sparkline.js?d={{ date('his') }}"></script>
	<!-- JQVMap -->
	<script src="{{ url('') }}/public/client_assets/plugins/jqvmap/jquery.vmap.min.js?d={{ date('his') }}"></script>
	<script src="{{ url('') }}/public/client_assets/plugins/jqvmap/maps/jquery.vmap.usa.js?d={{ date('his') }}"></script>
	<!-- jQuery Knob Chart -->
	<script src="{{ url('') }}/public/client_assets/plugins/jquery-knob/jquery.knob.min.js?d={{ date('his') }}"></script>
	<!-- daterangepicker -->
	<script src="{{ url('') }}/public/client_assets/plugins/moment/moment.min.js?d={{ date('his') }}"></script>
	<script src="{{ url('') }}/public/client_assets/plugins/daterangepicker/daterangepicker.js?d={{ date('his') }}"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{ url('') }}/public/client_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js?d={{ date('his') }}"></script>
	<!-- Summernote -->
	<script src="{{ url('') }}/public/client_assets/plugins/summernote/summernote-bs4.min.js?d={{ date('his') }}"></script>
	<!-- overlayScrollbars -->
	<script src="{{ url('') }}/public/client_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js?d={{ date('his') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ url('') }}/public/client_assets/dist/js/adminlte.js?d={{ date('his') }}"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js?d={{ date('his') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js?d={{ date('his') }}"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js?d={{ date('his') }}"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js?d={{ date('his') }}" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js?d={{ date('his') }}"></script>
	<script type="text/javascript" src="{{asset('public/frontend/dist/js/jquery.atwho.js?d='.date('his'))}}"></script>
	<script type="text/javascript" src="{{asset('public/frontend/dist/js/jquery.atwho.min.js?d='.date('his'))}}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/caret/1.3.7/jquery.caret.min.js?d={{ date('his') }}"></script>
	<!-- Ztree Scripts -->
	<script type="text/javascript" src="{{asset('public/frontend/ztree/js/jquery.ztree.all.js?d='.date('his'))}}"></script>
	<script type="text/javascript" src="{{asset('public/frontend/ztree/js/jquery.ztree.core.js?d='.date('his'))}}"></script>
	<script type="text/javascript" src="{{asset('public/frontend/ztree/js/jquery.ztree.excheck.js?d='.date('his'))}}"></script>
	<script type="text/javascript" src="{{asset('public/frontend/ztree/js/jquery.ztree.exedit.js?d='.date('his'))}}"></script>
	<script type="text/javascript" src="{{asset('public/frontend/ztree/js/jquery.ztree.exhide.js?d='.date('his'))}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js?d={{ date('his') }}"></script>
	<!--       <script src="{{asset('public/dist/pspdfkit.js')}}"></script> -->
	<script src="http://web.etabella.com:5000/pspdfkit.js?d={{ date('his') }}"></script>
	<!-- For Datatable Js -->
	<!-- <script src=" https://code.jquery.com/jquery-3.3.1.js"></script> -->
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js?d={{ date('his') }}"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js?d={{ date('his') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js?d={{ date('his') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js?d={{ date('his') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js?d={{ date('his') }}"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js?d={{ date('his') }}"></script>
	<!-- jqury scrol -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js?d={{ date('his') }}"></script>
	<script src="https://printjs-4de6.kxcdn.com/print.min.js?d={{ date('his') }}"></script>
	<!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js?d={{ date('his') }}"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js?d={{ date('his') }}"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js?d={{ date('his') }}"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="{{ url('') }}/public/client_assets/dist/js/demo.js?d={{ date('his') }}"></script>
	<script src="{{ asset('public/frontend/vendor/sweetalert/new/sweetalert.min.js?d='.date('his')) }}"></script>
	<script src="{{ asset('public/frontend/js/jquery-dateformat.js?d='.date('his')) }}"></script>
	<script src="{{ asset('public/js/timezone.js?d='.date('his')) }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js?d={{ date('his') }}"></script>
	<script src="{{ asset('public/client_assets/pages/js/app.js?d='.date('his')) }}"></script>
	<script src="{{ asset('public/js/custom.js') }}"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js?d={{ date('his') }}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js?d={{ date('his') }}"></script>
	@if(Request::segment(2)=='dashboard' || Request::segment(2)=='')
		<script src="{{ asset('public/client_assets/pages/js/dashboard.js?d='.date('his')) }}"></script>
	@endif
	@if(Request::segment(2)=='from' && Request::segment(3)=='dashboard')
		<script src="{{ asset('public/client_assets/pages/js/from_dashboard.js?d='.date('his')) }}"></script>
	@endif
	@if(Request::segment(2)=='myfiles')
		<script src="{{ asset('public/client_assets/pages/js/myfiles.js?d='.date('his')) }}"></script>
	@endif
	@if(Request::segment(3)=='render' && $page_status==1) 
		<script type="text/javascript">
		var id = "{{$id}}";
		var zNodes = {!! json_encode($all_nods) !!};
		var zNodes_dd = {!! json_encode($all_nods_dd) !!};
		var zNodes_links = {!! json_encode($all_add_to_links) !!};
		var page ={{ $page }};
		var current_job_id="{{Session::get("job_id")}}";
		$( document ).ready(function() {
			
		  $('body').css("background-color","rgba(255, 165, 0, 0.1)!important");
			$('body').css("opacity","0.1");
		   
			setTimeout(function(){
			  $('body').css("background-color","#fff !important");
			  $('body').css("opacity","1");
			},2000);

		});
		</script>
		<script src="{{ asset('public/client_assets/pages/js/check.js?d='.date('his')) }}"></script>
	@endif
	@if(Request::segment(2)=='examination_schedule')
		<script src="{{ asset('public/client_assets/pages/js/examination_schedule.js?d='.date('his')) }}"></script>
	@endif
	@if(Request::segment(2)=='examination_schedule_inner')
		<script src="{{ asset('public/client_assets/pages/js/examination_schedule_inner.js?d='.date('his')) }}"></script>
	@endif
	@if(Request::segment(2)=='manage_docs')
		<script src="{{ asset('public/client_assets/pages/js/manage_docs.js?d='.date('his')) }}"></script>
		<script>
			var zNodes = {!! json_encode($all_nods) !!};
			var zNodes_move = {!! json_encode($all_nods_move) !!};
			var segment3={{ Request::segment(3) }};
			var segment4={{ Request::segment(4) }};
		</script>
	@endif
	@if(Request::segment(2)=='examination_schedule_render' && $page_status==1)
		<script type="text/javascript">
		var id = "{{$id}}";
		var zNodes = {!! json_encode($all_nods) !!};
		var zNodes_dd = {!! json_encode($all_nods_dd) !!};
		var zNodes_links = {!! json_encode($all_add_to_links) !!};
		var page ={{ $page }};
		var current_job_id="{{Session::get("job_id")}}";
		var segment4={{Request::segment(4)}};
		$( document ).ready(function() {
			
		  $('body').css("background-color","rgba(255, 165, 0, 0.1)!important");
			$('body').css("opacity","0.1");
		   
			setTimeout(function(){
			  $('body').css("background-color","#fff !important");
			  $('body').css("opacity","1");
			},2000);

		});
		</script>
		<script src="{{ asset('public/client_assets/pages/js/examination_schedule_render.js?d='.date('his')) }}"></script>
	@endif
	
	@if(Request::segment(2)=='compare' || Request::segment(2)=='compare-file')
		<script type="text/javascript">
		const arr_pages_1 = <?=json_encode($arr_book_pages_1)?>;
		const arr_pages_2 = <?=json_encode($arr_book_pages_2)?>;
		var first_id = "{{$first_id}}";
		var second_id = "{{$second_id}}";
		var zNodes = {!! json_encode($all_nods) !!};
		</script>
		<script src="{{ asset('public/client_assets/pages/js/compare.js?d='.date('his')) }}"></script>
	@endif
	@if(Request::segment(2)=='reports')
	<script type="text/javascript">
	  var all_counts = '<?=count($reports)?>';
	  var annot_counts = '<?=count($annotations)?>';
	  var hyper_counts = '<?=count($hyperlinks)?>';
	  var book_counts = '<?=count($bookmarks)?>';
	  var issue_counts = '<?=count($issues)?>';	
	</script>
	<script src="{{ asset('public/client_assets/pages/js/reports.js?d='.date('his')) }}"></script>
	@endif
	@if(Request::segment(2)=='activity-log')
	<script type="text/javascript">
	   var counts = '<?=count($users)?>';
	</script>
	<script src="{{ asset('public/client_assets/pages/js/activity_log.js?d='.date('his')) }}"></script>
	@endif
	@if(Request::segment(2)=='get-recent-opened' || Request::segment(2)=='get-recent-commented' || Request::segment(2)=='get-recent-annoted' || Request::segment(2)=='get-recent-shared')
		<script>
		var counts = '<?=count($quicks)?>';
		var segment2="{{ Request::segment(2) }}";
		var segment3="{{ Request::segment(3) }}";
		var type="{{ $type }}";
		</script>
		<script src="{{ asset('public/client_assets/pages/js/recent.js?d='.date('his')) }}"></script>
	@endif
	@if(Request::segment(2)=='message_notification' || Request::segment(2)=='notifications')
	<script type="text/javascript">
	    var counts = '<?=count($allnotifications)?>';
	</script>
	<script src="{{ asset('public/client_assets/pages/js/message_notification.js?d='.date('his')) }}"></script>
	@endif
	@if(Request::segment(2)=='groups' || Request::segment(2)=='groups-single')
	<script>
		var mem_str = '<?php echo json_encode($member_names) ?>';
		var whchjobs = '<?php echo $whchjobs ?>';
		var authfirstTwoCharacters = '<?=$authfirstTwoCharacters?>';
		mem_str = JSON.parse(mem_str);
		console.log(mem_str);
		var my_name = '{{ucfirst(Session::get("client_display_name"))}}';
		@if($selected_grp)
			var grp_id="{{ $selected_grp->group_id }}";
		@else 
			var grp_id='';
		@endif
		var curr_date = '{{ date('M d , g:ia') }}';
	</script>
	<script src="{{ asset('public/client_assets/pages/js/groups.js?d='.date('his')) }}"></script>	
	@endif
	@if(Request::segment(2)=='topics' || Request::segment(2)=='topics-single')
		<script>
			var mem_str = '<?php echo json_encode($member_names) ?>';
			mem_str = JSON.parse(mem_str);
			var my_name = '{{ucfirst(Session::get("client_display_name"))}}';
			var authfirstTwoCharacters = '<?=$authfirstTwoCharacters?>';
			@if($tid)
				var tid={{ $tid }};
			@else 
				var tid='';
			@endif
			var curr_date = '{{ date('M d , g:ia') }}';
		</script>
		<script src="{{ asset('public/client_assets/pages/js/topics.js?d='.date('his')) }}"></script>	
	@endif
	@if(Request::segment(2)=='user' || Request::segment(2)=='user-single')
		<script>
		  var my_name = '{{ucfirst(Session::get("client_display_name"))}}';
		  var sel_user_id = "{{ $selected_user ? $selected_user->client_id : '' }}";
		  var whchjobs = '<?php echo $whchjobs ?>';
		  var authfirstTwoCharacters = '<?php echo $authfirstTwoCharacters ?>'; 
		  var selected_job="{{ $selected_user->client_id }}";
		  var curr_date = '{{ date('M d , H:i A') }}';
		</script>
		<script src="{{ asset('public/client_assets/pages/js/user.js?d='.date('his')) }}"></script>	
	@endif
	@if(Request::segment(2)=='shared')
		<script>
		 var pspdf_file_id="{{ $file->pspdf_file_id }}";
		 var layer_token="{{ $layer_token }}";
		 var fid="{{ $file->file_id }}";
		 var sender="{{ $sender }}";
		</script>
		<script src="{{ asset('public/client_assets/pages/js/file_render.js?d='.date('his')) }}"></script>	
	@endif
	</body>
</html>