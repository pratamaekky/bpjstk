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
                            <h1 class="m-0">Data Rumah Sakit</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Master Data</li>
                            </ol>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-success float-sm-right ml-2" data-toggle="modal" data-target="#modal-hospital"><i class="fas fa-plus"></i> Tambah Rumah Sakit</button>
                            <button type="button" class="btn btn-outline-success float-sm-right"><i class="far fa-file-alt"></i> Import</button>
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
                                    <table id="tableHospitalLists" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="dt-head-center">No</th>
                                                <th class="dt-head-center">Nama Rumah Sakit</th>
                                                <th class="dt-head-center">Alamat</th>
                                                <th class="dt-head-center">No Telp</th>
                                                <th class="dt-head-center">Jenis</th>
                                                <th class="dt-head-center">Kelas</th>
                                                <th class="dt-head-center">Kepemilikan</th>
                                                <th class="dt-head-center" style="width: 60px;">Aksi</th>
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

    <div class="modal fade modal-overflow" id="modal-hospital">
        <form name="hospitalForm" id="hospitalForm" enctype="multipart/form-data" novalidate="novalidate">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-modal-form">Tambah Rumah Sakit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <label class="modal-seg col-12">Informasi Rumah Sakit</label>
                        <div class="col-12 col-sm-6">
                            <input type="hidden" name="id" id="id" class="form-control" value="" />
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="name">Nama Rumah Sakit</label>
                                    <div class="input-group">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Rumah Sakit Umum Daerah" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="type">Jenis Rumah Sakit</label>
                                    <div class="input-group">
                                        <select name="type" id="type" class="form-control select2" required="required">
                                            <option value="">-- Pilih Jenis Rumah Sakit --</option>
                                            <?php 
                                            if (!is_null($getHospitalType)) {
                                                foreach ($getHospitalType as $hospitalType) {
                                                    echo '<option value="' . $hospitalType->id . '">' . $hospitalType->value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="class">Kelas rumah Sakit</label>
                                    <div class="input-group">
                                        <input type="text" name="class" id="class" class="form-control" placeholder="Contoh: A" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="status_blu">Status BLU</label>
                                    <div class="input-group">
                                        <input type="text" name="status_blu" id="status_blu" class="form-control" placeholder="Contoh: BLUD" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="owner">Kepemilikan</label>
                                    <div class="input-group">
                                        <select name="owner" id="owner" class="form-control select2" required="required">
                                            <option value="">-- Pilih Kepemilikan Rumah Sakit --</option>
                                            <?php 
                                            if (!is_null($getHospitalOwner)) {
                                                foreach ($getHospitalOwner as $hospitalOwner) {
                                                    echo '<option value="' . $hospitalOwner->id . '">' . $hospitalOwner->value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="directur">Direktur</label>
                                    <div class="input-group">
                                        <input type="text" name="directur" id="directur" class="form-control" placeholder="Contoh: Budi Gunadi Sadikin" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="land_area">Luas Tanah</label>
                                    <div class="input-group">
                                        <input type="text" name="land_area" id="land_area" class="form-control" placeholder="Contoh: 1234" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="building_area">Luas Bangunan</label>
                                    <div class="input-group">
                                        <input type="text" name="building_area" id="building_area" class="form-control" placeholder="Contoh: 1234" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="telp">No Telepon</label>
                                    <div class="input-group">
                                        <input type="text" name="telp" id="telp" class="form-control" placeholder="Contoh: 082221111111" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="province_id">Provinsi</label>
                                    <div class="input-group">
                                        <select name="province_id" id="province_id" class="form-control select2" required="required">
                                            <option value="">-- Pilih Provinsi --</option>
                                            <?php
                                            if (!is_null($getProvince)) {
                                                foreach ($getProvince as $province) {
                                                    echo '<option value="' . $province->id . '">' . $province->name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="city_id">Kota / Kabupaten</label>
                                    <div class="input-group">
                                        <select name="city_id" id="city_id" class="form-control select2" required="required" disabled>
                                            <option value="">-- Pilih Kota / Kabupaten --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="district_id">Kecamatan</label>
                                    <div class="input-group">
                                        <select name="district_id" id="district_id" class="form-control select2" required="required" disabled>
                                            <option value="">-- Pilih Kecamatan --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="postalcode">Kodepos</label>
                                    <div class="input-group">
                                        <input type="hidden" name="village_id" id="village_id" value="" />
                                        <select name="postalcode" id="postalcode" class="form-control select2" required="required" disabled>
                                            <option value="">-- Pilih Kodepos --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="address">Alamat</label>
                                    <textarea name="address" id="address" class="form-control" placeholder="Contoh: Jalan Masih Panjang No. 69" rows="6"></textarea>
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
    <!-- BootBox -->
    <script src="<?php echo base_url("assets/js/bootstarp-bootbox.min.js"); ?>"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url("assets/plugins/select2/js/select2.full.min.js"); ?>"></script>
    <script>
        $(document).ready(function(){
            $('#tableHospitalLists').DataTable({
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
                    emptyTable: "No record found",
                    search: "",
                    infoFiltered: ""
                },
                'ajax': {
                    'url':'<?php echo base_url("master/hospital/data"); ?>',
                    'type': 'POST',
                    'data': {'action':'#tableHospitalLists'}
                },
                'columns': [
                    { data: 'no', className: 'dt-body-center' },
                    { data: 'name' },
                    { data: 'address' },
                    { data: 'telp' },
                    { data: 'type' },
                    { data: 'class' },
                    { data: 'owner' },
                    { data: 'action' },
                ],
                "columnDefs":[
                    {
                        "targets":[0, 2, 3, 7],
                        "orderable":false,
                    },
                ]
            });
        });

        $("#province_id").on("change", function(e) {
            var idProvince = this.value;
            $('.overlay-loading').show();

            $.ajax({
                url: "<?php echo base_url('master/datas/city'); ?>",
                type: "POST",
                data: {
                    id: idProvince
                },
                dataType: "JSON",
                success: function(response) {
                    var cityOption = '<option value="">-- Pilih Kota / Kabupaten --</option>';
                    $.each(response, function(k, v) {
                        cityOption += '<option value="' + v.id + '">' + v.name + '</option>'
                    })
                    $("#city_id").html(cityOption);
                    $("#city_id").removeAttr("disabled");
                    $('.overlay-loading').hide();
                },
                error: function(error) {
                    $('.overlay-loading').hide();
                    show_notif("error", "Gagal Update Data! Ulangi beberapa saat lagi")
                }
            });
        })

        $("#city_id").on("change", function(e) {
            var idCity = this.value;
            $('.overlay-loading').show();

            $.ajax({
                url: "<?php echo base_url('master/datas/district'); ?>",
                type: "POST",
                data: {
                    id: idCity
                },
                dataType: "JSON",
                success: function(response) {
                    var districtOption = '<option value="">-- Pilih Kecamatan --</option>';
                    $.each(response, function(k, v) {
                        districtOption += '<option value="' + v.id + '">' + v.name + '</option>'
                    })
                    $("#district_id").html(districtOption);
                    $("#district_id").removeAttr("disabled");
                    $('.overlay-loading').hide();
                },
                error: function(error) {
                    $('.overlay-loading').hide();
                    show_notif("error", "Gagal Update Data! Ulangi beberapa saat lagi")
                }
            });
        })

        $("#district_id").on("change", function(e) {
            var idProvince = $('#province_id').find(":selected").val();
            var idCity = $('#city_id').find(":selected").val();
            var idDistrict = this.value;
            $('.overlay-loading').show();

            $.ajax({
                url: "<?php echo base_url('master/datas/postalcode'); ?>",
                type: "POST",
                data: {
                    idProvince: idProvince,
                    idCity: idCity,
                    idDistrict: idDistrict
                },
                dataType: "JSON",
                success: function(response) {
                    var kodeposOption = '<option value="">-- Pilih Kodepos --</option>';
                    $.each(response, function(k, v) {
                        kodeposOption += '<option value="' + v.postal_code + '" data-village-id="' + v.id_village + '">' + v.village + ' (' + v.postal_code + ')</option>'
                    })
                    $("#postalcode").html(kodeposOption);
                    $("#postalcode").removeAttr("disabled");
                    $('.overlay-loading').hide();
                },
                error: function(error) {
                    $('.overlay-loading').hide();
                    show_notif("error", "Gagal Update Data! Ulangi beberapa saat lagi")
                }
            });
        })

        $("#postalcode").on("change", function(e) {
            var idVillage = $('option:selected', this).attr('data-village-id');
            $("#village_id").val(idVillage);
        })

        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            }).one('select2:open', function(e) {
                $('input.select2-search__field').prop('placeholder', 'Cari disini...');
            });
            
            $.validator.setDefaults({
                ignore: ":hidden, [contenteditable='true']:not([name])",
                submitHandler: function(form) {
                    // $('.overlay-loading').show();

                    var todo = $("#todo").val();
                    var url;
                    if (todo == "update") {
                        url = "<?php echo base_url('master/hospital/update'); ?>";
                    } else {
                        url = "<?php echo base_url('master/hospital/save'); ?>"
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
            $('#hospitalForm').validate({
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

        function editHospital(id) {
            var hospitalOwnerHtml = "", hospitalTypeHtml = "", provinceHtml = "", cityHtml = "", districtHtml = "", postalHtml = "";
            var selectedHO = "", selectedHT = "", selectedProv = "", selectedCity = "", selectedDistrict = "", selectedPostal = "";
            $.ajax({
                url: "<?php echo base_url('master/hospital/detail'); ?>",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    hospital = response.hospital;
                    hospitalType = response.hospitalType;
                    hospitalOwner = response.hospitalOwner;
                    province = response.province;
                    city = response.city;
                    district = response.district;
                    postal = response.postal;
                    $("#id").val(hospital.id);
                    $("#name").val(hospital.name);
                    $("#telp").val(hospital.telp);
                    $("#class").val(hospital.class);
                    $("#status_blu").val(hospital.status_blu);
                    $("#directur").val(hospital.directur);
                    $("#land_area").val(hospital.land_area);
                    $("#building_area").val(hospital.building_area);
                    $("#address").val(hospital.address);
                    $("#village_id").val(hospital.village_id);

                    hospitalTypeHtml += '  <option value="">-- Pilih Jenis Rumah Sakit --</option>';
                    $.each(hospitalType, function(keyHt, ht) {
                        selectedHT = "";
                        if (hospital.hospital_type == ht.value) {
                            selectedHT = 'selected="selected"';
                        }

                        hospitalTypeHtml += '<option value="' + ht.id + '" ' + selectedHT + '>' + ht.value + '</option>';
                    });

                    hospitalOwnerHtml += '  <option value="">-- Pilih Kepemilikan Rumah Sakit --</option>';
                    $.each(hospitalOwner, function(keyHo, ho) {
                        selectedHO = "";
                        if (hospital.hospital_owner == ho.value) {
                            selectedHO = 'selected="selected"';
                        }

                        hospitalOwnerHtml += '<option value="' + ho.id + '" ' + selectedHO + '>' + ho.value + '</option>';
                    });

                    provinceHtml += '  <option value="">-- Pilih Provinsi --</option>';
                    $.each(province, function(keyProv, prov) {
                        selectedProv = "";
                        if (hospital.province_id == prov.id) {
                            selectedProv = 'selected="selected"';
                        }

                        provinceHtml += '<option value="' + prov.id + '" ' + selectedProv + '>' + prov.name + '</option>';
                    });

                    cityHtml += '  <option value="">-- Pilih Kota / Kabupaten --</option>';
                    $.each(city, function(keyCity, ci) {
                        selectedCity = "";
                        if (hospital.city_id == ci.id) {
                            selectedCity = 'selected="selected"';
                        }

                        cityHtml += '<option value="' + ci.id + '" ' + selectedCity + '>' + ci.name + '</option>';
                    });

                    districtHtml += '  <option value="">-- Pilih Kecamatan --</option>';
                    $.each(district, function(keyDistrict, dist) {
                        selectedDistrict = "";
                        if (hospital.district_id == dist.id) {
                            selectedDistrict = 'selected="selected"';
                        }

                        districtHtml += '<option value="' + dist.id + '" ' + selectedDistrict + '>' + dist.name + '</option>';
                    });

                    postalHtml += '  <option value="">-- Pilih Kodepos --</option>';
                    $.each(postal, function(keyPostal, postal) {
                        selectedPostal = "";
                        if (hospital.village_id == postal.id) {
                            selectedPostal = 'selected="selected"';
                        }

                        postalHtml += '<option value="' + postal.postal_code + '" data-village-id="' + postal.id_village + '" ' + selectedPostal + '>' + postal.village + ' (' + postal.postal_code + ')</option>';
                    });

                    $("#type").html(hospitalTypeHtml);
                    $("#owner").html(hospitalOwnerHtml);
                    $("#province_id").html(provinceHtml);
                    $("#city_id").html(cityHtml);
                    $("#city_id").removeAttr("disabled")
                    $("#district_id").html(districtHtml);
                    $("#district_id").removeAttr("disabled")
                    $("#postalcode").html(postalHtml);
                    $("#postalcode").removeAttr("disabled")
                    $("#btnForm").html("Update");
                    $("#todo").val("update");

                    $("#modal-hospital").modal("toggle");
                },
                error: function(error) {
                    $('.overlay-loading').hide();
                    show_notif("error", "Gagal Update Data! Ulangi beberapa saat lagi")
                }
            });

        }

        function deleteHospital(id) {
            bootbox.confirm({
                title: "Hapus Rumah Sakit",
                message: "Apakah kamu yakin untuk menghapus rumah sakit ini? Aksi ini tidak bisa di kembalikan",
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
                        // $('.overlay-loading').show();
                        $.ajax({
                            url: '<?php echo base_url("master/hospital/delete"); ?>',
                            type: "post",
                            dataType: "json",
                            data: {
                                id: id
                            },
                            success: function(response) {
                                // $('.overlay-loading').hide();
                                if (response.result == 200) {
                                    // $("#tableHospitalLists").DataTable().destroy();
                                    $('#tableHospitalLists').DataTable().ajax.reload()
                                    show_notif('success', response.data.name);
                                }
                            }
                        });
                    } else {
                        show_notif('info', 'Rumah sakit batal dihapus');
                    }
                }
            });
        }
</script>
</body>

</html>