<?php if($from == '1'): ?>
<!-- <li class="ks-separator">Today</li> -->
<?php endif; ?>

<?php if(count($messages) > 0): ?>
<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mkey => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php if($mkey == count($messages)-1): ?>
  <input type="hidden" class="countmsg_cls" name="last_msgs" value="<?php echo e($message->id); ?>">
<?php endif; ?>

<?php 
  $words = $message->sender_name;
  $firstTwoCharacters = substr($words, 0, 2);
  //$url = URL::to("storage/app")."/".$message->message;
  $url=url('public/storage/app/'.$message->message);
  $p_url = public_path("storage/app")."/".$message->message;	
?>

<?php if($message->sender_id == Session::get('client_id')): ?>
<?php if($message->msg_type == "file"){

   if($message->file_type =='image'){
    ?>

     <li class="ks-item ks-from" <?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>><span class="ks-avatar ks-offline"><?php echo e(strtoupper($firstTwoCharacters)); ?></span><div class="ks-body"><div class="ks-header"><span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="<?php echo e($message->message); ?>"><img id="msg-image" class = "msgs-image" _ngcontent-c4="" src="<?php echo $url; ?>"></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4=""><?php echo substr($message->message,0,20); ?></small></p><p _ngcontent-c4=""><small _ngcontent-c4=""><?php echo e(date('M d , g:ia', strtotime($message->created_at))); ?></small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>

<?php
    
   }else{

?>
 <li class="ks-item ks-from" <?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>><span class="ks-avatar ks-offline"><?php echo e(strtoupper($firstTwoCharacters)); ?></span><div class="ks-body"><div class="ks-header"><span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="<?php echo e($message->message); ?>"><i _ngcontent-c4="" class="fa fa-file" style="font-size:70px;"></i></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4=""><?php echo substr($message->message,0,20); ?></small></p><p _ngcontent-c4=""><small _ngcontent-c4=""><?php echo e(date('M d , g:ia', strtotime($message->created_at))); ?></small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>
<?php
}
}else{
  ?>
<li class="ks-item ks-from" <?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>>
   <span class="ks-avatar ks-offline"><?php echo e(strtoupper($firstTwoCharacters)); ?></span>
   <div class="ks-body">
      <div class="ks-header">
         <span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span>
         <span class="ks-datetime"><?php echo e(date('M d , g:ia', strtotime($message->created_at))); ?></span>
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

     <li class="ks-item ks-self test"<?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>><span class="ks-group-amount two-char-name"><?php echo e(strtoupper($firstTwoCharacters)); ?></span><div class="ks-body"><div class="ks-header"><span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="<?php echo e($message->message); ?>"><img id = "msg-image" class = "msgs-image"  _ngcontent-c4="" src="<?php echo $url; ?>"></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4=""><?php echo substr($message->message,0,20); ?></small></p><p _ngcontent-c4=""><small _ngcontent-c4=""><?php echo e(date('M d , g:ia', strtotime($message->created_at))); ?></small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>

<?php
   }else{
?>
 <li class="ks-item ks-self test"<?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>><span class="ks-group-amount two-char-name"><?php echo e(strtoupper($firstTwoCharacters)); ?></span><div class="ks-body"><div class="ks-header"><span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span><div _ngcontent-c4="" class="triangle-border right" style="float:right;text-align: right;max-width: 60%;"><span _ngcontent-c4=""></span><a _ngcontent-c4="" href="<?php echo $url; ?>" download="<?php echo e($message->message); ?>"><i _ngcontent-c4="" class="fa fa-file" style="font-size:70px;"></i></a><p _ngcontent-c4=""><small class="file_name" _ngcontent-c4=""><?php echo substr($message->message,0,20); ?></small></p><p _ngcontent-c4=""><small _ngcontent-c4=""><?php echo e(date('M d , g:ia', strtotime($message->created_at))); ?></small>&nbsp;<span _ngcontent-c4="" class="check-mark" id="235" style="color: rgb(134, 142, 150);"><span _ngcontent-c4="" class="ti-check"></span><span _ngcontent-c4="" class="ti-check" style="position: relative;right: 8px;top:1px;"></span></span></p></div></div></div></li>
<?php
}
}else{
  ?>
<li class="ks-item ks-self test"<?php if($mkey == 0): ?>  id="msg-start-<?php echo e($message->id); ?>" <?php endif; ?> <?php if($mkey == count($messages) - 1): ?>  id="msg-end-<?php echo e($message->id); ?>" <?php endif; ?>>
   <span class="ks-group-amount two-char-name"><?php echo e(strtoupper($firstTwoCharacters)); ?></span>
   <div class="ks-body">
      <div class="ks-header">
         <span class="ks-name"><?php echo e(ucfirst($message->sender_name)); ?></span>
         <span class="ks-datetime"><?php 
          if(is_int($message->created_at))
          {
            echo   date('M d , g:ia', $message->created_at);
          }
          else 
          {
              echo date('M d , g:ia', strtotime($message->created_at));
              
          }
          ?></span>
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

<!-- <li class="ks-item ks-self">
   <span class="ks-group-amount two-char-name">CA</span>
   <div class="ks-body">
      <div class="ks-header">
         <span class="ks-name">Brian Diaz</span>
         <span class="ks-datetime">6:46 PM</span>
      </div>
      <div class="ks-message">The weird future of movie theater food</div>
   </div>
</li>
<li class="ks-item ks-from">
   <span class="ks-avatar ks-offline">AB</span>
   <div class="ks-body">
      <div class="ks-header">
         <span class="ks-name">Brian Diaz</span>
         <span class="ks-datetime">6:46 PM</span>
      </div>
      <div class="ks-message">
         The weird future of movie theater food
         <div class="ks-link">
            <div class="ks-name">Google</div>
            <a href="http://www.google.com" target="_blank">www.google.com</a>
         </div>
      </div>
   </div>
</li> -->
<!-- <li class="ks-item ks-self">
   <span class="ks-avatar ks-offline">
       <img src="https://bootdey.com/img/Content/avatar/avatar4.png" width="36" height="36" class="rounded-circle">
   </span>
   <div class="ks-body">
       <div class="ks-header">
           <span class="ks-name">Brian Diaz</span>
           <span class="ks-datetime">6:46 PM</span>
       </div>
       <div class="ks-message">The weird future of movie theater food</div>
   </div>
   </li>
   <li class="ks-item ks-from ks-unread">
   <span class="ks-avatar ks-online">
       <img src="https://bootdey.com/img/Content/avatar/avatar5.png" width="36" height="36" class="rounded-circle">
   </span>
   <div class="ks-body">
       <div class="ks-header">
           <span class="ks-name">Brian Diaz</span>
           <span class="ks-datetime">1 minute ago</span>
       </div>
       <div class="ks-message">
           The weird future of movie theater food
   
           <ul class="ks-files">
               <li class="ks-file">
                   <a href="#">
                       <span class="ks-thumb">
                           <span class="ks-icon la la-file-word-o text-info"></span>
                       </span>
                       <span class="ks-info">
                           <span class="ks-name">Project...</span>
                       <span class="ks-size">15 kb</span>
                       </span>
                   </a>
               </li>
               <li class="ks-file">
                   <a href="#">
                       <span class="ks-thumb">
                           <img src="https://bootdey.com/img/Content/avatar/avatar1.png" width="36" height="36">
                       </span>
                       <span class="ks-info">
                           <span class="ks-name">photo.jpg</span>
                       <span class="ks-size">312 kb</span>
                       </span>
                   </a>
               </li>
           </ul>
       </div>
   </div>
   </li>
   
   <li class="ks-separator">Today</li>
   
   <li class="ks-item ks-self">
   <span class="ks-avatar ks-offline">
       <img src="https://bootdey.com/img/Content/avatar/avatar2.png" width="36" height="36" class="rounded-circle">
   </span>
   <div class="ks-body">
       <div class="ks-header">
           <span class="ks-name">Brian Diaz</span>
           <span class="ks-datetime">6:46 PM</span>
       </div>
       <div class="ks-message">
           Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
       </div>
   </div>
   </li>
   <li class="ks-item ks-self">
   <span class="ks-avatar ks-offline">
       <img src="https://bootdey.com/img/Content/avatar/avatar3.png" width="36" height="36" class="rounded-circle">
   </span>
   <div class="ks-body">
       <div class="ks-header">
           <span class="ks-name">Brian Diaz</span>
           <span class="ks-datetime">6:46 PM</span>
       </div>
       <div class="ks-message">
           Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
       </div>
   </div>
   </li>
   <li class="ks-item ks-self">
   <span class="ks-avatar ks-offline">
       <img src="https://bootdey.com/img/Content/avatar/avatar4.png" width="36" height="36" class="rounded-circle">
   </span>
   <div class="ks-body">
       <div class="ks-header">
           <span class="ks-name">Brian Diaz</span>
           <span class="ks-datetime">6:46 PM</span>
       </div>
       <div class="ks-message">
           Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
       </div>
   </div>
   </li> -->