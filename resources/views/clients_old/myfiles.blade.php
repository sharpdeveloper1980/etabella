@extends('layouts.client.app')
@section('title','My Files')
@section('content')
   <div class="row second_header">
      <img src="{{asset('public/frontend/img/Untitled.png')}}" style="float:left;" class="case_icon">
      <div class="dropdown jobs-dd" data-toggle="tooltip" title="Jobs">
         <label class="btn  dropdown-toggle" type="button" data-toggle="dropdown">My Cases({{$active_job->job_name}})
         <span class="fa fa-chevron-down" style="color: #f36523"></span></label>
         <ul class="dropdown-menu menu_case" >
            @if($jobs)
               @foreach($jobs as $jkey => $job)
               <li><a href="{{ url('/clients/myfiles/'.$job->job_id) }}" class="@if($job->job_id == $whchjobs) active @endif">{{ $job->job_name }}</a></li>

               @if($job->job_id == $whchjobs)
               <input type="hidden" value="{{ $job->job_name }}" class="active_jobname">
               @endif
               
               @endforeach
            @endif
         </ul>
      </div>

      <a href="{{ url('public/export.zip') }}" download id="download_zip" hidden>Download zip</a>
      <div class="action_parent">
		<button type="button" class="action-button add-file" onclick="opnFileMdl()" style="float:right;display:none" data-toggle="tooltip" data-placement="top" title="Add New"><i style="padding:3px;" class="fa fa-plus fa_ps" aria-hidden="true" ></i>
         </button>   
      
        <button type="button" class="action-button add-file" id="print_btn" onclick="printFiles()" style="float:right" data-toggle="tooltip" data-placement="top" title="Print files"><i style="padding:3px;" class="fa fa-print" aria-hidden="true"></i>
         </button>

          <button type="button" id="exportzip_btn" value="{{ $whchjobs }}" class="action-button" data-toggle="tooltip" data-placement="top" title="Export zip"><i class="fa fa-file-archive-o" aria-hidden="true"></i></button>
         
         <button type="button" class="action-button" onclick="refreshPage(9)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh"><i class="fa fa-refresh" aria-hidden="true"></i>
         </button>

         <form action="{{ route('downloadFile') }}" method="post" style="float:right">
          @csrf
            <input type="hidden" id="file_id" name="file_id" />
            <button type="button" id="download_btn" data-toggle="tooltip" title="Delete"  class="action-button"><i class="fa fa-trash" aria-hidden="true"></i>
            </button>
          </form>

         <button type="button" class="action-button" style="float:right;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Select All">
           
           <label class="checkbox_selectall" onchange="checkmyfile('all')">
             <input type="checkbox" class="checkbox_selectall_chck">
             <span class="checkmark"></span>
           </label>

         </button>
			
      	
         <div class="dropdown sort_dd">
            
            <button type="button" class="dropdown-toggle action-button" id="sort_dd_outer" data-toggle="dropdown">
            <i class="fa fa-sort-alpha-desc" aria-hidden="true" data-toggle="tooltip" title="Sort By"></i>
            </button>                
            
            <div class="dropdown-menu sort_dd_inner">
              <a href="javascript:void(0)" class="a1 sorting" onclick="sorting('{{Request::segment(2)}}','{{Request::segment(3)}}','{{$whchjobs}}','file_name','{{Session::get('file_name')}}')">
                @if(Session::get('file_name') == 'asc')
                  <span class="file_name"><i class="fa fa-chevron-down"></i></span>
                @else
                  <span class="file_name"><i class="fa fa-chevron-up"></i></span>
                @endif
                <!-- <i class="fa fa-check" aria-hidden="true"></i> --> 
                Name
              </a>

              <a href="javascript:void(0)" class="a1 sorting" onclick="sorting('{{Request::segment(2)}}','{{Request::segment(3)}}','{{$whchjobs}}','file_date_modified','{{Session::get('file_date_modified')}}')">
                @if(Session::get('file_date_modified') == 'asc')
                  <span class="file_date_modified"><i class="fa fa-chevron-down"></i></span>
                @else
                  <span class="file_date_modified"><i class="fa fa-chevron-up"></i></span>
                @endif
                Date
              </a>

              <a href="javascript:void(0)" class="a1 sorting" onclick="sorting('{{Request::segment(2)}}','{{Request::segment(3)}}','{{$whchjobs}}','file_size','{{Session::get('file_size')}}')">

                @if(Session::get('file_size') == 'asc')
                  <span class="file_size"><i class="fa fa-chevron-down"></i></span>
                @else
                  <span class="file_size"><i class="fa fa-chevron-up"></i></span>
                @endif
                Size
              </a>

              <a href="javascript:void(0)" class="a1 sorting" onclick="sorting('{{Request::segment(2)}}','{{Request::segment(3)}}','{{$whchjobs}}','file_type','{{Session::get('file_type')}}')">

                @if(Session::get('file_type') == 'asc')
                  <span class="file_type"><i class="fa fa-chevron-down"></i></span>
                @else
                  <span class="file_type"><i class="fa fa-chevron-up"></i></span>
                @endif
                Type
              </a>

            </div>
			
         	<a href="#" data-toggle="tooltip" title="Tag Filter" class="tag-box" onclick="getTags()" style="float: right;margin-top: 3px;margin-right: 2px;"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" height="26" width="26"></a>
         
            <div class="search_sorting" id="search_files" data-toggle="tooltip" title="Search">
               <input type="text" name="search" class="form-control search_inp" placeholder="Search here">
               <i class="fa fa-search" aria-hidden="true"></i>

               <input type="hidden" name="job" class="selected_job" value="{{$whchjobs}}">
            </div>
         </div>
      </div>
   </div>
   
