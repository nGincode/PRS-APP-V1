

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Pelaporan</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pelaporan</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>


        <?php if($this->session->flashdata('success')):

echo "<script> Swal.fire({
              icon: 'success',
              title: 'Berhasil...!',
              text: '".$this->session->flashdata('success')."',
              showConfirmButton: false,
              timer: 4000
            });
</script>";

         ?>
            
        <?php elseif($this->session->flashdata('error')):
echo "<script> Swal.fire({
              icon: 'error',
              title: 'Maaf...!',
              text: '".$this->session->flashdata('error')."',
              showConfirmButton: false,
              timer: 4000
            });
</script>";

         ?>

            
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Edit</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('pelaporan/update') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>



                <div class="form-group">
                  <label for="outlet">Outlet</label>
                  <input type="text" disabled class="form-control" id="outlet" name="outlet"  value="<?php echo $pelaporan_data['store']; ?>"  autocomplete="off"/>
                </div>

                <div class="form-group">
                  <label for="tgl_input">Tanggal Pengajuan</label>
                  <input type="text" disabled class="form-control" id="tgl_input" name="tgl_input" value="<?php echo $pelaporan_data['tgl_input']; ?>"  autocomplete="off"/>
                </div>


                <div class="form-group">
                  <label for="nama">Nama pelaporan</label>
                  <input type="text" disabled class="form-control" id="nama" name="nama" value="<?php echo $pelaporan_data['nama']; ?>"  autocomplete="off"/>
                </div>


                <div class="form-group">
                  <label for="ket">Keterangan</label>
                  <input type="text" disabled class="form-control" id="ket" name="ket"  value="<?php echo $pelaporan_data['ket']; ?>"  autocomplete="off"/>
                </div>



                <div class="form-group">
  <label>Status Pelaporan</label><br>
<div class="btn-group" data-toggle="buttons">
  <label for="status" class="btn btn-primary <?php if($pelaporan_data["status"]== 2){echo "active";}?>" >
    <input type="radio" name="status" id="status" value="2"> Terima
  </label>
  <label for="status" class="btn btn-primary <?php if($pelaporan_data["status"]== 0){echo "active";}?>">
    <input type="radio" name="status" id="status" value="0"> Proses
  </label>
  <label for="status" class="btn btn-primary <?php if($pelaporan_data["status"]== 1){echo "active";}?>" >
    <input type="radio" name="status" id="status" value="1"> Tolak
  </label>
</div>
</div>
</div>


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo base_url('pelaporan/') ?>" class="btn btn-warning">Batal</a>
              </div>
            </form>
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
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainpelaporanNav").addClass('active');
    $("#managepelaporanNav").addClass('active');

  });
</script>