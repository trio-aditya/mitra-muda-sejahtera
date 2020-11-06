<script type="text/javascript">
	$(document).ready(function() {
		$(':input:not([type="submit"])').each(function() {
			$(this).focus(function() {
				$(this).addClass('hilite');
			}).blur(function() {
				$(this).removeClass('hilite');
			});
		});

		$("#tgl").datepicker({
			dateFormat: "dd-mm-yy"
		});

		$("#no_bukti").keyup(function(e) {
			var isi = $(e.target).val();
			$(e.target).val(isi.toUpperCase());
			CariAnggota(isi);
		});

		$(".angka").keypress(function(data) {
			if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
				return false;
			}
		});

		$("#view").show();
		$("#form").hide();

		$("#tambah").click(function() {
			$("#view").hide();
			$("#form").show();
			buat_nojurnal();
			kosong();
			$("#no_bukti").focus();
			tampil_data();
			//$("#tampil_data").html('hai...');
		});

		function kosong() {
			$(".kosong").val('');
			$(".angka").val('');
			$("#no_bukti").val('');
			$("#ket").val('');
		}

		function buat_nojurnal() {
			$.ajax({
				type: 'POST',
				url: "<?php echo site_url(); ?>/ref_json/CariNoAJP",
				//data	: string,
				cache: false,
				dataType: "json",
				success: function(data) {
					$("#no_jurnal").val(data.nojurnal);
					$("#tgl").val(data.tgl);
				}
			});

		}

		$("#no_rek").keyup(function() {
			CariNoRek();
		});

		$("#no_rek").change(function() {
			CariNoRek();
		});

		function CariNoRek() {
			var no_rek = $("#no_rek").val();
			var string = "no_rek=" + no_rek;
			$.ajax({
				type: 'POST',
				url: "<?php echo site_url(); ?>/ref_json/CariNamaRek",
				data: string,
				cache: false,
				dataType: "json",
				success: function(data) {
					$("#nama_rek").val(data.nama_rek);
				}
			});
		}
		$("#simpan").click(function() {
			var no_jurnal = $("#no_jurnal").val();
			var tgl = $("#tgl").val();
			var no_rek = $("#no_rek").val();
			var debet = $("#dr").val();
			var kredit = $("#kr").val();

			var string = "no_jurnal=" + no_jurnal + "&tgl=" + tgl + "&no_rek=" + no_rek + "&debet=" + debet + "&kredit=" + kredit;

			if (no_rek.length == 0) {
				$.messager.show({
					title: 'Info',
					msg: 'Maaf, No Rek Tidak Boleh Kosong',
					timeout: 2000,
					showType: 'slide'
				});

				$("#no_rek").focus();
				return false();
			}
			if (nama_rek.length == 0) {
				//alert("Maaf, Nama Rekening tidak boleh kosong");
				$.messager.show({
					title: 'Info',
					msg: 'Maaf, Nama Rek Tidak Boleh Kosong',
					timeout: 2000,
					showType: 'slide'
				});

				$("#no_rek").focus();
				return false();
			}
			if (debet.length == 0) {
				$.messager.show({
					title: 'Info',
					msg: 'Maaf, Debet Tidak Boleh Kosong',
					timeout: 2000,
					showType: 'slide'
				});
				$("#dr").focus();
				return false();
			}
			if (kredit.length == 0) {
				$.messager.show({
					title: 'Info',
					msg: 'Maaf, Kredit Tidak Boleh Kosong',
					timeout: 2000,
					showType: 'slide'
				});
				$("#kr").focus();
				return false();
			}
			$.ajax({
				type: 'POST',
				url: "<?php echo site_url(); ?>/jurnal_penyesuaian/simpan",
				data: string,
				cache: false,
				success: function(data) {
					$.messager.show({
						title: 'Info',
						msg: data,
						timeout: 2000,
						showType: 'slide'
					});
					tampil_data();
				}
			});

		});

		function tampil_data() {
			var no_jurnal = $("#no_jurnal").val();
			var string = "no_jurnal=" + no_jurnal;

			$.ajax({
				type: 'POST',
				url: "<?php echo site_url(); ?>/jurnal_penyesuaian/DetailJurnalUmum",
				data: string,
				cache: false,
				success: function(data) {
					$("#tampil_data").html(data);
				}
			});
		}

		$("#tambah_data").click(function() {
			$(".kosong").val('');
			$(".angka").val('');
			$("#no_jurnal").focus();
			//buat_nojurnal();
		});

		$("#kembali").click(function() {
			window.location.assign('<?php echo base_url(); ?>index.php/jurnal_penyesuaian');
		});
	});

	function editData(id) {
		var string = "id=" + id;
		//alert(id);

		$.ajax({
			type: 'POST',
			url: "<?php echo site_url(); ?>/jurnal_penyesuaian/edit",
			data: string,
			cache: true,
			dataType: "json",
			success: function(data) {

				$("#no_bukti").val(data.no_bukti);
				$("#no_jurnal").val(data.no_jurnal);
				$("#ket").val(data.ket);
				$("#tgl").val(data.tgl);
				//$("#no_rek").focus();

				$("#view").hide();
				$("#form").show();
				tampil_data();
			}
		});

		function tampil_data() {
			var no_jurnal = $("#no_jurnal").val();
			var string = "no_jurnal=" + no_jurnal;

			$.ajax({
				type: 'POST',
				url: "<?php echo site_url(); ?>/jurnal_penyesuaian/DetailJurnalUmum",
				data: string,
				cache: false,
				success: function(data) {
					$("#tampil_data").html(data);
				}
			});
		}

	}
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Jurnal Penyesuaian</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Menu</a></li>
						<li class="breadcrumb-item active">Jurnal Penyesuaian</li>
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
						<h3 class="card-title">Daftar Jurnal Penyesuaian</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<button type="button" name="tambah" id="tambah" class="btn btn-success btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data</button>
						<a class="btn btn-info btn-sm" href="<?php echo base_url(); ?>index.php/jurnal_penyesuaian" role="button" name="refresh" id="refresh"><i class="fa fa-retweet" aria-hidden="true"></i> Refresh</a><br><br>
						<form class="form-inline" name="form" method="post" action="<?php echo base_url(); ?>index.php/jurnal_penyesuaian">
							<div class="form-group mx-sm-3 mb-2">
								<label>Cari No.Jurnal/No.Rek :</label>&nbsp;
								<input type="text" name="txt_cari" id="txt_cari" class="form-control">
							</div>
							<button type="submit" name="cari" id="cari" class="btn btn-info mb-2"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
						</form>
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>No Jurnal</th>
									<th>Tanggal</th>
									<th>No Rek</th>
									<th>Nama Rek</th>
									<th>Debet</th>
									<th>Kredit</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($data->num_rows() > 0) {
									$jml_dr = 0;
									$jml_kr = 0;
									$no = 1 + $hal;
									foreach ($data->result_array() as $db) {
										$tgl = $this->app_model->tgl_indo($db['tgl_jurnal']);
										$nama_rek = $this->app_model->CariNamaRek($db['no_rek']);
								?>
										<tr>
											<td align="center" width="20"><?php echo $no; ?></td>
											<td align="center" width="100"><?php echo $db['no_jurnal']; ?></td>
											<td align="center" width="100"><?php echo $tgl; ?></td>
											<td align="center" width="80"><?php echo $db['no_rek']; ?></td>
											<td><?php echo $nama_rek; ?></td>
											<td align="right" width="100"><?php echo number_format($db['debet']); ?></td>
											<td align="right" width="100"><?php echo number_format($db['kredit']); ?></td>
											<td align="center" width="80">
												<a class="btn btn-primary btn-sm" href="#" role="button">
													<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
														<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
													</svg>
												</a>
											</td>
										</tr>
									<?php
										$jml_dr = $jml_dr + $db['debet'];
										$jml_kr = $jml_kr + $db['kredit'];
										$no++;
									}
								} else {
									$jml_dr = 0;
									$jml_kr = 0;
									?>
									<tr>
										<td colspan="9" align="center">Tidak Ada Data</td>
									</tr>
								<?php
								}
								?>
								<tr>
									<td align="right" colspan="5"><b>Jumlah</b></td>
									<td align="right"><b><?php echo number_format($jml_dr); ?></b></td>
									<td align="right"><b><?php echo number_format($jml_kr); ?></b></td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
		</div>
	</section>
</div><br><br>