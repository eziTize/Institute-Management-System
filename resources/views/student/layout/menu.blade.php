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

                        <li><a href="{{ Asset(env('student').'/setting') }}"><i class="mdi-action-settings"></i> Settings</a></li>

                        <li><a href="{{ Asset(env('student').'/logout') }}"><i class="mdi-hardware-keyboard-tab"></i> Logout</a></li>

                    </ul>

                    <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">Welcome <i class="mdi-navigation-arrow-drop-down right"></i></a>

                    <p class="user-roal">{{ Auth::guard('student')->user()->name }}</p>

                </div>

            </div>

        </li>



        <li>

            <ul class="collapsible collapsible-accordion">

                <li>

                    <a class="collapsible-header waves-effect waves-cyan <?php if($page == 'dashboard' || $page == 'settings'){ ?> active <?php } ?>"><i class="fa fa-dashboard"></i> Dashboard</a>

                    <div class="collapsible-body">

                        <ul>

                            <li class="<?php if($page == "dashboard"){ echo "active"; } ?>"><a href="{{ Asset(env('student').'/dashboard') }}"><i class="fa fa-dashboard" style="font-size:16px"></i> Dashboard</a></li>

                            <li class="<?php if($page == "settings"){ echo "active"; } ?>"><a href="{{ Asset(env('student').'/settings') }}"><i class="fa fa-cog" style="font-size:16px"></i> Profile Settings</a></li>

                        </ul>

                    </div>

                </li>

            </ul>

        </li>



        <li>

            <ul class="collapsible collapsible-accordion">

                <li>

                    <a class="collapsible-header waves-effect waves-cyan <?php if($page == 'complaints' || $page == 'feedbacks' || $page == 'applications'){ ?> active <?php } ?>"><i class="mdi-action-help"></i> Student Helpdesk</a>

                    <div class="collapsible-body">

                        <ul>

                            <li class="<?php if($page == "complaints"){ echo "active"; } ?>"><a href="{{ Asset(env('student').'/complaints/add') }}"><i class="mdi-action-settings-voice" style="font-size:16px"></i> Lodge Complaints</a></li>

                            <li class="<?php if($page == "feedbacks"){ echo "active"; } ?>"><a href="{{ Asset(env('student').'/feedbacks/add') }}"><i class="mdi-action-speaker-notes" style="font-size:16px"></i> Give Feedbacks</a></li>

                            <li class="<?php if($page == "applications"){ echo "active"; } ?>"><a href="{{ Asset(env('student').'/applications/add') }}"><i class="mdi-action-view-list" style="font-size:16px"></i> Raise Applications</a></li>

                        </ul>

                    </div>

                </li>

            </ul>

        </li>



         <li class="<?php if($page == "notifications"){ echo "active"; } ?>"><a href="{{ Asset(env('student').'/notifications') }}" class="waves-effect waves-cyan"><i class="fa fa-bell" style="font-size:16px"></i> Notifications </a></li>



        <li class="<?php if($page == "getIDCard"){ echo "active"; } ?>"><a href="{{ Asset(env('student').'/getIDCard') }}" class="waves-effect waves-cyan"><i class="mdi-action-credit-card" style="font-size:16px"></i> Get ID Card</a></li>


        <li class="<?php if($page == "marksheet"){ echo "active"; } ?>"><a href="{{ Asset(env('student').'/marksheet') }}" class="waves-effect waves-cyan"><i class="fa fa-file" style="font-size:16px"></i> Marksheet </a></li>

        
        <li class="<?php if($page == "openings"){ echo "active"; } ?>"><a href="{{ Asset(env('student').'/openings') }}" class="waves-effect waves-cyan"><i class="fa fa-briefcase" style="font-size:16px"></i> Job Openings </a></li>


        <li class="<?php if($page == "job-offers"){ echo "active"; } ?>"><a href="{{ Asset(env('student').'/job-offers') }}" class="waves-effect waves-cyan"><i class="fa fa-envelope" style="font-size:16px"></i> Job Offers </a></li>


        <li><a href="{{ Asset(env('student').'/logout') }}" class="waves-effect waves-cyan"><i class="fa fa-sign-out" style="font-size:16px"></i> Logout</a></li>

    </ul>



    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>

</aside>