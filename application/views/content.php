<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Home</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="alert alert-info" role="alert">
                Hai, Selamat datang <b><?php echo $this->session->userdata('namalengkap'); ?></b> di Manajeman <b><?php echo $nama_program; ?></b>
                <hr>
            </div><br>
        </div>
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <br>
                            <h5>
                                <strong>Rekening / COA</strong>
                            </h5>
                            <br>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tv"></i>
                        </div>
                        <a href="<?php echo base_url(); ?>index.php/rekening" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <br>
                            <h5>
                                <strong>Saldo Awal</strong>
                            </h5>
                            <br>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <a href="<?php echo base_url(); ?>index.php/saldo_awal" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <br>
                            <h5>
                                <strong>Jurnal Umum</strong>
                            </h5>
                            <br>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <a href="<?php echo base_url(); ?>index.php/jurnal_umum" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <br>
                            <h5>
                                <strong>Jurnal Penyesuaian</strong>
                            </h5>
                            <br>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bookmark"></i>
                        </div>
                        <a href="<?php echo base_url(); ?>index.php/jurnal_penyesuaian" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <br>
                            <h5>
                                <strong>Buku Besar</strong>
                            </h5>
                            <br>
                        </div>
                        <div class="icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <a href="<?php echo base_url(); ?>index.php/buku_besar" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <hr>
            <strong>Catatan :</strong>
            <ol>
                <li>Kasus yang ditangani pada akuntansi standard ini adalah Perusahaan Jasa</li>
                <li>Pastikan jurnal Anda diisi dengan benar</li>
                <li>Kalo ada perubahan No.Rek (COA) pada Prive Pemilik Modal. Ubah/edit pada kode program lap_neraca/view_data</li>
            </ol>
        </div>
    </section>
</div><br><br>