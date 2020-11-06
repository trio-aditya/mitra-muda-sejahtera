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
            <div class="col-12">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="content-wrapper">
                        <!-- solid sales graph -->
                        <div class="card bg-gradient-info">
                            <div class="card-header border-0">
                                <h3 class="card-title">
                                    <i class="fas fa-th mr-1"></i>
                                    Sales Graph
                                </h3>
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
                                <div class="card-tools">
                                    <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer bg-transparent">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60" data-fgColor="#39CCCC">

                                        <div class="text-white">Mail-Orders</div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-4 text-center">
                                        <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgColor="#39CCCC">

                                        <div class="text-white">Online</div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-4 text-center">
                                        <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC">

                                        <div class="text-white">In-Store</div>
                                    </div>
                                    <!-- ./col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div><br><br>

<script type="text/javascript">
    $(function() {
        var chart;
        $(document).ready(function() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container',
                    type: 'line',
                    spacingTop: 0,
                    spacingBottom: 0
                },
                title: {
                    text: '<?php echo $judul; ?> Tahun <?php echo $tahun; ?>',
                    style: {
                        color: '#154C67',
                        fontSize: '14px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                },
                subtitle: {
                    text: '<?php echo $instansi; ?>'
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    labels: {
                        align: 'center',
                        style: {
                            fontSize: '8px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: 'Total Jurnal',
                        style: {
                            color: '#154C67',
                            fontSize: '12px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    },
                    lineColor: '#999',
                    lineWidth: 1,
                    tickColor: '#666',
                    tickWidth: 1,
                    tickLength: 3,
                    gridLineColor: '#ddd',
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' +
                            this.x + ': ' + this.y;
                    }
                    /*
				headerFormat: '<b>{series.name}</b><br />',
                pointFormat: 'x = {point.x}, y = {point.y}'
				*/
                },
                legend: {
                    enabled: true,
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom',
                    borderWidth: 0
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: true
                    }
                },
                series: [{
                    name: 'Debet',
                    data: [<?php echo $tampil_data_debet; ?>],
                    color: '#AA4643'
                }, {
                    name: 'Kredit',
                    data: [<?php echo $tampil_data_kredit; ?>],
                    color: '#4572A7'
                }]
            });
        });

    });
</script>