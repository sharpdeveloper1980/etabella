 

<?php $__env->startSection('title','Chat'); ?> 

<?php $__env->startSection('content'); ?>

<section class="content">

	<div class="container-fluid">

		<div class="card">

			<div class="card-body" >

				<div class="ks-page-content">

					<div class="ks-page-content-body">

						<div class="ks-messenger">
						<?php if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
							|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" 
							, $_SERVER["HTTP_USER_AGENT"])): ?>
							<div class="ks-discussions">

								<div class="ks-search">

								   <div class="dropdown chat_head">

									   <button class="btn btn-primary-outline ks-light ks-no-text ks-no-arrow" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

									   <span class="fa fa-home"> 

										<span class="fa fa-chevron-down" style="color: #7a7575"></span>

										</span>

									   </button>

									   <div class="dropdown-menu ks-simple" aria-labelledby="dropdownMenuButton">

										  <p><a class="dropdown-item" href="<?php echo e(url('clients/groups'.'/'.Session::get('job_id'))); ?>">

											 <span class="la la-user-plus ks-icon"></span>

											 <span class="ks-text">Groups</span>

											 </a>

										  </p>

										  <p><a class="dropdown-item" href="<?php echo e(url('clients/topics'.'/'.Session::get('job_id'))); ?>">

											 <span class="la la-eye-slash ks-icon"></span>

											 <span class="ks-text">Topics</span>

											 </a>

										  </p>

										  <p>

											<a class="dropdown-item sub-heading" href="javascript:void(0)">

											 <span class="ks-text">One to One</span>



											<?php if($all_users): ?>

											 <span class="fa fa-chevron-down" style="color: #7a7575"></span>

											 </a>

											 <div id="sub-one-to-one" class="dropdown-submenu dropdown-menu sub-ks-simple" aria-labelledby="dropdownMenuButton" style="display: none">

											  <?php $__currentLoopData = $all_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ukey =>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

												<?php if($sess_client_id != $user->client_id): ?>

												<p><a class="dropdown-item" href="<?php echo e(url('clients/user/'.Session::get('job_id').'/'.$user->client_id)); ?>">

												   <span class="la la-user-plus ks-icon"></span>

												   <i class="fa fa-comments-o" aria-hidden="true"></i>

												   <span class="ks-text"><?php echo e(ucfirst($user->client_display_name)); ?></span>

												   </a>

												</p>

												<?php endif; ?>

											  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

											  <!-- <p><a class="dropdown-item" href="#">

												 <span class="la la-eye-slash ks-icon"></span>

												 <span class="ks-text">User 2</span>

												 </a>

											  </p> -->



											</div>

											<?php endif; ?>



										  </p>

									   </div>

									   <span class="chat-type">Groups</span>

									</div>

								</div>
								
								
								<div class="ks-body ks-scrollable jspScrollable" data-auto-height="400" style="overflow-y: hidden; padding: 0px;" tabindex="0">



									<div class="jspContainer-sidebar" style="height: 450px;">

										<div class="jspPane" style="padding: 0px; top: 0px;">

											<ul class="ks-items">

											  <?php if($groups): ?>

											  <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gkey => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

												<?php 

												  $client = explode(',',$group->client_id); 

												?>

												<li class="<?php echo e($gkey % 2 ? 'ks-item ks-active': 'ks-item ks-unread'); ?>">

													<a href="<?php echo e(url('clients/groups/'.$whchjobs.'/'.$group->group_id)); ?>">

														<span class="ks-group-amount"><?php echo e(count($client)); ?></span>

														<div class="ks-body">

															<div class="ks-name">

																<?php echo e($group->group_name); ?>


																<span class="ks-datetime"></span>

															</div>

														</div>

													</a>

												</li>

												

											  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

											  <?php else: ?>

											  <li class="ks-item">

													<a href="#">

														<span class="ks-avatar">

															<!-- <img src="https://bootdey.com/img/Content/avatar/avatar3.png" width="36" height="36"> -->

														</span>

														<div class="ks-body">

															<!-- <div class="ks-name">

																Eric George

																<span class="ks-datetime">just now</span>

															</div> -->

															<div class="ks-message">No Group Found</div>

														</div>

													</a>

												</li>

											  <?php endif; ?>

											  

											</ul>

										</div>

										

									</div>

								</div>

							</div>
							<?php else: ?> 
							<div class="ks-discussions">

								<div class="ks-search">

								   <div class="dropdown chat_head">

									   <button class="btn btn-primary-outline ks-light ks-no-text ks-no-arrow" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

									   <span class="fa fa-home"> 

										<span class="fa fa-chevron-down" style="color: #7a7575"></span>

										</span>

									   </button>

									   <div class="dropdown-menu ks-simple" aria-labelledby="dropdownMenuButton">

										  <p><a class="dropdown-item" href="<?php echo e(url('clients/groups'.'/'.Session::get('job_id'))); ?>">

											 <span class="la la-user-plus ks-icon"></span>

											 <span class="ks-text">Groups</span>

											 </a>

										  </p>

										  <p><a class="dropdown-item" href="<?php echo e(url('clients/topics'.'/'.Session::get('job_id'))); ?>">

											 <span class="la la-eye-slash ks-icon"></span>

											 <span class="ks-text">Topics</span>

											 </a>

										  </p>

										  <p>

											<a class="dropdown-item sub-heading" href="javascript:void(0)">

											 <span class="ks-text">One to One</span>



											<?php if($all_users): ?>

											 <span class="fa fa-chevron-down" style="color: #7a7575"></span>

											 </a>

											 <div id="sub-one-to-one" class="dropdown-submenu dropdown-menu sub-ks-simple" aria-labelledby="dropdownMenuButton" style="display: none">

											  <?php $__currentLoopData = $all_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ukey =>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

												<?php if($sess_client_id != $user->client_id): ?>

												<p><a class="dropdown-item" href="<?php echo e(url('clients/user/'.Session::get('job_id').'/'.$user->client_id)); ?>">

												   <span class="la la-user-plus ks-icon"></span>

												   <i class="fa fa-comments-o" aria-hidden="true"></i>

												   <span class="ks-text"><?php echo e(ucfirst($user->client_display_name)); ?></span>

												   </a>

												</p>

												<?php endif; ?>

											  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

											  <!-- <p><a class="dropdown-item" href="#">

												 <span class="la la-eye-slash ks-icon"></span>

												 <span class="ks-text">User 2</span>

												 </a>

											  </p> -->



											</div>

											<?php endif; ?>



										  </p>

									   </div>

									   <span class="chat-type">Groups</span>

									</div>

								</div>
								
								
								<div class="ks-body ks-scrollable jspScrollable" data-auto-height="400" style="overflow-y: hidden; padding: 0px;" tabindex="0">



									<div class="jspContainer-sidebar" style="height: 450px;">

										<div class="jspPane" style="padding: 0px; top: 0px;">

											<ul class="ks-items">

											  <?php if($groups): ?>

											  <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gkey => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

												<?php 

												  $client = explode(',',$group->client_id); 

												?>

												<li class="<?php echo e($gkey % 2 ? 'ks-item ks-active': 'ks-item ks-unread'); ?>">

													<a href="<?php echo e(url('clients/groups-single/'.$whchjobs.'/'.$group->group_id)); ?>">

														<span class="ks-group-amount"><?php echo e(count($client)); ?></span>

														<div class="ks-body">

															<div class="ks-name">

																<?php echo e($group->group_name); ?>


																<span class="ks-datetime"></span>

															</div>

														</div>

													</a>

												</li>

												

											  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

											  <?php else: ?>

											  <li class="ks-item">

													<a href="#">

														<span class="ks-avatar">

															<!-- <img src="https://bootdey.com/img/Content/avatar/avatar3.png" width="36" height="36"> -->

														</span>

														<div class="ks-body">

															<!-- <div class="ks-name">

																Eric George

																<span class="ks-datetime">just now</span>

															</div> -->

															<div class="ks-message">No Group Found</div>

														</div>

													</a>

												</li>

											  <?php endif; ?>

											  

											</ul>

										</div>

										

									</div>

								</div>

							</div>
							<?php endif; ?>
							<?php if($selected_grp): ?>

							<div class="ks-messages ks-messenger__messages">

								<div class="ks-header">

									<div class="ks-description">

										<div class="ks-name"><strong style="font-weight: 10px"><?php echo e($selected_grp ? ucfirst($selected_grp->group_name) : 'Group Name'); ?></strong></div>

										<div class="ks-name"><?php echo e($member_names ? implode(', ',$member_names) : ''); ?></div>

										<div class="ks-amount"><?php echo e(count($members) > 0 ? count($members) : 0); ?> <?php echo e(count($members) == 1 ? 'member' : 'members'); ?></div>

									</div>

									<div class="ks-controls">

									<!--  Deependra -->

									<?php if(isset($messages[0])): ?>

									<a href="<?php echo e(asset('clients/export_group_chat/'.$messages[0]->group_id)); ?>" class="btn btn-info">Export chat</a>

									<?php endif; ?>

									

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

								  <div class="btn-group dropup">

								  <span _ngcontent-c4="" class="btn green fileinput-button">

									<i _ngcontent-c4="" class="fa fa-link"></i>

									<input _ngcontent-c4="" id="file" name="image" type="file">

								  </span>

								  </div>

									<div contenteditable="true" class="form-control message" onkeyup="typeMessage(event)" name="message" placeholder="Type something..."></div>



									<input type="hidden" class="group_id_cls" name="group_id" value="<?php echo e($selected_grp ? $selected_grp->group_id : ''); ?>">

									<input type="hidden" class="sender_cls" name="sender_id" value="<?php echo e($sess_client_id ? $sess_client_id : ''); ?>">



									<div class="ks-controls">

										<button class="btn btn-primary" onclick="sendMessage()">Send</button>

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