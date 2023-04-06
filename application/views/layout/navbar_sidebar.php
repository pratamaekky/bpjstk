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
                <?php if ($this->plkk_session->user_role == -1) { ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url("master/hospital"); ?>" class="nav-link <?php echo ($this->controller == "master" && $this->module == "hospital") ? "active" : ""; ?>">
                            <i class="fas fa-hospital nav-icon"></i>
                            <p>Data Rumah Sakit</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url("master/service"); ?>" class="nav-link <?php echo ($this->controller == "master" && $this->module == "service") ? "active" : ""; ?>">
                            <i class="fas fa-procedures nav-icon"></i>
                            <p>Data Pelayanan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url("bills/lists/"); ?>" class="nav-link <?php echo ($this->controller == "bills") ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>Tagihan</i></p>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($this->plkk_session->user_role == 1) { ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url("master/service/room/lists/" . $this->plkk_session->rs_id); ?>" class="nav-link <?php echo ($this->module == "service" && $this->command == "room") ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-bed"></i>
                            <p>Kamar</i></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url("master/service/radiology/lists/" . $this->plkk_session->rs_id); ?>" class="nav-link <?php echo ($this->module == "service" && $this->command == "radiology") ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-radiation-alt"></i>
                            <p>Radiologi</i></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url("master/service/medic/lists/" . $this->plkk_session->rs_id); ?>" class="nav-link <?php echo ($this->module == "service" && $this->command == "medic") ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-notes-medical"></i>
                            <p>Tindakan Medik</i></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url("master/service/laboratory/lists/" . $this->plkk_session->rs_id); ?>" class="nav-link <?php echo ($this->module == "service" && $this->command == "laboratory") ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-vials"></i>
                            <p>Laboratorium</i></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url("master/service/doctor/lists/" . $this->plkk_session->rs_id); ?>" class="nav-link <?php echo ($this->module == "service" && $this->command == "doctor") ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>Dokter</i></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url("master/service/surgery/lists/" . $this->plkk_session->rs_id); ?>" class="nav-link <?php echo ($this->module == "service" && $this->command == "surgery") ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-stethoscope"></i>
                            <p>Dokter Specialis</i></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url("master/service/rehabilitation/lists/" . $this->plkk_session->rs_id); ?>" class="nav-link <?php echo ($this->module == "service" && $this->command == "rehabilitation") ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-hand-holding-medical"></i>
                            <p>Rehab Medik / Fisioterapy</i></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url("master/service/fee/lists/" . $this->plkk_session->rs_id); ?>" class="nav-link <?php echo ($this->module == "service" && $this->command == "fee") ? "active" : ""; ?>">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Biaya Lainnya</i></p>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->plkk_session->user_role == -1 || $this->plkk_session->user_role == 0) { ?>
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
                                    <p>Dokter Umum/IGD</p>
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
                <?php } ?>
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
