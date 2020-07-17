 
<?php $__env->startSection('title','Report'); ?> 
<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header" style="display:none">
				
			</div>
			<div class="card-body" >
				<ul class="nav nav-tabs report_tab">
				  <li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#all">All</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#annotations">Annotations</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#hyperlinks">Hyperlinks</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#bookmarked">Bookmarked</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#issues">Issues</a>
				  </li>
				</ul><br>

				<!-- Tab panes -->
				<div class="tab-content">
				  <div class="tab-pane container active" id="all">
					<div class="loader" style="display: none;"></div>
						 <div class="row">
						   <div class="col-sm-4"></div>
						   <div class="col-sm-4">
							<input  type="text" name="daterange" class="daterange btn btn-info daterange_1 form-control" data-tablecont="table_container_1" data-tableid="sample_1" data-reporttype="all" />
						   </div> 
						 </div>
					 
						 <div class="container table_box" id="table_container_1" <?php if(count($reports)==0): ?> style="margin-top:50px;" <?php endif; ?>>
							<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_1" role="grid" aria-describedby="sample_1_info">
							  <thead>
								<tr role="row">
									<th>Filename</th>
									<th>Date Modified</th>
									<th>Reference</th>
									<th>Status</th>
								</tr>
							  </thead>
							  <tbody id="reportList">
								<?php if(count($reports) > 0): ?>
								<?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cldkey => $my_cloud): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								  <tr>
									<td>
									  <a href="<?php echo e(url('clients/file/render/'.$my_cloud->file_id.'/'.$my_cloud->page)); ?>"><?php echo e($my_cloud->file_name); ?></a>
									</td>
									<td>
									  <?php echo e(date('M d, Y H:i:s', $my_cloud->created_at)); ?>

									</td>
									<td>
									  <a class="btn btn-default" href="<?php echo e(url('clients/file/render/'.$my_cloud->file_id.'/'.$my_cloud->page)); ?>">Page <?php echo e($my_cloud->page); ?></a>
									</td>
									<td>
									  <?php echo e($my_cloud->type); ?>

									</td>
								  </tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php else: ?>
								<tr>
								  <td colspan="3" style="text-align: center;">No data found yet</td>
								</tr>
								<?php endif; ?>
							  </tbody>
							</table>
						  </div>
				  </div>
				  <div class="tab-pane container fade" id="annotations">
					<div class="loader" style="display: none;"></div>    
					 <div class="row">
					   <div class="col-sm-4"></div>
					   <div class="col-sm-4">
						<input type="text" name="daterange" class="btn btn-info daterange daterange_2 form-control" data-tablecont="table_container_2" data-tableid="sample_2" data-reporttype="Annotation" />
					   </div>
					 </div>
				
					 <div class="container table_box" id="table_container_2" <?php if(count($annotations)==0): ?> style="margin-top:50px;" <?php endif; ?>>
						<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_2" role="grid" aria-describedby="sample_2_info">
						  <thead>
							<tr role="row">
								<th>Filename</th>
								<th>Date</th>
								<th>Page</th>
								<th>Type</th>
							</tr>
						  </thead>
						  <tbody id="reportList">
							<?php if(count($annotations) > 0): ?>
							<?php $__currentLoopData = $annotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $akey => $annotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							  <tr>
								<td>
								  <a href="<?php echo e(url('clients/file/render/'.$annotation->file_id.'/'.$annotation->page)); ?>"><?php echo e($annotation->file_name); ?></a>
								</td>
								<td>
								  <?php echo e(date('M d, Y H:i:s', $annotation->created_at)); ?>

								</td>
								<td>
								  <a class="btn btn-default" href="<?php echo e(url('clients/file/render/'.$annotation->file_id.'/'.$annotation->page)); ?>">Page <?php echo e($annotation->page); ?></a>
								</td>
								<td>
								  <?php echo e($annotation->type); ?>

								</td>
							  </tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
							<tr>
							  <td colspan="3" style="text-align: center;">No data found yet</td>
							</tr>
							<?php endif; ?>
						  </tbody>
						</table>
					  </div>
				  </div>
				  <div class="tab-pane container fade" id="hyperlinks">
					<div class="loader" style="display: none;"></div>
					 <div class="row">
					  <div class="col-sm-4"></div>
					   <div class="col-sm-4">
						<input type="text" name="daterange" class="btn btn-info daterange daterange_3 form-control" data-tablecont="table_container_3" data-tableid="sample_3" data-reporttype="Hyperlink" />
					   </div>
					 </div>
				
					 <div class="container table_box" id="table_container_3" <?php if(count($hyperlinks)==0): ?> style="margin-top:50px;" <?php endif; ?>>
						<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_3" role="grid" aria-describedby="sample_3_info">
						  <thead>
							<tr role="row">
								<th>Filename</th>
								<th>Date</th>
								<th>Page</th>
								<th>Type</th>
							</tr>
						  </thead>
						  <tbody id="reportList">
							<?php if(count($hyperlinks) > 0): ?>
							<?php $__currentLoopData = $hyperlinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hkey => $hyperlink): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							  <tr>
								<td>
								  <a href="<?php echo e(url('clients/file/render/'.$hyperlink->file_id.'/'.$hyperlink->page)); ?>"><?php echo e($hyperlink->file_name); ?></a>
								</td>
								<td>
								  <?php echo e(date('M d, Y H:i:s', $hyperlink->created_at)); ?>

								</td>
								<td>
								  <a class="btn btn-default" href="<?php echo e(url('clients/file/render/'.$hyperlink->file_id.'/'.$hyperlink->page)); ?>">Page <?php echo e($hyperlink->page); ?></a>
								</td>
								<td>
								  <?php echo e($hyperlink->type); ?>

								</td>
							  </tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
							<tr>
							  <td colspan="3" style="text-align: center;">No data found yet</td>
							</tr>
							<?php endif; ?>
						  </tbody>
						</table>
					  </div>
				  </div>
				  
				  <div class="tab-pane container fade" id="bookmarked">
						<div class="loader" style="display: none;"></div>
							 <div class="row">
							   <div class="col-sm-4"></div>
						       <div class="col-sm-4">
								<input type="text" name="daterange" class="btn btn-info daterange daterange_4 form-control" data-tablecont="table_container_4" data-tableid="sample_4" data-reporttype="Bookmarked" />
							   </div>
							 </div>
						
							 <div class="container table_box" id="table_container_4" <?php if(count($bookmarks)==0): ?> style="margin-top:50px;" <?php endif; ?>>
								<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_4" role="grid" aria-describedby="sample_4_info">
								  <thead>
									<tr role="row">
										<th>Filename</th>
										<th>Date</th>
										<th>Page</th>
										<th>Type</th>
									</tr>
								  </thead>
								  <tbody id="reportList">
									<?php if(count($bookmarks) > 0): ?>
									<?php $__currentLoopData = $bookmarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bkey => $bookmark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									  <tr>
										<td>
										  <a href="<?php echo e(url('clients/file/render/'.$bookmark->file_id.'/'.$bookmark->page)); ?>"><?php echo e($bookmark->file_name); ?></a>
										</td>
										<td>
										  <?php echo e(date('M d, Y H:i:s', $bookmark->created_at)); ?>

										</td>
										<td>
										  <a class="btn btn-default" href="<?php echo e(url('clients/file/render/'.$bookmark->file_id.'/'.$bookmark->page)); ?>">Page <?php echo e($bookmark->page); ?></a>
										</td>
										<td>
										  <?php echo e($bookmark->type); ?>

										</td>
									  </tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php else: ?>
									<tr>
									  <td colspan="4" style="text-align: center;">No data found yet</td>
									</tr>
									<?php endif; ?>
								  </tbody>
								</table>
							  </div>
				  </div>
				  <div class="tab-pane container fade" id="issues">
					<div class="loader" style="display: none;"></div>  
						 <div class="row">
						   <div class="col-sm-4"></div>
						   <div class="col-sm-4">
							<input type="text" name="daterange" class="btn btn-info daterange daterange_5 form-control" data-tablecont="table_container_5" data-tableid="sample_5" data-reporttype="Issues" style=" margin-left: 15px; " />
						   </div>
						 </div>
				   
						 <div class="container table_box" id="table_container_5" <?php if(count($issues)==0): ?> style="margin-top:50px;" <?php endif; ?>>
							<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_5" role="grid" aria-describedby="sample_5_info">
							  <thead>
								<tr role="row">
									<th>Filename</th>
									<th>Date</th>
									<th>Page</th>
									<th>Type</th>
								</tr>
							  </thead>
							  <tbody id="reportList">
								<?php if(count($issues) > 0): ?>
								<?php $__currentLoopData = $issues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ikey => $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								  <tr>
									<td>
									  <a href="<?php echo e(url('clients/file/render/'.$issue->file_id.'/'.$issue->page)); ?>"><?php echo e($issue->file_name); ?></a>
									</td>
									<td>
									  <?php echo e(date('M d, Y H:i:s', $issue->created_at)); ?>

									</td>
									<td>
									  <a class="btn btn-default" href="<?php echo e(url('clients/file/render/'.$issue->file_id.'/'.$issue->page)); ?>">Page <?php echo e($issue->page); ?></a>
									</td>
									<td>
									  <?php echo e($issue->type); ?>

									</td>
								  </tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php else: ?>
								<tr>
								  <td colspan="4" style="text-align: center;">No data found yet</td>
								</tr>
								<?php endif; ?>
							  </tbody>
							</table>
						  </div>
				  </div>
				</div>				
			</div>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>