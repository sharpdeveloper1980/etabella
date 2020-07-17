<?php $__env->startSection('title','Users'); ?>

<?php $__env->startSection('content'); ?>
<section>
<!-- Page content-->
<div class="content-wrapper">
   <div class="content-heading">
      <!-- START Language list-->
      <div class="pull-right">
      </div>
      <!-- END Language list    -->
      Edit Client
      <!-- <small>Hehe</small> -->
   </div>
   <div class="row">
      <!-- START dashboard main content-->
      <div class="col-lg-7">
         <div class="panel panel-default">
            <div class="panel-body">
               <form id="add_client" action="<?php echo e(route('updateClient',$client->client_id)); ?>" class="form-horizontal" method="post">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">User Name*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="text" placeholder="Group Name" name="username" id="username" value="<?php echo e($client->username); ?>" maxlength="30">
                     </div>
                  </div>

                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Display Name*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="text" placeholder="Group Name" name="client_display_name" id="client_display_name" value="<?php echo e($client->client_display_name); ?>" maxlength="30">
                     </div>
                  </div>

                  <div class="form-group" id="ftp_host_div">
                     <label class="col-md-4 control-label">Password*</label>
                     <div class="col-md-7">
                        <input class="form-control" type="password" placeholder="Change password" name="user_password" id="user_password" maxlength="30">
                     </div>
                  </div>
                  <div class="form-group" id="ftp_user_div">
                     <label class="col-md-4 control-label">Select Jobs</label>
                     <div class="col-md-7">
                        <select id="jobs" name="jobs[]" multiple="multiple" size="10" class="form-control" style="width:300px">
                          <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobkey => $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option value="<?php echo e($job->job_id); ?>" <?php if(in_array($job->job_id, $arr_job_ids)): ?> selected <?php endif; ?>><?php echo e($job->job_name); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-4"></div>
                     <div class="col-md-7">
                        <button class="btn btn-success form-control" id="addgroupdata" name="add_user"><i class="fa fa-save"></i> Update</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- END dashboard main content-->
   </div>
</div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
   
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>