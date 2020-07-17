@extends('layouts.client.app') 
@section('title','Report') 
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header" style="display:none">
				
			</div>
			<div class="card-body" >
				<ul class="nav nav-tabs report_tab">
				  <li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#all">All</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#annotations">Annotations</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#hyperlinks">Hyperlinks</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#bookmarked">Bookmarked</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#issues">Issues</a>
				  </li>
				</ul><br>

				<!-- Tab panes -->
				<div class="tab-content">
				  <div class="tab-pane container active" id="all">
					<div class="loader" style="display: none;"></div>
						 <div class="row">
						   <div class="col-sm-4"></div>
						   <div class="col-sm-4">
							<input  type="text" name="daterange" class="daterange btn btn-info daterange_1 form-control" data-tablecont="table_container_1" data-tableid="sample_1" data-reporttype="all" />
						   </div> 
						 </div>
					 
						 <div class="container table_box" id="table_container_1" @if(count($reports)==0) style="margin-top:50px;" @endif>
							<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_1" role="grid" aria-describedby="sample_1_info">
							  <thead>
								<tr role="row">
									<th>Filename</th>
									<th>Date Modified</th>
									<th>Reference</th>
									<th>Status</th>
								</tr>
							  </thead>
							  <tbody id="reportList">
								@if(count($reports) > 0)
								@foreach($reports as $cldkey => $my_cloud)
								  <tr>
									<td>
									  <a href="{{url('clients/file/render/'.$my_cloud->file_id.'/'.$my_cloud->page)}}">{{ $my_cloud->file_name }}</a>
									</td>
									<td>
									  {{ date('M d, Y H:i:s', $my_cloud->created_at) }}
									</td>
									<td>
									  <a class="btn btn-default" href="{{url('clients/file/render/'.$my_cloud->file_id.'/'.$my_cloud->page)}}">Page {{ $my_cloud->page }}</a>
									</td>
									<td>
									  {{ $my_cloud->type }}
									</td>
								  </tr>
								@endforeach
								@else
								<tr>
								  <td colspan="3" style="text-align: center;">No data found yet</td>
								</tr>
								@endif
							  </tbody>
							</table>
						  </div>
				  </div>
				  <div class="tab-pane container fade" id="annotations">
					<div class="loader" style="display: none;"></div>    
					 <div class="row">
					   <div class="col-sm-4"></div>
					   <div class="col-sm-4">
						<input type="text" name="daterange" class="btn btn-info daterange daterange_2 form-control" data-tablecont="table_container_2" data-tableid="sample_2" data-reporttype="Annotation" />
					   </div>
					 </div>
				
					 <div class="container table_box" id="table_container_2" @if(count($annotations)==0) style="margin-top:50px;" @endif>
						<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_2" role="grid" aria-describedby="sample_2_info">
						  <thead>
							<tr role="row">
								<th>Filename</th>
								<th>Date</th>
								<th>Page</th>
								<th>Type</th>
							</tr>
						  </thead>
						  <tbody id="reportList">
							@if(count($annotations) > 0)
							@foreach($annotations as $akey => $annotation)
							  <tr>
								<td>
								  <a href="{{url('clients/file/render/'.$annotation->file_id.'/'.$annotation->page)}}">{{ $annotation->file_name }}</a>
								</td>
								<td>
								  {{ date('M d, Y H:i:s', $annotation->created_at) }}
								</td>
								<td>
								  <a class="btn btn-default" href="{{url('clients/file/render/'.$annotation->file_id.'/'.$annotation->page)}}">Page {{ $annotation->page }}</a>
								</td>
								<td>
								  {{ $annotation->type }}
								</td>
							  </tr>
							@endforeach
							@else
							<tr>
							  <td colspan="3" style="text-align: center;">No data found yet</td>
							</tr>
							@endif
						  </tbody>
						</table>
					  </div>
				  </div>
				  <div class="tab-pane container fade" id="hyperlinks">
					<div class="loader" style="display: none;"></div>
					 <div class="row">
					  <div class="col-sm-4"></div>
					   <div class="col-sm-4">
						<input type="text" name="daterange" class="btn btn-info daterange daterange_3 form-control" data-tablecont="table_container_3" data-tableid="sample_3" data-reporttype="Hyperlink" />
					   </div>
					 </div>
				
					 <div class="container table_box" id="table_container_3" @if(count($hyperlinks)==0) style="margin-top:50px;" @endif>
						<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_3" role="grid" aria-describedby="sample_3_info">
						  <thead>
							<tr role="row">
								<th>Filename</th>
								<th>Date</th>
								<th>Page</th>
								<th>Type</th>
							</tr>
						  </thead>
						  <tbody id="reportList">
							@if(count($hyperlinks) > 0)
							@foreach($hyperlinks as $hkey => $hyperlink)
							  <tr>
								<td>
								  <a href="{{url('clients/file/render/'.$hyperlink->file_id.'/'.$hyperlink->page)}}">{{ $hyperlink->file_name }}</a>
								</td>
								<td>
								  {{ date('M d, Y H:i:s', $hyperlink->created_at) }}
								</td>
								<td>
								  <a class="btn btn-default" href="{{url('clients/file/render/'.$hyperlink->file_id.'/'.$hyperlink->page)}}">Page {{ $hyperlink->page }}</a>
								</td>
								<td>
								  {{ $hyperlink->type }}
								</td>
							  </tr>
							@endforeach
							@else
							<tr>
							  <td colspan="3" style="text-align: center;">No data found yet</td>
							</tr>
							@endif
						  </tbody>
						</table>
					  </div>
				  </div>
				  
				  <div class="tab-pane container fade" id="bookmarked">
						<div class="loader" style="display: none;"></div>
							 <div class="row">
							   <div class="col-sm-4"></div>
						       <div class="col-sm-4">
								<input type="text" name="daterange" class="btn btn-info daterange daterange_4 form-control" data-tablecont="table_container_4" data-tableid="sample_4" data-reporttype="Bookmarked" />
							   </div>
							 </div>
						
							 <div class="container table_box" id="table_container_4" @if(count($bookmarks)==0) style="margin-top:50px;" @endif>
								<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_4" role="grid" aria-describedby="sample_4_info">
								  <thead>
									<tr role="row">
										<th>Filename</th>
										<th>Date</th>
										<th>Page</th>
										<th>Type</th>
									</tr>
								  </thead>
								  <tbody id="reportList">
									@if(count($bookmarks) > 0)
									@foreach($bookmarks as $bkey => $bookmark)
									  <tr>
										<td>
										  <a href="{{url('clients/file/render/'.$bookmark->file_id.'/'.$bookmark->page)}}">{{ $bookmark->file_name }}</a>
										</td>
										<td>
										  {{ date('M d, Y H:i:s', $bookmark->created_at) }}
										</td>
										<td>
										  <a class="btn btn-default" href="{{url('clients/file/render/'.$bookmark->file_id.'/'.$bookmark->page)}}">Page {{ $bookmark->page }}</a>
										</td>
										<td>
										  {{ $bookmark->type }}
										</td>
									  </tr>
									@endforeach
									@else
									<tr>
									  <td colspan="4" style="text-align: center;">No data found yet</td>
									</tr>
									@endif
								  </tbody>
								</table>
							  </div>
				  </div>
				  <div class="tab-pane container fade" id="issues">
					<div class="loader" style="display: none;"></div>  
						 <div class="row">
						   <div class="col-sm-4"></div>
						   <div class="col-sm-4">
							<input type="text" name="daterange" class="btn btn-info daterange daterange_5 form-control" data-tablecont="table_container_5" data-tableid="sample_5" data-reporttype="Issues" style=" margin-left: 15px; " />
						   </div>
						 </div>
				   
						 <div class="container table_box" id="table_container_5" @if(count($issues)==0) style="margin-top:50px;" @endif>
							<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_5" role="grid" aria-describedby="sample_5_info">
							  <thead>
								<tr role="row">
									<th>Filename</th>
									<th>Date</th>
									<th>Page</th>
									<th>Type</th>
								</tr>
							  </thead>
							  <tbody id="reportList">
								@if(count($issues) > 0)
								@foreach($issues as $ikey => $issue)
								  <tr>
									<td>
									  <a href="{{url('clients/file/render/'.$issue->file_id.'/'.$issue->page)}}">{{ $issue->file_name }}</a>
									</td>
									<td>
									  {{ date('M d, Y H:i:s', $issue->created_at) }}
									</td>
									<td>
									  <a class="btn btn-default" href="{{url('clients/file/render/'.$issue->file_id.'/'.$issue->page)}}">Page {{ $issue->page }}</a>
									</td>
									<td>
									  {{ $issue->type }}
									</td>
								  </tr>
								@endforeach
								@else
								<tr>
								  <td colspan="4" style="text-align: center;">No data found yet</td>
								</tr>
								@endif
							  </tbody>
							</table>
						  </div>
				  </div>
				</div>				
			</div>
		</div>
	</div>
</section>
@endsection