@extends('layouts.backend.app')

@section('title','Files')

@section('content')
<section>
    <!-- Page content-->
<div class="content-wrapper">
   <div class="content-heading">
     <!-- START Language list-->
     <div class="pull-right">
        <!-- BUTTON GROUP -->
        <div class="btn-group">
           <button id="new_folder" type="button" class="btn btn-warning btn-pill-left open_folder_mdl"><i class="fa fa-plus"></i> New Folder</button>
           <button id="upload" type="button" class="btn btn-info btn-pill-right open_file_mdl"><i class="fa fa-upload"></i> Upload Files</button>
        </div>
     </div>
     <!-- END Language list    -->
     Files
     <!-- <small>Hehe</small> -->
  </div>
  <div class="container">
    <div class="col-lg-12 selectfiletype">
     <div class="col-lg-4">
        <select class="form-control" id="selectfiletype" name="selectfiletype">
           <option value="MyFile">MyFile</option>
           <option value="MyPresentedFile">MyPresentedFile</option>
           <option value="Both">Both</option>
        </select>
     </div>
     <div class="col-lg-6">
        <button class="btn btn-success pull-left" id="savefiletype" type="button">Save</button>
     </div>
    </div>
  </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <div id="current">
                @if($arr_bread_bk)
                  @foreach($arr_bread_bk as $bkey => $bread)
                  @if($bkey == 0)
                    <a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> {{$bread['filename']}}</a>
                  @elseif((count($arr_bread_bk)-1) == $bkey)
                    <a style="color: grey"><i class="fa fa-folder-open"></i> {{$bread['filename']}}</a>
                  @else
                    <a href="{{ url('admin/files/'.$bread['file_id']) }}"><i class="fa fa-folder-open"></i> {{$bread['filename']}}</a>
                  @endif
                  
                  @if((count($arr_bread_bk)-1) == $bkey)
                    @else
                    <span class="separator">/</span>
                    @endif
                  @endforeach
                @endif                         
               </div>
            </div>
            <div class="panel-body">
               <table class="table table-hover" id="DataTable">
                  <thead>
                     <tr>
                        <th><a>Name</a></th>
                        <th><a><i class="fa fa-sort"></i>&nbsp;&nbsp;&nbsp;Date Modified</a></th>
                        <th class="header"><a>Size</a></th>
                        <th class="header"><a>Share</a></th>
                        <th class="header"><a>Add File</a></th>
                        <th class="header"><a>Options</a></th>
                        @if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2)
                        <th class="header"><a>filetype</a></th>
                        @endif
                     </tr>
                  </thead>
                  <tbody>
                     @if(count($files) > 0)
                     @foreach($files as $filekey => $file)
                    <tr id="row5995">
                     <td>
                      @if($file->file_type == 1)
                        <a href="{{ url('admin/files/'.$file->file_id) }}"><i class="fa fa-folder-open"></i>                                                    <span title="{{ucfirst($file->file_name)}}" class="file" id="file{{$file->file_id}}">{{ mb_strimwidth(ucfirst($file->file_name), 0, 40, "...") }}</span>
                        </a>
                      @else         
                        <span title="{{ucfirst($file->file_name)}}" class="fa fa-file" id="file{{$file->file_id}}" style="cursor: pointer"> {{ mb_strimwidth(ucfirst($file->file_name), 0, 40, "...") }}</span>
                      @endif                                                
                     </td>
                     <td>{{ date('M d, Y H:i:s', $file->file_date_modified) }}</td>
                     <td>{!! Helper::humanFileSize($file->file_size) !!}</td>
                     <td>
                        <a href="{{ url('admin/files/file/shared/'.$file->file_id.'/'.$file->file_parent_id.'/'.$file->file_shared) }}" type="button" class="@if($file->file_shared)btn-success @else btn btn-default @endif btn mb-sm share" file-id="5995"><i class="fa fa-share"></i></a>
                     </td>
                     <td>
                     @if($file->file_type == 2)
                      <input type="checkbox" name="none" class="form-control">
                      @endif
                     </td>
                     <td>
                      @if($file->file_type == 2)
                          <a href="{{ url('admin/files/file/added/'.$file->file_id.'/'.$file->file_parent_id.'/'.$file->file_added) }}" type="button" class="@if($file->file_added)btn-success @else btn btn-default @endif btn added shared mb-sm"><i class="fa fa-file-o"></i></a>
                      @endif
                     </td>
                     @if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2)
                     <td>
                          <a href="javascript:void(0)" onclick="renameFile({{$file->file_id}})" class="btn btn-default btn-xs rename"><i class="fa fa-pencil"></i></a>

                          <a data-file_id="{{ $file->file_id }}" class="btn btn-primary btn-xs open_edit_folder_mdl"><i class="fa fa-edit"></i></a>
                          @if(Auth::user()->user_level == 1) 
                           <button type="button" class="btn btn-danger btn-xs waves-effect" onclick="deleteFile({{$file->file_id}})"><i class="fa fa-trash"></i></button>
                           
                           <form id="delete-file-{{$file->file_id}}" action="{{ url('admin/files/delete/'.$file->file_id) }}" method="POST" style="display: none;">
                              @csrf
                              @method('DELETE')
                           </form>
                           @endif                        
                        </td>
                        @endif
                  </tr>
                     @endforeach
                      @else
                     <tr>
                       <td colspan="7">
                        <center>
                          <label class="alert alert-warning"> You do not have any folder or file added yet</label>
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
<!-- Add New Folder Modal -->
<div id="folder_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="{{ url('admin/files/create_folder') }}" method="POST">
        @csrf
        <input type="hidden" name="file_parent_id" value="{{ Request::segment(3) ? Request::segment(3) : 0 }}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-upload"></i> Upload Folder</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="form-group">
                <label for="file_name">Folder Name</label>
                <input type="text" name="folder_name" class="form-control">
              </div>
            </div>
            <div class="col-md-6 col-md-offset-3">
              <div class="form-group">
                <label for="file_name">Select Jobs</label>
                <select name="jobs[]" class="form-control" multiple>
                  @if($jobs)
                    @foreach($jobs as $jobkey => $job)
                     <option value="{{ $job->job_id }}">{{$job->job_name}}</option> 
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-default close_folder_mdl">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>

