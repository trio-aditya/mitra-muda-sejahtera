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
                <li class="nav-item">
                    <a href="home" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                <?php
                if ($level == 'super admin' or $level == 'admin') {
                ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Menu
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php
                            if ($level == 'super admin') {
                            ?>
                                <li class="nav-item">
                                    <a href="<?php echo base_url(); ?>index.php/users" class=" nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>index.php/rekening" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Rekening</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>index.php/saldo_awal" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Saldo Awal</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>index.php/jurnal_umum" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Jurnal Umum</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>index.php/buku_besar" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Buku Besar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url(); ?>index.php/jurnal_penyesuaian" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Jurnal Penyesuaian</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                            Laporan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>index.php/lap_buku_besar" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Buku Besar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>index.php/lap_neraca_saldo" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Neraca Saldo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>index.php/lap_neraca_lajur" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Neraca Lajur</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>index.php/lap_laba_rugi" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laba Rugi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>index.php/lap_neraca" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Neraca</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Grafik
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>index.php/grafik" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jurnal</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <hr>
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