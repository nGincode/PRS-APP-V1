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
      Manage
      <small>Barang</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Barang</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>


        <div class="box box-danger box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Edit Barang</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('ivn/update') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label>Gambar : </label>
                <?php if ($ivn_data['img']) { ?>
                  <img src="<?php echo base_url() . $ivn_data['img'] ?>" width="150" height="150" class="img-circle">
                <?php } else {
                  echo '<font style="color:red;"> Tidak ada gambar terupload</font>';
                } ?>
              </div>

              <div class="form-group">
                <label for="ivn_image">Update Gambar</label>
                <div class="kv-avatar">
                  <div class="file-loading">
                    <input id="ivn_image" name="ivn_image" type="file">
                  </div>
                </div>
              </div>


              <div class="form-group">
                <label for="bagian">Bagian</label>
                <select class="form-control" id="bagian" name="bagian">
                  <option value="Bar & Kasir" <?php if ($ivn_data['bagian'] == 'Bar & Kasir') {
                                                echo "selected='selected'";
                                              } ?>>Bar & Kasir</option>
                  <option value="Waiters" <?php if ($ivn_data['bagian'] == 'Waiters') {
                                            echo "selected='selected'";
                                          } ?>>Waiters</option>
                  <option value="Dapur" <?php if ($ivn_data['bagian'] == 'Dapur') {
                                          echo "selected='selected'";
                                        } ?>>Dapur</option>
                </select>
              </div>

              <div class="form-group">
                <label for="nama">Nama Inventaris</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Produk" value="<?php echo $ivn_data['nama']; ?>" autocomplete="off" />
              </div>


              <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga Produk" value="<?php echo $ivn_data['harga']; ?>" autocomplete="off" />
              </div>


              <div class="form-group">
                <label for="product_name">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan Nama Produk" value="<?php echo $ivn_data['jumlah']; ?>" autocomplete="off" />
              </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>
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

    $("#mainivnNav").addClass('active');
    $("#manageivnNav").addClass('active');

    var btnCust = '';
    $("#ivn_image").fileinput({
      overwriteInitial: true,
      maxFileSize: 1500,
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

  });
</script>