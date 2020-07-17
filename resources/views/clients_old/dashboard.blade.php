@extends('layouts.client.app')
@section('title','Client Dashboard')
@section('content')
<style>
  a.tag-box {
    margin-right: 2px;
    margin-top: 3px;
  }
 .hide_div{
	 display:none;
 }
</style>

<div class="ovrl hide_div" id="page_overlay" style="
    position: absolute;
    width: 100%;
    height: 100%;
    background: #ffffffb0;
    z-index: 1;
"></div>
<div id="loader1" class="hide_div" style="z-index: 7;position: absolute;top: 50%;left: 43%;">
<img src="{{ asset('public/images/ajax-loader.gif') }}" >
</div>

   <div class="row second_header">
      

      <a href="{{ url('public/export.zip') }}" download id="download_zip" hidden>Download zip</a>
      <div class="action_parent">
         <!--<button type="button" class="action-button add-file" onclick="opnFileMdl()" style="float:right" data-toggle="tooltip" data-placement="top" title="Add New"><i style="padding:3px;" class="fa fa-plus fa_ps" aria-hidden="true" ></i>
         </button>-->

         <button type="button" class="action-button add-file" id="print_btn" onclick="printFiles()" style="float:right" data-toggle="tooltip" data-placement="top" title="Print files" ><i style="padding:3px;" class="fa fa-print" aria-hidden="true"></i>
         </button>

         <!--<button type="button" onclick="toggleSearchBox()" class="action-button"><i class="fa fa-search"></i>
         </button>-->

         <button type="button" class="action-button" onclick="refreshPage({{$whchjobs}})" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-refresh" aria-hidden="true" ></i></button>
          
          <form action="{{ route('downloadFile') }}" method="post" style="float:right">
               @csrf
                  <input type="hidden" id="file_id" name="file_id" />
                  <button type="button" id="exportzip_btn" value="{{ $whchjobs }}" class="action-button" data-toggle="tooltip" data-placement="top" title="Export zip" ><i class="fa fa-file-archive-o" aria-hidden="true"></i></button>
              </form>
          
           <form action="{{ route('downloadFile') }}" method="post" style="float:right">
               @csrf
                  <input type="hidden" id="file_id" name="file_id" />
                  <button type="button" id="download_btn" value="{{ $whchjobs }}" class="action-button" data-toggle="tooltip" data-placement="top" title="Download" ><i class="fa fa-download" aria-hidden="true"></i></button>
               </form>
                
               <button type="button" class="action-button" style="float:right;" data-toggle="tooltip" data-placement="top" title="Select All">
                
                <label class="checkbox_selectall" onclick="checkfile('all')">
                <input type="checkbox" class="checkbox_selectall_chck">
                <span class="checkmark"></span>
              </label>

              </button>
               

               <div class="dropdown sort_dd" >

                <button type="button" class="dropdown-toggle action-button sort_dd_outer" >
                  <i class="fa fa-sort-alpha-desc" aria-hidden="true" data-toggle="tooltip" title="Sort By"></i>
                </button>                

                <div class="dropdown-menu sort_dd_inner" >
                    <a href="javascript:void(0)" class="a1 sorting" onclick="sorting('{{Request::segment(2)}}','{{Request::segment(3)}}','{{$whchjobs}}','file_name','{{Session::get('file_name')}}')">
                      @if(Session::get('file_name') == 'asc')
                        <span class="file_name"><i class="fa fa-chevron-down"></i></span>
                      @else
                        <span class="file_name"><i class="fa fa-chevron-up"></i></span>
                      @endif
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

                    <a href="javascript:void(0)" class="a1 sorting dropdown-item" onclick="sorting('{{Request::segment(2)}}','{{Request::segment(3)}}','{{$whchjobs}}','file_size','{{Session::get('file_size')}}')">

                      @if(Session::get('file_size') == 'asc')
                        <span class="file_size"><i class="fa fa-chevron-down"></i></span>
                      @else
                        <span class="file_size"><i class="fa fa-chevron-up"></i></span>
                      @endif
                      <!-- <i class="fa fa-check" aria-hidden="true"></i> --> 
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

