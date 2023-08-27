<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_header_script.php"); ?>
    <link href="<?php echo base_url("assets/plugins/datatables/jquery.dataTables.min.css"); ?>" rel="stylesheet">
    <!-- Select2 -->
    <link href="<?php echo base_url("assets/plugins/select2/css/select2.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"); ?>" rel="stylesheet">
    <!-- Date Range Picker -->
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/daterangepicker/daterangepicker.css"); ?>" type="text/css">
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
                            <h1 class="m-0">Data Tagihan</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Tagihan</li>
                            </ol>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-success float-sm-right ml-2" data-toggle="modal" data-target="#modal-bills"><i class="fas fa-plus"></i> Tambah Tagihan</button>
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
                                    <table id="tableBillsLists" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="dt-head-center">No</th>
                                                <th class="dt-head-center">Nama Pasien</th>
                                                <th class="dt-head-center">KPJ</th>
                                                <th class="dt-head-center">Rumah Sakit</th>
                                                <th class="dt-head-center">Diagnosis</th>
                                                <th class="dt-head-center">Kondisi Terakhir</th>
                                                <th class="dt-head-center">Sub Total</th>
                                                <th class="dt-head-center">COB</th>
                                                <th class="dt-head-center">Total</th>
                                                <th class="dt-head-center">Action</th>
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

    <div class="modal fade modal-overflow" id="modal-bills">
        <form name="billsForm" id="billsForm" enctype="multipart/form-data" novalidate="novalidate">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-modal-form">Tambah Tagihan Rumah Sakit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row form-horizontal">
                        <label class="modal-seg col-12">Informasi Rumah Sakit</label>
                        <div class="col-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-12">
                                    <div class="row">
                                        <label for="rs_id" class="col-form-label col-sm-3 col-3">Rumah Sakit</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <select name="rs_id" id="rs_id" class="form-control select2" required="required">
                                                <option value="">-- Pilih Rumah Sakit --</option>
                                                <?php
                                                    if (!empty($hospitals)) {
                                                        foreach ($hospitals as $hospital) {
                                                            echo '<option value="' . $hospital->id . '">' . $hospital->name . '</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body row">
                        <label class="modal-seg col-12">Informasi Pasien</label>
                        <div class="col-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-6">
                                    <div class="row">
                                        <label for="kpj" class="col-form-label col-sm-3 col-3">KPJ</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="kpj" id="kpj" class="form-control" placeholder="Contoh: 99999999" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <div class="row">
                                        <label for="npp" class="col-form-label col-sm-3 col-3">NPP</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="npp" id="npp" class="form-control" placeholder="Contoh: BB9999999" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <div class="row">
                                        <label for="name" class="col-form-label col-sm-3 col-3">Nama Pasien</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Alexander Pieter" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <div class="row">
                                        <label for="jenis_kelamin" class="col-form-label col-sm-3 col-3">Jenis Kelamin</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control select2" required="required">
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="Laki-Laki">Laki-Laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <div class="row">
                                        <label for="company" class="col-form-label col-sm-3 col-3">Perusahaan</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="company" id="company" class="form-control" placeholder="Contoh: PT ANGIN RIBUT" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <div class="row">
                                        <label for="lokasi" class="col-form-label col-sm-3 col-3">Lokasi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Contoh: Lobi Kantor" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body row form-horizontal">
                        <label class="modal-seg col-12">Informasi Kecelakaan Kerja</label>
                        <div class="col-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-6">
                                    <div class="row">
                                        <label for="jkk_date" class="col-form-label col-sm-3 col-3">Tanggal JKK</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="jkk_date" id="jkk_date" class="form-control" placeholder="Tanggal JKK" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <div class="row">
                                        <label for="last_condition" class="col-form-label col-sm-3 col-3">Kondisi Akhir</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="last_condition" id="last_condition" class="form-control" placeholder="Kondisi Akhir Pasien" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <div class="row">
                                        <label for="treatment_date" class="col-form-label col-sm-3 col-3">Tanggal Berobat</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="treatment_date" id="treatment_date" class="form-control" placeholder="Tanggal Berobat" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <div class="row" id="elem-stmb">
                                        <label for="stmb-1" class="col-form-label col-sm-3 col-3">STMB</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="stmb[]" id="stmb-1" class="form-control stmb" placeholder="STMB" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-12 text-right">
                                        <label class="add-pic" onclick="appendNewStmb('elem-stmb', 'stmb');">+ STMBB</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body row form-horizontal">
                        <label class="modal-seg col-12">Informasi Tindakan</label>
                        <div class="col-6 col-sm-6">
                            <div class="row">
                                <div class="form-group col-12">
                                    <div class="row">
                                        <label for="ranap_date" class="col-form-label col-sm-3 col-3">Rawat Inap</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="ranap_date" id="ranap_date" class="form-control" placeholder="Rawat Inap" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <div class="row">
                                        <label for="last_rajal" class="col-form-label col-sm-3 col-3">Rajal Terakhir</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="last_rajal" id="last_rajal" class="form-control" placeholder="Rawat Jalan Terakhir" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <div class="row">
                                        <label for="dx_sekunder" class="col-form-label col-sm-3 col-3">DX Sekunder</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="dx_sekunder" id="dx_sekunder" class="form-control" placeholder="DX Sekunder" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6">
                            <div class="row">
                                <div class="form-group col-12">
                                    <div class="row">
                                        <label for="diagnose" class="col-form-label col-sm-3 col-3">Diagnosa</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <textarea name="diagnose" id="diagnose" class="form-control" placeholder="Diagnosa Pasien" autocomplete="off" rows="2" required="required"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <div class="row">
                                        <label for="action" class="col-form-label col-sm-3 col-3">Tindakan</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <textarea name="action" id="action" class="form-control" placeholder="Tindakan Terhadap Pasien" autocomplete="off" rows="2" required="required"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <div class="row">
                                        <label for="action" class="col-form-label col-sm-3 col-3">Keterangan</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <textarea name="verification" id="verification" class="form-control" placeholder="Hasil Verifikasi Pasien" autocomplete="off" rows="2" required="required"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body row form-horizontal">
                        <label class="modal-seg col-12">Informasi Pelayanan Kesehatan</label>
                        <div class="col-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-12 separate-div-bottom">
                                    <div class="row">
                                        <label for="cob_subtotal_1" class="col-form-label col-sm-3 col-3">COB Jasa Raharja</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-cob-div" id="row-cob-div" data-count="1">
                                                    <div class="row-flex row-cob col-sm-12 col-12 no-padding" id="row-cob-1">
                                                        <div class="row-flex col-sm-12 col-12 no-padding">
                                                            <label class="col-form-label col-sm-1 col-1 text-left">IDR</label>
                                                            <input type="number" name="cob_subtotal[]" id="cob_subtotal_1" class="form-control col-sm-11 col-11" value="0" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-outline card-outline-tabs col-12" id="bills-form" style="display: none;">
                                    <div class="card-header p-0 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="yankes-ranap-tab" data-toggle="pill" href="#yankes-ranap" role="tab" aria-controls="yankes-ranap" aria-selected="true">RANAP</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="yankes-rajal-tab" data-toggle="pill" href="#yankes-rajal" role="tab" aria-controls="yankes-rajal" aria-selected="false">RAJAL</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body" style="padding-left: 0; padding-right: 0;">
                                        <div class="tab-content" id="custom-tabs-four-tabContent">
                                            <div class="tab-pane fade show active" id="yankes-ranap" role="tabpanel" aria-labelledby="yankes-ranap-tab">
                                                <div class="yankes-div" id="ctc-yankes-ranap" data-elem="true">
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="yankes-rajal" role="tabpanel" aria-labelledby="yankes-rajal-tab">
                                                <div class="yankes-div" id="ctc-yankes-rajal" data-elem="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_total_bayar">
                                    <div class="row">
                                        <label class="col-form-label col-sm-9 col-9">Total Pembayaran Tagihan</label>
                                        <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                        <label class="row-flex col-form-label col-sm-2 col-2 no-padding pr-1">
                                            <input type="number" name="total_bayar" id="total_bayar" class="total_bayar form-control text-right col-sm-11 col-11" value="0" />
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_total">
                                    <div class="row">
                                        <label class="col-form-label col-sm-9 col-9">TOTAL</label>
                                        <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                        <label class="row-flex col-form-label col-sm-2 col-2 no-padding pr-1">
                                            <input type="number" name="total" id="total" class="total form-control text-right col-sm-11 col-11" value="0" readonly />
                                        </label>
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
    
    <div class="modal fade modal-overflow" id="modal-bills-view">
    </div>
    
    <?PHP include(APPPATH . "views/layout/html_footer_script.php"); ?>
    <script src="<?php echo base_url("assets/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo base_url("assets/plugins/moment/moment.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/moment/moment-with-locales.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"); ?>"></script>
    <!-- Daterangepicker -->
    <script src="<?php echo base_url("assets/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url("assets/plugins/select2/js/select2.full.min.js"); ?>"></script>
    <!-- BootBox -->
    <script src="<?php echo base_url("assets/js/bootstarp-bootbox.min.js"); ?>"></script>
    <script src="<?php echo base_url('assets/js/bills.js'); ?>"></script>
    <script>
        $(document).ready(function(){
            $('#tableBillsLists').DataTable({
                destroy:true,
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
                    'url':'<?php echo base_url("bills/lists/data/"); ?>',
                    'type': 'POST',
                    'data': {'action':'#tableBillsLists'}
                },
                'columns': [
                    { data: 'no', className: 'dt-body-center' },
                    { data: 'patient_name' },
                    { data: 'kpj' },
                    { data: 'hospital_name' },
                    { data: 'diagnose' },
                    { data: 'last_condition' },
                    { data: 'subtotal' },
                    { data: 'cob' },
                    { data: 'total' },
                    { data: 'action' },
                ],
                "columnDefs":[
                    {
                        "targets":[0],
                        "orderable":false,
                    },
                    {
                        "targets":[3],
                        "orderable":false,
                    },
                ]
            });
        });

        $("#rs_id").on("change", function() {
            $.ajax({
                url: '<?php echo base_url("master/datas/layanan"); ?>',
                type: "post",
                dataType: "json",
                data: {
                    rs_id: $(this).val()
                },
                success: function(response) {
                    $('.overlay-loading').hide();
                    $("#bills-form").show();
                    elements.create(response, '<?php echo base_url(); ?>');
                }
            });
        })

        $("#modal-bills").on("hidden.bs.modal", function(e) {
            $("#billsForm").trigger("reset");
            $("#todo").val("");
        });

        $("#jkk_date").on("focus", function() {
            //Date picker
            $('#jkk_date').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
                locale: {
                    format: 'DD-MM-YYYY h:mm'
                }
            }).on('cancel.daterangepicker', function(ev, picker) {
                //do something, like clearing an input
                $('#jkk_date').val('');
            });
        });

        $("#treatment_date").on("focus", function() {
            $('#treatment_date').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            }).on('cancel.daterangepicker', function(ev, picker) {
                //do something, like clearing an input
                $('#treatment_date').val('');
            });
        });

        $("#ranap_date").on("focus", function() {
            $('#ranap_date').daterangepicker({
                defaultDate: null,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            }).on('cancel.daterangepicker', function(ev, picker) {
                //do something, like clearing an input
                $('#ranap_date').val('');
            });
        });

        $("#last_rajal").on("focus", function() {
            $('#last_rajal').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            }).on('cancel.daterangepicker', function(ev, picker) {
                //do something, like clearing an input
                $('#last_rajal').val('');
            });
        });

        $(".stmb").on("focus", function() {
            $('.stmb').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });
        });

        function appendNewStmb(elemId, inputName) {
            var elem = $("#" + elemId);
            var countInput = $("." + inputName).length;
            
            elem.append('<label for="stmb" class="col-form-label col-sm-3 col-3 mt-2 row-stmb-' + (countInput + 1) + '"></label>' + 
                        '<div class="input-group col-sm-8 col-8 mt-2 row-stmb-' + (countInput + 1) + '">' +
                        '   <input type="text" name="stmb[]" id="stmb-' + (countInput + 1) + '" class="form-control stmb" placeholder="STMB" onfocus="javascript:$(this).daterangepicker({locale: {format: \'DD-MM-YYYY\'}});" autocomplete="off" />' +
                        '</div>' + 
                        '<div class="col-sm-1 col-1 pt-3 add-pic row-stmb-' + (countInput + 1) + '" onclick="javascript:$(\'.row-stmb-' + (countInput + 1) + '\').remove();"><i class="far fa-window-close"></i></div>');
        }

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

                    $.ajax({
                        url: "<?php echo base_url('bills/save_bills/'); ?>",
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
            $('#billsForm').validate({
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

            $('#billsForm').validate({
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

        $("#modal-bills").on("hidden.bs.modal", function(e) {
            $('.overlay-loading').show();
            location.reload();
        });

        function detail_bills(id) {
            $.ajax({
                url: '<?php echo base_url("bills/detail"); ?>',
                type: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(response) {
                    $("#modal-bills-view").html(response);
                    $("#modal-bills-view").modal("toggle");
                }
            });
        }

        function delete_bills(id) {
            bootbox.confirm({
                title: "Hapus Tagihan",
                message: "Apakah kamu yakin untuk menghapus tagihan ini? Aksi ini tidak bisa di kembalikan",
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
                            url: '<?php echo base_url("bills/delete"); ?>',
                            type: "post",
                            dataType: "json",
                            data: {
                                id: id
                            },
                            success: function(response) {
                                $('.overlay-loading').hide();
                                if (response.result == 200 || response.message == 'Success') {
                                    $('#tableBillsLists').DataTable().ajax.reload()
                                    show_notif('success', response.data.name);
                                } else {
                                    $('.overlay-loading').hide();
                                    show_notif("error", response.message)
                                }
                            }
                        });
                    } else {
                        show_notif('info', 'Tagihan batal dihapus');
                    }
                }
            });
        }

        function export_bills($id) {
            $.ajax({
                url: '<?php echo base_url("bills/export"); ?>/' + $id,
                type: "post",
                dataType: "json",
                success: function(response) {
                    $('.overlay-loading').hide();
                }
            });
        }
    </script>
</body>

</html>