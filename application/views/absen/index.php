

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Absensi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Absen</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>



          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Manage Absensi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow: auto;">
              <table id="userTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Alasan Absen Pagi Kosong/terlambat</th>
                  <th>Alasan Absen Sore Kosong/lebih awal</th>
                  <th>Izin Tidak Masuk Kerja</th>
                  <th>Waktu</th>

                  <?php if(in_array('updateabsen', $user_permission) || in_array('deleteabsen', $user_permission)): ?>
                  <th style="min-width: 150px;">Action</th>
                  <?php endif; ?>
                </tr>
                </thead>
                <tbody>            
                    <?php $no =1; foreach ($absen_data as $k => $v): ?>
                      <tr>
                        <td><?php echo $v['tgl']; ?></td>
                        <td><?php echo $v['nama']; ?></td>
                        <td><?php echo $v['pagi']; ?></td>
                        <td><?php echo $v['sore']; ?></td>
                        <td><?php echo $v['izin']; ?></td>
                        <td><?php echo $v['waktu']; ?></td>

                        <?php if(in_array('updateabsen', $user_permission) || in_array('deleteabsen', $user_permission) || in_array('viewabsen', $user_permission)): ?>
                        <td>
                          <?php if(in_array('deleteabsen', $user_permission)): ?>
                             <button type="button" class="btn btn-default" onclick="removeFunc(<?php echo $v['id'] ?>)" ><i class="fa fa-trash"></i></button>
                          <?php endif; ?>
                        </td>
                      <?php endif; ?>
                      </tr>
                    <?php $no++; endforeach ?>
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

      $("#mainabsenNav").addClass('active');
      $("#manageabsenNav").addClass('active');
    });


// remove functions 
function removeFunc(id)
{
Swal.fire({
  title: 'Yakin Ingin Menghapus?',
  text: "Data akan hilang selamanya !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Hapus'
}).then((result) => {
  if (result.isConfirmed) {
      var url = "<?php echo base_url('absen/remove') ?>";
     $.ajax({
        url: url,
        type: "post",
        data: { id:id }, 
        success:function(response) {
          Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Berhasil Terhapus',
          showConfirmButton: false,
          timer: 1500
          })
           setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 1500); 
        }
      });

  }
})
}

  </script>
