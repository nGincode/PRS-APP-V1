<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>
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
            <h3 class="box-title"><i class="fa fa fa-th"></i> <b> Edit Barang "<?php echo $product_data['name']; ?>"</b></h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>

          <!-- /.box-header -->
          <div class="box-body">
            <form role="form" action="<?php base_url('products/update') ?>" method="post" enctype="multipart/form-data">


              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label>Gambar: </label>
                <?php if ($product_data['image']) : ?>
                  <img src="<?php echo base_url() . $product_data['image'] ?>" width="150" height="150" class="img-circle">
                <?php else : ?>
                  <br>
                  <font color="red">Gambar Tidak Diupload</font>
                <?php endif; ?>
              </div>

              <div class="form-group">
                <label for="product_image">Update Gambar</label>
                <div class="kv-avatar">
                  <div class="file-loading">
                    <input id="product_image" name="product_image" type="file">
                  </div>
                </div>
              </div>Pastikan gambar yang dipilih muncul jika ingin ubah gambar<br><br>
              <div class="form-group">
                <label for="product_name">Nama Produk</label>
                <input type="text" class="form-control" id="product_name" required="" name="product_name" placeholder="Masukkan Nama Produk" value="<?php echo $product_data['name']; ?>" autocomplete="off" />
                <input type="hidden" class="form-control" id="tgl_input" name="tgl_input" autocomplete="off" value="<?php
                                                                                                                    echo date('Y-m-d'); ?>" />
              </div>

              <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" class="form-control" id="sku" name="sku" required="" placeholder="Masukkan Kode Barang" value="<?php echo $product_data['sku']; ?>" autocomplete="off" />
              </div>

              <div class="form-group">
                <label for="price">Harga</label>
                <input type="text" class="form-control" id="price" name="price" required="" placeholder="Masukkan Harga" value="<?php echo $product_data['price']; ?>" autocomplete="off" />
              </div>

              <div class="form-group">
                <label for="qty">Qty</label>
                <input type="number" step="any" class="form-control" id="qty" name="qty" required="" placeholder="Masukkan Qty" value="<?php echo $product_data['qty']; ?>" autocomplete="off" />
              </div>

              <div class="form-group">
                <label for="hpp">HPP</label>
                <input type="number" step="any" class="form-control" id="hpp" name="hpp" placeholder="Harga Pokok Penjualan" value="<?php echo $product_data['hpp']; ?>" autocomplete="off" />
              </div>

              <div class="form-group">
                <label for="ke">Penampilan</label><br>
                <?php
                foreach ($store as $key => $value) {
                  echo '<input type="checkbox" name="ke[]" value="' . $value['id'] . '" ';
                  $datake = explode(',', $product_data['ke']);
                  if (in_array($value['id'], $datake)) {
                    echo "checked=''";
                  };
                  echo '>&nbsp;' . $value['name'] . '&nbsp;&nbsp;&nbsp;';
                }
                ?>
              </div>

              <div class="form-group">

                <label for="satuan">Satuan (<?php echo $product_data['satuan']; ?>)</label>
                <select class="form-control" name="satuan">
                  <option value="Pcs" <?php if ($product_data['satuan'] == 'Pcs') {
                                        echo "checked='' ";
                                      } ?>>Pcs</option>
                  <option value="Kg" <?php if ($product_data['satuan'] == 'Kg') {
                                        echo "selected=''";
                                      } ?>>Kg</option>
                  <option value="Pck" <?php if ($product_data['satuan'] == 'Pck') {
                                        echo "selected=''";
                                      } ?>>Pck</option>
                  <option value="Dus" <?php if ($product_data['satuan'] == 'Dus') {
                                        echo "selected=''";
                                      } ?>>Dus</option>
                  <option value="Box" <?php if ($product_data['satuan'] == 'Box') {
                                        echo "selected=''";
                                      } ?>>Box</option>
                  <option value="Bks" <?php if ($product_data['satuan'] == 'Bks') {
                                        echo "selected=''";
                                      } ?>>Bks</option>
                  <option value="Btr" <?php if ($product_data['satuan'] == 'Btr') {
                                        echo "selected=''";
                                      } ?>>Btr</option>
                  <option value="Tbg" <?php if ($product_data['satuan'] == 'Tbg') {
                                        echo "selected=''";
                                      } ?>>Tbg</option>
                  <option value="Ikt" <?php if ($product_data['satuan'] == 'Ikt') {
                                        echo "selected=''";
                                      } ?>>Ikt</option>
                  <option value="Bal" <?php if ($product_data['satuan'] == 'Bal') {
                                        echo "selected=''";
                                      } ?>>Ikt</option>
                  <option value="Sak" <?php if ($product_data['satuan'] == 'Sak') {
                                        echo "selected=''";
                                      } ?>>Ikt</option>
                  <option value="Ctn" <?php if ($product_data['satuan'] == 'Ctn') {
                                        echo "selected=''";
                                      } ?>>Ikt</option>
                </select>

              </div>

              <div class="form-group">
                <label>Kadaluarsa:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" name="kadaluarsa" value="<?php if ($product_data['kadaluarsa']) {
                                                                                      echo date('Y/m/d', strtotime($product_data['kadaluarsa']));
                                                                                    } ?>" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask="">
                </div>
                <!-- /.input group -->
              </div>


              <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter 
                  description" autocomplete="off">
                    <?php echo $product_data['description']; ?>
                  </textarea>
              </div>

              <div class="form-group">
                <label for="store">Ketersediaan</label>
                <select class="form-control" id="availability" name="availability">
                  <option value="1" <?php if ($product_data['availability'] == 1) {
                                      echo "selected='selected'";
                                    } ?>>Ada</option>
                  <option value="2" <?php if ($product_data['availability'] != 1) {
                                      echo "selected='selected'";
                                    } ?>>Tidak</option>
                </select>
              </div>


              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Ubah</button>
                <a href="<?php echo base_url('products/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
              </div>
            </form>
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
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainProductNav").addClass('active');
    $("#manageProductNav").addClass('active');

    var btnCust = '';
    $("#product_image").fileinput({
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



  });

  $(document).ready(function() {
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });
  });


  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy/mm/dd', {
      'placeholder': 'yyyy/mm/dd'
    })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

  })
</script>