@extends('layouts.client.app') 
@section('title','Examination schedule') 
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header">
				<div class="row second_header">
				  <div class="col-sm-12">
					  <ul class="dashboard_control float-right">
						<li>
							<div class="search_sorting" id="search_files" data-toggle="tooltip" title="Search">
							   <input type="text" name="search" class="form-control search_witness" placeholder="Search here">
							   <i class="fa fa-search" aria-hidden="true"></i>

							   <input type="hidden" name="job" class="selected_job" value="{{$whchjobs}}">
							</div>
						</li>
						<li>
							<button data-toggle="modal"  data-target="#create_witness" type="button" class="action-button" >
								<span data-toggle="tooltip" title="Create Witness">Create Witness</span>
							</button> 
						</li>
						<li>
							<button  type="button" id="copy_witness" class="action-button" >
								<span data-toggle="tooltip" title="Copy Witness">Copy Witness</span>
							</button>
						</li>
						<li>
							<button  type="button" id="Modify" class="action-button" >
								<span data-toggle="tooltip" title="Modify">Modify</span>
							</button> 
						</li>
						<li>
						   <button  type="button" id="Delete" class="action-button" >
								<span data-toggle="tooltip" title="Delete">Delete</span>
						   </button>
						</li>
					  </ul>
				  </div>
			   </div>
			</div>
			<div class="card-body">
				<div class="container">
					<div id="witness_container">
						@if($all_witness)
							<ul class="list-group examination_schedule_inner_control" id="sortable" >
								@foreach($all_witness as $witness)
								<li class="list-group-item"  id="{{ $witness['id'] }}" data-id="{{ $witness['id'] }}" >
								<div style=" float: left; width: 25px; padding-top: 3px; "><input class="witness" type="checkbox" value="{{ $witness['id']  }}" ></div> <a href="{{ asset('clients/manage_docs/'.$witness['id']) }}/{{ Session::get('job_id') }}"><div><span id="wit_name_{{ $witness['id'] }}">
								{{ $witness['witness_name'] }}<i style=" float: right; " class="fa fa-chevron-right float-right" aria-hidden="true"></i></div></a>
								</li>
								@endforeach
							</ul>
						@else 
							<h3 align="center">Witness Not Found</h3>
						@endif
					</div>
				</div>
			</div>
			<!-- /.card-footer-->
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- upload files modal -->
<div id="create_witness" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
		<h4 class="modal-title">Create New Witness</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="{{ asset('clients/create_witness') }}" class="database_operation_form">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Enter Witness Name</label>
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
					<input type="text" name="witness_name" placeholder="Enter Witness Name" class="form-control" />
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<button class="btn btn-info">Add</button>
				</div>
			</div>
		</div>
		</form>
      </div>
    </div>

  </div>
</div>
<div id="Modify_witness" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
		<h4 class="modal-title">Modify Witness</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="{{ asset('clients/modify_witness') }}" class="database_operation_form">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Enter Witness Name</label>
					<input type="hidden" name="_token"  value="{{ csrf_token() }}">
					<input type="hidden" name="witness_id" id="witness_id" />
					<input type="text" name="witness_name" required="required" id="witness_name" placeholder="Enter Witness Name" class="form-control" />
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<button class="btn btn-info">Modify</button>
				</div>
			</div>
		</div>
		</form>
      </div>
    </div>

  </div>
</div>


<div id="copy_witness_popup" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
		<h4 class="modal-title">Copy Witness</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="{{ asset('clients/copy_witness') }}" class="database_operation_form">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Enter New Witness Name</label>
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
					<input type="hidden" name="witness_old_id" id="witness_old_id" />
					<input type="text" name="witness_name" placeholder="Enter Witness Name" class="form-control" />
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<button class="btn btn-info">Add</button>
				</div>
			</div>
		</div>
		</form>
      </div>
    </div>

  </div>
</div>
@endsection