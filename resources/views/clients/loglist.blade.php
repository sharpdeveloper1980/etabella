@extends('layouts.client.app') 
@section('title','Activity Log') 
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header">
				<div class="row text-center">
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						<input type="text" name="daterange" class="pull-right btn btn-info daterange form-control" />
					 </div>
				</div>
			</div>
			<div class="card-body" >
				<div class="panel-body table_box" id="dvData">
					<table class="table table-hover" id="sample_1">
					  <thead>
						 <th><a>No.</a>
						 </th>
						 <th><a>Description</a></th>
						 <th><a>Action</a></th>
						 <th><a>Type</a></th>
						 <th><a>Date</a></th>
					  </thead>
					  <tbody>
						 @if(count($users) > 0)
						 <?php $i=1; ?>
						 @foreach($users as $userkey => $user)
						 <tr>
							<td>{{ $i }}</td>
							
							<td>
							  {{$user->description}}             
							</td>
							
							<td>
							   {{$user->action}}
							</td>
							
							<td>
							  @if($user->type == 1)
								Admin
							  @elseif($user->type == 2)
								Manager
							  @elseif($user->type == 3)
								Developer
							  @else
								Client
							  @endif  
							</td>
							
							<td>{{ date('M d, Y H:i:s', $user->created_at) }}</td>
						 </tr>
					  <?php $i++; ?>
						 @endforeach
						 @else
						 <tr>
						   <td colspan="7">
							<center>
							  <label class="alert alert-warning">
								No data found on this date range
							  </label>
							</center> 
						   </td>
						 </tr>
						 @endif
					  </tbody>
					</table>
				   
				</div>
			</div>
		</div>
	</div>
</section>
@endsection