@extends('layouts.backend.app')

@section('title','Clients')

@section('content')
<section>
    <!-- Page content-->
<div class="content-wrapper">
   <div class="content-heading">
      <!-- START Language list-->
      <div class="pull-right">
         <!-- BUTTON GROUP -->
         <div class="btn-group">
            <a href="{{ route('activeClients') }}" class="@if(Request::segment(1) == 'active_clients') btn btn-info @else btn btn-default @endif btn-pill-left"><i class="fa fa-check"></i> Active Users Only</a>
            <a href="{{ route('adminClients') }}" class="@if(Request::segment(1) == 'clients') btn btn-info @else btn btn-default @endif  btn-pill-left"><i class="fa fa-users"></i> All Users</a>
            <a href="{{ route('inactiveClients') }}" class="@if(Request::segment(1) == 'inactive_clients') btn btn-info @else btn btn-default @endif  btn-pill-right"><i class="fa fa-remove"></i> Inactive Users Only</a>
            <a href="{{ route('addClient') }}" class="btn btn-default btn-pill-right adduserbtn"><i class="fa fa-plus"></i> Add Client</a>
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
               <table class="table table-hover" id="Clients-table">
                  <thead>
                     <th><a>Name</a>
                     </th>
                     <th><a>Username</a></th>
                     <th><a>UNIQUE ID</a></th>
                     <th><a>Files Downloaded</a></th>
                     <th><a><i class="fa fa-sort"></i>&nbsp;&nbsp;&nbsp;Date Created</a></th>
                     <th><a>Status</a></th>
                     <th><a>Action</a></th>
                  </thead>
                  <tbody>
                     @if(count($users) > 0)
                     @foreach($users as $userkey => $user)
                     <tr>
                        <td id="user59">{{ $user->client_display_name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->client_unique_id }}</td>
                        <td><button class="downloaded btn btn-inverse" data-clientid="{{ $user->client_id }}" data-clientname="{{ $user->client_display_name }}">{{ $user->mydownloads->count() }}</button></td>
                        <td>{{ date('M d, Y H:i:s', $user->client_date_created) }}</td>
                        <td>
                           @if($user->client_status == 1)
                           <button class="btn btn-success btn-sm">Active</button>
                           @else
                           <button class="btn btn-secondary btn-sm">Inactive</button>
                           @endif                                            
                        </td>
                        <td>
                           <a href="{{ url('admin/clients/edit/'.$user->client_id) }}" class="btn btn-primary btn-xs">Edit</a>               
                          
                          @if(Auth::user()->user_level == 1)
                           <button type="button" class="btn btn-danger btn-xs waves-effect" onclick="deleteClient({{$user->client_id}})">Delete</button>
                           
                           <form id="delete-client-{{$user->client_id}}" action="{{ url('admin/clients/delete/'.$user->client_id) }}" method="POST" style="display: none;">
                              @csrf
                              @method('DELETE')
                           </form> 
                          @endif              
                        </td>
                     </tr>
                     @endforeach
                    @else
                       <tr>
                         <td colspan="7">
                          <center>
                            <label class="alert alert-warning"> You do not have any client added yet</label>
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

<!-- Modal -->
<div id="d_file_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-upload"></i> <strong id="clientname"></strong> - Downloaded Files</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table id="treeDemo" class="table table-striped upload-custom-file">
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning d_close_file_mdl">Back</button>
        </div>
      </form>
    </div>
  </div>
</div>
</section>
@endsection

@section('js')
<script type="text/javascript">
  var counts = '<?=count($users)?>';

  if(counts > 0){
  $('#Clients-table').DataTable( {
	   "order": [[ 4, "desc" ]],
       // dom: 'Bfrtip',
       // buttons: [
            // 'copyHtml5',
            // 'excelHtml5',
            // 'csvHtml5',
            // 'pdfHtml5'
       // ]
    } );
  }

  var zNodes = {!! json_encode($all_nods) !!};
    var setting = {
                    data: {
                      simpleData: {
                        enable: true
                      },
                    },
                      view: {
                        addDiyDom: null,
                        autoCancelSelected: true,
                        dblClickExpand: true,
                        expandSpeed: "fast",
                        fontCss: {},
                        nameIsHTML: true,
                        selectedMulti: true,
                        showIcon: false,
                        showLine: true,
                        showTitle: true,
                        txtSelectedEnable: false,
                      },
                    check: {
                      enable: false
                    },
                    callback: {
                        // onCheck: zTreeOnCheck
                    }
                  };

   function deleteClient(id){
      swal({
        title: 'Are you sure?',
        text: 'This will delete this Client!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false
      },
      function() {
         $("#delete-client-"+id).submit();
        swal(
          'Deleted!',
          'Your file has been deleted.',
          'success'
        );
      });
   };

   /**
Open File Modal
**/
$(".downloaded").click(function(){
  var id = $(this).data('clientid');
  var cl_name = $(this).data('clientname');
  $("#clientname").text(cl_name);
    $.ajax({
           type: "Get",
           url: baseurl+"/admin/clients/downloaded_files/"+id,
           data: {"id":id}, 
           dataType: "json",
           success: function(data)
           {
            console.log(data);
            // zNodes = JSON.parse(data);
            load(setting,data);
            $("#d_file_modal").modal('show');
           }
         });
      // console.log(zNodes);
      // zNodes = JSON.parse(data);
      // load(setting,zNodes);
   });
/**End**/

/**
Close File Modal
**/
   $(".d_close_file_mdl").click(function(){
      $("#d_file_modal").modal('hide');
   });
/**End**/

$( document ).ready(function() {
  load(setting,zNodes);
});

function load(setting,zNodes){
  // console.log(zNodes);
  return $.fn.zTree.init($("#treeDemo"), setting, zNodes);
}
</script>
@stop
