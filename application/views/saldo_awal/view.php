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
					<h1 class="m-0 text-dark">Saldo Awal</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Menu</a></li>
						<li class="breadcrumb-item active">Saldo Awal</li>
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
						<h3 class="card-title">Daftar Saldo Awal</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="form-group">
							<form class="form-inline">
								<div class="form-group mx-sm-12 mb-2 btn-sm">
									<label><strong>Periode : </strong></label> &nbsp;&nbsp;
									<select class="form-control" name="periode" id="periode">
										<?php
										if (empty($periode)) {
										?>
											<option value="">-PILIH-</option>
											<?php
										}
										$year_awal = date('Y') - 1;
										$year_akhir = date('Y');
										for ($i = $year_awal; $i <= $year_akhir; $i++) {
											if ($periode == $i) {
											?>
												<option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
											<?php } else { ?>
												<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php }
										} ?>
									</select>&nbsp;&nbsp;
								</div>
								<button type="submit" name="cari" id="cari" class="btn btn-primary mb-2"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>&nbsp;&nbsp;&nbsp;&nbsp;
								<button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#tambahdata">
									<i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data
								</button>
							</form>
						</div>
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>No Rekening</th>
									<th>Nama Rekening</th>
									<th>Debet</th>
									<th>Kredit</th>
									<th width="80">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($data->num_rows() > 0) {
									$t_dr = 0;
									$t_kr = 0;
									$no = 1;
									foreach ($data->result_array() as $db) {
								?>
										<tr>
											<td align="center" width="20"><?php echo $no; ?></td>
											<td align="center" width="150"><?php echo $db['no_rek']; ?>
												<input type="hidden" name="no_rek<?php echo $no; ?>" id="no_rek<?php echo $no; ?>" value="<?php echo $db['no_rek']; ?>" />
											</td>
											<td><?php echo $db['nama_rek']; ?></td>
											<td align="right" width="100">
												<?php echo number_format($db['debet']); ?>
											</td>
											<td align="right" width="100">
												<?php echo number_format($db['kredit']); ?>
											</td>
											<td align="center" width="80">
												<a href="<?php echo base_url(); ?>index.php/saldo_awal/edit/<?php echo $db['periode']; ?>/<?php echo $db['no_rek']; ?>">
													<img src="<?php echo base_url(); ?>asset/images/ed.png" title='Edit'>
												</a>
												<a href="<?php echo base_url(); ?>index.php/saldo_awal/hapus/<?php echo $db['periode']; ?>/<?php echo $db['no_rek']; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
													<img src="<?php echo base_url(); ?>asset/images/del.png" title='Hapus'>
												</a>
											</td>
										</tr>
									<?php
										$t_dr = $t_dr + $db['debet'];
										$t_kr = $t_kr + $db['kredit'];
										$no++;
									}
								} else {
									$t_dr = 0;
									$t_kr = 0;
									?>
									<tr>
										<td colspan="5" align="center">Tidak Ada Data</td>
									</tr>
								<?php
								}
								?>
								<tr>
									<td colspan="3" align="right">Total</td>
									<td align="right"><?php echo number_format($t_dr); ?></td>
									<td align="right"><?php echo number_format($t_kr); ?></td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th>No</th>
									<th>No Rekening</th>
									<th>Nama Rekening</th>
									<th>Debet</th>
									<th>Kredit</th>
									<th width="80">Aksi</th>
								</tr>
							</tfoot>
						</table>
						<input type="hidden" id="jml_data" value="<?php echo $no; ?>" />
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