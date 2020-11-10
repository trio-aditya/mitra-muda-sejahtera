<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ref_json extends CI_Controller
{
	public function CariAnggota()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if (!empty($cek) && $level == 'admin') {
			$id['noanggota'] = $this->input->post('nomor');

			$hasil = $this->app_model->getSelectedData("anggota", $id);
			$row = $hasil->num_rows();
			if ($row > 0) {
				foreach ($hasil->result() as $db) {
					if ($db->jk == 'L') {
						$sex = 'Laki-laki';
					} else {
						$sex = 'Perempuan';
					}
					$data['identitas'] = $db->noidentitas;
					$data['anggota'] = $db->namaanggota;
					$data['jk'] = $sex; // $db->jk;
					$data['tempat_lhr'] = $db->tempat_lahir;
					$data['tgl_lhr'] = $this->app_model->tgl_str($db->tgl_lahir);
					//$data['alamat'] = $db->alamat;
					$data['hp'] = $db->hp;
					$data['sisa_angsuran'] = number_format($this->app_model->sisa_pinjaman($db->noanggota));
					$id_pinjam =  $this->app_model->cari_nopinjam($db->noanggota);
					$data['no_pinjam'] = $id_pinjam;
					$data['lama'] = $this->app_model->cari_lama($id_pinjam);
					$data['bunga'] = $this->app_model->cari_bunga($id_pinjam);
					$data['jumlah'] = number_format($this->app_model->cari_jumlah($id_pinjam));
					$data['angsuran'] = $this->app_model->cicilan_ke($id_pinjam) . ' / ' .
						number_format($this->app_model->cicilan_angsuran($id_pinjam));

					echo json_encode($data);
				}
			} else {
				$data['identitas'] = '';
				$data['anggota'] = '';
				$data['jk'] = '';
				//$data['tempat_lhr'] = '';
				//$data['tgl_lhr'] = '';
				//$data['alamat'] = '';
				$data['hp'] = '';
				$data['sisa_angsuran'] = '';
				$data['no_pinjam'] = '';
				$data['lama'] = '';
				$data['bunga'] = '';
				$data['jumlah'] = '';
				$data['angsuran'] = '';
				echo json_encode($data);
			}
		} else {
			redirect('/koperasi/logout/', 'refresh');
		}
	}

	public function CariJenis()
	{
		$cek = $this->session->userdata('logged_in');
		$level = $this->session->userdata('level');
		if (!empty($cek) && $level == 'admin') {
			$id['id_jenis'] = $this->input->post('id');

			$hasil = $this->app_model->getSelectedData("jenis_simpan", $id);
			$row = $hasil->num_rows();
			if ($row > 0) {
				foreach ($hasil->result() as $db) {
					$data['jumlah'] = $db->jumlah;

					echo json_encode($data);
				}
			} else {
				$data['jumlah'] = 0;

				echo json_encode($data);
			}
		} else {
			redirect('/koperasi/logout/', 'refresh');
		}
	}
}

/* End of file anggota.php */
/* Location: ./application/controllers/anggota.php */
