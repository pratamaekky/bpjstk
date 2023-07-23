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
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required="required">
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
                                        <label for="cob" class="col-form-label col-sm-3 col-3">COB Jasa Raharja</label>
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
                                <div class="form-group col-12 separate-div-bottom">
                                    <div class="row">
                                        <label for="yankes" class="col-form-label col-sm-3 col-3">Jenis Pelayanan</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <select name="yankes" class="form-control select2" required="required">
                                                <option value="">-- Pilih Jenis Pelayanan -- </option>
                                                <option value="ranap">Rawat Inap</option>
                                                <option value="rajal">Rawat jalan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_room" style="display: none;">
                                    <div class="row">
                                        <label for="room" class="col-form-label col-sm-3 col-3">Kamar</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-room-div" id="row-room-div" data-count="1">
                                                    <div class="row row-room col-sm-12 col-12" id="row-room-1">
                                                        <select name="room[]" id="room_1" class="room form-control select2 col-sm-4 col-4" data-id="1">
                                                            <option value="">-- Pilih Kamar --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-2 col-2">
                                                            <input type="number" name="room_days[]" id="room_days_1" class="room_days form-control col-sm-8 col-8" min="1" value="1" data-id="1" />
                                                            <label class="col-form-label col-sm-4 col-4 text-center">Hari</label>
                                                        </div>
                                                        <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">
                                                            <label class="col-sm-5 col-5 text-center no-padding">X</label>
                                                            <label class="col-sm-7 col-7 pl-0">IDR</label>
                                                        </div>
                                                        <input type="number" name="room_rate[]" id="room_rate_1" class="room_rate form-control text-right col-sm-2 col-2" value="0" data-id="1" onblur="calculation_room(this, false, true);" />
                                                        <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>
                                                        <div class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="room_subtotal[]" id="room_subtotal_1" class="room_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />
                                                            <label class="col-form-label col-sm-1 col-1 add-pic text-right">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label col-sm-12 col-12 add-pic" onclick="appendRoomElem();">+ Tambahkan Kamar</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_room" class="subtotal subtotal-room form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_room_nurse" style="display: none;">
                                    <div class="row">
                                        <label for="room-nurse" class="col-form-label col-sm-3 col-3">Jasa Perawat Kamar</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-room-nurse-div" id="row-room-nurse-div" data-count="1">
                                                    <div class="row row-room-nurse col-sm-12 col-12" id="row-room-nurse-1">
                                                        <input type="text" name="room_nurse[]" id="room_nurse_1" placeholder="Contoh: Jasa Perawat Kamar" class="form-control col-sm-9 col-9" />
                                                        <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                        <label class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="room_nurse_subtotal[]" id="room_nurse_subtotal_1" class="room_nurse_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_room_nurse()" />
                                                            <label class="col-sm-1 col-1">&nbsp;</label>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label add-pic" onclick="appendRoomNurseElem();">+ Tambahkan Perawat Kamar</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_room_nurse" class="subtotal subtotal-room-nurse form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_admin" style="display: none;">
                                    <div class="row">
                                        <label for="admin" class="col-form-label col-sm-3 col-3">Administrasi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-admin-div" id="row-admin-div" data-count="1">
                                                    <div class="row row-admin col-sm-12 col-12" id="row-admin-1">
                                                        <select name="admin[]" id="admin_1" class="admin form-control select2 col-sm-9 col-9" data-id="1" onchange="calculation_admin(this);">
                                                            <option value="">-- Pilih Administrasi --</option>
                                                        </select>
                                                        <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                        <label class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="admin_subtotal[]" id="admin_subtotal_1" class="admin_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_admin(this)" />
                                                            <label class="col-sm-1 col-1">&nbsp;</label>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label add-pic" onclick="appendAdminElem();">+ Tambahkan Administrasi</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_admin" class="subtotal subtotal-admin form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_medicine" style="display: none;">
                                    <div class="row">
                                        <label for="medicine" class="col-form-label col-sm-3 col-3">Obat-Obatan</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-medicine-div" id="row-medicine-div" data-count="1">
                                                    <div class="row row-medicine col-sm-12 col-12" id="row-medicine-1">
                                                        <input type="text" name="medicine_value[]" id="medicine_value_1" placeholder="Contoh: Jasa Paracetamol" class="form-control col-sm-9 col-9" />
                                                        <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                        <label class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="medicine_subtotal[]" id="medicine_subtotal_1" class="medicine_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_medicine()" />
                                                            <label class="col-sm-1 col-1">&nbsp;</label>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label add-pic" onclick="appendMedicineElem();">+ Tambahkan Obat-Obatan</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_medicine" class="subtotal subtotal-medicine form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_docter" style="display: none;">
                                    <div class="row">
                                        <label for="docter" class="col-form-label col-sm-3 col-3">Dokter Umum / IGD</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-docter-div" id="row-docter-div" data-count="1">
                                                    <div class="row row-docter col-sm-12 col-12" id="row-docter-1">
                                                        <select name="docter[]" id="docter_1" class="docter form-control select2 col-sm-4 col-4" data-id="1" onchange="calculation_docter(this);">
                                                            <option value="">-- Pilih Dokter --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-2 col-2">
                                                            <input type="number" name="docter_qty[]" id="docter_qty_1" class="docter_qty form-control col-sm-8 col-8" min="1" value="1" data-id="1" onchange="calculation_docter(this, true);" />
                                                            <label class="col-form-label col-sm-4 col-4 text-center">Visit</label>
                                                        </div>
                                                        <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">
                                                            <label class="col-sm-5 col-5 text-center no-padding">X</label>
                                                            <label class="col-sm-7 col-7 pl-0">IDR</label>
                                                        </div>
                                                        <input type="number" name="docter_rate[]" id="docter_rate_1" class="docter_rate form-control text-right col-sm-2 col-2" value="0" data-id="1" onblur="calculation_docter(this, false, true);" />
                                                        <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>
                                                        <div class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="docter_subtotal[]" id="docter_subtotal_1" class="docter_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />
                                                            <label class="col-form-label col-sm-1 col-1 add-pic text-right">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                    <div class="row-docter-do-div col-sm-12 col-12 pl-0" id="row-docter-do-div-1" data-count="0">
                                                    </div>
                                                    <label class="col-form-label add-pic ml-3" onclick="appendDocterDoElem(1);">+ Tambahkan Tindakan Dokter</label>
                                                </div>
                                            </div>
                                            <label class="col-form-label add-pic" onclick="appendDocterElem();">+ Tambahkan Dokter</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_docter" class="subtotal subtotal-docter form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_surgery" style="display: none;">
                                    <div class="row">
                                        <label for="surgery" class="col-form-label col-sm-3 col-3">Dokter Spesialis</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-surgery-div" id="row-surgery-div" data-count="1">
                                                    <div class="row row-surgery col-sm-12 col-12" id="row-surgery-1">
                                                        <select name="surgery[]" id="surgery_1" class="surgery form-control select2 col-sm-9 col-9" data-id="1" onchange="calculation_surgery(this);">
                                                            <option value="">-- Pilih Dokter Spesialis --</option>
                                                        </select>
                                                        <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                        <label class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="surgery_subtotal[]" id="surgery_subtotal_1" class="surgery_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_surgery(this)" />
                                                            <label class="col-sm-1 col-1">&nbsp;</label>
                                                        </label>
                                                    </div>
                                                    <div class="row-surgery-do-div col-sm-12 col-12 pl-0" id="row-surgery-do-div-1" data-count="0">
                                                    </div>
                                                    <label class="col-form-label add-pic ml-3" onclick="appendSurgeryDoElem(1);">+ Tambahkan Tindakan Dokter Spesialis</label>
                                                </div>
                                            </div>
                                            <label class="col-form-label add-pic" onclick="appendSurgeryElem();">+ Tambahkan Dokter Spesialis</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_surgery" class="subtotal subtotal-surgery form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_surgery_nurse" style="display: none;">
                                    <div class="row">
                                        <label for="surgery-nurse" class="col-form-label col-sm-3 col-3">Jasa Perawat Operasi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-surgery-nurse-div" id="row-surgery-nurse-div" data-count="1">
                                                    <div class="row row-surgery-nurse col-sm-12 col-12" id="row-surgery-nurse-1">
                                                        <input type="text" name="surgery_nurse[]" id="surgery_nurse_1" placeholder="Contoh: Jasa Perawat Operasi" class="form-control col-sm-9 col-9" />
                                                        <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                        <label class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="surgery_nurse_subtotal[]" id="surgery_nurse_subtotal_1" class="surgery_nurse_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_surgery_nurse();" />
                                                            <label class="col-sm-1 col-1">&nbsp;</label>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label add-pic" onclick="appendSurgeryNurseElem();">+ Tambahkan Perawat Operasi</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_surgery_nurse" class="subtotal subtotal-surgery-nurse form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_anestesi" style="display: none;">
                                    <div class="row">
                                        <label for="anestesi" class="col-form-label col-sm-3 col-3">Dokter Anestesi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-anestesi-div" id="row-anestesi-div" data-count="1">
                                                    <div class="row row-anestesi col-sm-12 col-12" id="row-anestesi-1">
                                                        <select name="anestesi[]" id="anestesi_1" class="anestesi form-control select2 col-sm-9 col-9" data-id="1" onchange="calculation_anestesi(this);">
                                                            <option value="">-- Pilih Dokter Anestesi --</option>
                                                        </select>
                                                        <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                        <label class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="anestesi_subtotal[]" id="anestesi_subtotal_1" class="anestesi_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_anestesi(this)" />
                                                            <label class="col-sm-1 col-1">&nbsp;</label>
                                                        </label>
                                                    </div>
                                                    <div class="row-anestesi-do-div col-sm-12 col-12 pl-0" id="row-anestesi-do-div-1" data-count="0">
                                                    </div>
                                                    <label class="col-form-label add-pic ml-3" onclick="appendAnestesiDoElem(1);">+ Tambahkan Tindakan Dokter Anestesi</label>
                                                </div>
                                            </div>
                                            <label class="col-form-label add-pic" onclick="appendAnestesiElem();">+ Tambahkan Dokter Anestesi</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_anestesi" class="subtotal subtotal-anestesi form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_lab" style="display: none;">
                                    <div class="row">
                                        <label for="lab" class="col-form-label col-sm-3 col-3">Laboratorium</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-lab-div" id="row-lab-div" data-count="1">
                                                    <div class="row row-lab col-sm-12 col-12" id="row-lab-1">
                                                        <select name="lab[]" id="lab_1" class="lab form-control select2 col-sm-4 col-4" data-id="1" onchange="calculation_lab(this);">
                                                            <option value="">-- Pilih Laboratorium --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-2 col-2">
                                                            <input type="number" name="lab_qty[]" id="lab_qty_1" class="lab_qty form-control col-sm-8 col-8" min="1" value="1" data-id="1" onchange="calculation_lab(this, true);" />
                                                            <label class="col-form-label col-sm-4 col-4 text-left"> Pcs</label>
                                                        </div>
                                                        <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">
                                                            <label class="col-sm-5 col-5 text-center no-padding">X</label>
                                                            <label class="col-sm-7 col-7 pl-0">IDR</label>
                                                        </div>
                                                        <input type="number" name="lab_rate[]" id="lab_rate_1" class="lab_rate form-control text-right col-sm-2 col-2" value="0" data-id="1" onblur="calculation_lab(this, false, true);" />
                                                        <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>
                                                        <div class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="lab_subtotal[]" id="lab_subtotal_1" class="lab_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />
                                                            <label class="col-form-label col-sm-1 col-1 add-pic text-right">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label col-sm-12 col-12 add-pic" onclick="appendLabElem();">+ Tambahkan Laboratorium</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_lab" class="subtotal subtotal-lab form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_radiology" style="display: none;">
                                    <div class="row">
                                        <label for="radiology" class="col-form-label col-sm-3 col-3">Radiologi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-radiology-div" id="row-radiology-div" data-count="1">
                                                    <div class="row row-radiology col-sm-12 col-12" id="row-radiology-1">
                                                        <select name="radiology[]" id="radiology_1" class="radiology form-control select2 col-sm-4 col-4" data-id="1" onchange="calculation_radiology(this);">>
                                                            <option value="">-- Pilih Radiologi --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-2 col-2">
                                                            <input type="number" name="radiology_qty[]" id="radiology_qty_1" class="radiology_qty form-control col-sm-8 col-8" min="1" value="1" onchange="calculation_radiology(this, true);" data-id="1" />
                                                            <label class="col-form-label col-sm-4 col-4 text-center">Pcs</label>
                                                        </div>
                                                        <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">
                                                            <label class="col-sm-5 col-5 text-center no-padding">X</label>
                                                            <label class="col-sm-7 col-7 pl-0">IDR</label>
                                                        </div>
                                                        <input type="number" name="radiology_rate[]" id="radiology_rate_1" class="radiology_rate form-control text-right col-sm-2 col-2" value="0" data-id="1" onblur="calculation_radiology(this, false, true);" />
                                                        <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>
                                                        <div class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="radiology_subtotal[]" id="radiology_subtotal_1" class="radiology_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />
                                                            <label class="col-form-label col-sm-1 col-1 add-pic text-right">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label col-sm-12 col-12 add-pic" onclick="appendRadiologyElem();">+ Tambahkan Radiologi</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_radiology" class="subtotal subtotal-radiology form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_medic" style="display: none;">
                                    <div class="row">
                                        <label for="medic" class="col-form-label col-sm-3 col-3">Medikal</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-medic-div" id="row-medic-div" data-count="1">
                                                    <div class="row row-medic col-sm-12 col-12" id="row-medic-1">
                                                        <select name="medic[]" id="medic_1" class="medic form-control select2 col-sm-4 col-4" data-id="1" onchange="calculation_medic(this);">>
                                                            <option value="">-- Pilih Medikal --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-2 col-2">
                                                            <input type="number" name="medic_qty[]" id="medic_qty_1" class="medic_qty form-control col-sm-8 col-8" min="1" value="1" onchange="calculation_medic(this, true);" data-id="1" />
                                                            <label class="col-form-label col-sm-4 col-4 text-center">Pcs</label>
                                                        </div>
                                                        <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">
                                                            <label class="col-sm-5 col-5 text-center no-padding">X</label>
                                                            <label class="col-sm-7 col-7 pl-0">IDR</label>
                                                        </div>
                                                        <input type="number" name="medic_rate[]" id="medic_rate_1" class="medic_rate form-control text-right col-sm-2 col-2" value="0" data-id="1" onblur="calculation_medic(this, false, true);" />
                                                        <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>
                                                        <div class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="medic_subtotal[]" id="medic_subtotal_1" class="medic_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />
                                                            <label class="col-form-label col-sm-1 col-1 add-pic text-right">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label col-sm-12 col-12 add-pic" onclick="appendMedicElem();">+ Tambahkan Medikal</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_medic" class="subtotal subtotal-medic form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_rehab" style="display: none;">
                                    <div class="row">
                                        <label for="rehab" class="col-form-label col-sm-3 col-3">Rehabilitasi</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-rehab-div" id="row-rehab-div" data-count="1">
                                                    <div class="row row-rehab col-sm-12 col-12" id="row-rehab-1">
                                                        <select name="rehab[]" id="rehab_1" class="rehab form-control select2 col-sm-4 col-4" data-id="1" onchange="calculation_rehab(this);">>
                                                            <option value="">-- Pilih Rehabilitasi --</option>
                                                        </select>
                                                        <div class="row-flex col-sm-2 col-2">
                                                            <input type="number" name="rehab_qty[]" id="rehab_qty_1" class="rehab_qty form-control col-sm-8 col-8" min="1" value="1" onchange="calculation_rehab(this, true);" data-id="1" />
                                                            <label class="col-form-label col-sm-4 col-4 text-center">Pcs</label>
                                                        </div>
                                                        <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">
                                                            <label class="col-sm-5 col-5 text-center no-padding">X</label>
                                                            <label class="col-sm-7 col-7 pl-0">IDR</label>
                                                        </div>
                                                        <input type="number" name="rehab_rate[]" id="rehab_rate_1" class="rehab_rate form-control text-right col-sm-2 col-2" value="0" data-id="1" onblur="calculation_rehab(this, false, true);" />
                                                        <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>
                                                        <div class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="rehab_subtotal[]" id="rehab_subtotal_1" class="rehab_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />
                                                            <label class="col-form-label col-sm-1 col-1 add-pic text-right">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label col-sm-12 col-12 add-pic" onclick="appendRehabElem();">+ Tambahkan Rehabilitasi</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_rehab" class="subtotal subtotal-rehab form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_ambulance" style="display: none;">
                                    <div class="row">
                                        <label for="ambulance" class="col-form-label col-sm-3 col-3">Ambulance</label>
                                        <div class="input-group col-sm-9 col-9">
                                            <div class="col-sm-12 col-12">
                                                <div class="row row-ambulance-div" id="row-ambulance-div" data-count="1">
                                                    <div class="row row-ambulance col-sm-12 col-12" id="row-ambulance-1">
                                                        <select name="ambulance[]" id="ambulance_1" class="ambulance form-control select2 col-sm-9 col-9" data-id="1" onchange="calculation_ambulance(this);">
                                                            <option value="">-- Pilih Ambulance --</option>
                                                        </select>
                                                        <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                        <label class="row-flex col-sm-2 col-2 no-padding">
                                                            <input type="number" name="ambulance_subtotal[]" id="ambulance_subtotal_1" class="ambulance_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_ambulance(this)" />
                                                            <label class="col-sm-1 col-1">&nbsp;</label>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label add-pic" onclick="appendAmbulanceElem();">+ Tambahkan Ambulance</label>
                                            <div class="sbtotal row col-sm-12 col-12">
                                                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                                <label class="row-flex col-sm-2 col-2 no-padding">
                                                    <input type="number" name="subtotal" id="subtotal_ambulance" class="subtotal subtotal-ambulance form-control text-right col-sm-11 col-11" value="0" readonly />
                                                    <label class="col-sm-1 col-1">&nbsp;</label>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_total_bayar">
                                    <div class="row">
                                        <label class="col-form-label col-sm-9 col-9">Total Pembayaran Tagihan</label>
                                        <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                        <label class="row-flex col-form-label col-sm-2 col-2 no-padding">
                                            <input type="number" name="total_bayar" id="total_bayar" class="total_bayar form-control text-right col-sm-10 col-10" value="0" />
                                            <label class="col-sm-2 col-2">&nbsp;</label>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-12 separate-div-bottom" id="div_total">
                                    <div class="row">
                                        <label class="col-form-label col-sm-9 col-9">TOTAL</label>
                                        <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                                        <label class="row-flex col-form-label col-sm-2 col-2 no-padding">
                                            <input type="number" name="total" id="total" class="total form-control text-right col-sm-10 col-10" value="0" readonly />
                                            <label class="col-sm-2 col-2">&nbsp;</label>
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

                    if (response.hasOwnProperty('surgery')) {
                        $("#div_surgery").show();
                        var htmlSurgery = '<option value="">-- Pilih Dokter Spesialis --</option>';

                        $.each(response.surgery, function(index, value) {
                            htmlSurgery += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })
                        $(".surgery").html(htmlSurgery)
                    }

                    if (response.hasOwnProperty('anestesi')) {
                        $("#div_anestesi").show();
                        var htmlAnestesi = '<option value="">-- Pilih Dokter Anestesi --</option>';

                        $.each(response.anestesi, function(index, value) {
                            htmlAnestesi += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })
                        $(".anestesi").html(htmlAnestesi)
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

                    if (response.hasOwnProperty('ambulance')) {
                        $("#div_ambulance").show();
                        var htmlFee = '<option value="">-- Pilih Ambulance --</option>';

                        $.each(response.ambulance, function(index, value) {
                            htmlFee += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })
                        $(".ambulance").html(htmlFee)
                    }


                    $("#div_room_nurse").show();
                    $("#div_medicine").show();
                    $("#div_surgery_nurse").show();
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

        function calculation_room(e, is_rooms = false, is_rate = false) {
            var room_subtotal;
            var room_id = $(e).attr("data-id");
            var days = $("#room_days_" + room_id).val();
            
            if (is_rooms === true) {
                room_subtotal = $("#room_rate_" + room_id).val();
            } else if (is_rooms === false && is_rate === true) {
                room_subtotal = $(e).val();
            } else {
                room_subtotal = $(e).val();
                room_subtotal = room_subtotal.split("-");
                room_subtotal = room_subtotal[1];
            }

            $("#room_rate_" + room_id).val(room_subtotal);
            $("#room_subtotal_" + room_id).val(room_subtotal * days);

            var st_room = 0;
            $.each($(".room_subtotal"), function(index, value) {
                st_room = st_room + parseInt($(value).val());
            })
            $(".subtotal-room").val(st_room);
            calculation_total();
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
                            '<div class="row row-room col-sm-12 col-12" id="row-room-' + nXElem + '">' +
                            '    <select name="room[]" id="room_' + nXElem + '" class="room form-control select2 col-sm-4 col-4" data-id="' + nXElem + '" onchange="calculation_room(this);">' +
                            '        <option value="">-- Pilih Kamar --</option>';

                        $.each(response.room, function(index, value) {
                            htmlRoom += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })

                        htmlRoom += '' +
                            '    </select>' +
                            '    <div class="row-flex col-sm-2 col-2">' +
                            '        <input type="number" name="room_days[]" id="room_days_' + nXElem + '" class="room_days form-control col-sm-8 col-8" min="1" value="1" data-id="' + nXElem + '" onchange="calculation_room(this, true);" />' +
                            '        <label class="col-form-label col-sm-4 col-4 text-center"> Hari</label>' +
                            '    </div>' +
                            '    <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">' +
                            '        <label class="col-sm-5 col-5 text-center no-padding">X</label>' +
                            '        <label class="col-sm-7 col-7 pl-0">IDR</label>' +
                            '    </div>' +
                            '    <input type="number" name="room_rate[]" id="room_rate_' + nXElem + '" class="room_rate form-control text-right col-sm-2 col-2" value="0" data-id="' + nXElem + '" onblur="calculation_room(this, false, true);" />' +
                            '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>' +
                            '    <div class="row-flex col-sm-2 col-2 no-padding">' +
                            '        <input type="number" name="room_subtotal[]" id="room_subtotal_' + nXElem + '" class="room_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />' +
                            '        <label class="col-form-label col-sm-1 col-1 add-pic text-right row-room-' + nXElem + '" data-id="' + nXElem + '" onclick="javascript:$(\'#row-room-' + nXElem + '\').remove(); calculation_room(this); calculation_total();"><i class="far fa-window-close"></i></label>' +
                            '    </div>' +
                            '</div>';

                        $(".row-room-div").append(htmlRoom)
                        $("#room_" + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function(e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        }

        function appendRoomNurseElem() {
            var xElem = parseInt($(".row-room-nurse-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-room-nurse-div").attr("data-count", (xElem + 1));

            $(".row-room-nurse-div").append(''+
                '<div class="row row-room-nurse col-sm-12 col-12" id="row-room-nurse-' + nXElem + '">' +
                '   <input type="text" name="room_nurse[]" id="room_nurse_' + nXElem + '" placeholder="Contoh: Jasa Perawat kamar" class="form-control col-sm-9 col-9" />' +
                '   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '   <label class="row-flex col-sm-2 col-2 no-padding">' +
                '       <input type="number" name="room_nurse_subtotal[]" id="room_nurse_subtotal_' + nXElem +'" class="room_nurse_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_room_nurse()" />' +
                '       <div class="col-form-label col-sm-1 col-1 add-pic text-right row-room-nurse-' + nXElem + '" onclick="javascript:$(\'#row-room-nurse-' + nXElem + '\').remove(); calculation_room_nurse(); calculation_total();"><i class="far fa-window-close"></i></div>' +
                '   </label>' +
                '</div>' +
            '');
        }

        function calculation_room_nurse() {
            var st_nurse = 0;
            $.each($(".room_nurse_subtotal"), function(index, value) {
                st_nurse = st_nurse + parseInt($(value).val());
            })

            $(".subtotal-room-nurse").val(st_nurse);
            calculation_total();
        }

        function calculation_admin(e) {
            var admin_id = $(e).attr("data-id");
            
            var fare = $(e).val();
                fare = fare.split("-");
                fare = fare[1];

            $("#admin_subtotal_" + admin_id).val(fare);

            var st_admin = 0;
            $.each($(".admin_subtotal"), function(index, value) {
                st_admin = st_admin + parseInt($(value).val());
            })
            $(".subtotal-admin").val(st_admin);
            calculation_total();
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
                        var htmlAdmin = '' +
                            '<div class="row row-admin col-sm-12 col-12" id="row-admin-' + nXElem + '">'+
                            '   <select name="admin[]" id="admin_' + nXElem + '" class="admin form-control select2 col-sm-9 col-9" data-id="' + nXElem + '" onchange="calculation_admin(this);">' +
                            '       <option value="">-- Pilih Administrasi --</option>';

                        $.each(response.fee, function(index, value) {
                            htmlAdmin += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })

                        htmlAdmin += '' +
                            '   </select>' +
                            '   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                            '   <label class="row-flex col-sm-2 col-2 no-padding">' +
                            '       <input type="number" name="admin_subtotal[]" id="admin_subtotal_' + nXElem + '" class="admin_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_admin(this);" />' +
                            '       <div class="col-form-label col-sm-1 col-1 add-pic text-right row-admin-' + nXElem + '" data-id="' + nXElem + '" onclick="javascript:$(\'#row-admin-' + nXElem + '\').remove(); calculation_admin(this); calculation_total();"><i class="far fa-window-close"></i></div>' +
                            '   </label>' +
                            '</div>';

                        $(".row-admin-div").append(htmlAdmin);
                        $("#admin_" + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function(e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        }

        function appendMedicineElem() {
            var xElem = parseInt($(".row-medicine-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-medicine-div").attr("data-count", (xElem + 1));

            $(".row-medicine-div").append(''+
                '<div class="row row-medicine col-sm-12 col-12" id="row-medicine-' + nXElem + '">' +
                '   <input type="text" name="medicine_value[]" id="medicine_value_' + nXElem + '" placeholder="Contoh: Paracetamol" class="form-control col-sm-9 col-9" />' +
                '   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '   <label class="row-flex col-sm-2 col-2 no-padding">' +
                '       <input type="number" name="medicine_subtotal[]" id="medicine_subtotal_' + nXElem + '" class="medicine_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_medicine()" />' +
                '       <div class="col-form-label col-sm-1 col-1 add-pic text-right row-medicine-' + nXElem + '" onclick="javascript:$(\'#row-medicine-' + nXElem + '\').remove(); calculation_medicine(); calculation_total();"><i class="far fa-window-close"></i></div>' +
                '   </label>' +
                '</div>' +
            '');
        }

        function calculation_medicine() {
            var st_medicine = 0;
            $.each($(".medicine_subtotal"), function(index, value) {
                st_medicine = st_medicine + parseInt($(value).val());
            })
            $(".subtotal-medicine").val(st_medicine);
            calculation_total();
        }

        function calculation_docter(e, is_docters = false, is_rate = false) {
            var docter_subtotal;
            var docter_id = $(e).attr("data-id");
            var qty = $("#docter_qty_" + docter_id).val();
            
            if (is_docters === true) {
                docter_subtotal = $("#docter_rate_" + docter_id).val();
            } else if (is_docters === false && is_rate === true) {
                docter_subtotal = $(e).val();
            } else {
                docter_subtotal = $(e).val();
                docter_subtotal = docter_subtotal.split("-");
                docter_subtotal = docter_subtotal[1];
            }

            $("#docter_rate_" + docter_id).val(docter_subtotal);
            $("#docter_subtotal_" + docter_id).val(docter_subtotal * qty);

            var st_docter = 0;
            $.each($(".docter_subtotal"), function(index, value) {
                st_docter = st_docter + parseInt($(value).val());
            })
            $.each($(".docter_do_subtotal"), function(index, value) {
                st_docter = st_docter + parseInt($(value).val());
            })
            $(".subtotal-docter").val(st_docter);
            calculation_total();
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
                        var htmlDocter = '' +
                            '<div class="row row-docter col-sm-12 col-12" id="row-docter-' + nXElem + '">' +
                            '    <select name="docter[]" id="docter_' + nXElem + '" class="docter form-control select2 col-sm-4 col-4" data-id="' + nXElem + '" onchange="calculation_docter(this);">' +
                            '        <option value="">-- Pilih Dokter --</option>';

                        $.each(response.docter, function(index, value) {
                            htmlDocter += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })

                        htmlDocter += '' +
                            '    </select>' +
                            '    <div class="row-flex col-sm-2 col-2">' +
                            '        <input type="number" name="docter_qty[]" id="docter_qty_' + nXElem + '" class="docter_qty form-control col-sm-8 col-8" min="1" value="1" data-id="' + nXElem + '" onchange="calculation_docter(this, true);" />' +
                            '        <label class="col-form-label col-sm-4 col-4 text-center">Pcs</label>' +
                            '    </div>' +
                            '    <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">' +
                            '        <label class="col-sm-5 col-5 text-center no-padding">X</label>' +
                            '        <label class="col-sm-7 col-7 pl-0">IDR</label>' +
                            '    </div>' +
                            '    <input type="number" name="docter_rate[]" id="docter_rate_' + nXElem + '" class="docter_rate form-control text-right col-sm-2 col-2" value="0" data-id="' + nXElem + '" onblur="calculation_docter(this, false, true);" />' +
                            '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>' +
                            '    <div class="row-flex col-sm-2 col-2 no-padding">' +
                            '        <input type="number" name="docter_subtotal[]" id="docter_subtotal_' + nXElem + '" class="docter_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />' +
                            '        <label class="col-form-label col-sm-1 col-1 add-pic text-right row-docter-' + nXElem + '" data-id="' + nXElem + '" onclick="javascript:$(\'#row-docter-' + nXElem + '\').remove(); calculation_docter(this); calculation_total();"><i class="far fa-window-close"></i></label>' +
                            '    </div>' +
                            '</div>' +
                            '<div class="row-docter-do-div col-sm-12 col-12 pl-0" id="row-docter-do-div-' + nXElem + '" data-count="' + nXElem + '">' +
                            '</div>' +
                            '<label class="col-form-label add-pic ml-3" onclick="appendDocterDoElem(' + nXElem + ');">+ Tambahkan Tindakan Dokter</label>';

                        $(".row-docter-div").append(htmlDocter)
                        $("#docter_" + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function(e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        }

        function calculation_docterdo() {
            var st_docter_do = 0;
            $.each($(".docter_subtotal"), function(index, value) {
                st_docter_do = st_docter_do + parseInt($(value).val());
            })

            $.each($(".docter_do_subtotal"), function(index, value) {
                st_docter_do = st_docter_do + parseInt($(value).val());
            })

            $(".subtotal-docter").val(st_docter_do);
            calculation_total();
        }

        function appendDocterDoElem(id) {
            var xElem = parseInt($(".row-docter-do-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-docter-do-div").attr("data-count", (xElem + 1));

            htmlDocterDo = ''+
                '<div class="row-flex row-docter-do col-sm-12 col-12 pl-0" id="row-docter-do-' + nXElem + '">' +
                '    <label class="row-flex col-sm-9 col-9 pr-3">' +
                '       <input type="text" name="docter_do_value[' + id + '][]" id="docter_do_value_' + nXElem + '" placeholder="Contoh: Kunjungan" class="form-control col-sm-12 col-12 ml-3" />' +
                '    </label>' +
                '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '    <label class="row-flex col-sm-2 col-2 no-padding">' +
                '        <input type="number" name="docter_do_subtotal[' + id + '][]" id="docter_do_subtotal_' + nXElem + '" class="docter_do_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_docterdo()" />' +
                '        <div class="col-form-label col-sm-1 col-1 add-pic text-right row-docter-' + nXElem + '" onclick="javascript:$(\'#row-docter-do-' + nXElem + '\').remove(); calculation_docterdo(this); calculation_total();"><i class="far fa-window-close"></i></div>' +
                '    </label>' +
                '</div>';

            $("#row-docter-do-div-" + id).append(htmlDocterDo)
        }

        function calculation_surgery(e) {
            var surgery_id = $(e).attr("data-id");
            
            var surgery_subtotal = $(e).val();
                surgery_subtotal = surgery_subtotal.split("-");
                surgery_subtotal = surgery_subtotal[1];

            $("#surgery_subtotal_" + surgery_id).val(surgery_subtotal);
            
            var st_surgery = 0;
            $.each($(".surgery_subtotal"), function(index, value) {
                st_surgery = st_surgery + parseInt($(value).val());
            })
            $(".subtotal-surgery").val(st_surgery);
            calculation_total();
        }

        function appendSurgeryElem() {
            var xElem = parseInt($(".row-surgery-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-surgery-div").attr("data-count", (xElem + 1));

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
                    if (response.hasOwnProperty('surgery')) {
                        var htmlSurgery = '' +
                            '<div class="row row-surgery col-sm-12 col-12" id="row-surgery-' + nXElem + '">'+
                            '   <select name="surgery[]" id="surgery_' + nXElem + '" class="surgery form-control select2 col-sm-9 col-9" data-id="' + nXElem + '" onchange="calculation_surgery(this);">' +
                            '       <option value="">-- Pilih Dokter Spesialis --</option>';

                        $.each(response.surgery, function(index, value) {
                            htmlSurgery += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })

                        htmlSurgery += '' +
                            '   </select>' +
                            '   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                            '   <label class="row-flex col-sm-2 col-2 no-padding">' +
                            '       <input type="number" name="surgery_subtotal[]" id="surgery_subtotal_' + nXElem + '" class="surgery_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_surgery(this);" />' +
                            '       <div class="col-form-label col-sm-1 col-1 add-pic text-right row-surgery-' + nXElem + '" data-id="' + nXElem + '" onclick="javascript:$(\'#row-surgery-' + nXElem + '\').remove(); calculation_surgery(this); calculation_total();"><i class="far fa-window-close"></i></div>' +
                            '   </label>' +
                            '</div>' +
                            '<div class="row-surgery-do-div col-sm-12 col-12 pl-0" id="row-surgery-do-div-' + nXElem + '" data-count="' + nXElem + '">' +
                            '</div>' +
                            '<label class="col-form-label add-pic ml-3" onclick="appendSurgeryDoElem(' + nXElem + ');">+ Tambahkan Tindakan Dokter Spesialis</label>';

                        $(".row-surgery-div").append(htmlSurgery);
                        $("#surgery_" + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function(e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        }

        function appendSurgeryDoElem(id) {
            var xElem = parseInt($(".row-surgery-do-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-surgery-do-div").attr("data-count", (xElem + 1));

            htmlSurgeryDo = ''+
                '<div class="row-flex row-surgery-do col-sm-12 col-12 pl-0" id="row-surgery-do-' + nXElem + '">' +
                '    <label class="row-flex col-sm-9 col-9 pr-3">' +
                '       <input type="text" name="surgery_do_value[' + id + '][]" id="surgery_do_value_' + nXElem + '" placeholder="Contoh: Kunjungan" class="form-control col-sm-12 col-12 ml-3" />' +
                '    </label>' +
                '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '    <label class="row-flex col-sm-2 col-2 no-padding">' +
                '        <input type="number" name="surgery_do_subtotal[' + id + '][]" id="surgery_do_subtotal_' + nXElem + '" class="surgery_do_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_surgerydo()" />' +
                '        <div class="col-form-label col-sm-1 col-1 add-pic text-right row-surgery-' + nXElem + '" onclick="javascript:$(\'#row-surgery-do-' + nXElem + '\').remove(); calculation_surgerydo(this); calculation_total();"><i class="far fa-window-close"></i></div>' +
                '    </label>' +
                '</div>';

            $("#row-surgery-do-div-" + id).append(htmlSurgeryDo)
        }

        function calculation_surgerydo() {
            var st_docter_do = 0;
            $.each($(".surgery_subtotal"), function(index, value) {
                st_docter_do = st_docter_do + parseInt($(value).val());
            })

            $.each($(".surgery_do_subtotal"), function(index, value) {
                st_docter_do = st_docter_do + parseInt($(value).val());
            })

            $(".subtotal-surgery").val(st_docter_do);
            calculation_total();
        }

        function calculation_surgery_nurse() {
            var st_surgery_nurse = 0;
            $.each($(".surgery_nurse_subtotal"), function(index, value) {
                st_surgery_nurse = st_surgery_nurse + parseInt($(value).val());
            })

            $(".subtotal-surgery-nurse").val(st_surgery_nurse);
            calculation_total();
        }

        function appendSurgeryNurseElem() {
            var xElem = parseInt($(".row-surgery-nurse-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-surgery-nurse-div").attr("data-count", (xElem + 1));

            $(".row-surgery-nurse-div").append(''+
                '<div class="row row-surgery-nurse col-sm-12 col-12" id="row-surgery-nurse-' + nXElem + '">' +
                '   <input type="text" name="surgery_nurse[]" id="surgery_nurse_' + nXElem + '" placeholder="Contoh: Jasa Perawat Anestesi" class="form-control col-sm-9 col-9" />' +
                '   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '   <label class="row-flex col-sm-2 col-2 no-padding">' +
                '       <input type="number" name="surgery_nurse_subtotal[]" id="surgery_nurse_subtotal_' + nXElem + '" class="surgery_nurse_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_surgery_nurse();" />' +
                '       <div class="col-form-label col-sm-1 col-1 add-pic text-right row-surgery-nurse-' + nXElem + '" onclick="javascript:$(\'#row-surgery-nurse-' + nXElem + '\').remove(); calculation_surgery_nurse(); calculation_total();"><i class="far fa-window-close"></i></div>' +
                '   </label>' +
                '</div>' +
            '');
        }

        function calculation_anestesi(e) {
            var anestesi_id = $(e).attr("data-id");
            
            var anestesi_subtotal = $(e).val();
                anestesi_subtotal = anestesi_subtotal.split("-");
                anestesi_subtotal = anestesi_subtotal[1];

            $("#anestesi_subtotal_" + anestesi_id).val(anestesi_subtotal);
            
            var st_anestesi = 0;
            $.each($(".anestesi_subtotal"), function(index, value) {
                st_anestesi = st_anestesi + parseInt($(value).val());
            })
            $(".subtotal-anestesi").val(st_anestesi);
            calculation_total();
        }

        function appendAnestesiElem() {
            var xElem = parseInt($(".row-anestesi-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-anestesi-div").attr("data-count", (xElem + 1));

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
                    if (response.hasOwnProperty('anestesi')) {
                        var htmlAnestesi = '' +
                            '<div class="row row-anestesi col-sm-12 col-12" id="row-anestesi-' + nXElem + '">'+
                            '   <select name="anestesi[]" id="anestesi_' + nXElem + '" class="anestesi form-control select2 col-sm-9 col-9" data-id="' + nXElem + '" onchange="calculation_anestesi(this);">' +
                            '       <option value="">-- Pilih Dokter Anestesi --</option>';

                        $.each(response.anestesi, function(index, value) {
                            htmlAnestesi += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })

                        htmlAnestesi += '' +
                            '   </select>' +
                            '   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                            '   <label class="row-flex col-sm-2 col-2 no-padding">' +
                            '       <input type="number" name="anestesi_subtotal[]" id="anestesi_subtotal_' + nXElem + '" class="anestesi_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_anestesi_do(this);" />' +
                            '       <div class="col-form-label col-sm-1 col-1 add-pic text-right row-anestesi-' + nXElem + '" data-id="' + nXElem + '" onclick="javascript:$(\'#row-anestesi-' + nXElem + '\').remove(); calculation_anestesi_do(this); calculation_total();"><i class="far fa-window-close"></i></div>' +
                            '   </label>' +
                            '</div>' +
                            '<div class="row-anestesi-do-div col-sm-12 col-12 pl-0" id="row-anestesi-do-div-' + nXElem + '" data-count="' + nXElem + '">' +
                            '</div>' +
                            '<label class="col-form-label add-pic ml-3" onclick="appendAnestesiDoElem(' + nXElem + ');">+ Tambahkan Tindakan Dokter Anestesi</label>';

                        $(".row-anestesi-div").append(htmlAnestesi);
                        $("#anestesi_" + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function(e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        }

        function calculation_anestesi_do() {
            var st_anestesi_do = 0;
            $.each($(".anestesi_subtotal"), function(index, value) {
                st_anestesi_do = st_anestesi_do + parseInt($(value).val());
            })

            $.each($(".anestesi_do_subtotal"), function(index, value) {
                st_anestesi_do = st_anestesi_do + parseInt($(value).val());
            })

            $(".subtotal-anestesi").val(st_anestesi_do);
            calculation_total();
        }

        function calculation_lab(e, is_lab = false, is_qty = false) {
            var lab_rate;
            var lab_id = $(e).attr("data-id");
            var pcs = $("#lab_qty_" + lab_id).val();
            
            if (is_lab === true) {
                lab_rate = $("#lab_rate_" + lab_id).val();
            } else if (is_lab === false && is_qty === true) {
                lab_rate = $(e).val();
            } else {
                lab_rate = $(e).val();
                lab_rate = lab_rate.split("-");
                lab_rate = lab_rate[1];
            }

            $("#lab_rate_" + lab_id).val(lab_rate);
            $("#lab_subtotal_" + lab_id).val(lab_rate * pcs);

            var st_lab = 0;
            $.each($(".lab_subtotal"), function(index, value) {
                st_lab = st_lab + parseInt($(value).val());
            })
            $(".subtotal-lab").val(st_lab);
            calculation_total();
        }

        function appendAnestesiDoElem(id) {
            var xElem = parseInt($(".row-anestesi-do-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-anestesi-do-div").attr("data-count", (xElem + 1));

            htmlAnestesiDo = ''+
                '<div class="row-flex row-anestesi-do col-sm-12 col-12 pl-0" id="row-anestesi-do-' + nXElem + '">' +
                '    <label class="row-flex col-sm-9 col-9 pr-3">' +
                '       <input type="text" name="anestesi_do_value[' + id + '][]" id="anestesi_do_value_' + nXElem + '" placeholder="Contoh: Kunjungan" class="form-control col-sm-12 col-12 ml-3" />' +
                '    </label>' +
                '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                '    <label class="row-flex col-sm-2 col-2 no-padding">' +
                '        <input type="number" name="anestesi_do_subtotal[' + id + '][]" id="anestesi_do_subtotal_' + nXElem + '" class="anestesi_do_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_anestesi_do(this)" />' +
                '        <div class="col-form-label col-sm-1 col-1 add-pic text-right row-anestesi-' + nXElem + '" onclick="javascript:$(\'#row-anestesi-do-' + nXElem + '\').remove(); calculation_anestesi_do(this); calculation_total();"><i class="far fa-window-close"></i></div>' +
                '    </label>' +
                '</div>';

            $("#row-anestesi-do-div-" + id).append(htmlAnestesiDo)
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
                        var htmlLab = '' +
                            '<div class="row row-lab col-sm-12 col-12" id="row-lab-' + nXElem + '">' +
                            '    <select name="lab[]" id="lab_' + nXElem + '" class="lab form-control select2 col-sm-4 col-4" data-id="' + nXElem + '" onchange="calculation_lab(this);">' +
                            '        <option value="">-- Pilih Laboratorium --</option>';

                        $.each(response.laboratory, function(index, value) {
                            htmlLab += '<option value="' + value.id + '-' + value.fare + '">' + value.name + '</option>';
                        })

                        htmlLab += '' +
                            '    </select>' +
                            '    <div class="row-flex col-sm-2 col-2">' +
                            '        <input type="number" name="lab_qty[]" id="lab_qty_' + nXElem + '" class="lab_qty form-control col-sm-8 col-8" min="1" value="1" data-id="' + nXElem + '" onchange="calculation_lab(this, true);" />' +
                            '        <label class="col-form-label col-sm-4 col-4 text-center">Pcs</label>' +
                            '    </div>' +
                            '    <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">' +
                            '        <label class="col-sm-5 col-5 text-center no-padding">X</label>' +
                            '        <label class="col-sm-7 col-7 pl-0">IDR</label>' +
                            '    </div>' +
                            '    <input type="number" name="lab_rate[]" id="lab_rate_' + nXElem + '" class="lab_rate form-control text-right col-sm-2 col-2" value="0" data-id="' + nXElem + '" onblur="calculation_lab(this, false, true);" />' +
                            '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>' +
                            '    <div class="row-flex col-sm-2 col-2 no-padding">' +
                            '        <input type="number" name="lab_subtotal[]" id="lab_subtotal_' + nXElem + '" class="lab_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />' +
                            '        <label class="col-form-label col-sm-1 col-1 add-pic text-right row-lab-' + nXElem + '" data-id="' + nXElem + '" onclick="javascript:$(\'#row-lab-' + nXElem + '\').remove(); calculation_lab(this); calculation_total();"><i class="far fa-window-close"></i></label>' +
                            '    </div>' +
                            '</div>';

                        $(".row-lab-div").append(htmlLab)
                        $("#lab_" + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function(e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        }

        function calculation_radiology(e, is_radiology = false, is_qty = false) {
            var radiology_rate;
            var radiology_id = $(e).attr("data-id");
            var pcs = $("#radiology_qty_" + radiology_id).val();
            
            if (is_radiology === true) {
                radiology_rate = $("#radiology_rate_" + radiology_id).val();
            } else if (is_radiology === false && is_qty === true) {
                radiology_rate = $(e).val();
            } else {
                radiology_rate = $(e).val();
                radiology_rate = radiology_rate.split("-");
                radiology_rate = radiology_rate[1];
            }

            $("#radiology_rate_" + radiology_id).val(radiology_rate);
            $("#radiology_subtotal_" + radiology_id).val(radiology_rate * pcs);

            var st_radiology = 0;
            $.each($(".radiology_subtotal"), function(index, value) {
                st_radiology = st_radiology + parseInt($(value).val());
            })
            $(".subtotal-radiology").val(st_radiology);
            calculation_total();
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
                        var htmlRadiology = '' +
                            '<div class="row row-radiology col-sm-12 col-12" id="row-radiology-' + nXElem + '">' +
                            '    <select name="radiology[]" id="radiology_' + nXElem + '" class="radiology form-control select2 col-sm-4 col-4" data-id="' + nXElem + '" onchange="calculation_radiology(this);">' +
                            '        <option value="">-- Pilih Radiologi --</option>';

                        $.each(response.radiology, function(index, value) {
                            htmlRadiology += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })

                        htmlRadiology += '' +
                            '    </select>' +
                            '    <div class="row-flex col-sm-2 col-2">' +
                            '        <input type="number" name="radiology_qty[]" id="radiology_qty_' + nXElem + '" class="radiology_qty form-control col-sm-8 col-8" min="1" value="1" data-id="' + nXElem + '" onchange="calculation_radiology(this, true);" />' +
                            '        <label class="col-form-label col-sm-4 col-4 text-center">Pcs</label>' +
                            '    </div>' +
                            '    <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">' +
                            '        <label class="col-sm-5 col-5 text-center no-padding">X</label>' +
                            '        <label class="col-sm-7 col-7 pl-0">IDR</label>' +
                            '    </div>' +
                            '    <input type="number" name="radiology_rate[]" id="radiology_rate_' + nXElem + '" class="radiology_rate form-control text-right col-sm-2 col-2" value="0" data-id="' + nXElem + '" onblur="calculation_radiology(this, false, true);" />' +
                            '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>' +
                            '    <div class="row-flex col-sm-2 col-2 no-padding">' +
                            '        <input type="number" name="radiology_subtotal[]" id="radiology_subtotal_' + nXElem + '" class="radiology_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />' +
                            '        <label class="col-form-label col-sm-1 col-1 add-pic text-right row-radiology-' + nXElem + '" data-id="' + nXElem + '" onclick="javascript:$(\'#row-radiology-' + nXElem + '\').remove(); calculation_radiology(this); calculation_total();"><i class="far fa-window-close"></i></label>' +
                            '    </div>' +
                            '</div>';

                        $(".row-radiology-div").append(htmlRadiology)
                        $("#radiology_" + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function(e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        }

        function calculation_medic(e, is_medic = false, is_qty = false) {
            var medic_rate;
            var medic_id = $(e).attr("data-id");
            var pcs = $("#medic_qty_" + medic_id).val();
            
            if (is_medic === true) {
                medic_rate = $("#medic_rate_" + medic_id).val();
            } else if (is_medic === false && is_qty === true) {
                medic_rate = $(e).val();
            } else {
                medic_rate = $(e).val();
                medic_rate = medic_rate.split("-");
                medic_rate = medic_rate[1];
            }

            $("#medic_rate_" + medic_id).val(medic_rate);
            $("#medic_subtotal_" + medic_id).val(medic_rate * pcs);

            var st_medic = 0;
            $.each($(".medic_subtotal"), function(index, value) {
                st_medic = st_medic + parseInt($(value).val());
            })
            $(".subtotal-medic").val(st_medic);
            calculation_total();
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
                        var htmlMedic = '' +
                            '<div class="row row-medic col-sm-12 col-12" id="row-medic-' + nXElem + '">' +
                            '    <select name="medic[]" id="medic_' + nXElem + '" class="medic form-control select2 col-sm-4 col-4" data-id="' + nXElem + '" onchange="calculation_medic(this);">' +
                            '        <option value="">-- Pilih Medikal --</option>';

                        $.each(response.medic, function(index, value) {
                            htmlMedic += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })

                        htmlMedic += '' +
                            '    </select>' +
                            '    <div class="row-flex col-sm-2 col-2">' +
                            '        <input type="number" name="medic_qty[]" id="medic_qty_' + nXElem + '" class="medic_qty form-control col-sm-8 col-8" min="1" value="1" data-id="' + nXElem + '" onchange="calculation_medic(this, true);" />' +
                            '        <label class="col-form-label col-sm-4 col-4 text-center">Pcs</label>' +
                            '    </div>' +
                            '    <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">' +
                            '        <label class="col-sm-5 col-5 text-center no-padding">X</label>' +
                            '        <label class="col-sm-7 col-7 pl-0">IDR</label>' +
                            '    </div>' +
                            '    <input type="number" name="medic_rate[]" id="medic_rate_' + nXElem + '" class="medic_rate form-control text-right col-sm-2 col-2" value="0" data-id="' + nXElem + '" onblur="calculation_medic(this, false, true);" />' +
                            '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>' +
                            '    <div class="row-flex col-sm-2 col-2 no-padding">' +
                            '        <input type="number" name="medic_subtotal[]" id="medic_subtotal_' + nXElem + '" class="medic_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />' +
                            '        <label class="col-form-label col-sm-1 col-1 add-pic text-right row-medic-' + nXElem + '" data-id="' + nXElem + '" onclick="javascript:$(\'#row-medic-' + nXElem + '\').remove(); calculation_medic(this); calculation_total();"><i class="far fa-window-close"></i></label>' +
                            '    </div>' +
                            '</div>';

                        $(".row-medic-div").append(htmlMedic)
                        $("#medic_" + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function(e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        }

        function calculation_rehab(e, is_rehab = false, is_qty = false) {
            var rehab_rate;
            var rehab_id = $(e).attr("data-id");
            var pcs = $("#rehab_qty_" + rehab_id).val();
            
            if (is_rehab === true) {
                rehab_rate = $("#rehab_rate_" + rehab_id).val();
            } else if (is_rehab === false && is_qty === true) {
                rehab_rate = $(e).val();
            } else {
                rehab_rate = $(e).val();
                rehab_rate = rehab_rate.split("-");
                rehab_rate = rehab_rate[1];
            }

            $("#rehab_rate_" + rehab_id).val(rehab_rate);
            $("#rehab_subtotal_" + rehab_id).val(rehab_rate * pcs);

            var st_rehab = 0;
            $.each($(".rehab_subtotal"), function(index, value) {
                st_rehab = st_rehab + parseInt($(value).val());
            })
            $(".subtotal-rehab").val(st_rehab);
            calculation_total();
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
                        var htmlRehab = '' +
                            '<div class="row row-rehab col-sm-12 col-12" id="row-rehab-' + nXElem + '">' +
                            '    <select name="rehab[]" id="rehab_' + nXElem + '" class="rehab form-control select2 col-sm-4 col-4" data-id="' + nXElem + '" onchange="calculation_rehab(this);">' +
                            '        <option value="">-- Pilih Rehab Medik --</option>';

                        $.each(response.rehab, function(index, value) {
                            htmlRehab += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })

                        htmlRehab += '' +
                            '    </select>' +
                            '    <div class="row-flex col-sm-2 col-2">' +
                            '        <input type="number" name="rehab_qty[]" id="rehab_qty_' + nXElem + '" class="rehab_qty form-control col-sm-8 col-8" min="1" value="1" data-id="' + nXElem + '" onchange="calculation_rehab(this, true);" />' +
                            '        <label class="col-form-label col-sm-4 col-4 text-center">Pcs</label>' +
                            '    </div>' +
                            '    <div class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">' +
                            '        <label class="col-sm-5 col-5 text-center no-padding">X</label>' +
                            '        <label class="col-sm-7 col-7 pl-0">IDR</label>' +
                            '    </div>' +
                            '    <input type="number" name="rehab_rate[]" id="rehab_rate_' + nXElem + '" class="rehab_rate form-control text-right col-sm-2 col-2" value="0" data-id="' + nXElem + '" onblur="calculation_rehab(this, false, true);" />' +
                            '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>' +
                            '    <div class="row-flex col-sm-2 col-2 no-padding">' +
                            '        <input type="number" name="rehab_subtotal[]" id="rehab_subtotal_' + nXElem + '" class="rehab_subtotal form-control text-right col-sm-11 col-11" value="0" readonly />' +
                            '        <label class="col-form-label col-sm-1 col-1 add-pic text-right row-rehab-' + nXElem + '" data-id="' + nXElem + '" onclick="javascript:$(\'#row-rehab-' + nXElem + '\').remove(); calculation_rehab(this); calculation_total();"><i class="far fa-window-close"></i></label>' +
                            '    </div>' +
                            '</div>';

                        $(".row-rehab-div").append(htmlRehab)
                        $("#rehab_" + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function(e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        }

        function calculation_ambulance(e) {
            var ambulance_id = $(e).attr("data-id");
            
            var fare = $(e).val();
                fare = fare.split("-");
                fare = fare[1];

            $("#ambulance_subtotal_" + ambulance_id).val(fare);

            var st_ambulance = 0;
            $.each($(".ambulance_subtotal"), function(index, value) {
                st_ambulance = st_ambulance + parseInt($(value).val());
            })
            $(".subtotal-ambulance").val(st_ambulance);
            calculation_total();
        }

        function appendAmbulanceElem() {
            var xElem = parseInt($(".row-ambulance-div").attr("data-count"));
            var nXElem = xElem + 1;
            $(".row-ambulance-div").attr("data-count", (xElem + 1));

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
                    if (response.hasOwnProperty('ambulance')) {
                        var htmlAmbulance = '' +
                            '<div class="row row-ambulance col-sm-12 col-12" id="row-ambulance-' + nXElem + '">'+
                            '   <select name="ambulance[]" id="ambulance_' + nXElem + '" class="ambulance form-control select2 col-sm-9 col-9" data-id="' + nXElem + '" onchange="calculation_ambulance(this);">' +
                            '       <option value="">-- Pilih Ambulance --</option>';

                        $.each(response.ambulance, function(index, value) {
                            htmlAmbulance += '<option value="' + value.id + '-' + value.fare + '">' + value.value + '</option>';
                        })

                        htmlAmbulance += '' +
                            '   </select>' +
                            '   <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>' +
                            '   <label class="row-flex col-sm-2 col-2 no-padding">' +
                            '       <input type="number" name="ambulance_subtotal[]" id="ambulance_subtotal_' + nXElem + '" class="ambulance_subtotal form-control text-right col-sm-11 col-11" value="0" onblur="calculation_ambulance(this);" />' +
                            '       <div class="col-form-label col-sm-1 col-1 add-pic text-right row-ambulance-' + nXElem + '" data-id="' + nXElem + '" onclick="javascript:$(\'#row-ambulance-' + nXElem + '\').remove(); calculation_ambulance(this); calculation_total();"><i class="far fa-window-close"></i></div>' +
                            '   </label>' +
                            '</div>';

                        $(".row-ambulance-div").append(htmlAmbulance);
                        $("#ambulance_" + nXElem).select2({
                            theme: 'bootstrap4'
                        }).one('select2:open', function(e) {
                            $('input.select2-search__field').prop('placeholder', 'Cari disini...');
                        });
                    }
                }
            })
        }

        function calculation_total()
        {
            var subtotal = 0;
            $.each($(".subtotal"), function(index, value) {
                subtotal = subtotal + parseInt($(value).val());
            })
            $(".total").val(subtotal);
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