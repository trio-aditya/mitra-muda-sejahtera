<script type="text/javascript">
	$(document).ready(function() {
		$(':input:not([type="submit"])').each(function() {
			$(this).focus(function() {
				$(this).addClass('hilite');
			}).blur(function() {
				$(this).removeClass('hilite');
			});
		});


		$("#view").show();
		$("#form").hide();

		$("#tambah").click(function() {
			$("#view").hide();
			$("#form").show();
			$("#no_rek").focus();
			return false();
		});

		function kosong() {
			$("#rek_induk").val('');
			$("#no_rek").val('');
			$("#nama_rek").val('');
			return false();
		}
		$("#simpan").click(function() {
			var rek_induk = $("#rek_induk").val();
			var no_rek = $("#no_rek").val();
			var nama_rek = $("#nama_rek").val();

			var string = "rek_induk=" + rek_induk + "&no_rek=" + no_rek + "&nama_rek=" + nama_rek;

			if (no_rek.length == 0) {
				$.messager.show({
					title: 'Info',
					msg: 'Maaf, No Rek Tidak Boleh Kosong',
					timeout: 2000,
					showType: 'slide'
				});
				$("#no_rek").focus();
				return false;
			}
			if (nama_rek.length == 0) {
				//alert("Maaf, Nama Rekening tidak boleh kosong");
				$.messager.show({
					title: 'Info',
					msg: 'Maaf, Nama Rek Tidak Boleh Kosong',
					timeout: 2000,
					showType: 'slide'
				});
				$("#nama_rek").focus();
				return false;
			}

			$.ajax({
				type: 'POST',
				url: "<?php echo site_url(); ?>/rekening/simpan",
				data: string,
				cache: false,
				success: function(data) {
					$.messager.show({
						title: 'Info',
						msg: data,
						timeout: 2000,
						showType: 'slide'
					});
				},
				error: function(xhr, teksStatus, kesalahan) {
					$.messager.show({
						title: 'Info',
						msg: 'Server tidak merespon :' + kesalahan,
						timeout: 2000,
						showType: 'slide'
					});
					return false();
				}
			});
			return false();
		});

		$("#tambah_data").click(function() {
			$.ajax({
				type: 'POST',
				url: "<?php echo site_url(); ?>/rekening/tambah",
				cache: false,
				success: function(data) {
					kosong();
					$("#no_rek").focus();
				}
			});
			return false();
		});

		$("#kembali").click(function() {
			window.location.assign('<?php echo base_url(); ?>index.php/rekening');
			return false();
		});
	});

	function editData(id) {
		var string = "id=" + id;
		$.ajax({
			type: 'POST',
			url: "<?php echo site_url(); ?>/rekening/edit",
			data: string,
			cache: true,
			dataType: "json",
			success: function(data) {
				$("#view").hide();
				$("#form").show();

				$("#no_rek").focus();

				$("#no_rek").val(id);
				$("#rek_induk").val(data.level);
				$("#nama_rek").val(data.nama_rek);
				return false();
			}
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
					<h1 class="m-0 text-dark">Rekening</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Menu</a></li>
						<li class="breadcrumb-item active">Rekening</li>
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
						<h3 class="card-title">Daftar Rekening</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahdata">
							<i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data
						</button>
						<a class="btn btn-info btn-sm" href="<?php echo base_url(); ?>index.php/rekening" role="button" name="refresh" id="refresh"><i class="fa fa-retweet" aria-hidden="true"></i> Refresh</a><br><br>

						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>No Rekening</th>
									<th>Nama Rekening</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($data->num_rows() > 0) {
									$no = 1 + $hal;
									foreach ($data->result_array() as $db) {
								?>
										<tr>
											<td align="center" width="20"><?php echo $no; ?></td>
											<td width="150"><?php echo $db['no_rek']; ?></td>
											<td><?php echo $db['nama_rek']; ?></td>
											<td align="center" width="80">
												<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editmodal<?php echo $db['id_rekening']; ?>">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
														<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
													</svg>
												</button>
												<a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>index.php/rekening/hapus/<?php echo $db['no_rek']; ?>" role="button" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
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
									<th>No Rekening</th>
									<th>Nama Rekening</th>
									<th>Aksi</th>
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