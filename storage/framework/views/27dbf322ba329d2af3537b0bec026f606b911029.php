 
<?php $__env->startSection('title','Notifications'); ?> 
<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header custom_cart_header">
				<div class="row">
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						  <input style=" margin-top: -5px;" type="text" name="daterange" data-access="<?php if(Request::segment(2)=='notifications') { echo "1"; } else { echo "2"; }  ?>" class="daterange daterange_1 form-control" data-tablecont="table_container_1" data-tableid="sample_1" data-reporttype="all" />
					 </div>
				</div>
			</div>
			<div class="card-body" >
				<div class="container table_box" id="table_container">
					<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="Notification-table" role="grid" aria-describedby="sample_1_info">
						<thead>
						  <tr role="row">
							  <th>Title</th>  
							  <th>Message</th>
							  <th>Date</th>
							  <th>Status</th>
						  </tr>
						</thead>
						<tbody>
						  <?php if(count($allnotifications) > 0): ?>
								 <?php $__currentLoopData = $allnotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nkey => $allnotification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								 <?php 
									 $url="javascript:;";
									  if($allnotification->type==1)
									  {
										  if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
											|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
											, $_SERVER["HTTP_USER_AGENT"]))
											{
												$url = url('clients/groups-single/'.$allnotification->job_id.'/'.$allnotification->file_id); 
											}
											else 
											{
												$url = url('clients/groups/'.$allnotification->job_id.'/'.$allnotification->file_id);
											}
											
									  }
								     else if($allnotification->type==2)
									 {
										 if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
											|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
											, $_SERVER["HTTP_USER_AGENT"]))
											{
												$url = url('clients/topics-single/'.$allnotification->job_id.'/'.$allnotification->file_id);
											}
											else 
											{
												$url = url('clients/topics/'.$allnotification->job_id.'/'.$allnotification->file_id);
											}
											
									 }
								     else if($allnotification->type==3)
									 {
										 if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
											|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
											, $_SERVER["HTTP_USER_AGENT"]))
											{
												$url = url('clients/user-single/'.$allnotification->job_id.'/'.$allnotification->file_id);
											}
											else 
											{
												$url = url('clients/user/'.$allnotification->job_id.'/'.$allnotification->file_id);
											}
											
									 }
								    ?> 
								 <tr>
									<td>
									   <?php if($allnotification->is_annotation == 1): ?>
										<a href="<?php echo e(url('clients/shared/'.$allnotification->id)); ?>">
										<?php echo e($allnotification->title); ?>

										</a>
										<?php elseif($allnotification->type == 1): ?>
										<a href="<?php echo e($url); ?>">
										<?php echo e($allnotification->title); ?>

										</a>
										<?php elseif($allnotification->type == 2): ?>
										<a href="<?php echo e($url); ?>">
										<?php echo e($allnotification->title); ?>

										</a>
										<?php elseif($allnotification->type == 3): ?>
										<a href="<?php echo e($url); ?>">
										<?php echo e($allnotification->title); ?>

										</a>
										<?php else: ?>
										<?php echo e($allnotification->title); ?>

										<?php endif; ?>
									</td>
									<td>
									   <?php 
									  $message = str_replace('#','',str_replace('@','', substr(strip_tags($allnotification->message), 0, 20)));
									 // $message2= str_replace('#','',str_replace('@','', strip_tags($allnotification->message)));
									 //  $message = substr(strip_tags($allnotification->message), 0, 20);
									   //$message2= strip_tags($allnotification->message);
									  ?>
									   <?php if($allnotification->is_annotation == 1): ?>
										<a href="<?php echo e(url('clients/shared/'.$allnotification->id)); ?>">
										<?php echo  strlen($message) > 15  ? $message . '...' :  $message; ?>
										</a>
										<?php else: ?>
										<?php echo  strlen($message) > 15  ? $message . '...' : $message; ?>  
										<?php endif; ?>
									</td>
									<td><?php echo e(date('M d, Y H:i:s', $allnotification->created_at)); ?></td>
									<td>
									  <?php if($allnotification->mark_read == 1): ?>
									   <a href="javascript:void(0)" data-notif_list_id="<?php echo e($allnotification->id); ?>" type="button" class="btn btn-xs btn-success mark_read_list">Mark read</a>      
									   <?php else: ?>
									   <a href="javascript:void(0)" data-notif_list_id="<?php echo e($allnotification->id); ?>" type="button" class="btn btn-xs btn-info" disabled>Read</a>      
									   <?php endif; ?>
									</td>
								 </tr>
								 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								 <?php else: ?>
								 <tr>
								   <td colspan="5">
									<center>
									<?php if(Request::segment(2)=='message_notification'): ?>
									  <a  href="<?php echo e(url('clients/groups/'.Session::get('job_id'))); ?>"><label style="cursor: pointer;" class="alert alert-warning">Go To Messenger</label></a>
									<?php else: ?> 
									  <label class="alert alert-warning"> No new message found yet</label>
									<?php endif; ?>
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