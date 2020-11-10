<?php
function tgl_indo($tanggal)
{
	$bulan = array(
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);

	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun

	return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
?>

<!DOCTYPE html>
<style type="text/css">
	* {
		font-family: Arial;
		font-size: 12px;
	}

	#kotak_luar {
		width: 20.4cm;
		margin: 10px 10px 10px 10px;
		font-size: 12px;
	}

	#kotak_judul {
		border: 2px solid;
		line-height: 5px;
	}

	#judul_koperasi {
		width: 450px;
	}

	h1 {
		font-size: 16px;
	}

	h2 {
		font-size: 10px;
	}

	h1 u {
		font-size: 16px;
	}

	#nomor {
		float: right;
		margin-right: 40px;
		margin-top: -5px;
		font-size: 12px;
		font-weight: bold;
	}

	#kotak_subjek {
		padding-left: 20px;
		padding-top: 20px;
		width: 500px;
		border: 2px solid;
		clear: both;
		height: 250px;
	}

	#t_subjek tr {
		height: 60px;
	}

	#t_subjek i {
		font-size: 16px;
	}

	#kotak_nip {
		float: right;
		padding-top: 20px;
		width: 245px;
		border: 2px solid;
		margin-top: -274px;
		height: 250px;
	}

	#dalam_kotak_nip {
		padding: 5px 15px 5px 5px;
	}
</style>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cetak Data Pengambilan</title>
</head>

<body>
	<?php
	if ($hasil->num_rows() > 0) {
		foreach ($hasil->result_array() as $db) {
			$terbilang = $this->app_model->terbilang($db['jumlah'], 4);
	?>
			<div id='kotak_luar'>
				<div id='kotak_judul'>
					<div id='judul_koperasi' align='center'>
						<h1><?php echo $nama_perusahaan; ?></h1>
						<h2><u><?php echo $alamat_perusahaan; ?></u></h2>
					</div>
					<div id='nomor'>
						Nomor : <?php echo sprintf("%05s", $nomor); ?></b>
					</div>
					<br>
					<span id='kwitansi' align='center'>
						<h1>KWITANSI TANDA TERIMA</h1>
					</span>
					<br>
				</div>
				<div id='kotak_subjek'>
					<table id='t_subjek'>
						<tr>
							<td valign='top' width='70'>Subjek</td>
							<td valign='top' width='2'>:</td>
							<td valign='top'>Sudah terima dari <b><i><?php echo $db['namaanggota']; ?></i></b> <br>alamat <?php echo $db['alamat']; ?></td>
						</tr>
						<tr>
							<td valign='top'>Untuk</td>
							<td valign='top' width='2'>:</td>
							<td valign='top'>(Penarikan / Setoran) <?php echo $db['jenis_simpanan']; ?> </td>
						</tr>
						<tr>
							<td valign='top'>Terbilang</td>
							<td valign='top' width='2'>:</td>
							<td valign='top'><i><?php echo $terbilang; ?> rupiah</i></td>
						</tr>
						<tr>
							<td valign='top'>Rp</td>
							<td valign='top' width='2'>:</td>
							<td valign='top'><b><i><?php echo number_format($db['jumlah']); ?></i></b></td>
						</tr>
					</table>
				</div>
				<div id='kotak_nip'>
					<div id='dalam_kotak_nip'>
						<table>
							<tr>
								<td valign='top' width='70'>NIP</td>
								<td valign='top' width='2'>:</td>
								<td valign='top'><b><?php echo $db['noanggota']; ?></b></td>
							</tr>
							<tr>
								<td valign='top' width='70'>No. Rek</td>
								<td valign='top' width='2'>:</td>
								<td valign='top'><?php echo $db['noidentitas']; ?></td>
							</tr>
						</table>
						<br><br>
						<p>
							<center>Lampung Tengah, <?php echo tgl_indo(date($db['tgl'])); ?></center>
						</p>
						<br>
						<p>
							<center>Yang Menerima</center>
						</p>
						<br><br><br>
						<p>
							<center>(_______________________)</center>
						</p>

					</div>
				</div>
			</div>
		<?php
			$no++;
		}
	} else {
		?>
	<?php
	}
	?>
</body>

</html>