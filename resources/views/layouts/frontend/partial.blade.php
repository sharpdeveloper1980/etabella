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

                <li class="{{ Request::segment(1) == 'home' ? 'active' : '' }}">
                    <a href="{{ route('home') }}" title="Files">
                        <em class="fa fa-file"></em>
                        <span>Files</span>
                    </a>
                </li>

                <li class="{{ Request::segment(1) == 'groups' ? 'active' : '' }}">
                    <a href="{{ route('groups') }}" title="Groups">

                        <em class="fa fa-users"></em>
                        <span>Groups</span>
                    </a>
                </li>
                <li class="{{ Request::segment(1) == 'jobs' ? 'active' : '' }}">
                    <a href="{{ route('jobs') }}" title="Jobs">

                        <em class="fa fa-briefcase"></em>
                        <span>Jobs</span>
                    </a>
                </li>
                <li class="{{ Request::segment(1) == 'clients' ? 'active' : '' }}">
                    <a href="{{ route('clients') }}" title="Clients">
                        <div id="online_users" class="pull-right label label-warning hide">0</div>
                        <em class="icon-people"></em>
                        <span>Clients</span>
                    </a>
                </li>

                <li class="{{ Request::segment(1) == 'settings' ? 'active' : '' }}">
                    <a href="#settings" title="Settings" data-toggle="collapse">
                        <em class="icon-settings"></em>
                        <span>Settings</span>
                    </a>
                    <ul id="settings" class="nav sidebar-subnav collapse">
                        <li class="{{ Request::segment(2) == 'change_password' ? 'active' : '' }}">
                            <a href="{{ route('changePassword') }}" title="Change Password">
                                <em class="icon-key"></em>
                                <span>Change Password</span>
                            </a>
                        </li>
                        <li class="{{ Request::segment(2) == 'ftp' ? 'active' : '' }}">
                            <a href="{{ route('Ftp') }}" title="FTP Settings">
                                <em class="icon-energy"></em>
                                <span>FTP Settings</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <em class="icon-power"></em>
                        <span>{{ __('Logout') }}</span>
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                     </form>
                </li>
            </ul>
            <!-- END sidebar nav-->
        </nav>
    </div>
    <!-- END Sidebar (left)-->
</aside>