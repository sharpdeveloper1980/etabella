	<?php 
	    // echo "<pre>";
	    // print_r(json_decode($bookJson));
	    $arr_book_pages = [];
	    $bookmrks = json_decode($bookJson);
	    if($bookmrks){
	      foreach ($bookmrks as $key => $mrk) {
	        $arr_book_pages[] = $mrk->action->pageIndex;
	      }
	    }
  	?>
	<ul class="list-inline custom-toolbar">
      <li><a href="#" class="close_{{ $file->file_id }}" id="close">Close</a></li>
      <li><a href="#" class="rotate_{{ $file->file_id }}" id="rotate"><img src="{{asset('public/frontend/img/rotate.png')}}" height="23" width="23"></a></li>
      <li><a href="#" onclick="getTags()"><img src="{{asset('public/frontend/img/ColorPicker1.png')}}" height="23" width="23"></a></li>
       <li><a href="#" id="share_user"><i class="fa fa-users" aria-hidden="true"></i></a></li>
      <li style="width: 841px; text-align: center; color: #E54E09;"><b> {{$file->file_name}} </b></li>
      
      <li><a href="#" id="compare_btn"><i class="fa fa-files-o" aria-hidden="true"></i></a></li>
      
      <li><a href="#" class="page_{{ $file->file_id }}" id="page"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a></li>
      
      <li><a href="#" class="createbookmark_{{ $file->file_id }}" id="createbookmark"><i id="i-bookmark" class="fa @if(in_array(1, $arr_book_pages)) fa-bookmark @else fa-bookmark-o @endif i-bookmark" aria-hidden="true"></i></a></li>

      <li><a href="#" class="search_{{ $file->file_id }}" id="search"><i class="fa fa-search" aria-hidden="true"></i></a></li>
      
      <li><a href="#" onclick="annotationToggle(<?=$file->file_id?>)" class="annotation_{{ $file->file_id }}" id="annotation"><i class="fa fa-edit" aria-hidden="true"></i><input type="hidden" class="annotation_cls_{{ $file->file_id }}" name="annotation_{{ $file->file_id }}" value="true"></a></li>
      <li><a href="#" class="grid_{{ $file->file_id }}" id="grid"><i class="fa fa-th-large"></i></a></li> 
      @if(count($myFiles) > 0)
      <li class="dropdown pull-right">
        <a href="#" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">My File</a>
        <ul class="dropdown-menu">
          @foreach($myFiles as $mfkey => $myFile)
          <li>
            <a href="#" class="add-contact" onclick="addTab(<?=$myFile->file_id?>,'<?=$myFile->file_name?>')" data-fileid="{{$myFile->file_id}}" data-filename="{{$myFile->file_name}}"> 
              <img src="http://66.206.3.18/etabellaweb/public/images/file-pdf-icon_32.png">
              {{$myFile->file_name}} 
            </a>
          </li>
          @endforeach
        </ul>
      </li>
      @endif
    </ul>