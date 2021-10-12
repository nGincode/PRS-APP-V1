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
      Edit Data Barang
      <small>Stock</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Stock</li>
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
            <h3 class="box-title"><b><i class="fa fa-book"></i> Edit Data Barang</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('stock/databarangedit') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Masukkan Nama Produk" value="<?php echo $data['nama_produk']; ?>" autocomplete="off" />
              </div>


              <div class="form-group">
                <label for="Bagian">Bagian</label><br>

                <select name="bagian" class="form-control">
                  <option value="1" <?php if ($data['bagian'] == 1) {
                                      echo "selected";
                                    } ?>>Bar & Kasir</option>
                  <option value="2" <?php if ($data['bagian'] == 2) {
                                      echo "selected";
                                    } ?>>Waiter</option>
                  <option value="3" <?php if ($data['bagian'] == 3) {
                                      echo "selected";
                                    } ?>>Dapur</option>
                </select>
              </div>



              <div class="form-group">
                <label for="satuan">Satuan</label><br>

                <select name="satuan" class="form-control">
                  <option value="Pcs" <?php if ($data['satuan'] == 'Pcs') {
                                        echo "selected";
                                      } ?>>Pcs</option>
                  <option value="Pck" <?php if ($data['satuan'] == 'Pck') {
                                        echo "selected";
                                      } ?>>Pck</option>
                  <option value="Klg" <?php if ($data['satuan'] == 'Klg') {
                                        echo "selected";
                                      } ?>>Klg</option>
                  <option value="Kg" <?php if ($data['satuan'] == 'Kg') {
                                        echo "selected";
                                      } ?>>Kg</option>
                  <option value="Gr" <?php if ($data['satuan'] == 'Gr') {
                                        echo "selected";
                                      } ?>>Gr</option>
                  <option value="Jrg" <?php if ($data['satuan'] == 'Jrg') {
                                        echo "selected";
                                      } ?>>Jrg</option>
                  <option value="Dus" <?php if ($data['satuan'] == 'Dus') {
                                        echo "selected";
                                      } ?>>Dus</option>
                  <option value="Btl" <?php if ($data['satuan'] == 'Btl') {
                                        echo "selected";
                                      } ?>>Btl</option>
                  <option value="Box" <?php if ($data['satuan'] == 'Box') {
                                        echo "selected";
                                      } ?>>Box</option>
                  <option value="Bks" <?php if ($data['satuan'] == 'Bks') {
                                        echo "selected";
                                      } ?>>Bks</option>
                  <option value="Btr" <?php if ($data['satuan'] == 'Btr') {
                                        echo "selected";
                                      } ?>>Btr</option>
                  <option value="Por" <?php if ($data['satuan'] == 'Por') {
                                        echo "selected";
                                      } ?>>Porsi</option>
                </select>
              </div>


              <div class="form-group">
                <label for="kategori">Category</label><br>

                <select name="kategori" class="form-control">
                  <option value="1" <?php if ($data['kategori'] == 1) {
                                      echo "selected";
                                    } ?>>Bahan Baku</option>
                  <option value="2" <?php if ($data['kategori'] == 2) {
                                      echo "selected";
                                    } ?>>Supply</option>
                  <option value="3" <?php if ($data['kategori'] == 3) {
                                      echo "selected";
                                    } ?>>Perlengkapan</option>
                </select>
              </div>
              <div class="form-group">
                <label for="harga">Harga Produk</label>
                <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan Harga Produk" value="<?php echo $data['harga']; ?>" autocomplete="off" />
              </div>



            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Simpan</button>
            </div>
          </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->









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
    $("#mainstockNav").addClass('active');
    $("#addstocknbNav").addClass('active');



  });
</script>