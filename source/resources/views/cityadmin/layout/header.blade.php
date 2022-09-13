 	<!-- BEGIN #header -->
		<div id="header" class="app-header">
			<!-- BEGIN mobile-toggler -->
			<div class="mobile-toggler">
				<button type="button" class="menu-toggler" data-toggle="sidebar-mobile">
					<span class="bar"></span>
					<span class="bar"></span>
				</button>
			</div>
			<!-- END mobile-toggler -->
			
			<!-- BEGIN brand -->
			<div class="brand">
				<div class="desktop-toggler">
					<button type="button" class="menu-toggler" data-toggle="sidebar-minify">
						<span class="bar"></span>
						<span class="bar"></span>
					</button>
				</div>
				
				<a href="#" class="brand-logo">
					
					<h4>Havadhi</h4>
				</a>
			</div>
			<!-- END brand -->
			
			<!-- BEGIN menu -->
			<div class="menu">
				<form class="menu-search" method="POST" name="header_search_form">
				</form>
				<div class="menu-item dropdown">
					
						
						
				</div>
				<div class="menu-item dropdown">
					<a href="#" data-toggle="dropdown" data-display="static" class="menu-link">
						<div class="menu-img online">
							<img src="{{url($cityadmin->cityadmin_image)}}" alt="" class="mw-100 mh-100 rounded-circle" />
						</div>
						<div class="menu-text">{{$cityadmin->cityadmin_name}}</div>
					</a>
					<div class="dropdown-menu dropdown-menu-right mr-lg-3">
						<a class="dropdown-item d-flex align-items-center" href="{{route('cityadmin-logout')}}">Log Out <em style="width:100% !important; float:right !important" class="fas fa-sign-out-alt fa-fw ml-auto text-gray-400 f-s-16"></em></a>
					</div>
				</div>
			</div>
			<!-- END menu -->
		</div>
		<!-- END #header -->   






