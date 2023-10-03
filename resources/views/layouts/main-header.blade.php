<!-- Main Wrapper -->
<div class="main-wrapper">
	
	<!-- Header -->
	<div class="header">
	
		<!-- Logo -->
		<div class="header-left">
			<a href="index" class="logo">
				<img src="../assets_admin/img/logo.png" alt="Logo">
			</a>
			<a href="index" class="logo logo-small">
				<img src="../assets_admin/img/logo-small.png" alt="Logo" width="30" height="30">
			</a>
			<!-- Sidebar Toggle -->
			<a href="javascript:void(0);" id="toggle_btn">
				<i class="feather-chevrons-left"></i>
			</a>
			<!-- /Sidebar Toggle -->
			
			<!-- Mobile Menu Toggle -->
			<a class="mobile_btn" id="mobile_btn">
				<i class="feather-chevrons-left"></i>
			</a>
			<!-- /Mobile Menu Toggle -->
		</div>
		<!-- /Logo -->
		
		<!-- Search -->
		<div class="top-nav-search">
			<!-- <form>
				<input type="text" class="form-control" placeholder="Start typing your Search...">
				<button class="btn" type="submit"><i class="feather-search"></i></button>
			</form> -->
		</div>
		<!-- /Search -->
		
		<!-- Header Menu -->
		<ul class="nav user-menu">

			<!-- Start Notifications -->
			@can('الإشعارات')
				<li class="nav-item dropdown">
					<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
						<i class="feather-bell"></i> 
							@if(auth()->user()->unreadNotifications->count() > 0)
								<span class="badge badge-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
							@endif
					</a>
					<div class="dropdown-menu notifications">
						<div class="topnav-dropdown-header">
							<span class="notification-title">{{ trans('main.Notifications') }}</span>
							<a href="{{ route('markAllAsRead') }}" class="clear-noti">{{ trans('main.Mark All Read') }}</a>
						</div>
						<div class="noti-content">
							<ul class="notification-list">
								@foreach (auth()->user()->unreadNotifications as $notification)
									<li class="notification-message">
										<a href="{{ url('admin/'.$notification->data['route'].'/'.$notification->id) }}">
											<div class="media d-flex">
												<div class="avatar avatar-sm flex-shrink-0">
													<span class="avatar-title rounded-circle bg-info-light"><i class="far fa-comment"></i></span>
												</div>
												<div class="media-body flex-grow-1">
													<p class="noti-details"><span class="noti-title">{{ $notification->data['title'] }} {{ $notification->data['user'] }}</span></p>
													<p class="noti-time"><span class="notification-time">{{ $notification->created_at }}</span></p>
												</div>
											</div>
										</a>
									</li>
								@endforeach
							</ul>
						</div>
						<div class="topnav-dropdown-footer">
							<a href="{{ route('allNotifications') }}">{{ trans('main.VIEW ALL') }}</a>
						</div>
					</div>
				</li>
			@endcan
			<!-- End Notifications -->
			
			<!-- User Menu -->
			<li class="nav-item dropdown has-arrow main-drop">
				<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
					<span class="user-img">
						<img src="../assets_admin/img/profiles/logo-01.png" alt="">
						<span class="status online"></span>
					</span>
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="profile"><i data-feather="user" class="mr-1"></i> Profile</a>
					<a class="dropdown-item" href="settings"><i data-feather="settings" class="mr-1"></i> Settings</a>
					<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i data-feather="log-out" class="mr-1"></i> {{ trans('main.Logout') }}</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</div>
			</li>
			<!-- /User Menu -->
			
		</ul>
		<!-- /Header Menu -->
		
	</div>
	<!-- /Header -->
