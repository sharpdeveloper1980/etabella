@extends('layouts.client.app') 
@section('title',$title) 
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header">
				<div class="row">
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						<input type="text" name="daterange" class="pull-right btn btn-info daterange form-control" />
					 </div>
				</div>
			</div>
			<div class="card-body" >
				<div id="dvData" class="table_box">
				<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_1" role="grid" aria-describedby="sample_1_info">
					<thead>
					  <tr role="row">
						  <th>Filename</th>
						  @if($type=='commented')
						  <th>Comment</th>
						  @endif
						  @if($type=="shared")
						  <th>Reciepient</th>
						  @endif
						  <th>Date</th>
					  </tr>
					</thead>
					<tbody id="reportList">
					  @if(count($quicks) > 0)
					  @foreach($quicks as $quickkey => $quick)
						<tr>
						  <td>
							<a href="{{ url('clients/file/render/'.$quick->file_id) }}">
							{{ $quick->file_name }}
							</a>
						  </td>
						   @if($type=='commented')
						   <td>{{ $quick->comment }}</td>
						   @endif
						   @if($quick->type == 4)
						  <td>
							{{$quick->reciepient}}
						  </td>
						  @endif
						  <td>
						  @if($type=='commented')
						  {{ date("M d , H:i A", strtotime($quick->created_at)) }}
						  @else 
							 {{ date('M d, Y H:i:s', $quick->created_at) }}
						  @endif
						  </td>
						</tr>
					  @endforeach
					  @else
					   <tr>
						  <td colspan="2" style="text-align: center;">
						  No files found here.. 
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