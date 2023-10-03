<?php $page="categories";?>

@extends('layouts.master')

@section('css')
    <!-- Print -->
    <style>
        @media print {
            .notPrint {
                display: none;
            }
        }
    </style>
    @section('title')
        {{ trans('main.Categories') }}
    @stop
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

            <!-- success Notify -->
            @if (session()->has('success'))
                <script id="successNotify">
                    window.onload = function() {
                        notif({
                            msg: "تمت العملية بنجاح",
                            type: "success"
                        })
                    }
                </script>
            @endif

            <!-- error Notify -->
            @if (session()->has('error'))
                <script id="errorNotify">
                    window.onload = function() {
                        notif({
                            msg: "لقد حدث خطأ.. برجاء المحاولة مرة أخرى!",
                            type: "error"
                        })
                    }
                </script>
            @endif

            <!-- canNotDeleted Notify -->
            @if (session()->has('canNotDeleted'))
                <script id="canNotDeleted">
                    window.onload = function() {
                        notif({
                            msg: "لا يمكن الحذف لوجود بيانات أخرى مرتبطة بها..!",
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
                                <h3 class="page-title">{{ trans('main.Categories') }}</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('main.Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active">{{ trans('main.Categories') }}</li>
                                </ul>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn add-button me-2" data-bs-toggle="modal" data-bs-target="#addModal">
                                    <i class="fas fa-plus"></i>
                                </button>
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
                    <div class="card filter-card" id="filter_inputs" @if($name || $from_date || $to_date) style="display:block" @endif>
                        <div class="card-body pb-0">
                            <form action="{{ route('category.index') }}" method="get">
                                <div class="row filter-row">
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('main.Name') }}</label>
                                            <input class="form-control" type="text" name="name" value="{{ $name }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('main.From Date') }}</label>
                                            <input class="form-control" type="date" name="from_date" value="{{ $from_date }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('main.To Date') }}</label>
                                            <input class="form-control" type="date" name="to_date" value="{{ $to_date }}">
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
                                    <ul id="edit_error_list"></ul>
                                    <ul id="delete_error_list"></ul>
                                    <div class="table-responsive">
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-stripped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">
                                                            <input class="box1 mr-1" name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)"  oninput="showBtnDeleteSelected()">
                                                            #
                                                        </th>
                                                        <th class="text-center">{{ trans('main.Name') }}</th>
                                                        <th class="text-center">{{ trans('main.Actions') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                            {{ $data->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('dashboard.category.addModal')
                        @include('dashboard.category.editModal')
                        @include('dashboard.category.deleteModal')
                        @include('dashboard.category.deleteSelectedModal')		
                    </div>	
                </div>
            </div>			
        </div>
        <!-- /Page Wrapper -->
	</div>
</div>
<!-- /Main Wrapper -->
	
@endsection



@section('js')
    <script>
        $(document).ready(function () {
            
            fetchData();

            //fetch
            function fetchData()
            {
                $.ajax({
                    type: "get",
                    url: "{{ route('category.fetch') }}",
                    dataType: "json",
                    success:function(response) {
                        $('tbody').html("");
                        $.each(response.data, function(key, item) {
                            $('tbody').append('<tr>\
                                <td class="text-center notPrint">\
                                    <input id="delete_selected_input" type="checkbox" value="'+ item.id +'" class="box1 mr-1" oninput="showBtnDeleteSelected()">'+ item.id +'\
                                </td>\
                                <td class="text-center">'+ item.name +'</td>\
                                <td class="text-center">\
                                    <button type="button" class="editBtn btn btn-sm btn-secondary mr-1" value="'+ item.id +'"><i class="far fa-edit"></i></button>\
                                    <button type="button" class="deleteBtn btn btn-sm btn-danger" value="'+ item.id +'"><i class="far fa-trash-alt"></i></button>\
                                </td>\
                            </tr>');
                        });
                    }
                });
            }



            //store
            $(document).on('click','#storeBtn',function(e){
                e.preventDefault();
                $(this).text('جارى الحفظ');
                var storeData = {
                    'name'  : $('.name').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{ route('category.store') }}",
                    enctype: "multipart/form-data",
                    data: storeData,
                    dataType: "json",
                    success:function(response) {
                        if(response.status == false) {
                            $('#error_list').html("");
                            $('#error_list').addClass('alert alert-danger');
                            $.each(response.messages, function(key, val) {
                                $('#storeBtn').text('تأكيد');
                                $('#error_list').append('<li>'+ val +'</li>');
                                notif({
                                    msg: "لقد حدث خطأ.. برجاء المحاولة مرة أخرى!",
                                    type: "error"
                                })
                            });
                        } else {
                            $('#error_list').html("");
                            $('#addModal').modal('hide');
                            $('#addModal').find('input').val("");
                            $('#storeBtn').text('تأكيد');
                            fetchData();
                            notif({
                                msg: "تمت العملية بنجاح",
                                type: "success"
                            })
                        }
                    },
                    error:function(reject){},
                });
            });



            //edit
            $(document).on('click','.editBtn',function(e){
                e.preventDefault();
                var id = $(this).val();
                $('#edit_error_list').html("");
                $('#edit_category').modal('show');
                $.ajax({
                    type: "get",
                    url: "/admin/category/edit/"+id,
                    success:function(response) {
                        if(response.status == false) {
                            $('#edit_error_list').html("");
                            $('#edit_error_list').addClass('alert alert-danger');
                            $("#edit_error_list").append("<li>"+ response.messages +"</li>");
                        } else {
                            $('#update_id').val(response.data.id);
                            $('#update_name').val(response.data.name);
                        }
                    },
                    error:function(reject){},
                });
            });



            //update
            $(document).on('click','.updateBtn',function(e){
                e.preventDefault();
                $(this).text('جارى التعديل');
                var updateData = {
                    'id'   : $('#update_id').val(),
                    'name' : $('#update_name').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{ route('category.update') }}",
                    enctype: "multipart/form-data",
                    data: updateData,
                    dataType: "json",
                    success:function(response) {
                        if(response.status == false) {
                            $('#update_error_list').html("");
                            $('#update_error_list').addClass('alert alert-danger');
                            $.each(response.messages, function(key, val) {
                                $('#update_error_list').append('<li>'+ val +'</li>');
                                $('.updateBtn').text('تأكيد');
                                notif({
                                    msg: "لقد حدث خطأ.. برجاء المحاولة مرة أخرى!",
                                    type: "error"
                                })
                            });
                        } else {
                            $('#update_error_list').html("");
                            $('#edit_category').modal('hide');
                            $('#addModal').find('input').val("");
                            $('.updateBtn').text('تأكيد');
                            fetchData();
                            notif({
                                msg: "تمت العملية بنجاح",
                                type: "success"
                            })
                        }
                    },
                    error:function(reject){},
                });
            });



            //delete
            $(document).on('click','.deleteBtn',function(e){
                e.preventDefault();
                var id = $(this).val();
                $('#delete_id').val(id);
                $('#delete_error_list').html("");
                $('#delete_category').modal('show');
            });
            $(document).on('click','.destroyBtn',function(e){
                e.preventDefault();
                $(this).text('جارى الحذف');
                var id = $('#delete_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "delete",
                    url: "/admin/category/destroy/"+id,
                    success:function(response) {
                        if(response.status == false) {
                            $('#delete_error_list').html("");
                            $('#delete_error_list').addClass('alert alert-danger');
                            $("#delete_error_list").append("<li>"+ response.messages +"</li>");
                            $('.destroyBtn').text('حذف');
                            notif({
                                msg: "لقد حدث خطأ.. برجاء المحاولة مرة أخرى!",
                                type: "error"
                            })
                        } else {
                            $('#delete_error_list').html("");
                            $('#delete_category').modal('hide');
                            $('.destroyBtn').text('حذف');
                            fetchData();
                            notif({
                                msg: "تمت العملية بنجاح",
                                type: "success"
                            })
                        }
                    },
                    error:function(reject){},
                });
            });
        });
    </script>
@endsection
