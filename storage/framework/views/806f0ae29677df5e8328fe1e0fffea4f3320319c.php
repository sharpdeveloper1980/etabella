<!-- notify content -->
<?php if(count($notifications) > 0): ?>
	<?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nkey => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    	<div class="drop-content" id="row-<?php echo e($notification->id); ?>">
        	
            	<?php if($notification->is_annotation == 1): ?>
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="<?php echo e(url('clients/shared/'.$notification->id)); ?>">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           <?php echo e($notification->title); ?>

                                      </label>
                                      </a> 
                                    </div>
                                    <?php elseif($notification->is_annotation == 2): ?>
									 <?php 
									 $url="javascript:;";
									  if($notification->type==1)
									  {
										  if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
											|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
											, $_SERVER["HTTP_USER_AGENT"]))
											{
												$url = url('clients/groups-single/'.$notification->job_id.'/'.$notification->file_id); 
											}
											else 
											{
												$url = url('clients/groups/'.$notification->job_id.'/'.$notification->file_id);
											}
											
									  }
								     else if($notification->type==2)
									 {
										 if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
											|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
											, $_SERVER["HTTP_USER_AGENT"]))
											{
												$url = url('clients/topics-single/'.$notification->job_id.'/'.$notification->file_id);
											}
											else 
											{
												$url = url('clients/topics/'.$notification->job_id.'/'.$notification->file_id);
											}
											
									 }
								     else if($notification->type==3)
									 {
										 if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
											|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
											, $_SERVER["HTTP_USER_AGENT"]))
											{
												$url = url('clients/user-single/'.$notification->job_id.'/'.$notification->file_id);
											}
											else 
											{
												$url = url('clients/user/'.$notification->job_id.'/'.$notification->file_id);
											}
											
									 }
								    ?> 
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="<?php echo e($url); ?>">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           <?php echo e($notification->title); ?>

                                      </label>
                                      </a> 
                                    </div>
                                    <?php elseif($notification->is_annotation == 3): ?>
                                    <div class="col-md-9 pd-l0"> 
                                      <a href="<?php echo e($url); ?>">
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           <?php echo e($notification->title); ?>

                                      </label>
                                      </a> 
                                    </div>
                                    <?php elseif($notification->is_annotation == 0): ?>
                                    <div class="col-md-9 pd-l0"> 
                                      <label style="cursor: pointer;">
                                      <i class="fa fa-bell" style="color: #f36523;"></i> 
                                           <?php echo e($notification->title); ?>

                                      </label>  
                                    </div>
                                    <?php endif; ?> 
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <!-- <div class="notify-img"> -->
                    <a href="javascript:void(0)" onclick="mark_read(<?=$notification->id?>)" data-notif_id="<?php echo e($notification->id); ?>" type="button" class="btn btn-xs btn-default mark_read_btn">Mark read</a>
                    <!-- </div> -->
                </div>

                <div class="col-md-12 pd-l0">
                	<p></p>
                </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <div class="drop-content" id="row-else">
            <div class="col-md-12">No message found</div>
    </div>
<?php endif; ?>