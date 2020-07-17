@extends('layouts.backend.app')

@section('title','Users')

@section('content')
<section>
    <!-- Page content-->
<div class="content-wrapper">
   <div class="content-heading">
      <!-- START Language list-->
      <div class="pull-right">
         <!-- BUTTON GROUP -->
         <div class="btn-group">
            <a href="http://66.206.3.18/etabellaweb/users/activeonly" class="btn btn-default btn-pill-left"><i class="fa fa-check"></i> Active Users Only</a>
            <a href="http://66.206.3.18/etabellaweb/users" class="btn btn-default btn-pill-left"><i class="fa fa-users"></i> All Users</a>
            <a href="http://66.206.3.18/etabellaweb/users/inactiveonly" class="btn btn-default btn-pill-right"><i class="fa fa-remove"></i> Inactive Users Only</a>
            <a href="javascript:void(0);" class="btn btn-default btn-pill-right adduserbtn"><i class="fa fa-plus"></i> Add User</a>
         </div>
      </div>
      <!-- END Language list    -->
      Users
      <!-- <small>Hehe</small> -->
   </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <table class="table table-hover">
                  <thead>
                     <th>                                    <a href='http://66.206.3.18/etabellaweb/users/user/desc'>Name
                        </a>
                     </th>
                     <th><a href='http://66.206.3.18/etabellaweb/users/username/desc'>Username</a></th>
                     <th><a href='http://66.206.3.18/etabellaweb/users/unique/desc'>UNIQUE ID</a></th>
                     <th><a href='http://66.206.3.18/etabellaweb/users/files/desc'>Files Downloaded</a></th>
                     <th><a href='http://66.206.3.18/etabellaweb/users/date/asc'><i class="fa fa-sort"></i>&nbsp;&nbsp;&nbsp;Date Created</a></th>
                     <th><a href='http://66.206.3.18/etabellaweb/users/status/asc'>Status</a></th>
                     <th><a href='http://66.206.3.18/etabellaweb/main/userdelete/asc'>Action</a></th>
                  </thead>
                  <tbody>
                     @if($users)
                     @foreach($users as $userkey => $user)
                     <tr>
                        <td id="user59">{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->client_unique_id }}</td>
                        <td><button class="downloaded btn btn-inverse" client-id="59">0</button></td>
                        <td>{{ date('M d, Y H:i:s', $user->client_date_created) }}</td>
                        <td>
                           @if($user->client_status == 1)
                           <button class="btn btn-success">active</button>
                           @else
                           <button class="btn btn-default">inactive</button>
                           @endif                                            
                        </td>
                        <td>
                           <a href="http://66.206.3.18/etabellaweb/main/useredit/59" class="btn btn-primary btn-xs">Edit</a>               
                           <a href="http://66.206.3.18/etabellaweb/main/userdelete/59" class="btn btn-primary btn-xs" onclick="return confirm('Are you sure you want to Delete?');">Delete</a>               
                        </td>
                     </tr>
                     @endforeach
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
<!-- Modal -->
<div id="addUser" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary close_adduser">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
   $("body").on('click','.adduserbtn',function(e){
      $('#addUser').modal('show');
   });
   $("body").on('click','.close_adduser',function(e){
      $('#addUser').modal('hide');
   });
</script>
@stop
