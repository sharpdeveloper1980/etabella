<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer " id="<?php echo e($tableid); ?>" role="grid" aria-describedby="<?php echo e($tableid); ?>_info">
              <thead>
                <tr role="row">
                    <th>Filename</th>
                    <th>Date</th>
                    <th>Page</th>
                    <th>Type</th>
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