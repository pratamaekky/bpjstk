<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_header_script.php"); ?>
    <link href="<?php echo base_url("assets/plugins/datatables/jquery.dataTables.min.css"); ?>" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="overlay-loading" style="display: none">
        <div class="overlay-loading-spinner">
            <i class="fa fa-spinner fa-spin animated" style="font-size: 38px; margin: 12px;"></i>
            <p>Processing...</p>
        </div>
    </div>
    <div class="wrapper">
        <?php include(APPPATH . "views/layout/navbar_header.php"); ?>
        <?php include(APPPATH . "views/layout/navbar_sidebar.php"); ?>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Data Users Rumah Sakit</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url("master/service"); ?>">Data Users</a></li>
                                <li class="breadcrumb-item active"><?php echo (!is_null($hospital) ? $hospital->name : "") ?></li>
                            </ol>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-success float-sm-right ml-2" data-toggle="modal" data-target="#modal-users"><i class="fas fa-plus"></i> Tambah</button>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="tableUsersLists" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="dt-head-center">No</th>
                                                <th class="dt-head-center">Nama User</th>
                                                <th class="dt-head-center">Username</th>
                                                <th class="dt-head-center">Last Login</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        <?php include(APPPATH . "views/layout/html_footer.php"); ?>
    </div>

    <div class="modal fade modal-overflow" id="modal-users">
        <form name="usersForm" id="usersForm" enctype="multipart/form-data" novalidate="novalidate">
            <input type="hidden" name="rs_id" id="rs_id" value="<?php echo (!is_null($hospital) ? $hospital->id : 0) ?>" />
            <input type="hidden" name="created" id="created" value="<?php echo date("Y-m-d H:i:s") ?>" />
            <input type="hidden" name="role" id="role" value="1" />
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-modal-form">Tambah Tindakan Rumah Sakit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="name">Nama User</label>
                                    <div class="input-group">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Lades Sagita" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="username">Username</label>
                                    <div class="input-group">
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Contoh: lades.sagita" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="password">Password [Default: "!Plkkrates123"]</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control" value="!Plkkrates123" autocomplete="off" required="required" disabled />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="button-seg">
                            <input type="hidden" name="todo" id="todo" value="" />
                            <button type="button" class="btn btn-default" id="modal-close" data-dismiss="modal">Batal</button>
                            <button type="submit" name="btnTodo" class="btn btn-danger" id="btnForm">Simpan</button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>

    <?PHP include(APPPATH . "views/layout/html_footer_script.php"); ?>
    <script src="<?php echo base_url("assets/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>
    <script>
        $(document).ready(function(){
            $('#tableUsersLists').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'pagingType': 'full_numbers',
                'paging': true,
                language: {
                    paginate: {
                        previous: '<i class="fas fa-angle-double-left"></i> Prev',
                        next: '<i class="fas fa-angle-double-right"></i> Next'
                    },
                    searchPlaceholder: "Search",
                    emptyTable: "Tidak ada data yang ditemukan",
                    zeroRecords: "Tidak ada data yang cocok",
                    search: "",
                    infoFiltered: ""
                },
                'ajax': {
                    'url':'<?php echo base_url("master/service/users/data"); ?>',
                    'type': 'POST',
                    'data': {"rsid": <?php echo $rsId; ?>, 'action':'#tableUsersLists'}
                },
                'columns': [
                    { data: 'no', className: 'dt-body-center', width: '20px' },
                    { data: 'name' },
                    { data: 'username' },
                    { data: 'last_login' },
                ]
            });
        });

        $(function() {
            $.validator.setDefaults({
                ignore: ":hidden, [contenteditable='true']:not([name])",
                submitHandler: function(form) {
                    $('.overlay-loading').show();

                    $.ajax({
                        url: "<?php echo base_url('master/service/users/save'); ?>",
                        type: "POST",
                        data: new FormData(form),
                        async: true,
                        dataType: "JSON",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.result == 200 || response.message == 'Success') {
                                $(".overlay-loading").hide();
                                location.reload();
                            } else {
                                $('.overlay-loading').hide();
                                show_notif("error", response.message)
                            }
                        },
                        error: function(error) {
                            $('.overlay-loading').hide();
                            show_notif("error", "Gagal Update Data! Ulangi beberapa saat lagi")
                        }
                    });
                }
            });
            $('#usersForm').validate({
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
</script>
</body>

</html>