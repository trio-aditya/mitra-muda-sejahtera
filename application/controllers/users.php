<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
{

  public function index()
  {
    $cek = $this->session->userdata('logged_in');
    if (!empty($cek)) {
      $cari = $this->input->post('txt_cari');
      if (empty($cari)) {
        $where = ' ';
      } else {
        $where = " WHERE user_id LIKE '%$cari%' OR namalengkap LIKE '%$cari%'";
      }

      $d['prg'] = $this->config->item('prg');
      $d['web_prg'] = $this->config->item('web_prg');

      $d['nama_program'] = $this->config->item('nama_program');
      $d['instansi'] = $this->config->item('instansi');
      $d['usaha'] = $this->config->item('usaha');
      $d['alamat_instansi'] = $this->config->item('alamat_instansi');


      $d['judul'] = "Users";

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

      $config['base_url'] = site_url() . '/users/index/';
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


      $text = "SELECT * FROM users_akuntansi $where
          ORDER BY user_id ASC
          LIMIT $limit OFFSET $offset";
      $d['data'] = $this->app_model->manualQuery($text);

      $text = "SELECT * FROM rekening";
      $d['list'] = $this->app_model->manualQuery($text);


      $d['content'] = $this->load->view('users/view', $d, true);
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

      $d['judul'] = "Users";



      $d['content'] = $this->load->view('users/form', $d, true);
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
      $text = "SELECT * FROM users_akuntansi WHERE user_id='$id'";
      $data = $this->app_model->manualQuery($text);
      //if($data->num_rows() > 0){
      foreach ($data->result() as $db) {
        $d['user_id']    = $db->user_id;
        $d['nama']  = $db->namalengkap;
        $d['level']  = $db->level;
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
      $this->app_model->manualQuery("DELETE FROM users_akuntansi WHERE user_id='$id'");
      echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "index.php/users'>";
    } else {
      header('location:' . base_url());
    }
  }

  public function simpan()
  {

    $cek = $this->session->userdata('logged_in');
    if (!empty($cek)) {

      $pwd = md5($this->input->post('pwd'));

      if (!empty($pwd)) {
        $up['password'] = $pwd;
      }

      $up['user_id'] = $this->input->post('user_id');
      $up['namalengkap'] = $this->input->post('nama');
      $up['level'] = $this->input->post('level');

      $id['user_id'] = $this->input->post('user_id');

      $data = $this->app_model->getSelectedData("users_akuntansi", $id);
      if ($data->num_rows() > 0) {
        $this->app_model->updateData("users_akuntansi", $up, $id);
        echo 'Update data Sukses';
      } else {
        $this->app_model->insertData("users_akuntansi", $up);
        echo 'Simpan data Sukses';
      }
    } else {
      header('location:' . base_url());
    }
  }

  //Tambah Data User
  public function proses_tambah_data()
  {

    $data = [
      "user_id" => $this->input->post('user_id'),
      "password" => md5($this->input->post('password')),
      "namalengkap" => $this->input->post('namalengkap'),
      "level" => $this->input->post('level'),
    ];

    $this->db->insert('users_akuntansi', $data);

    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil ditambahkan!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>');
    redirect('users');
  }

  //Edit Data User
  public function proses_edit_data()
  {
    $data = [
      "user_id" => $this->input->post('user_id'),
      "password" => md5($this->input->post('password')),
      "namalengkap" => $this->input->post('namalengkap'),
      "level" => $this->input->post('level'),
    ];

    $id['user_id'] = $this->input->post('user_id');

    $this->db->where('user_id', $this->input->post('user_id'));
    $this->db->update('users_akuntansi', $data);

    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil diubah!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>');
    redirect('users');
  }
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */
