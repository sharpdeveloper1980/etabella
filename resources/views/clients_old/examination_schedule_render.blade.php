@extends('layouts.client.app')
@section('title','Examination Schedule File Render')
@section('content')
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
.accordion_files {
    height: auto !important;
}
.ui-accordion-content-active{
	display:block !important;
}
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
	border: 1px solid #b8b8ba;
	background: #f6f6f6;
	font-weight: normal;
	color: #656565;
}
.custom_class {
    height: 100px !important;
}
.sort_dd .action-button {
	border: 2px solid #e54e09 !important;
	width: auto;
	height: 28px;
	float: right;
}
img.file_iocn {
    width: 19px;
}
a{
	text-decoration:none;	
}
a:hover{
	text-decoration:none;	
}
#save_selected_data {
    float: inherit !important;
} 
body{
  overflow: hidden;
}
#issue_table >tr> td {
    width: 22%;
    padding-right: 20px;
    height: 47px;
}
a.overlay_delete {
    background: red !important;
    color: white !important;
    padding-left: 7px !important;
    padding-right: 5px !important;
    margin-left: 172px !important;
    position: absolute !important;
}
.topnavbar-wrapper{
  display:none;
}
  .nodefile.filecheck {
    display: none !important;
  }
  
  i.fa.fa-check {
    color: green;
    font-size: 20px;
    margin-left: 16px;
  }

  .jconfirm-box.jconfirm-hilight-shake.jconfirm-type-default.jconfirm-type-animated {
      width: 500px !important;
   }

  ul {
    list-style: none;
  }
  
  .PSPDFKit-DocumentEditor > div:first-child {
    display: none !important;
  }
  
  .incomming_comment {
    width: 80%;
    height: 50px;
}
.outgoing_comment {
    width: 80%;
    height: 50px;
    margin-left: 20%;
    background: #ebeef5;;
    color: #333;
    padding: 10px;
    border-radius: 8px;
     margin-bottom: 10px;
}
.incomming_comment {
    width: 80%;
    height: 50px;
    background: #f9f1ca;
    border-radius: 6px;
    margin-bottom: 10px;
  color:#333;
  padding: 10px;
}
.hide_div
  {
    display: none;
  }

.PSPDFKit-Sidebar-Bookmarks-Button-Add{
  display: none !important;
}
.nav.nav-tabs {
    display: flex;
    overflow: auto;
}
.nav.nav-tabs li {
    width: 150px;
    flex-shrink: 0;
    margin-right: 5px;
    position: relative;
}
.nav.nav-tabs li a {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.treeDemo_dd{
  max-height: 300px !important;
    overflow-y: scroll !important;
}
.treeDemo_dd::-webkit-scrollbar {display:none !important;}

/* .tab-content.prev {
    position: absolute;
    top: 460px;
    left: 250px;
    z-index: 9;
}

.tab-content.next {
    position: absolute;
    top: 460px;
    right: 250px;
    z-index: 9;
    
} */
.PSPDFKit-Scroll::before {
content: "←";
font-size: 32px;
color: red;
position: absolute;
top: 50%;
left: 16px;
transform: translateY(-50%);
}

.PSPDFKit-Scroll::after {
content: "→";
font-size: 32px;
color: red;
position: absolute;
top: 50%;
right: 16px;
transform: translateY(-50%);
}
</style>

<script type="text/javascript">

$( document ).ready(function() {
    
  $('body').css("background-color","rgba(255, 165, 0, 0.1)!important");
    $('body').css("opacity","0.1");
   
    setTimeout(function(){
      $('body').css("background-color","#fff !important");
      $('body').css("opacity","1");
    },2000);

});
</script>

    <?php 
      $arr_book_pages = [];
      if($bookJson){
        $bookmrks = json_decode($bookJson);
        if($bookmrks){
          foreach ($bookmrks as $key => $mrk) {
            $arr_book_pages[] = $mrk->action->pageIndex;
          }
        }
      }
  // print_r($arr_book_pages);die;
    ?> 
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
  <div class="row custom-toolbar-parent">
    <input type="hidden" name="active_file_id" class="active_file_id" value="{{$id}}">
    <input type="hidden" name="hyperlink_hdn" class="hyperlink_hdn">
    <ul class="list-inline custom-toolbar">
      <li><a href="#" id="close" class="closebtn" data-toggle="tooltip" data-placement="bottom" title="Close">Close</a></li>
      <li><a href="#" id="rotate"  class="rotatebtn" data-toggle="tooltip" data-placement="bottom" title="Rotate"><img src="{{asset('public/frontend/img/rotate.png')}}" height="23" width="23"></a></li>
      <li><a href="#" onclick="getTags()" data-toggle="tooltip" data-placement="bottom" title="Tags"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" height="23" width="23"></a></li>

      @if(count($clients) > 0)
       <li class="dropdown" data-toggle="tooltip" data-placement="bottom" title="Users">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="share_user"><i class="fa fa-users" aria-hidden="true"></i></a>
          <ul class="dropdown-menu clients-dropdown-menu">
            @foreach($clients as $clnkey => $clnt)
              <li>
                <a href="#" onclick="shareAnnotation(<?=$clnt->client_id?>)" data-clientid="{{$clnt->client_id}}" data-clientname="{{$clnt->client_display_name}}">
                <i class="fa fa-user" style="margin-right: 5px;"></i> 
                  {{ucfirst($clnt->client_display_name)}} 
                </a>
              </li>
            @endforeach
          </ul>
      </li>
      @endif
      <li><a  data-toggle="tooltip" data-placement="bottom" title="File Attachment" title="Attachment" id="attachment"><i class="fa fa-upload"></i></a></li>
      <li class="custom-single" style="width: 60%; text-align: center; color: #E54E09;"><b><span class="active_file_name">{{$file->file_name}}</span></b></li>
      
      <li><a href="#" id="compare_btn" data-toggle="tooltip" data-placement="bottom" title="Compare files"><i class="fa fa-files-o" aria-hidden="true"></i></a></li>
      
      <li><a href="#" id="page1" data-toggle="tooltip" data-placement="bottom" title="Goto page"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>
      
      <li><a href="#" class="createbookmark" data-toggle="tooltip" data-placement="bottom" title="Bookmark"><i id="i-bookmark" class="fa fa-bookmark-o i-bookmark" aria-hidden="true"></i></a></li>
      <li><a href="#" id="search" class="searchbtn" data-toggle="tooltip" data-placement="bottom" title="Search"><i class="fa fa-search" aria-hidden="true"></i></a></li>
      
      <li class="annotation-li"><a href="#" id="annotation" class="annotationbtn" data-toggle="tooltip" data-placement="bottom" title="Annotations"><i class="fa fa-edit" aria-hidden="true"></i><input type="hidden" class="annotation_cls{{$id}}" name="annotation-{{$id}}" value="true"></a></li>
      <li><a href="#" id="grid" class="gridbtn" data-toggle="tooltip" data-placement="bottom" title="Thumbnails"><i class="fa fa-th-large"></i></a></li> 
      @if(count($myFiles) > 0)
      <li class="dropdown myFiles_dd pull-right">
        <a href="#" type="button" class="btn btn-default dropdown-toggle drop12" style="display:none;" data-toggle="dropdown">My File</a>
        
      </li>
      @endif
    </ul>
  </div>

   <div class="row tag-line tag-title-con" style="width:90%;float:left;display:none;height: 1.5em;border: 1px solid #ccc;background-color: aqua;text-align: center;">
    <small id="tag-title"></small>
  </div>
	<div style="width:10%;float:left;height: 1.5em;background:red;color:white;cursor:pointer;" id="tag_remove_btn" class="text-center hide_div"><i class="fa fa-trash"></i> Remove Tag</div>
	<input type="hidden" id="tag_id">
	<input type="hidden" id="tag_file_id">
  

  <div class="container">
  <div>
    <ul class="nav nav-tabs" role="tablist" style="width: 100%;">
        <li data-file="{{ $file->file_name }}" class="li_tab li_tab_{{$id}} active">

          <a href="#pspdfkit_{{$id}}" data-file_id="{{$id}}" data-toggle="tab"><!-- <span style="padding-right: 9px;"> x </span> --> 
             <span data-fileid="{{$id}}" id="first_file" ></span>
            {{ $file->file_name }}</a>
        </li>
         <li id="add_new_tab" class="dropdown add_new_tab" data-toggle="tooltip" data-placement="top" title="Open New File"><a id="new_tab_btn"  style="width:35px" class="">+</a>
        </li>
    </ul>
  </div>
    <div class="tab-content">
      <div class="tab-pane lib_con active" id="pspdfkit_{{$id}}" style="width: 100%; height: 480px !important;"></div>
    </div>
  </div>

  <div class="modal fade docs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="form-groupsearch_sorting" id="search_files">
            <input type="text" name="search" class="form-control search_inp" placeholder="Search here">
               <i class="fa fa-search" aria-hidden="true"></i>
          </div>
        </div>
        <form method="POST" action="{{ route('compareFiles') }}">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="compare_first_file" class="activefile  compare_1" value="{{ $id }}">
            <input type="hidden" name="compare_second_file" class="compare_2" value="{{ $id }}">
            <ul id="treeDemo" class="treeDemo ztree">
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Compare</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade modal-color-picker" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Colour picker</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="hdn_color_picker" class="hdn_color_picker" value="#ccc">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="pageModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Go to Page #</h4>
        </div>
        <div class="modal-body">
          <input type="number" id="pageNo" min="0"> 
        </div>
        <div class="modal-footer">
          <button type="button" id="" class="btn btn-default pagebutton" data-dismiss="modal">Go</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="add_txt_mark" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add To Mark</h4>
        </div>
        <div class="modal-body">
          <h4 id="mark_text" style=" width: 100%;  word-break: break-word; "></h4>
          <hr>
          <div class="all_comment">
           
          </div>
          <div class="new_comment"></div>
          <div class="form-group" >  
            <label>Enter Comment</label>
            <textarea class="form-control" id="comment_field" placeholder="Enter Comment..."></textarea>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" id="save_selected_data" style="float: left;">Save</button> <a id="share_comment"  style="width: 100px" class="btn hide_div" href="javascript:;"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
            <div class="hide_div" id="all_user_list">
              <input type="hidden" id="document_id" value="{!! Request::segment(4) !!}" >
              <input type="hidden" id="comment_id" value="" >
              <p>All Users </p>
              <ul>
            @foreach($clients as $clnkey => $clnt)
              <li>
                <a href="#" class="shareComment" data-clientid="{{$clnt->client_id}}" data-clientname="{{$clnt->client_display_name}}">
                <i class="fa fa-user" style="margin-right: 5px;"></i> 
                  {{ucfirst($clnt->client_display_name)}} 
                </a>
              </li>
            @endforeach
          </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Modal -->
<div id="add_new_file" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">My Files</h4>
      </div>
      <div class="modal-body">
        <div class="page-101">
			@if($all_witness)
			<div id="accordion">
			  @foreach($all_witness as $wit) 
			  <h3>{{ $wit['witness_name'] }}</h3>
			  <?php $files = (new \App\Helpers\Helper)->get_witness_files($wit['id']);  
			  ?>
			  <div class="accordion_files" >
				
				@if($files)
				<table id="example" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>SNo.</th>
							<th>File Name</th>
						</tr>
					</thead>
					<tbody>
					
					<?php $i=1; foreach($files as $f1) { 
					 $color = (new \App\Helpers\Helper)->get_file_tag(Session::get('client_id'),$f1['doc_id']);  
					$file_extension = strtolower(substr(strrchr($f1['file_upload_name'], "."), 1));
					?>
						<tr>
							<td>{{ $i }}</td>
							@if($file_extension == 'pdf')
							<td><a href="javascript:;" onclick="addContact({{ $f1['doc_id'] }},'{{ $f1['file_name'] }}')"> <div style="width:100%;color:cornflowerblue"><span style="background:{{ $color }};width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="{{ asset('public/images/file-pdf-icon_32.png') }}">  {{ $f1['file_name'] }}</div></a></td>
							@endif
						</tr>
					<?php $i++; } ?>
					</tbody>
				</table>
				@else 
					<h3 align="center">File Not Found</h3>
				@endif
			  </div> 
			  @endforeach
			</div>
			@else 
			<div id="accordion">
			 <h3 align="center">Witness And Files Are Not found</h3>
			</div>
			@endif
			</div>
      </div>
    </div>

  </div>
</div>
  <!-- deependra -->
  <div class="modal fade" id="create_issue" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Issue</h4>
        </div>
        <div class="modal-body">
          <div class="row">
      <div class="col-sm-12">
        <a href="javascript:;" id="cretate_issue_btn" id="create_issue_btn" class="btn btn-info btn-sm pull-right">Create Issue</a>
      </div>
      </div>
      <div class="row">
      <div class="col-sm-12">
      <div class="show_issue_table">
      <?php if($all_issue) { ?>
        <table class="table" id="issue_table">
          <tr>
            <th>Issue</th>
            <th>Color</th>
            <th>Action</th>
          </tr>
          <?php 
            foreach($all_issue as $issue)
            {
              ?>
              <tr>
                <td><input type="radio" name="issue_color_select" class="change_icolor" id="change_icolor_<?php echo $issue['id'] ?>"  data-color="<?php echo $issue['color'] ?>" value="<?php echo $issue['name'] ?>" onClick="change_issue_color('<?php echo $issue['id'] ?>')"  ></td>
                <td><?php echo $issue['name'] ?></td>
                <td><div style="background:<?php  echo $issue['color'] ?>">&nbsp;</div></td>
                <td><a href="javascript:;" class="btn btn-info btn-sm delete_issue_color" data-id="<?php echo $issue['id'] ?>">Delete</a></td>
              </tr>
              <?php 
            } 
          ?>
        </table>
        <?php } else { ?>  
        <div style="  text-align: center; margin-top: 31px; margin-bottom: 58px;">
          <p>Issue Not Found | Please Create New Issue</p>
          <a href="javascript:;" id="cretate_issue_btn" id="create_issue_btn" class="btn btn-info btn-sm ">Create Issue</a>
        </div>
        <?php  } ?>
        
        </div>
      </div>
      </div>
        </div>
      </div>
    </div>
  </div>
  
   <div class="modal fade" id="create_issue_popup" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create Issue </h4>
        </div>
        <div class="modal-body">
          <div class="row">
      <div class="col-sm-12">
        
        <div id="create_new_issue_block">
          <div class="row">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Enter Issue Name</label>
                    <input type="text" name="issue" id="issue_name" placeholder="Enter Issue"  class="form-control" />
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Enter Select Color</label>
                    <input type="color" name="color" id="issue_color" required="required" class="form-control" />
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <button class="btn btn-primary btn-sm" id="add_new_iccue_db_btn"><i class="fa fa-add"></i> Add</button>
                    <button class="btn btn-danger btn-sm" id="close_issue_popup_btn"><i class="fa fa-cancel"></i>Close</button>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
        </div>
      </div>
    </div>
  </div>
  
  
  <div class="modal fade" id="" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create Hyperlink </h4>
        </div>
        <div class="modal-body">
          <div class="row">
      <div class="col-sm-12">
        
      </div>
      </div>
        </div>
      </div>
    </div>
  </div>
  
    <div class="modal fade " id="create_hyperlink_popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        <input type="checkbox" value="1" id="user_current_file" />
        <label for="user_current_file">Use Current File</label>
          <div class="form-groupsearch_sorting" id="search_files">
            <div id="search_files1">
              <input type="text" name="search" class="form-control search_link" placeholder="Search here">
               <i class="fa fa-search" aria-hidden="true"></i>
            </div>
          </div>
        </div>
    <input type="hidden" id="annotation_id" />
    
       
          @csrf
          <div class="modal-body">
            <div id="treeDemo_list">
                <div class="col-md-12">
                  <ul id="treeDemo" class="treeDemo ztree "></ul>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <button  style="float: right;" class="btn btn-info hyperlink_btn" onclick="createUrlLink()">Hyperlink</button>
                      <button style="float: right; margin-right: 5px" class="btn btn-secondary hyperlink_cancel" modal-dismiss="true">Cancel</button>
                    </div>
                  </div>
                </div>
            </div>

            <div id="custom_page_no" class="hide_div">
              <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Enter Page No / External Url</label>
                      <input type="hidden" class="tot_page_no" name="tot_page_no">
                      <input type="text" class="form-control" id="page_no" />
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <button  style="float: right;" class="btn btn-info hyperlink_btn" id="add_page_no">Hyperlink</button>
                      <button style="float: right; margin-right: 5px" class="btn btn-secondary hyperlink_cancel" modal-dismiss="true">Cancel</button>
                    </div>
                  </div>
                </div>
            </div>
          </div>
         
       
      </div>
    </div>
  </div>

  <!-- The Modal -->
<div class="modal" id="file_upload">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Upload File</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{ asset('clients/upload_pdf_file_for_pdf') }}" class="database_operation_form_new">
        <div class="row">
          <div class="col-lg-12">
              <div class="form-group">
                <label>Select File</label>
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" name="file_id" id="file_id" value="{{ Request::segment(4) }}">
                 <input type="file" required="required" name="file" class="form-control" />
              </div>
          </div>
          <div class="col-lg-12">
              <div class="form-group">
                <button type="submit" class="btn btn-info submitbtn">Upload</button>
              </div>
          </div>
        </div>
       </form>
      </div>
    </div>
  </div>
