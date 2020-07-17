<!-- sidebar-->

<aside class="aside">

    <!-- START Sidebar (left)-->

    <div class="aside-inner">

        <nav data-sidebar-anyclick-close="" class="sidebar">

            <!-- START sidebar nav-->

            <ul class="nav">

                <!-- Iterates over all sidebar items-->

                <li class="nav-heading ">

                    <span data-localize="sidebar.heading.HEADER">Main Navigation</span>

                </li>



                <li class="<?php echo e(Request::segment(2) == 'dashboard' ? 'active' : ''); ?>">

                    <a href="<?php echo e(route('dashboard')); ?>" title="Files">

                        <em class="fa fa-file"></em>

                        <span>Files</span>

                    </a>

                </li>



                <?php if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2): ?>

                <li class="<?php echo e(Request::segment(2) == 'groups' ? 'active' : ''); ?>">

                    <a href="<?php echo e(route('groups')); ?>" title="Groups">



                        <em class="fa fa-users"></em>

                        <span>Groups</span>

                    </a>

                </li>

                <?php endif; ?>



                <?php if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2): ?>

                <li class="<?php echo e(Request::segment(2) == 'jobs' ? 'active' : ''); ?>">

                    <a href="<?php echo e(route('jobs')); ?>" title="Jobs">



                        <em class="fa fa-briefcase"></em>

                        <span>Jobs</span>

                    </a>

                </li>

                <?php endif; ?>



                <?php if(Auth::user()->user_role == '111'): ?>

                <li class="<?php echo e(Request::segment(2) == 'admins' && Request::segment(3) != 'admin_log' ? 'active' : ''); ?>">

                    <a href="<?php echo e(route('adminAdmins')); ?>" title="Admins">

                        <div id="online_users" class="pull-right label label-warning hide">0</div>

                        <em class="icon-people"></em>

                        <span>Admins</span>

                    </a>

                </li>

                <li class="<?php echo e(Request::segment(2) == 'admins' && Request::segment(3) == 'admin_log' ? 'active' : ''); ?>">

                    <a href="<?php echo e(route('adminActivityLog')); ?>" title="Admins">

                        <div id="online_users" class="pull-right label label-warning hide">0</div>

                        <em class="icon-people"></em>

                        <span>Admin Activity Log</span>

                    </a>

                </li>

                <?php endif; ?>



                <?php if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2): ?>

                <li class="<?php echo e(Request::segment(2) == 'clients' && Request::segment(3) == 'client_log' ? 'active' : ''); ?>">

                    <a href="<?php echo e(route('clientActivityLog')); ?>" title="Admins">

                        <div id="online_users" class="pull-right label label-warning hide">0</div>

                        <em class="icon-people"></em>

                        <span>Client Activity Log</span>

                    </a>

                </li>

                <?php endif; ?>

                

                <?php if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2): ?>

                <li class="<?php echo e(Request::segment(2) == 'clients' && Request::segment(3) != 'client_log' ? 'active' : ''); ?>">

                    <a href="<?php echo e(route('adminClients')); ?>" title="Clients">

                        <div id="online_users" class="pull-right label label-warning hide">0</div>

                        <em class="icon-people"></em>

                        <span>Clients</span>

                    </a>

                </li>

                <?php endif; ?>



                <?php if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2): ?>

                <li class="<?php echo e(Request::segment(2) == 'settings' ? 'active' : ''); ?>">

                    <a href="#settings" title="Settings" data-toggle="collapse">

                        <em class="icon-settings"></em>

                        <span>Settings</span>

                    </a>

                    <ul id="settings" class="nav sidebar-subnav collapse">

                        <li class="<?php echo e(Request::segment(3) == 'change_password' ? 'active' : ''); ?>">

                            <a href="<?php echo e(route('changePassword')); ?>" title="Change Password">

                                <em class="icon-key"></em>

                                <span>Change Password</span>

                            </a>

                        </li>

                        <li class="<?php echo e(Request::segment(3) == 'ftp' ? 'active' : ''); ?>">

                            <a href="<?php echo e(route('Ftp')); ?>" title="FTP Settings">

                                <em class="icon-energy"></em>

                                <span>FTP Settings</span>

                            </a>

                        </li>

                    </ul>

                </li>

                <?php endif; ?>

                

                <li class="">

                    <a href="<?php echo e(route('logout')); ?>"

                        onclick="event.preventDefault();

                        document.getElementById('logout-form').submit();">

                        <em class="icon-power"></em>

                        <span><?php echo e(__('Logout')); ?></span>

                     </a>

                     <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">

                        <?php echo csrf_field(); ?>

                     </form>

                </li>

            </ul>

            <!-- END sidebar nav-->

        </nav>

    </div>

    <!-- END Sidebar (left)-->

</aside>