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
                            <h1 class="m-0">Data Rumah Sakit</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Master Data</li>
                            </ol>
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
                                    <table id="tableServiceLists" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="dt-head-center">No</th>
                                                <th class="dt-head-center">Nama Rumah Sakit</th>
                                                <th class="dt-head-center">Kamar</th>
                                                <th class="dt-head-center">Radiologi</th>
                                                <th class="dt-head-center">Medikal</th>
                                                <th class="dt-head-center">Laboratorium</th>
                                                <th class="dt-head-center">Dokter</th>
                                                <th class="dt-head-center">Rehabitasi</th>
                                                <th class="dt-head-center">Biaya</th>
                                                <th class="dt-head-center">Users</th>
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

    <?PHP include(APPPATH . "views/layout/html_footer_script.php"); ?>
    <script src="<?php echo base_url("assets/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>
    <script>
        $(document).ready(function(){
            $('#tableServiceLists').DataTable({
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
                    'url':'<?php echo base_url("master/service/data"); ?>',
                    'type': 'POST',
                    'data': {'action':'#tableServiceLists'}
                },
                'columns': [
                    { data: 'no', className: 'dt-body-center' },
                    { data: 'name' },
                    { data: 'room', className: 'dt-body-center' },
                    { data: 'radiology', className: 'dt-body-center' },
                    { data: 'medic', className: 'dt-body-center' },
                    { data: 'laboratory', className: 'dt-body-center' },
                    { data: 'doctor', className: 'dt-body-center' },
                    { data: 'rehabilitation', className: 'dt-body-center' },
                    { data: 'fee', className: 'dt-body-center' },
                    { data: 'users', className: 'dt-body-center' },
                ],
                "columnDefs":[
                    {
                        "targets":[0, 2, 3, 4, 5],
                        "orderable":false,
                    },
                ]
            });
        });
</script>
</body>

</html>