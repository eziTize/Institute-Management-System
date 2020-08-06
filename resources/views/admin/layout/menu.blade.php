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

                        <li><a href="{{ Asset(env('admin').'/setting') }}"><i class="mdi-action-settings"></i> Settings</a></li>

                        <li><a href="{{ Asset(env('admin').'/logout') }}"><i class="mdi-hardware-keyboard-tab"></i> Logout</a></li>

                    </ul>

                    <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">Welcome <i class="mdi-navigation-arrow-drop-down right"></i></a>

                    <p class="user-roal">{{ Auth::guard('admin')->user()->name }}</p>

                </div>

            </div>

        </li>



        <?php /*<li class="<?php if($page == "dashboard"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/dashboard') }}" class="waves-effect waves-cyan"><i class="fa fa-dashboard" style="font-size:16px"></i> Dashboard</a></li>*/ ?>



        <li>

            <ul class="collapsible collapsible-accordion">

                <li>

                    <a class="collapsible-header waves-effect waves-cyan <?php if($page == 'dashboard' || $page == 'settings' || $page == 'fee-settings'){ ?> active <?php } ?>"><i class="fa fa-dashboard"></i> Dashboard</a>

                    <div class="collapsible-body">

                        <ul>

                            <li class="<?php if($page == "dashboard"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/dashboard') }}"><i class="fa fa-dashboard" style="font-size:16px"></i> Dashboard</a></li>

                            <li class="<?php if($page == "settings"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/settings') }}"><i class="fa fa-cog" style="font-size:16px"></i> Profile Settings</a></li>

                            <li class="<?php if($page == "fee-settings"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/fee-settings') }}"><i class="fa fa-money" style="font-size:16px"></i> Fee Settings</a></li>



                        </ul>

                    </div>

                </li>

            </ul>

        </li>






        <li>

            <ul class="collapsible collapsible-accordion">

                <li>

                    <a class="collapsible-header waves-effect waves-cyan <?php if($page == 'branch' || $page == 'telecaller' || $page == 'tpo' || $page =='marketing_person' || $page == 'teacher'){ ?> active <?php } ?>"><i class="fa fa-users"></i> Manage Users</a>

                    <div class="collapsible-body">

                        <ul>

                            <li class="<?php if($page == "branch"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/branch') }}"><i class="fa fa-user" style="font-size:16px"></i> Branch</a></li>

                            <li class="<?php if($page == "telecaller"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/telecaller') }}"><i class="fa fa-user" style="font-size:16px"></i> Telecaller / Counsellor</a></li>

                            <li class="<?php if($page == "tpo"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/tpo') }}"><i class="fa fa-user" style="font-size:16px"></i> Tpo / Company HR</a></li>

                            <li class="<?php if($page == "marketing_person"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/marketing_person') }}"><i class="fa fa-user" style="font-size:16px"></i> Marketing Person</a></li>

                            <li class="<?php if($page == "teacher"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/teacher') }}"><i class="fa fa-user" style="font-size:16px"></i> Teacher</a></li>

                        </ul>

                    </div>

                </li>

            </ul>

        </li>

        <li class="<?php if($page == "notifications"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/notifications') }}" class="waves-effect waves-cyan"><i class="fa fa-bell" style="font-size:16px"></i> Notifications </a></li>



        <li class="<?php if($page == "course"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/course') }}" class="waves-effect waves-cyan"><i class="mdi-av-my-library-books" style="font-size:16px"></i> Course</a></li>

        

        <li class="<?php if($page == "batch"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/batch') }}" class="waves-effect waves-cyan"><i class="mdi-social-group" style="font-size:16px"></i> Batch</a></li>


         <li class="<?php if($page == "fees"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/fees') }}" class="waves-effect waves-cyan"><i class="fa fa-money" style="font-size:16px"></i> Fees</a></li>


          <li class="<?php if($page == "marksheet"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/marksheet') }}" class="waves-effect waves-cyan"><i class="fa fa-copy" style="font-size:16px"></i> Marksheet</a></li>

        
            <li>
            <ul class="collapsible collapsible-accordion">
            <li>
            <a class="collapsible-header waves-effect waves-cyan <?php if($page == 'complaints' || $page == 'feedbacks' || $page == 'applications'){ ?> active <?php } ?>"><i class="mdi-action-help"></i> Student Helpdesk</a>
            <div class="collapsible-body">
            <ul>
            <li class="<?php if($page == "complaints"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/complaints') }}"><i class="mdi-action-settings-voice" style="font-size:16px"></i> Lodge Complaints</a></li>
            <li class="<?php if($page == "feedbacks"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/feedbacks') }}"><i class="mdi-action-speaker-notes" style="font-size:16px"></i> Give Feedbacks</a></li>
            <li class="<?php if($page == "applications"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/applications') }}"><i class="mdi-action-view-list" style="font-size:16px"></i> Raise Applications</a></li>
            </ul>
            </div>
            </li>
            </ul>
            </li>


        <li class="<?php if($page == "enquiry_src"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/enquiry_src') }}" class="waves-effect waves-cyan"><i class="mdi-action-search" style="font-size:16px"></i> Enquiry Source</a></li>

        <li class="<?php if($page == "enquiry_leads"){ echo "active"; } ?>"><a href="{{ Asset(env('admin').'/enquiry_leads') }}" class="waves-effect waves-cyan"><i class="mdi-action-info-outline" style="font-size:16px"></i> Enquiry Leads</a></li>

        

        <li><a href="{{ Asset(env('admin').'/logout') }}" class="waves-effect waves-cyan"><i class="fa fa-sign-out" style="font-size:16px"></i> Logout</a></li>

    </ul>



    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>

</aside>