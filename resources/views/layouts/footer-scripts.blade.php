<!-- jQuery -->
<script src="{{ URL::asset('assets_admin/js/jquery-3.6.0.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ URL::asset('assets_admin/js/bootstrap.bundle.min.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ URL::asset('assets_admin/js/feather.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ URL::asset('assets_admin/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Select2 JS -->
<script src="{{ URL::asset('assets_admin/plugins/select2/js/select2.min.js') }}"></script>

<!-- Datatables JS -->
<script src="{{ URL::asset('assets_admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets_admin/plugins/datatables/datatables.min.js') }}"></script>

<!-- Datepicker Core JS -->
<script src="{{ URL::asset('assets_admin/js/moment.min.js') }}"></script>
<script src="{{ URL::asset('assets_admin/js/bootstrap-datetimepicker.min.js') }}"></script>

<!-- Mask JS -->
<script src="{{ URL::asset('assets_admin/js/jquery.maskedinput.min.js') }}"></script>
<script src="{{ URL::asset('assets_admin/js/mask.js') }}"></script>

<!-- Form Validation JS -->
<script src="{{ URL::asset('assets_admin/js/form-validation.js') }}"></script>


<script src="{{ URL::asset('assets_admin/js/apexcharts1.js') }}"></script>

<!-- Ck Editor JS -->
<script src="{{ URL::asset('assets_admin/js/ckeditor.js') }}"></script>

<!-- Custom JS -->
<script src="{{ URL::asset('assets_admin/js/script.js') }}"></script>

<!--Internal  Notify js -->
<script src="{{ URL::asset('assets_admin/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets_admin/plugins/notify/js/notifit-custom.js') }}"></script>

<!-- Sweet-alert js  -->
<script src="{{URL::asset('assets_admin/js/sweet-alert.js')}}"></script>
<script src="{{URL::asset('assets_admin/plugins/sweet-alert/sweetalert.min.js')}}"></script>
<script src="{{URL::asset('assets_admin/plugins/sweet-alert/jquery.sweet-alert.js')}}"></script>

@yield('js')



<!-- notification reload -->
<script>
    setInterval(function() {
        $("#notifications_count").load(window.location.href + " #notifications_count");
        $("#unreadNotifications").load(window.location.href + " #unreadNotifications");
    }, 10000); //reload every 10 seconds
</script>


<!-- deleteSelected -->
<script type="text/javascript">
    //when check all
    function CheckAll(className, elem) {
        var elements = document.getElementsByClassName(className);
        var l = elements.length;
        if (elem.checked) {
            for (var i = 0; i < l; i++) {
                elements[i].checked = true;
            }
        } else {
            for (var i = 0; i < l; i++) {
                elements[i].checked = false;
            }
        }
    }

    //when check show or hide button
    function showBtnDeleteSelected()
    {
        var selected = new Array();
        $("#example1 input[type=checkbox]:checked").each(function() {
            selected.push(this.value);
        });
        if (selected.length > 0) {
            document.getElementById('btn_delete_selected').style.display = "inline-block";
        } else {
            document.getElementById('btn_delete_selected').style.display = "none";
        }
    }

    //when click button show modal
    $(function() {
        $("#btn_delete_selected").click(function() {
            var selected = new Array();
            $("#example1 input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
            });
            if (selected.length > 0) {
                $('#delete_selected').modal('show')
                $('input[id="delete_selected_id"]').val(selected);
            }
        });
    });
</script>