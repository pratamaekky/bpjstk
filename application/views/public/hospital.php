<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_header_script.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
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
                                    <div class="div_table-bordered">
                                        <table id="tableHospitalLists" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th align="center">No</th>
                                                    <th align="center">Nama Rumah Sakit</th>
                                                    <th>Alamat</th>
                                                    <th>No Telp</th>
                                                    <th>Jenis</th>
                                                    <th>Kelas</th>
                                                    <th>Kepemilikan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
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
        <form name="projectForm" id="projectForm" enctype="multipart/form-data" novalidate="novalidate">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-modal-form">Tambah Rumah Sakit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="project_id" id="project_id" value="" />
                        <label class="modal-seg col-12">Informasi Rumah Sakit</label>
                        <div class="col-12 col-sm-6">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="project_name">Nama Rumah Sakit</label>
                                    <div class="input-group">
                                        <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Contoh: Rumah Sakit Umum Daerah" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_link">Jenis Rumah Sakit</label>
                                    <div class="input-group">
                                        <input type="text" name="project_link" id="project_link" class="form-control" placeholder="Contoh: http://www.telkomsel.com" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_progress">Kelas rumah Sakit</label>
                                    <div class="input-group">
                                        <input type="text" name="project_link" id="project_link" class="form-control" placeholder="Contoh: http://www.telkomsel.com" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_deadline">Status BLU</label>
                                    <div class="input-group">
                                        <input type="text" name="project_link" id="project_link" class="form-control" placeholder="Contoh: http://www.telkomsel.com" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_deadline">Kepemilikan</label>
                                    <div class="input-group">
                                        <input type="text" name="project_link" id="project_link" class="form-control" placeholder="Contoh: http://www.telkomsel.com" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_deadline">Direktur</label>
                                    <div class="input-group">
                                        <input type="text" name="project_link" id="project_link" class="form-control" placeholder="Contoh: http://www.telkomsel.com" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_deadline">Luas Tanah</label>
                                    <div class="input-group">
                                        <input type="text" name="project_link" id="project_link" class="form-control" placeholder="Contoh: http://www.telkomsel.com" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="project_divisi">Provinsi</label>
                                    <div class="input-group">
                                        <select name="project_divisi" id="project_divisi" class="form-control" required="required">
                                            <option value="">-- Pilih Provinsi --</option>
                                            <?php
                                            if (!is_null($usersDivisi)) {
                                                foreach ($usersDivisi as $divisi) {
                                                    echo '<option value="' . $divisi->id . '">' . $divisi->value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_divisi">Kota / Kabupaten</label>
                                    <div class="input-group">
                                        <select name="project_divisi" id="project_divisi" class="form-control" required="required" disabled>
                                            <option value="">-- Pilih Kota / Kabupaten --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_divisi">Kecamatan</label>
                                    <div class="input-group">
                                        <select name="project_divisi" id="project_divisi" class="form-control" required="required" disabled>
                                            <option value="">-- Pilih Kecamatan --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_divisi">Kodepos</label>
                                    <div class="input-group">
                                        <select name="project_divisi" id="project_divisi" class="form-control" required="required" disabled>
                                            <option value="">-- Pilih Kodepos --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_description">Deskripsi Proyek</label>
                                    <textarea name="project_description" id="project_description" class="form-control" placeholder="Contoh: Proyek prioritas tahun ini" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row row-pic">
                            <div class="col-12 col-sm-6">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="pic_leader_name">Nama PIC Leader</label>
                                        <input type="text" name="pic_leader_name" id="pic_leader_name" class="form-control" placeholder="Contoh: Dwi Setiawan" autocomplete="off" required="required" />
                                        <input type="hidden" name="pic_leader_id" id="pic_leader_id" />
                                        <div id="autocomplete-pic-leader">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="pic_leader_handphone">Nomor Telepon PIC Leader</label>
                                        <input type="text" name="pic_leader_handphone" id="pic_leader_handphone" class="form-control" placeholder="Contoh: 089818181818" autocomplete="off" required="required" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row-pic row-pic-member">
                            <input type="hidden" name="count-pic" id="count-pic" value="0" />
                        </div>
                        <div class="col-12">
                            <label class="add-pic">+ Tambahkan PIC Member</label>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
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
</body>

</html>