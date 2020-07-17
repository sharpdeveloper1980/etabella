 
<?php $__env->startSection('title',$file->file_name); ?> 
<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header" style="display:none">
				<ul class="list-inline custom-toolbar">
				  <li style="width:14%;float: left;"><a href="<?php echo e(url('clients/dashboard')); ?>" id="">Back</a></li>
				  <li style="width: 86%; text-align: center; color: #E54E09;"><b><center><?php echo e($file->file_name); ?></center></b></li>
				</ul>
			</div>
			<div class="card-body">
				<div id="pspdfkit" style="width: 100%;" class="pdf_container"></div>
			</div>
		</div>
	</div>
</section>
<div class="modal fade" id="add_txt_mark" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add To Mark</h4>
        </div>
        <div class="modal-body">
          <p id="mark_text"></p>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>