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
                    <li class="nav-item <?php echo ($this->controller == "master" && ($this->module == "hospital" || $this->module == "service")) ? "menu-open": ""; ?>">
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
                                <a href="<?php echo base_url("master/service"); ?>" class="nav-link <?php echo ($this->module == "service") ? "active" : ""; ?>">
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
                <li class="nav-item <?php echo ($this->controller == "master" && $this->module != "hospital" && $this->module != "service") ? "menu-open": ""; ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url("master/generals/lists/hospital_type"); ?>" class="nav-link <?php echo ($this->module == "generals" && $this->last_segment == "hospital_type") ? "active" : ""; ?>">
                                <i class="fas fa-h-square nav-icon"></i>
                                <p>Tipe Rumah Sakit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("master/generals/lists/hospital_owner"); ?>" class="nav-link <?php echo ($this->module == "generals" && $this->last_segment == "hospital_owner") ? "active" : ""; ?>">
                                <i class="fas fa-users nav-icon nav-icon"></i>
                                <p>Pemilik RS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("master/generals/lists/ot_category"); ?>" class="nav-link <?php echo ($this->module == "generals" && $this->last_segment == "ot_category") ? "active" : ""; ?>">
                                <i class="fas fa-database nav-icon"></i>
                                <p>Kategori Operasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("master/generals/lists/ot_specialist"); ?>" class="nav-link <?php echo ($this->module == "generals" && $this->last_segment == "ot_specialist") ? "active" : ""; ?>">
                                <i class="fas fa-user-tag nav-icon"></i>
                                <p>Spesialis Operasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("master/generals/lists/doctor_specialist"); ?>" class="nav-link <?php echo ($this->module == "generals" && $this->last_segment == "doctor_specialist") ? "active" : ""; ?>">
                                <i class="fas fa-user-md nav-icon"></i>
                                <p>Dokter Spesialisasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("master/generals/lists/lab_category"); ?>" class="nav-link <?php echo ($this->module == "generals" && $this->last_segment == "lab_category") ? "active" : ""; ?>">
                                <i class="fas fa-vials nav-icon"></i>
                                <p>Kategori Lab</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("master/generals/lists/other_fee"); ?>" class="nav-link <?php echo ($this->module == "generals" && $this->last_segment == "other_fee") ? "active" : ""; ?>">
                                <i class="fas fa-money-check-alt nav-icon"></i>
                                <p>Biaya Lainnya</p>
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
