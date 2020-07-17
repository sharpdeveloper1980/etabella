<ul>
<?php if(count($tags) > 0): ?>
<?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mkey => $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<li>
		<div class="row">
			<div class="col-md-12">
				<a href="javascript:void(0)" class="tag_row" onclick="getTaggedFiles(<?=$tag->id?>,'<?php echo e($tag->color_tag); ?>')">
					<i class="fa fa-circle" style="color: <?php echo e($tag->color_tag); ?>"></i>
					<span><?php echo e($tag->title); ?></span>
				</a>
			</div>
		</div>
	</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
	<li></li>
<?php endif; ?> 
</ul>