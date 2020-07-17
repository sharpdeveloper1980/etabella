@extends('layouts.client.app')
@section('title','Notifications')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend/css/daterangepicker.css')}}" />
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
@stop
@section('content')
   <div class="row second_header">
      <img src="{{asset('public/frontend/img/Untitled.png')}}" style="float:left;" class="case_icon">
      <div class="dropdown jobs-dd">
         <label class="btn  dropdown-toggle" type="button" data-toggle="dropdown">My Cases(<?php if($active_job) {  echo $active_job->job_name; } ?>)
         <span class="fa fa-chevron-down" style="color: #f36523"></span></label>
         <ul class="dropdown-menu job-dropdown menu_case">
            @if($jobs)
               @foreach($jobs as $jkey => $job)
               <li><a href="{{ url('/clients/notifications/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>
               @if($job->job_id == $whchjobs)
                  <input type="hidden" value="{{ $job->job_name }}" class="active_jobname">
                @endif
               @endforeach
            @endif
         </ul>
      </div>
   </div>
   <hr class="hr_new1">
   <div class="row">
     <div class="custom_date_range" style="margin-bottom: 43px;">
      <i class="fa fa-calendar glyphicon glyphicon-calendar"></i>
      <input type="text" name="daterange" data-access="<?php if(Request::segment(2)=='notifications') { echo "1"; } else { echo "2"; }  ?>" class="daterange daterange_1 form-control" data-tablecont="table_container_1" data-tableid="sample_1" data-reporttype="all" />
     </div>
   </div>
   <div class="loader" style="display: none;"></div>
     
      <div class="container" id="table_container">
        <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="Notification-table" role="grid" aria-describedby="sample_1_info">
            <thead>
              <tr role="row">
                  <th>Title</th>  
                  <th>Message</th>
                  <th>Date</th>
                  <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @if(count($allnotifications) > 0)
                     @foreach($allnotifications as $nkey => $allnotification)
                     <tr>
                        <td>
                           @if($allnotification->is_annotation == 1)
                            <a href="{{ url('clients/shared/'.$allnotification->id) }}">
                            {{ $allnotification->title }}
                            </a>
							@elseif($allnotification->type == 1)
                            <a href="{{ url('clients/groups/'.$allnotification->job_id.'/'.$allnotification->file_id) }}">
                            {{ $allnotification->title }}
                            </a>
							@elseif($allnotification->type == 2)
                            <a href="{{ url('clients/topics/'.$allnotification->job_id.'/'.$allnotification->file_id) }}">
                            {{ $allnotification->title }}
                            </a>
							@elseif($allnotification->type == 3)
                            <a href="{{ url('clients/user/'.$allnotification->job_id.'/'.$allnotification->sender) }}">
                            {{ $allnotification->title }}
                            </a>
                            @else
                            {{ $allnotification->title }}
                            @endif
                        </td>
                        <td>
                           <?php 
                          $message = str_replace('#','',str_replace('@','', substr(strip_tags($allnotification->message), 0, 20)));
                         // $message2= str_replace('#','',str_replace('@','', strip_tags($allnotification->message)));
                         //  $message = substr(strip_tags($allnotification->message), 0, 20);
                           //$message2= strip_tags($allnotification->message);
                          ?>
                           @if($allnotification->is_annotation == 1)
                            <a href="{{ url('clients/shared/'.$allnotification->id) }}">
                            <?php echo  strlen($message) > 15  ? $message . '...' :  $message; ?>
                            </a>
                            @else
                            <?php echo  strlen($message) > 15  ? $message . '...' : $message; ?>  
                            @endif
                        </td>
                        <td>{{ date('M d, Y H:i:s', $allnotification->created_at) }}</td>
                        <td>
                          @if($allnotification->mark_read == 1)
                           <a href="javascript:void(0)" data-notif_list_id="{{$allnotification->id}}" type="button" class="btn btn-xs btn-success mark_read_list">Mark read</a>      
                           @else
                           <a href="javascript:void(0)" data-notif_list_id="{{$allnotification->id}}" type="button" class="btn btn-xs btn-info" disabled>Read</a>      
                           @endif
                        </td>
                     </tr>
                     @endforeach
                     @else
                     <tr>
                       <td colspan="5">
                        <center>
						@if(Request::segment(2)=='message_notification')
                          <a  href="{{ url('clients/groups/'.Session::get('job_id')) }}"><label style="cursor: pointer;" class="alert alert-warning">Go To Messenger</label></a>
					    @else 
						  <label class="alert alert-warning"> No new message found yet</label>
					    @endif
                        </center> 
                       </td>
                     </tr>
                     @endif
            </tbody>
        </table>
      </div>
<!-- upload files modal -->
@section('js')
<script type="text/javascript">
  var counts = '<?=count($allnotifications)?>';
if(counts>0)
  var lst=1;
else 
  var lst=0;
  if(counts > 0){
  $('#Notification-table').DataTable( {
        "order": [[ 2, "desc" ]],
		dom: 'Bfrtip',
        buttons: [
            // 'copyHtml5',
            // 'excelHtml5',
            // 'csvHtml5',
            // 'pdfHtml5'
        ]
    } );
  }

  $(".mark_read_list").click(function(){
      var id = $(this).data('notif_list_id');
      $.ajax({
           type: "Get",
           url: baseurl+"/clients/mark_read/"+id,
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              if(data.message == true){
               window.location.reload();
              }
           }
      });
   });
  $('.daterange_1').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate = start.format('YYYY-MM-DD');
      var endDate = end.format('YYYY-MM-DD');
      var aceess = $('.daterange_1').attr('data-access');
       $.ajax({
             type: "POST",
             url: baseurl+"/clients/render-notification",
             data: {_token: "{{ csrf_token() }}",startDate:startDate,endDate:endDate,access:aceess},
             success: function(data)
             {
              console.log(data);

               resp=$.parseJSON(data);
                console.log(resp);
                if(resp.status==1)
                {
                if(lst==1)
                  destroy_datatable();
                }
                lst=resp.status;
                        $("#table_container").html(resp.data);
                
                if(resp.status==1)
                {
                  init_datatable();
                }
          
             }
       });
    });

</script>
@stop

@endsection