@extends('layouts.client.app')
@section('title',$title)
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/daterangepicker.css')}}" />
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    @stop
    @section('content')
   <div class="row second_header">
      <img src="{{asset('public/frontend/img/Untitled.png')}}" style="float:left;" class="case_icon">
      <div class="dropdown jobs-dd">
         <label class="btn  dropdown-toggle" type="button" data-toggle="dropdown">My Cases({{$active_job->job_name}})
         <span class="fa fa-chevron-down" style="color: #f36523"></span></label>
         <ul class="dropdown-menu job-dropdown menu_case">
            @if($jobs)
               @foreach($jobs as $jkey => $job)
         		
         
         	@if($type=='shared')
               <li><a href="{{ url('/clients/get-recent-shared/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>
         	@endif
         	@if($type=='opened')
               <li><a href="{{ url('/clients/get-recent-opened/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>
         	@endif
         	@if($type=='annoted')
               <li><a href="{{ url('/clients/get-recent-annoted/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>
         	@endif
         	@if($type=='commented')
               <li><a href="{{ url('/clients/get-recent-commented/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>
         	@endif

                @if($job->job_id == $whchjobs)
                  <input type="hidden" value="{{ $job->job_name }}" class="active_jobname">
                @endif

               @endforeach
            @endif
         </ul>
      </div>
   </div>
   
      <div class="container" id="table_container">
	    <div class="panel-body">
		  <div class="col-lg-6 col-lg-offset-3">
			<input type="text" name="daterange" class="pull-right btn btn-info daterange form-control" />
		  </div>
		</div>
		<div id="dvData">
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
<!-- upload files modal -->
@section('js')
<script type="text/javascript">
 var counts = '<?=count($quicks)?>';
if(counts>0)
	var lst=1;
else 
	var lst=0;

$('input[name="daterange"]').daterangepicker({
       opens: 'right',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate = start.format('YYYY-MM-DD');
      var endDate = end.format('YYYY-MM-DD')
       
       $.ajax({
             type: "POST",
             url: baseurl+"/clients/render-quick/{{ Request::segment(3) }}/{{ $type }}",
             data: {_token: "{{ csrf_token() }}",startDate:startDate,endDate:endDate},
             success: function(data)
             {
				resp=$.parseJSON(data);
              
                  console.log(resp);
				 
				  if(resp.status==1)
				  {
					if(lst==1)
						destroy_datatable();
				  }
				  lst=resp.status;
                  $("#dvData").html(resp.data);
				  
				  if(resp.status==1)
				  {
					init_datatable();
				  }
          
             }
       });
   });
   
 
 if(counts>0)
 {
 $('#sample_1').DataTable({
	 @if(Request::segment(2)=='get-recent-shared' || Request::segment(2)=='get-recent-commented')
	 "order": [[ 2, "desc" ]],
	 @else 
	 "order": [[ 1, "desc" ]],
	 @endif
 });
 }
//  if(counts > 0){
    
    //$('#sample_1').DataTable({
      //dom: 'Bfrtip',
      //
     // buttons: [
      // 'copyHtml5',
      // 'excelHtml5',
     // 'csvHtml5',
      // 'pdfHtml5'
   //   ]
 //   });
 // }
 function init_datatable(){
    $('#sample_1').DataTable({
    	@if(Request::segment(2)=='get-recent-shared' || Request::segment(2)=='get-recent-commented')
		 "order": [[ 2, "desc" ]],
		 @else 
		 "order": [[ 1, "desc" ]],
		 @endif
    });
  }
  function destroy_datatable(){
    $("#sample_1").DataTable().destroy();
  }
</script>
@stop

@endsection