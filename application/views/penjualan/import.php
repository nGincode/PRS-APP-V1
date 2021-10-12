<?php if ($this->session->flashdata('success')) :
  echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
?>
<?php elseif ($this->session->flashdata('error')) :
  echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
?>
<?php endif; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Upload
      <small>Penjualan</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Penjualan</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>


        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Upload penjualan</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->


          <!-- Option button -->


          <?= form_open_multipart('penjualan/check_import') ?>
          <div class="box-body">
            <input type="file" class="form-control" name="file_import">
          </div>
          <div class="box-footer">
            <input type="submit" class="btn btn-primary" name="preview" value="Upload">
            <a href="<?= base_url() ?>penjualan/dl_format" class="btn btn-success"><i class="fa fa-download" class="btn btn-success"></i> Download Format</a>
          </div>
          </form>

          <!-- /.box-body -->

          <div class="box-body">
            Keterangan : <br>
            <font color='red'>*</font> Perhatian Upload dengan benar pada qty jika tidak benar akan di ubah jadi 0<br>
            <font color='red'>*</font> Data akan di replace ke data yang baru diupload<br>
            <font color='red'>*</font> Untuk melihat data yang terupload bisa kunjungi submenu export<br>

          </div>
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

    $("#mainpenjualanNav").addClass('active');
    $("#addimportNav").addClass('active');

  });
</script>