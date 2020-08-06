@php($page = Request::segment(2))

<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details cyan darken-2">
            <div class="row">
                <div class="col col s4 m4 l4">
                    <img src="{{ Asset('images/avatar.jpg') }}" alt="" class="circle responsive-img valign profile-image">
                </div>
                <div class="col col s8 m8 l8">
                    <ul id="profile-dropdown" class="dropdown-content">
                        <li><a href="{{ Asset(env('teacher').'/setting') }}"><i class="mdi-action-settings"></i> Settings</a></li>
                        <li><a href="{{ Asset(env('teacher').'/logout') }}"><i class="mdi-hardware-keyboard-tab"></i> Logout</a></li>
                    </ul>
                    <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">Welcome <i class="mdi-navigation-arrow-drop-down right"></i></a>
                    <p class="user-roal">{{ Auth::guard('teacher')->user()->name }}</p>
                </div>
            </div>
        </li>

        <?php /*<li class="<?php if($page == "dashboard"){ echo "active"; } ?>"><a href="{{ Asset(env('teacher').'/dashboard') }}" class="waves-effect waves-cyan"><i class="fa fa-dashboard" style="font-size:16px"></i> Dashboard</a></li>*/ ?>

        <li>
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header waves-effect waves-cyan <?php if($page == 'dashboard' || $page == 'settings'){ ?> active <?php } ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    <div class="collapsible-body">
                        <ul>
                            <li class="<?php if($page == "dashboard"){ echo "active"; } ?>"><a href="{{ Asset(env('teacher').'/dashboard') }}"><i class="fa fa-dashboard" style="font-size:16px"></i> Dashboard</a></li>
                            <li class="<?php if($page == "settings"){ echo "active"; } ?>"><a href="{{ Asset(env('teacher').'/settings') }}"><i class="fa fa-cog" style="font-size:16px"></i> Profile Settings</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>


        <li class="<?php if($page == "notifications"){ echo "active"; } ?>"><a href="{{ Asset(env('teacher').'/notifications') }}" class="waves-effect waves-cyan"><i class="fa fa-bell" style="font-size:16px"></i> Notifications </a></li>

        <li class="<?php if($page == "task"){ echo "active"; } ?>"><a href="{{ Asset(env('teacher').'/task') }}" class="waves-effect waves-cyan"><i class="mdi-action-assignment" style="font-size:16px"></i> Task Tracker</a></li>

        <li><a href="{{ Asset(env('teacher').'/logout') }}" class="waves-effect waves-cyan"><i class="fa fa-sign-out" style="font-size:16px"></i> Logout</a></li>
    </ul>

    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
</aside>