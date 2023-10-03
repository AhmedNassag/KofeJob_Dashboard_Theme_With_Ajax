<!-- Start modal-->
<div class="modal custom-modal fade" id="delete_selected" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>{{ trans('main.Delete Selected') }}</h3>
                    <p>{{ trans('main.Are You Sure Of Multiple Deleting..??') }}</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{ route('user.deleteSelected') }}" method="POST" id="delete_multi_category_form">
                        {{ csrf_field() }}
                        @csrf
                        <!-- id -->
                        <input class="text" type="hidden" id="delete_selected_id" name="delete_selected_id" value=''>
                        <div class="row">
                            <div class="col-6">
                                <a class="btn btn-primary continue-btn" onclick="event.preventDefault();document.getElementById('delete_multi_category_form').submit();">{{ trans('main.Delete') }}</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary cancel-btn">{{ trans('main.Close') }}</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal-->