<hr class="hr_new2">
<div class="loader" style="display: none;"></div>
  <div class="container">
    <ul id="treeDemo" class="ztree">
    </ul>
</div>

<!-- upload files modal -->
<div id="file_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form id="add_file" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="file_parent_id" value="0">
        <!-- <input type="hidden" name="file_parent_id" value="{{ Request::segment(2) == 'dashboard' ? 0 : Request::segment(3) }}"> -->
<!--        <input type="hidden" name="jobs[]" value="{{ $whchjobs }}"> -->
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
                <label class="btn btn-warning form-control" style="display: block;">
                    Please choose a file to upload 
                    <input type="file" id="file_field" name="file_name[]" multiple style="display: none;">
                </label>
              </div>
            </div>
            <div class="col-md-3">
              <label for="file_name">Select Jobs</label>
            </div>
             <div class="col-md-9">
              
                <select name="jobs[]" class="form-control" multiple style="margin:0;">
                  @if($jobs)
                    @foreach($jobs as $jobkey => $job)
                     <option value="{{ $job->job_id }}">{{$job->job_name}}</option> 
                    @endforeach
                  @endif
                </select>
              
            </div> 
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="save_btn" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-default" onclick="clsFileMdl()">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade docs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="form-groupsearch_sorting" id="">
            <h4><img src="{{ url('public/images/move-icon.png') }}" height="30" width="30"> Move file</h4> 
          </div>
        </div>
        <!--  -->
          <div class="modal-body">
            <input type="hidden" name="from_doc" class="from_doc" value="">
            <input type="hidden" name="to_doc" class="to_doc" value="">
            <ul id="treeDemo_move" class="treeDemo ztree">
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancel-move-mdl">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="moveDocument()">Move</button>
          </div>
        <!--  -->
      </div>
    </div>
  </div>

