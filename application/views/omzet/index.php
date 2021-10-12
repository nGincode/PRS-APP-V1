

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Omzet</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Omzet</li>
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
          
          <?php if(in_array('createUser', $user_permission)): ?>
            <a href="<?php echo base_url('users/create') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah User</a>
            <br /> <br />
          <?php endif; ?>


          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Manage Omzet</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow: auto;">
              <table id="userTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Outlet</th>
                  <th>Pengeluaran</th>
                  <th>Petty Cash</th>
                  <th>Pemasukan</th>
                  <th>GOP</th>

                  <?php if(in_array('updateOmzet', $user_permission) || in_array('deleteOmzet', $user_permission)): ?>
                  <th style="min-width: 150px;">Action</th>
                  <?php endif; ?>
                </tr>
                </thead>
                <tbody>            
                    <?php $no =1; foreach ($omzet_data as $k => $v): ?>
                      <tr>
                        <td><?php echo $v['tgl']; ?></td>
                        <td><?php echo $v['store']; ?></td>
                        <td><?php echo $hasil_rupiah = "Rp " . number_format($v['pengeluaran'],0,',','.'); ?></td>
                        <td><?php echo $hasil_rupiah = "Rp " . number_format($v['pettycash'],0,',','.'); ?></td>
                        <td><?php echo $hasil_rupiah = "Rp " . number_format($v['pemasukkan'],0,',','.'); ?></td>
                        <td><?php  echo $hasil_rupiah = "Rp " . number_format($v['gop'],0,',','.'); ?></td>

                        <?php if(in_array('updateOmzet', $user_permission) || in_array('deleteOmzet', $user_permission) || in_array('viewOmzet', $user_permission)): ?>

                        <td>
                          <?php if(in_array('viewOmzet', $user_permission)): ?>
                            <div style="position: absolute;top: -10000px;"><textarea id="pilih<?php echo $no; ?>">*LAPORAN OMZET*
Hari/tanggal  : <?php echo $v['tgl']; ?>.
Outlet : <?php echo $v['store']; ?>.
Pengeluaran : <?php echo $hasil_rupiah = "Rp " . number_format($v['pengeluaran'],0,',','.'); ?>.
Petty Cash : <?php echo $hasil_rupiah = "Rp " . number_format($v['pettycash'],0,',','.'); ?>.
Pemasukkan : <?php echo $hasil_rupiah = "Rp " . number_format($v['pemasukkan'],0,',','.'); ?>.
GOP : <?php  echo $hasil_rupiah = "Rp " . number_format($v['gop'],0,',','.'); ?>.</textarea></div>
                            <button type="button" onclick="copy_text<?php echo $no; ?>()" title="Copy Laporan" class="btn btn-success"><i class="fa fa-copy"></i></button> 
                          <?php endif; ?>

    <script type="text/javascript">
 function copy_text<?php echo $no; ?>() {
        document.getElementById("pilih<?php echo $no; ?>").select();
        document.execCommand("copy"); 
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Berhasil Tercopy',
          showConfirmButton: false,
          timer: 1500
          });
    }</script>
                          <?php if(in_array('updateOmzet', $user_permission)): ?>
                            <a href="<?php echo base_url('Omzet/edit/'.$v['id']) ?>" class="btn btn-default"><i class="fa fa-edit"></i></a> 
                          <?php endif; ?>

                          <?php if(in_array('deleteOmzet', $user_permission)): ?>
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

      $("#mainOmzetNav").addClass('active');
      $("#manageOmzetNav").addClass('active');
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
  confirmButtonText: 'Hapus !'
}).then((result) => {
  if (result.isConfirmed) {
      var url = "<?php echo base_url('Omzet/remove') ?>";
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
