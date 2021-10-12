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


        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Manage Users</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body" id='penyesuaian'>
            <table id="userTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nama leader</th>
                  <th>Email</th>
                  <th>Username</th>
                  <th>No Hp</th>
                  <th>Group</th>
                  <th>Outlet</th>

                  <?php if (in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php if ($user_data) : ?>
                  <?php foreach ($user_data as $k => $v) : ?>
                    <tr>
                      <td><?php echo $v['user_info']['firstname'] . ' ' . $v['user_info']['lastname']; ?></td>
                      <td><?php echo $v['user_info']['email']; ?></td>
                      <td><?php echo $v['user_info']['username']; ?></td>
                      <td><?php echo $v['user_info']['phone']; ?></td>
                      <td><?php echo $v['user_group']['group_name']; ?></td>
                      <td><?php echo $v['user_info']['store']; ?></td>

                      <?php if (in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>

                        <td>
                          <?php if (in_array('updateUser', $user_permission)) : ?>
                            <a href="<?php echo base_url('users/edit/' . $v['user_info']['id']) ?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
                          <?php endif; ?>
                          <?php if (in_array('deleteUser', $user_permission)) : ?>
                            <a href="<?php echo base_url('users/delete/' . $v['user_info']['id']) ?>" class="btn btn-default"><i class="fa fa-trash"></i></a>
                          <?php endif; ?>
                        </td>
                      <?php endif; ?>
                    </tr>
                  <?php endforeach ?>
                <?php endif; ?>
              </tbody>
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
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $('#userTable').DataTable();

    $("#mainUserNav").addClass('active');
    $("#manageUserNav").addClass('active');
  });
</script>