<!--                 <a href="#" class="tag-box" onclick="getTags()" style="float: right"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" height="26" width="26"></a> -->

                <div class="search_sorting" id="search_files" data-toggle="tooltip" title="Search">
                  <input type="text" name="search" class="form-control search_inp" placeholder="Search here">
          <i class="fa fa-search" aria-hidden="true"></i>
                  <input type="hidden" name="job" class="selected_job" value="{{$whchjobs}}">

               </div>  

              </div>
     
   </div>
      
   </div>

   <!-- second buttons start -->
   <div class="row">
      <center>
        
        <!--<div class="col-md-6 col-md-offset-3 search_sorting" id="name_date">
         <div class="name_date">
            
         </div>
       </div>-->
      </center>
   </div>
   <!-- end second button -->
   <hr class="hr_new2">
   <!-- Table start -->
  <!--  <div class="row">
      <div class="col-md-6 client_bread">
         @if($arr_bread_bk)
            @foreach($arr_bread_bk as $bkey => $bread)
               @if($bkey == 0)
                  <a href="{{ url('/clients/dashboard/'.$whchjobs) }}" class="client_bread"><i class="fa fa-home"></i> {{$bread['filename']}}</a>
               @elseif((count($arr_bread_bk)-1) == $bkey)
                  <a style="color: grey" class="client_bread"><i class="fa fa-folder-open"></i> {{$bread['filename']}}</a>
               @else
                  <a href="{{ url('/clients/files/'.$bread['file_id'].'/'.$whchjobs) }}" class="client_bread"><i class="fa fa-folder-open"></i> {{$bread['filename']}}</a>
               @endif
                  
               @if((count($arr_bread_bk)-1) == $bkey)
                  @else
                  <span class="separator client_bread">/</span>
               @endif
            @endforeach
         @endif                         
      </div> -->
   </div>
   <!-- <hr class="hr_new3"> -->
   <div class="loader" style="display: none;"></div>
  <div class="container">
    <ul id="treeDemo" class="ztree">
    </ul>
    <div id="for-search-con" style="display: none;">
    </div>
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

 <div class="modal" id="select_job" role="dialog" style="margin-top:15%">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h4 class="modal-title">Select Job</h4>
        </div>
        <div class="modal-body">
        <div class="row">
        	<div class="col-sm-12">
            <div class="form-group">
            <label>Select Job</label>
            <select id="select_job_dash"  class="form-control">
            	@foreach($jobs as $jkey => $job)
                <option <?php if($job->job_id==$whchjobs) { ?> selected <?php } ?>  value="{{ $job->job_id }}">{{ $job->job_name }}</option>
               @endforeach
            </select>
            </div>
        	</div>
        </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" id="select_job_btn" class="btn btn-info" >Next</button>
        </div>
      </div>
      
    </div>
  </div>

@section('js')
<script src="{{ asset('public/frontend/vendor/sweetalert/new/sweetalert.min.js') }}"></script>

  <script type="text/javascript">
    $(document).on('click','.sort_dd_outer',function(){
		$('.sort_dd_inner').css({'display':'block'});
	});
	$('body').on('click',function(){
		$('.sort_dd_inner').css({'display':'none'});
	});
	
	$(document).on('click','#select_job_btn',function(){
    		localStorage.setItem("job_popup", 1);
    		var val=$('#select_job_dash').val();
    		window.location.href=baseurl+'/clients/dashboard/'+val;
    });
