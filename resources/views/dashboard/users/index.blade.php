<?php $page="user";?>

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
								<h3 class="page-title">{{ trans('main.Users') }}</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Dashboard') }}</a></li>
									<li class="breadcrumb-item active">{{ trans('main.Users') }}</li>
								</ul>
							</div>
							<div class="col-auto">
                                @can('إضافة مستخدم')
                                <button type="button" class="btn add-button me-2" data-bs-toggle="modal" data-bs-target="#addModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                                @endcan
                                <button type="button" class="btn filter-btn me-2" id="filter_search">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <button type="button" class="btn" id="btn_delete_selected" title="{{ trans('main.Delete Selected') }}" style="display:none; width: 42px; height: 42px; justify-content: center; align-items: center; color: #fff; background: red; border: 1px solid red; border-radius: 5px;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<!-- Search Filter -->
					<div class="card filter-card" id="filter_inputs" @if($name || $email || $mobile) style="display:block" @endif>
						<div class="card-body pb-0">
							<form action="{{ route('user.index') }}" method="get">
								<div class="row filter-row">
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label>{{trans('main.Name') }}</label>
											<input class="form-control" type="text" name="name" value="{{ $name }}">
										</div>
									</div>
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label>{{trans('main.Email') }}</label>
											<input type="email" class="form-control" name="email" value="{{ $email }}">										
										</div>
									</div>
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<label>{{ trans('main.Mobile') }}</label>
											<input type="text" class="form-control" name="mobile" value="{{ $mobile }}">
										</div>
									</div>
									<div class="col-sm-6 col-md-3">
										<div class="form-group">
											<button class="btn btn-primary btn-block" type="submit">{{ trans('main.Search') }}</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- /Search Filter -->

					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-center table-hover mb-0">
											<thead>
												<tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">{{ trans('main.Name') }}</th>
                                                    <th class="text-center">{{ trans('main.Email') }}</th>
                                                    <th class="text-center">{{ trans('main.Mobile') }}</th>
                                                    <th class="text-center">{{ trans('main.Status') }}</th>
                                                    <th class="text-center">{{ trans('main.Role') }}</th>
                                                    <th class="text-center">{{ trans('main.Actions') }}</th>
												</tr>
											</thead>
											<tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($data as $item)
                                                    <?php $i++; ?>
                                                    <tr>
                                                        <td class="text-center notPrint">{{ $i }}</td>
                                                        <td class="text-center">{{ $item->name }}</td>
                                                        <td class="text-center">{{ $item->email }}</td>
                                                        <td class="text-center">{{ $item->mobile }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('user.changeStatus',$item->id) }}">
                                                                @if ($item->status == 1)
                                                                    <div class="btn ripple btn-purple-gradient" id='swal-success'>
                                                                        <span class="label text-success text-center">
                                                                            {{ app()->getLocale() == 'ar' ? 'مفعل' : 'Active' }}
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <div class="btn ripple btn-purple-gradient" id='swal-success'>
                                                                        <span class="label text-danger text-center">
                                                                            {{ app()->getLocale() == 'ar' ? 'غير مفعل' : 'InActive' }}
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            @if (!empty($item->getRoleNames()))
                                                                @foreach ($item->getRoleNames() as $v)
                                                                    <label class="badge badge-primary">{{ $v }}</label>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($item->id != 1)
                                                                @can('تعديل مستخدم')
                                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$item->id}}"><i class="far fa-edit"></i></button>
                                                                @endcan

                                                                @can('حذف مستخدم')
                                                                    <button type="button" class="deleteBtn btn btn-sm btn-danger" value="{{ $item->id }}"><i class="far fa-trash-alt"></i></button>
                                                                @endcan
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @include('dashboard.users.editModal')
                                                @endforeach
											</tbody>
										</table>
                                        {{ $data->links() }}
									</div>
								</div>
							</div>
						</div>		
                        @include('dashboard.users.addModal')
                        @include('dashboard.users.deleteModal')
                        @include('dashboard.users.deleteSelectedModal')	
					</div>
                    <!-- row closed -->
				</div>
                <!-- content container-fluid closed -->	
			</div>
			<!-- /Page Wrapper -->
		</div>
		<!-- /Main Wrapper -->
@endsection



@section('js')

    <script>
        $(document).ready(function () {

            //delete
            $(document).on('click','.deleteBtn',function(e){
                e.preventDefault();
                var id = $(this).val();
                $('#delete_id').val(id);
                $('#delete_error_list').html("");
                $('#delete_user').modal('show');
            });
            $(document).on('click','.destroyBtn',function(e){
                e.preventDefault();
                $(this).text('Deleting');
                var id = $('#delete_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "delete",
                    url: "/admin/user/destroy/"+id,
                    success:function(response) {
                        if(response.status == false) {
                            $('#delete_error_list').html("");
                            $('#delete_error_list').addClass('alert alert-danger');
                            $("#delete_error_list").append("<li>"+ response.messages +"</li>");
                        } else {
                            $('#delete_error_list').html("");
                            $('#delete_user').modal('hide');
                            $(this).text('Deleting');
                            location.reload();
                        }
                    },
                    error:function(reject){},
                });
            });

        });
    </script>
@endsection
