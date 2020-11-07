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
				<?php echo $this->session->flashdata('pesan'); ?>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Daftar Saldo Awal</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="form-group">
							<form class="form-inline" name="form" method="post" action="<?php echo base_url(); ?>index.php/saldo_awal">
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
												<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editmodal<?php echo $db['id']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
														<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
													</svg>
												</button>
												<a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>index.php/saldo_awal/hapus/<?php echo $db['periode']; ?>/<?php echo $db['no_rek']; ?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
														<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
													</svg>
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
				<?php echo form_open_multipart('saldo_awal/proses_tambah_data'); ?>
				<div class="modal-body">
					<div class="form-group">
						<label><strong>Periode</strong></label>
						<select class="form-control" name="periode" id="periode">
							<?php
							if (empty($periode)) {
							?>
								<option value="">- Pilih Periode -</option>
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
						</select>
					</div>
					<div class="form-group">
						<label><strong>Rekening</strong></label>
						<select class="form-control" name="no_rek" id="no_rek">
							<?php
							$list_rek = $this->app_model->getListRek();
							foreach ($list_rek->result() as $row) {
							?>
								<option value="<?php echo $row->no_rek; ?>"><?php echo $row->no_rek; ?> - <?php echo $row->nama_rek; ?></option>
							<?php } ?>
						</select>
						</select>
					</div>
					<div class="form-group">
						<label><strong>Debet</strong></label>
						<input type="number" name="debet" id="debet" class="form-control" placeholder="Masukkan Debet">
					</div>
					<div class="form-group">
						<label><strong>Kredit</strong></label>
						<input type="number" name="kredit" id="kredit" class="form-control" placeholder="Masukkan Kredit">
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
	<div class="modal fade" id="editmodal<?php echo $db['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php echo form_open_multipart('saldo_awal/proses_edit_data'); ?>
				<input type="hidden" name="id" value="<?php echo $db['id']; ?>"></input>
				<div class="modal-body">
					<div class="form-group">
						<label><strong>Periode</strong></label>
						<select class="form-control" name="periode" id="periode">
							<?php
							if (empty($periode)) {
							?>
								<option value="">- Pilih Periode -</option>
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
						</select>
					</div>
					<div class="form-group">
						<label><strong>Rekening</strong></label>
						<select class="form-control" name="no_rek" id="no_rek">
							<?php
							$list_rek = $this->app_model->getListRek();
							foreach ($list_rek->result() as $row) {
							?>
								<option value="<?php echo $row->no_rek; ?>"><?php echo $row->no_rek; ?> - <?php echo $row->nama_rek; ?></option>
							<?php } ?>
						</select>
						</select>
					</div>
					<div class="form-group">
						<label><strong>Debet</strong></label>
						<input type="number" name="debet" id="debet" value="<?php echo $db['debet']; ?>" class="form-control" placeholder="Masukkan Debet">
					</div>
					<div class="form-group">
						<label><strong>Kredit</strong></label>
						<input type="number" name="kredit" id="kredit" value="<?php echo $db['kredit']; ?>" class="form-control" placeholder="Masukkan Kredit">
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