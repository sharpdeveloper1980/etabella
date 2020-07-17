@extends('layouts.backend.app')

@section('title','Add Admin')

@section('content')
<section>
<!-- Page content-->
<div class="content-wrapper">
   <div class="content-heading">
      <!-- START Language list-->
      <div class="pull-right">
      </div>
      <!-- END Language list    -->
      Add Admin
      <!-- <small>Hehe</small> -->
   </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-7">
         <div class="panel panel-default">
            <div class="panel-body">
               <form id="add_admin" action="{{route('saveAdmins')}}" class="form-horizontal" method="post">
                @csrf
                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">User Name*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="text" placeholder="Admin Name" name="user_name" id="user_name" value="" maxlength="30">
                     </div>
                  </div>

                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Display Name*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="text" placeholder="Admin Display Name" name="user_display_name" id="user_display_name" value="" maxlength="30">
                     </div>
                  </div>
                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Password*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="password" placeholder="Admin Password" name="user_password" id="user_password" value="" maxlength="30">
                     </div>
                  </div>
                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Role*</label>
                     <div class="col-md-7">
                        <select class="form-control" name="user_level">
                           @if(count($roles) > 0)
                              @foreach($roles as $rkey => $role)
                                 <option value="{{ $role->id }}">{{ $role->role }}</option>
                              @endforeach
                           @endif
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-4"></div>
                     <div class="col-md-7">
                        <button class="btn btn-success form-control" id="addgroupdata" name="add_user"><i class="fa fa-save"></i> Add</button>
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
