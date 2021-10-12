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
      Barang Baru
      <small>Inventaris</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Inventaris</li>
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
            <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Tambah Inventaris</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('ivn/create') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <font style="color: red"><?php echo validation_errors(); ?></font>


              <div class="form-group">

                <input type="hidden" class="form-control" id="tgl_masuk" name="tgl_masuk" autocomplete="off" value="<?php
                                                                                                                    echo date('Y-m-d'); ?>" />

                <label for="ivn_image">Gambar</label>
                <div class="kv-avatar">
                  <div class="file-loading">
                    <input id="ivn_image" name="ivn_image" type="file">
                  </div>
                </div>
              </div>
              <?php

              $user_id = $this->session->userdata('id');
              $div = $this->session->userdata('divisi');

              if ($div == 0) {

                echo ' <div class="form-group">
                <label  for="bagian">Divisi</label>
                <select id="bagian" name="bagian" class="form-control">
                   <option selected="true" disabled="disabled">- PILIH DIVISI -</option>
                   <option value="1" >Bar & Kasir</option>
                   <option value="2">Waiter</option>
                   <option value="3">Dapur</option>
                 </select>
                </div>';
              } elseif ($div == 11) {
                echo ' <div class="form-group">
                <label for="bagian">Divisi</label>
                <select id="bagian" name="bagian" class="form-control">
                   <option selected="true" disabled="disabled">- PILIH DIVISI -</option>
                   <option value="1" >Bar & Kasir</option>
                   <option value="2">Waiter</option>
                   <option value="3">Dapur</option>
                 </select>
                </div>';
              } else {
                if ($div == 1) {
                  $bagian = 'Bar & Kasir';
                } elseif ($div == 2) {
                  $bagian = 'Waiter';
                } elseif ($div == 3) {
                  $bagian = 'Kitchen';
                };
                echo ' <div class="form-group">
                <label for="bagian">Divisi</label>
                <select id="bagian" name="bagian" class="form-control">
                   <option value="' . $div . '" >' . $bagian . '</option>
                 </select>
                </div>';
              }
              ?>




              <?php $date = date('m');
              $b = ltrim($date, '0'); ?>
              <div class="form-group">
                <label for="bulan">Bulan</label>
                <select class="form-control select_group" id="bulan" name="bulan">
                  <option value="1" <?php if ($b == 1) {
                                      echo 'selected="selected"';
                                    } ?>>Januari</option>
                  <option value="2" <?php if ($b == 2) {
                                      echo 'selected="selected"';
                                    } ?>>Februari</option>
                  <option value="3" <?php if ($b == 3) {
                                      echo 'selected="selected"';
                                    } ?>>Maret</option>
                  <option value="4" <?php if ($b == 4) {
                                      echo 'selected="selected"';
                                    } ?>>April</option>
                  <option value="5" <?php if ($b == 5) {
                                      echo 'selected="selected"';
                                    } ?>>Mei</option>
                  <option value="6" <?php if ($b == 6) {
                                      echo 'selected="selected"';
                                    } ?>>Juni</option>
                  <option value="7" <?php if ($b == 7) {
                                      echo 'selected="selected"';
                                    } ?>>Juli</option>
                  <option value="8" <?php if ($b == 8) {
                                      echo 'selected="selected"';
                                    } ?>>Agustus</option>
                  <option value="9" <?php if ($b == 9) {
                                      echo 'selected="selected"';
                                    } ?>>September</option>
                  <option value="10" <?php if ($b == 10) {
                                        echo 'selected="selected"';
                                      } ?>>Oktober</option>
                  <option value="11" <?php if ($b == 11) {
                                        echo 'selected="selected"';
                                      } ?>>November</option>
                  <option value="12" <?php if ($b == 12) {
                                        echo 'selected="selected"';
                                      } ?>>Desember</option>
                </select>
              </div>

              <div class="form-group">
                <label for="tahun">Tahun</label>
                <select class="form-control select_group" id="tahun" name="tahun">
                  <option value="<?= date('Y') ?>" selected="selected"><?= date('Y') ?></option>
                </select>
              </div>

              <div class="form-group">
                <label for="nama">Nama Inventaris</label>
                <input type="text" class="form-control" id="nama" required name="nama" placeholder="Masukkan Nama Inventaris" autocomplete="off" />
              </div>


              <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" required name="harga" placeholder="Harga Inventaris" autocomplete="off" />
              </div>

              <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" required name="jumlah" placeholder="Jumlah Barang" autocomplete="off" />
              </div>


            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
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


  <section class="content">


    <br /> <br />


    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Data Inventaris Baru</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body" id='penyesuaian'>
        <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Nama</th>
              <th>Bagian</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th>Total</th>
            </tr>
          </thead>

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
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {

    $("#mainivnNav").addClass('active');
    $("#addivnNav").addClass('active');

    var btnCust = '';
    $("#ivn_image").fileinput({
      overwriteInitial: true,
      maxFileSize: 5000,
      showClose: false,
      showCaption: false,
      browseLabel: '',
      removeLabel: '',
      browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
      removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
      removeTitle: 'Cancel or reset changes',
      elErrorContainer: '#kv-avatar-errors-1',
      msgErrorClass: 'alert alert-block alert-danger',
      // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
      layoutTemplates: {
        main2: '{preview} ' + btnCust + ' {remove} {browse}'
      },
      allowedFileExtensions: ["jpg", "png", "gif"]
    });



    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'ivn/fetchivnDatainput',
      'order': []
    });

  });
</script>