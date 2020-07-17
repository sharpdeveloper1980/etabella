<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="sample_1" role="grid" aria-describedby="sample_1_info">
            <thead>
              <tr role="row">
                  <th>Filename</th>
				  <?php if($type=='commented'): ?>
				  <th>Comment</th>
				  <?php endif; ?>
                  <?php if($type=="shared"): ?>
                  <th>Reciepient</th>
                  <?php endif; ?>
                  <th>Date</th>
              </tr>
            </thead>
            <tbody id="reportList">
              <?php if(count($quicks) > 0): ?>
              <?php $__currentLoopData = $quicks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickkey => $quick): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td>
                    <a href="<?php echo e(url('clients/file/render/'.$quick->file_id)); ?>">
                    <?php echo e($quick->file_name); ?>

                    </a>
                  </td>
				   <?php if($type=='commented'): ?>
				   <td><?php echo e($quick->comment); ?></td>
				   <?php endif; ?>
				   <?php if($quick->type == 4): ?>
                  <td>
                    <?php echo e($quick->reciepient); ?>

                  </td>
                  <?php endif; ?>
                  <td>
				  <?php if($type=='commented'): ?>
				  <?php echo e(date("M d , H:i A", strtotime($quick->created_at))); ?>

				  <?php else: ?> 
                     <?php echo e(date('M d, Y H:i:s', $quick->created_at)); ?>

				  <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php else: ?>
               <tr>
                  <td colspan="2" style="text-align: center;">
                  No files found here.. 
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
        </table>