</div>
<input type="hidden" value="{{ $layer_token }}" id="active_layer" />
@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
$( function() {
    $( "#accordion" ).accordion();
  } );
var prev_file=0;
$(document).on('click','.li_tab',function(){
	//alert(prev_file);
	var fid = $(this).children('a').attr('data-file_id');
	PSPDFKit.unload('#pspdfkit_'+prev_file);
	prev_file=fid; 
  	$('.active_file_name').text($(this).attr('data-file'));
});
var open_files=[];
var overlay_ids=[];
var annotaed_files=[];
$('[data-toggle="tooltip"]').tooltip();

  var markers = [];
    var id = "{{$id}}";
    var mi = 0;
    var count=0;
    var arr_pages = [];
    var zNodes = {!! json_encode($all_nods) !!};
    var zNodes_dd = {!! json_encode($all_nods_dd) !!};
    var zNodes_links = {!! json_encode($all_add_to_links) !!};
    //var report_page = {!! json_encode($page) !!};
    var annotation1 = '';
    var Squiggle1 = '';
    var Highlight1 = '';
    var highlighted_instance = '';
    var annoted_text = '';
    var arr_link_ids = [];
    var text_selected = '';
    var is_external = '';
  var squiggly_json = '';
  var report_all = [];
    var report_annotation = 'Annotation';
    var report_bookmark = '';
  var delete_id = '';
  var already_open = [];
  var tool_tip_counter=0;
  var annotation_ids=[];
  var annotation_ids_new=[];
 var open_file_info=[];
 var open_count=1;
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

    
already_open = [];
already_open.push(id);
already_open = JSON.parse('['+already_open+']');

getFileData(id);

function doBlur(){
   $('body').css("background-color","rgba(255, 165, 0, 0.1)!important");
    $('body').css("opacity","0.1");

  // setTimeout(function(){
    
  // },2000)
}

