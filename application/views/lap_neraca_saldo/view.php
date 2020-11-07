<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#cari").click(function() {
			var e = 'cari';
			tampil_data(e);
			return false();
		});

		$("#cetak").click(function() {
			var e = 'cetak';
			tampil_data(e);
			//window.open('<?php echo site_url(); ?>/lap_surat_keputusan/cetak/'+tgl1+'/'+tgl2);
			return false();
		});

		function tampil_data(e) {
			var th = $("#th").val();
			var bln = $("#bln").val();
			var no_rek = $("#no_rek").val();


			var string = "no_rek=" + no_rek + "&th=" + th + "&bln=" + bln;
			var string2 = no_rek + "/" + th + "/" + bln;

			if (th.length == 0) {
				Swal.fire({
					icon: 'error',
					title: 'Info',
					text: 'Maaf Tahun Tidak Boleh Kosong',
					timer: 2000,
				})
			}
			if (e == 'cari') {
				$("#tampil_data").html('');
				Swal.fire({
					title: 'Please waiting!',
					html: 'Loading data',
					timer: 4000,
					timerProgressBar: true,
					willOpen: () => {
						Swal.showLoading()
						timerInterval = setInterval(() => {
							const content = Swal.getContent()

						}, 500)
					},
					onClose: () => {
						clearInterval(timerInterval)
					}
				}).then((result) => {
					$("#tampil_data").html('');
					$.ajax({
						type: 'POST',
						url: "<?php echo site_url(); ?>/lap_neraca_saldo/view_data",
						data: string,
						cache: false,
						success: function(data) {
							//$("#tampil_data").html(data);
							setTimeout(function() {
								$("#tampil_data").html(data);
							}, 500)
						}
					});
				})
			} else {
				window.open('<?php echo site_url(); ?>/lap_neraca_saldo/cetak_data/' + string2);
				return false();
			}
		}
	});
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Neraca Saldo</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Laporan</a></li>
						<li class="breadcrumb-item active">Neraca Saldo</li>
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
						<h3 class="card-title">Daftar Laporan Neraca Saldo</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="form-group">
							<form class="form-inline" name="form" method="post" action="<?php echo base_url(); ?>index.php/buku_besar">
								<div class="form-group mx-sm-12 mb-2 btn-sm">
									<label><strong>Tahun :</strong></label> &nbsp;&nbsp;
									<select class="form-control" name="th" id="th">
										<option value="">- Pilih -</option>
										<?php
										foreach ($list_th->result_array() as $t) {
										?>
											<option value="<?php echo $t['th']; ?>"><?php echo $t['th']; ?></option>
										<?php } ?>
									</select>&nbsp;&nbsp;
								</div>
								<button type="button" name="cari" id="cari" class="btn btn-primary mb-2"><i class="fa fa-search" aria-hidden="true"></i> Cari</button> &nbsp;&nbsp;
								<button type="button" name="cetak" id="cetak" class="btn btn-secondary mb-2"><i class="fa fa-print" aria-hidden="true"></i> Cetak</button>
							</form>
						</div>
						<div id="tampil_data"></div>
					</div>

				</div>
			</div>
		</div>
	</section>
</div>