<!-- Edit Folder Modal -->
<div id="edit_folder_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form method="POST" id="editFolder">
        @csrf
        @method('PUT')
        <input type="hidden" name="file_parent_id" value="{{ Request::segment(3) ? Request::segment(3) : 0 }}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-upload"></i> Upload Folder</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="form-group">
                <label for="file_name">Folder Name</label>
                <input type="text" name="folder_name" class="form-control folder_name" disabled>
              </div>
            </div>
            <div class="col-md-6 col-md-offset-3">
              <div class="form-group">
                <label for="file_name">Select Jobs</label>
                <select name="jobs[]" class="form-control" multiple>
                  @if($jobs)
                    @foreach($jobs as $jobkey => $job)
                     <option id="job-{{$job->job_id}}" value="{{ $job->job_id }}">{{$job->job_name}}</option> 
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-default close_edit_folder_mdl">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="file_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form id="add_file" method="POST" action="{{ url('admin/files/upload_files') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="file_parent_id" value="{{ Request::segment(3) ? Request::segment(3) : 0 }}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-upload"></i> Upload Files</h4>
        </div>
        <div class="modal-body">
          <div style="margin-top:-10px;padding-bottom:10px">
            <span class="grey"><i class="fa fa-home"></i></span>
            {{ implode(' / ',$arr_bread) }}
          </div>
          <div class="row">
            <div class="col-md-12">
              <table id="uploads_table" class="table table-striped upload-custom-file">
              </table>
            </div>
            <div class="col-md-12">
              <div class="progress-custom" style="display: none">
              <div class="bar-custom"></div >
              <div class="percent-custom">0%</div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="file_name"></label>
                <label class="btn btn-warning form-control">
                    Please choose a file to upload <input id="file_field" type="file" name="file_name[]" multiple hidden>
                </label>
              </div>
            </div>
            <div class="col-md-6 col-md-offset-3">
              <div class="form-group">
                <label for="file_name">Select Jobs</label>
                <select name="jobs[]" class="form-control jobs" multiple>
                  @if($jobs)
                    @foreach($jobs as $jobkey => $job)
                     <option value="{{ $job->job_id }}">{{$job->job_name}}</option> 
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="save_btn" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-default close_file_mdl">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
  var counts = '<?=count($files)?>';

  if(counts > 0){
    $('#DataTable').DataTable( {
		 "order": [[ 1, "desc" ]],
        //dom: 'Bfrtip',
        //buttons: [
            // 'copyHtml5',
            // 'excelHtml5',
            // 'csvHtml5',
            // 'pdfHtml5'
       // ]
    } );
  }
