<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User
      <small>Profile</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Profile</li>
    </ol>
  </section>

  <!-- Main content -->

  <section class="content">
    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/images/logo/<?php echo $user_data['logo']; ?>" alt="User profile picture">

            <h3 class="profile-username text-center"><?php echo $user_data['store']; ?></h3>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Username</b> <a class="pull-right"><?php echo $user_data['username']; ?></a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
            <li><a href="#password" data-toggle="tab">Ubah Password</a></li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="settings">
              <form class="form-horizontal" action="<?php echo base_url('users/ubahdata') ?>" method="POST" enctype="multipart/form-data">


                <div class="form-group">
                  <label for="username" class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-10"><input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $user_data['username'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $user_data['email'] ?>" autocomplete="off">
                  </div>
                </div>


                <div class="form-group">
                  <label for="fname" class="col-sm-2 control-label">Nama Depan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" value="<?php echo $user_data['firstname'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="lname" class="col-sm-2 control-label">Nama Belakang</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" value="<?php echo $user_data['lastname'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="phone" class="col-sm-2 control-label">No Hp</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo $user_data['phone'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="gender" class="col-sm-2 control-label">Gender</label>
                  <div class="col-sm-10">
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
                </div>
                <div class="form-group">
                  <label for="inputFoto" class="col-sm-2 control-label">Foto</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" placeholder="Foto" name="logo">
                  </div>
                </div>


                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Submit</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane" id="password">
              <form class="form-horizontal" action="<?php echo base_url('users/ubah_password') ?>" method="POST">
                <div class="form-group">
                  <label for="passLama" class="col-sm-2 control-label">Password Lama</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" required="" placeholder="Password Lama" name="passLama">
                  </div>
                </div>
                <div class="form-group">
                  <label for="passBaru" class="col-sm-2 control-label">Password Baru</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" required placeholder="Password Baru" name="passBaru">
                  </div>
                </div>
                <div class="form-group">
                  <label for="passKonf" class="col-sm-2 control-label">Konfirmasi Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" required placeholder="Konfirmasi Password" name="passKonf">
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="msg" style="display:none;">
          <?php echo $this->session->flashdata('msg'); ?>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->



  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div class="box box-primary box-solid">

          <div class="box-header with-border">
            <h3 class="box-title">
              <b><i class="fa fa-users"></i> Profile</b>
            </h3>

            <!-- /.box-tools -->
          </div>

          <!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-condensed table-hovered">
              <tr>
                <th>Username</th>
                <td><?php echo $user_data['username']; ?></td>
              </tr>
              <tr>
                <th>Email</th>
                <td><?php echo $user_data['email']; ?></td>
              </tr>
              <tr>
                <th>Nama Depan</th>
                <td><?php echo $user_data['firstname']; ?></td>
              </tr>
              <tr>
                <th>Nama Belakang</th>
                <td><?php echo $user_data['lastname']; ?></td>
              </tr>
              <tr>
                <th>Gender</th>
                <td><?php echo ($user_data['gender'] == 1) ? 'Laki-Laki' : 'Perempuan'; ?></td>
              </tr>
              <tr>
                <th>No. Hp</th>
                <td><?php echo $user_data['phone']; ?></td>
              </tr>
              <tr>
                <th>Group</th>
                <td><span class="label label-info"><?php echo $user_group['group_name']; ?></span></td>
              </tr>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#profNav").addClass('active');

  });

  $(document).ready(function() {
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });
  });
</script>
<!-- /.content-wrapper -->