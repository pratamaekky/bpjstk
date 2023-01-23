<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Toastr -->
<script src="<?php echo base_url("assets/plugins/toastr/toastr.min.js"); ?>"></script>

<!-- overlayScrollbars -->
<script src="<?php echo base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
<script src="<?php echo base_url("assets/js/bootstrap-notify.min.js"); ?>" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist/js/adminlte.js'); ?>"></script>

    <script>
        function show_notif(type, message) {
            toastr.options.timeOut = 3000;
            toastr.options.progressBar = true;
            if (type == "success") {
                toastr.success(message)
            } else if (type == "error") {
                toastr.error(message)
            } else if (type == "info") {
                toastr.info(message)
            }
        }
    </script>