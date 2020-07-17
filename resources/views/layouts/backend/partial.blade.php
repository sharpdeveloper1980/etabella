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



                <li class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">

                    <a href="{{ route('dashboard') }}" title="Files">

                        <em class="fa fa-file"></em>

                        <span>Files</span>

                    </a>

                </li>



                @if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2)

                <li class="{{ Request::segment(2) == 'groups' ? 'active' : '' }}">

                    <a href="{{ route('groups') }}" title="Groups">



                        <em class="fa fa-users"></em>

                        <span>Groups</span>

                    </a>

                </li>

                @endif



                @if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2)

                <li class="{{ Request::segment(2) == 'jobs' ? 'active' : '' }}">

                    <a href="{{ route('jobs') }}" title="Jobs">



                        <em class="fa fa-briefcase"></em>

                        <span>Jobs</span>

                    </a>

                </li>

                @endif



                @if(Auth::user()->user_role == '111')

                <li class="{{ Request::segment(2) == 'admins' && Request::segment(3) != 'admin_log' ? 'active' : '' }}">

                    <a href="{{ route('adminAdmins') }}" title="Admins">

                        <div id="online_users" class="pull-right label label-warning hide">0</div>

                        <em class="icon-people"></em>

                        <span>Admins</span>

                    </a>

                </li>

                <li class="{{ Request::segment(2) == 'admins' && Request::segment(3) == 'admin_log' ? 'active' : '' }}">

                    <a href="{{ route('adminActivityLog') }}" title="Admins">

                        <div id="online_users" class="pull-right label label-warning hide">0</div>

                        <em class="icon-people"></em>

                        <span>Admin Activity Log</span>

                    </a>

                </li>

                @endif



                @if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2)

                <li class="{{ Request::segment(2) == 'clients' && Request::segment(3) == 'client_log' ? 'active' : '' }}">

                    <a href="{{ route('clientActivityLog') }}" title="Admins">

                        <div id="online_users" class="pull-right label label-warning hide">0</div>

                        <em class="icon-people"></em>

                        <span>Client Activity Log</span>

                    </a>

                </li>

                @endif

                

                @if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2)

                <li class="{{ Request::segment(2) == 'clients' && Request::segment(3) != 'client_log' ? 'active' : '' }}">

                    <a href="{{ route('adminClients') }}" title="Clients">

                        <div id="online_users" class="pull-right label label-warning hide">0</div>

                        <em class="icon-people"></em>

                        <span>Clients</span>

                    </a>

                </li>

                @endif



                @if(Auth::user()->user_level == 1 || Auth::user()->user_level == 2)

                <li class="{{ Request::segment(2) == 'settings' ? 'active' : '' }}">

                    <a href="#settings" title="Settings" data-toggle="collapse">

                        <em class="icon-settings"></em>

                        <span>Settings</span>

                    </a>

                    <ul id="settings" class="nav sidebar-subnav collapse">

                        <li class="{{ Request::segment(3) == 'change_password' ? 'active' : '' }}">

                            <a href="{{ route('changePassword') }}" title="Change Password">

                                <em class="icon-key"></em>

                                <span>Change Password</span>

                            </a>

                        </li>

                        <li class="{{ Request::segment(3) == 'ftp' ? 'active' : '' }}">

                            <a href="{{ route('Ftp') }}" title="FTP Settings">

                                <em class="icon-energy"></em>

                                <span>FTP Settings</span>

                            </a>

                        </li>

                    </ul>

                </li>

                @endif

                

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