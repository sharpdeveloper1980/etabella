@extends('layouts.backend.app')

@section('title','Users')

@section('content')
<section>
<!-- Page content-->
<div class="content-wrapper">
   <div class="content-heading">
      <!-- START Language list-->
      <div class="pull-right">
      </div>
      <!-- END Language list    -->
      Change Password
      <!-- <small>Hehe</small> -->
   </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-7">
         <div class="panel panel-default">
            <div class="panel-body">
               <form id="add_client" action="{{route('updatePassword')}}" class="form-horizontal" method="post">
                @csrf
                @method('PUT')
                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Current Password*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="password" placeholder="Current Password" name="current_password" id="current_password" maxlength="30">
                     </div>
                  </div>
                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">New Password*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="password" placeholder="New Password" name="user_password" id="user_password" maxlength="30">
                     </div>
                  </div>
                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Confirmed Password*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="password" placeholder="Confirmed Password" name="confirm_password" id="confirm_password" value="" maxlength="30">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-4"></div>
                     <div class="col-md-7">
                        <button class="btn btn-success form-control"><i class="fa fa-save"></i> Change Now</button>
                     </div>
                  </div>
               </form>
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
   $("body").on('click','.addGroup',function(e){
      $('#addGroupMdl').modal('show');
   });
   $("body").on('click','.close_adduser',function(e){
      $('#addGroupMdl').modal('hide');
   });
</script>
@stop
