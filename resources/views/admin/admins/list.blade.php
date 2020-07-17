@extends('layouts.backend.app')

@section('title','Admins')

@section('content')
<section>
    <!-- Page content-->
<div class="content-wrapper">
   <div class="content-heading">
      <!-- START Language list-->
      <div class="pull-right">
         <!-- BUTTON GROUP -->
         <div class="btn-group">
            <a href="{{ route('activeAdmins') }}" class="@if(Request::segment(1) == 'active_admins') btn btn-info @else btn btn-default @endif btn-pill-left"><i class="fa fa-check"></i> Active Admins Only</a>
            <a href="{{ route('adminAdmins') }}" class="@if(Request::segment(1) == 'admins') btn btn-info @else btn btn-default @endif  btn-pill-left"><i class="fa fa-users"></i> All Admins</a>
            <a href="{{ route('inactiveAdmins') }}" class="@if(Request::segment(1) == 'inactive_admins') btn btn-info @else btn btn-default @endif  btn-pill-right"><i class="fa fa-remove"></i> Inactive Admins Only</a>
            <a href="{{ route('addAdmins') }}" class="btn btn-default btn-pill-right adduserbtn"><i class="fa fa-plus"></i> Add Admin</a>
         </div>
      </div>
      <!-- END Language list    -->
      {{$head_label}}
      <!-- <small>Hehe</small> -->
   </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <table class="table table-hover" id="Admins-table">
                  <thead>
                     <th><a>Name</a>
                     </th>
                     <th><a>Username</a></th>
                     <th><a><i class="fa fa-sort"></i>&nbsp;&nbsp;&nbsp;Date Created</a></th>
                     <th><a>Status</a></th>
                     <th><a>Action</a></th>
                  </thead>
                  <tbody>
                     @if(count($users) > 0)
                     @foreach($users as $userkey => $user)
                     <tr>
                        <td id="user59">{{ $user->user_display_name }}</td>
                        <td>{{ $user->user_name }}</td>
                        <td>{{ date('M d, Y H:i:s', $user->user_date_created) }}</td>
                        <td>
                           @if($user->user_status == 1)
                           <button class="btn btn-success btn-sm">Active</button>
                           @else
                           <button class="btn btn-secondary btn-sm">Inactive</button>
                           @endif                                            
                        </td>
                        <td>
                           <a href="{{ url('admin/admins/edit/'.$user->user_id) }}" class="btn btn-primary btn-xs">Edit</a>               
                           
                           <button type="button" class="btn btn-danger btn-xs waves-effect" onclick="deleteAdmin({{$user->user_id}})">Delete</button>
                           
                           <form id="delete-admin-{{$user->user_id}}" action="{{ url('admin/admins/delete/'.$user->user_id) }}" method="POST" style="display: none;">
                              @csrf
                              @method('DELETE')
                           </form>               
                        </td>
                     </tr>
                     @endforeach
                     @else
                     <tr>
                       <td colspan="5">
                        <center>
                          <label class="alert alert-warning"> You do not have any admin added yet</label>
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

  if(counts > 0){
  $('#Admins-table').DataTable( {
	  "order": [[ 2, "desc" ]],
       // dom: 'Bfrtip',
       // buttons: [
            // 'copyHtml5',
            // 'excelHtml5',
            // 'csvHtml5',
            // 'pdfHtml5'
      //  ]
    } );
  }

   function deleteAdmin(id){
      swal({
        title: 'Are you sure?',
        text: 'This will delete this user!',
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
