<script type="text/javascript">
    $(document).ready(function() {
        $(':input:not([type="submit"])').each(function() {
            $(this).focus(function() {
                $(this).addClass('hilite');
            }).blur(function() {
                $(this).removeClass('hilite');
            });
        });
    });
    /*
    function editData(id){
    	var periode = $("#periode").val();
    	var string 	= "id="+id+"&periode="+periode;

    	$.ajax({
    			type	: 'POST',
    			url		: "<?php echo site_url(); ?>/saldo_awal/edit",
    			data	: string,
    			cache	: true,
    			dataType : "json",
    			success	: function(data){			
    				$("#periode").focus();
    				
    				$("#no_rek").val(id);
    				$("#periode").val(periode);
    				$("#nama_rek").val(data.nama_rek);
    			}
    	});
    	return false();
    }
    */
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Buku Besar</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Menu</a></li>
                        <li class="breadcrumb-item active">Buku Besar</li>
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Buku Besar</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <form class="form-inline" name="form" method="post" action="<?php echo base_url(); ?>index.php/buku_besar">
                                <div class="form-group mx-sm-12 mb-2 btn-sm">
                                    <label><strong>No. Rek : </strong></label> &nbsp;&nbsp;
                                    <select class="form-control" name="no_rek" id="no_rek">
                                        <?php
                                        if (empty($no_rek)) {
                                        ?>
                                            <option value="">-PILIH-</option>
                                            <?php
                                        }
                                        foreach ($list_rek->result_array() as $t) {
                                            if ($no_rek == $t['no_rek']) {
                                            ?>
                                                <option value="<?php echo $t['no_rek']; ?>" selected="selected"><?php echo $t['no_rek']; ?> | <?php echo $t['nama_rek']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $t['no_rek']; ?>"><?php echo $t['no_rek']; ?> | <?php echo $t['nama_rek']; ?></option>
                                        <?php }
                                        } ?>
                                    </select>&nbsp;&nbsp;
                                </div>
                                <button type="submit" name="cari" id="cari" class="btn btn-primary mb-2"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                            </form>
                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No Jurnal</th>
                                    <th>Tanggal</th>
                                    <th>No Bukti</th>
                                    <th>Keterangan</th>
                                    <th>No Rek</th>
                                    <th>Nama Rek</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //if($data->num_rows()>0){
                                $periode = date('Y') - 1;
                                $saldo = 0;
                                $dr_sa = $this->app_model->dr_sa($no_rek, $periode);
                                $kr_sa = $this->app_model->kr_sa($no_rek, $periode);
                                $saldo = $saldo + $dr_sa - $kr_sa;
                                ?>
                                <tr>
                                    <td colspan="6" align="center"><b>Saldo Awal Tahun <?php echo $periode; ?></b></td>
                                    <td align="right" width="100"><?php echo number_format($dr_sa); ?></td>
                                    <td align="right" width="100"><?php echo number_format($kr_sa); ?></td>
                                    <td align="right" width="100"><?php echo number_format($saldo); ?></td>
                                </tr>
                                <?php
                                $jml_dr = 0;
                                $jml_kr = 0;
                                $no = 1 + $hal;
                                foreach ($data->result_array() as $db) {
                                    $tgl = $this->app_model->tgl_indo($db['tgl_jurnal']);
                                    $nama_rek = $this->app_model->CariNamaRek($db['no_rek']);
                                    $saldo = $saldo + $db['debet'] - $db['kredit'];
                                ?>
                                    <tr>
                                        <td align="center" width="100"><?php echo $db['no_jurnal']; ?></td>
                                        <td align="center" width="100"><?php echo $tgl; ?></td>
                                        <td align="center" width="80"><?php echo $db['no_bukti']; ?></td>
                                        <td><?php echo $db['ket']; ?></td>
                                        <td align="center" width="80"><?php echo $db['no_rek']; ?></td>
                                        <td width="150"><?php echo $nama_rek; ?></td>
                                        <td align="right" width="80"><?php echo number_format($db['debet']); ?></td>
                                        <td align="right" width="80"><?php echo number_format($db['kredit']); ?></td>
                                        <td align="right" width="80"><?php echo number_format($saldo); ?></td>
                                    </tr>
                                <?php
                                    $jml_dr = $jml_dr + $db['debet'];
                                    $jml_kr = $jml_kr + $db['kredit'];
                                    $no++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No Jurnal</th>
                                    <th>Tanggal</th>
                                    <th>No Bukti</th>
                                    <th>Keterangan</th>
                                    <th>No Rek</th>
                                    <th>Nama Rek</th>
                                    <th>Debet</th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div><br><br>

<!-- Start Modal Tambah Data -->
<div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" name="tambah" id="tambah">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="form">
                <form name="my-form" id="my-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label><strong>User Id</strong></label>
                            <input type="text" name="user_id" id="user_id" class="form-control" placeholder="Masukkan User Id">
                        </div>
                        <div class="form-group">
                            <label><strong>Password</strong></label>
                            <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Masukkan Password">
                        </div>
                        <div class="form-group">
                            <label><strong>Nama Lengkap</strong></label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label><strong>Level</strong></label>
                            <select class="form-control" name="level" id="level">
                                <option value="">-Pilih</option>
                                <option value="super admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="simpan" id="simpan" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Tambah Data -->