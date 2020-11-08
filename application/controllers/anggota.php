<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Anggota extends CI_Controller
{

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if (!empty($cek)) {
			$cari = $this->input->post('txt_cari');
			if (empty($cari)) {
				$where = ' ';
			} else {
				$where = " WHERE no_rek LIKE '%$cari%' OR nama_rek LIKE '%$cari%'";
			}

			$d['prg'] = $this->config->item('prg');
			$d['web_prg'] = $this->config->item('web_prg');

			$d['nama_program'] = $this->config->item('nama_program');
			$d['instansi'] = $this->config->item('instansi');
			$d['usaha'] = $this->config->item('usaha');
			$d['alamat_instansi'] = $this->config->item('alamat_instansi');


			$d['judul'] = "Rekening";

			//paging
			$page = $this->uri->segment(3);

			$text = "SELECT * FROM anggota ORDER BY noanggota ASC";
			$d['data'] = $this->app_model->manualQuery($text);

			$d['content'] = $this->load->view('anggota/view', $d, true);
			$this->load->view('home', $d);
		} else {
			header('location:' . base_url());
		}
	}

	public function tambah()
	{
		$cek = $this->session->userdata('logged_in');
		if (!empty($cek)) {
			$d['prg'] = $this->config->item('prg');
			$d['web_prg'] = $this->config->item('web_prg');

			$d['nama_program'] = $this->config->item('nama_program');
			$d['instansi'] = $this->config->item('instansi');
			$d['usaha'] = $this->config->item('usaha');
			$d['alamat_instansi'] = $this->config->item('alamat_instansi');

			$d['judul'] = "Rekening";

			$text = "SELECT * FROM rekening";
			$d['list'] = $this->app_model->manualQuery($text);


			$d['content'] = $this->load->view('rekening/form', $d, true);
			$this->load->view('home', $d);
		} else {
			header('location:' . base_url());
		}
	}

	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		if (!empty($cek)) {
			/*
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Surat Perintah";
			$d['message'] = '';
			*/

			$id = $this->input->post('id');  //$this->uri->segment(3);
			$text = "SELECT * FROM rekening WHERE no_rek='$id'";
			$data = $this->app_model->manualQuery($text);
			//if($data->num_rows() > 0){
			foreach ($data->result() as $db) {
				$d['no_rek']		= $db->no_rek;
				$d['rek_induk']	= $db->induk;
				$d['nama_rek']	= $db->nama_rek;
				echo json_encode($d);
			}
			//}

			//$d['content'] = $this->load->view('rekening/tambah', $d, true);		
			//$this->load->view('home',$d);
		} else {
			header('location:' . base_url());
		}
	}

	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		if (!empty($cek)) {
			$id = $this->uri->segment(3);
			$this->app_model->manualQuery("DELETE FROM jenis_simpan WHERE id_jenis='$id'");
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "index.php/jenis'>";
		} else {
			header('location:' . base_url());
		}
	}

	public function simpan()
	{

		$cek = $this->session->userdata('logged_in');
		if (!empty($cek)) {

			$induk = $this->input->post('rek_induk');

			if ($induk != 0) {
				$level = $this->app_model->CariLevel($induk);
				$up['induk'] = $this->input->post('rek_induk');
				$up['level'] = $level + 1;
			} else {
				$up['induk'] = 0;
				$up['level'] = 0;
			}
			$up['no_rek'] = $this->input->post('no_rek');
			$up['nama_rek'] = $this->input->post('nama_rek');

			$id['no_rek'] = $this->input->post('no_rek');

			$data = $this->app_model->getSelectedData("rekening", $id);
			if ($data->num_rows() > 0) {
				$this->app_model->updateData("rekening", $up, $id);
				echo 'Update data Sukses';
			} else {
				$this->app_model->insertData("rekening", $up);
				echo 'Simpan data Sukses';
			}
		} else {
			header('location:' . base_url());
		}
	}

	//Tambah Data Anggota
	public function proses_tambah_data()
	{

		$password = $this->input->post('pwd');

		$config['upload_path']          = './assets/images/anggota/';
		$config['allowed_types']        = 'jpg|jpeg|JPG|JPEG|png';

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('foto')) {
			$data['error_upload'] = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error', ' ');
			redirect('auth/login');
		} else {
			$data = array('upload_data' => $this->upload->data());

			$dataa = [
				"noanggota" => getAutoNumber('anggota', 'noanggota', 'A', 4),
				"noidentitas" => $this->input->post('noidentitas'),
				"namaanggota" => $this->input->post('namaanggota'),
				"pwd" => md5($password),
				"jk" => $this->input->post('jk'),
				"tempat_lahir" => $this->input->post('tempat_lahir'),
				"tgl_lahir" => $this->input->post('tgl_lahir'),
				"hp" => $this->input->post('hp'),
				"alamat" => $this->input->post('alamat'),
				"foto" => $data['upload_data']['file_name'],
			];

			$this->db->insert('anggota', $dataa);

			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Data berhasil ditambahkan!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('anggota');
		}
	}

	//Edit Data Anggota
	public function proses_edit_data()
	{
		$data = [
			"noidentitas" => $this->input->post('noidentitas'),
			"namaanggota" => $this->input->post('namaanggota'),
			"jk" => $this->input->post('jk'),
			"tempat_lahir" => $this->input->post('tempat_lahir'),
			"tgl_lahir" => $this->input->post('tgl_lahir'),
			"hp" => $this->input->post('hp'),
			"alamat" => $this->input->post('alamat'),
		];

		$this->db->where('noanggota', $this->input->post('noanggota'));
		$this->db->update('anggota', $data);

		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil diubah!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>');
		redirect('anggota');
	}

	//Edit Data Foto
	public function proses_edit_foto()
	{

		$id = $this->input->post('noanggota');
		$data = $this->app_model->editfoto($id);
		$nama = 'assets/images/anggota/' . $data['foto'];

		if (is_readable($nama) && unlink($nama)) {
			$config['upload_path']          = './assets/images/anggota/';
			$config['allowed_types']        = 'jpg|jpeg|JPG|JPEG|png';
			$config['max_size']             = '2048';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('foto')) {
				$data['error_upload'] = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('error', ' ');
				redirect('anggota');
			} else {
				$upload_data = array('upload_data' => $this->upload->data());
				$name = $upload_data['foto'];

				$data = array(
					"foto" => $name,
				);

				$nama = array('upload_data' => $this->upload->data());
				$dataa = [
					'foto' => $nama['upload_data']['file_name']
				];

				$this->db->where('noanggota', $this->input->post('noanggota'));
				$this->db->update('anggota', $dataa);

				$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data berhasil diubah!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>');
				redirect('anggota');
			}
		}
	}

	public function hapus_data($id)
	{
		$data = $this->app_model->editfoto($id);
		$nama = 'assets/images/anggota/' . $data['foto'];

		if (is_readable($nama) && unlink($nama)) {
			$this->db->where('noanggota', $id);
			$this->db->delete('anggota');

			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data berhasil dihapus!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
			redirect('anggota');
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-alert alert-dismissible fade show" role="alert">
            <strong>Data gagal dihapus!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
			redirect('anggota');
		}
	}
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */