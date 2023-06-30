<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('home')}}">
            <div class="logo-img">
               <img height="30" src="{{ asset('img/logo_white.png')}}" class="header-brand-img" title="RADMIN"> 
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp
    
    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-lavel">{{__('Home')}}</div>
                {{-- αυτό σημαίνει translation αν υπάρχει --}}
                <div class="nav-item {{ ($segment1 == 'dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}"><i class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard')}}</span></a>
                </div>

                <div class="nav-item {{ ($segment1 == 'myprofile') ? 'active' : '' }}">
                <a href="{{url('myprofile')}}"><i class="ik ik-user"></i><span>{{ __('My Profile')}}</span></a>
                </div>
                @can('manage_user')
                    <div class="nav-lavel">{{ __('Administration')}} </div>
             
                <div class="nav-item {{ ($segment1 == 'users' || $segment1 == 'roles'||$segment1 == 'permission' ||$segment1 == 'user'||$segment1 == 'app_settings') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-users"></i><span>{{ __('Administrator')}}</span></a>
                    <div class="submenu-content">
                         <!-- only those have manage_user permission will get access -->
                        
                        <a href="{{url('users')}}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('Users')}}</a>
                        <a href="{{url('user/create')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add User')}}</a>
                       
                         <!-- only those have manage_role permission will get access -->
                  
                        <a href="{{url('roles')}}" class="menu-item {{ ($segment1 == 'roles') ? 'active' : '' }}">{{ __('Roles')}}</a>
                    
                        <!-- only those have manage_permission permission will get access -->
                       
                        <a href="{{url('permission')}}" class="menu-item {{ ($segment1 == 'permission') ? 'active' : '' }}">{{ __('Permission')}}</a>

                    <a href="{{url('app_settings')}}" class="menu-item {{ ($segment1 == 'app_settings') ? 'active' : '' }}">{{ __('Settings')}}</a>
                    </div>
                </div>
                @endcan



                {{-- <div class="nav-lavel">{{ __('Support1') }} </div> --}}
                <div class="nav-lavel">{{ __('Technical Directives') }} </div>

                <!-- start support pages -->

                <div class="nav-item">
                {{-- <div class="nav-item {{ ($segment1 == 'technical_directives' ) ? 'active open' : '' }} has-sub"> --}}
                    {{-- <a href="#"><i class="ik ik-mail"></i><span>{{ __('Technical Directives')}}</span></a> --}}
                    {{-- <div class="submenu-content"> --}}
                    @can('manage_user') <a href="{{route('directives.create')}}" class="menu-item {{ ($segment1 == 'technical_directives' && $segment2 == 'create') ? 'active' : '' }}"><i class="ik ik-mail"></i>{{ __('New Directive')}}</a>@endcan
                    <a href="{{route('directives.index')}}" class="menu-item {{ ($segment1 == 'technical_directives' && $segment2 == 'list') ? 'active' : '' }}"><i class="ik ik-mail"></i>{{ __('Directives List')}}</a>
                    {{-- </div> --}}
                </div>
              
                @can('manage_user')  <div class="nav-item {{ ($segment1 == 'support_tickets') ? 'active open' : '' }} has-sub">
                      <!-- <a href="#"><i class="ik ik-life-buoy"></i><span>{{ __('Support Tickets')}}</span></a>
                     
                    <div class="submenu-content">
                        <a href="{{url('support_tickets/create')}}" class="menu-item {{ ($segment1 == 'support_tickets' && $segment2 == 'create') ? 'active' : '' }}">{{ __('New Ticket')}}</a>
                        <a href="#" class="menu-item {{ ($segment1 == 'support_tickets' && $segment2 == '') ? 'active' : '' }}">{{ __('List Tickets')}}</a>
                    </div> -->
                </div>@endcan

                
                <div class="nav-lavel">{{ __('Technical Cases') }} </div>
                <div class="nav-item">
                {{-- <div class="nav-item {{ ($segment1 == 'technical_reports') ? 'active open' : '' }} has-sub"> --}}
                    {{-- <a href="#"><i class="ik ik-file-text"></i><span>{{ __('Technical Reports')}}</span></a> --}}
                    {{-- <div class="submenu-content"> --}}
                        <a href="{{route('cases.create')}}" class="menu-item {{ ($segment1 == 'technical_cases' && $segment2 == 'create') ? 'active' : '' }}"><i class="ik ik-life-buoy"></i>{{ __('New Case')}}</a>
                        <a href="{{route('cases.index')}}" class="menu-item {{ ($segment1 == 'technical_cases' && $segment2 == 'list') ? 'active' : '' }}"><i class="ik ik-life-buoy"></i>{{ __('List of Cases')}}</a>
                    {{-- </div> --}}
                </div>
                  
                @can('manage_user') <div class="nav-item {{ ($segment1 == 'warranty_claims' ) ? 'active open' : '' }} has-sub">
                   <!--  <a href="#"><i class="ik ik-settings"></i><span>{{ __('Warranty Claims')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{url('warranty_claims/create')}}" class="menu-item {{ ($segment1 == 'warranty_claims' && $segment2 == 'create') ? 'active' : '' }}">{{ __('New Claim')}}</a>
                        <a href="#" class="menu-item {{ ($segment1 == 'warranty_claims' && $segment2 == '') ? 'active' : '' }}">{{ __('List Claims')}}</a>
                    </div> -->
                </div>@endcan



                <!-- end support pages -->






                @can('manage_user')

                <!-- start report pages -->


                <div class="nav-lavel">{{ __('Reports')}} </div>
                

                <div class="nav-item">
               {{-- <div class="nav-item {{ ($segment1 == 'reports') ? 'active open' : '' }} has-sub"> --}}
                    {{-- <a href="#"><i class="ik ik-file-text"></i><span>{{ __('Reports per VIN')}}</span></a> --}}
                    {{-- <div class="submenu-content"> --}}
                        {{-- <a href="{{url('reports/vin_search')}}" class="menu-item {{ ($segment1 == 'reports' && $segment2 == 'vin_search') ? 'active' : '' }}">{{ __('Vehicle History')}}</a> --}}
                        <a href="{{url('reports/vin_search')}}" class="menu-item "><i class="ik ik-file-text"></i>{{ __('Reports per VIN')}}</a>
                    {{-- </div> --}}
                </div>

               <!-- end report pages -->


               @endcan








                
        </div>
    </div>
</div>