<?php $page="login";?>
@extends('layouts.master2')
@section('content')
	<!-- Main Wrapper -->
	<div class="main-wrapper login-body">
		<div class="login-wrapper">
			<div class="container">
				<img class="img-fluid logo-dark mb-2" src="../assets_admin/img/logo-01.png" alt="Logo">
                <div class="loginbox">
					<div class="login-right">
						<div class="login-right-wrap">
							<h1>Coding System Company</h1>
							<h1>{{ trans('main.Welcome Back') }}</h1>
							<form method="POST" action="{{ route('login') }}">
								@csrf
								<div class="form-group form-focus mt-5">
									<input id="identify" type="text" class="form-control floating @error('identify') is-invalid @enderror" name="identify" value="{{ old('identify') }}">
									<label class="focus-label">{{ trans('main.Email Or Mobile') }}</label>
									@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<div class="form-group form-focus">
									<input id="password" type="password" class="form-control floating @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
									<label class="focus-label">{{ trans('main.Password') }}</label>
									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">{{ trans('main.Login') }}</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Main Wrapper -->
@endsection