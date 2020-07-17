 
<?php $__env->startSection('title','Activity Log'); ?> 
<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header">
				<div class="row text-center">
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						<input type="text" name="daterange" class="pull-right btn btn-info daterange form-control" />
					 </div>
				</div>
			</div>
			<div class="card-body" >
				<div class="panel-body table_box" id="dvData">
					<table class="table table-hover" id="sample_1">
					  <thead>
						 <th><a>No.</a>
						 </th>
						 <th><a>Description</a></th>
						 <th><a>Action</a></th>
						 <th><a>Type</a></th>
						 <th><a>Date</a></th>
					  </thead>
					  <tbody>
						 <?php if(count($users) > 0): ?>
						 <?php $i=1; ?>
						 <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userkey => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						 <tr>
							<td><?php echo e($i); ?></td>
							
							<td>
							  <?php echo e($user->description); ?>             
							</td>
							
							<td>
							   <?php echo e($user->action); ?>

							</td>
							
							<td>
							  <?php if($user->type == 1): ?>
								Admin
							  <?php elseif($user->type == 2): ?>
								Manager
							  <?php elseif($user->type == 3): ?>
								Developer
							  <?php else: ?>
								Client
							  <?php endif; ?>  
							</td>
							
							<td><?php echo e(date('M d, Y H:i:s', $user->created_at)); ?></td>
						 </tr>
					  <?php $i++; ?>
						 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						 <?php else: ?>
						 <tr>
						   <td colspan="7">
							<center>
							  <label class="alert alert-warning">
								No data found on this date range
							  </label>
							</center> 
						   </td>
						 </tr>
						 <?php endif; ?>
					  </tbody>
					</table>
				   
				</div>
			</div>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>