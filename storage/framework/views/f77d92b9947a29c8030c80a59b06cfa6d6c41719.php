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
                     <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userkey => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td id="user59"><?php echo e($userkey + 1); ?></td>
                        <td><?php echo e($user->description); ?></td>
                        
                        <td><?php echo e($user->action); ?></td>
                        
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
               