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
                                <label class="form-control">[INFO_HOSPITAL_NAME]</label>
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
                                <label class="form-control">[INFO_PATIENT_KPJ]</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <div class="row">
                            <label for="company" class="col-form-label col-sm-3 col-3">Perusahaan</label>
                            <div class="input-group col-sm-9 col-9">
                                <label class="form-control">[INFO_PATIENT_COMPANY]</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <div class="row">
                            <label for="name" class="col-form-label col-sm-3 col-3">Nama Pasien</label>
                            <div class="input-group col-sm-9 col-9">
                                <label class="form-control">[INFO_PATIENT_NAME]</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <div class="row">
                            <label for="npp" class="col-form-label col-sm-3 col-3">NPP</label>
                            <div class="input-group col-sm-9 col-9">
                                <label class="form-control">[INFO_PATIENT_NPP]</label>
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
                                <label class="form-control">[INFO_JKK]</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <div class="row">
                            <label for="last_condition" class="col-form-label col-sm-3 col-3">Kondisi Akhir</label>
                            <div class="input-group col-sm-9 col-9">
                                <label class="form-control">[INFO_LAST_CONDITION]</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <div class="row">
                            <label for="treatment_date" class="col-form-label col-sm-3 col-3">Tanggal Berobat</label>
                            <div class="input-group col-sm-9 col-9">
                                <label class="form-control">[INFO_TREATMENT_DATE]</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <div class="row" id="elem-stmb">
                            <label for="stmb" class="col-form-label col-sm-3 col-3">STMB</label>
                            <div class="col-sm-9 col-9">
                                [INFO_STMB]
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
                                <label class="form-control">[INFO_RANAP]</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label for="last_rajal" class="col-form-label col-sm-3 col-3">Rajal Terakhir</label>
                            <div class="input-group col-sm-9 col-9">
                                <label class="form-control">[INFO_RAJAL]</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label for="dx_sekunder" class="col-form-label col-sm-3 col-3">DX Sekunder</label>
                            <div class="input-group col-sm-9 col-9">
                                <label class="form-control">[INFO_DX_SEKUNDER]</label>
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
                                <p class="form-control" style="height: 62px;">[INFO_DIAGNOSE]</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label for="action" class="col-form-label col-sm-3 col-3">Tindakan</label>
                            <div class="input-group col-sm-9 col-9">
                                <p class="form-control" style="height: 62px;">[INFO_ACTION]</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label for="action" class="col-form-label col-sm-3 col-3">Keterangan</label>
                            <div class="input-group col-sm-9 col-9">
                                <p class="form-control" style="height: 62px;">[INFO_VERIFICATION]</p>
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
                                                <label class="col-sm-9 col-9">&nbsp;</label>
                                                <label class="col-form-label col-sm-1 col-1 text-right"> IDR </label>
                                                <label class="form-control col-sm-2 col-2 text-right">[INFO_COB]</label>
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
                                <label class="form-control">[INFO_YANKES]</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_room">
                        <div class="row">
                            <label for="room" class="col-form-label col-sm-3 col-3">Kamar</label>
                            <div class="input-group col-sm-9 col-9">
                                [INFO_YANKES_ROOM]
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_room_nurse">
                        <div class="row">
                            <label for="room-nurse" class="col-form-label col-sm-3 col-3">Jasa Perawat Kamar</label>
                            <div class="input-group col-sm-9 col-9">
                                [INFO_YANKES_ROOM_NURSE]
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_admin">
                        <div class="row">
                            <label for="admin" class="col-form-label col-sm-3 col-3">Administrasi</label>
                            <div class="input-group col-sm-9 col-9">
                                [INFO_YANKES_ADMIN]
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_medicine">
                        <div class="row">
                            <label for="medicine" class="col-form-label col-sm-3 col-3">Obat-Obatan</label>
                            <div class="input-group col-sm-9 col-9">
                                [INFO_YANKES_MEDICINE]
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_docter">
                        <div class="row">
                            <label for="docter" class="col-form-label col-sm-3 col-3">Dokter</label>
                            <div class="input-group col-sm-9 col-9">
                                [INFO_YANKES_DOCTER]
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_surgery">
                        <div class="row">
                            <label for="surgery" class="col-form-label col-sm-3 col-3">Dokter Anestesi</label>
                            <div class="input-group col-sm-9 col-9">
                                [INFO_YANKES_SURGERY]
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_surgery_nurse">
                        <div class="row">
                            <label for="surgery-nurse" class="col-form-label col-sm-3 col-3">Jasa Perawat Operasi</label>
                            <div class="input-group col-sm-9 col-9">
                                [INFO_YANKES_SURGERY_NURSE]
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_lab">
                        <div class="row">
                            <label for="lab" class="col-form-label col-sm-3 col-3">Laboratorium</label>
                            <div class="input-group col-sm-9 col-9">
                                [INFO_YANKES_LAB]
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_radiology">
                        <div class="row">
                            <label for="radiology" class="col-form-label col-sm-3 col-3">Radiologi</label>
                            <div class="input-group col-sm-9 col-9">
                                [INFO_YANKES_RADIOLOGY]
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_medic">
                        <div class="row">
                            <label for="medic" class="col-form-label col-sm-3 col-3">Medikal</label>
                            <div class="input-group col-sm-9 col-9">
                                [INFO_YANKES_MEDIC]
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_rehab">
                        <div class="row">
                            <label for="rehab" class="col-form-label col-sm-3 col-3">Rehabilitasi</label>
                            <div class="input-group col-sm-9 col-9">
                                [INFO_YANKES_REHAB]
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_rehab">
                        <div class="row">
                            <label class="col-form-label col-sm-9 col-9">TOTAL</label>
                            <label class="col-form-label col-sm-1 col-1 text-right"> IDR </label>
                            <label class="form-control col-sm-2 col-2 text-right">[INFO_TOTAL]</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="button-seg">
                <input type="hidden" name="todo" id="todo" value="" />
                <button type="button" class="btn btn-default" id="modal-close" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
