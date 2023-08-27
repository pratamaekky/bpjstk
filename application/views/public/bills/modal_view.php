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
                            <label for="npp" class="col-form-label col-sm-3 col-3">NPP</label>
                            <div class="input-group col-sm-9 col-9">
                                <label class="form-control">[INFO_PATIENT_NPP]</label>
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
                            <label for="name" class="col-form-label col-sm-3 col-3">Jenis Kelamin</label>
                            <div class="input-group col-sm-9 col-9">
                                <label class="form-control">[INFO_PATIENT_JENIS_KELAMIN]</label>
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
                            <label for="npp" class="col-form-label col-sm-3 col-3">Lokasi</label>
                            <div class="input-group col-sm-9 col-9">
                                <label class="form-control">[INFO_PATIENT_LOKASI]</label>
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
                                <p class="form-control text-bold" style="height: 62px;">[INFO_DIAGNOSE]</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label for="action" class="col-form-label col-sm-3 col-3">Tindakan</label>
                            <div class="input-group col-sm-9 col-9">
                                <p class="form-control text-bold" style="height: 62px;">[INFO_ACTION]</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label for="action" class="col-form-label col-sm-3 col-3">Keterangan</label>
                            <div class="input-group col-sm-9 col-9">
                                <p class="form-control text-bold" style="height: 62px;">[INFO_VERIFICATION]</p>
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
                    <div class="card-outline card-outline-tabs col-12" id="bills-form">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="yankes-ranap-tab" data-toggle="pill" href="#yankes-ranap-view" role="tab" aria-controls="yankes-ranap" aria-selected="true">RANAP</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="yankes-rajal-tab" data-toggle="pill" href="#yankes-rajal-view" role="tab" aria-controls="yankes-rajal" aria-selected="false">RAJAL</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body" style="padding-left: 0; padding-right: 0;">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade show active" id="yankes-ranap-view" role="tabpanel" aria-labelledby="yankes-ranap-tab">
                                    <div class="yankes-div" id="ctc-yankes-ranap" data-elem="true">
                                        [DETAIL_BILLS_RANAP]
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="yankes-rajal-view" role="tabpanel" aria-labelledby="yankes-rajal-tab">
                                    <div class="yankes-div" id="ctc-yankes-rajal" data-elem="true">
                                        [DETAIL_BILLS_RAJAL]
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
                                <label class="form-control col-sm-11 col-11 text-right">[INFO_TOTAL_BAYAR]</label>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-12 separate-div-bottom" id="div_total">
                        <div class="row">
                            <label class="col-form-label col-sm-9 col-9">TOTAL</label>
                            <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>
                            <label class="row-flex col-form-label col-sm-2 col-2 no-padding pr-1">
                                <label class="form-control col-sm-11 col-11 text-right">[INFO_TOTAL]</label>
                            </label>
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
