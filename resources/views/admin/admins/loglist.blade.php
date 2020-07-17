@extends('layouts.backend.app')

@section('title','Admins')
@section('content')
<style>
  button.dt-button.buttons-csv.buttons-html5 {
    margin-left: 20px !important;
  }
.custom-section{
	height: 100%;
}
button.dt-button.buttons-csv.buttons-html5 {
    background: #424141;
	color: #fff;
}
</style>

<section class="custom-section">
    <!-- Page content-->
<div class="content-wrapper">
   <div class="content-heading">
      <!-- START Language list-->
      
      {{$head_label}}
      
      <div class="pull-right">
         <!-- BUTTON GROUP -->
         <div class="btn-group">
          
            <!-- <a href="{{ route('activeAdmins') }}" class="@if(Request::segment(1) == 'active_admins') btn btn-info @else btn btn-default @endif btn-pill-left"><i class="fa fa-check"></i> Active Admins Only</a>
            <a href="{{ route('adminAdmins') }}" class="@if(Request::segment(1) == 'admins') btn btn-info @else btn btn-default @endif  btn-pill-left"><i class="fa fa-users"></i> All Admins</a>
            <a href="{{ route('inactiveAdmins') }}" class="@if(Request::segment(1) == 'inactive_admins') btn btn-info @else btn btn-default @endif  btn-pill-right"><i class="fa fa-remove"></i> Inactive Admins Only</a> -->
        </div>
      </div>
      <!-- END Language list    -->
      
      <!-- <small>Hehe</small> -->
   </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
               <div class="col-lg-6 col-lg-offset-3" style="margin-bottom:15px;">
                <select class="js-example-basic-single form-control clients" name="clients">
  					<option style="text-align:center;" value="">select users</option>
    				@if(count($clients) > 0)
                	@foreach($clients as $ckey => $client)
  						<option value="{{$client->client_id}}">{{$client->client_display_name}}</option>
                	@endforeach
                	@endif
				</select>
              </div>	
              <div class="col-lg-6 col-lg-offset-3">
                <input type="text" name="daterange" class="pull-right btn btn-info daterange form-control" />
              	<input type="hidden" class="segment" name="segment" value="{{Request::segment(3)}}">
              </div>
            </div>
<!--             <div class="panel-body">
            <a href="javascript:void(0)" class="pull-right btn btn-success export" @if(count($users) == 0) disabled @endif><i class="fa fa-plus"></i> Export csv</a>
            </div> -->
            <div class="panel-body" id="dvData">
                <table class="table table-hover" id="sample_1">
                  <thead>
                     <th><a>No.</a>
                     </th>
                     <th><a>IP Address</a></th>
                     <th><a>Description</a></th>
                     <th><a>Action</a></th>
                     <th><a>Type</a></th>
                     <th><a>Date</a></th>
                  </thead>
                  <tbody>
                     @if(count($users) > 0)
						<?php $i=1; ?>>
                     @foreach($users as $userkey => $user)
                     <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $user->ip_address }}</td>
                        
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
                       <td colspan="6">
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
      <!-- END dashboard main content-->
   </div>
</div>
</section>
@endsection

@section('js')
<script type="text/javascript">

$('.js-example-basic-single').select2();


var counts = '<?=count($users)?>';
if(counts>0)
  var lst=1;
else 
  var lst=0;

var start_date = '';
var end_date = '';

if(counts > 0){
  init_datatable();
}

  function init_datatable(){
    $('#sample_1').DataTable({
    	 "order": [[ 5, "desc" ]],
    //  dom: 'lBfrtip',
     // buttons: [
        // 'copyHtml5',
        // 'excelHtml5',
//'csvHtml5',
        // 'pdfHtml5'
     // ]
    });
  }

  function destroy_datatable(){
    $("#sample_1").DataTable().destroy();
  }
  
	$(".clients").change(function(){
    	var startDate = start_date;
      	var endDate = end_date;
      	var sel_client_id = $(".clients").val();
    	$.ajax({
             type: "POST",
             url: baseurl+"/admin/render-logs",
             data: {_token: "{{ csrf_token() }}",startDate:startDate,endDate:endDate,segment:"{{ Request::segment(3) }}",client_id:sel_client_id},
             success: function(data)
             {
              var resp=$.parseJSON(data);
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
               /*if(data){
                  console.log(data);
                  destroy_datatable();
                  $("#dvData").html(data);
                  init_datatable();
               }*/
               console.log(resp);
             }
       });
    });


    $('input[name="daterange"]').daterangepicker({
       opens: 'right',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate = start.format('YYYY-MM-DD');
      var endDate = end.format('YYYY-MM-DD')
      var sel_client_id = $(".clients").val();
    
    start_date = startDate;
    end_date = endDate;
       $.ajax({
             type: "POST",
             url: baseurl+"/admin/render-logs",
             data: {_token: "{{ csrf_token() }}",startDate:startDate,endDate:endDate,segment:"{{ Request::segment(3) }}",client_id:sel_client_id},
             success: function(data)
             {
                var resp=$.parseJSON(data);
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
               /*if(data){
                  console.log(data);
                  destroy_datatable();
                  $("#dvData").html(data);
                  init_datatable();
               }*/
             }
       });
   });


   function deleteAdmin(id){
      swal({
        title: 'Are you sure?',
        text: 'You will not be able to delete this Admin!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false
      },
      function() {
         $("#delete-admin-"+id).submit();
        swal(
          'Deleted!',
          'Admin has been deleted.',
          'success'
        );
      });
   };

  function download_csv(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV FILE
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // We have to create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Make sure that the link is not displayed
    downloadLink.style.display = "none";

    // Add the link to your DOM
    document.body.appendChild(downloadLink);

    // Lanzamos
    downloadLink.click();
  }

  function export_table_to_csv(html, filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
      for (var i = 0; i < rows.length; i++) {
      var row = [], cols = rows[i].querySelectorAll("td, th");
      
          for (var j = 0; j < cols.length; j++) 
              row.push(cols[j].innerText);
          
      csv.push(row.join(","));    
    }

      // Download CSV
      download_csv(csv.join("\n"), filename);
  }

  document.querySelector(".export").addEventListener("click", function () {
      var html = document.querySelector("table").outerHTML;
    export_table_to_csv(html, "Log List.csv");
  });
</script>
@stop
