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
      Edit Group
      <!-- <small>Hehe</small> -->
   </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-7">
         <div class="panel panel-default">
            <div class="panel-body">
               <form id="add_group" action="{{route('updateGroup',$group->group_id)}}" class="form-horizontal" method="post">
                @csrf
                @method('PUT')
                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Group Name*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="text" placeholder="Group Name" name="group_name" id="groupname" value="{{ $group->group_name }}" maxlength="30">
                     </div>
                  </div>
                  <div class="form-group" id="ftp_user_div">
                     <label class="col-md-4 control-label">Select User</label>
                     <div class="col-md-7">
                        <select id="state_id" name="client_id[]" multiple="multiple" size="10" class="form-control" style="width:300px">
                          @foreach($clients as $clientkey => $client)
                           <option value="{{$client->client_id}}" @if(in_array($client->client_id, $arr_client_ids)) selected @endif>{{ $client->client_display_name }}</option>
                          @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-4"></div>
                     <div class="col-md-7">
                        <button type="submit" class="btn btn-success form-control" id="addgroupdata" name="add_user"><i class="fa fa-save"></i> Update</button>
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
