@extends('layouts.client.app')
@section('title','Reports')
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
               <li><a href="{{ url('/clients/reports/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>

                @if($job->job_id == $whchjobs)
                  <input type="hidden" value="{{ $job->job_name }}" class="active_jobname">
                @endif

               @endforeach
            @endif
         </ul>
      </div>
   </div>
<hr class="hr_new2">
<div id="exTab1" class="row second_header container" style="margin-top:20px;">
   <ul  class="nav nav-pills">
      <li class="active">
         <a  href="#all" data-toggle="tab">All</a>
      </li>
      <li><a href="#annotations" data-toggle="tab">Annotations</a>
      </li>
      <li><a href="#hyperlinks" data-toggle="tab">Hyperlinks</a>
      </li>
      <li><a href="#bookmarked" data-toggle="tab">Bookmarked</a>
      </li>
   	  <li><a href="#issues" data-toggle="tab">Issues</a>
      </li>	
   </ul>
   <div class="tab-content clearfix">
      <div class="tab-pane active" id="all">
        <div class="loader" style="display: none;"></div>
    
         <div class="row">
           <div class="custom_date_range" style="margin-bottom: 43px;">
            <i class="fa fa-calendar glyphicon glyphicon-calendar"></i>
            <input type="text" name="daterange" class="daterange daterange_1 form-control" data-tablecont="table_container_1" data-tableid="sample_1" data-reporttype="all" />
           </div>
         </div>
     
         <div class="container" id="table_container_1" @if(count($reports)==0) style="margin-top:50px;" @endif>
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
      <div class="tab-pane" id="annotations">
         <div class="loader" style="display: none;"></div>
    
         <div class="row">
           <div class="custom_date_range" style="margin-bottom: 43px;">
            <i class="fa fa-calendar glyphicon glyphicon-calendar"></i>
            <input type="text" name="daterange" class="daterange daterange_2 form-control" data-tablecont="table_container_2" data-tableid="sample_2" data-reporttype="Annotation" />
           </div>
         </div>
    
         <div class="container" id="table_container_2" @if(count($annotations)==0) style="margin-top:50px;" @endif>
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
      <div class="tab-pane" id="hyperlinks">
        <div class="loader" style="display: none;"></div>
    
         <div class="row">
           <div class="custom_date_range" style="margin-bottom: 43px;">
            <i class="fa fa-calendar glyphicon glyphicon-calendar"></i>
            <input type="text" name="daterange" class="daterange daterange_3 form-control" data-tablecont="table_container_3" data-tableid="sample_3" data-reporttype="Hyperlink" />
           </div>
         </div>
    
         <div class="container" id="table_container_3" @if(count($hyperlinks)==0) style="margin-top:50px;" @endif>
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
      <div class="tab-pane" id="bookmarked">
         <div class="loader" style="display: none;"></div>
      
         <div class="row">
           <div class="custom_date_range" style="margin-bottom: 43px;">
            <i class="fa fa-calendar glyphicon glyphicon-calendar"></i>
            <input type="text" name="daterange" class="daterange daterange_4 form-control" data-tablecont="table_container_4" data-tableid="sample_4" data-reporttype="Bookmarked" />
           </div>
         </div>
    
         <div class="container" id="table_container_4" @if(count($bookmarks)==0) style="margin-top:50px;" @endif>
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
   	  <div class="tab-pane" id="issues">
         <div class="loader" style="display: none;"></div>
  
         <div class="row">
           <div class="custom_date_range" style="margin-bottom: 43px;">
            <i class="fa fa-calendar glyphicon glyphicon-calendar"></i>
            <input type="text" name="daterange" class="daterange daterange_5 form-control" data-tablecont="table_container_5" data-tableid="sample_5" data-reporttype="Issues" />
           </div>
         </div>
   
         <div class="container" id="table_container_5" @if(count($issues)==0) style="margin-top:50px;" @endif>
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

<hr class="hr_new1">
   
   
      
<!-- upload files modal -->
@section('js')
<script type="text/javascript">
  var all_counts = '<?=count($reports)?>';
  var annot_counts = '<?=count($annotations)?>';
  var hyper_counts = '<?=count($hyperlinks)?>';
  var book_counts = '<?=count($bookmarks)?>';
  var issue_counts = '<?=count($issues)?>';	


if(all_counts>0)
  var all_lst=1;
else 
  var all_lst=0;

if(annot_counts>0)
  var annot_lst=1;
else 
  var annot_lst=0;

if(hyper_counts>0)
  var hyper_lst=1;
else 
  var hyper_lst=0;

if(book_counts>0)
  var book_lst=1;
else 
  var book_lst=0;

if(issue_counts>0)
  var issue_lst=1;
else 
  var issue_lst=0;


  if(all_counts > 0){
    $('#sample_1').DataTable({
                  //  dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
                  //  buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                   // 'csvHtml5',
                    // 'pdfHtml5'
                   // ]
                  });
  }
  if(annot_counts > 0){
    $('#sample_2').DataTable({
                    //dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
                    //buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                   // 'csvHtml5',
                    // 'pdfHtml5'
                  //  ]
                  });
  }if(hyper_counts > 0){
    $('#sample_3').DataTable({
                   // dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
                   // buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                  //  'csvHtml5',
                    // 'pdfHtml5'
                   // ]
                  });
  }if(book_counts > 0){
    $('#sample_4').DataTable({
                    //dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
                   // buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                   // 'csvHtml5',
                    // 'pdfHtml5'
                   // ]
                  });
  }if(issue_counts > 0){
    $('#sample_5').DataTable({
                   // dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
                   // buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                   // 'csvHtml5',
                    // 'pdfHtml5'
                    //]
                  });
  }

