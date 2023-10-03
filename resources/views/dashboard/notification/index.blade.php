@extends('layouts.master')



@section('css')
	@section('title')
        {{ trans('main.Notifications') }}
    @stop
@endsection



@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('main.Dashboard') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('main.Notifications') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection



@section('content')
				<!-- row -->
				<div class="row">
					<!-- Notifications -->
					<div class="col-12" id="unreadNotifications">
						@if(auth()->user()->unreadNotifications->count() > 0)
							@foreach (auth()->user()->unreadNotifications as $notification)
								<div class="main-notification-list Notification-scroll">
									<a class="d-flex p-3 border-bottom" href="{{ url('/'.$notification->data['route']) }}">
										<div class="notifyimg bg-pink">
											<i class="la la-file-alt text-white"></i>
										</div>
										<div class="mr-3">
											<h5 class="notification-label mb-1">
												{{ $notification->data['title'] }} {{ $notification->data['user'] }}
											</h5>
											<div class="notification-subtext">
												{{ $notification->created_at }}
											</div>
										</div>
									</a>
								</div>
							@endforeach
						@else
							<div class="main-notification-list Notification-scroll">
								<a class="d-flex p-3 border-bottom" href="#">
									<div class="notifyimg bg-pink">
										<i class="la la-file-alt text-white"></i>
									</div>
									<div class="mr-3 mt-2">
										<h5 class="notification-label mb-1">
											{{ trans('main.No Notifications') }}
										</h5>
									</div>
								</a>
							</div>
						@endif
					</div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection



@section('js')

@endsection