//   alert(localStorage.getItem("job_popup"))
   if(!localStorage.getItem("job_popup") || localStorage.getItem("job_popup")==0)
   {
     $('#page_overlay').addClass('page_overlay');
  	 $('#select_job').show();
   }
   $('body').css("background-color","rgba(255, 165, 0, 0.1)!important");
    $('body').css("opacity","0.1");
   
  setTimeout(function(){
    $('body').css("background-color","#fff !important");
    $('body').css("opacity","1");
  },2000)

   $('[data-toggle="tooltip"]').tooltip(); 

    // var zNodes = '';
    var zNodes = {!! json_encode($all_nods) !!};
    var whchjobs = {!! json_encode($whchjobs) !!};
    var setting = {
                    edit: {
                      enable: true,
                      showRemoveBtn: false,
                      showRenameBtn: false,
                    },
                    data: {
                      keep: {
                        parent: true,
                        leaf: true
                      },
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
                        onDragMove: myOnDragMove
                        // onExpand: expandNode
                        // onCheck: zTreeOnCheck
                    },
                  };


      setTimeout(function(){
        expandNode();
      },500);

      function myOnDragMove(event, treeId, treeNodes) {
        console.log(event.target);
      }

      function expandNode() {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
          zTree.expandAll(true);
          zTree.expandAll(false);
      }
      // function zTreeOnCheck(event, treeId, treeNode) {
        // var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
      //   var nodes = treeObj.getCheckedNodes(true);
      //   console.log(nodes); //Here are all of the selected nodes
      // };

      function refreshPage(whchjobs){
         $("#treeDemo").hide();
         $(".hr_new3").hide();
         $(".loader").show();
         setTimeout(function () {
            window.location.reload();
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
Select All Function
**/
var array_checked = []; 
function checkfile(type)
  {
    console.log(type);

  array_checked = []; 
    
    if(type == 'all'){

      if($(".checkbox_selectall_chck").is(":checked")){
        
        $(".filecheck").prop('checked', true);
        
        // $('#download_btn').prop("disabled", false);
        // $('#exportzip_btn').prop("disabled", false);
        // $('#print_btn').prop("disabled", false);
      }else{
        
        $(".filecheck").prop('checked', false);
        
        // $('#download_btn').prop("disabled", true);
        // $('#exportzip_btn').prop("disabled", true);
        // $('#print_btn').prop("disabled", true);
      }

    }else{
      
      if($(type).is(":checked")){
        $(type).prop('checked', true);
      }else{
        $(type).prop('checked', false);
      }
    
    }

    $("input:checkbox[name=file_id]:checked").each(function() { 
      if(jQuery.inArray($(this).val(), array_checked) !== -1){
      }else{
        array_checked.push($(this).val()); 
      }

    }); 
    if(array_checked.length > 0){
      // $('#download_btn').prop("disabled", false); // Element(s) are now enabled.
      // $('#exportzip_btn').prop("disabled", false);
      // $('#print_btn').prop("disabled", false);
    }else{
      // $('#download_btn').prop("disabled", true);
      // $('#exportzip_btn').prop("disabled", true);
      // $('#print_btn').prop("disabled", true);
    }
  }
  
    function folderCheck(id) {
    // console.log(id);
    var main = document.querySelector(".main-checkbox-"+id);
    var children = document.querySelectorAll(".sub-checkbox-"+id);
    
    children.forEach(child => {
      	console.log(child.value);
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
      // $('#exportzip_btn').prop("disabled", false);
    }else{
      // $('#download_btn').prop("disabled", true);
      // $('#exportzip_btn').prop("disabled", true);
    }
    console.log(array_checked)
    return array_checked;
  }

  $("#download_btn").click(function(){
    var whchjobs = $(this).val();
    if(array_checked.length > 0){
		/**Loader Show**/
		$("#treeDemo").hide();
		$(".hr_new3").hide();
		$(".loader").show();
	  $.ajax({
          type: "POST",
          url: baseurl+"/clients/files/downloading",
          data: {_token: "{{ csrf_token() }}",arr_fileid:array_checked},
          dataType: "json",
          success: function(data)
          {
            console.log(data);
            if(data){
              /**jQuery.grep(array_checked, function(value) {
                $("#check-"+value).removeAttr('name');
                $("#check-"+value).prop("disabled", true);
              }); **/

              array_checked = [];
			       $(".filecheck").prop('checked', false);
			 /**Loader Hide**/
				$("#treeDemo").show();
				$(".hr_new3").show();
				$(".loader").hide();
			  toastr.success(data.message, data.title);
            }
          }
      });
    }else{
      swal('Warning','Please select atleast single folder/file','error');
    }
  });

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


/**
End
**/

/**
 Sorting Start 
**/
   function sorting(segment,parentid=0,job,orderName,type){

    if(segment == 'dashboard'){
      parentid = 0;
    }
    
    var spanClass = $('.'+orderName).find('i').attr('class');
    
    $.ajax({
          type: "GET",
          url: baseurl+"/clients/sorting/"+job+"/"+orderName,
          success: function(data)
          {
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
                setTimeout(function(){
                    expandNode();
                },500);
            }
          }
      });
   }
/**
Sorting End
**/

/**
Search Files 
**/
  function toggleSearchBox(){
    $("#search_files").toggle('fast');
    $("#name_date").toggle('fast');
  }

  $(".search_inp").keyup(function(e){
    if(e.keyCode == '13'){
      swal({
            title: "Click options where you want to apply search ?",
            buttons: {
              close: "Search files",
              catch: {
                text: "Search inside document",
                value: "catch",
              },
            },
          })
          .then((value) => {
            var keywords = $(this).val();
            var job = $('.selected_job').val();
            if(keywords){
              switch (value) {
                case "catch":
				 $('#loader1').removeClass('hide_div');
                $('#page_overlay').removeClass('hide_div');
				 $('body').css({'pointer-events':'none'});
				 
                  $.ajax({
                      type: "GET",
                      url: baseurl+"/clients/search_inside/"+keywords+"/"+job,
                      success: function(data)
                      {
						$('#loader1').addClass('hide_div');
                       $('#page_overlay').addClass('hide_div');
						$('body').css({'pointer-events':'all'});
                        if(data){
                          console.log(data);
                            $("#treeDemo").hide();
                            $(".hr_new3").hide();
                            $("#for-search-con").html(data);
                            $("#for-search-con").show();
                        }else{
                          swal(
                              'Searching..',
                              'No result found for this keywords',
                              'error'
                            );
                        }
                      }
                  });
                  break;
                
                case "close":
                  $.ajax({
                      type: "GET",
                      url: baseurl+"/clients/search/"+keywords+"/"+job,
                      success: function(data)
                      {
                        if(data != ''){
                          console.log(zNodes);
                            zNodes = JSON.parse(data);
                            load(setting,zNodes);
                             setTimeout(function(){
                                  expandNode();
                              },500);
                        }else{
                          swal(
                              'Searching..',
                              'No result found for this keywords',
                              'error'
                            );
                        }
                      }
                  });
                  break;

                default:   
              }
            }else{
              window.location.reload();
            }
          });
    }
  });
/**stop**/


$( document ).ready(function() {
  load(setting,zNodes);
});

function load(setting,zNodes){
  // console.log(zNodes);
  return $.fn.zTree.init($("#treeDemo"), setting, zNodes);
}

// function renameFile(id){
//   var fileid = $(this).data('file_id');
//   alert(id);
// }

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

    // function printFiles(){
//   printJS({
//     printable: ['http://66.206.3.18/etabella/public/images/file-pdf-icon_64.png', 'http://66.206.3.18/etabella/public/images/Folder-blue-icon_64.png', 'http://66.206.3.18/etabella/public/images/folder2.png'],
//     type: 'image',
//     header: 'Multiple Images',
//     imageStyle: 'width:50%;margin-bottom:20px;'
//    });
// }

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

/** 
Start ajax method for get rename filename 
**/
  function renameFile(id){
    $.ajax({
           type: "Get",
           url: baseurl+"/clients/get_file/"+id,
           data: {"id":id}, 
           dataType: "json",
           success: function(data)
           {
            console.log(data);
              swal({
                    title: "Rename "+'"'+data.file_name+'"'+"!",
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

    var arr_ids = [];
    function moveFile(fileId){
      if ($.inArray(fileId, arr_ids) !== -1) {
          arr_ids.splice($.inArray(fileId, arr_ids),1);
          $(".facheck-"+fileId).hide();
        }else{
        arr_ids.push(fileId); 
        $(".facheck-"+fileId).show();
      }
      console.log(arr_ids);
    }
  
  	

/** End **/
</script>
@stop

@endsection