function ajaxForFilter(datecls,tablecont,tableid,reporttype,startDate,endDate){
  $.ajax({
    type: "POST",
    url: baseurl+"/clients/report-files",
    data: {_token: "{{ csrf_token() }}",startDate:startDate,endDate:endDate,reporttype:reporttype,tableid:tableid,whchjobs:"{{$whchjobs}}"},
    success: function(data)
      {

           var resp = $.parseJSON(data);
           console.log(resp);
            if(resp.status==1)
            {
              if(datecls=='daterange_1')
              {
                if(all_lst==1)
                 destroy_datatable(tableid);  
              }

              if(datecls=='daterange_2')
              {
                if(annot_lst==1)
                 destroy_datatable(tableid);  
              }

              if(datecls=='daterange_3')
              {
                if(hyper_lst==1)
                 destroy_datatable(tableid);  
              }

              if(datecls=='daterange_4')
              {
                if(book_lst==1)
                 destroy_datatable(tableid);  
              }

              if(datecls=='daterange_5')
              {
                if(issue_lst==1)
                 destroy_datatable(tableid);  
              }              
            }




            if(datecls=='daterange_1')
            {
               all_lst=resp.status; 
            }
            if(datecls=='daterange_2')
            {
               annot_lst=resp.status; 
            }
            if(datecls=='daterange_3')
            {
               hyper_lst=resp.status; 
            }
            if(datecls=='daterange_4')
            {
               book_lst=resp.status; 
            }
            if(datecls=='daterange_5')
            {
               issue_lst=resp.status; 
            }
            

            $("#"+tablecont).html(resp.data);
            if(resp.status==1)
            {
                init_datatable(tableid);
            }
             /*if ( ! $.fn.DataTable.isDataTable( '#'+tableid ) ) {
                  $("#"+tablecont).html(data);
                  init_datatable(tableid);
             }
             else 
             {
	             destroy_datatable(tableid);
                 $("#"+tablecont).html(data);
                 init_datatable(tableid);
            }*/
       
      }
  });
}

  
   $('.daterange_1').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate1 = start.format('YYYY-MM-DD');
      var endDate1 = end.format('YYYY-MM-DD')

      var tablecont1 = $('.daterange_1').data('tablecont');
      var tableid1 = $('.daterange_1').data('tableid');
      var reporttype1 = $('.daterange_1').data('reporttype');

      ajaxForFilter('daterange_1',tablecont1,tableid1,reporttype1,startDate1,endDate1);
    });

   $('.daterange_2').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate2 = start.format('YYYY-MM-DD');
      var endDate2 = end.format('YYYY-MM-DD')

      var tablecont2 = $('.daterange_2').data('tablecont');
      var tableid2 = $('.daterange_2').data('tableid');
      var reporttype2 = $('.daterange_2').data('reporttype');

      ajaxForFilter('daterange_2',tablecont2,tableid2,reporttype2,startDate2,endDate2);
    });

   $('.daterange_3').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate3 = start.format('YYYY-MM-DD');
      var endDate3 = end.format('YYYY-MM-DD')

      var tablecont3 = $('.daterange_3').data('tablecont');
      var tableid3 = $('.daterange_3').data('tableid');
      var reporttype3 = $('.daterange_3').data('reporttype');

      ajaxForFilter('daterange_3',tablecont3,tableid3,reporttype3,startDate3,endDate3);
    });

   $('.daterange_4').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate4 = start.format('YYYY-MM-DD');
      var endDate4 = end.format('YYYY-MM-DD')

      var tablecont4 = $('.daterange_4').data('tablecont');
      var tableid4 = $('.daterange_4').data('tableid');
      var reporttype4 = $('.daterange_4').data('reporttype');
      ajaxForFilter('daterange_4',tablecont4,tableid4,reporttype4,startDate4,endDate4);
    });

   $('.daterange_5').daterangepicker({
       opens: 'left',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate5 = start.format('YYYY-MM-DD');
      var endDate5 = end.format('YYYY-MM-DD')

      var tablecont5 = $('.daterange_5').data('tablecont');
      var tableid5 = $('.daterange_5').data('tableid');
      var reporttype5 = $('.daterange_5').data('reporttype');

      ajaxForFilter('daterange_5',tablecont5,tableid5,reporttype5,startDate5,endDate5);
    });
 

   function init_datatable(tableid){
    $('#'+tableid).DataTable({
                    //dom: 'Bfrtip',
                    "order": [[ 1, "desc" ]],
                   //buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                    //'csvHtml5',
                    // 'pdfHtml5'
                   // ]
                  });
  }

  function destroy_datatable(tableid){
    $("#"+tableid).DataTable().destroy();
  }

  
</script>
@stop

@endsection