<!-- Add New Folder Modal -->
<div id="copy_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form id="copy-form">
      	@csrf
        <input type="hidden" name="copied_file" class="copied_file">
      	<input type="hidden" name="sufix_name" class="sufix_name">
        <input type="hidden" name="vch_tab" class="vch_tab" value="1">
        <input type="hidden" name="jobs" value="{{$whchjobs}}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-copy"></i> Copy File</h4>
        </div>
        <div class="modal-body">
          <div class="row">
          <div class="col-md-6 col-md-offset-3">
          <div id="exTab1" class="">
          	<ul  class="nav nav-pills" style="margin-bottom:20px !important">
      			<li class="active">
         			<a href="#searchfolder" class="tb" data-tb_type="1" data-toggle="tab">Select Folder</a>
      			</li>
      			<li>
                <a  href="#newfolder" class="tb" data-tb_type="2" data-toggle="tab">New Folder</a>
      			</li>
   			</ul>
   			<div class="tab-content clearfix">
            	<div class="tab-pane active" id="searchfolder">
              			<div class="form-group">
                			<label for="file_name">Folder Name</label>
							<!-- <input type="text" name="folder_name" class="form-control" autocomplete="off"> -->
              				<select class="js-example-basic-single folder_sel" name="select_folder">
                            <option value="">Select Folder</option>
                				@if(count($my_dirs) > 0)
                					@foreach($my_dirs as $dkey => $dir)
    									<option class="list list-{{$dir->file_id}}" value="{{$dir->file_id}}">{{$dir->file_name}}</option>
                    				@endforeach
                				@endif
  							</select>
              			</div>
 			  	</div>
   				<div class="tab-pane" id="newfolder">
            
              <div class="form-group">
                <label for="file_name">Folder Name</label>
                <input type="text" name="folder_name" class="folder_name form-control" autocomplete="off">
              </div>
   			</div>
          </div>
          </div>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Copy</button>
          <button type="button" class="btn btn-default close_folder_mdl">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>
@section('js')
<script src="{{ asset('public/frontend/vendor/sweetalert/new/sweetalert.min.js') }}"></script>

<script type="text/javascript">
$('body').css("background-color","rgba(255, 165, 0, 0.1)!important");
    $('body').css("opacity","0.1");
   
  setTimeout(function(){
    $('body').css("background-color","#fff !important");
    $('body').css("opacity","1");
  },2000)
$('.js-example-basic-single').select2();
var zNodes = {!! json_encode($all_nods) !!};
var zNodes_move = {!! json_encode($all_nods_move) !!};
var name_sufix = '';
var whchjobs = '<?=$whchjobs?>';
   
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
                        txtSelectedEnable: true,
                      },
                    check: {
                      enable: false
                    },
                    callback: {
                        // onCheck: zTreeOnCheck
                    }
                  };

  setTimeout(function(){
    expandNode();
  },500);

  function expandNode() {
    var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.expandAll(true);
        zTree.expandAll(false);
  }

	$(".level1").removeAttr('title');

