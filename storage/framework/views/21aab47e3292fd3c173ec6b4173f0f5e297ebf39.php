 
<?php $__env->startSection('title','My Files'); ?> 
<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header">
				<ul class="dashboard_control float-right" style="margin-left: -15px;">
					<li>
						<div class="search_sorting" id="search_files" data-toggle="tooltip" title="Search">
							<input type="text" name="search" class="form-control search_inp" placeholder="Search here"> <i class="fa fa-search" aria-hidden="true"></i>
							<input type="hidden" name="job" class="selected_job" value="<?php echo e($whchjobs); ?>">
						</div>
					</li>
					<li>
						<a href="#" data-toggle="tooltip" title="Tag Filter" class="tag-box" onclick="getTags()" style="float: right;margin-top: 3px;margin-right: 2px;"><img src="<?php echo e(asset('public/frontend/img/ColorPicker1.png')); ?>" height="26" width="26"></a>
					</li>
					<li>
						<div class="dropdown">
							<button type="button" class="btn dropdown-toggle action-button sort_dd_outer" data-toggle="dropdown"> <i class="fas fa-sort-alpha-up-alt" aria-hidden="true" data-toggle="tooltip" title="Sort By"></i>
							</button>
							<div class="dropdown-menu sort_dd_inner">	<a href="javascript:void(0)" class="a1 sorting dropdown-item" onclick="sorting('<?php echo e(Request::segment(2)); ?>','<?php echo e(Request::segment(3)); ?>','<?php echo e($whchjobs); ?>','file_name','<?php echo e(Session::get('file_name')); ?>')">
                      <?php if(Session::get('file_name') == 'asc'): ?>
                        <span class="file_name"><i class="fa fa-chevron-down"></i></span>
                      <?php else: ?>
                        <span class="file_name"><i class="fa fa-chevron-up"></i></span>
                      <?php endif; ?>
                      Name
                    </a>
								<a href="javascript:void(0)" class="a1 sorting dropdown-item" onclick="sorting('<?php echo e(Request::segment(2)); ?>','<?php echo e(Request::segment(3)); ?>','<?php echo e($whchjobs); ?>','file_date_modified','<?php echo e(Session::get('file_date_modified')); ?>')">

                      <?php if(Session::get('file_date_modified') == 'asc'): ?>
                        <span class="file_date_modified"><i class="fa fa-chevron-down"></i></span>
                      <?php else: ?>
                        <span class="file_date_modified"><i class="fa fa-chevron-up"></i></span>
                      <?php endif; ?>
                      Date
                    </a>  <a href="javascript:void(0)" class="a1 sorting dropdown-item" onclick="sorting('<?php echo e(Request::segment(2)); ?>','<?php echo e(Request::segment(3)); ?>','<?php echo e($whchjobs); ?>','file_size','<?php echo e(Session::get('file_size')); ?>')">

                      <?php if(Session::get('file_size') == 'asc'): ?>
                        <span class="file_size"><i class="fa fa-chevron-down"></i></span>
                      <?php else: ?>
                        <span class="file_size"><i class="fa fa-chevron-up"></i></span>
                      <?php endif; ?>
                      <!-- <i class="fa fa-check" aria-hidden="true"></i> --> 
                      Size
                    </a>
								<a href="javascript:void(0)" class="a1 sorting dropdown-item" onclick="sorting('<?php echo e(Request::segment(2)); ?>','<?php echo e(Request::segment(3)); ?>','<?php echo e($whchjobs); ?>','file_type','<?php echo e(Session::get('file_type')); ?>')">

                      <?php if(Session::get('file_type') == 'asc'): ?>
                        <span class="file_type"><i class="fa fa-chevron-down"></i></span>
                      <?php else: ?>
                        <span class="file_type"><i class="fa fa-chevron-up"></i></span>
                      <?php endif; ?>
                      Type
                    </a>
							</div>
						</div>
					</li>
					<li>
						<button type="button" class="action-button" data-toggle="tooltip" data-placement="top" title="Select All">
							<label class="checkbox_selectall" onclick="checkmyfile('all')">
								<input type="checkbox" class="checkbox_selectall_chck">
							</label>
						</button>
					</li>
					<li>    
					  <form action="<?php echo e(route('downloadFile')); ?>" method="post" style="float:right">
					  <?php echo csrf_field(); ?>
						<input type="hidden" id="file_id" name="file_id" />
						<button type="button" id="download_btn" data-toggle="tooltip" title="Delete"  class="action-button"><i class="fa fa-trash" aria-hidden="true"></i>
						</button>
					  </form>
					</li>
					<li>
						<button type="button" class="action-button" onclick="refreshPage(<?php echo e($whchjobs); ?>)" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fas fa-redo-alt" aria-hidden="true"></i>
						</button>
					</li>
					<li>
						<button type="button" id="exportzip_btn" value="<?php echo e($whchjobs); ?>" class="action-button" data-toggle="tooltip" data-placement="top" title="Export zip"><i class="fas fa-file-archive" aria-hidden="true"></i></button>
						<a href="<?php echo e(url('public/export.zip')); ?>" download id="download_zip" hidden>Download zip</a>
					</li>
					<li>
						<button  data-toggle="tooltip" data-placement="top" title="Print files"  type="button" class="action-button add-file" id="print_btn" onclick="printFiles()" style="float:right"  ><i style="padding:3px;" class="fa fa-print" aria-hidden="true"></i>
						</button>
					</li>
				</ul>
			</div>
			<div class="card-body">
				<ul id="treeDemo" class="ztree">
				</ul>
			</div>
		</div>
	</div>
</section>
<!-- upload files modal -->
<div id="file_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form id="add_file" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="file_parent_id" value="0">
        <!-- <input type="hidden" name="file_parent_id" value="<?php echo e(Request::segment(2) == 'dashboard' ? 0 : Request::segment(3)); ?>"> -->
<!--        <input type="hidden" name="jobs[]" value="<?php echo e($whchjobs); ?>"> -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-upload"></i> Upload Files</h4>
        </div>
        <div class="modal-body">
          <div style="margin-top:-10px;padding-bottom:10px">
            <span class="grey"><i class="fa fa-home"></i></span>
            <?php echo e(implode(' / ',$arr_bread)); ?>

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
                  <?php if($jobs): ?>
                    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobkey => $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <option value="<?php echo e($job->job_id); ?>"><?php echo e($job->job_name); ?></option> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
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
            <h4><img src="<?php echo e(url('public/images/move-icon.png')); ?>" height="30" width="30"> Move file</h4> 
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
      	<?php echo csrf_field(); ?>
        <input type="hidden" name="copied_file" class="copied_file">
      	<input type="hidden" name="sufix_name" class="sufix_name">
        <input type="hidden" name="vch_tab" class="vch_tab" value="1">
        <input type="hidden" name="jobs" value="<?php echo e($whchjobs); ?>">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-copy"></i> Copy File</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
          <div class="col-md-12 text-center ">
          <div id="exTab1" class="">
				<ul class="nav nav-tabs report_tab"> 
				  <li class="nav-item">
					<a class="nav-link active tb" data-tb_type="1" data-toggle="tab" href="#home">Select Folder</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link tb" data-tb_type="2" data-toggle="tab" href="#menu1">New Folder</a>
				  </li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
				  <div class="tab-pane container active" id="home">
				  <br>
						<div class="form-group">
                			<label for="file_name">Folder Name</label><br>
							<!-- <input type="text" name="folder_name" class="form-control" autocomplete="off"> -->
              				<select class="form-control js-example-basic-single folder_sel" name="select_folder">
                            <option value="">Select Folder</option>
                				<?php if(count($my_dirs) > 0): ?>
                					<?php $__currentLoopData = $my_dirs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dkey => $dir): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    									<option class="list list-<?php echo e($dir->file_id); ?>" value="<?php echo e($dir->file_id); ?>"><?php echo e($dir->file_name); ?></option>
                    				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                				<?php endif; ?>
  							</select>
              			</div>
				  </div>
				  <div class="tab-pane container fade" id="menu1">
					  <br>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>