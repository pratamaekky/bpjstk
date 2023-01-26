<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-green-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>" class="brand-link" style="background-color: #fff;">
        <img src="<?php echo base_url("assets/images/bpjstk-logo.png"); ?>" alt="Integrated PLKK Rates" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Integrated PLKK Rates</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url("assets/dist/img/user2-160x160.jpg"); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $this->plkk_session->name; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php if ($this->plkk_session->user_role == -1 || $this->plkk_session->user_role == 0) { ?>
                    <li class="nav-item <?php echo ($this->controller == "master") ? "menu-open": ""; ?>">
                        <a href="javascript:void(0);" class="nav-link">
                            <i class="nav-icon fas fa-hospital-alt"></i>
                            <p>Rumah Sakit<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo base_url("master/hospital"); ?>" class="nav-link <?php echo ($this->module == "hospital") ? "active" : ""; ?>">
                                    <i class="fas fa-clinic-medical nav-icon"></i>
                                    <p>Data Rumah Sakit</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/charts/flot.html" class="nav-link">
                                    <i class="fas fa-hospital-user nav-icon"></i>
                                    <p>Data Dokter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages/charts/inline.html" class="nav-link">
                                    <i class="fas fa-procedures nav-icon"></i>
                                    <p>Data Pelayanan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-md"></i>
                        <p>Data Dokter</i></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-hospital-user"></i>
                        <p>Data Pasien</i></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-pills"></i>
                        <p>Data Obat-obatan</i></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/charts/chartjs.html" class="nav-link">
                                <i class="fas fa-hospital nav-icon"></i>
                                <p>Rumah Sakit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/charts/flot.html" class="nav-link">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav nav-pills nav-sidebar flex-column nav-bottom" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url("user/dologout"); ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Keluar</i></p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
