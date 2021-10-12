

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Absen</small>
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
              <h3 class="box-title">Absen</h3>
            </div>
            <form role="form" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

               <div class="form-group">
                  <label for="lahir">Tanggal</label>
                  <input type="date" class="form-control" name="tgl"  required autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="pemasukan">Nama Karyawan</label>
                  <input type="text" class="form-control" required="" name="nama" placeholder="Nama Karyawan" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="masuk_kerja">Alasan Absen Pagi Kosong/terlambat</label>
                  <input type="text" class="form-control" name="pagi" placeholder="Alasan Absen Pagi" autocomplete="off">
                </div>


                <div class="form-group">
                  <label for="middapro">Absen Middle Dapro Kosong</label>
                  <input type="text" class="form-control" name="middapro" placeholder="Absen Middle Dapro Kosong" autocomplete="off">
                </div>
                
                <div class="form-group">
                  <label for="pettycash">Alasan Absen Sore Kosong/lebih awal</label>
                  <input type="text" class="form-control" name="sore" required placeholder="Alasan Absen Sore"  autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="pettycash">Izin Tidak Masuk Kerja</label>
                  <input type="text" class="form-control" name="izin" required placeholder="Izin"  autocomplete="off">
                </div>


                <div class="form-group">
                  <label for="pettycash">Waktu</label>
                  <input type="text" class="form-control" placeholder="Waktu" name="waktu" required  autocomplete="off">
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>
                <a href="<?php echo base_url('absen/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
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

    $("#mainabsenNav").addClass('active');
    $("#addabsenNav").addClass('active');
  
  });
</script>
