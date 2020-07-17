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
      FTP Settings
      <!-- <small>Hehe</small> -->
   </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-7">
         <div class="panel panel-default">
            <div class="panel-body">
               @if($ftp)
               <form id="add_ftp" action="{{route('updateFtp',$ftp->ftp_id)}}" class="form-horizontal" method="post">
                @method('PUT')
                @else
                <form id="add_ftp" action="{{route('saveFtp')}}" class="form-horizontal" method="post">
                @endif
                @csrf
                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Ftp Host*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="text" placeholder="FTP Host" name="ftp_host" id="ftp_host" maxlength="30" value="{{  $ftp ? $ftp->ftp_host : '' }}">
                     </div>
                  </div>

                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Ftp User*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="text" placeholder="FTP User" name="ftp_user" id="ftp_user" value="{{ $ftp ? $ftp->ftp_user : '' }}" maxlength="30">
                     </div>
                  </div>

                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Password*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="text" placeholder="FTP Password" name="ftp_pass" id="ftp_pass" value="{{ $ftp ? $ftp->ftp_pass : '' }}" maxlength="30">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-4"></div>
                     <div class="col-md-7">
                        <button class="btn btn-success form-control" id="addgroupdata" name="add_user"><i class="fa fa-save"></i> Save</button>
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
