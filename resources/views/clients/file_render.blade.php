@extends('layouts.client.app') 
@section('title',$file->file_name) 
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header">
				
			</div>
			<div class="card-body" >
				<div id="pspdfkit" style="width: 100%;"></div>
			</div>
		</div>
	</div>
</section>
 <div class="modal fade" id="add_txt_mark" role="dialog">
    <div class="modal-dialog">
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
          <div class="form-group">
            <label>Enter Comment</label>
            <textarea class="form-control" id="comment_field" placeholder="Enter Comment..."></textarea>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" id="save_selected_data">Save</button> <a id="share_comment" class="btn pull-right" href="javascript:;"></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="add_txt_mark_2" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add To Mark</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h4 style=" width: 100%;  word-break: break-word; " id="mark_text_2"></h4>
          <hr>
          <div class="all_comment_2">
           
          </div>
          <div class="new_comment_2"></div>
         
          <div class="form-group">
            <label>Enter Comment</label>
            <textarea class="form-control" id="comment_field_2" placeholder="Enter Comment..."></textarea>
            <input type="hidden" name="document_id1" id="document_id1" value="{!! Request::segment(3) !!}">
            <input type="hidden" name="client_id" id="client_id" value="{!! $notofocation_main->sender; !!}">
            <input type="hidden" name="d1" id="d1" value="{!! $notofocation_main->file_id; !!}">
          </div>
          <div class="form-group">
            <button class="btn btn-primary" id="save_selected_data_2">Save</button> <a id="share_comment" class="btn pull-right" href="javascript:;"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection