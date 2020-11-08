<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller
{

  /**
   * @author : Deddy Rusdiansyah,S.Kom
   * @web : http://deddyrusdiansyah.blogspot.com
   * @keterangan : Controller untuk halaman profil
   **/



  public function edit()
  {
    $cek = $this->session->userdata('logged_in');
    if (!empty($cek)) {
      $d['prg'] = $this->config->item('prg');
      $d['web_prg'] = $this->config->item('web_prg');

      $d['nama_program'] = $this->config->item('nama_program');
      $d['instansi'] = $this->config->item('instansi');
      $d['usaha'] = $this->config->item('usaha');
      $d['alamat_instansi'] = $this->config->item('alamat_instansi');

      $d['judul'] = "Edit Profile";

      $id = $this->uri->segment(3);
      $text = "SELECT * FROM users_akuntansi WHERE id_user='$id'";
      $data = $this->app_model->manualQuery($text);

      foreach ($data->result() as $db) {
        $d['id_user']    = $db->id_user;
        $d['user_id']    = $db->user_id;
        $d['nama']  = $db->namalengkap;
        $d['level']  = $db->level;
        $d['pwd']  = ' ';
      }
      $d['content'] = $this->load->view('profile/form', $d, true);
      $this->load->view('home', $d);
    } else {
      header('location:' . base_url());
    }
  }


  public function simpan()
  {

    $cek = $this->session->userdata('logged_in');
    if (!empty($cek)) {

      $pwd = $this->input->post('pwd');
      $id_user = $this->input->post('id_user');

      $foto = $_FILES['foto'];

      $config['upload_path'] = './asset/foto_profil';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['overwrite']  = TRUE;
      $config['max_size']  = '2000*2';

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('foto')) {
        $this->upload->data();
        $up['foto'] = $foto['name'];
        $error = 'upload sukses';
        $this->session->set_flashdata('error', $error);
      } else {
        $error = 'Error Upload Foto : ' . $this->upload->display_errors();
        $this->session->set_flashdata('error', $error);
      }


      if (!empty($pwd)) {
        $up['password'] = md5($pwd);
      }

      $up['user_id']     = $this->input->post('user_id');
      $up['namalengkap'] = $this->input->post('nama');
      $id['id_user']     = $id_user;

      $data = $this->app_model->getSelectedData("users_akuntansi", $id);
      if ($data->num_rows() > 0) {
        $this->app_model->updateData("users_akuntansi", $up, $id);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Data berhasil diubah!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>');
      }

      redirect('profile/edit/' . $id_user);
    } else {
      header('location:' . base_url());
    }
  }
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */
