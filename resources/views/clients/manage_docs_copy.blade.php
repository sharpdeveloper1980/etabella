@extends('layouts.client.app') 
@section('title','Examination schedule') 
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header">
				<div class="row second_header">
				 <div class="col-sm-4 not_mobile">
					<button class="go_back" onclick="goBack()" data-toggle="tooltip" title="Go Back">Go Back</button>
				</div>
				@if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
							|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
							, $_SERVER["HTTP_USER_AGENT"])) 
				  <div class="col-sm-8 not_mobile">
					  <ul class="dashboard_control float-right">
						<li>
							<div class="search_sorting" id="search_files" data-toggle="tooltip" title="Search">
							   <input type="text" name="search" class="form-control search_witness_files" placeholder="Search here">
							   <i class="fa fa-search" aria-hidden="true"></i>
							   <input type="hidden" name="job" class="selected_job" value="{{$whchjobs}}">
							</div>
						</li>
						<li>
							<button data-toggle="modal" data-target="#add_doc" data-toggle="tooltip" title="Add Doc" type="button" class="action-button" >
								Add Doc 
							</button> 
						</li>
						<li>
							<button  type="button" id="go_to" data-toggle="tooltip" title="Go To" data-witness="{{ Request::segment(3) }}" class="action-button" >
								Go To
							</button>
						</li>
						<li>
							<button  type="button" id="Modify" data-toggle="tooltip" title="Modify"  class="action-button" >
								Modify
							</button> 
						</li>
						<li>
						   <button  type="button" id="move_to" data-toggle="tooltip" title="Move To" class="action-button" >
								Move To
							</button>
						</li>
						<li>
							<button  type="button" id="Delete" data-witness="{{ Request::segment(3) }}" data-toggle="tooltip" title="Delete" class="action-button" >
								Delete
							</button>
						</li>
						<li>
							<button type="button" class="action-button" onclick="refreshPage(9)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh"><i class="fas fa-redo" data-toggle="tooltip" title="Refresh" aria-hidden="true"></i>
							</button>
						</li>
					  </ul>
				  </div>
				  @endif
				  @if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
							|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
							, $_SERVER["HTTP_USER_AGENT"]))
				  <div class="col-sm-12 for_mobile">
					  <ul class="dashboard_control float-right">
						<li>
							<div class="search_sorting" id="search_files" data-toggle="tooltip" title="Search">
							   <input type="text" name="search" class="form-control search_witness_files" placeholder="Search here">
							   <i class="fa fa-search" aria-hidden="true"></i>
							   <input type="hidden" name="job" class="selected_job" value="{{$whchjobs}}">
							</div>
						</li>
						<li>
							<button data-toggle="modal" id="doc_add" data-target="#add_doc" data-toggle="tooltip" title="Add Doc" type="button" class="action-button" >
								Add Doc
							</button> 
						</li>
						<li>
							<button  type="button" id="go_to" data-toggle="tooltip" title="Go To" data-witness="{{ Request::segment(3) }}" class="action-button" >
								Go To
							</button>
						</li>
						<li>
							<button  type="button" id="Modify" data-toggle="tooltip" title="Modify"  class="action-button" >
								Modify
							</button> 
						</li>
						<li>
						   <button  type="button" id="move_to" data-toggle="tooltip" title="Move To" class="action-button" >
								Move To
							</button>
						</li>
						<li>
							<button  type="button" id="Delete" data-witness="{{ Request::segment(3) }}" data-toggle="tooltip" title="Delete" class="action-button" >
								Delete
							</button>
						</li>
						<li>
							<button type="button" class="action-button" onclick="refreshPage(9)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh"><i class="fas fa-redo" data-toggle="tooltip" title="Refresh" aria-hidden="true"></i>
							</button>
						</li>
					  </ul>
				  </div>
				  @endif
			   </div>
			</div>
			<div class="card-body">
				<div class="container">
					<div class="page-101">
						<div class="row">
							<div  class="col-sm-12">
								 <div class="file_container">
										@if($all_witness_file)
										<ul class="list-group" id="sortable" >
											<?php
												$i=1; 
											?>
											@foreach($all_witness_file as $file)
												<?php  
												$color = (new \App\Helpers\Helper)->get_file_tag(Session::get('client_id'),$file['doc_id']);  
													$file_extension = strtolower(substr(strrchr($file['file_name'], "."), 1));
													$url = asset('public/storage/files/'.$file['file_upload_name']); 
												?>
												@if($file_extension=='pdf')
												<li  class="list-group-item"  id="{{ $file['id'] }}" data-id="{{ $file['id'] }}" >
													<a href="{{ asset('clients/examination_schedule_render/'.$file['doc_id']).'/'.Request::segment(3) }}"><div style="width:93%;float:left"><span >{{ $i }}</span> &nbsp; <span1 style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span1> &nbsp; <img style="width:20px" class="file_iocn" src="{{ asset('public/images/pdf.ico') }}"> {{ $file['file_name'] }}</div></a>
													<div><input type="checkbox" value="{{ $file['id'] }}" class="witness_files" /></div>
												</li>
												@elseif($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx')
												<li  class="list-group-item"  id="{{ $file['id'] }}" data-id="{{ $file['id'] }}" >
													<a href="javascript:;" onclick="popupwindow('{{  $url }}','doc')"><div style="width:93%;float:left"><span >{{ $i }}</span> &nbsp; <span1 style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span1> &nbsp; <img style="width:20px" class="file_iocn" src="{{ url('public/images/doc.png') }}"> {{ $file['file_name'] }}</div></a>
													<div><input type="checkbox" value="{{ $file['id'] }}" class="witness_files" /></div>
												</li>
												@elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg')
												<li  class="list-group-item"  id="{{ $file['id'] }}" data-id="{{ $file['id'] }}" >
													<a href="javascript:;" onclick="popupwindow('{{  $url }}','doc')"><div style="width:93%;float:left"><span >{{ $i }}</span> &nbsp; <span1 style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span1> &nbsp; <img style="width:20px" class="file_iocn" src="{{ url('public/images/image.png') }}"> {{ $file['file_name'] }}</div></a>
													<div><input type="checkbox" value="{{ $file['id'] }}" class="witness_files" /></div>
												</li>
												@else
												<li  class="list-group-item"  id="{{ $file['id'] }}" data-id="{{ $file['id'] }}" >
													<a href="javascript:;" onclick="popupwindow('{{  $url }}','img')"><div style="width:93%;float:left"><span >{{ $i }}</span> &nbsp; <span1 style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span1> &nbsp;<img style="width:20px" class="file_iocn" src="{{ url('public/images/play.png')}}"> {{ $file['file_name'] }}</div></a>
													<div><input type="checkbox" value="{{ $file['id'] }}" class="witness_files" /></div>
												</li>	
												@endif
											<?php $i++; ?>
											@endforeach
										</ul>
										@else 
										<h2 align="center">File Not Found</h2>
										@endif
								 </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.card-footer-->
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<div id="add_doc" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add New Doc</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="container" style="width:auto;min-height: 200px !important;">
					<ul id="treeDemo" class="ztree">
					</ul>
				</div>
			</div>
		</div>
      </div>
	  <div class="modal-footer">
       <div class="row" style=" width: 100%; ">
		   <div class="col-sm-6">
			<button class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
		   </div> 
		   <div class="col-sm-6">
			<button id="add_files" data-witness="{{ Request::segment(3) }}" value="{{ $whchjobs }}" class="btn btn-default btn-block">Add</button>
		   </div>
	   </div>
      </div>
    </div>
  </div>
</div>



<div id="doc_Modify" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
		<h4 class="modal-title">Modify Doc</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="container" style="width:auto;min-height: 200px !important;">
					<input type="hidden" name="selected_doc" id="selected_doc" value="" />
					<ul id="treeDemo_Modify" class="ztree">
					</ul>
				</div>
			</div>
		</div>
      </div>
	  <div class="modal-footer">
       <div class="row" style="width:100%">
			<div class="col-sm-6">
			<button class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
		   </div>
		   <div class="col-sm-6">
			<button id="Modify_files" data-witness="{{ Request::segment(3) }}" value="{{ $whchjobs }}" class="btn btn-default btn-block">Modify</button>
		   </div>
	   <div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<div id="move_to_popup" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
		<h4 class="modal-title">Move At Index</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p align="center">(Current Index : <span id="current_index">0</span>)</p>
				<form action="{{ asset('clients/move_to_witness_file') }}" class="database_operation_form">
				<div class="form-group ">
					<label>Enter New Index No</label>
					<input type="hidden" name="current_index_field" id="current_index_field" class="form-control" />
					<input type="hidden" name="current_id" id="current_id" class="form-control" />
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
					<input type="hidden" name="witness" value="{{ Request::segment(3) }}">					
					<input type="number" required="required" name="new_index" class="form-control" id="new_index" placeholder="Enter New Index" />
				</div>
				<div class="form-group">
					<button class="btn btn-info">Change Index</button>
				</div>
				</form>
	  </div>
    </div>
    </div>

  </div> 
@endsection