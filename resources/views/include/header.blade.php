<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                





            </div>
            <div class="top-menu d-flex align-items-center">
                
            <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>




                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="{{auth()->user()->avatarURL()}}" alt=""></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        
                        <a class="dropdown-item" href="{{ url('logout') }}">
                            <i class="ik ik-power dropdown-icon"></i> 
                            {{ __('Logout')}}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>