/**
Method for Delete File 
**/
   function deleteFile(id){
      swal({
        title: 'Are you sure?',
        text: 'please click "Yes", if you really want to delete this File/Folder',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false
      },
      function() {
         $("#delete-file-"+id).submit();
        swal(
          'Deleted!',
          'Your file has been deleted.',
          'success'
        );
      });
   };
/**End**/

/** 
Start ajax method for get rename filename 
**/
  function renameFile(id){
    $.ajax({
           type: "Get",
           url: baseurl+"/admin/files/get_file/"+id,
           data: {"id":id}, 
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              swal({
                    title: "Rename "+'"'+data.file_name+'"'+"!",
                    text: "You can change your filename here",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Enter new Filename"
                  },
                  function(inputValue){
                    if (inputValue === false) return false;
                    if ($.trim(inputValue) === "") {
                      swal.showInputError("You need to write something!");
                      return false
                    }else{
                      updateRenameFile(inputValue,id);
                    }

                  });
           }
         });
  }
/** 
End
**/

/**
Method for change filename
**/
   function updateRenameFile(inputValue,id){
      $.ajax({
           type: "POST",
           url: baseurl+"/admin/files/rename/"+id,
           data: {file_name:inputValue,_token: '{!! csrf_token() !!}',}, 
           success: function(data)
           {
            if(data){
              $("#file"+id).text(inputValue);
              swal("Nice!", "You wrote: " + inputValue, "success");
            }
           }
        });
   }
/**End**/

/**
Open Folder Modal
**/
$(".open_folder_mdl").click(function(){
      $("#folder_modal").modal('show');
   });
/**End**/

/**
Close Folder Modal
**/
   $(".close_folder_mdl").click(function(){
      $("#folder_modal").modal('hide');
   });
/**End**/

/**
Open File Modal
**/
$(".open_file_mdl").click(function(){
      $('#uploads_table').html('');
      $('.jobs option:selected').removeAttr('selected');
      $("#file_modal").modal('show');
   });
/**End**/

/**
Close File Modal
**/
   $(".close_file_mdl").click(function(){
      $("#file_modal").modal('hide');
   });
/**End**/

/**
Open Edit Folder Modal
**/
$(".open_edit_folder_mdl").click(function(){
  var file_id = $(this).data('file_id');
      $.ajax({
           type: "Get",
           url: baseurl+"/admin/files/get_file/"+file_id,
           dataType: "json",
           success: function(data)
           {
            if(data){
              var arr_job = [];
              $(".folder_name").val(data.file_name);
              $("select option").prop("selected", false);
                arr_job = data.job_id.split(',');
                $.each( arr_job, function( key, value ) {
                  $("#job-"+value).prop('selected', true);
                });
              $('#editFolder').attr('action', baseurl+'/admin/files/update_folder/'+file_id);    
              $("#edit_folder_modal").modal('show');
            }
           }
        });
   });
/**End**/

/**
Close Edit Folder Modal
**/
   $(".close_edit_folder_mdl").click(function(){
      $("#edit_folder_modal").modal('hide');
   });
/**End**/

