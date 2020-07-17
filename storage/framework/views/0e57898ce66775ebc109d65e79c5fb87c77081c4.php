<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('public/images/icon.png')); ?>">

    <title><?php echo $__env->yieldContent('title'); ?> - eTabella</title>
<!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="<?php echo e(asset('public/backend/vendor/fontawesome/css/font-awesome.min.css')); ?>">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="<?php echo e(asset('public/backend/vendor/simple-line-icons/css/simple-line-icons.css')); ?>">
   <!-- ANIMATE.CSS-->
   <link rel="stylesheet" href="<?php echo e(asset('public/backend/vendor/animate.css/animate.min.css')); ?>">
   <!-- WHIRL (spinners)-->
   <link rel="stylesheet" href="<?php echo e(asset('public/backend/vendor/whirl/dist/whirl.css')); ?>">
   <!-- =============== PAGE VENDOR STYLES ===============-->
   <!-- WEATHER ICONS-->
   <link rel="stylesheet" href="<?php echo e(asset('public/backend/vendor/weather-icons/css/weather-icons.min.css')); ?>">
   <link rel="stylesheet" href="<?php echo e(asset('public/backend/vendor/sweetalert/dist/sweetalert.css')); ?>">
   <link rel="stylesheet" href="<?php echo e(asset('public/backend/vendor/loaders.css/loaders.css')); ?>">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/bootstrap.css')); ?>" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/app.css')); ?>" id="maincss">
   <link rel="stylesheet" href="<?php echo e(asset('public/backend/css/theme-a.css')); ?>">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
   <link rel="stylesheet" href="<?php echo e(asset('public/frontend/ztree/css/zTreeStyle/zTreeStyle.css')); ?>" type="text/css"> 
   <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/frontend/css/daterangepicker.css')); ?>" />
   <!-- Datatable Css -->
      <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
      <!-- <link rel="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> -->
      <link rel="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
	  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />	
   <style type="text/css">
      th,td{
         font-size: 18px;
      }
      .file{
         margin-left:10px;
      }
      .separator{
         padding:5px;
      }
      .btn{
         font-size:16px;
      }
      input[type="file"] {
          display: none;
      }
   </style>
