@extends('layouts.client.app')

@section('title','Activity Log')

@section('content')
<style>
  button.dt-button.buttons-csv.buttons-html5 {
    margin-left: 20px !important;
  }
.custom-section{
	height: auto;
}
.activity_log_block{
	height:650px;
}
</style>
<section class="custom-section">
    <!-- Page content-->
<div class="content-wrapper">
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-12">
        <div class="panel panel-default activity_log_block">
            <div class="panel-body">
              <div class="col-lg-6 col-lg-offset-3">
                <input type="text" name="daterange" class="pull-right btn btn-info daterange form-control" />
              </div>
            </div>
            <div class="panel-body" style="display: none;">
            <a href="javascript:void(0)" class="pull-right btn btn-success export" @if(count($users) == 0) disabled @endif><i class="fa fa-plus"></i> Export csv</a>
            </div>
            <div class="panel-body" id="dvData">
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
      <!-- END dashboard main content-->
   </div>
</div>
</section>
@endsection

@section('js')
<script type="text/javascript">
  var counts = '<?=count($users)?>';
if(counts>0)
  var lst=1;
else 
  var lst=0;
if(counts > 0){
  init_datatable();
}

  function init_datatable(){
    $('#sample_1').DataTable({
    	 "order": [[ 4, "desc" ]],
      //dom: 'lBfrtip',
     // buttons: [
        // 'copyHtml5',
        // 'excelHtml5',
     //   'csvHtml5',
        // 'pdfHtml5'
    //  ]
    });
  }

  function destroy_datatable(){
    $("#sample_1").DataTable().destroy();
  }

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


    $('input[name="daterange"]').daterangepicker({
       opens: 'right',
       maxDate: new Date()
     }, function(start, end, label) {
      var startDate = start.format('YYYY-MM-DD');
      var endDate = end.format('YYYY-MM-DD')
       
       $.ajax({
             type: "POST",
             url: baseurl+"/clients/render-logs",
             data: {_token: "{{ csrf_token() }}",startDate:startDate,endDate:endDate},
             success: function(data)
             {
              var resp = $.parseJSON(data);
              console.log(resp);
               if(data){
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
</script>
@stop
