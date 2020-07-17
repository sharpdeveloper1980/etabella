@extends('layouts.client.app') 
@section('title','My Files') 
@section('content')
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
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header" style="display:none">
				
			</div>
			<div class="card-body" >
				<div class="row custom-toolbar-parent">
					<input type="hidden" name="active_file_id" class="active_file_id" value="{{$id}}">
					<input type="hidden" name="hyperlink_hdn" class="hyperlink_hdn">
					<div class="row" style=" width: 100%;">
					<div class="col-sm-3 text-center">
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
						</ul>
					</div>
					<div class="col-sm-6">
					<ul class="list-inline custom-toolbar">
					  <li class="custom-single" style="width: 100%; text-align: center; color: #E54E09;"><b><span class="active_file_name">{{$file->file_name}}</span></b></li>
					</ul>
					</div>
					<div class="col-sm-3 text-center">
					<ul class="list-inline custom-toolbar">
					  <li><a href="#" id="compare_btn" data-toggle="tooltip" data-placement="bottom" title="Compare files"><i class="far fa-copy"></i></a></li>
					  
					  <li><a href="#" id="page1" data-toggle="tooltip" data-placement="bottom" title="Goto page"><i class="fas fa-arrow-circle-right"></i></a></li>
					   
					  <li><a href="#" class="createbookmark" data-toggle="tooltip" data-placement="bottom" title="Bookmark"><i id="i-bookmark" class="fas fa-bookmark" aria-hidden="true"></i></a></li>
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
					</div>
				</div>
				  <div class="row tag-line tag-title-con" style="width:91%;float:left;display:none;height: 1.5em;border: 1px solid #ccc;background-color: aqua;text-align: center;">
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
							<b data-layer="{{ $download_info[0]['layer'] }}" class="tab_operation">{{ $file->file_name }}</b></a>
						</li>
						 <li id="add_new_tab" class="dropdown add_new_tab" data-toggle="tooltip" data-placement="top" title="Open New File"><a id="new_tab_btn"  style="width:35px" class="">+</a>
						</li>
					</ul>
				  </div>
					<div class="tab-content">
					  <div class="tab-pane lib_con active" id="pspdfkit_{{$id}}" style="width: 100%; height: 480px !important;"></div>
					</div>
				  </div>
			</div>
		</div>
	</div>
</section>
 <div class="modal fade docs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="form-group search_sorting" id="search_files" style=" width: 100%; margin-right: 0px; margin-top: 5px; ">
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
          <h4 class="modal-title">Colour picker</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
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
          <h4 class="modal-title">Go to Page #</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
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
          <h4 class="modal-title">Add To Mark</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
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
        <h4 class="modal-title">My Files</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <ul id="treeDemo_dd" class="ztree" >
          
        </ul>
      </div>
    </div>

  </div>
</div>
  <!-- deependra -->
  <div class="modal fade" id="create_issue" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
		  <h4 class="modal-title">Issue</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
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
          <h4 class="modal-title">Create Issue </h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
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
          <h4 class="modal-title">Create Hyperlink </h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
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
        <div class="row" style="width:100%">
			<div class="col-sm-12">
				<input type="checkbox" value="1" id="user_current_file" />
				<label for="user_current_file">Use Current File</label>
			</div>
			<div class="col-sm-12">
				<div class="form-group search_sorting" id="search_files" style=" width: 100%; margin-right: 0px; margin-top: 5px; ">
					<div id="search_files1">
					  <input type="text" name="search" class="form-control search_link" placeholder="Search here">
					   <i class="fa fa-search" aria-hidden="true"></i>
					</div>
				</div>
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
@endsection