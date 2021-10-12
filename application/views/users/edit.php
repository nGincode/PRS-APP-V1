<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Users</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Users</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div class="box box-danger box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b> Edit Akun</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <form role="form" action="<?php base_url('users/create') ?>" method="post">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="groups">Group</label>
                <select class="form-control" name="groups">
                  <option value="">Pilih Group</option>
                  <?php foreach ($group_data as $k => $v) : ?>
                    <option value="<?php echo $v['id'] ?>" <?php if ($user_group['id'] == $v['id']) {
                                                              echo 'selected';
                                                            } ?>><?php echo $v['group_name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <div class="form-group">
                <label for="store">Outlet</label>
                <select class="form-control" id="store" name="store">
                  <?php foreach ($s_data as $k => $v) : ?>
                    <option value="<?php echo $v['id'] ?>" <?php if ($user_data['store'] == $v['name']) {
                                                              echo 'selected';
                                                            } ?>><?php echo $v['name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $user_data['username'] ?>" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $user_data['email'] ?>" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="fname">Nama Depan</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" value="<?php echo $user_data['firstname'] ?>" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="lname">Nama Belakang</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" value="<?php echo $user_data['lastname'] ?>" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="phone">No Hp</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo $user_data['phone'] ?>" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="gender">Gender</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="gender" id="male" value="1" <?php if ($user_data['gender'] == 1) {
                                                                            echo "checked";
                                                                          } ?>>
                    Laki-Laki
                  </label>
                  <label>
                    <input type="radio" name="gender" id="female" value="2" <?php if ($user_data['gender'] == 2) {
                                                                              echo "checked";
                                                                            } ?>>
                    Perempuan
                  </label>
                </div>
              </div>



              <div class="form-group">
                <label for="divisi">Izin</label>
                <select class="form-control" id="divisi" name="divisi" required>
                  <option value="">-- Kode Izin --</option>
                  <option value="0" <?php if ($user_data['divisi'] == 0) {
                                      echo "selected";
                                    } ?>>0</option>
                  <option value="11" <?php if ($user_data['divisi'] == 11) {
                                        echo "selected";
                                      } ?>>11</option>
                  <option value="1" <?php if ($user_data['divisi'] == 1) {
                                      echo "selected";
                                    } ?>>1</option>
                  <option value="2" <?php if ($user_data['divisi'] == 2) {
                                      echo "selected";
                                    } ?>>2</option>
                  <option value="3" <?php if ($user_data['divisi'] == 3) {
                                      echo "selected";
                                    } ?>>3</option>
                </select>
              </div>


              <div class="form-group">
                <div class="alert alert-info alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Masukkan password untuk mengubah.
                </div>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="text" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="cpassword">Ulangi Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Ulangi Password" autocomplete="off">
              </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>
              <a href="<?php echo base_url('users/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#groups").select2();

    $("#mainUserNav").addClass('active');
    $("#manageUserNav").addClass('active');
  });


  $(document).ready(function() {
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });
  });
</script>