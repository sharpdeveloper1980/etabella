<?php $__env->startSection('title','Client Login'); ?>



<?php $__env->startSection('content'); ?>
<style>
@media  screen and (max-device-width: 360px) {
	#login-form {
    width: 314px !important;
}
}
</style>
<div id="login-form" class="login_form">

    <h3>Client <?php echo e(__('Login')); ?></h3>

    <fieldset>

        <form method="POST" action="<?php echo e(route('postClientLogin')); ?>" aria-label="<?php echo e(__('Login')); ?>" id="loginform">

                        <?php echo csrf_field(); ?>

                <input id="user_name" type="text" class="form-control<?php echo e($errors->has('user_name') ? ' is-invalid' : ''); ?>" name="user_name"  placeholder="Username" value="<?php if($client_username): ?><?php echo e($client_username); ?><?php else: ?><?php echo e(old('user_name')); ?><?php endif; ?>" required autofocus>

                                <?php if($errors->has('user_name')): ?>

                                    <span class="invalid-feedback" role="alert">

                                        <strong><?php echo e($errors->first('user_name')); ?></strong>

                                    </span>

                                <?php endif; ?>

                <br>

                <br>

                <input id="user_password" type="password" class="form-control<?php echo e($errors->has('user_password') ? ' is-invalid' : ''); ?>" name="user_password" placeholder="Password" value="<?php echo e($client_password); ?>" required>



                                <?php if($errors->has('user_password')): ?>

                                    <span class="invalid-feedback" role="alert">

                                        <strong><?php echo e($errors->first('user_password')); ?></strong>

                                    </span>

                                <?php endif; ?>
                <div>
                <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php if($client_username): ?> <?php echo e($client_username ? 'checked' : ''); ?> <?php else: ?> <?php echo e(old('remember') ? 'checked' : ''); ?>  <?php endif; ?>>



                                    <label class="form-check-label" for="remember">

                                        <?php echo e(__('Remember Me')); ?>


                                    </label><br>
                                </div>
                <input type="submit" value="<?php echo e(__('Login')); ?>">

                <!--<footer class="clearfix">

                    <p><span class="info">?</span><a href="#">Forgot Password</a></p>

                </footer>

                -->

        </form>

    </fieldset>

</div> <!-- end login-form -->

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.login_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>