var array_checked = []; 
function checkmyfile(type)
  {
    array_checked = [];
    if(type == 'all'){
      if($(".checkbox_selectall_chck").is(":checked")){
        
        $(".filecheck").prop('checked', true);
        
        // $('#download_btn').prop("disabled", false);
        // $('#print_btn').prop("disabled", false);
        // $('#exportzip_btn').prop("disabled", false);
      
      }else{
        
        $(".filecheck").prop('checked', false);
        
        // $('#download_btn').prop("disabled", true);
        // $('#print_btn').prop("disabled", true);
        // $('#exportzip_btn').prop("disabled", true);
      }

    }else{

      if($(this).is(":checked")){
        $(this).prop('checked', true);
      }else{
        $(this).prop('checked', false);
      }
    
    }

    $(".filecheck:checked").each(function() { 
      if(jQuery.inArray($(this).val(), array_checked) !== -1){
      }else{
        array_checked.push($(this).val()); 
      }

    }); 
    if(array_checked.length > 0){
      // $('#download_btn').prop("disabled", false); // Element(s) are now enabled.
      // $('#print_btn').prop("disabled", false);
      // $('#exportzip_btn').prop("disabled", false);
    }
  }

  function folderCheck(id) {
    // console.log(id);
    var main = document.querySelector(".main-checkbox-"+id);
    var children = document.querySelectorAll(".sub-checkbox-"+id);
    
    children.forEach(child => {
      if(child.dataset.file_type == 1){
        folderCheck(child.value);
      }
      child.checked = child.checked == true ? false : true
      
      if (child.checked == true && child.dataset.file_type == 2) {
        array_checked.push(child.value);
      }else{
        if ($.inArray(child.value, array_checked) !== -1) {
          array_checked.splice($.inArray(child.value, array_checked),1);
        }
      }
    })

    if(array_checked.length > 0){
      // $('#download_btn').prop("disabled", false); // Element(s) are now enabled.
      // $('#print_btn').prop("disabled", false);
      // $('#exportzip_btn').prop("disabled", false);
    }else{
    //  swal('Warining','Please select atleast single file/folder','error');
      // $('#download_btn').prop("disabled", true);
      // $('#print_btn').prop("disabled", true);
      // $('#exportzip_btn').prop("disabled", true);
    }
    console.log(array_checked)
    return array_checked;
  }

  $("#download_btn").click(function(){
    // var whchjobs = $(this).val();
    if(array_checked.length > 0){
		
		/**Loader Show**/
		$("#treeDemo").hide();
		$(".hr_new3").hide();
		$(".loader").show();
		$("body").css("cursor", "progress");
		
      $.ajax({
          type: "POST",
          url: baseurl+"/clients/files/delete-downloaded",
          data: {_token: "{{ csrf_token() }}",arr_fileid:array_checked},
          dataType: "json",
          success: function(data)
          {
            if(data){
				/**Loader Hide**/
				$("#treeDemo").show();
				$(".hr_new3").show();
				$(".loader").hide();
				
              toastr.success(data.message, data.title);
              
			  setTimeout(function(){ window.location.reload(); }, 1000);
            }
          }
      });
    }else{
      swal('Warning','Please select atleast single folder/file','error');
    }
  });

      function refreshPage(whchjobs){
         $("#treeDemo").hide();
         $(".hr_new3").hide();
         $(".loader").show();
         $("input[type=checkbox]").prop('checked',false);
         
         // $('#download_btn').prop("disabled", true);
         // $('#print_btn').prop("disabled", true);
         // $('#exportzip_btn').prop("disabled", true);
         setTimeout(function () {
            $('.loader').hide();
            $(".hr_new3").show();
            $("#treeDemo").show();  
         }, 1000);
      }

/**
Open File Modal
**/
   function opnFileMdl(){
      $("#file_modal").modal('show');
   }
/**End**/

/**
Close File Modal
**/
   function clsFileMdl(){
      $("#file_modal").modal('hide');
   }
/**End**/



/**
Search Files 
**/
  function toggleSearchBox(){
    $("#search_files").toggle('fast');
    $(".name_date").toggle('fast');
  }

  $(".search_inp").keyup(function(e){
    if(e.keyCode == '13'){
      var keywords = $(this).val();
      var job = $('.selected_job').val();
      if(keywords){
        $.ajax({
            type: "GET",
            url: baseurl+"/clients/searchmyfiles/"+keywords+"/"+job,
            success: function(data)
            {
              if(data != ''){
                // console.log(zNodes);
                  zNodes = JSON.parse(data);
                  load(setting,zNodes);
              }else{
                swal(
                    'Searching..',
                    'No result found for this keywords',
                    'error'
                  );
              }
            }
        });
      }else{
        window.location.reload();
      }
    }
  });
/**stop**/

/**
 Sorting Start 
**/
   function sorting(segment,parentid=0,job,orderName,type){
    var spanClass = $('.'+orderName).find('i').attr('class');
    $.ajax({
          type: "GET",
          url: baseurl+"/clients/sortmyfiles/"+job+"/"+orderName,
          success: function(data)
          {
            // console.log(data);
            if(data){
                if(spanClass == 'fa fa-chevron-down'){
                  $('.'+orderName).find('i').attr('class','');
                  $('.'+orderName).find('i').attr('class','fa fa-chevron-up');
                }else{
                  $('.'+orderName).find('i').attr('class','');
                  $('.'+orderName).find('i').attr('class','fa fa-chevron-down');
                }
                zNodes = JSON.parse(data);
                load(setting,zNodes);
            }
          }
      });
   }
/**
Sorting End
**/

$( document ).ready(function() {
  load(setting,zNodes);
  load_move(setting,zNodes_move);
$('[data-toggle="tooltip"]').tooltip();
});

function load(setting,zNodes){
  // console.log(zNodes);
  return $.fn.zTree.init($("#treeDemo"), setting, zNodes);

}

