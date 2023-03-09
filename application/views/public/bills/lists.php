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
                                    <table id="tableBillsLists" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="dt-head-center">No</th>
                                                <th class="dt-head-center">Nama Pasien</th>
                                                <th class="dt-head-center">KPJ</th>
                                                <th class="dt-head-center">Rumah Sakit</th>
                                                <th class="dt-head-center">Diagnosis</th>
                                                <th class="dt-head-center">Kondisi Terakhir</th>
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
                                    <div class="row" id="elem-stmb">
                                        <label for="stmb" class="col-form-label col-sm-3 col-3">STMB</label>
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
                                <div class="form-group col-12" id="div_room" style="display: none;">
                                    <div class="row">
                                        <label for="room" class="col-form-label col-sm-3 col-3">Kamar</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-room-div" id="row-room-div" data-count="1">
                                                    <div class="row row-room col-sm-12 col-12" id="row-room-1">
                                                        <select name="room[]" id="room_1" class="room form-control col-sm-4" data-id="1">
                                                            <option value="">-- Pilih Kamar --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-2 col-2">
                                                            <input type="number" name="room_days[]" id="room_days_1" class="room_days form-control col-sm-8 col-8" min="1" value="1" data-id="1">
                                                            <label class="col-form-label col-sm-4 col-4 text-left"> Hari</label>
                                                        </div>
                                                        <div class="row-flex col-sm-3 col-3">
                                                            <label class="col-form-label col-sm-1 col-1 text-right"> X</label>
                                                            <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>
                                                            <input type="text" name="room_rate[]" id="room_rate_1" class="room_rate form-control text-right col-sm-8 col-8" value="0" readonly />
                                                        </div>
                                                        <div class="row-flex col-sm-3 col-3">
                                                            <label class="col-form-label col-sm-1 col-1 text-right"> = </label>
                                                            <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>
                                                            <input type="text" name="room_subtotal[]" id="room_subtotal_1" class="room_subtotal form-control text-right col-sm-8 col-8" value="0" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="col-form-label add-pic" onclick="appendRoomElem();">+ Tambahkan Kamar</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_admin" style="display: none;">
                                    <div class="row">
                                        <label for="admin" class="col-form-label col-sm-3 col-3">Administrasi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-admin-div" id="row-admin-div" data-count="1">
                                                    <div class="row row-admin col-sm-12 col-12" id="row-admin-1">
                                                        <select name="admin[]" id="admin_1" class="admin form-control col-sm-9 col-9" data-id="1" onchange="calculation_admin(this);">
                                                            <option value="">-- Pilih Administrasi --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-3 col-3">
                                                            <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>
                                                            <input type="text" name="admin_subtotal[]" id="admin_subtotal_1" class="form-control text-right col-sm-8 col-8" value="0" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="col-form-label add-pic" onclick="appendAdminElem();">+ Tambahkan Administrasi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <div class="row">
                                        <label for="medicine" class="col-form-label col-sm-3 col-3">Obat-Obatan</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-medicine-div" id="row-medicine-div" data-count="1">
                                                    <div class="row row-medicine col-sm-12 col-12" id="row-medicine-1">
                                                        <input type="text" name="medicine_value[]" id="medicine_value_1" placeholder="Contoh: Paracetamol" class="form-control col-sm-9 col-9" />
                                                        <div class="row-flex col-sm-3 col-3">
                                                            <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>
                                                            <input type="text" name="medicine_fare[]" id="medicine_fare_1" placeholder="200000" class="form-control col-sm-8 col-8" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="col-form-label add-pic" onclick="appendMedicineElem();">+ Tambahkan Obat-Obatan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_docter" style="display: none;">
                                    <div class="row">
                                        <label for="docter" class="col-form-label col-sm-3 col-3">Dokter</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-docter-div" id="row-docter-div" data-count="1">
                                                    <div class="row row-docter col-sm-12 col-12" id="row-docter-1">
                                                        <select name="docter[]" id="docter_1" class="docter form-control col-sm-9 col-9" data-id="1" onchange="calculation_docter(this);">
                                                            <option value="">-- Pilih Dokter --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-3 col-3">
                                                            <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>
                                                            <input type="text" name="docter_fare[]" id="docter_fare_1" class="form-control text-right col-sm-8 col-8" value="0" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="col-form-label add-pic" onclick="appendDocterElem();">+ Tambahkan Dokter</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_lab" style="display: none;">
                                    <div class="row">
                                        <label for="lab" class="col-form-label col-sm-3 col-3">Laboratorium</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-lab-div" id="row-lab-div" data-count="1">
                                                    <div class="row row-lab col-sm-12 col-12" id="row-lab-1">
                                                        <select name="lab[]" id="lab_1" class="lab form-control col-sm-9 col-9" data-id="1" onchange="calculation_lab(this);">
                                                            <option value="">-- Pilih Laboratorium --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-3 col-3">
                                                            <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>
                                                            <input type="text" name="lab_fare[]" id="lab_fare_1" class="form-control text-right col-sm-8 col-8" value="0" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="col-form-label add-pic" onclick="appendLabElem();">+ Tambahkan Laboratorium</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_radiology" style="display: none;">
                                    <div class="row">
                                        <label for="radiology" class="col-form-label col-sm-3 col-3">Radiologi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-radiology-div" id="row-radiology-div" data-count="1">
                                                    <div class="row row-radiology col-sm-12 col-12" id="row-radiology-1">
                                                        <select name="radiology[]" id="radiology_1" class="radiology form-control col-sm-9 col-9" data-id="1" onchange="calculation_radiology(this);">
                                                            <option value="">-- Pilih Radiologi --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-3 col-3">
                                                            <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>
                                                            <input type="text" name="radiology_fare[]" id="radiology_fare_1" class="form-control text-right col-sm-8 col-8" value="0" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="col-form-label add-pic" onclick="appendRadiologyElem();">+ Tambahkan Radiologi</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_medic" style="display: none;">
                                    <div class="row">
                                        <label for="medic" class="col-form-label col-sm-3 col-3">Medikal</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-medic-div" id="row-medic-div" data-count="1">
                                                    <div class="row row-medic col-sm-12 col-12" id="row-medic-1">
                                                        <select name="medic[]" id="medic_1" class="medic form-control col-sm-9 col-9" data-id="1" onchange="calculation_medic(this);">
                                                            <option value="">-- Pilih Medikal --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-3 col-3">
                                                            <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>
                                                            <input type="text" name="medic_fare[]" id="medic_fare_1" class="form-control text-right col-sm-8 col-8" value="0" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="col-form-label add-pic" onclick="appendMedicElem();">+ Tambahkan Medikal</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12" id="div_rehab" style="display: none;">
                                    <div class="row">
                                        <label for="rehab" class="col-form-label col-sm-3 col-3">Rehabilitasi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-rehab-div" id="row-rehab-div" data-count="1">
                                                    <div class="row row-rehab col-sm-12 col-12" id="row-rehab-1">
                                                        <select name="rehab[]" id="rehab_1" class="rehab form-control col-sm-9 col-9" data-id="1" onchange="calculation_rehab(this);">
                                                            <option value="">-- Pilih Rehabilitasi --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-3 col-3">
                                                            <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>
                                                            <input type="text" name="rehab_fare[]" id="rehab_fare_1" class="form-control text-right col-sm-8 col-8" value="0" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="col-form-label add-pic" onclick="appendRehabElem();">+ Tambahkan Rehabilitasi</label>
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
        $(document).ready(function(){
            $('#tableBillsLists').DataTable({
                destroy:true,
                'processing': false,
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
                    if (response.hasOwnProperty('room')) {
                        $("#div_room").show();
                        var htmlRoom = '<option value="">-- Pilih Kamar --</option>';

                        $.each(response.room, function(index, value) {
                            htmlRoom += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })
                        $(".room").html(htmlRoom)
                    }

                    if (response.hasOwnProperty('fee')) {
                        $("#div_admin").show();
                        var htmlFee = '<option value="">-- Pilih Administrasi --</option>';

                        $.each(response.fee, function(index, value) {
                            htmlFee += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })
                        $(".admin").html(htmlFee)
                    }

                    if (response.hasOwnProperty('docter')) {
                        $("#div_docter").show();
                        var htmlDocter = '<option value="">-- Pilih Dokter --</option>';

                        $.each(response.docter, function(index, value) {
                            htmlDocter += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })
                        $(".docter").html(htmlDocter)
                    }

                    if (response.hasOwnProperty('laboratory')) {
                        $("#div_lab").show();
                        var htmlLaboratory = '<option value="">-- Pilih Laboratorium --</option>';

                        $.each(response.laboratory, function(index, value) {
                            htmlLaboratory += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })
                        $(".lab").html(htmlLaboratory)
                    }

                    if (response.hasOwnProperty('radiology')) {
                        $("#div_radiology").show();
                        var htmlRadiology = '<option value="">-- Pilih Radiologi --</option>';

                        $.each(response.radiology, function(index, value) {
                            htmlRadiology += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })
                        $(".radiology").html(htmlRadiology)
                    }

                    if (response.hasOwnProperty('medic')) {
                        $("#div_medic").show();
                        var htmlMedic = '<option value="">-- Pilih Medikal --</option>';

                        $.each(response.medic, function(index, value) {
                            htmlMedic += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })
                        $(".medic").html(htmlMedic)
                    }

                    if (response.hasOwnProperty('rehab')) {
                        $("#div_rehab").show();
                        var htmlRehab = '<option value="">-- Pilih Rehabilitasi --</option>';

                        $.each(response.rehab, function(index, value) {
                            htmlRehab += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })
                        $(".rehab").html(htmlRehab)
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

        function calculation_room(e, is_rooms = false) {
            var room_fare;
            var room_id = $(e).attr("data-id");
            var days = $("#room_days_" + room_id).val();
            
            if (is_rooms === true) {
                room_fare = $("#room_rate_" + room_id).val();
            } else {
                room_fare = $(e).val();
                room_fare = room_fare.split("-");
                room_fare = room_fare[1];
            }

            $("#room_rate_" + room_id).val(room_fare);
            $("#room_subtotal_" + room_id).val(room_fare * days);
        }

        $(".room").on("change", function() {
            calculation_room(this);
        })

        $(".room_days").on("change", function() {
            calculation_room(this, true);
        })

        function appendRoomElem() {
            var xElem = parseInt($(".row-room-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-room-div").attr("data-count", (xElem + 1));

            var rs_id = ($("#rs_id").find(":selected").val());
            $.ajax({
                url: '<?php echo base_url("master/datas/layanan"); ?>',
                type: "post",
                dataType: "json",
                data: {
                    rs_id: rs_id
                },
                success: function(response) {
                    $('.overlay-loading').hide();
                    if (response.hasOwnProperty('room')) {
                        var htmlRoom = '' +
                            '<div class="row room col-sm-12 col-12 mt-2" id="row-room-' + nXElem + '">' +
                            '    <select name="room[]" id="room_' + nXElem + '" class="room form-control col-sm-4" data-id="' + nXElem + '" onchange="calculation_room(this);">' +
                            '        <option value="">-- Pilih Kamar --</option>';

                        $.each(response.room, function(index, value) {
                            htmlRoom += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })

                        htmlRoom += '' +
                            '    </select>' +
                            '    <div class="row-flex col-sm-2 col-2">' +
                            '        <input type="number" name="[]" id="room_days_' + nXElem + '" class="room_days form-control col-sm-8 col-8" min="1" value="1" data-id="' + nXElem + '" onchange="calculation_room(this, true);">' +
                            '        <label class="col-form-label col-sm-4 col-4 text-left"> Hari</label>' +
                            '    </div>' +
                            '    <div class="row-flex col-sm-3 col-3">' +
                            '        <label class="col-form-label col-sm-1 col-1 text-right"> X</label>' +
                            '        <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>' +
                            '        <input type="text" name="room_rate[]" id="room_rate_' + nXElem + '" class="room_rate form-control text-right col-sm-8 col-8" value="0" readonly />' +
                            '    </div>' +
                            '    <div class="row-flex col-sm-3 col-3">' +
                            '        <label class="col-form-label col-sm-1 col-1 text-right"> = </label>' +
                            '        <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>' +
                            '        <input type="text" name="room_subtotal[]" id="room_subtotal_' + nXElem + '" class="room_subtotal form-control text-right col-sm-8 col-8" value="0" readonly />' +
                            '        <div class="col-sm-1 col-1 pt-2 add-pic text-right row-room-' + nXElem + '" onclick="javascript:$(\'#row-room-' + nXElem + '\').remove();"><i class="far fa-window-close"></i></div>' +
                            '    </div>' +
                            '</div>';

                        $(".row-room-div").append(htmlRoom)
                    }
                }
            })
        }

        function calculation_admin(e) {
            var admin_id = $(e).attr("data-id");
            
            var fare = $(e).val();
                fare = fare.split("-");
                fare = fare[1];

            $("#admin_subtotal_" + admin_id).val(fare);
        }

        function appendAdminElem() {
            var xElem = parseInt($(".row-admin-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-admin-div").attr("data-count", (xElem + 1));

            var rs_id = ($("#rs_id").find(":selected").val());
            $.ajax({
                url: '<?php echo base_url("master/datas/layanan"); ?>',
                type: "post",
                dataType: "json",
                data: {
                    rs_id: rs_id
                },
                success: function(response) {
                    $('.overlay-loading').hide();
                    if (response.hasOwnProperty('fee')) {
                        var htmlFee = '' +
                            '<div class="row row-admin col-sm-12 col-12 mt-2" id="row-admin-' + nXElem + '">'+
                            '   <select name="admin[]" id="admin_' + nXElem + '" class="admin form-control col-sm-9 col-9" data-id="' + nXElem + '" onchange="calculation_admin(this);">' +
                            '       <option value="">-- Pilih Administrasi --</option>';

                        $.each(response.fee, function(index, value) {
                            htmlFee += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })

                        htmlFee += '' +
                            '   </select>' +
                            '   <div class="row-flex col-sm-3 col-3">' +
                            '       <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>' +
                            '       <input type="text" name="admin_subtotal[]" id="admin_subtotal_' + nXElem + '" class="admin_subtotal form-control text-right col-sm-8 col-8" value="0" readonly />' +
                            '       <div class="col-sm-1 col-1 pt-2 add-pic text-right row-admin-' + nXElem + '" onclick="javascript:$(\'#row-admin-' + nXElem + '\').remove();"><i class="far fa-window-close"></i></div>' +
                            '   </div>' +
                            '</div>';

                        $(".row-admin-div").append(htmlFee)
                    }
                }
            })
        }

        function appendMedicineElem() {
            var xElem = parseInt($(".row-medicine-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-medicine-div").attr("data-count", (xElem + 1));

            $(".row-medicine-div").append(''+
                '<div class="row row-medicine col-sm-12 col-12 mt-2" id="row-medicine-' + nXElem + '">' +
                '   <input type="text" name="medicine_value[]" id="medicine_value_' + nXElem + '" placeholder="Contoh: Paracetamol" class="form-control col-sm-9 col-9" />' +
                '   <div class="row-flex col-sm-3 col-3">' +
                '       <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>' +
                '       <input type="text" name="medicine_fare[]" id="medicine_fare" placeholder="200000" class="form-control col-sm-8 col-8" />' +
                '       <div class="col-sm-1 col-1 pt-2 add-pic text-right row-medicine-' + nXElem + '" onclick="javascript:$(\'#row-medicine-' + nXElem + '\').remove();"><i class="far fa-window-close"></i></div>' +
                '   </div>' +
                '</div>' +
            '');
        }

        function calculation_docter(e) {
            var docter_id = $(e).attr("data-id");
            
            var docter_fare = $(e).val();
                docter_fare = docter_fare.split("-");
                docter_fare = docter_fare[1];

            $("#docter_fare_" + docter_id).val(docter_fare);
        }

        function appendDocterElem() {
            var xElem = parseInt($(".row-docter-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-docter-div").attr("data-count", (xElem + 1));

            var rs_id = ($("#rs_id").find(":selected").val());
            $.ajax({
                url: '<?php echo base_url("master/datas/layanan"); ?>',
                type: "post",
                dataType: "json",
                data: {
                    rs_id: rs_id
                },
                success: function(response) {
                    $('.overlay-loading').hide();
                    if (response.hasOwnProperty('docter')) {
                        var htmlFee = '' +
                            '<div class="row row-docter col-sm-12 col-12 mt-2" id="row-docter-' + nXElem + '">'+
                            '   <select name="docter[]" id="docter_' + nXElem + '" class="docter form-control col-sm-9 col-9" data-id="' + nXElem + '" onchange="calculation_docter(this);">' +
                            '       <option value="">-- Pilih Dokter --</option>';

                        $.each(response.docter, function(index, value) {
                            htmlFee += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })

                        htmlFee += '' +
                            '   </select>' +
                            '   <div class="row-flex col-sm-3 col-3">' +
                            '       <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>' +
                            '       <input type="text" name="docter_fare[]" id="docter_fare_' + nXElem + '" class="docter_fare form-control text-right col-sm-8 col-8" value="0" readonly />' +
                            '       <div class="col-sm-1 col-1 pt-2 add-pic text-right row-docter-' + nXElem + '" onclick="javascript:$(\'#row-docter-' + nXElem + '\').remove();"><i class="far fa-window-close"></i></div>' +
                            '   </div>' +
                            '</div>';

                        $(".row-docter-div").append(htmlFee)
                    }
                }
            })
        }

        function calculation_lab(e) {
            var lab_id = $(e).attr("data-id");
            
            var lab_fare = $(e).val();
                lab_fare = lab_fare.split("-");
                lab_fare = lab_fare[1];

            $("#lab_fare_" + lab_id).val(lab_fare);
        }

        function appendLabElem() {
            var xElem = parseInt($(".row-lab-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-lab-div").attr("data-count", (xElem + 1));

            var rs_id = ($("#rs_id").find(":selected").val());
            $.ajax({
                url: '<?php echo base_url("master/datas/layanan"); ?>',
                type: "post",
                dataType: "json",
                data: {
                    rs_id: rs_id
                },
                success: function(response) {
                    $('.overlay-loading').hide();
                    if (response.hasOwnProperty('laboratory')) {
                        var htmlFee = '' +
                            '<div class="row row-lab col-sm-12 col-12 mt-2" id="row-lab-' + nXElem + '">'+
                            '   <select name="lab[]" id="lab_' + nXElem + '" class="lab form-control col-sm-9 col-9" data-id="' + nXElem + '" onchange="calculation_lab(this);">' +
                            '       <option value="">-- Pilih Laboratorium --</option>';

                        $.each(response.laboratory, function(index, value) {
                            htmlFee += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })

                        htmlFee += '' +
                            '   </select>' +
                            '   <div class="row-flex col-sm-3 col-3">' +
                            '       <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>' +
                            '       <input type="text" name="lab_fare[]" id="lab_fare_' + nXElem + '" class="lab_fare form-control text-right col-sm-8 col-8" value="0" readonly />' +
                            '       <div class="col-sm-1 col-1 pt-2 add-pic text-right row-lab-' + nXElem + '" onclick="javascript:$(\'#row-lab-' + nXElem + '\').remove();"><i class="far fa-window-close"></i></div>' +
                            '   </div>' +
                            '</div>';

                        $(".row-lab-div").append(htmlFee)
                    }
                }
            })
        }

        function calculation_radiology(e) {
            var radiology_id = $(e).attr("data-id");
            
            var radiology_fare = $(e).val();
                radiology_fare = radiology_fare.split("-");
                radiology_fare = radiology_fare[1];

            $("#radiology_fare_" + radiology_id).val(radiology_fare);
        }

        function appendRadiologyElem() {
            var xElem = parseInt($(".row-radiology-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-radiology-div").attr("data-count", (xElem + 1));

            var rs_id = ($("#rs_id").find(":selected").val());
            $.ajax({
                url: '<?php echo base_url("master/datas/layanan"); ?>',
                type: "post",
                dataType: "json",
                data: {
                    rs_id: rs_id
                },
                success: function(response) {
                    $('.overlay-loading').hide();
                    if (response.hasOwnProperty('radiology')) {
                        var htmlFee = '' +
                            '<div class="row row-radiology col-sm-12 col-12 mt-2" id="row-radiology-' + nXElem + '">'+
                            '   <select name="radiology[]" id="radiology_' + nXElem + '" class="radiology form-control col-sm-9 col-9" data-id="' + nXElem + '" onchange="calculation_radiology(this);">' +
                            '       <option value="">-- Pilih Radiologi --</option>';

                        $.each(response.radiology, function(index, value) {
                            htmlFee += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })

                        htmlFee += '' +
                            '   </select>' +
                            '   <div class="row-flex col-sm-3 col-3">' +
                            '       <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>' +
                            '       <input type="text" name="radiology_fare[]" id="radiology_fare_' + nXElem + '" class="radiology_fare form-control text-right col-sm-8 col-8" value="0" readonly />' +
                            '       <div class="col-sm-1 col-1 pt-2 add-pic text-right row-radiology-' + nXElem + '" onclick="javascript:$(\'#row-radiology-' + nXElem + '\').remove();"><i class="far fa-window-close"></i></div>' +
                            '   </div>' +
                            '</div>';

                        $(".row-radiology-div").append(htmlFee)
                    }
                }
            })
        }

        function calculation_medic(e) {
            var medic_id = $(e).attr("data-id");
            
            var medic_fare = $(e).val();
                medic_fare = medic_fare.split("-");
                medic_fare = medic_fare[1];

            $("#medic_fare_" + medic_id).val(medic_fare);
        }

        function appendMedicElem() {
            var xElem = parseInt($(".row-medic-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-medic-div").attr("data-count", (xElem + 1));

            var rs_id = ($("#rs_id").find(":selected").val());
            $.ajax({
                url: '<?php echo base_url("master/datas/layanan"); ?>',
                type: "post",
                dataType: "json",
                data: {
                    rs_id: rs_id
                },
                success: function(response) {
                    $('.overlay-loading').hide();
                    if (response.hasOwnProperty('medic')) {
                        var htmlFee = '' +
                            '<div class="row row-medic col-sm-12 col-12 mt-2" id="row-medic-' + nXElem + '">'+
                            '   <select name="medic[]" id="medic_' + nXElem + '" class="medic form-control col-sm-9 col-9" data-id="' + nXElem + '" onchange="calculation_medic(this);">' +
                            '       <option value="">-- Pilih Medikal --</option>';

                        $.each(response.medic, function(index, value) {
                            htmlFee += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })

                        htmlFee += '' +
                            '   </select>' +
                            '   <div class="row-flex col-sm-3 col-3">' +
                            '       <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>' +
                            '       <input type="text" name="medic_fare[]" id="medic_fare_' + nXElem + '" class="medic_fare form-control text-right col-sm-8 col-8" value="0" readonly />' +
                            '       <div class="col-sm-1 col-1 pt-2 add-pic text-right row-medic-' + nXElem + '" onclick="javascript:$(\'#row-medic-' + nXElem + '\').remove();"><i class="far fa-window-close"></i></div>' +
                            '   </div>' +
                            '</div>';

                        $(".row-medic-div").append(htmlFee)
                    }
                }
            })
        }

        function calculation_rehab(e) {
            var rehab_id = $(e).attr("data-id");
            
            var rehab_fare = $(e).val();
                rehab_fare = rehab_fare.split("-");
                rehab_fare = rehab_fare[1];

            $("#rehab_fare_" + rehab_id).val(rehab_fare);
        }

        function appendRehabElem() {
            var xElem = parseInt($(".row-rehab-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-rehab-div").attr("data-count", (xElem + 1));

            var rs_id = ($("#rs_id").find(":selected").val());
            $.ajax({
                url: '<?php echo base_url("master/datas/layanan"); ?>',
                type: "post",
                dataType: "json",
                data: {
                    rs_id: rs_id
                },
                success: function(response) {
                    $('.overlay-loading').hide();
                    if (response.hasOwnProperty('rehab')) {
                        var htmlFee = '' +
                            '<div class="row row-rehab col-sm-12 col-12 mt-2" id="row-rehab-' + nXElem + '">'+
                            '   <select name="rehab[]" id="rehab_' + nXElem + '" class="rehab form-control col-sm-9 col-9" data-id="' + nXElem + '" onchange="calculation_rehab(this);">' +
                            '       <option value="">-- Pilih Rehabilitasi --</option>';

                        $.each(response.rehab, function(index, value) {
                            htmlFee += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })

                        htmlFee += '' +
                            '   </select>' +
                            '   <div class="row-flex col-sm-3 col-3">' +
                            '       <label class="col-form-label col-sm-3 col-3 text-right"> IDR </label>' +
                            '       <input type="text" name="rehab_fare[]" id="rehab_fare_' + nXElem + '" class="rehab_fare form-control text-right col-sm-8 col-8" value="0" readonly />' +
                            '       <div class="col-sm-1 col-1 pt-2 add-pic text-right row-rehab-' + nXElem + '" onclick="javascript:$(\'#row-rehab-' + nXElem + '\').remove();"><i class="far fa-window-close"></i></div>' +
                            '   </div>' +
                            '</div>';

                        $(".row-rehab-div").append(htmlFee)
                    }
                }
            })
        }

        $(function() {
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

        function detail_bills(id) {
            $.ajax({
                url: '<?php echo base_url("bills/detail"); ?>',
                type: "post",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(response) {
                }
            });
        }
    </script>
</body>

</html>