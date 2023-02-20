<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_header_script.php"); ?>
    <link href="<?php echo base_url("assets/plugins/datatables/jquery.dataTables.min.css"); ?>" rel="stylesheet">
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
                                    <table id="tableGeneralLists" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="dt-head-center">No</th>
                                                <th class="dt-head-center">Value</th>
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
                                            <select name="rs_id" id="rs_id" class="form-control" required="required">
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
                                        <label for="company" class="col-form-label col-sm-3 col-3">Perusahaan</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="company" id="company" class="form-control" placeholder="Contoh: PT ANGIN RIBUT" autocomplete="off" required="required" />
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
                                        <label for="npp" class="col-form-label col-sm-3 col-3">NPP</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="npp" id="npp" class="form-control" placeholder="Contoh: BB9999999" autocomplete="off" required="required" />
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
                                    <div class="row">
                                        <label for="stmb" class="col-form-label col-sm-3 col-3">STMB</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <input type="text" name="stmb" id="stmb" class="form-control" placeholder="STMB" autocomplete="off" />
                                        </div>
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
                            </div>
                        </div>
                    </div>
                    <div class="modal-body row form-horizontal">
                        <label class="modal-seg col-12">Informasi Pelayanan Kesehatan</label>
                        <div class="col-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-12">
                                    <div class="row">
                                        <label for="yankes" class="col-form-label col-sm-3 col-3">Jenis Pelayanan</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <select name="yankes" class="form-control" required="required">
                                                <option value="">-- Pilih Jenis Pelayanan -- </option>
                                                <option value="ranap">Rawat Inap</option>
                                                <option value="rajal">Rawat jalan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_yankes_room" style="display: none;">
                                    <div class="row">
                                        <label for="yankes_room" class="col-form-label col-sm-3 col-3">Kamar</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <select name="yankes_room[]" id="yankes_room" class="form-control" disabled>
                                                <option value="">-- Pilih Kamar --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_yankes_admin" style="display: none;">
                                    <div class="row">
                                        <label for="yankes_administration" class="col-form-label col-sm-3 col-3">Administrasi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="no-padding col-sm-12 col-12">
                                                <select name="yankes_administration[]" id="yankes_administration" class="form-control" disabled>
                                                    <option value="">-- Pilih Administrasi --</option>
                                                </select>
                                                <label class="col-form-label add-pic">+ Tambahkan Administrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <div class="row">
                                        <label for="yankes_medicine" class="col-form-label col-sm-3 col-3">Obat-Obatan</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row">
                                                    <input type="text" name="yankes_medicine_value[]" id="yankes_medicine_value" placeholder="Contoh: Paracetamol" class="form-control col-sm-9 col-9" required="required" disabled />
                                                    <input type="text" name="yankes_medicine_fare[]" id="yankes_medicine_fare" placeholder="200000" class="form-control col-sm-3 col-3" required="required" disabled />
                                                </div>
                                                <label class="col-form-label add-pic">+ Tambahkan Obat-Obatan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_yankes_docter" style="display: none;">
                                    <div class="row">
                                        <label for="yankes_docter" class="col-form-label col-sm-3 col-3">Dokter</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="no-padding col-sm-12 col-12">
                                                <select name="yankes_docter[]" id="yankes_docter" class="form-control" disabled>
                                                    <option value="">-- Pilih Dokter --</option>
                                                </select>
                                                <label class="col-form-label add-pic">+ Tambahkan Dokter</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_yankes_lab" style="display: none;">
                                    <div class="row">
                                        <label for="yankes_lab" class="col-form-label col-sm-3 col-3">Laboratorium</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="no-padding col-sm-12 col-12">
                                                <select name="yankes_lab[]" id="yankes_lab" class="form-control" disabled>
                                                    <option value="">-- Pilih Laboratorium --</option>
                                                </select>
                                                <label class="col-form-label add-pic">+ Tambahkan Laboratorium</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_yankes_radiology" style="display: none;">
                                    <div class="row">
                                        <label for="yankes_radiology" class="col-form-label col-sm-3 col-3">Radiologi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="no-padding col-sm-12 col-12">
                                                <select name="yankes_radiology[]" id="yankes_radiology" class="form-control" disabled>
                                                    <option value="">-- Pilih Radiologi --</option>
                                                </select>
                                                <label class="col-form-label add-pic">+ Tambahkan Radiologi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_yankes_medic" style="display: none;">
                                    <div class="row">
                                        <label for="yankes_medic" class="col-form-label col-sm-3 col-3">Medikal</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="no-padding col-sm-12 col-12">
                                                <select name="yankes_medic[]" id="yankes_medic" class="form-control" disabled>
                                                    <option value="">-- Pilih Medikal --</option>
                                                </select>
                                                <label class="col-form-label add-pic">+ Tambahkan Medikal</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_yankes_rehab" style="display: none;">
                                    <div class="row">
                                        <label for="yankes_rehab" class="col-form-label col-sm-3 col-3">Rehabilitasi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="no-padding col-sm-12 col-12">
                                                <select name="yankes_rehab[]" id="yankes_rehab" class="form-control" disabled>
                                                    <option value="">-- Pilih Rehabilitasi --</option>
                                                </select>
                                                <label class="col-form-label add-pic">+ Tambahkan Rehabilitasi</label>
                                            </div>
                                        </div>
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
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo base_url("assets/plugins/moment/moment.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/moment/moment-with-locales.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"); ?>"></script>
    <!-- Daterangepicker -->
    <script src="<?php echo base_url("assets/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
    <script>
        // $(document).ready(function(){
        //     $('#tableGeneralLists').DataTable({
        //         destroy:true,
        //         'processing': true,
        //         'serverSide': true,
        //         'serverMethod': 'post',
        //         'pagingType': 'full_numbers',
        //         'paging': true,
        //         language: {
        //             paginate: {
        //                 previous: '<i class="fas fa-angle-double-left"></i> Prev',
        //                 next: '<i class="fas fa-angle-double-right"></i> Next'
        //             },
        //             searchPlaceholder: "Search",
        //             emptyTable: "No record found",
        //             search: "",
        //             infoFiltered: ""
        //         },
        //         'ajax': {
        //             'url':'<?php echo base_url("master/generals/data/"); ?>',
        //             'type': 'POST',
        //             'data': {'action':'#tableGeneralLists'}
        //         },
        //         'columns': [
        //             { data: 'no', className: 'dt-body-center', width: '20px' },
        //             { data: 'value' },
        //         ],
        //         "columnDefs":[
        //             {
        //                 "targets":[0],
        //                 "orderable":false,
        //             },
        //         ]
        //     });
        // });

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
                    if (response.hasOwnProperty('room')) {
                        $("#div_yankes_room").show();
                        var htmlRoom = '<option value="">-- Pilih Kamar --</option>';

                        $.each(response.room, function(index, value) {
                            htmlRoom += '<option value="' + value.id + '-' + value.fare + '">' + value.value + ' ( Rp ' + number_format(value.fare, 0, ',', '.') + ' )</option>';
                        })
                        $("#yankes_room").html(htmlRoom)
                        $("#yankes_room").removeAttr("disabled")
                    }

                    if (response.hasOwnProperty('fee')) {
                        $("#div_yankes_admin").show();
                        var htmlFee = '<option value="">-- Pilih Administrasi --</option>';

                        $.each(response.fee, function(index, value) {
                            htmlFee += '<option value="' + value.id + '-' + value.fare + '">' + value.name + ' ( Rp ' + number_format(value.fare, 0, ',', '.') + ' )</option>';
                        })
                        $("#yankes_administration").html(htmlFee)
                        $("#yankes_administration").removeAttr("disabled")
                    }

                    if (response.hasOwnProperty('docter')) {
                        $("#div_yankes_docter").show();
                        var htmlDocter = '<option value="">-- Pilih Dokter --</option>';

                        $.each(response.docter, function(index, value) {
                            htmlDocter += '<option value="' + value.id + '-' + value.fare + '">' + value.name + ' ( Rp ' + number_format(value.fare, 0, ',', '.') + ' )</option>';
                        })
                        $("#yankes_docter").html(htmlDocter)
                        $("#yankes_docter").removeAttr("disabled")
                    }

                    if (response.hasOwnProperty('laboratory')) {
                        $("#div_yankes_lab").show();
                        var htmlLaboratory = '<option value="">-- Pilih Laboratorium --</option>';

                        $.each(response.laboratory, function(index, value) {
                            htmlLaboratory += '<option value="' + value.id + '-' + value.fare + '">' + value.name + ' ( Rp ' + number_format(value.fare, 0, ',', '.') + ' )</option>';
                        })
                        $("#yankes_lab").html(htmlLaboratory)
                        $("#yankes_lab").removeAttr("disabled")
                    }

                    if (response.hasOwnProperty('radiology')) {
                        $("#div_yankes_radiology").show();
                        var htmlRadiology = '<option value="">-- Pilih Radiologi --</option>';

                        $.each(response.radiology, function(index, value) {
                            htmlRadiology += '<option value="' + value.id + '-' + value.fare + '">' + value.value + ' ( Rp ' + number_format(value.fare, 0, ',', '.') + ' )</option>';
                        })
                        $("#yankes_radiology").html(htmlRadiology)
                        $("#yankes_radiology").removeAttr("disabled")
                    }

                    if (response.hasOwnProperty('medic')) {
                        $("#div_yankes_medic").show();
                        var htmlMedic = '<option value="">-- Pilih Medikal --</option>';

                        $.each(response.medic, function(index, value) {
                            htmlMedic += '<option value="' + value.id + '-' + value.fare + '">' + value.value + ' ( Rp ' + number_format(value.fare, 0, ',', '.') + ' )</option>';
                        })
                        $("#yankes_medic").html(htmlMedic)
                        $("#yankes_medic").removeAttr("disabled")
                    }

                    if (response.hasOwnProperty('rehab')) {
                        $("#div_yankes_rehab").show();
                        var htmlRehab = '<option value="">-- Pilih Rehabilitasi --</option>';

                        $.each(response.rehab, function(index, value) {
                            htmlRehab += '<option value="' + value.id + '-' + value.fare + '">' + value.value + ' ( Rp ' + number_format(value.fare, 0, ',', '.') + ' )</option>';
                        })
                        $("#yankes_rehab").html(htmlRehab)
                        $("#yankes_rehab").removeAttr("disabled")
                    }
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
            });
        });

        $("#treatment_date").on("focus", function() {
            $('#treatment_date').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });
        });

        $("#ranap_date").on("focus", function() {
            $('#ranap_date').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });
        });

        $("#last_rajal").on("focus", function() {
            $('#last_rajal').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });
        });

        $("#stmb").on("focus", function() {
            $('#stmb').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });
        });

        $(function() {
            $.validator.setDefaults({
                ignore: ":hidden, [contenteditable='true']:not([name])",
                submitHandler: function(form) {
                    $('.overlay-loading').show();

                    $.ajax({
                        url: "<?php echo base_url('bills/save_patient/'); ?>",
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
    </script>
</body>

</html>