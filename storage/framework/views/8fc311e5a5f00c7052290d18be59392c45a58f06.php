<?php $__env->startSection('title','Login'); ?>

<?php $__env->startSection('content'); ?>
<div id="login-form">
    <h3>Admin <?php echo e(__('Login')); ?></h3>
    <fieldset>
        <form method="POST" action="<?php echo e(route('login')); ?>" aria-label="<?php echo e(__('Login')); ?>" id="loginform">
                        <?php echo csrf_field(); ?>
                <input id="user_name" type="text"  placeholder="Username" class="form-control<?php echo e($errors->has('user_name') ? ' is-invalid' : ''); ?>" name="user_name" value="<?php echo e(old('user_name')); ?>" required autofocus>
                                <?php if($errors->has('user_name')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('user_name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                <br>
                <br>
                <input id="user_password" type="password" placeholder="Password" class="form-control<?php echo e($errors->has('user_password') ? ' is-invalid' : ''); ?>" name="user_password" required value="<?php echo e(old('user_password')); ?>">

                                <?php if($errors->has('user_password')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('user_password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                <label class="form-check-label" for="remember">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e($username ? 'checked' : ''); ?>>

                                        <?php echo e(__('Remember Me')); ?>

                                    </label><br>
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