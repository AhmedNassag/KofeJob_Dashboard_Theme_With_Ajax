<?php $page="role";?>

@extends('layouts.master')



@section('content')

            <!-- validationNotify -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- successNotify -->
            @if (session()->has('success'))
                <script id="successNotify" style="display: none;">
                    window.onload = function() {
                        notif({
                            msg: "تمت العملية بنجاح",
                            type: "success"
                        })
                    }
                </script>
            @endif

            <!-- errorNotify -->
            @if (session()->has('error'))
                <script id="errorNotify" style="display: none;">
                    window.onload = function() {
                        notif({
                            msg: "لقد حدث خطأ.. برجاء المحاولة مرة أخرى!",
                            type: "error"
                        })
                    }
                </script>
            @endif

            <!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
                
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">{{ trans('main.Roles') }}</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Dashboard') }}</a></li>
									<li class="breadcrumb-item active">{{trans('main.Edit')}} {{ trans('main.Roles') }}</li>
                                </ul>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('role.index') }}" type="button" class="btn btn-primary me-2" id="filter_search">
                                    {{ trans('main.Back') }}
                                    <i class="fas fa-arrow-left"></i>
                                </a>
							</div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <form action="{{ Route('role.update', $role->id) }}" method="post">
                        {{ method_field('patch') }}
                        @csrf
                        <div class="row">

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body pt-0">
                                        <div class="card-header mb-4">
                                            <h5 class="card-title">{{ trans('main.Role') }}</h5>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>{{ trans('main.Name') }}</label>
                                            <input type="text" class="form-control name" name="name" value="{{ $role->name }}" placeholder="{{ trans('main.Name') }}">
                                        </div>
                                    </div>
                                </div>			
                                <button type="submit" class="btn btn-primary btn-block">{{ trans('main.Confirm') }}</button>
                            </div>
                            
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body pt-0">
                                        <div class="card-header mb-4">
                                            <h5 class="card-title">{{ trans('main.Roles')}}</h5>
                                        </div>
                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                                            @foreach($permission as $value)
                                                <div class="col mb-3 d-flex">
                                                    <div class="card flex-fill">
                                                        <div class="card-body p-3 text-center">
                                                        <p class="card-text f-12">{{ $value->name }}</p>
                                                        </div>
                                                        <div class="card-footer">
                                                            <label class="form-group toggle-switch mb-0">
                                                                <input type="checkbox" class="toggle-switch-input" name="permission[]" value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                <span class="toggle-switch-label mx-auto">
                                                                    <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach  
                                        </div>
                                    </div>
                                </div>			
                            
                            </div>

                        </div>
                        <!-- row closed -->
                    </form>
                        
                </div>
                <!-- content container-fluid closed -->	
            </div>
            <!-- page-wrapper closed -->
        </div>
        <!-- /Main Wrapper -->
@endsection



@section('js')

@endsection