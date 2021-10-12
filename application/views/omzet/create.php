

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

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Omzet</h3>
            </div>
            <form role="form" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>


                <div class="form-group">
                  <label for="nama">Outlet</label>
                  <input type="text" class="form-control" name="store" readonly value="<?php echo $this->session->userdata('store'); ?>" autocomplete="off">
                </div>

               <div class="form-group">
                  <label for="lahir">Tanggal</label>
                  <input type="date" class="form-control" name="tgl" value="<?php echo $this->session->userdata('store'); ?>" required autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="pemasukan">Pemasukan</label>
                  <input type="number" class="form-control" required="" name="pemasukan" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="masuk_kerja">Pengeluaran</label>
                  <input type="number" class="form-control" name="pengeluaran" required autocomplete="off">
                </div>


                <div class="form-group">
                  <label for="pettycash">Petty Cash</label>
                  <input type="number" class="form-control" name="pettycash" required  autocomplete="off">
                </div>



                <!--
                <div class="form-group">
                  <label for="gop">GOP</label>
                  <input type="number" class="form-control" required="" name="gop" autocomplete="off">
                </div>
              -->


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>
                <a href="<?php echo base_url('pegawai/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
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

    $("#mainOmzetNav").addClass('active');
    $("#addOmzetNav").addClass('active');
  
  });
</script>
