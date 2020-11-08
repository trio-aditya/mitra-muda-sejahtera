<?php
$level = $this->session->userdata('level');
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?php echo base_url(); ?>asset/images/logo_koperasi_85.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">KOPERASI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <?php
            $id = $this->session->userdata('user_id');
            $foto = $this->app_model->getFoto($id);
            if (empty($foto)) {
            ?>
                <div class="image">
                    <img src="<?php echo base_url(); ?>asset/foto_profil/ayah_profile.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <!-- <img style="float:left;padding:2px;" src="<?php echo base_url(); ?>asset/foto_profil/ayah_profile.jpg" width="50" height="50" align="middle" /> -->
            <?php } else { ?>
                <!-- <img style="float:left;padding:2px;" src="<?php echo base_url(); ?>asset/foto_profil/<?php echo $foto; ?>" width="50" height="50" align="middle" /> -->
                <div class="image">
                    <img src="<?php echo base_url(); ?>asset/foto_profil/<?php echo $foto; ?>" class="img-circle elevation-2" alt="User Image">
                </div>
            <?php } ?>
            <div class="info">
                <a href="#" class="d-block"><?php echo $this->session->userdata('namalengkap'); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <?php if ($this->uri->segment(1) == "home") { ?>
                    <li class="nav-item has-treeview menu-open">
                        <a href="<?php echo site_url(); ?>/home" class="nav-link active">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Home
                            </p>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($this->uri->segment(1) != "home") { ?>
                    <li class="nav-item has-treeview">
                        <a href="<?php echo site_url(); ?>/home" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Home
                            </p>
                        </a>
                    </li>
                <?php } ?>

                <!--Start Data Master-->
                <?php if (
                    $this->uri->segment(1) == "profil" || $this->uri->segment(1) == "jenis" ||
                    $this->uri->segment(1) == "anggota"
                ) {
                    echo
                        '<li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>
                                Data Master
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>';
                } else {
                    echo
                        ' <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>
                                Data Master
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>';
                } ?>

                <ul class="nav nav-treeview">
                    <!-- Start Submenu Profil -->
                    <?php if ($this->uri->segment(1) == "profil") { ?>
                        <li class="nav-item has-treeview menu-open">
                            <a href="<?php echo site_url(); ?>/profil" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Profil
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->uri->segment(1) != "profil") { ?>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo site_url(); ?>/profil" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Profil
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- End Profil -->

                    <!-- Start Submenu Jenis Simpanan -->
                    <?php if ($this->uri->segment(1) == "jenis") { ?>
                        <li class="nav-item has-treeview menu-open">
                            <a href="<?php echo site_url(); ?>/jenis" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Jenis Simpanan
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->uri->segment(1) != "jenis") { ?>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo site_url(); ?>/jenis" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Jenis Simpanan
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- End Data Jenis Simpanan -->

                    <!-- Start Submenu Anggota -->
                    <?php if ($this->uri->segment(1) == "anggota") { ?>
                        <li class="nav-item has-treeview menu-open">
                            <a href="<?php echo site_url(); ?>/anggota" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Anggota
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->uri->segment(1) != "anggota") { ?>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo site_url(); ?>/anggota" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Anggota
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- End Submenu Anggota -->
                </ul>

                <?php
                if ($level == 'super admin' or $level == 'admin') {
                ?>
                    <?php if (
                        $this->uri->segment(1) == "users" || $this->uri->segment(1) == "rekening" || $this->uri->segment(1) == "saldo_awal"
                        || $this->uri->segment(1) == "jurnal_umum" || $this->uri->segment(1) == "buku_besar" || $this->uri->segment(1) == "jurnal_penyesuaian"
                    ) {
                        echo
                            '<li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Akuntansi
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>';
                    } else {
                        echo
                            ' <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Akuntansi
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>';
                    } ?>

                    <ul class="nav nav-treeview">
                        <?php
                        if ($level == 'super admin') {
                        ?>
                            <?php if ($this->uri->segment(1) == "users") { ?>
                                <li class="nav-item has-treeview menu-open">
                                    <a href="<?php echo site_url(); ?>/users" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Users
                                        </p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($this->uri->segment(1) != "users") { ?>
                                <li class="nav-item has-treeview">
                                    <a href="<?php echo site_url(); ?>/users" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Users
                                        </p>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>

                        <!-- Rekening -->
                        <?php if ($this->uri->segment(1) == "rekening") { ?>
                            <li class="nav-item has-treeview menu-open">
                                <a href="<?php echo site_url(); ?>/rekening" class="nav-link active">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Rekening
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($this->uri->segment(1) != "rekening") { ?>
                            <li class="nav-item has-treeview">
                                <a href="<?php echo site_url(); ?>/rekening" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Rekening
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <!--End Rekening-->

                        <!-- Start Saldo Awal -->
                        <?php if ($this->uri->segment(1) == "saldo_awal") { ?>
                            <li class="nav-item has-treeview menu-open">
                                <a href="<?php echo site_url(); ?>/saldo_awal" class="nav-link active">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Saldo Awal
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($this->uri->segment(1) != "saldo_awal") { ?>
                            <li class="nav-item has-treeview">
                                <a href="<?php echo site_url(); ?>/saldo_awal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Saldo Awal
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <!--End Saldo Awal -->

                        <!-- Start Jurnal Umum -->
                        <?php if ($this->uri->segment(1) == "jurnal_umum") { ?>
                            <li class="nav-item has-treeview menu-open">
                                <a href="<?php echo site_url(); ?>/jurnal_umum" class="nav-link active">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Jurnal Umum
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($this->uri->segment(1) != "jurnal_umum") { ?>
                            <li class="nav-item has-treeview">
                                <a href="<?php echo site_url(); ?>/jurnal_umum" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Jurnal Umum
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <!--End Jurnal Umum -->

                        <!-- Start Buku Besar -->
                        <?php if ($this->uri->segment(1) == "buku_besar") { ?>
                            <li class="nav-item has-treeview menu-open">
                                <a href="<?php echo site_url(); ?>/buku_besar" class="nav-link active">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Buku Besar
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($this->uri->segment(1) != "buku_besar") { ?>
                            <li class="nav-item has-treeview">
                                <a href="<?php echo site_url(); ?>/buku_besar" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Buku Besar
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <!--End Buku Besar -->

                        <!-- Start Jurnal Penyesuaian -->
                        <?php if ($this->uri->segment(1) == "jurnal_penyesuaian") { ?>
                            <li class="nav-item has-treeview menu-open">
                                <a href="<?php echo site_url(); ?>/jurnal_penyesuaian" class="nav-link active">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Jurnal Penyesuaian
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($this->uri->segment(1) != "jurnal_penyesuaian") { ?>
                            <li class="nav-item has-treeview">
                                <a href="<?php echo site_url(); ?>/jurnal_penyesuaian" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Jurnal Penyesuaian
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <!--End Jurnal Penyesuaian -->
                    </ul>
                    </li>
                <?php } ?>

                <!--Start Laporan-->
                <?php if (
                    $this->uri->segment(1) == "lap_buku_besar" || $this->uri->segment(1) == "lap_neraca_saldo" || $this->uri->segment(1) == "lap_neraca_lajur"
                    || $this->uri->segment(1) == "lap_laba_rugi" || $this->uri->segment(1) == "lap_neraca"
                ) {
                    echo
                        '<li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Laporan
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>';
                } else {
                    echo
                        ' <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Laporan
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>';
                } ?>
                <ul class="nav nav-treeview">
                    <!-- Start Submenu Buku Besar -->
                    <?php if ($this->uri->segment(1) == "lap_buku_besar") { ?>
                        <li class="nav-item has-treeview menu-open">
                            <a href="<?php echo site_url(); ?>/lap_buku_besar" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Buku Besar
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->uri->segment(1) != "lap_buku_besar") { ?>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo site_url(); ?>/lap_buku_besar" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Buku Besar
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- End Submenu Buku Besar -->

                    <!-- Start Submenu Neraca Saldo -->
                    <?php if ($this->uri->segment(1) == "lap_neraca_saldo") { ?>
                        <li class="nav-item has-treeview menu-open">
                            <a href="<?php echo site_url(); ?>/lap_neraca_saldo" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Neraca Saldo
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->uri->segment(1) != "lap_neraca_saldo") { ?>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo site_url(); ?>/lap_neraca_saldo" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Neraca Saldo
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- End Submenu Neraca Saldo -->

                    <!-- Start Submenu Neraca Lajur -->
                    <?php if ($this->uri->segment(1) == "lap_neraca_lajur") { ?>
                        <li class="nav-item has-treeview menu-open">
                            <a href="<?php echo site_url(); ?>/lap_neraca_lajur" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Neraca Lajur
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->uri->segment(1) != "lap_neraca_lajur") { ?>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo site_url(); ?>/lap_neraca_lajur" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Neraca Lajur
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- End Submenu Neraca Lajur -->

                    <!-- Start Submenu Laba Rugi -->
                    <?php if ($this->uri->segment(1) == "lap_laba_rugi") { ?>
                        <li class="nav-item has-treeview menu-open">
                            <a href="<?php echo site_url(); ?>/lap_laba_rugi" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Laba Rugi
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->uri->segment(1) != "lap_laba_rugi") { ?>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo site_url(); ?>/lap_laba_rugi" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Laba Rugi
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- End Submenu Laba Rugi -->

                    <!-- Start Submenu Neraca -->
                    <?php if ($this->uri->segment(1) == "lap_neraca") { ?>
                        <li class="nav-item has-treeview menu-open">
                            <a href="<?php echo site_url(); ?>/lap_neraca" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Neraca
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->uri->segment(1) != "lap_neraca") { ?>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo site_url(); ?>/lap_neraca" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Neraca
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- End Submenu Neraca -->
                </ul>
                </li>

                <!--Start Grafik-->
                <?php if (
                    $this->uri->segment(1) == "grafik"
                ) {
                    echo
                        '<li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Grafik
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>';
                } else {
                    echo
                        ' <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Grafik
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>';
                } ?>

                <ul class="nav nav-treeview">
                    <!-- Start Submenu Jurnal -->
                    <?php if ($this->uri->segment(1) == "grafik") { ?>
                        <li class="nav-item has-treeview menu-open">
                            <a href="<?php echo site_url(); ?>/grafik" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Jurnal
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->uri->segment(1) != "grafik") { ?>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo site_url(); ?>/grafik" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Jurnal
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- End Submenu Jurnal -->
                </ul>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>index.php/login/logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>