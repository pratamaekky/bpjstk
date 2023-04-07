<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_header_script.php"); ?>
    <link href="<?php echo base_url("assets/plugins/datatables/jquery.dataTables.min.css"); ?>" rel="stylesheet">
    <!-- Select2 -->
    <link href="<?php echo base_url("assets/plugins/select2/css/select2.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"); ?>" rel="stylesheet">
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
                            <h1 class="m-0">Data Laboratorium Rumah Sakit</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url("master/service"); ?>">Data Pelayanan</a></li>
                                <li class="breadcrumb-item active"><?php echo (!is_null($hospital) ? $hospital->name : "") ?></li>
                            </ol>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-success float-sm-right ml-2" data-toggle="modal" data-target="#modal-laboratory"><i class="fas fa-plus"></i> Tambah</button>
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
                                    <table id="tableLaboratoryLists" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="dt-head-center" style="width: 20px;">No</th>
                                                <th class="dt-head-center">Nama Tindakan</th>
                                                <th class="dt-head-center">Kategori</th>
                                                <th class="dt-head-center">Tarif</th>
                                                <th class="dt-head-center" style="width: 60px;">Action</th>
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

    <div class="modal fade modal-overflow" id="modal-laboratory">
        <form name="laboratoryForm" id="laboratoryForm" enctype="multipart/form-data" novalidate="novalidate">
            <input type="hidden" name="id_rs" id="id_rs" value="<?php echo (!is_null($hospital) ? $hospital->id : 0) ?>" />
            <input type="hidden" name="id" id="id" value="" />
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-modal-form">Tambah Dokter Rumah Sakit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="id_lab_category">Kategori</label>
                                    <div class="input-group">
                                        <select name="id_lab_category" id="id_lab_category" class="form-control select2" required="required">
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php 
                                            if (!is_null($labCategory)) {
                                                foreach ($labCategory as $labCat) {
                                                    echo '<option value="' . $labCat->id . '">' . $labCat->value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="name">Nama Tindakan</label>
                                    <div class="input-group">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Kamar Inap Kelas II" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="fare">Tarif Tindakan</label>
                                    <div class="input-group">
                                        <input type="text" name="fare" id="fare" class="form-control" placeholder="Contoh: 2000000" autocomplete="off" required="required" />
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
    <!-- Select2 -->
    <script src="<?php echo base_url("assets/plugins/select2/js/select2.full.min.js"); ?>"></script>
    <!-- BootBox -->
    <script src="<?php echo base_url("assets/js/bootstarp-bootbox.min.js"); ?>"></script>

    <script>
        $(document).ready(function(){
            $('#tableLaboratoryLists').DataTable({
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
                    emptyTable: "No record found",
                    search: "",
                    infoFiltered: ""
                },
                'ajax': {
                    'url':'<?php echo base_url("master/service/laboratory/data"); ?>',
                    'type': 'POST',
                    'data': {"rsid": <?php echo $rsId; ?>, 'action':'#tableLaboratoryLists'}
                },
                'columns': [
                    { data: 'no', className: 'dt-body-center' },
                    { data: 'name' },
                    { data: 'lab_category' },
                    { data: 'fare' },
                    { data: 'action' }
                ]
            });
        });

        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            }).one('select2:open', function(e) {
                $('input.select2-search__field').prop('placeholder', 'Cari disini...');
            });
            $.validator.setDefaults({
                ignore: ":hidden, [contenteditable='true']:not([name])",
                submitHandler: function(form) {
                    $('.overlay-loading').show();

                    var todo = $("#todo").val();
                    var url;
                    if (todo == "update") {
                        url = "<?php echo base_url('master/service/laboratory/update'); ?>";
                    } else {
                        url = "<?php echo base_url('master/service/laboratory/save'); ?>";
                    }

                    $.ajax({
                        url: url,
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
            $('#laboratoryForm').validate({
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

        function editService(id) {
            $('.overlay-loading').show();
            $.ajax({
                url: "<?php echo base_url('master/service/laboratory/detail/'); ?>",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    $('.overlay-loading').hide();
                    $("#id").val(response.id);
                    $("#name").val(response.name);
                    $("#fare").val(response.fare);

                    $("#btnForm").html("Update");
                    $("#todo").val("update");
                    $("#modal-laboratory").modal("toggle");
                },
                error: function(error) {
                    $('.overlay-loading').hide();
                    show_notif("error", "Gagal Update Data! Ulangi beberapa saat lagi")
                }
            });
        }

        function deleteService(id) {
            bootbox.confirm({
                title: "Hapus Laboratorium",
                message: "Apakah kamu yakin untuk menghapus laboratorium ini? Aksi ini tidak bisa di kembalikan",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Batal'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Setuju'
                    }
                },
                callback: function(result) {
                    if (result) {
                        $('.overlay-loading').show();
                        $.ajax({
                            url: '<?php echo base_url("master/service/laboratory/delete"); ?>',
                            type: "post",
                            dataType: "json",
                            data: {
                                id: id
                            },
                            success: function(response) {
                                $('.overlay-loading').hide();
                                if (response.result == 200) {
                                    $('#tableLaboratoryLists').DataTable().ajax.reload()
                                    show_notif('success', response.data.name);
                                }
                            }
                        });
                    } else {
                        show_notif('info', 'Laboratorium batal dihapus');
                    }
                }
            });
        }        

    </script>
</body>

</html>