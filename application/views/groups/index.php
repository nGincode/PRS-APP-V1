<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Groups</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">groups</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">


        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Manage Groups</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="groupTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nama Group</th>
                  <?php if (in_array('updateGroup', $user_permission) || in_array('deleteGroup', $user_permission)) : ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php if ($groups_data) : ?>
                  <?php foreach ($groups_data as $k => $v) : ?>
                    <tr>
                      <td><?php echo $v['group_name']; ?></td>

                      <?php if (in_array('updateGroup', $user_permission) || in_array('deleteGroup', $user_permission)) : ?>
                        <td>
                          <?php if (in_array('updateGroup', $user_permission)) : ?>
                            <a href="<?php echo base_url('groups/edit/' . $v['id']) ?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
                          <?php endif; ?>
                          <?php if (in_array('deleteGroup', $user_permission)) : ?>
                            <a href="<?php echo base_url('groups/delete/' . $v['id']) ?>" class="btn btn-default"><i class="fa fa-trash"></i></a>
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
    $('#groupTable').DataTable();

    $("#mainGroupNav").addClass('active');
    $("#manageGroupNav").addClass('active');
  });
</script>