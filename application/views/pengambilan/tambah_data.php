<style>
    .scroll {
        width: 100%;
        overflow: scroll;

    }
</style>
<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.min.js"></script>

<script type="text/javascript">
    function autofill() {
        var noanggota = $("#noanggota").val();
        $.ajax({
            url: "<?php echo site_url(); ?>/pengambilan/autofill",
            data: 'noanggota=' + noanggota,
        }).success(function(data) {
            var json = data,
                obj = JSON.parse(json);
            $("#noidentitas").val(obj.noidentitas);
            $("#namaanggota").val(obj.namaanggota);
            $("#jk").val(obj.jk);
            $("#hp").val(obj.hp);
        });
    }
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Penarikan Dana Anggota</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>index.php/pengambilan">Penarikan Dana</a></li>
                        <li class="breadcrumb-item active">Tambah Data</li>
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
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo base_url(); ?>index.php/pengambilan/proses_tambah_data" method="post">
                            <div class="form-group">
                                <label>Nomor Anggota</label>
                                <input type="text" class="form-control" id="noanggota" name="noanggota" value="" onchange="return autofill();" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="tgl" id="tgl" value="" placeholder="Masukkan Tanggal" required>
                            </div>
                            <div class="form-group">
                                <label>Jenis Simpanan</label>
                                <select class="form-control" name="id_jenis" id="id_jenis" value="">
                                    <?php
                                    foreach ($list_jenis->result() as $t) {
                                    ?>
                                        <option value="<?php echo $t->id_jenis; ?>"><?php echo $t->jenis_simpanan; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Penarikan</label>
                                <input type="text" class="form-control" name="jumlah" id="jumlah" value="3000">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" name="ket" id="ket" placeholder="Masukkan Keterangan">
                            </div>
                            <div class="form-group">
                                <button type="submit" id="simpan" class="btn btn-primary">Simpan</button>
                        </form>
                        <a class="btn btn-info" href="<?php echo base_url(); ?>index.php/pengambilan" role="button">Tutup</a><br><br>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label>No. Identitas</label>
                            <input type="text" class="form-control" id="noidentitas" disabled>
                        </div>
                        <div class="form-group">
                            <label>Nama Anggota</label>
                            <input type="text" class="form-control" id="namaanggota" disabled>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <input type="text" class="form-control" id="jk" disabled>
                        </div>
                        <div class="form-group">
                            <label>HP</label>
                            <input type="number" class="form-control" id="hp" disabled>
                        </div>
                        <div class="form-group">
                            <label></label><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Anggota</th>
                                <th>Tanggal</th>
                                <th>Jenis Simpanan</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($dt_view_pengambilan->num_rows() > 0) {
                                $no = 1 + $hal;
                                foreach ($dt_view_pengambilan->result_array() as $db) {
                                    $tgl = $this->app_model->tgl_str($db['tgl']);
                            ?>
                                    <tr>
                                        <td align="center"><?php echo $no; ?></td>
                                        <td align="center"><?php echo $db['noanggota']; ?></td>
                                        <td align="center"><?php echo $tgl; ?></td>
                                        <td><?php echo $db['jenis_simpanan']; ?></td>
                                        <td align="right"><?php echo number_format($db['jumlah']); ?></td>
                                        <td align="center">
                                            <a class="btn btn-info btn-sm" href="javascript:cetakData('<?php echo $db['id_ambil'] ?>')">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-printer" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 2H5a1 1 0 0 0-1 1v2H3V3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h-1V3a1 1 0 0 0-1-1zm3 4H2a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h1v1H2a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1z" />
                                                    <path fill-rule="evenodd" d="M11 9H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1zM5 8a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H5z" />
                                                    <path d="M3 7.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                                                </svg>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>index.php/pengambilan/hapus_data/<?php echo $db['id_ambil']; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6" align="center">Tidak Ada Data</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>No. Anggota</th>
                                <th>Tanggal</th>
                                <th>Jenis Simpanan</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
</div>
</section>
</div><br><br>

<script>
    function autofill() {
        var noanggota = document.getElementById('noanggota').value;
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/pengambilan/cari",
            data: '&noanggota=' + noanggota,
            success: function(data) {
                var hasil = JSON.parse(data);

                $.each(hasil, function(key, val) {

                    document.getElementById('noanggota').value = val.noanggota;
                    document.getElementById('noidentitas').value = val.noidentitas;
                    document.getElementById('namaanggota').value = val.namaanggota;
                    document.getElementById('jk').value = val.jk;
                    document.getElementById('hp').value = val.hp;
                    $("#tambah_data").html(data);
                    CariSaldoJenis();
                });
            }
        });

        $(document).ready(function() {
            $('#noanggota').keyup(function() {
                var noanggota = $('#noanggota').val();

                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/simpanan/tambah_data",
                    method: "POST",
                    data: {
                        noanggota: noanggota
                    },
                    success: function(data) {
                        $("#tambah_data").html(data);
                    }
                });
            });
        });
    }

    //Cetak Data
    function cetakData(ID) {
        var id = ID;
        window.open('<?php echo site_url(); ?>/pengambilan/cetak?id=' + id);
    }
    //Function Clear Form Inputan
    function eraseText() {
        document.getElementById("output").value = "";
        document.getElementById("noanggota").value = "";
        document.getElementById("tgl").value = "";
        document.getElementById("id_jenis").value = "";
        document.getElementById("jumlah").value = "";
    }
</script>