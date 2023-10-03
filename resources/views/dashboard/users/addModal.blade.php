<!-- Add Modal -->
<div class="modal fade custom-modal" id="addModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header flex-wrap">
                <div class="text-center w-100 mb-3">
                    <img src="../assets_admin/img/logo-small.png" alt="">
                </div>
                <h4 class="modal-title">{{ trans('main.Add') }} {{ trans('main.User') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <ul id="error_list"></ul>
                <form action="{{ route('user.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('main.Name') }}</label>
                        <input class="name form-control" type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('main.Email') }}</label>
                        <input class="email form-control" type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('main.Mobile') }}</label>
                        <input class="mobile form-control" type="text" class="form-control" name="mobile" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('main.Password') }}</label>
                        <input class="password form-control" type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('main.Confirm') }} {{ trans('main.Password') }}</label>
                        <input class="confirm-password form-control" type="password" class="form-control" name="confirm-password" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('main.Status') }}</label>
                        <select class="status form-control form-select" name="status" required>
                            <option value="1">{{ trans('main.Active') }}</option>
                            <option value="0">{{ trans('main.InActive') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ trans('main.Role') }} :</label>
                        {!! Form::select('roles_name[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                    </div>
                    <div class="mt-4">
                        <button id="storeBtn" type="submit" class="btn btn-primary btn-block">{{ trans('main.Confirm') }}</button>
                    </div>
                </from>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal -->