<?php
$tahun = date('Y');

for ($a = 1; $a <= 12; $a++) {
    $total = $this->app_model->GrafikDebet($a, $tahun);
    $data_debet[$a] = $total;
}
for ($a = 1; $a <= 12; $a++) {
    $total = $this->app_model->GrafikKredit($a, $tahun);
    $data_kredit[$a] = $total;
}


$tampil_data_debet = '';
$tampil_data_kredit = '';

for ($i = 1; $i <= 12; $i++) {

    $tampil_data_debet .= $data_debet[$i];
    if ($i < 12) $tampil_data_debet .= ',';
}

for ($i = 1; $i <= 12; $i++) {

    $tampil_data_kredit .= $data_kredit[$i];
    if ($i < 12) $tampil_data_kredit .= ',';
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Grafik Jurnal</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Grafik</a></li>
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
            <div class="row">
                
            </div>
            <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div><br><br>

<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>

