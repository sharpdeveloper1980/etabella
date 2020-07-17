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
      Edit Client
      <!-- <small>Hehe</small> -->
   </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-7">
         <div class="panel panel-default">
            <div class="panel-body">
               <form id="add_client" action="{{route('updateClient',$client->client_id)}}" class="form-horizontal" method="post">
                @csrf
                @method('PUT')
                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">User Name*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="text" placeholder="Group Name" name="username" id="username" value="{{ $client->username }}" maxlength="30">
                     </div>
                  </div>

                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Display Name*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="text" placeholder="Group Name" name="client_display_name" id="client_display_name" value="{{ $client->client_display_name }}" maxlength="30">
                     </div>
                  </div>

                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Password*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="password" placeholder="Change password" name="user_password" id="user_password" maxlength="30">
                     </div>
                  </div>
                  <div class="form-group" id="ftp_user_div">
                     <label class="col-md-4 control-label">Select Jobs</label>
                     <div class="col-md-7">
                        <select id="jobs" name="jobs[]" multiple="multiple" size="10" class="form-control" style="width:300px">
                          @foreach($jobs as $jobkey => $job)
                           <option value="{{$job->job_id}}" @if(in_array($job->job_id, $arr_job_ids)) selected @endif>{{ $job->job_name }}</option>
                          @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-4"></div>
                     <div class="col-md-7">
                        <button class="btn btn-success form-control" id="addgroupdata" name="add_user"><i class="fa fa-save"></i> Update</button>
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
   
</script>
@stop
