 

<?php $__env->startSection('title','Chat'); ?> 

<?php $__env->startSection('content'); ?>
<style>
.ks-messenger .ks-messages, .ks-messenger__messages {
    position: initial;
    top: 120px;
    bottom: 0;
    z-index: 2;
    height: -webkit-calc(100% - 120px);
    height: calc(100% - 120px);
    width: 100%;
    right: -1000px;
}
.ks-name {
    font-size: 12px;
}
.ks-body {
    margin-left: 0px !important;
    width: 106%;
	margin-right: 0px !important;
}
.chat_header{
	height:75px;padding-bottom: 13px;
}
.chat_header_a{
	width:70%;float:left;font-size:12px;
}
.chat_header_b{
	width:30%;float:left;font-size:12px;
}

</style>
<section class="content">

	<div class="container-fluid">

		<div class="card">

			<div class="card-body" >

				<div class="ks-page-content">

					<div class="ks-page-content-body">

						<div class="ks-messenger">
							<?php if($selected_grp): ?>

							<div class="ks-messages ks-messenger__messages">

								<div class="ks-header" style="height: 175px;padding-top: 0px;margin-top: -43px;">
									<div class="row">
										<div class="col-sm-12">
											<div class="ks-description">
												<div class="chat_header">
													<div class="chat_header_a"><strong style="font-weight: 10px"><?php echo e($selected_grp ? ucfirst($selected_grp->group_name) : 'Group Name'); ?></strong></div>
													<div class="chat_header_b"><?php echo e(count($members) > 0 ? count($members) : 0); ?> <?php echo e(count($members) == 1 ? 'member' : 'members'); ?></div>
													<div class="ks-name"><?php echo e($member_names ? implode(', ',$member_names) : ''); ?></div>
												</div>
											</div>
										</div>
										<div style="width:45%;float:left">
											<div class="ks-controls">
											<!--  Deependra -->
											<a href="<?php echo e(asset('clients/groups/'.Session::get('job_id'))); ?>" class="btn btn-info btn-sm">Go Back</a>
											</div>
										</div>
										<div style="width:10%;float:left"></div>
										<div style="width:45%;float:left">
											<div class="ks-controls">
											<!--  Deependra -->
											<?php if(isset($messages[0])): ?>
											<a href="<?php echo e(asset('clients/export_group_chat/'.$messages[0]->group_id)); ?>" class="btn btn-info btn-sm">Export chat</a>
											<?php endif; ?>
											</div>
										</div>
									</div>
								</div>

								

								<div class="ks-body ks-scrollable jspScrollable" data-auto-height="" data-reduce-height=".ks-footer" data-fix-height="32" style="height: 390px; overflow: hidden; padding: 0px;" tabindex="0">

									<div class="jspContainer" style="height: 380px;">

										<div class="jspPane" style="padding: 0px; top: 0px;">

											<ul class="ks-items" id="message-container">

												<?php if(count($messages) > 0): ?>

												  <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mkey => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



												  <?php if($mkey == count($messages)-1): ?>

													<input type="hidden" class="countmsg_cls" name="last_msgs" value="<?php echo e($message->id); ?>">

												  <?php endif; ?>



												  <?php if($mkey == 0): ?>

													<input type="hidden" class="last_start_date" name="last_start_date" value="<?php echo e($message->created_at); ?>">

												  <?php endif; ?>



												  <?php 

													$words = $message->sender_name;

													$firstTwoCharacters = substr($words, 0, 2);

													$url = URL::to("public/storage/app")."/".$message->message;

													$p_url = public_path("storage/app")."/".$message->message;	

												  ?>



												  <?php if($message->sender_id == Session::get('client_id')): ?>



							  <?php 

							  if($message->msg_type == "file"){

								if($message->file_type=='image'){

					?>



					 <li class="ks-item ks-from" <?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>><span class="ks-avatar ks-offline"><?php echo e(strtoupper($firstTwoCharacters)); ?></span><div class="ks-body"><div class="ks-header"><span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="<?php echo e($message->message); ?>"><img id = "msg-image" class = "msgs-image" _ngcontent-c4="" src="<?php echo $url; ?>"></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4=""><?php echo substr($message->message,0,20); ?></small></p><p _ngcontent-c4=""><small _ngcontent-c4=""><?php echo e(date('M d , g:ia', $message->created_at)); ?></small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>



				<?php

					

				   }else{



				?>

							  <li class="ks-item ks-from" <?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>><span class="ks-avatar ks-offline"><?php echo e(strtoupper($firstTwoCharacters)); ?></span><div class="ks-body"><div class="ks-header"><span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="<?php echo e($message->message); ?>"><i _ngcontent-c4="" class="fa fa-file" style="font-size:70px;"></i></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4=""><?php echo substr($message->message,0,20); ?></small></p><p _ngcontent-c4=""><small _ngcontent-c4=""><?php echo e(date('M d , g:ia', $message->created_at)); ?></small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>

							  <?php

							} 

							  }else{

								?>

												  <li class="ks-item ks-from" <?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>>

													 <span class="ks-avatar ks-offline"><?php echo e(strtoupper($firstTwoCharacters)); ?></span>

													 <div class="ks-body">

														<div class="ks-header">

														   <span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span>

														   <span class="ks-datetime"><?php echo e(date('M d , g:ia', $message->created_at)); ?></span>

														</div>

														<div class="ks-message"><?php echo $message->message; ?></div>

													 </div>

												  </li>

												  <?php

				}

				?>

												  <?php else: ?>

					<?php if($message->msg_type == "file"){



							   if($message->file_type=='image'){

					?>



					 <li class="ks-item ks-self"<?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>><span class="ks-group-amount two-char-name"><?php echo e(strtoupper($firstTwoCharacters)); ?></span><div class="ks-body"><div class="ks-header"><span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="<?php echo e($message->message); ?>"><img id = "msg-image " class = "msgs-image" _ngcontent-c4="" src="<?php echo $url; ?>"></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4=""><?php echo substr($message->message,0,20); ?></small></p><p _ngcontent-c4=""><small _ngcontent-c4=""><?php echo e(date('M d , g:ia', $message->created_at)); ?></small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>



				<?php

					

				   }else{ 



				?>

							  <li class="ks-item ks-self"<?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>><span class="ks-group-amount two-char-name"><?php echo e(strtoupper($firstTwoCharacters)); ?></span><div class="ks-body"><div class="ks-header"><span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="<?php echo e($message->message); ?>"><i _ngcontent-c4="" class="fa fa-file" style="font-size:70px;"></i></a><p _ngcontent-c4=""><small  class="file_name" _ngcontent-c4=""><?php echo substr($message->message,0,20); ?></small></p><p _ngcontent-c4=""><small _ngcontent-c4=""><?php echo e(date('M d , g:ia', $message->created_at)); ?></small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>

							  <?php

							}

							  }else{

								?>



												  <li class="ks-item ks-self"<?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>>

													 <span class="ks-group-amount two-char-name"><?php echo e(strtoupper($firstTwoCharacters)); ?></span>

													 <div class="ks-body">

														<div class="ks-header">

														   <span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span>

														   <span class="ks-datetime"><?php echo e(date('M d , g:ia', $message->created_at)); ?></span>

														</div>

														<div class="ks-message"><?php echo $message->message; ?></div>

													 </div>

												  </li>

					<?php

				}

				?>

												  <?php endif; ?>



												  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

												  <?php endif; ?>

											</ul>

										</div>

										

									</div>

								</div>

								<div class="ks-footer clnt-footer">
								 <div class="row" style="width: 100%;margin-bottom: 11px;">
									<div style="width: 20%;float:left">
										<div class="btn-group dropup">
										  <span _ngcontent-c4="" class="btn green fileinput-button">
											<i _ngcontent-c4="" class="fa fa-link"></i>
											<input _ngcontent-c4="" id="file" name="image" type="file">
										  </span>
										  </div>
									</div> 
									<div style="width: 75%;">
										<div contenteditable="true" class="form-control message" onkeyup="typeMessage(event)" name="message" placeholder="Type something..."></div>

										<input type="hidden" class="group_id_cls" name="group_id" value="<?php echo e($selected_grp ? $selected_grp->group_id : ''); ?>">

										<input type="hidden" class="sender_cls" name="sender_id" value="<?php echo e($sess_client_id ? $sess_client_id : ''); ?>">
									</div>
								</div>
								<div class="row">
									<div class="ks-controls" style="margin-top: 6px;width: 100%;">

										<button class="btn btn-primary btn-block" onclick="sendMessage()">Send</button>

									</div>
								</div>
									<ul class="client-id-all">

									  <?php if(count($member_names) > 0): ?>

										<?php $__currentLoopData = $member_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $memkey => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

										  <li class="ui-menu-item" onclick="chooseClient('<?php echo e($name); ?>')"><?php echo e($name); ?></li>

										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

									  <?php endif; ?>
									</ul>
								</div>
							</div>
							<?php endif; ?>
						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>