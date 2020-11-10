<style>
    .scroll {
        width: 100%;
        overflow: scroll;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Simpanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                        <li class="breadcrumb-item active">Simpanan</li>
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
                <?php echo $this->session->flashdata('pesan'); ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Simpanan Anggota</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <a class="btn btn-success btn-sm" href="<?php echo base_url() ?>index.php/simpanan/tambah_data" role="button">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data
                        </a>
                        <a class="btn btn-info btn-sm" href="<?php echo base_url(); ?>index.php/simpanan" role="button" name="refresh" id="refresh"><i class="fa fa-retweet" aria-hidden="true"></i> Refresh</a><br><br>
                        <div class="scroll">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Nomor</th>
                                        <th rowspan="2">No.Identitas</th>
                                        <th rowspan="2">Nama Anggota</th>
                                        <th rowspan="2">Jenis Kelamin</th>
                                        <?php
                                        if ($header_jenis->num_rows() > 0) {
                                            foreach ($header_jenis->result_array() as $db) {
                                        ?>
                                                <th colspan="3"><?php echo $db['jenis_simpanan']; ?></th>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <?php
                                        if ($header_jenis->num_rows() > 0) {
                                            foreach ($header_jenis->result_array() as $db) {
                                        ?>
                                                <th>Debet</th>
                                                <th>Kredit</th>
                                                <th class="saldo">Saldo</th>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($data->num_rows() > 0) {
                                        $no = 1 + $hal;
                                        foreach ($data->result_array() as $db) {
                                            if ($db['jk'] == 'L') {
                                                $sex = 'Laki-laki';
                                            } else {
                                                $sex = 'Perempuan';
                                            }

                                            $saldo = $db['jumlah_simpanan'] - $db['jumlah_pengambilan']
                                    ?>
                                            <tr>
                                                <td align="center"><?php echo $db['noanggota']; ?></td>
                                                <td align="center"><?php echo $db['noidentitas']; ?></td>
                                                <td><?php echo $db['namaanggota']; ?></td>
                                                <td align="center"><?php echo $db['jk']; ?></td>
                                                <?php
                                                if ($header_jenis->num_rows() > 0) {
                                                    foreach ($header_jenis->result_array() as $datas) {
                                                        $id = $db['noanggota'];
                                                        $jn = $datas['id_jenis'];
                                                        $simpanan = $this->app_model->Jumlah_Simpanan_Jenis($id, $jn);
                                                        $pengambilan = $this->app_model->Jumlah_Pengambilan_Jenis($id, $jn);
                                                        $saldoPerJenis = $simpanan - $pengambilan;
                                                ?>
                                                        <td align="right"><?php echo number_format($pengambilan); ?></td>
                                                        <td align="right"><?php echo number_format($simpanan); ?></td>
                                                        <td class="saldo" align="right"><?php echo number_format($saldoPerJenis); ?></td>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tr>
                                        <?php
                                            $no++;
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="5" align="center">Tidak Ada Data</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
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
                <?php echo form_open_multipart('rekening/proses_tambah_data'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label><strong>Rekening Induk</strong></label>
                        <select class="form-control" name="induk" id="induk">
                            <?php
                            foreach ($list->result() as $t) {
                            ?>
                                <option value="<?php echo $t->no_rek; ?>"><?php echo $t->nama_rek; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><strong>No. Rekening</strong></label>
                        <input type="text" name="no_rek" id="no_rek" class="form-control" placeholder="Masukkan Nomor Rekening">
                    </div>
                    <div class="form-group">
                        <label><strong>Nama Rekening</strong></label>
                        <input type="text" name="nama_rek" id="nama_rek" class="form-control" placeholder="Masukkan Nama Rekening">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Tambah Data -->

<!-- Start of Modal Edit Data -->
<?php $no = 0; ?>
<?php foreach ($data->result_array() as $db) : ?>
    <div class="modal fade" id="editmodal<?php echo $db['id_rekening']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php echo form_open_multipart('rekening/proses_edit_data'); ?>
                <input type="hidden" name="id_rekening" value="<?php echo $db['id_rekening']; ?>"></input>
                <div class="modal-body">
                    <div class="form-group">
                        <label><strong>Rekening Induk</strong></label>
                        <select class="form-control" name="induk" id="induk">
                            <?php
                            foreach ($list->result() as $t) {
                            ?>
                                <option value="<?php echo $t->no_rek; ?>"><?php echo $t->nama_rek; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><strong>No. Rekening</strong></label>
                        <input type="text" name="no_rek" id="no_rek" value="<?php echo $db['no_rek']; ?>" class="form-control" placeholder="Masukkan Nomor Rekening">
                    </div>
                    <div class="form-group">
                        <label><strong>Nama Rekening</strong></label>
                        <input type="text" name="nama_rek" id="nama_rek" value="<?php echo $db['nama_rek']; ?>" class="form-control" placeholder="Masukkan Nama Rekening">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- End of Modal Edit Data -->