function nodefile(id){
  // var fileid = $(this).data('file_id');
  // alert(id);
}

function checkfile(id){
  // alert(id);
}

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
    $('#add_file').ajaxForm({
        beforeSend: function () {
            $('.progress-custom').css('display', 'block');
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            document.getElementById("file_field").disabled = true;
            document.getElementById("save_btn").disabled = true;
            var percentVal = percentComplete + '%';
            console.log(percentVal);
            bar.width(percentVal);
            percent.html(percentVal);
        },
        complete: function () {
            document.getElementById("file_field").disabled = false;
            document.getElementById("save_btn").disabled = false;
            //$('#add_file :input[type=submit]').attr('disabled', false);
        },
        clearForm: true, // clear all form fields after successful submit 
        resetForm: true,
        url: "{{ url('clients/files/upload_files') }}",
        success: function (res) {
            $('#uploads_table').html('');
                $('#file_modal').modal('hide');
                setTimeout(function(){ window.location.reload(); }, 1000);
        },
    });

/**Print Button functionality**/
  function printFiles(){
    
    if(array_checked.length > 0){
      $("#treeDemo").hide();
      $(".hr_new3").hide();
      $(".loader").show();
      $("body").css("cursor", "progress");

      $.ajax({
          type: "POST",
          url: baseurl+"/clients/files/printing",
          data: {_token: "{{ csrf_token() }}",arr_fileid:array_checked},
          dataType: "json",
          success: function(data)
          {
            if(data){
              PrintMerge();              
              jQuery.grep(array_checked, function(value) {
                $("#check-"+value).removeAttr('name');
                $("#check-"+value).prop("disabled", true);
              }); 

              array_checked = [];
              $(".filecheck").prop('checked', false);
              toastr.success(data.message, data.title);
            }
          }
      });
    }else{
      swal('Warning','Please select atleast single folder/file','error');
    }
  }

function PrintMerge(){
  printJS({
    printable: ['http://web.etabella.com/etabellaweb/public/storage/mergeall/merge.pdf'],
    onLoadingEnd: function(){
        $('.loader').hide();
        $(".hr_new3").show();
        $("#treeDemo").show();  
        $("body").css("cursor", "default");
    }
   });
}

$("#exportzip_btn").click(function(){
    var whchjobs = $(this).val();
    if(array_checked.length > 0){

      /**Loader Show**/
      $("#treeDemo").hide();
      $(".hr_new3").hide();
      $(".loader").show();
      
      $.ajax({
          type: "POST",
          url: baseurl+"/clients/files/exportzip",
          data: {_token: "{{ csrf_token() }}",arr_fileid:array_checked},
          dataType: "json",
          success: function(data)
          {
            console.log(data);
            if(data){
            
              toastr.success(data.message, data.title);
            }else{
              toastr.error(data.message, data.title);
            }
              array_checked = [];
          	  console.log(array_checked);
              $(".filecheck").prop('checked', false);
              /**Loader Hide**/
              $("#treeDemo").show();
              $(".hr_new3").show();
              $(".loader").hide();
              $('#download_zip').get(0).click();
              
              '<?php file_exists(public_path('export.zip')) ? unlink(public_path('export.zip')) : "" ?>';
          }
      });
    }else{
      swal('Warning','Please select atleast single folder/file','error');
    }
  });
/**
End
**/

