<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Simpanan extends CI_Controller
{

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$akses = $this->session->userdata('level');
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
			$limit = $this->config->item('limit_data');
			if (!$page) :
				$offset = 0;
			else :
				$offset = $page;
			endif;

			$text = "SELECT * FROM rekening $where ";
			$tot_hal = $this->app_model->manualQuery($text);

			$d['tot_hal'] = $tot_hal->num_rows();

			$config['base_url'] = site_url() . '/rekening/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['next_link'] = 'Lanjut &raquo;';
			$config['prev_link'] = '&laquo; Kembali';
			$config['last_link'] = '<b>Terakhir &raquo; </b>';
			$config['first_link'] = '<b> &laquo; Pertama</b>';
			$this->pagination->initialize($config);
			$d["paginator"] = $this->pagination->create_links();
			$d['hal'] = $offset;

			$jenis = $this->app_model->manualQuery("SELECT * FROM jenis_simpan");
			$d['opt_jenis'][''] = '-Pilih-';
			foreach ($jenis->result() as $db) {
				if ($akses == 'super admin') {
					$d['header_jenis'] = $jenis;
					$d['opt_jenis'][$db->id_jenis] = '| ' . $db->id_jenis . ' | ' . $db->jenis_simpanan;
				} else {
					if ($db->kontrol_laporan != 1) {
						$d['header_jenis'] = $this->app_model->manualQuery("SELECT * FROM jenis_simpan WHERE kontrol_laporan != '1'");
					}
					if ($db->kontrol_simpanan != 1) {
						$d['opt_jenis'][$db->id_jenis] = '| ' . $db->id_jenis . ' | ' . $db->jenis_simpanan;
					}
				}
			}


			$text = "SELECT a.*, b.* FROM simpanan a JOIN anggota b ON a.noanggota = b.noanggota GROUP BY a.noanggota";
			$d['data'] = $this->app_model->manualQuery($text);

			$text = "SELECT a.*, b.* FROM anggota a, simpanan b WHERE a.noanggota = b.noanggota";
			$d['list'] = $this->app_model->manualQuery($text);

			$d['content'] = $this->load->view('simpanan/view', $d, true);
			$this->load->view('home', $d);
		} else {
			header('location:' . base_url());
		}
	}

	public function tambah_data()
	{
		$cek = $this->session->userdata('logged_in');
		if (!empty($cek)) {
			//$id = 'A001';
			$noanggota = $this->input->post('noanggota');

			$where = " WHERE a.noanggota='$noanggota'";

			$text = "SELECT a.id_simpanan,a.noanggota,a.id_jenis,a.jumlah,a.tgl,
					b.jenis_simpanan
					FROM simpanan as a
					JOIN jenis_simpan as b
					ON a.id_jenis=b.id_jenis
					
					ORDER BY a.id_simpanan DESC";
			$d['dt_view_simpanan'] = $this->app_model->manualQuery($text);

			$text = "SELECT * FROM jenis_simpan";
			$d['list_jenis'] = $this->app_model->manualQuery($text);

			$text = "SELECT * FROM anggota";
			$d['data'] = $this->app_model->manualQuery($text);


			$d['content'] = $this->load->view('simpanan/tambah_data', $d, true);
			$this->load->view('home', $d);
		} else {
			header('location:' . base_url());
		}
	}

	public function cari()
	{
		$noanggota = $_GET['noanggota'];
		$cari = $this->app_model->cari($noanggota)->result();
		echo json_encode($cari);
	}

	public function view_simpanan()
	{
		$cek = $this->session->userdata('logged_in');
		if (!empty($cek)) {
			$id = $this->input->post('noanggota');

			//paging
			$page = $this->uri->segment(3);
			$limit = $this->config->item('limit_data');
			if (!$page) :
				$offset = 0;
			else :
				$offset = $page;
			endif;

			$text = "SELECT *
					FROM simpanan 
					WHERE noanggota='$id'";
			$tot_hal = $this->app_model->manualQuery($text);
			/*
			$config['full_tag_open'] = '<div class="ajax_paging">';
			$config['full_tag_close'] = '</div>';
			*/
			$config['base_url'] = site_url() . '/simpanan/view_simpanan/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$d['paginators'] = $this->pagination->create_links();
			$d['hal'] = $offset;

			//LIMIT $limit OFFSET $offset
			$text = "SELECT a.id_simpanan,a.noanggota,a.id_jenis,a.jumlah,a.tgl,
					b.jenis_simpanan
					FROM simpanan as a
					JOIN jenis_simpan as b
					ON a.id_jenis=b.id_jenis
					WHERE a.noanggota='$id'
					ORDER BY a.id_simpanan DESC
					LIMIT $limit OFFSET $offset";
			$d['dt_view_simpanan'] = $this->app_model->manualQuery($text);

			$this->load->view('simpanan/view_simpanan', $d, true);
		} else {
			header('location:' . base_url());
		}
	}

	//Cetak Data
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		if (!empty($cek)) {
			$id = $this->input->get('id');

			$d['nomor'] = $id; //$this->config->item('judul');
			$d['judul'] = $this->config->item('judul');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');

			$text = "SELECT a.id_simpanan,a.noanggota,a.id_jenis,a.jumlah,a.tgl,
					b.jenis_simpanan,
					c.namaanggota,c.noidentitas,c.alamat
					FROM simpanan as a
					JOIN jenis_simpan as b
					JOIN anggota as c
					ON a.id_jenis=b.id_jenis AND a.noanggota=c.noanggota
					WHERE a.id_simpanan='$id'";

			$d['hasil'] = $this->app_model->manualQuery($text);

			$this->load->view('simpanan/cetak_terima', $d);
		} else {
			header('location:' . base_url());
		}
	}
	public function CariData()
	{
		$cek = $this->session->userdata('logged_in');
		if (!empty($cek)) {
			$id['id_simpanan'] = $this->input->post('id');

			$hasil = $this->app_model->getSelectedData("simpanan", $id);
			$row = $hasil->num_rows();
			if ($row > 0) {
				$data['info'] = true;
				echo json_encode($data);
			} else {
				$data['info'] = false;
				echo json_encode($data);
			}
		} else {
			header('location:' . base_url());
		}
	}

	//Tambah Data Simpanan
	public function proses_tambah_data()
	{

		$data = [
			"tgl" => $this->input->post('tgl'),
			"noanggota" => $this->input->post('noanggota'),
			"id_jenis" => $this->input->post('id_jenis'),
			"jumlah" => $this->input->post('jumlah'),
			"user_id" => $this->session->userdata('user_id'),
			"tglinsert" => date('Y-m-d h:m:s'),
		];

		$this->db->insert('simpanan', $data);

		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil ditambahkan!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>');
		redirect('simpanan/tambah_data');
	}

	//Hapus Data Simpanan
	public function hapus_data($id)
	{
		$this->db->where('id_simpanan', $id);
		$this->db->delete('simpanan');

		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil dihapus!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>');
		redirect('simpanan/tambah_data');
	}
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */