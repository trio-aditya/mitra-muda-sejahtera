<script type="text/javascript">
  $(document).ready(function() {
    $(':input:not([type="submit"])').each(function() {
      $(this).focus(function() {
        $(this).addClass('hilite');
      }).blur(function() {
        $(this).removeClass('hilite');
      });
    });


    $("#view").show();
    $("#form").hide();

    $("#tambah").click(function() {
      $("#view").hide();
      $("#form").show();
      $("#user_id").focus();
      return false();
    });

    function kosong() {
      $("#user_id").val('');
      $("#pwd").val('');
      $("#nama").val('');
      return false();
    }
    $("#simpan").click(function() {
      var user_id = $("#user_id").val();
      var nama = $("#nama").val();

      var string = $("#my-form").serialize();
      //alert(string);

      if (user_id.length == 0) {
        Swal.fire({
          icon: 'error',
          title: 'Info',
          text: 'Maaf, user_id Tidak Boleh Kosong',
          timer: 2000,
        });
        $("#user_id").focus();
        return false;
      }

      if (nama.length == 0) {
        Swal.fire({
          icon: 'error',
          title: 'Info',
          text: 'Maaf, Nama Lengkap Tidak Boleh Kosong',
          timer: 2000,
        });
        $("#nama").focus();
        return false;
      }

      $.ajax({
        type: 'POST',
        url: "<?php echo site_url(); ?>/users/simpan",
        data: string,
        cache: false,
        success: function(data) {
          console.log(data);
          $.messager.show({
            title: 'Info',
            msg: data,
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
          return false();
        }
      });
      return false();
    });

    $("#tambah_data").click(function() {
      $.ajax({
        type: 'POST',
        url: "<?php echo site_url(); ?>/users/tambah",
        cache: false,
        success: function(data) {
          kosong();
          $("#user_id").focus();
        }
      });
      return false();
    });

    $("#kembali").click(function() {
      window.location.assign('<?php echo base_url(); ?>index.php/users');
      return false();
    });
  });

  function editData(id) {
    var string = "id=" + id;
    $.ajax({
      type: 'POST',
      url: "<?php echo site_url(); ?>/users/edit",
      data: string,
      cache: true,
      dataType: "json",
      success: function(data) {
        $("#view").hide();
        $("#form").show();

        $("#user_id").focus();

        $("#user_id").val(id);
        $("#nama").val(data.nama);
        $("#level").val(data.level);
        return false();
      }
    });
  }
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Menu</a></li>
            <li class="breadcrumb-item active">Users</li>
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
        <?php echo $this->session->flashdata('pesan'); ?>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Daftar Users</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahdata">
              <i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data
            </button>
            <a class="btn btn-info btn-sm" href="<?php echo base_url(); ?>index.php/users" role="button" name="refresh" id="refresh"><i class="fa fa-retweet" aria-hidden="true"></i> Refresh</a><br><br>

            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th align="center">user_id</th>
                  <th>Nama Lengkap</th>
                  <th>Level</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($data->num_rows() > 0) {
                  $no = 1 + $hal;
                  foreach ($data->result_array() as $db) {
                ?>
                    <tr>
                      <td align="center" width="20"><?php echo $no; ?></td>
                      <td width="150"><?php echo $db['user_id']; ?></td>
                      <td><?php echo $db['namalengkap']; ?></td>
                      <td><?php echo $db['level']; ?></td>
                      <td align="center" width="80">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editmodal<?php echo $db['user_id']; ?>">
                          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                          </svg>
                        </button>
                        <a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>index.php/users/hapus/<?php echo $db['user_id']; ?>" role="button" onClick="return confirm('Anda yakin ingin menghapus data ini?')">
                          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                          </svg>
                        </a>
                      </td>
                    </tr>
                  <?php
                    $no++;
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan="6" align="center">Tidak Ada Data</td>
                  </tr>
                <?php
                }
                ?>

              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>user_id</th>
                  <th>Nama Lengkap</th>
                  <th>Level</th>
                  <th>Aksi</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </section>
</div><br><br>

<!-- Start Modal Tambah Data -->
<div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" name="tambah" id="tambah">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('users/proses_tambah_data'); ?>
      <div class="modal-body">
        <div class="form-group">
          <label><strong>User Id</strong></label>
          <input type="text" name="user_id" id="user_id" class="form-control" placeholder="Masukkan User Id">
        </div>
        <div class="form-group">
          <label><strong>Password</strong></label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password">
        </div>
        <div class="form-group">
          <label><strong>Nama Lengkap</strong></label>
          <input type="text" name="namalengkap" id="namalengkap" class="form-control" placeholder="Masukkan Nama Lengkap">
        </div>
        <div class="form-group">
          <label><strong>Level</strong></label>
          <select class="form-control" name="level" id="level">
            <option value="">-Pilih</option>
            <option value="super admin">Super Admin</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      <?php echo form_close() ?>
    </div>
  </div>
</div>
</div>
<!-- End Modal Tambah Data -->

<!-- Start of Modal Edit Data -->
<?php $no = 0; ?>
<?php foreach ($data->result_array() as $db) : ?>
  <div class="modal fade" id="editmodal<?php echo $db['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?php echo form_open_multipart('users/proses_edit_data'); ?>
        <input type="hidden" name="user_id" value="<?php echo $db['user_id']; ?>"></input>
        <div class="modal-body">
          <div class="form-group">
            <label><strong>user_id<strong></label>
            <input type="text" name="user_id" class="form-control" value="<?php echo $db['user_id'] ?>">
          </div>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label><strong>Password<strong></label>
            <input type="password" name="password" class="form-control" value="<?php echo $db['password'] ?>">
          </div>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label><strong>Nama lengkap<strong></label>
            <input type="text" name="namalengkap" class="form-control" value="<?php echo $db['namalengkap'] ?>">
          </div>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label><strong>Level</strong></label>
            <select class="form-control" name="level" id="level">
              <option value="">-Pilih</option>
              <option value="super admin">Super Admin</option>
              <option value="admin">Admin</option>
              <option value="user">User</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
          <?php echo form_close() ?>
        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- End of Modal Edit Data -->