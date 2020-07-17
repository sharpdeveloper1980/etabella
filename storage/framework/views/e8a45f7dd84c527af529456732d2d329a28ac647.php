 
<?php $__env->startSection('title','Examination schedule'); ?> 
<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header">
				<div class="row second_header">
				  <div class="col-sm-12">
					  <ul class="dashboard_control float-right">
						<li>
						<div class="search_sorting" id="search_files" data-toggle="tooltip" title="Search">
						   <input type="text" name="search" class="form-control search_witness_and_file" placeholder="Search here">
						   <i class="fa fa-search" aria-hidden="true"></i>

						   <input type="hidden" name="job" class="selected_job" value="<?php echo e($whchjobs); ?>">
						</div>
						</li>
						<li>
						<a  href="#" data-toggle="tooltip" title="Tag Filter" class="tag-box" onclick="getTags()" style="float: right"><img src="<?php echo e(asset('public/frontend/img/ColorPicker1.png')); ?>" style=" margin-top: 3px; margin-right: 1px; " height="26" width="26"></a>	
						</li>
						<li>
							<button style=" border: 1px solid; " data-toggle="tooltip" title="Create/Modify"  onclick="window.location.href='<?php echo e(asset('clients/examination_schedule_inner/'.Session::get('job_id'))); ?>'" type="button" class=" action-button" >
								Create/Modify
							</button> 
						</li>
						<li>
							<button type="button" class="action-button" onclick="refreshPage(9)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh"><i data-toggle="tooltip" title="Refresh" class="fas fa-redo-alt" aria-hidden="true"></i>
							</button>
						</li>
					  </ul>
				  </div>
			   </div>
			</div>
			<div class="card-body">
				<div class="container">
					<div class="page-101">
						<?php if($all_witness): ?>
						<div id="accordion">
						  <?php $__currentLoopData = $all_witness; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						  <h3><?php echo e($wit['witness_name']); ?></h3>
						  <?php $files = (new \App\Helpers\Helper)->get_witness_files($wit['id']);  
						  ?>
						  <div class="<?php if(!$files): ?> custom_class <?php endif; ?>">
							
							<?php if($files): ?>
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>SNo.</th>
										<th>File Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								
								<?php $i=1; foreach($files as $f1) { 
								 $color = (new \App\Helpers\Helper)->get_file_tag(Session::get('client_id'),$f1['doc_id']);  
								$file_extension = strtolower(substr(strrchr($f1['file_upload_name'], "."), 1));
								?>
									<tr>
										<td><?php echo e($i); ?></td>
										<?php if($file_extension == 'pdf'): ?>
										<td><a href="<?php echo e(asset('clients/examination_schedule_render/'.$f1['doc_id'].'/'.$f1['witness_id'])); ?>"><div style="width:100%;color:cornflowerblue"><span style="background:<?php echo e($color); ?>;width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="<?php echo e(asset('public/images/file-pdf-icon_32.png')); ?>">  <?php echo e($f1['file_name']); ?></div></a></td>
										<td><a href="#" data-id="<?php echo e($f1['doc_id']); ?>" onclick="getTags1(<?php echo e($f1['doc_id']); ?>)" data-toggle="tooltip" data-placement="top" title="Tags"><img src="<?php echo e(asset('public/frontend/img/ColorPicker1.png')); ?>" height="23" width="23"></a></td>
										<?php elseif($file_extension == 'xlsx' || $file_extension == 'wpd' || $file_extension == 'tex' || $file_extension == 'xls' || $file_extension == 'xlsx' || $file_extension == 'docb' || $file_extension == 'dotm' || $file_extension == 'dotx' || $file_extension == 'docm' || $file_extension == 'csv' || $file_extension == 'pptx' || $file_extension == 'ppt' || $file_extension == 'txt' || $file_extension == 'doc' || $file_extension == 'docx'): ?>
										<?php  $url = asset('public/storage/files/'.$f1['file_upload_name']); ?>
										<td style=" cursor: pointer; " onclick="popupwindow('<?php echo e($url); ?>','doc')"><span style="background:<?php echo e($color); ?>;width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="<?php echo e(url('public/images/doc.png')); ?>"> <?php echo e($f1['file_name']); ?></td>	
										 <td><a data-id="<?php echo e($f1['doc_id']); ?>" href="#" onclick="getTags1(<?php echo e($f1['doc_id']); ?>)" data-toggle="tooltip" data-placement="top" title="Tags"><img src="<?php echo e(asset('public/frontend/img/ColorPicker1.png')); ?>" height="23" width="23"></a></td>
										<?php elseif($file_extension == 'jpg' || $file_extension == 'png' || $file_extension == 'jpeg'): ?>
										<?php  $url = asset('public/storage/files/'.$f1['file_upload_name']); ?>
										<td style=" cursor: pointer; " onclick="popupwindow('<?php echo e($url); ?>','doc')"><span style="background:<?php echo e($color); ?>;width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn1" src="<?php echo e(url('public/images/image.png')); ?>"><?php echo e($color); ?>  <?php echo e($f1['file_name']); ?> </td>	
										 <td><a data-id="<?php echo e($f1['doc_id']); ?>" href="#" onclick="getTags1(<?php echo e($f1['doc_id']); ?>)" data-toggle="tooltip" data-placement="top" title="Tags"><img src="<?php echo e(asset('public/frontend/img/ColorPicker1.png')); ?>" height="23" width="23"></a></td>
										<?php else: ?>
										<?php  $url = asset('public/storage/files/'.$f1['file_upload_name']); ?>
										<td style=" cursor: pointer; " onclick="popupwindow('<?php echo e($url); ?>','img')"><span style="background:<?php echo e($color); ?>;width: 46px;padding-left: 12px;border-radius: 50%;">&nbsp;</span><img class="file_iocn" src="<?php echo e(url('public/images/play.png')); ?>"> <?php echo e($color); ?> <?php echo e($f1['file_name']); ?></td>
										 <td><a data-id="<?php echo e($f1['doc_id']); ?>" href="#" onclick="getTags1(<?php echo e($f1['doc_id']); ?>)" data-toggle="tooltip" data-placement="top" title="Tags"><img src="<?php echo e(asset('public/frontend/img/ColorPicker1.png')); ?>" height="23" width="23"></a></td>
										<?php endif; ?>
									</tr>
								<?php $i++; } ?>
								</tbody>
							</table>
							<?php else: ?> 
								<h3 align="center">File Not Found</h3>
							<?php endif; ?>
						  </div> 
						  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
						<?php else: ?> 
						<div id="accordion">
						 <h3 align="center">Witness And Files Are Not found</h3>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<!-- /.card-footer-->
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<input type="hidden" class="activefile" />  
<input type="hidden" class="hdn_color_picker" value="#ffff" />
<!-- upload files modal -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>