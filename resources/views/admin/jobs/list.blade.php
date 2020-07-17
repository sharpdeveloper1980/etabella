@extends('layouts.backend.app')

@section('title','Jobs')

@section('content')
<section>
    <!-- Page content-->
<div class="content-wrapper">
   <div class="content-heading">
      <!-- START Language list-->
      <div class="pull-right">
         <!-- BUTTON GROUP -->
         <div class="btn-group">
            <!--                    <a href="http://66.206.3.18/etabellaweb/users/activeonly" class="btn btn-default btn-pill-left"><i class="fa fa-check"></i> Active Users Only</a>
               <a href="http://66.206.3.18/etabellaweb/users" class="btn btn-default btn-pill-left"><i class="fa fa-users"></i> All Users</a>-->
            <a href="{{ route('addJob') }}" class="btn btn-default btn-pill-right addJob"><i class="fa fa-remove"></i>Add Job</a>
         </div>
      </div>
      <!-- END Language list    -->
      Jobs
      <!-- <small>Hehe</small> -->
   </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <table class="table table-hover" id="Jobs-table">
                  <thead>
                     <tr>
                        <th><a>Job Name</a></th>
                        <th><a><i class="fa fa-sort"></i>&nbsp;&nbsp;&nbsp;Date Created</a></th>
                        <th class="header"><a>Action</a></th>
                     </tr>
                  </thead>
                  <tbody>
                    @if(count($jobs) > 0)
                    @foreach($jobs as $jobkey => $job)
                     <tr>
                        <td>{{$job->job_name}}</td>
                        <td>{{$job->created_at}}</td>
                        <td>
                           <a href="{{ url('admin/jobs/edit/'.$job->job_id) }}" class="btn btn-primary btn-xs">Edit</a>
                          
                          @if(Auth::user()->user_level == 1)
                           <button type="button" class="btn btn-danger btn-xs waves-effect" onclick="deleteJob({{$job->job_id}})">Delete</button>
                           
                           <form id="delete-job-{{$job->job_id}}" action="{{ url('admin/jobs/delete/'.$job->job_id) }}" method="POST" style="display: none;">
                              @csrf
                              @method('DELETE')
                           </form>                          
                           @endif    
                        </td>
                     </tr>
                    @endforeach
                     @else
                     <tr>
                       <td colspan="3">
                        <center>
                          <label class="alert alert-warning"> You do not have any job added yet</label>
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
  var counts = '<?=count($jobs)?>';

  if(counts > 0){
  $('#Jobs-table').DataTable( {
	  "order": [[ 1, "desc" ]],
       // dom: 'Bfrtip',
      //  buttons: [
            // 'copyHtml5',
            // 'excelHtml5',
            // 'csvHtml5',
            // 'pdfHtml5'
      //  ]
    } );
  }

   function deleteJob(id){
      swal({
        title: 'Are you sure?',
        text: 'This will delete this Job!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false
      },
      function() {
         $("#delete-job-"+id).submit();
        swal(
          'Deleted!',
          'Your file has been deleted.',
          'success'
        );
      });
   };
</script>
@stop
