
<?php $__env->startSection('title','File Render'); ?>
<?php $__env->startSection('content'); ?>
<img src="<?php echo e(url('public/storage/not_found.png')); ?>"  style=" width: 200px; margin-top: 71px; margin-left: 40%; " />
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>