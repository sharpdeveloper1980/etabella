 
<?php $__env->startSection('title','Compare File'); ?> 
<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
			 <?php 
				$arr_book_pages_1 = [];
				if($bookJson_1){
				  $bookmrks_1 = json_decode($bookJson_1);
				  if($bookmrks_1){
					foreach ($bookmrks_1 as $key_1 => $mrk_1) {
					  $arr_book_pages_1[] = $mrk_1->action->pageIndex;
					}
				  }
				}
			  ?>
				<div class="card">
					<div class="card-header custom_cart_header">
						<div class="row custom-toolbar-parent">
						  <ul class="list-inline custom-toolbar">
							<li><a href="#" onclick="CloseBoth()">Close</a></li>

							<!-- <li><a href="#" onclick="getTags(1)"><img src="<?php echo e(asset('public/frontend/img/ColorPicker1.png')); ?>" height="23" width="23"></a></li> -->

							<input type="hidden" name="activefile_1" class="activefile_1" value="<?php echo e($first_id); ?>">

							<li class="test-0" style="width: 51%; text-align: center; color: #E54E09;"><b> <?php if(strlen($file_1->file_name) > 44): ?> <?php echo e(substr($file_1->file_name, 0, 40) . '...'); ?> <?php else: ?> <?php echo e($file_1->file_name); ?> <?php endif; ?> </b></li>

							<li class="test_4"><a href="#" id="page_1"><i class="fas fa-arrow-circle-right" aria-hidden="true"></i></a></li>

							<li class="test_3"><a href="#" class="createbookmark_1"><i id="i-bookmark_1" class="fas fa-bookmark i-bookmark_1" aria-hidden="true"></i></a></li>

							<li class="test_2"><a href="#" id="search_1"><i class="fa fa-search" aria-hidden="true"></i></a></li>
							
							<li class="test_1"><a href="#" id="annotation_1"><i class="fa fa-edit" aria-hidden="true"></i><input type="hidden" class="annotation_cls_1" name="annotation" value="true"></a></li>
							
							<!-- Compare File -->
							<li ><a href="#" id="compare_btn_for_first" data-toggle="tooltip" data-placement="top" title="Compare files"><i class="far fa-copy" aria-hidden="true"></i></a></li>
							<!-- Compare File -->
						</ul>
						</div>
					</div>
					<div class="card-body" >
						 <div class="row tag-line-1 tag-title-con-1" style="display:none;height: 1.5em;border: 1px solid #ccc;background-color: aqua;text-align: center;">
						  <small id="tag-title-1"></small>
						</div>

						<div id="pspdfkit_1<?php echo e($first_id); ?>" style="width: 100%; height: 100vh;"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
			<?php 
			$arr_book_pages_2 = [];
			if($bookJson_2 ){  
			  $bookmrks_2 = json_decode($bookJson_2);
			  if($bookmrks_2){
				foreach ($bookmrks_2 as $key_2 => $mrk_2) {
				  $arr_book_pages_2[] = $mrk_2->action->pageIndex;
				}
			  }
			}
		  ?>
				<div class="card">
					<div class="card-header custom_cart_header">
						<div class="row custom-toolbar-parent">
						  <ul class="list-inline custom-toolbar">
							<!-- <li><a href="#" onclick="getTags(2)"><img src="<?php echo e(asset('public/frontend/img/ColorPicker1.png')); ?>" height="23" width="23"></a></li> -->

							<input type="hidden" name="activefile_2" class="activefile_2" value="<?php echo e($second_id); ?>">

							<li class="test-0" style="width: 63%; text-align: center; color: #E54E09;"><b style="margin-left: 100px;"> <?php if(strlen($file_2->file_name) > 44): ?> <?php echo e(substr($file_2->file_name, 0, 40) . '...'); ?> <?php else: ?> <?php echo e($file_2->file_name); ?> <?php endif; ?> </b></li>

							<li class="test_4"><a href="#" id="page_2"><i class="fas fa-arrow-circle-right" aria-hidden="true"></i></a></li>

							<li class="test_3"><a href="#" class="createbookmark_2"><i id="i-bookmark_2" class="fas fa-bookmark i-bookmark_2" aria-hidden="true"></i></a></li>

							<li class="test_2"><a href="#" id="search_2"><i class="fa fa-search" aria-hidden="true"></i></a></li>
							
							<li class="test_1"><a href="#" id="annotation_2"><i class="fa fa-edit" aria-hidden="true"></i><input type="hidden" class="annotation_cls_2" name="annotation" value="true"></a></li>
							
							<!-- Compare File -->
							<li><a href="#" id="compare_btn" data-toggle="tooltip" data-placement="top" title="Compare files"><i class="far fa-copy" aria-hidden="true"></i></a></li>
							<!-- Compare File -->
						  </ul>
						</div>
					</div>
					<div class="card-body" >
						<div class="row tag-line-2 tag-title-con-2" style="display:none;height: 1.5em;border: 1px solid #ccc;background-color: aqua;text-align: center;">
						  <small id="tag-title-2"></small>
						</div>

						<div id="pspdfkit_2<?php echo e($second_id); ?>" style="width: 100%; height: 100vh;"></div>
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
          <div class="form-groupsearch_sorting" id="search_files">
            <input type="text" name="search" class="form-control search_inp" placeholder="Search here">
               <i class="fa fa-search" aria-hidden="true"></i>
          </div>
        </div>
        <form method="POST" action="<?php echo e(route('compareFiles')); ?>">
          <?php echo csrf_field(); ?>
          <div class="modal-body">
            <input type="hidden" name="compare_first_file" class="activefile  compare_1" value="<?php echo e($first_id); ?>">
            <input type="hidden" name="compare_second_file" class="compare_2" value="<?php echo e($second_id); ?>">
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

 <div class="modal fade docs-example-modal-lg-first" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="form-groupsearch_sorting" id="search_files">
            <input type="text" name="search" class="form-control search_inp" placeholder="Search here">
               <i class="fa fa-search" aria-hidden="true"></i>
          </div>
        </div>
        <form method="POST" action="<?php echo e(route('compareFilesFirst')); ?>">
          <?php echo csrf_field(); ?>
          <div class="modal-body">
            <input type="hidden" name="compare_first_file" class="activefile  compare_1" value="<?php echo e($first_id); ?>">
            <input type="hidden" name="compare_second_file" class="compare_2" value="<?php echo e($second_id); ?>">
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
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.client.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>