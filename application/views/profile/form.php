<div id="form">
  <?php
  $info = $this->session->flashdata('info');
  if (!empty($info)) {
  ?>
    <p><?php echo $info; ?></p>
  <?php
  } ?>
  <?php
  $error = $this->session->flashdata('error');
  if (!empty($error)) {
  ?>
    <p><?php echo $error; ?></p>
  <?php
  } ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Profil</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Profil</li>
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
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-12">
            <?php echo $this->session->flashdata('pesan'); ?>
            <form name="my-form" id="my-form" method="post" action="<?php echo site_url(); ?>/profile/simpan" enctype="multipart/form-data" autocomplete="off">
              <div class="form-group">
                <label><strong>Username</strong></label>
                <input type="text" class="form-control" name="user_id" id="user_id" placeholder="Masukkan Username" value="<?php echo $user_id; ?>">
              </div>
              <hr>
              <div class="form-group">
                <label><strong>Password</strong></label>
                <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Masukkan Password" value="<?php echo $password; ?>">
                <p class="text-danger">*) Kosongkan jika tidak diubah</p>
              </div>
              <hr>
              <div class="form-group">
                <label><strong>Nama Lengkap</strong></label>
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Lengkap" value="<?php echo $nama; ?>">
              </div>
              <hr>
              <div class="form-group">
                <label><strong>Foto</strong></label>
                <input type="file" class="form-control-file" name="foto" id="foto">
              </div>
              <hr>
              <div class="form-group">
                <button type="submit" class="btn btn-success float-right">Simpan</button></div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</div><br><br>