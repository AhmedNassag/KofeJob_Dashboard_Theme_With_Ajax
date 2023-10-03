<!-- Edit Modal -->
<div class="modal fade custom-modal" id="editModal{{$item->id}}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header flex-wrap">
                <div class="text-center w-100 mb-3">
                    <img src="../assets_admin/img/logo-small.png" alt="">
                </div>
                <h4 class="modal-title">{{ trans('main.Edit') }} {{ trans('main.User') }}</h4>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('user.update', 'test') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>{{ trans('main.Name') }}</label>
                        <input class="name form-control" type="text" class="form-control" name="name" value="{{ $item->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('main.Email') }}</label>
                        <input class="email form-control" type="email" class="form-control" name="email" value="{{ $item->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('main.Mobile') }}</label>
                        <input class="mobile form-control" type="text" class="form-control" name="mobile" value="{{ $item->mobile }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('main.Status') }}</label>
                        <select class="status form-control form-select" name="status" required>
                            <option value="1" {{ $item->status == 1 ? 'selected' : ''}}>{{ trans('main.Active') }}</option>
                            <option value="0" {{ $item->status == 0 ? 'selected' : ''}}>{{ trans('main.InActive') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ trans('main.Role') }} :</label>
                        {!! Form::select('roles[]', $roles,$item->roles, array('class' => 'form-control','multiple')) !!}
                    </div>
                    <!-- id -->
                    <div class="col-6">
                        <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Modal -->