/** File Uploading **/
var index = 0;

    $(document).on('change', '.btn-warning :file', function () {
        $('#uploads_table').html('');
        for (var i = 0; i < this.files.length; i++)
            sendFiledata(this.files[i], index++);

    });
    
    function sendFiledata(file, index) {
        $('#uploads_table').append('<tr class="div-file" style="padding:1px;"><td></td><td style="padding-left:20px">' + file.name + '</td><td style="padding-left:20px;color:#f05050"><span class="msg" style="word-break: break-all;" id="msg' + index + '"></span></td></tr>');
    }

    var bar = $('.bar-custom');
    var percent = $('.percent-custom');
    // $('#add_file').ajaxForm({
    //     beforeSend: function () {
    //         $('.progress-custom').css('display', 'block');
    //         var percentVal = '0%';
    //         bar.width(percentVal);
    //         percent.html(percentVal);
    //         //$('#add_file :input[type=submit]').attr('disabled', true);
    //         //$('#_parent_id').val(parseInt($('#parent_id').val()));
    //         //console.log($('#parent_id').val());
    //     },
    //     uploadProgress: function (event, position, total, percentComplete) {
    //         document.getElementById("file_field").disabled = true;
    //         document.getElementById("save_btn").disabled = true;
    //         var percentVal = percentComplete + '%';
    //         console.log(percentVal);
    //         bar.width(percentVal);
    //         percent.html(percentVal);
    //     },
    //     complete: function (res) {
    //         document.getElementById("file_field").disabled = false;
    //         document.getElementById("save_btn").disabled = false;
    //         //$('#add_file :input[type=submit]').attr('disabled', false);
    //     },
    //     clearForm: true, // clear all form fields after successful submit 
    //     resetForm: true,
        // url: "{{ url('admin/files/upload_files') }}",
    //     success: function (res) {
    //       // console.log(responseJSON());
    //             $('#uploads_table').html('');
    //             $('#file_modal').modal('hide');
    //             // toastr.success('File is uploading successfully','Success',{
    //             //             "debug": false,
    //             //         });
    //          // setTimeout(function(){ window.location.reload(); }, 1000);
    //     },
    //     error: function (reject) {
    //             if( reject.status === 422 ) {
    //                   var vfilename = $("#file_field").val();
    //                   if(!vfilename){
    //                     toastr.error('The File is required for uploading','Error',{
    //                         "debug": false,
    //                     });
    //                   }
    //                 var errors = $.parseJSON(reject.responseText);
    //                 $.each(errors, function (key, val) {
    //                   console.log(val);
    //                   if(val['jobs']){
    //                     toastr.error('Please select Job its required','Error',{
    //                         "debug": false,
    //                     });
    //                   }
    //                 });
    //             }
    //         $('#file_modal').modal('hide');
    //       // setTimeout(function(){ window.location.reload(); }, 1000);
    //         },
    // });
/** End **/


$('#save_btn').click(function(){
$('#add_file').ajaxForm({
        beforeSend: function () {
            $('.progress-custom').css('display', 'block');
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
            //$('#add_file :input[type=submit]').attr('disabled', true);
            //$('#_parent_id').val(parseInt($('#parent_id').val()));
            //console.log($('#parent_id').val());
        },
        uploadProgress: function (event, position, total, percentComplete) {
            document.getElementById("file_field").disabled = true;
            document.getElementById("save_btn").disabled = true;
            var percentVal = percentComplete + '%';
            console.log(percentVal);
            bar.width(percentVal);
            percent.html(percentVal);
        },
		error: function (reject) {
                if( reject.status === 422 ) {
                      var vfilename = $("#file_field").val();
                      if(!vfilename){
                        toastr.error('The File is required for uploading','Error',{
                            "debug": false,
                        });
                      }
                    var errors = $.parseJSON(reject.responseText);
                    $.each(errors, function (key, val) {
                      console.log(val);
                      if(val['jobs']){
                        toastr.error('Please select Job its required','Error',{
                            "debug": false,
                        });
                      }
                    });
                }
            $('#file_modal').modal('hide');
           setTimeout(function(){ window.location.reload(); }, 1000);
            },
		success: function (res) {
          // console.log(responseJSON());
          // 
          var data = JSON.parse(res);
                $('#uploads_table').html('');
                $('#file_modal').modal('hide');
        		if(data.status){
                		 toastr.success(data.msg,'Success',{
                            "debug": false,
                        });
                }
        		else{
                	toastr.error(data.msg,'Error',{
                            "debug": false,
                        });
                }
               
             setTimeout(function(){ window.location.reload(); }, 1000);
        }
        
      
      
    }).submit();
});
</script>
@stop
