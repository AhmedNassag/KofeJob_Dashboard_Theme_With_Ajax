<!-- Start modal-->
<div class="modal custom-modal fade" id="delete{{ $role->id }}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('main.Delete') }}
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-header">
                    <p>{{ trans('main.Are You Sure Of Deleting..??') }}</p>
                </div>
                <form action="{{ route('role.delete', 'test') }}" method="post">
                    @csrf
                    <!-- id -->
                    <input id="id" type="hidden" name="id" class="form-control" value="{{ $role->id }}">
                    
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="destroyBtn btn btn-primary continue-btn">{{ trans('main.Delete') }}</button>
                        </div>
                        <div class="col-6">
                            <a href="" data-bs-dismiss="modal" class="btn btn-primary cancel-btn">{{ trans('main.Close') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end delete modal -->