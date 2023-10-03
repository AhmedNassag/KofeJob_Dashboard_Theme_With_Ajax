@extends('layouts.master')



@section('css')
    <!--Internal Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <!-- Internal Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
    @section('title')
        {{ trans('main.Edit') }} {{ trans('main.User') }}
    @stop
@endsection



@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('main.Users') }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('main.Edit') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection



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


            <!-- row -->
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>{{ trans('main.Error') }}</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-right">
                                    <a class="btn btn-primary ripple" href="{{ route('users.index') }}">
                                        <i class="typcn typcn-arrow-right-outline"></i>&nbsp;{{ trans('main.Back') }}
                                    </a>
                                </div>
                            </div>
                            <br>

                            <form action="{{ route('brands.update', 'test') }}" method="post" enctype="multipart/form-data">
                                {{ method_field('patch') }}
                                @csrf
                                <div class="">
                                    <div class="row mg-b-20">
                                        <!-- name -->
                                        <div class="parsley-input col-md-6" id="fnWrapper">
                                            <label>{{ trans('main.Name') }} : <span class="tx-danger">*</span></label>
                                            <input id="name" type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                                            {!! Form::text('name', null, array('class' => 'form-control','required')) !!}
                                        </div>

                                        <!-- email -->
                                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                            <label>{{ trans('main.Email') }} : <span class="tx-danger">*</span></label>
                                            {!! Form::text('email', null, array('class' => 'form-control','required')) !!}
                                        </div>
                                    </div>
                                </div>

                            <!-- password -->
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>{{ trans('main.Password') }} : <span class="tx-danger">*</span></label>
                                    {!! Form::password('password', array('class' => 'form-control','required')) !!}
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>{{ trans('main.Confirm') }} {{ trans('main.Password') }} : <span class="tx-danger">*</span></label>
                                    {!! Form::password('confirm-password', array('class' => 'form-control','required')) !!}
                                </div>
                            </div>

                            <div class="row row-sm mg-b-20">
                                <!-- mobile -->
                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>{{ trans('main.Mobile') }} : <span class="tx-danger">*</span></label>
                                    {!! Form::number('mobile', null, array('class' => 'form-control','required')) !!}
                                </div>

                                <!-- status -->
                                <div class="col-lg-6">
                                    <label class="form-label">{{ trans('main.Status') }}</label>
                                    <select name="status" id="select-beast" class="form-control nice-select custom-select">
                                        <option value="1" {{ $user->status == '1' ? 'selected' : ''}}>{{ trans('main.Active') }}</option>
                                        <option value="0" {{ $user->status == '0' ? 'selected' : ''}}>{{ trans('main.InActive') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mg-b-20">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <strong>{{ trans('main.Role') }}</strong>
                                        {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple'))
                                        !!}
                                    </div>
                                </div>
                            </div>
                            <div class="mg-t-30">
                                <button class="btn btn-main-primary pd-x-20" type="submit">{{ trans('main.Confirm') }}</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection



@section('js')
    <!--Internal Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <!-- Internal Nice-select js-->
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>
    <!--Internal Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
@endsection