/** 
Start ajax method for get rename filename 
**/
  function renameFile(id){
    $.ajax({
           type: "Get",
           url: baseurl+"/clients/get_editedfile/"+id,
           data: {"id":id}, 
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              swal({
                    title: "Rename "+'"'+data.name+'"'+"!",
                    text: "You can change your filename here",
                    content: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Enter new Filename"
                  })
                  .then((inputValue) => { 
                    if (inputValue === false) return false;
                    if ($.trim(inputValue) === "") {
                      swal("Warning!", "You need to write something!", "warning");
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
           url: baseurl+"/clients/rename/"+id,
           data: {file_name:inputValue,_token: '{!! csrf_token() !!}',}, 
           success: function(data)
           {
            if(data){
          window.location.reload();
              /**$("#file"+id).text(inputValue);**/
              /**swal("Nice!", "You wrote: " + inputValue, "success");**/
            }
           }
        });
   }
/**End**/

  function load_move(setting,zNodes_move){
    return $.fn.zTree.init($("#treeDemo_move"), setting, zNodes_move);
  }

/**
Method for change filename
**/
var arr_ids = [];
    function moveFile(fileId){
      if ($.inArray(fileId, arr_ids) !== -1) {
          arr_ids.splice($.inArray(fileId, arr_ids),1);
          $(".facheck-"+fileId).hide();
        }else{
        arr_ids.push(fileId); 
        $(".from_doc").val(fileId);
        $(".facheck-"+fileId).show();
        
        $(".from_file_"+fileId).closest("li").hide();
        
        $(".docs-example-modal-lg").modal('show');
      }
      console.log(arr_ids);
    }

    function moveHere(fileid){
    	var copied_file = $(".from_doc").val();	
    	$(".to_doc").val(fileid);
      	$(".tick").hide();
      	$(".tickmark_"+fileid).show();
      	checkFilenameExist(fileid,copied_file,2);	
    }

    $("#cancel-move-mdl").click(function(){
    	$(".from_file").closest("li").show();
      	
    	arr_ids = [];
    	$(".facheck").hide();

      	$(".tick").hide();

      	$(".to_doc").val('');
      	$(".from_doc").val('');
      	$(".docs-example-modal-lg").modal('hide');
    });

    function moveDocument(){
      var to_doc = $('.to_doc').val();
      var from_doc = $('.from_doc').val();
    
    if(to_doc && from_doc){
        $.ajax({
            type: "GET",
            url: baseurl+"/clients/move_doc/"+to_doc+"/"+from_doc+"/"+name_sufix,
        	dataType: "json",
            success: function(data)
            {
                console.log(data);
              if(data==1){
              toastr.success('Document Moved successfully', 'success');	
              
              window.location.reload();
                  // zNodes = JSON.parse(data);
                  // load(setting,zNodes);
              }else{
                toastr.error('Something went wrong', 'error');
              }
            }
        });
      }else{
        toastr.error('Please select the folder where you want to move', 'error');
      }
    }
/**End**/
   // var array_copy = [];
   
   // function copyFile(id){
   // 	var main = document.querySelector(".main-checkbox-"+id);
   //  var children = document.querySelectorAll(".sub-checkbox-"+id);

   //  children.forEach(child => {
   //    if(child.dataset.file_type == 1){
   // 			if($(".checkmyfile-"+id).prop("checked") == true){
   //              $(".checkmyfile-"+id).prop("checked",false);
   //          }else{
   //          	$(".checkmyfile-"+id).prop("checked",true);
   //          	array_copy.push(id);
   //          }
   //      copyFile(child.value);
   //    }
   //    child.checked = child.checked == true ? false : true
      
   //    if (child.checked == true && child.dataset.file_type == 2) {
   //      array_copy.push(child.value);
   //    }else{
   //      if ($.inArray(child.value, array_copy) !== -1) {
   //        array_copy.splice($.inArray(child.value, array_copy),1);
   //      }
   //    }
   //  })
   //  $("#copy_modal").modal('show');
   // }

   function copyFile(id){
   	$(".list").prop("disabled", false);
    $(".copied_file").val(id);
   	$(".list-"+id).prop("disabled", true);
    $("#copy_modal").modal('show');
   }
   
   $(".close_folder_mdl").click(function(){
      $("#copy_modal").modal('hide');
   });
   
   // $(".list").change(function(){
   // 	var dir_id = $(this).data('dir_id');
   // 	$(".folder_id").val(dir_id);
   // alert(dir_id);
   // });
   
   	$(".folder_sel").on('change', function(e) {
    	e.preventDefault();
  		var sel_val = this.value;
    	var copied_file = $(".copied_file").val();
    	checkFilenameExist(sel_val,copied_file,1);
	});
   
   $(".tb").click(function(){
   		var type = $(this).data('tb_type');
   		$(".vch_tab").val(type);
   });
   
   $('#copy-form').on('submit', function (e) {
	e.preventDefault();
   var tab = $(".vch_tab").val();
   if(tab == 1){
   		var sel_folder = $(".folder_sel").val();	
   		// $(".folder_sel").children("option:selected").val();
   		if(!sel_folder){
   			toastr.error('Please select destination folder', 'error');
   			return false;
        }
   }
   if(tab == 2){
   		var folder_nam = $(".folder_name").val();	
   		if(!folder_nam){
   			toastr.error('folder name is required', 'error');
   			return false;
        }
   }
		$.ajax({
            type: 'post',
            url: baseurl+'/clients/files/copy_doc',
            data: $('#copy-form').serialize(),
        	dataType: "json",
            success: function (data) {
            	console.log(data.success_msg);
            	if(data.success == 1){
            		toastr.success(data.success_msg, 'success');
                }else{
                	toastr.error(data.success_msg, 'error');
                }
                	window.location.reload();
            }
        });
   });

function SubmitCopyForm() {
   var tab = $(".vch_tab").val();
   if(tab == 1){
   		var sel_folder = $(".folder_sel").val();	
   		// $(".folder_sel").children("option:selected").val();
   		if(!sel_folder){
   			toastr.error('Please select destination folder', 'error');
   			return false;
        }
   }
   if(tab == 2){
   		var folder_nam = $(".folder_name").val();	
   		if(!folder_nam){
   			toastr.error('folder name is required', 'error');
   			return false;
        }
   }
		$.ajax({
            type: 'post',
            url: baseurl+'/clients/files/copy_doc',
            data: $('#copy-form').serialize(),
        	dataType: "json",
            success: function (data) {
            	console.log(data.success_msg);
            	if(data.success == 1){
            		toastr.success(data.success_msg, 'success');
                }else{
                	toastr.error(data.success_msg, 'error');
                }
                	window.location.reload();
            }
        });
   }
   
   function checkFilenameExist(sel_val,copied_file,formtype){
   		if(sel_val){
    		$.get(baseurl+'/clients/check_filename/'+sel_val+'/'+copied_file, function(data, status){
    			console.log(data);
            	if(data > 0){
                
                	swal({
  						title: "Would you like to continue?",
                    	text: "This named document already exist in this folder",
  						icon: "warning",
  						buttons: true,
  						dangerMode: false,
                    	buttons: ['no, thanks','yes, continue']
					})
						.then((willDelete) => {
  							if (willDelete) {
    							name_sufix = "("+data+")";
                            	$(".sufix_name").val(name_sufix);
                            	if(formtype == 1){
                            		SubmitCopyForm();
                                }else{
                                	moveDocument();
                                }
  							} else {
                            	$("#copy_modal").modal('hide');
    							window.location.reload();
  						}
					});
                }
  			});
    	}
   }
   
   /** Get Tags **/
var a = '';
    function getTags(){ 
      $.ajax({
            type: "GET",
            url: baseurl+"/clients/get-tags-for-filter/",
            success: function(data)
            {
              console.log(data);
              if(data != ''){
                a = $.confirm({
                      title: 'Filter by Tags',
                      content: data,
                      
                  });
              }else{
                a = $.confirm({
                    title: 'Filter by Tags',
                    content: 'No tags added yet',
                    
                });
              }

            }
        });
    }

    function getTaggedFiles(tagid){
      $.ajax({
           type: "GET",
           url: baseurl+"/clients/get-by-tagid/"+tagid+"/"+whchjobs,
           success: function(data)
           {
              if(data != ''){
                console.log(zNodes);
                zNodes = JSON.parse(data);
                load(setting,zNodes);
              }else{
                  swal(
                        'Searching..',
                        'No result found for this keywords',
                        'error'
                      );            
              }
              a.close();
           }
        });
    }

/**
Open File Modal
**/
   function opnFileMdl(){
      $("#file_modal").modal('show');
   }
/**End**/

/**
Close File Modal
**/
   function clsFileMdl(){
      $("#file_modal").modal('hide');
   }
/**End**/


</script>
@stop

@endsection