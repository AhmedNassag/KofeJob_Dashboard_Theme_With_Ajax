<!-- Start modal-->
<div class="modal custom-modal fade" id="delete_selected" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('main.Delete Selected') }}
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-header">
                    <p>{{ trans('main.Are You Sure Of Multiple Deleting..??') }}</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{ route('category.deleteSelected') }}" method="POST" id="delete_multi_category_form">
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