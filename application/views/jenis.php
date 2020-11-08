<script type="text/javascript">
	$(function() {
		$("#theTable tr:even").addClass("stripe1");
		$("#theTable tr:odd").addClass("stripe2");
		$("#theTable tr").hover(
			function() {
				$(this).toggleClass("highlight");
			},
			function() {
				$(this).toggleClass("highlight");
			}
		);
	});
	$(document).ready(function() {
		$(':input:not([type="submit"])').each(function() {
			$(this).focus(function() {
				$(this).addClass('hilite');
			}).blur(function() {
				$(this).removeClass('hilite');
			});
		});
		/*
	$("#jumlah").keypress(function (data)  { 
		if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
	          return false;
		}	
	});	
	$("#jumlah").blur(function(){
   		$(this).parseNumber({format:"#,###.00", locale:"us"});
  		$(this).formatNumber({format:"#,###.00", locale:"us"});	
	});
	*/

		$('#jumlah').priceFormat({
			prefix: '',
			centsSeparator: '',
			thousandsSeparator: ',',
			centsLimit: 0
		});
		$('#form_input').dialog({
			buttons: [{
				text: 'Simpan',
				iconCls: 'icon-save',
				handler: function() {
					simpan();
					return false;
				}
			}, {
				text: 'Tambah',
				iconCls: 'icon-add',
				handler: function() {
					$('input').val('');
					$('#userid').focus();
					return false;
				}
			}, {
				text: 'Tutup',
				iconCls: 'icon-close',
				handler: function() {
					$('#form_input').dialog('close');
					window.parent.location.reload(true);
					//$('.data').flexReload();
				}
			}]
		});

		$("#tambah").click(function() {
			$('#form_input').dialog('open');
			$('input').val('');
			CariKode();
			$('#jenis').focus();
		});

		function CariKode() {
			$.ajax({
				type: "POST",
				url: "<?php echo site_url(); ?>/jenis/CariKode",
				dataType: "json",
				success: function(data) {
					$('#id_jenis').val(data.id_jenis);
				}
			});
		}
		$("#refresh").click(function() {
			//window.parent.location.reload(true);
			window.location.replace('<?php echo site_url(); ?>/jenis/index');
		});

		function simpan() {
			var kts = $("#kontrol_simpanan").attr("checked");
			var ktp = $("#kontrol_penarikan").attr("checked");
			var ktl = $("#kontrol_laporan").attr("checked");
			if (kts == "checked") {
				$("#kontrol_simpanan").val('1')
			} else {
				$("#kontrol_simpanan").val('0')
			}
			if (ktp == "checked") {
				$("#kontrol_penarikan").val('1')
			} else {
				$("#kontrol_penarikan").val('0')
			}
			if (ktl == "checked") {
				$("#kontrol_laporan").val('1')
			} else {
				$("#kontrol_laporan").val('0')
			}
			var id_jenis = $("#id_jenis").val();
			var jenis = $("#jenis").val();
			var jumlah = $("#jumlah").val();
			var kontrol_simpanan = $("#kontrol_simpanan").val();
			var kontrol_penarikan = $("#kontrol_penarikan").val();
			var kontrol_laporan = $("#kontrol_laporan").val();

			if (id_jenis.length == 0) {
				alert('Maaf, ID Jenis tidak boleh kosong');
				$("#jenis").focus();
				return false();
			}
			if (jenis.length == 0) {
				alert('Maaf, Jenis Simpanan tidak boleh kosong');
				$("#jenis").focus();
				return false();
			}
			if (jumlah.length == 0) {
				alert('Maaf, Jumlah tidak boleh kosong');
				$("#jumlah").focus();
				return false();
			}

			var string = "id_jenis=" + id_jenis + "&jenis=" + jenis + "&jumlah=" + jumlah + "&kontrol_simpanan=" + kontrol_simpanan + "&kontrol_penarikan=" + kontrol_penarikan + "&kontrol_laporan=" + kontrol_laporan;
			//alert('Info ' + string);

			$.ajax({
				type: 'POST',
				url: "<?php echo site_url(); ?>/jenis/simpan",
				data: string,
				cache: false,
				success: function(data) {
					//alert('Info '+data);
					//window.parent.location.reload(true);
					$.messager.show({
						title: 'Info',
						msg: data, //'Password Tidak Boleh Kosong.',
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
				}
			});

		}
	});

	function editData(ID) {
		var cari = ID;
		$.ajax({
			type: "POST",
			url: "<?php echo site_url(); ?>/jenis/cari",
			data: "cari=" + cari,
			dataType: "json",
			success: function(data) {
				$('#form_input').dialog('open');
				$('#id_jenis').val(ID);
				$('#jenis').val(data.jenis);
				$('#jumlah').val(data.jumlah);
				//alert('Info ' + data.kontrol);
				if (data.kontrol_simpanan == 1) {
					$('#kontrol_simpanan').attr("checked", "checked");
				} else {
					$('#kontrol_simpanan').removeAttr("checked");
				}
				if (data.kontrol_penarikan == 1) {
					$('#kontrol_penarikan').attr("checked", "checked");
				} else {
					$('#kontrol_penarikan').removeAttr("checked");
				}
				if (data.kontrol_laporan == 1) {
					$('#kontrol_laporan').attr("checked", "checked");
				} else {
					$('#kontrol_laporan').removeAttr("checked");
				}
				$('#jenis').focus();
			}
		});
	}

	function deleteData(ID) {
		var id = ID;
		var pilih = confirm('Data yang akan dihapus  = ' + id + '?');
		if (pilih == true) {
			$.ajax({
				type: "POST",
				url: "<?php echo site_url(); ?>/jenis/hapus",
				data: "id=" + id,
				success: function(data) {
					window.parent.location.reload(true);
				}
			});
		}
	}
</script>
<style type="text/css">
	#tombol {
		float: left;
	}

	#pencarian {
		float: right;
	}
