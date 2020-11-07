<hr>
<table id="example1" class="table table-bordered table-striped">
	<thead>
		<tr align="center">
			<th rowspan="2">No</th>
			<th rowspan="2">No Rek</th>
			<th rowspan="2">Nama Rek</th>
			<th colspan="2">Neraca Saldo</th>
		</tr>
		<tr align="center">
			<th>Debet</th>
			<th>Kredit</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ($data->num_rows() > 0) {
			$t_dr = 0;
			$t_kr = 0;
			$no = 1;
			foreach ($data->result_array() as $db) {
				$periode = $th - 1;

				$ns = $this->app_model->neraca_saldo($db['no_rek'], $th);
				if ($ns > 0) {
					$dr_ju = $ns;
					$kr_ju = 0;
				} else {
					$dr_ju = 0;
					$kr_ju = -1 * $ns;
				}
		?>
				<tr>
					<td align="center" width="20"><?php echo $no; ?></td>
					<td align="center" width="80"><?php echo $db['no_rek']; ?></td>
					<td><?php echo $db['nama_rek']; ?></td>
					<td align="right" width="80"><?php echo number_format($dr_ju); ?></td>
					<td align="right" width="80"><?php echo number_format($kr_ju); ?></td>
				</tr>
			<?php
				$t_dr = $t_dr + $dr_ju;
				$t_kr = $t_kr + $kr_ju;
				$no++;
			}
		} else {
			$t_dr = 0;
			$t_kr = 0;
			?>
			<tr>
				<td colspan="9" align="center">Tidak Ada Data</td>
			</tr>
		<?php
		}
		?>
		<tr>
			<td colspan="3" align="center"><strong>Saldo</strong></td>
			<td align="right"><strong><?php echo number_format($t_dr); ?></strong></td>
			<td align="right"><strong><?php echo number_format($t_kr); ?></strong></td>
		</tr>
	</tbody>
</table>