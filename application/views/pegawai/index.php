<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Pegawai</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pegawai</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <?php if (in_array('createUser', $user_permission)) : ?>
          <a href="<?php echo base_url('users/create') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah User</a>
          <br /> <br />
        <?php endif; ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Pegawai</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body" style="overflow: auto;">
            <table id="userTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Store</th>
                  <th>Divisi</th>
                  <th>Jabatan</th>
                  <th>TTL</th>
                  <th style='width:120px'>Bergabung</th>
                  <th>Agama</th>
                  <th>Hp</th>
                  <th style='width:150px'>Alamat</th>

                  <?php if (in_array('updatePegawai', $user_permission) || in_array('deletePegawai', $user_permission)) : ?>
                    <th style='width:70px'>Action</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($pegawai_data as $k => $v) : ?>
                  <tr <?php if ($v['keluar'] == 1) {
                        echo 'style="background-color: #ff000012;"';
                      } ?>>
                    <td><?php echo $v['nama']; ?></td>
                    <td><?php $pegawai_data = $this->model_stores->getStoresData($v['store_id']);
                        echo $pegawai_data['name']; ?></td>
                    <td><?php echo $v['divisi']; ?></td>
                    <td><?php echo $v['jabatan']; ?></td>
                    <td><?php echo $v['tempat'] . ', <br>' . date('d-m-Y', strtotime($v['lahir']));; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($v['masuk_kerja'])); ?></td>
                    <td><?php echo $v['agama']; ?></td>
                    <td><?php echo $v['hp']; ?></td>
                    <td><?php echo $v['alamat']; ?></td>

                    <?php if (in_array('updatePegawai', $user_permission) || in_array('deletePegawai', $user_permission)) : ?>

                      <td>
                        <?php if (in_array('updatePegawai', $user_permission)) : ?>
                          <a href="<?php echo base_url('pegawai/edit/' . $v['id']) ?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
                        <?php endif; ?>
                        <?php if (in_array('deletePegawai', $user_permission)) : ?>
                          <button type="button" class="btn btn-default" onclick="removeFunc(<?php echo $v['id'] ?>)"><i class="fa fa-trash"></i></button>
                        <?php endif; ?>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach ?>
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

    $("#mainPegawaiNav").addClass('active');
    $("#managePegawaiNav").addClass('active');
  });


  // remove functions 
  function removeFunc(id) {
    Swal.fire({
      title: 'Yakin Ingin Menghapus?',
      text: "Hilangkan Data Pegawai, Namun Absensi Tetap Tercatat!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus !'
    }).then((result) => {
      if (result.isConfirmed) {
        var url = "<?php echo base_url('Pegawai/remove') ?>";
        $.ajax({
          url: url,
          type: "post",
          data: {
            id: id
          },
          success: function(response) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Berhasil Terhapus',
              showConfirmButton: false,
              timer: 1500
            })
            setTimeout(function() { // wait for 5 secs(2)
              location.reload(); // then reload the page.(3)
            }, 1500);
          }
        });

      }
    })
  }
</script>