function getFileData(id){
    // $("#loader").show();
    $.ajax({
      type: "GET",
      url: baseurl+"/clients/get-render-file/"+id,
      dataType: 'json',
      success: function(data)
        {  
          loadFile(data);
          if(data){
            
          }else{
            swal('Something went wrong','error');
          }
        }
    });    
  }  

   // function unloadFile(fileid){  
   //     PSPDFKit.unload(markers[fileid]);
   // }

   function loadFile(data){  
   var layer = $('#active_layer').val();
   open_files.push(data.file.file_id);
   //annotaed_files.push({'file_id':data.file.file_id,'status':0});
   annotaed_files[data.file.file_id]=0;
   console.log('a');
   console.log(layer);
   var obj={'psppdf_file_id':data.file.pspdf_file_id,'layer':layer,'file_id':data.file.file_id};
   if(open_count)
   {
		open_file_info.push(obj);
		open_count=0;
   }
   prev_file=data.file.file_id;
    $.ajax({
           url:api_url+data.file.pspdf_file_id+'/'+layer,
       method:'GET',
       contentType:"application/json",
       success : function(resp){
              $('body').css("background-color","#fff !important");
            $('body').css("opacity","1");
      PSPDFKit.Options.IGNORE_DOCUMENT_PERMISSIONS = true
      PSPDFKit.load({
         container: "#pspdfkit_"+data.file.file_id,
         documentId: data.file.pspdf_file_id,
         authPayload: { jwt: resp },
    // autoSaveMode: PSPDFKit.AutoSaveMode.INTELLIGENT,
         instant: true, 
      //   styleSheets: ["http://66.206.3.18/etabellaweb/public/dist/pspdfkit/custom-pspdfkit.css"],
       })
        .then(function(instance) {
	//	instance.viewState.set("FIT_TO_VIEWPORT",PSPDFKit.ZoomMode);
		instance.setViewState(function (state) {
		return state 
		.set('ZoomMode', PSPDFKit.ZoomMode.FIT_TO_VIEWPORT)
		.set('scrollMode', PSPDFKit.ScrollMode.PER_SPREAD)
		});      
        
         //markers[id].viewState.set("scrollMode", "PER_SPREAD");  
        // const state11 = instance.viewState;

      //  instance.setViewState(newState11);
        
          instance.addEventListener("annotations.create", function(createdAnnotations) {
            annotation_ids.push(createdAnnotations._tail.array[0].id);
            var fill_arr={'file':$(".activefile").val(),'id':createdAnnotations._tail.array[0].id};
            annotation_ids_new.push(fill_arr);
            console.log(annotation_ids);
			if(annotaed_files<0)
			{
				annotaed_files[$(".activefile").val()]=0;
			}
			annotaed_files[$(".activefile").val()]++;
			console.log(annotaed_files);
          });
      

      var fid= $(".activefile").val();
      $.post(baseurl+'/clients/get_document_file',{_token:"{{ csrf_token() }}",'file_id':fid },function(fb){
        var file_resp=$.parseJSON(fb);
        if(file_resp.status=='true')
        {
        var size=Object.keys(file_resp.data).length 
        const videoWidget=[]; 
        for(i=0;i<size;i++)
        {
        videoWidget[i] = document.createElement('div');
          if(file_resp.data[i].file_type=='jpg' || file_resp.data[i].file_type=='png' || file_resp.data[i].file_type=='svg')
          {           
             videoWidget[i].innerHTML ='<a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  style=" margin-left: 182px; background: red; padding-top: 8px; padding-left: 13px; padding-bottom: 8px; padding-right: 12px; position: absolute; top: -36px; border-radius: 50px; color: white; " class="overlay_delete" href="javascript:;">&#10005;</a><img width="200px" height="100px" src="'+baseurl+'/'+file_resp.data[i].file_name+'">';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+file_resp.data[i].page_no,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 350, y: 600 })
            });
            instance.setCustomOverlayItem(item);
          }
          else if(file_resp.data[i].file_type=='mp4' || file_resp.data[i].file_type=='avi' || file_resp.data[i].file_type=='webm' || file_resp.data[i].file_type=='avi')
          {
            videoWidget[i].innerHTML =
              '\
              <a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  style=" margin-left: 182px; background: red; padding-top: 8px; padding-left: 13px; padding-bottom: 8px; padding-right: 12px; position: absolute; top: -36px; border-radius: 50px; color: white; " class="overlay_delete" href="javascript:;">&#10005;</a><video width="200" controls>\
              <source src="'+baseurl+'/'+file_resp.data[i].file_name+'" type="video/'+file_resp.data[i].file_type+'"> \
              Your browser does not support HTML5 video. \
              </video> \
            ';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+file_resp.data[i].page_no,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 350, y: 600 })
            });
            instance.setCustomOverlayItem(item);
          }
          else if(file_resp.data[i].file_type=='mp3' || file_resp.data[i].file_type=='mpeg' || file_resp.data[i].file_type=='m4r' || file_resp.data[i].file_type=='ogg')
          {
            videoWidget[i].innerHTML =
              '<a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  style=" margin-left: 182px; background: red; padding-top: 8px; padding-left: 13px; padding-bottom: 8px; padding-right: 12px; position: absolute; top: -36px; border-radius: 50px; color: white; " class="overlay_delete" href="javascript:;">&#10005;</a><audio style="width:200px" controls><source src="'+baseurl+'/'+file_resp.data[i].file_name+'" type="audio/'+file_resp.data[i].file_type+'"></audio>';
               var item = new PSPDFKit.CustomOverlayItem({
                id: "video-instructions_"+file_resp.data[i].page_no,
                node: videoWidget[i],
                pageIndex:parseInt(file_resp.data[i].page_no),
                position: new PSPDFKit.Geometry.Point({ x: 360, y: 730 })
              });
              instance.setCustomOverlayItem(item);
          }
          else 
          {
            videoWidget[i].innerHTML ='<a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  class="overlay_delete" href="javascript:;" style=" background: red; color: white; left: 28px; position: absolute; top: -21px; padding-top: 5px; padding-left: 10px; padding-right: 10px; padding-bottom: 6px; border-radius: 50px; ">&#10005;</a><a href="'+baseurl+'/'+file_resp.data[i].file_name+'" target="_blank"><img width="50px" height="50px" src="https://image.flaticon.com/icons/png/512/2323/premium/2323513.png"></a>';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+file_resp.data[i].page_no,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 530, y: 720 })
            });
            instance.setCustomOverlayItem(item);
          }
          
        }
        }
      });


        instance.setToolbarItems(function(items) {
          // console.log(items);
            items.splice(0, 30);
            items.push({"type": "sidebar-thumbnails"});
            items.push({"type": "sidebar-bookmarks"});
            items.push({"type": "pager"});
          items.push({"type": "zoom-in"});
          items.push({"type": "zoom-out"});
            items.push({"type":"spacer"});
            items.push({
                    type: "custom",
                    id: "comment_btn",
                    title: 'Comment',
                    onPress: function(event) {
                      if(text_selected == 1){
                        $("#comment_id").val('');
                        $(".new_comment").html('');
                        $(".all_comment").html('');
                        $("#mark_text").html('<h4>'+annoted_text+'</h4>');
                        $('#share_comment').addClass('hide_div');
                        $('#add_txt_mark').modal('show');
                      }else{
                        toastr.error('You need to select some text','Error',{"debug": false,});
                      } 
                    }
                  },
                  {
                  type: "custom",
                  id: "hyperlink_btn",
                  title: 'Hyperlink',
                  onPress: function(event) {
                    if(text_selected == 1){
                      load(setting,zNodes_links);
                      $('#create_hyperlink_popup').modal('show');
                    }else{
                      toastr.error('You need to select some text','Error',{"debug": false,});
                    }
                  }
                });
            items.push({
                type: "custom",
                  id: "issue_btn",
                  title: 'Issue',
                  onPress: function(event) {
                    if(text_selected == 1){
                      $(".change_icolor").prop('checked', false); 
                      $('#create_issue').modal('show');
                    }else{
                      toastr.error('You need to select some text','Error',{"debug": false,});
                    } 
                } 
             });
            items.push({"type":"highlighter"});
            items.push({"type":"ink"});
            items.push({"type":"text-highlighter"});
            items.push({"type":"ink-eraser"});
            items.push({"type":"line"});
            items.push({"type":"arrow"});
            items.push({"type":"rectangle"});
            items.push({"type":"ellipse"});
            items.push({"type":"polygon"});
            items.push({"type":"polyline"});
            items.push({"type":"note"});
            return items;
          });
      
          instance.totalPageCount; // => 10
            $('.tot_page_no').val(instance.totalPageCount);
            
            if(<?=$page?>){
              const state = instance.viewState;
              const newState = state.set("currentPageIndex", <?=$page?>-parseInt(1));
              instance.setViewState(newState);
            }
            var fid = data.file.file_id;
            markers[fid] =instance;
        
            const state = instance.viewState;
           // const newState = state.set("scrollMode", "PER_SPREAD");
            //instance.setViewState(newState);
           
      instance.addEventListener("annotations.delete", deletedAnnotations => {
              delete_id = deletedAnnotations._tail.array[0].id;
              deleteKit(fid);
			  annotaed_files[$(".activefile").val()]=annotaed_files[$(".activefile").val()]-1;
			  console.log('Delete Annotation')
			  console.log(annotaed_files);
      });
    
      instance.setViewState(function(viewState) {
        return viewState.set("sidebarMode", null);
    });
    
    
      instance.addEventListener("bookmarks.create", (createdBookmarks) => {
          report_bookmark = 1;
          report_all.push({"Data_id":createdBookmarks._tail.array[0].id,"Data_page":createdBookmarks._tail.array[0].action.pageIndex,"Data_type":"Bookmarked"});
		  if(annotaed_files<0)
		  {
			  annotaed_files[$(".activefile").val()]=0; 
		  }
		  annotaed_files[$(".activefile").val()]++;
		  console.log('bookmarks Created');
		  console.log(annotaed_files)
		});
    
      instance.addEventListener("bookmarks.delete", (deletedBookmarks) => {
            report_bookmark = 1;
            delete_id = deletedBookmarks._tail.array[0].id;
        deleteKit(fid);
		annotaed_files[$(".activefile").val()]=annotaed_files[$(".activefile").val()]-1;
		console.log('bookmarks Delete');
		console.log(annotaed_files)
        });
    
  json='';
    instance.addEventListener("textSelection.change", function(textSelection) {
      if(textSelection){
        text_selected = 1;
        squiggly_json = '';
        textSelection.getSelectedRectsPerPage().then(rectsPerPage => {
          rectsPerPage.map(({ pageIndex, rects }) => {
            textSelection.getText().then(text => {
              annoted_text = text;
              annotation1 = new PSPDFKit.Annotations.UnderlineAnnotation({
                pageIndex: pageIndex,
                rects: rects,
                boundingBox: PSPDFKit.Geometry.Rect.union(rects)
              });

              Squiggle1 = new PSPDFKit.Annotations.SquiggleAnnotation({
                pageIndex: pageIndex,
                rects: rects,
                boundingBox: PSPDFKit.Geometry.Rect.union(rects)
              });

              Highlight1 ={ pageIndex : pageIndex,rects:rects};
            });
          });
        });
      }
    });
    
    function GoToPage(id,page_no){
      
      const state = markers[id].viewState;
        const newState = state.set("currentPageIndex", parseInt(page_no)-parseInt(1));
        markers[id].setViewState(newState);
    }

    instance.addEventListener("annotations.press", event => {
      text_selected = '';
      if(squiggly_json){
        squiggly_json = '';
      }
    var serializedObject = PSPDFKit.Annotations.toSerializableObject(event.annotation);
    
      var json = JSON.stringify(serializedObject);
      var resp=$.parseJSON(json);
    if(resp.type == "pspdfkit/markup/underline"){
        var id=resp.id;
         $.post(baseurl+'/clients/check_hyperlink',{_token:"{{ csrf_token() }}","id":id},function(fb){
           var ajax_resp=$.parseJSON(fb);
           
          if(ajax_resp.status=='true')
           {
            if(ajax_resp.data[0].is_external == 1){
              window.open(ajax_resp.data[0].url, '_blank');
            }
           else if (ajax_resp.data[0].is_external == 2){
              window.location.href=baseurl+'/'+ajax_resp.data[0].url;
            }
           else if (ajax_resp.data[0].is_external == 3){
              if ($.inArray(ajax_resp.data[0].file_id, already_open) !== -1) {
                  $.get(baseurl+"/clients/get_file/"+ajax_resp.data[0].file_id, function(datas){
                      datas = JSON.parse(datas);
                  
                      toastr.warning('"'+datas.file_name+'"'+' file is already opened in tab','Error',{"debug": false,});
                    });
                      
              }else{
                  $.get(baseurl+"/clients/get_file/"+ajax_resp.data[0].file_id, function(dataas){
                      dataas = JSON.parse(dataas);
                    addContact(ajax_resp.data[0].file_id,''+dataas.file_name+'');
                    // already_open.push(ajax_resp.data[0].file_id);
                    });
              }
            }
           }
         })
      }else if(resp.type=='pspdfkit/markup/squiggly'){
      squiggly_json = json;
        $.post(baseurl+'/clients/read_all_text_comment',{_token:"{{ csrf_token() }}","json":json},function(fb){
          let resp=$.parseJSON(fb);
          if(resp.status=='true'){
            var message=resp.data;
            $('#add_txt_mark').modal('show');
            $('#mark_text').text(resp.message);
            $('.all_comment').html('');
            $('.new_comment').html('');
            $('#comment_id').val(resp.comment_id);
            $('#share_comment').removeClass('hide_div');
            for(i=0;i<Object.keys(message).length;i++)
            {
            if(resp.user_id==message[i].user_id)
            $('.all_comment').append('<div class="outgoing_comment">'+message[i].comment+'</div>');
            else 
            $('.all_comment').append('<div class="incomming_comment">'+message[i].comment+'</div>');
          }
        }
      });
    }else{   }
     return false;
     
        var id=resp.id;
        $.post(baseurl+'/clients/check_hyperlink',{_token:"{{ csrf_token() }}","id":id},function(fb){
           var ajax_resp=$.parseJSON(fb);
           if(ajax_resp.status=='true'){
             window.location.href=baseurl+'/'+ajax_resp.data[0].url;
           }else{
            load(setting,zNodes_links);
            $('#annotation_id').val(id);
            $('#create_hyperlink_popup').modal('show');
           }
        })
    }); 
          // deleteBookmarks
          const viewState = instance.viewState;
          const curr_page = viewState.currentPageIndex+1;
          
          instance.setViewState(viewState.set("showToolbar", true));
			//PSPDFKit.unload("#pspdfkit_"+data.file.file_id)
        
		})
        .catch(function(error) {
          console.error(error.message);
        });
      /*pspdf load*/
    
    },error:function(err)
       {
      
       }
        });
  }
  

   $("#page1").click(function(){
      $("#pageModal").modal('show');
   });

   $("#attachment").click(function(){
      $("#file_upload").modal('show');
   });

  /*deependra*/
   $(document).ready(function(){
     localStorage.setItem("selected_text", "");
   });
   $(document).on('click','#cretate_issue_btn',function(){
     $('#create_issue').modal('hide');
     $('#create_issue_popup').modal('show');
   });
   $(document).on('click','#close_issue_popup_btn',function(){
     $('#create_issue_popup').modal('hide');
     $('#create_issue').modal('show');
   });
   $(document).on('click','#add_new_iccue_db_btn',function(){
     var issue_name=$('#issue_name').val();
     if(issue_name=='')
     {
        swal('Please Enter Issue Name')
        return false;
     }
     var issue_color=$('#issue_color').val();
     var data={'name':issue_name,'color':issue_color,_token:'{{ csrf_token() }}'};
    $.post(baseurl+'/clients/add_new_issue',data,function(fb){
      if(fb!='')
      {
        $.get(baseurl+'/clients/get_all_issue',function(fb){
          resp=$.parseJSON(fb);
          var obect_length=Object.keys(resp).length;
          if(!$('table').hasClass('issue_table'))
          {
            $('.show_issue_table').html('<table class="table" id="issue_table"></table>');
          }
          $('#issue_table').html('<tr><th>Issue</th><th>Color</th><th>Action</th></tr>');
          for(i=0;i<obect_length;i++)
          {
              
              
              $('#issue_table').append('<tr><td><input type="radio" class="change_icolor" id="change_icolor_'+resp[i].id+'" data-color="'+resp[i].color+'" value="'+resp[i].name+'" onClick="change_issue_color('+resp[i].id+')"  ></td><td>'+resp[i].name+'</td><td><div style="background:'+resp[i].color+'">&nbsp;</div></td><td><a href="javascript:;" class="btn btn-info btn-sm delete_issue_color" data-id="'+resp[i].id+'">Delete</a></td></tr>');
          }
        })
        $('#issue_name').val('');
        $('#issue_color').val('');
         $('#create_issue_popup').modal('hide');
         // text_selected = '';
         $('#create_issue').modal('show');
      }
      else 
      {
        swal('Some Technical Problum Please Try Again');
      }
    })
   });

   function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
      r: parseInt(result[1], 16),
      g: parseInt(result[2], 16),
      b: parseInt(result[3], 16)
    } : null;
  }

   function change_issue_color(id)
   {
	   var repo=[];
    $(".change_icolor").prop('checked', false); 
      var active_file = $(".activefile").val();
      var createdAnnotation='';
      var clr = $('#change_icolor_'+id).data('color');
    $('#change_icolor_'+id).prop('checked', true);  
      var colorcode = hexToRgb(clr); 
      var color = new PSPDFKit.Color({ r: 245, g: 0, b: 0 });
      color = color.set("r", colorcode.r);
      color = color.set("g", colorcode.g);
      color = color.set("b", colorcode.b);

      var highlighter = new PSPDFKit.Annotations.HighlightAnnotation({
        pageIndex: Highlight1.pageIndex,
        rects: Highlight1.rects,
        boundingBox: PSPDFKit.Geometry.Rect.union(Highlight1.rects),
        color:color
      });

      markers[active_file].createAnnotation(highlighter).then(function(createdAnnotation) {
        createdAnnotation=createdAnnotation;
        var serializedObject = PSPDFKit.Annotations.toSerializableObject(createdAnnotation);
        var json = JSON.stringify(serializedObject);
        highlighted_instance=$.parseJSON(json);
        //report_all.push({"Data_id":createdAnnotation.id,"Data_page":createdAnnotation.pageIndex,"Data_type":"Issues"});
		var rep={"Data_id":createdAnnotation.id,"Data_page":createdAnnotation.pageIndex,"Data_type":"Issues"};
        repo.push(rep);
      });
    text_selected = '';
      var active_file = $(".activefile").val(); 
      var file_id = active_file;
      var file_id = active_file;
      const viewState = markers[file_id].viewState;
      const page_no = viewState.currentPageIndex + 1; 

      markers[file_id].exportInstantJSON().then(function(instantJSON) {
      const viewState = markers[file_id].viewState;
      const page_no = viewState.currentPageIndex + 1; // => 0
        $.ajax({
            type: "POST", 
            url: baseurl+"/clients/instant-json",
            data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:file_id,page_no:page_no,report_annotation:'Issue',report_bookmark:report_bookmark,report_all:JSON.stringify(repo)},
            success: function(data)
            { 
             
            }
        });
        }); 
  $.get(baseurl+'/clients/add_activity/Issue',function(fb){
    
  })
    $("#create_issue").modal('hide');
   }
   
   $(document).on('change','#user_current_file',function(){
    var user_current_file = $("input[id='user_current_file']:checked").val();
    if(user_current_file == 1){
        $('#custom_page_no').removeClass('hide_div');
        $('#search_files1').addClass('hide_div');
        $('#treeDemo_list').addClass('hide_div');
      }else{
        $('#custom_page_no').addClass('hide_div');
        $('#search_files1').removeClass('hide_div');
        $('#treeDemo_list').removeClass('hide_div');
      }
   });

  function validateURL(textval) {
    var urlregex = new RegExp(
          "^(http:\/\/|https:\/\/|http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
    return urlregex.test(textval);
  }

   $(document).on('click','#add_page_no',function(){
      var page_no=$('#page_no').val();  
      var file_id = $(".activefile").val();
      if($.isNumeric(page_no)){
        var tot_page_no = $('.tot_page_no').val();
      
        if(parseInt(page_no) > parseInt(tot_page_no)){
          toastr.error('Total number of pages is '+tot_page_no,'Error',{
                      "debug": false,
          });
        return false;
        }
       var url = 'clients/file/render/'+file_id+'/'+page_no;
      is_external = 2;
      }else{
        var valid = validateURL(page_no);
        if(valid == false){
          toastr.error('Please Enter a valid Url','Error',{
                      "debug": false,
          });
          return false;
        }else{
          is_external = 1;
          var url = page_no;
        }
      }


      createHyperLinkAnnotation(url,file_id,page_no);

      $("#create_hyperlink_popup").modal('hide');
   
 
   });

 
  
      $("#color-picker").click(function(){
        $(".modal-color-picker").modal('show');
      });
  
      $(".nav-tabs").on("click", "a", function (e) {

          e.preventDefault();
     // var old_active_id = $(".activefile").val();
     // unloadFile(old_active_id);
          var idd = $(this).data('file_id');
         
          $('.active_file_id').val(idd);

          $(".activefile").val(idd);
          $("#file_id").val(idd);
          
          $('.pagebutton').attr('onclick','gotoPage('+idd+')');
          $('.closebtn').attr('onclick','closeKit('+idd+')');
          $('.rotatebtn').attr('onclick','rotateKit('+idd+')');
          $('.annotationbtn').attr('onclick','annotationKit('+idd+')');

          $('.searchbtn').attr('onclick','searchKit('+idd+')');
          $('.gridbtn').attr('onclick','gridKit('+idd+')');
          /** For Bookmark **/
          getBookmarkedPages(idd);
          
          $('.createbookmark').attr('onclick','createBookmark('+idd+')');
          
          setTimeout(function(){
            currentPage(idd);  
            getCheckedTag(idd);
            pdf_overlay(idd);
      getFileData(idd);
          },500);
          /** For Bookmark End **/


          if (!$(this).hasClass('add-contact')) {
              $(this).tab('show');
          } 
      })
      .on("click", "span", function (e) {

        var filename = '';
        var idd = id;
        // $.get(baseurl+"/clients/get_file/"+idd, function(data){ 
        // data = JSON.parse(data); 
        // $('.add-contact-'+idd).attr('onclick','addContact('+idd+','+data.file_name +')');      
        // });
        var anchor = $(this).siblings('a');
        var fileid = $(this).parent().data('file_id');
        
        if ($.inArray(fileid, already_open) !== -1) {
          already_open.splice($.inArray(fileid, already_open), 1);
        }
          $(anchor.attr('href')).remove();
      //alert(fileid)
       // closeKit_tab(fileid,'tab_change');
	//annotaed_files[$(this).attr('data-fileid')]=0;
	closeKit_single_file($(this).attr('data-fileid'));
	//return false
	$(this).parent().parent().remove();
	  
          console.log(already_open);
            // unloadFile(fileid);
      
      $(".nav-tabs li").children('a').first().click();
        $("#pspdfkit_"+idd).addClass('active'); 
         e.preventDefault();
          $('.active_file_id').val(idd);
    
          $(".activefile").val(idd);
          $("#file_id").val(idd);
          
      
          $('.pagebutton').attr('onclick','gotoPage('+idd+')');
          $('.closebtn').attr('onclick','closeKit('+idd+')');
          $('.rotatebtn').attr('onclick','rotateKit('+idd+')');
          $('.annotationbtn').attr('onclick','annotationKit('+idd+')');

          $('.searchbtn').attr('onclick','searchKit('+idd+')');
          $('.gridbtn').attr('onclick','gridKit('+idd+')');
          /** For Bookmark **/
         // getBookmarkedPages(idd);
          
         $('.createbookmark').attr('onclick','createBookmark('+idd+')');
        setTimeout(function(){
          $("#pspdfkit_"+fileid).remove();
          // $(".li_tab_"+fileid).remove(); 
            currentPage(idd);  
            getCheckedTag(idd);
            pdf_overlay(idd);
          },500);
        
          return false;
      });
      var previue_file=$(".activefile").val();
    /*  $(document).on('click','.li_tab',function(){
        var new_file = $(this).children('a').attr('data-file_id');
        closeKit_tab(previue_file,'tab_change');
        setTimeout(function(){
         // alert(previue_file);
          previue_file=new_file;
         // alert(previue_file);
        },10000);
        
      });*/

  /*$('.add-contact').click(function (e) {
      e.preventDefault();
      var id = $(this).data('fileid');
      var Fname = $(this).data('filename'); //think about it ;)
      var tabId = 'pspdfkit_' + id;
      var heightvph = resizeDiv2();
      $('.nav-tabs li:last-child').after('<li><a href="#pspdfkit_' + id + '" data-file_id="'+id+'"> <span> x </span> '
        +Fname+'</a></li>');
      $('.annotation-li').after('<input type="hidden" class="annotation_cls'+id+'" name="annotation-'+id+'" value="true">');
      $('.tab-content').append('<div class="tab-pane" id="' + tabId + '" style="width: 100%; height: '+heightvph+'px;"></div>');
     $('.nav-tabs li:nth-child(' + id + ') a').click();
    // $('.add-contact-'+id).removeAttr('onclick');
     getFileData(id);
    already_open.push(id);
  });*/

  function addContact(id,Fname) {
    
      if ($.inArray(id, already_open) !== -1) {
        toastr.warning('"'+Fname+'"'+' file is already opened in tab','Error',{"debug": false,});
        return false;
      }else{
        already_open.push(id);
      }
   // alert(previue_file);
   open_files.push(id);
  // alert('#pspdfkit_'+prev_file);
   PSPDFKit.unload('#pspdfkit_'+prev_file);
   //annotaed_files.push({'file_id':id,'status':0});
  // alert('s')
  prev_file=id;
 // alert(prev_file);
  $('.active_file_name').text(Fname);
  $('#add_new_file').modal('hide');
  console.log('annotaed_files');
   console.log(annotaed_files);
  // alert('aa')
    $.get(baseurl+'/clients/get_file_token/'+id,function(token){
		
     var resp=$.parseJSON(token);
	 console.log('resp');
	 console.log(resp);
      //alert(resp.layer)
	  $('#active_layer').val(resp.layer);
	//  var obj1={'psppdf_file_id':resp.file_id,'layer':resp.layer,'file_id':id};
	  open_file_info.push(resp);
	  //obj1={};
	  console.log('fgfd');
	  console.log(open_file_info); 
    });
    $('#first_file').text('x');
      $('.li_tab').removeClass('active');
      $('.tab-pane').removeClass('active');
      // var Fname = $(".add-contact-"+id).data('filename'); //think about it ;)
      var tabId = 'pspdfkit_' + id;
      var heightvph = resizeDiv2();
      $('.add_new_tab').before('<li data-file="'+Fname+'" class="active li_tab li_tab_'+id+'"><a href="#pspdfkit_' + id + '" data-file_id="'+id+'"> <span data-fileid="'+id+'"> x </span> '
        +Fname+'</a></li>');
      $('.annotation-li').after('<input type="hidden" class="annotation_cls'+id+'" name="annotation-'+id+'" value="true">');
      $('.tab-content').append('<div class="tab-pane active" id="' + tabId + '" style="width: 100%; height: '+heightvph+'px;"></div>');
     $('.nav-tabs li:nth-child(' + id + ') a').click();
    // $('.add-contact-'+id).removeAttr('onclick');
  
     /**activate active file id**/
          $('.active_file_id').val(id);

          $(".activefile").val(id);
          $("#file_id").val(id);
          
          $('.pagebutton').attr('onclick','gotoPage('+id+')');
          $('.closebtn').attr('onclick','closeKit('+id+')');
          $('.rotatebtn').attr('onclick','rotateKit('+id+')');
          $('.annotationbtn').attr('onclick','annotationKit('+id+')');

          $('.searchbtn').attr('onclick','searchKit('+id+')');
          $('.gridbtn').attr('onclick','gridKit('+id+')');
          /** For Bookmark **/
        doBlur();
          getBookmarkedPages(id);
          
          $('.createbookmark').attr('onclick','createBookmark('+id+')');
          
      
          setTimeout(function(){
            getCheckedTag(id);
            pdf_overlay(id);
            currentPage(id);  
          },500);
     /**activate active file id**/
     recentOpened(id);
     getFileData(id);
   /* closeKit_tab(previue_file,'tab_open',id,Fname);
        setTimeout(function(){
          previue_file=id;
        },10000);*/
  }

  
   
  $('.pagebutton').attr('onclick','gotoPage('+id+')');
  $('.createbookmark').attr('onclick','createBookmark('+id+')');
  $('.closebtn').attr('onclick','closeKit('+id+')');
  $('.rotatebtn').attr('onclick','rotateKit('+id+')');
  $('.annotationbtn').attr('onclick','annotationKit('+id+')');
  $('.searchbtn').attr('onclick','searchKit('+id+')');
  $('.gridbtn').attr('onclick','gridKit('+id+')');
var c1=0;
  function gridKit(id){
  
    let state = markers[id].viewState;

    markers[id].setViewState(function(viewState) {  
         if(c1==1)
         {
            c1=0;
            return viewState.set("sidebarMode", null);  
         }
         else 
         {
            c1=1;
            return viewState.set("sidebarMode", PSPDFKit.SidebarMode.THUMBNAILS);  
         }
        
        
    });
    // markers[id].setViewState(state.set("interactionMode",
                // PSPDFKit.InteractionMode.DOCUMENT_EDITOR));
  }

  function searchKit(id){
    let state = markers[id].viewState;
    markers[id].setViewState(state.set("interactionMode",
                PSPDFKit.InteractionMode.SEARCH));
  }

  function gotoPage(id){
      var name = $('#pageNo').val();
      var tot_pages = markers[id].totalPageCount;
    if(!name){
      alert('provide a valid page number');
      return false;
    }
    
    if(name > tot_pages){
      toastr.error('The file is expected to be in the range from 1 to '+tot_pages,'Error',{"debug": false,});
      return false;
    }
    // $.alert('Your name is ' + name);
    //markers[fid].setViewState(viewState.set("currentPageIndex", name - 1));
    let state = markers[id].viewState;
    let newState = state.set("currentPageIndex", name - 1);
      markers[id].setViewState(newState);

      if ($.inArray(Number(name), arr_pages) !== -1) {
    $("#i-bookmark").removeClass("fa-bookmark-o");
        $("#i-bookmark").addClass("fa-bookmark");
          }else {
            $("#i-bookmark").addClass("fa-bookmark-o");                        }
      }

  function currentPage(id){
	 
	// console.log(markers);
    const state = markers[id].viewState;
    const curr_page = state.currentPageIndex+1;

    if ($.inArray(Number(curr_page), arr_pages) !== -1) {
            $("#i-bookmark").removeClass("fa-bookmark-o");
            $("#i-bookmark").addClass("fa-bookmark");
          }else {
            // console.log('Not in array');
            $("#i-bookmark").addClass("fa-bookmark-o");
          }
    return curr_page; 
  }

  function createBookmark(id){
      markers[id].setViewState(function(viewState) {
        return viewState.set("sidebarMode", PSPDFKit.SidebarMode.BOOKMARKS);
    });
    }


  function annotationKit(id){
    const annot_val = $(".annotation_cls"+id).val();
    let state = markers[id].viewState;
    let newstate = state.set("showToolbar", annot_val);
    markers[id].setViewState(newstate);

    if(annot_val == 'true'){
      $(".annotation_cls"+id).val('true');
    }else{
      $(".annotation_cls"+id).val('false');
    }
  }
  
    function closeKit(id,resp1='',color=''){ 
	var annotation_action=0;
	console.log(annotaed_files);
	$.each(annotaed_files, function (key, val) {
        if(val>0)
			annotation_action=1;
    });
	if(annotation_action>0)
	{
                 $('div#page_overlay').removeClass('hide_div');
                $('#loader1').removeClass('hide_div');
                 alll_instance=[];
                 var main_count=1; 
                 markers[id].exportInstantJSON().then(instantJSON => {
				  instantJSON=instantJSON;
				  const viewState = markers[id].viewState;
				  const page_no = viewState.currentPageIndex + 1; // => 0
				  console.log('ins');
				  console.log(alll_instance);
                swal({
                  title: 'Are you sure to save this file?',
                  text: '',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Save it!',
                  cancelButtonText: 'No cancel!',
                  confirmButtonClass: 'confirm-class',
                  cancelButtonClass: 'cancel-class',
                  closeOnConfirm: true,
                  closeOnCancel: true
                },
                function(isConfirm) {
               if(isConfirm) { 
                    $.ajax({ 
                      type: "POST",
                      url: baseurl+"/clients/instant-json1",
                      data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:id,page_no:page_no,report_annotation:report_annotation,report_bookmark:report_bookmark,report_all:JSON.stringify(report_all),delete_id:delete_id,overlay_ids:overlay_ids,open_file_info:JSON.stringify(open_file_info)},
                      success: function(data)
                      { 
					  
					     $('div#page_overlay').addClass('hide_div');
					     $('#loader1').addClass('hide_div');
                        console.log(data);
                     
                        if(data == true){

                          recentAnnoted(id);
                          swal('Save','File Updated Successfully','success');
                           if(resp1!='tab_change')
                            {
                              setTimeout(function(){
                                window.location.href=baseurl+'/clients/manage_docs/{{Request::segment(4)}}/{{Session::get("job_id")}}';
                              },3000);
                            } 
                        }
                      }
                    });    
                   // window.location.href=document.referrer;
                  } else {   
                    $('div#page_overlay').addClass('hide_div');
                $('#loader1').addClass('hide_div');
                var annot_status = 0;
                console.log(annotation_ids_new)
                  if(annotation_ids){
                    for(d=0;d<annotation_ids_new.length;d++)
                    {
                       markers[annotation_ids_new[d].file].deleteAnnotation(annotation_ids_new[d].id);
                       console.log(annotation_ids_new[d].id);
                    }
                    }
                    setTimeout(function(){
                       window.location.href=baseurl+'/clients/manage_docs/{{Request::segment(4)}}/{{Session::get("job_id")}}';
                    },1000);
                  }
                });
       });
    }
	else 
	{
		 window.location.href=baseurl+'/clients/manage_docs/{{Request::segment(4)}}/{{Session::get("job_id")}}';
	}
  }
  
  
  function closeKit_single_file(id,resp1='',color=''){ 
 	 if(annotaed_files[id]>0)
	 {		 
		annotaed_files[id]=0;
	  newfilearr=[];
	  var new_opens = open_file_info;
	  console.log('new');
	  console.log(annotation_ids_new);
	  var new_ids=annotation_ids_new;
	  annotation_ids_new=[];
	  open_file_info=[];
	  for(jj=0;jj<new_ids.length;jj++)
	  {
		  if(new_ids[jj].file!=id)
		  {
			  annotation_ids_new.push(new_ids[jj]);
		  }
	  }
	  for(c=0;c<new_opens.length;c++)
	  {
		  
		  if(new_opens[c].file_id==id)
		  {
			  //console.log('in');
			  //console.log(open_file_info[c]);
			  newfilearr.push(new_opens[c]);
		  }
		  else 
		  {
			  open_file_info.push(new_opens[c]);
		  }
	  }
	             $('div#page_overlay').removeClass('hide_div');
                $('#loader1').removeClass('hide_div');
                 alll_instance=[];
                 var main_count=1; 
                 markers[id].exportInstantJSON().then(instantJSON => {
				  instantJSON=instantJSON;
				  const viewState = markers[id].viewState;
				  const page_no = viewState.currentPageIndex + 1; // => 0
				  console.log('ins');
				  console.log(alll_instance);
                swal({
                  title: 'Are you sure to save this file?',
                  text: '',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Save it!',
                  cancelButtonText: 'No cancel!',
                  confirmButtonClass: 'confirm-class',
                  cancelButtonClass: 'cancel-class',
                  closeOnConfirm: true,
                  closeOnCancel: true
                },
                function(isConfirm) {
               if(isConfirm) { 
                    $.ajax({  
                      type: "POST",
                      url: baseurl+"/clients/instant-json1",
                      data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:id,page_no:page_no,report_annotation:report_annotation,report_bookmark:report_bookmark,report_all:JSON.stringify(report_all),delete_id:delete_id,overlay_ids:overlay_ids,open_file_info:JSON.stringify(newfilearr)},
                      success: function(data)
                      { 
					  
					     $('div#page_overlay').addClass('hide_div');
					     $('#loader1').addClass('hide_div');
                        console.log(data);
                     
                        if(data == true){

                          recentAnnoted(id);
                          swal('Save','File Updated Successfully','success');
                           if(resp1!='tab_change')
                            {
                              /*setTimeout(function(){
                                window.location.href=baseurl+'/clients/manage_docs/{{Request::segment(4)}}/{{Session::get("job_id")}}';
                              },3000);*/
                            } 
                        }
                      }
                    });    
                   // window.location.href=document.referrer;
                  } else {   
                    $('div#page_overlay').addClass('hide_div');
                $('#loader1').addClass('hide_div');
                var annot_status = 0;
                console.log(annotation_ids_new)
                  if(annotation_ids){
                    for(d=0;d<annotation_ids_new.length;d++)
                    {
                       markers[annotation_ids_new[d].file].deleteAnnotation(annotation_ids_new[d].id);
                       console.log(annotation_ids_new[d].id);
                    }
                    }
                   /* setTimeout(function(){
                       window.location.href=baseurl+'/clients/manage_docs/{{Request::segment(4)}}/{{Session::get("job_id")}}';
                    },1000);*/
                  }
                });
       });
	  }
  }





   function closeKit_tab(id,resp1='',fid='',Fname=''){
     
    markers[id].exportInstantJSON().then(instantJSON => {
    instantJSON=instantJSON;
      const viewState = markers[id].viewState;
      const page_no = viewState.currentPageIndex + 1; // => 0
        
                swal({
                  title: 'Are you want to save reports of this file ?',
                  text: '',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Save it!',
                  cancelButtonText: 'No cancel!',
                  confirmButtonClass: 'confirm-class',
                  cancelButtonClass: 'cancel-class',
                  closeOnConfirm: true,
                  closeOnCancel: true
                },
                function(isConfirm) {
                  if(isConfirm) {
                    $.ajax({
                      type: "POST",
                      url: baseurl+"/clients/instant-json",
                      data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:id,page_no:page_no,report_annotation:report_annotation,report_bookmark:report_bookmark,report_all:JSON.stringify(report_all),delete_id:delete_id,overlay_ids:overlay_ids},
                      success: function(data)
                      { 
                        if(resp1=='tab_open')
                        { 
                          open_new_tab(fid,Fname);
                        }
                        if(data == true){

                          recentAnnoted(id);
                          swal('Save','Report Successfully Created','success');
                        }
                      }
                    });
                  }else{ 
                    if(resp1=='tab_open')
                    { 
                       open_new_tab(fid,Fname);
                    }
                  }
                });
    });
  }
  function open_new_tab(id,Fname)
  {
    $.get(baseurl+'/clients/get_file_token/'+id,function(token){
      $('#active_layer').val(token);
    });
    $('#first_file').text('x');
      $('.li_tab').removeClass('active');
      $('.tab-pane').removeClass('active');
      // var Fname = $(".add-contact-"+id).data('filename'); //think about it ;)
      var tabId = 'pspdfkit_' + id;
      var heightvph = resizeDiv2();
      $('.add_new_tab').before('<li data-file="'+Fname+'" class="active li_tab li_tab_'+id+'"><a href="#pspdfkit_' + id + '" data-file_id="'+id+'"> <span data-fileid="'+id+'"> x </span> '
        +Fname+'</a></li>');
      $('.annotation-li').after('<input type="hidden" class="annotation_cls'+id+'" name="annotation-'+id+'" value="true">');
      $('.tab-content').append('<div class="tab-pane active" id="' + tabId + '" style="width: 100%; height: '+heightvph+'px;"></div>');
     $('.nav-tabs li:nth-child(' + id + ') a').click();
    // $('.add-contact-'+id).removeAttr('onclick');
  
     /**activate active file id**/
          $('.active_file_id').val(id);

          $(".activefile").val(id);
          $("#file_id").val(id);
          
          $('.pagebutton').attr('onclick','gotoPage('+id+')');
          $('.closebtn').attr('onclick','closeKit('+id+')');
          $('.rotatebtn').attr('onclick','rotateKit('+id+')');
          $('.annotationbtn').attr('onclick','annotationKit('+id+')');

          $('.searchbtn').attr('onclick','searchKit('+id+')');
          $('.gridbtn').attr('onclick','gridKit('+id+')');
          /** For Bookmark **/
        doBlur();
          getBookmarkedPages(id);
          
          $('.createbookmark').attr('onclick','createBookmark('+id+')');
          
      
          setTimeout(function(){
            getCheckedTag(id);
            pdf_overlay(id);
            currentPage(id);  
          },500);
     /**activate active file id**/
     recentOpened(id);
     getFileData(id);
  }
  function deleteKit(id){
       markers[id].exportInstantJSON().then(function(instantJSON) {
        const viewState = markers[id].viewState;
        const page_no = viewState.currentPageIndex + 1; // => 0
         $.ajax({
            type: "POST",
            url: baseurl+"/clients/instant-json",
            data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:id,page_no:page_no,report_annotation:report_annotation,report_bookmark:report_bookmark,report_all:JSON.stringify(report_all),delete_id:delete_id},
            success: function(data)
            { 
             // if(data == true){
              delete_id = '';
               recentAnnoted(id);
               //window.location.href=document.referrer;
               toastr.success('Deleted Successfully','Success',{"debug": false,});
             // }
            }
          });
      });
    }

  function rotateKit(id){
    markers[id].setViewState(viewState => viewState.rotateRight());
  }

  getBookmarkedPages(id);
  function getBookmarkedPages(id){
    arr_pages = [];
    $.ajax({
      type: "GET",
      url: baseurl+"/clients/get-render-file/"+id,
      dataType: 'json',
      success: function(data)
        {  
          arr_pages = data.arr_book_pages;
          // console.log(arr_pages);
          if(data){
            
          }else{
            swal('Something went wrong','error');
          }
        }
    });    
  }

    $("#compare_btn").click(function(){
      load(setting,zNodes);
      $(".docs-example-modal-lg").modal('show');
    });

    $("#tag").click(function(){
      var active_file = $(".activefile").val();
      $.ajax({
            type: "GET",
            url: baseurl+"/clients/get-tags/"+active_file,
            success: function(data)
            {
              if(data != ''){
                $.confirm({
                    title: 'Tags  <a onclick="addTag('+active_file+')" class="fa fa-plus add-tag" data-fileid="'+active_file+'"></a>',
                    content: data,
                });
              }else{
                $.confirm({
                    title: 'Tags',
                    content: '',   
                });
              }
            }
        });
    });

   // setTimeout(function(){ pdf_overlay($(".activefile").val()); },20000)

    function pdf_overlay(fid){
      var fid= $(".activefile").val();
      $.post(baseurl+'/clients/get_document_file',{_token:"{{ csrf_token() }}",'file_id':fid },function(fb){
        var file_resp=$.parseJSON(fb);
        if(file_resp.status=='true')
        {
        var size=Object.keys(file_resp.data).length 
        const videoWidget=[]; 
        for(i=0;i<size;i++)
        {
        videoWidget[i] = document.createElement('div');
          if(file_resp.data[i].file_type=='jpg' || file_resp.data[i].file_type=='png' || file_resp.data[i].file_type=='svg')
          {           
             videoWidget[i].innerHTML ='<a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  style="background: red; border-radius: 50%; color: #fff; font-size: 30px; position: fixed; right: -10px; bottom: 50px;padding: 4px;text-decoration:none;" class="overlay_delete" href="javascript:;">X</a><img width="200px" height="100px" src="'+baseurl+'/'+file_resp.data[i].file_name+'">';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+file_resp.data[i].page_no,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 350, y: 600 })
            });
            markers[fid].setCustomOverlayItem(item);
          }
          else if(file_resp.data[i].file_type=='mp4' || file_resp.data[i].file_type=='avi' || file_resp.data[i].file_type=='webm' || file_resp.data[i].file_type=='avi')
          {
            videoWidget[i].innerHTML =
              '\
              <a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  style="background: red; border-radius: 50%; color: #fff; font-size: 30px; position: fixed; right: -10px; bottom: 50px;padding: 4px;text-decoration:none;" class="overlay_delete" href="javascript:;">X</a><video width="200" controls>\
              <source src="'+baseurl+'/'+file_resp.data[i].file_name+'" type="video/'+file_resp.data[i].file_type+'"> \
              Your browser does not support HTML5 video. \
              </video> \
            ';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+file_resp.data[i].page_no,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 350, y: 600 })
            });
            markers[fid].setCustomOverlayItem(item);
          }
          else if(file_resp.data[i].file_type=='mp3' || file_resp.data[i].file_type=='mpeg' || file_resp.data[i].file_type=='m4r' || file_resp.data[i].file_type=='ogg')
          {
            videoWidget[i].innerHTML =
              '<a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  style="background: red; border-radius: 50%; color: #fff; font-size: 30px; position: fixed; right: -10px; bottom: 50px;padding: 4px;text-decoration:none;" class="overlay_delete" href="javascript:;">X</a><audio style="width:200px" controls><source src="'+baseurl+'/'+file_resp.data[i].file_name+'" type="audio/'+file_resp.data[i].file_type+'"></audio>';
               var item = new PSPDFKit.CustomOverlayItem({
                id: "video-instructions_"+file_resp.data[i].page_no,
                node: videoWidget[i],
                pageIndex:parseInt(file_resp.data[i].page_no),
                position: new PSPDFKit.Geometry.Point({ x: 360, y: 730 })
              });
              markers[fid].setCustomOverlayItem(item);
          }
          else 
          {
            videoWidget[i].innerHTML ='<a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  style="background: red; border-radius: 50%; color: #fff; font-size: 30px; position: fixed; right: -10px; bottom: 50px;padding: 4px;text-decoration:none;" class="overlay_delete" href="javascript:;">X</a><a href="'+baseurl+'/'+file_resp.data[i].file_name+'" target="_blank"><img width="50px" height="50px" src="https://image.flaticon.com/icons/png/512/2323/premium/2323513.png"></a>';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+file_resp.data[i].page_no,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 530, y: 720 })
            });
            markers[fid].setCustomOverlayItem(item);
          }
          
        }
        }
      });
    }




    function pdf_overlay1(fid,file_resp){
    /*  $.post(baseurl+'/clients/get_document_file_one',{_token:"{{ csrf_token() }}",'file_id':fid },function(fb){
      var file_resp=$.parseJSON(fb);
      if(file_resp.status=='true')
      {*/
        console.log(file_resp.data);
        var size=Object.keys(file_resp.data).length 
        const videoWidget=[];
        for(i=0;i<size;i++)
        {
//         markers[fid].removeCustomOverlayItem('video-instructions_'+i)
        videoWidget[i] = document.createElement('div');
          if(file_resp.data[i].file_type=='jpg' || file_resp.data[i].file_type=='png' || file_resp.data[i].file_type=='svg')
          {          
             videoWidget[i].innerHTML ='<a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  style=" margin-left: 182px; background: red; padding-top: 8px; padding-left: 13px; padding-bottom: 8px; padding-right: 12px; position: absolute; top: -36px; border-radius: 50px; color: white; " class="overlay_delete" href="javascript:;">&#10005</a><img width="200px" height="100px" src="'+baseurl+'/'+file_resp.data[i].file_name+'">';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+file_resp.data[i].page_no,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 350, y: 600 })
            });
            markers[fid].setCustomOverlayItem(item);
          }
          else if(file_resp.data[i].file_type=='mp4' || file_resp.data[i].file_type=='avi' || file_resp.data[i].file_type=='webm' || file_resp.data[i].file_type=='avi')
          {
            videoWidget[i].innerHTML =
              '\
              <a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  style=" margin-left: 182px; background: red; padding-top: 8px; padding-left: 13px; padding-bottom: 8px; padding-right: 12px; position: absolute; top: -36px; border-radius: 50px; color: white; " class="overlay_delete" href="javascript:;">&#10005</a><video width="200" controls>\
              <source src="'+baseurl+'/'+file_resp.data[i].file_name+'" type="video/'+file_resp.data[i].file_type+'"> \
              Your browser does not support HTML5 video. \
              </video> \
            ';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+file_resp.data[i].page_no,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 350, y: 600 })
            });
            markers[fid].setCustomOverlayItem(item);
          }
          else if(file_resp.data[i].file_type=='mp3' || file_resp.data[i].file_type=='mpeg' || file_resp.data[i].file_type=='m4r' || file_resp.data[i].file_type=='ogg')
          {
            videoWidget[i].innerHTML =
              '<a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  style=" margin-left: 182px; background: red; padding-top: 8px; padding-left: 13px; padding-bottom: 8px; padding-right: 12px; position: absolute; top: -36px; border-radius: 50px; color: white; " class="overlay_delete" href="javascript:;">&#10005</a><audio style="width:200px" controls><source src="'+baseurl+'/'+file_resp.data[i].file_name+'" type="audio/'+file_resp.data[i].file_type+'"></audio>';
               var item = new PSPDFKit.CustomOverlayItem({
                id: "video-instructions_"+file_resp.data[i].page_no,
                node: videoWidget[i],
                pageIndex:parseInt(file_resp.data[i].page_no),
                position: new PSPDFKit.Geometry.Point({ x: 360, y: 730 })
              });
              markers[fid].setCustomOverlayItem(item);
          }
          else 
          {
            videoWidget[i].innerHTML ='<a onclick="window.top.delete_overlay('+file_resp.data[i].id+','+file_resp.data[i].page_no+','+fid+');"  style=" background: red; color: white; left: 28px; position: absolute; top: -21px; padding-top: 5px; padding-left: 10px; padding-right: 10px; padding-bottom: 6px; border-radius: 50px; " class="overlay_delete" href="javascript:;">&#10005</a><a href="'+baseurl+'/'+file_resp.data[i].file_name+'" target="_blank"><img width="50px" height="50px" src="https://image.flaticon.com/icons/png/512/2323/premium/2323513.png"></a>';
             var item = new PSPDFKit.CustomOverlayItem({
              id: "video-instructions_"+file_resp.data[i].page_no,
              node: videoWidget[i],
              pageIndex:parseInt(file_resp.data[i].page_no),
              position: new PSPDFKit.Geometry.Point({ x: 530, y: 720 })
            });
            markers[fid].setCustomOverlayItem(item);
          }
          
        }
     /*    }
      });*/
    }

    var a = '';
    function getTags(){ 
      var active_file = $(".activefile").val();
      $.ajax({
            type: "GET",
            url: baseurl+"/clients/get-tags/"+active_file,
            success: function(data)
            {
              if(data != ''){
                a = $.confirm({
                      title: 'Tags  <a onclick="addTag('+active_file+')" class="fa fa-plus add-tag" data-fileid="'+active_file+'"></a>',
                      content: data,
                      
                  });
              }else{
                a = $.confirm({
                    title: 'Tags',
                    content: '',
                    
                });
              }

            }
        });
    }

    function addTag(fileid){
      a.close();
      
      $.confirm({
        title: 'Add Tag',
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>Title</label>'+
        '<input type="text" placeholder="Your title" class="name form-control" required />' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Color</label><br>'+
        '<input type="color" id="bgcolor" value="#ffffff" onchange="pickColor(this)" onkeyup="pickColor(this)" />'+
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Submit',
                btnClass: 'btn-blue',
                action: function () {
                    var name = this.$content.find('.name').val();
                    if(!name){
                        $.alert('provide a valid title');
                        return false;
                    }
                    var colr_tag = $(".hdn_color_picker").val();
                    
                    $.ajax({
                        type: "POST",
                        url: baseurl+"/clients/add_tag",
                        data: {_token: "{{ csrf_token() }}",title:name,fileid:fileid,color_tag:colr_tag},
                        success: function(data)
                        {
                          getTags();
                        }
                    });
                }
            },
            cancel: function () {
                
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
    }

  function pickColor(t) {
    var pick_color = $("#bgcolor").val();
    $(".hdn_color_picker").val(pick_color);
  }

  function deleteTag(fileid){
    a.close();
    $.ajax({
            type: "GET",
            url: baseurl+"/clients/delete_tag/"+fileid,
            success: function(data)
            {
              getTags();
              getCheckedTag(fileid);
            }
        });
  }

  function tagRow(tagid){
	 a.close();
    var fileid = $(".activefile").val();
    $.ajax({
            type: "GET",
            url: baseurl+"/clients/change_tag/"+tagid+"/"+fileid,
            success: function(data)
            {
              var datares = JSON.parse(data);
              if(datares.success == 1){
				var active_file=$('.activefile').val();
				$("#tag-title").text(datares.tag.title);
                $('.tag-title-con').css('background-color', datares.tag.color_tag);
                $(".tag-title-con").show();
				$("#tag_id").val(datares.tag.id);
				$('#tag_file_id').val(active_file);
				$('#tag_remove_btn').removeClass('hide_div');
				
              }
            }
        });
  }

    getCheckedTag(id);

   function getCheckedTag(fileid){
    $.ajax({
            type: "GET",
            url: baseurl+"/clients/get_active_tag/"+fileid,
            success: function(data)
            {
              var datares = JSON.parse(data);
              if(datares.success == 1){
			    var active_file=$('.activefile').val();
                $("#tag-title").text(datares.tag.title);
				$("#tag_id").val(datares.tag.id);
				$('#tag_file_id').val(active_file);
                $('.tag-title-con').css('background-color', datares.tag.color_tag);
                $(".tag-title-con").show();
				$('#tag_remove_btn').removeClass('hide_div');
              }else{
                $(".tag-title-con").hide();
				$('#tag_remove_btn').addClass('hide_div');
              }
            }
        });
  }
  $(document).on('click','#tag_remove_btn',function(){
	  var file_id = $("#tag_file_id").val();
	  var tag_id = $("#tag_id").val();
	  $.get(baseurl+'/clients/removeFileTag/'+file_id+'/'+tag_id,function(fb){
		  $('#tag_remove_btn').addClass('hide_div');
		  $(".tag-title-con").hide();
	  })
  });
  $(".search_inp").keyup(function(e){
    if(e.keyCode == '13'){
      var keywords = $(this).val();
      var job = $('.selected_job').val();
      if(keywords){
        $.ajax({
            type: "GET",
            url: baseurl+"/clients/searchmyfiles/"+keywords,
            success: function(data)
            {
              if(data != ''){
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
        var zNodes = {!! json_encode($all_nods) !!};
        load(setting,zNodes);
      }
    }
  });

  $(".search_link").keyup(function(e){
    if(e.keyCode == '13'){
      var keywords = $(this).val();
      var job = $('.selected_job').val();
      if(keywords){
        $.ajax({
            type: "GET",
            url: baseurl+"/clients/searchmyfileshyperlink/"+keywords,
            success: function(data)
            {
              if(data != ''){
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
        var zNodes = {!! json_encode($all_nods) !!};
        load(setting,zNodes);
      }
    }
  });

  load_dd(setting,zNodes_dd);

  function load_dd(setting,zNodes_dd){
    return $.fn.zTree.init($("#treeDemo_dd"), setting, zNodes_dd);
  }

  function load(setting,zNodes){
    return $.fn.zTree.init($(".treeDemo"), setting, zNodes);
  }

  function nodefile(id){
    $(".tick").hide();
    $(".tickmark_"+id).show();
    $(".compare_2").val(id);
  }

  function shareAnnotation(rec_id){
    var id = $(".active_file_id").val();
    
    markers[id].exportInstantJSON().then(function(instantJSON) {
                
                const viewState = markers[id].viewState;
                const page_no = viewState.currentPageIndex + 1; // => 0
                
                swal({
                  title: 'Are you sure to share this file?',
                  text: '',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Share',
                  cancelButtonText: 'Cancel!',
                  confirmButtonClass: 'confirm-class',
                  cancelButtonClass: 'cancel-class',
                  closeOnConfirm: false,
                  closeOnCancel: true
                },
                function(isConfirm) {
                  if (isConfirm) {
                    $.ajax({
                      type: "POST",
                      url: baseurl+"/clients/share-annotation",
                      data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:id,client_id:rec_id},
                      success: function(data)
                      {  
                        if(data == true){
                          recentShared(id,rec_id)
                          swal('shared','File Shared','success');
                        }else{
                            toastr.error('Please add some annotation','Error',{"debug": false,});
                        }
                      }
                    });
                  }
                });
              });
  }

  recentOpened(id);
  function recentOpened(id){
        $.ajax({
          type: "GET",
          url: baseurl+"/clients/recent-opened/"+id,
          success: function(data)
            {  
            }
        });
  }

  function recentAnnoted(id){
        $.ajax({
          type: "GET",
          url: baseurl+"/clients/recent-annoted/"+id,
          success: function(data)
            {  
            }
        });
  }

  function recentShared(id,rec_id){
        $.ajax({
          type: "GET",
          url: baseurl+"/clients/recent-shared/"+id+"/"+rec_id,
          success: function(data)
            {  
            }
        });
  }

$(document).on('click', '.myFiles_dd .dropdown-menu', function (e) {
  e.stopPropagation();
});

resizeDiv();
  function resizeDiv() {
    vpw = $(window).width();
    vph = $(window).height()-140;
    $(".lib_con").css({'height': vph + 'px'});
  }

  function resizeDiv2() {
    vpw = $(window).width();
    vph = $(window).height()-140;
    // $(".lib_con").css({'height': vph + 'px'});
    return vph;
  }

var resp_comment = '';
  $(document).on('click','#save_selected_data',function(){
    text_selected = '';
    $(this).attr('disabled',true);
      var active_file = $(".activefile").val();
      var comment_id = $("#comment_id").val();
      if(!comment_id && squiggly_json==''){
        var createdAnnotation='';
        markers[active_file].createAnnotation(Squiggle1).then(function(createdAnnotation) {
        createdAnnotation=createdAnnotation;
        var serializedObject = PSPDFKit.Annotations.toSerializableObject(createdAnnotation);
        var json = JSON.stringify(serializedObject);
        resp_comment = json;
        });
      }
      if(squiggly_json){
           resp_comment = squiggly_json;
      }
      var file_id = active_file;
      const viewState = markers[file_id].viewState;
      const page_no = viewState.currentPageIndex + 1; 
      var comment=$('#comment_field').val();
      var text=$('#mark_text').text(); 
      if(comment!='')
      {
      markers[file_id].exportInstantJSON().then(function(instantJSON) {
      const viewState = markers[file_id].viewState;
      const page_no = viewState.currentPageIndex + 1; // => 0
        $.ajax({
            type: "POST", 
            url: baseurl+"/clients/instant-json",
            data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:file_id,page_no:page_no,report_annotation:'Comment',report_bookmark:report_bookmark,report_all:JSON.stringify(report_all)},
            success: function(data)
            { 
           if(data == true){
             /** Save Comment **/
              var lst_id=localStorage.getItem("last_annotation_id1");
            var current_instanceJSON=resp_comment;

            $.post(baseurl+'/clients/selected_text_information_save',{_token:"{{ csrf_token() }}",'comment':comment,'last_id':lst_id,'text':text,'current_instanceJSON':current_instanceJSON,'page_no':page_no,'file_id':file_id},function(fb){
              var resp=$.parseJSON(fb);
          
              if(resp.status=='true'){
                $('.new_comment').append('<div class="outgoing_comment">'+comment+'</div>');
                $('#comment_field').val('');
                $('#comment_id').val(resp.comment_id);
                $('#share_comment').removeClass('share_comment');
                $('#add_txt_mark').modal('hide');
                $("#save_selected_data").removeAttr('disabled');
                count=0;
              }
            });
                recentAnnoted(file_id);
             }
            }
        });
      });
        
     
     }else{
        swal('Please Enter Comment');
     }
  });

  $(document).on('click','#share_comment',function(){
    $('#all_user_list').toggleClass('hide_div');
  });
  
  $(document).on('click','.shareComment',function(){
    // var document_id=$('#document_id').val();
    var document_id = $(".activefile").val();
      const viewState = markers[document_id].viewState;
      const page_no = viewState.currentPageIndex + 1; 
    var client_id=$(this).attr('data-clientid');
    var text=$('#mark_text').text();
    var comment_id=$('#comment_id').val();
    $.post(baseurl+'/clients/shareComment',{_token:'{{ csrf_token() }}','client_id':client_id,'document_id':document_id,'text':text,'comment_id':comment_id,'page_no':page_no},function(fb){
    if(fb.match('1'))
    {
      swal('Comment Successfully Shared');
    //  $('#add_txt_mark').modal('hide');
    }
    })
  });
  $(document).on('click',function(){
    count=0;
  });

  $(document).on('submit','.database_operation_form_new',function(){
  var active_id=$(".activefile").val();
  const viewState = markers[active_id].viewState;
    const page_no = viewState.currentPageIndex + 1; 
    var url=$(this).attr('action');
    var data=new FormData($(this)[0]);
    var popup=$(this).attr('data-pop');
    $('.submitbtn').attr('disabled','true');
  $('.submitbtn').html('<i class="fa fa-spinner" aria-hidden="true"></i> Upload');

    $.ajax({
        type:'POST',
        url:url+'/'+page_no,
        data:data,
        contentType:false,
        processData:false,
        success:function(fb)
        {
            var resp=$.parseJSON(fb);
            if(resp.status=='true')
            {
              const viewState = markers[$(".activefile").val()].viewState;
              const page_no = viewState.currentPageIndex + 1;
              var overlayData={'id':resp.overlay_id,'page_no':page_no};
              overlay_ids.push(overlayData);
              console.log(overlay_ids)
        $('.submitbtn').removeAttr('disabled');
        $('.submitbtn').html('Upload');
                $('.database_operation_form_new').trigger('reset');
        pdf_overlay1($(".activefile").val(),resp);
                swal('Success',resp.message,'success');
                $('#file_upload').modal('hide');
            }
            else
            {
              swal('Warning',resp.message,'error');
            }
        }


    });
    return false;
  });

  $(".hyperlink_cancel").click(function(){
    $("#create_hyperlink_popup").modal('hide');
  })

  function createUrlLink(){
    var fileid = $('.hyperlink_hdn').val();
    var url = 'clients/file/render/'+fileid;
    is_external = 3;
    createHyperLinkAnnotation(url,fileid,1);
    $("#create_hyperlink_popup").modal('hide');
  }

  function add_to_link(file_id)
  {  
    $('.checklink').hide();
    $('.checklink_'+file_id).show();
    $('.hyperlink_hdn').val(file_id);
   }

   function createHyperLinkAnnotation(url,hfileid,hpage_no){
    text_selected = '';
    report_annotation = 'Hyperlink';
     var active_file = $(".activefile").val();
      var createdAnnotation='';
      markers[active_file].createAnnotation(annotation1).then(function(createdAnnotation) {
      createdAnnotation=createdAnnotation;
      
      report_all.push({"Data_id":createdAnnotation.id,"Data_page":createdAnnotation.pageIndex,"Data_type":"Hyperlink"});
      var serializedObject = PSPDFKit.Annotations.toSerializableObject(createdAnnotation);
      var json = JSON.stringify(serializedObject);
      var resp=$.parseJSON(json);
      arr_link_ids.push({'url':url,'id':resp.id});
      if(arr_link_ids.length > 0){
        markers[active_file].exportInstantJSON().then(function(instantJSON) {
        const viewState = markers[active_file].viewState;
        const page_no = viewState.currentPageIndex + 1; // => 0
              $.ajax({
                      type: "POST",
                      url: baseurl+"/clients/instant-json",
                      data: {_token: "{{ csrf_token() }}",instant_json: JSON.stringify(instantJSON),fileid:active_file,page_no:page_no,report_annotation:report_annotation,report_bookmark:report_bookmark,report_all:JSON.stringify(report_all),delete_id:delete_id},
                      success: function(data)
                      { 
                          recentAnnoted(id);
                          report_all = [];
                      }
                    });
        
        /*hyperlink*/
            $.each(arr_link_ids, function (index, val) {
             $.post(baseurl+'/clients/add_to_link_add',{_token:'{{ csrf_token() }}','url':val.url,'annotation_id':val.id,'file_id':hfileid,'page_no':hpage_no,is_external:is_external},function(data){
              var data = JSON.parse(data);
              if(data.success){
                arr_link_ids = [];
        console.log('Hyperlink save');
                toastr.success('Link Added','Success',{
                      "debug": false,
              });
              }
             });
            });
        });       
       }
      });       
   }

$(".add_new_tab").click(function(){ 
  //$('.myFiles_dd').find(".treeDemo_dd").slideToggle("fast");
  $('#add_new_file').modal('show');
});

$(document).on("click", function(event){
  var $trigger = $(".myFiles_dd");
  if($trigger !== event.target && !$trigger.has(event.target).length && $(event.toElement).attr('id')!='new_tab_btn'){
    $(".treeDemo_dd").slideUp("fast");
  }
});

$(document).on('click','.drop12',function(){
  $('.myFiles_dd').find(".treeDemo_dd").slideToggle("fast");
});
$(document).on('click','.overlay_delete',function(){
  alert('asdda')
});
function delete_overlay(id,i,fid)
{
  markers[fid].removeCustomOverlayItem('video-instructions_'+i)
  $.post(baseurl+'/clients/delete_overlay',{_token: "{{ csrf_token() }}",id:id},function(fb){
      swal('Overlay Successfully Deleted')
  })
}
$(document).on('click','.delete_issue_color',function(){
  var data=$(this).attr('data-id');
  

  $.get(baseurl+'/clients/delete_issue/'+data,function(fb){

  })
  $.get(baseurl+'/clients/get_all_issue',function(fb){
          resp=$.parseJSON(fb);
          var obect_length=Object.keys(resp).length;
          if(!$('table').hasClass('issue_table'))
          {
            $('.show_issue_table').html('<table class="table" id="issue_table"></table>');
          }
          $('#issue_table').html('<tr><th>Issue</th><th>Color</th><th>Action</th></tr>');
          for(i=0;i<obect_length;i++)
          {
              
              
              $('#issue_table').append('<tr><td><input type="radio" class="change_icolor" id="change_icolor_'+resp[i].id+'" data-color="'+resp[i].color+'" value="'+resp[i].name+'" onClick="change_issue_color('+resp[i].id+')"  ></td><td>'+resp[i].name+'</td><td><div style="background:'+resp[i].color+'">&nbsp;</div></td><td><a href="javascript:;" class="btn btn-info btn-sm delete_issue_color" data-id="'+resp[i].id+'">Delete</a></td></tr>');
          }
        })
});

</script>
@stop

@endsection