</head>
<body>
    <div class="wrapper">
      <!-- top navbar-->
      <header class="topnavbar-wrapper">
         <!-- START Top Navbar-->
         <nav role="navigation" class="navbar topnavbar">
            <!-- START navbar header-->
            <div class="navbar-header">
               <a href="#/" class="navbar-brand">
                  <div class="brand-logo">
                     <img src="<?php echo e(asset('public/img/logo.png')); ?>" alt="" class="img-responsive">
                  </div>
                  <div class="brand-logo-collapsed">
                     <img src="<?php echo e(asset('public/img/logo-single.png')); ?>" alt="" class="img-responsive">
                  </div>
               </a>
            </div>
            <!-- END navbar header-->
            <!-- START Nav wrapper-->
            <div class="nav-wrapper">
               <!-- START Left navbar-->
               <ul class="nav navbar-nav">
                  <li>
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a href="#" data-trigger-resize="" data-toggle-state="aside-collapsed" class="hidden-xs">
                        <em class="fa fa-navicon"></em>
                     </a>
                     <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                     <a href="#" data-toggle-state="aside-toggled" data-no-persist="true" class="visible-xs sidebar-toggle">
                        <em class="fa fa-navicon"></em>
                     </a>
                  </li>
               </ul>
               <!-- END Left navbar-->
               <!-- START Right Navbar-->
               <ul class="nav navbar-nav navbar-right">
                  <li>
                     <a href="#" data-search-open="">
                        <em class="icon-magnifier"></em>
                     </a>
                  </li>
                  <li>
                     <a href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <em class="icon-power"></em>
                     </a>
                     <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                     </form>
                  </li>
               </ul>
               <!-- END Right Navbar-->
            </div>
            <!-- END Nav wrapper-->
            <!-- START Search form-->
            <form role="search" action="" method="post" class="navbar-form">
               <div class="form-group has-feedback">
                  <input type="text" placeholder="Search User's Name" class="form-control" name="search">
                  <div data-search-dismiss="" class="fa fa-times form-control-feedback"></div>
               </div>
               <button type="submit" class="hidden btn btn-default">Submit</button>
            </form>
            <!-- END Search form--> 
         </nav>
         <!-- END Top Navbar-->
      </header>
         <?php echo $__env->make('layouts.backend.partial', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         <?php echo $__env->yieldContent('content'); ?>
      <footer>
          <span>&copy; 2019 - eTabella - Powered by LegalWare</span>
      </footer>
   </div>
   
   <!-- =============== VENDOR SCRIPTS ===============-->
   <!-- JQUERY-->
   <script src="<?php echo e(asset('public/backend/vendor/jquery/dist/jquery.js')); ?>"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
   <!-- STORAGE API-->
   <script src="<?php echo e(asset('public/backend/vendor/jQuery-Storage-API/jquery.storageapi.js')); ?>"></script>
   <!-- BOOTSTRAP-->
   <script src="<?php echo e(asset('public/backend/vendor/bootstrap/dist/js/bootstrap.js')); ?>"></script>
   <!-- ANIMO-->
   <script src="<?php echo e(asset('public/backend/vendor/animo.js/animo.js')); ?>"></script>
   <!-- SLIMSCROLL-->
   <script src="<?php echo e(asset('public/backend/vendor/slimScroll/jquery.slimscroll.min.js')); ?>"></script>
   <!-- LOCALIZE-->
   <script src="<?php echo e(asset('public/backend/vendor/jquery-localize-i18n/dist/jquery.localize.js')); ?>"></script>
   <!-- CLASSY LOADER-->
   <script src="<?php echo e(asset('public/backend/vendor/jquery-classyloader/js/jquery.classyloader.min.js')); ?>"></script>
   <!-- SWEET ALERT-->
   <script src="<?php echo e(asset('public/backend/vendor/sweetalert/dist/sweetalert.min.js')); ?>"></script>
   <!-- Ztree Scripts -->
      <script type="text/javascript" src="<?php echo e(asset('public/frontend/ztree/js/jquery.ztree.all.js')); ?>"></script>

      <script type="text/javascript" src="<?php echo e(asset('public/frontend/ztree/js/jquery.ztree.core.js')); ?>"></script>
      
      <script type="text/javascript" src="<?php echo e(asset('public/frontend/ztree/js/jquery.ztree.excheck.js')); ?>"></script>
      
      <script type="text/javascript" src="<?php echo e(asset('public/frontend/ztree/js/jquery.ztree.exedit.js')); ?>"></script>
      
      <script type="text/javascript" src="<?php echo e(asset('public/frontend/ztree/js/jquery.ztree.exhide.js')); ?>"></script>
      <!-- /***************/ -->

    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
   <!-- For Datatable Js -->
      <!-- <script src=" https://code.jquery.com/jquery-3.3.1.js"></script> -->
      <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
	  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>	
   <!-- =============== APP SCRIPTS ===============-->
   <script type="text/javascript">
       var APP_LINK = "<?php echo e(url('/')); ?>";
   </script>
   <script src="<?php echo e(asset('public/backend/js/demo/demo-flot.js')); ?>"></script>
   <!-- <script src="<?php echo e(asset('public/backend/js/app.js')); ?>"></script>
   <script src="<?php echo e(asset('public/backend/js/etabella.js')); ?>"></script> -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <?php echo Toastr::message(); ?>


    <script type="text/javascript">
      var baseurl = "<?php echo e(url('/')); ?>";
        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                toastr.error('<?php echo e($error); ?>','Error',{
                    "debug": false,
                });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </script>  
    <?php echo $__env->yieldContent('js'); ?>
</body>
</html>
