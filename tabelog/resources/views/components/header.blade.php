


<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

            <div class="navbar navbar-expand-lg bg-light navbar-light">
                <div class="container-fluid">
                    <a href="{{route('home')}}" class="navbar-brand">Tabelog</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
        
                    <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
                        <div class="navbar-nav ml-auto">
                            <a href="{{route('home')}}" class="nav-item nav-link active">Home</a>
                          
                            
                        @guest
                        <a href="{{route('login')}}" class="nav-item nav-link">Login</a>    
                        <a href="{{route('auth.register')}}" class="nav-item nav-link">Register</a>    
                        @endguest
                            
                            @auth
                            <a href="{{route('booking')}}" class="nav-item nav-link">Booking</a>
                                
                            @endauth
          
                            @auth
                            {{-- @if(Auth::user()->token == '') --}}
                            <a href="{{route('mypage.register_card')}}" class="nav-item nav-link">My payment Card </a>
                            
                            {{-- @endif --}}
                            @endauth
                            @auth
                            {{-- @if(Auth::user()->user_type == 'normal' && !Auth::user()->token == '') --}}
                            <a href="{{route('users.apply_permium')}}" class="nav-item nav-link">Premium </a>
                            
                            {{-- @endif --}}
                            @endauth
                          
                            @auth

                            <a href="{{route('profile')}}" class="nav-item nav-link">Profile</a>
                            @endauth
                            @auth

                            <a href="{{route('logout')}}" class="nav-item nav-link">Logout</a>
                            @endauth

                         
                        </div>
                    </div>
                </div>
            </div>