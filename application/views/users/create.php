<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>User</small>
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

        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b> Tambah Akun</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <form role="form" action="<?php base_url('users/create') ?>" method="post">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="groups">Group Akun</label>
                <select class="form-control" name="groups">
                  <option value="">Pilih Group</option>
                  <?php foreach ($group_data as $k => $v) : ?>
                    <option value="<?php echo $v['id'] ?>"><?php echo $v['group_name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label for="store">Outlet</label>
                <select class="form-control" id="store" name="store">
                  <option value="">Pilih Outlet</option>
                  <?php foreach ($s_data as $k => $v) : ?>
                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>


              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="username" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="cpassword">Masukkan password kembali</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Masukkan kembali" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="fname">Nama depan</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="Nama depan" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="lname">Nama belakang</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Nama Belakang" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="phone">No Hp</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="No Hp" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="gender">Gender</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="gender" id="male" value="1">
                    Laki-Laki
                  </label>
                  <label>
                    <input type="radio" name="gender" id="female" value="2">
                    Perempuan
                  </label>
                </div>
              </div>


              <div class="form-group">
                <label for="divisi">Izin Sebagai</label>
                <select class="form-control" id="divisi" name="divisi" required>
                  <option value="">-- Kode Izin --</option>
                  <option value="0">Office / Logistik</option>
                  <option value="11">Leader / Kasir</option>
                  <option value="1">Bar</option>
                  <option value="2">Waiter</option>
                  <option value="3">Kitchen</option>
                </select>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>
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
    $("#mainUserNav").addClass('active');
    $("#createUserNav").addClass('active');

  });



  $(document).ready(function() {
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });
  });
</script>