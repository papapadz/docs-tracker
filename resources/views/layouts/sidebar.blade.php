<nav class="sidebar col-xs-12 col-sm-4 col-lg-3 col-xl-2 bg-faded sidebar-style-1" style="background-color: #FFA700;">
				<h1 class="site-title"><a href="#"><em class="fa fa-rocket"></em> DOG COACH FRANCIS</a></h1>
				
				<a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><em class="fa fa-bars"></em></a>
				
				<ul class="nav nav-pills flex-column sidebar-nav">
					
                    <li class="nav-item"><a @if($activeLink == 'home') class="nav-link active" @else class="nav-link" @endif href="{{ url('admin/home') }}"><em class="fa fa-dashboard"></em> Dashboard <span class="sr-only"></span></a></li>
					
                    <li class="nav-item"><a @if($activeLink == 'petinfo') class="nav-link active" @else class="nav-link" @endif href="{{ url('admin/petinfo') }}"><em class="fa fa-paw"></em> Pets <span class="sr-only"></span></a></li>
					
                    <li class="nav-item"><a @if($activeLink == 'userinfo') class="nav-link active" @else class="nav-link" @endif href="{{ url('admin/userinfo') }}"><em class="fa fa-user-circle"></em> Pet Parents <span class="sr-only"></span></a></li>
                    
                    <li class="nav-item"><a @if($activeLink == 'staffinfo') class="nav-link active" @else class="nav-link" @endif href="{{ url('admin/staffinfo') }}"><em class="fa fa-users"></em> Staff <span class="sr-only"></span></a></li>
					
				</ul>
				
				<a href="#" class="logout-button"><em class="fa fa-power-off"></em> Signout</a>
            </nav>