</style>
<div class="atas">
	<p><img src="<?php echo base_url(); ?>/asset/css/themes/icons/jenis.png" align="absmiddle" />
		DAFTAR JENIS SIMPANAN
	</p>
</div>
<div class="tengah">
	<div id="tombol_proses">
		<div id="tombol">
			<?php echo form_button($tambah, 'Tambah Data'); ?>
			<?php echo form_button($refresh, 'Refresh Data'); ?>
		</div>
		<div id="pencarian">
			<?php echo form_open('jenis/index'); ?>
			Pencarian <?php echo form_input($cari); ?>
			<?php echo form_close(); ?>
		</div>
	</div>
	<div class="tampil_data">
		<table id="theTable" width="100%">
			<tr>
				<th rowspan="2" width="5">No</th>
				<th rowspan="2" width="50">ID Jenis</th>
				<th rowspan="2">Jenis Simpanan</th>
				<th rowspan="2">Jumlah</th>
				<th colspan="3">Hanya Super Admin ?</th>
				<th rowspan="2" colspan="2">Aksi</th>
			</tr>
			<tr>
				<th>Simpanan</th>
				<th>Penarikan</th>
				<th>Laporan</th>
			</tr>
			<?php
			if ($dt_jenis->num_rows() > 0) {
				$no = 1 + $hal;
				foreach ($dt_jenis->result_array() as $db) {
					if ($db['kontrol_simpanan'] == 1) {
						$v_kontrol_simpanan = "Ya";
					} else {
						$v_kontrol_simpanan = "Tidak";
					}
					if ($db['kontrol_penarikan'] == 1) {
						$v_kontrol_penarikan = "Ya";
					} else {
						$v_kontrol_penarikan = "Tidak";
					}
					if ($db['kontrol_laporan'] == 1) {
						$v_kontrol_laporan = "Ya";
					} else {
						$v_kontrol_laporan = "Tidak";
					}
			?>
					<tr>
						<td align="center"><?php echo $no; ?></td>
						<td align="center"><?php echo $db['id_jenis']; ?></td>
						<td><?php echo $db['jenis_simpanan']; ?></td>
						<td align="right"><?php echo number_format($db['jumlah']); ?></td>
						<td align="center"><?php echo $v_kontrol_simpanan; ?></td>
						<td align="center"><?php echo $v_kontrol_penarikan; ?></td>
						<td align="center"><?php echo $v_kontrol_laporan; ?></td>
						<td align="center">
							<a href="javascript:editData('<?php echo $db['id_jenis'] ?>')">
								<img src="<?php echo base_url(); ?>asset/images/ed.png" title='Ubah'>
							</a>
						</td>
						<td align="center">
							<a href="javascript:deleteData('<?php echo $db['id_jenis']; ?>')">
								<img src="<?php echo base_url(); ?>asset/images/del.png" title='Hapus'>
							</a>
						</td>
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
		</table>
	</div>
	<div id="form_input" class="easyui-dialog" title="Input Data" style="padding:5px;width:520px;height:220px;" data-options="closed:true,modal:true,buttons:'#dlg-buttons',resizable:false">
		<p><label>ID Jenis</label>:<?php echo form_input($id_jenis); ?></p>
		<p><label>Jenis Simpanan</label>:<?php echo form_input($jenis); ?></p>
		<p><label>Jumlah</label>:<?php echo form_input($jumlah); ?></p>
		<p>
			<label>Hanya Super Admin?</label>:
			<?php echo form_checkbox($kontrol_simpanan);
			echo "Simpanan"; ?>
			<?php echo form_checkbox($kontrol_penarikan);
			echo "Penarikan"; ?>
			<?php echo form_checkbox($kontrol_laporan);
			echo "Laporan"; ?>
		</p>
	</div>
</div>
<div class="bawah">
	<div id="paging">
		<center><?php echo $paginator; ?></center>
	</div>
</div>