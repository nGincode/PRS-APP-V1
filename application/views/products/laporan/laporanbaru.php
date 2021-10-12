

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
      <li class="active">Products</li>
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



              <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Tambah Barang</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('products/create') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">

                  <label for="product_image">Gambar</label>
                  <div class="kv-avatar">
                      <div class="file-loading">
                          <input id="product_image" name="product_image" type="file">
                      </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="product_name">Nama Produk</label>
                  <input type="text" class="form-control" id="product_name" name="product_name" required="" placeholder="Masukkan Nama Produk" autocomplete="off"/>
                </div>

                <div class="form-group">
                  <label for="sku">SKU</label>
                  <input type="text" class="form-control" id="sku" name="sku" placeholder="Kode Barang" required="" autocomplete="off" />
                </div>

                  <input type="hidden" class="form-control" id="tgl_input" name="tgl_input" autocomplete="off" value="<?php 
echo date('Y-m-d');?>" /> 

                <div class="form-group">
                  <label for="price">Harga</label>
                  <input type="number" class="form-control" id="price" name="price" placeholder="Masukan Harga" required=""  autocomplete="off" />
                </div>

                <div class="form-group">
                  <label for="qty">Qty</label>
                  <input type="number" class="form-control" id="qty" name="qty" placeholder="Masukkan Qty"  autocomplete="off" />
                </div>


                <div class="form-group">
                  <label for="satuan">Satuan</label>
                   <select class="form-control"name="satuan">
                    <option value="Pcs">Pcs</option>
                    <option value="Kg" >Kg</option>
                    <option value="Pck" >Pck</option>
                    <option value="Dus">Dus</option>
                    <option value="Box" >Box</option>
                    <option value="Bks" >Bks</option>
                    <option value="Btr" >Btr</option>
                    <option value="Tbg" >Tbg</option>
                    <option value="Ikt" >Ikt</option>
                  </select>
                </div>

               <div class="form-group">
                  <label for="kadaluarsa">Kadaluarsa</label>
                  <input type="date" class="form-control" id="kadaluarsa" name="kadaluarsa" autocomplete="off" />
                </div>


                <div class="form-group">
                  <label for="description">Keterangan</label>
                  <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter 
                  description" autocomplete="off">
                  </textarea>
                </div>

                <div class="form-group">
                  <label for="store">Ketersedian</label>
                  <select class="form-control" id="availability" name="availability">
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                  </select>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                <a href="<?php echo base_url('products/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    <br />


        <div class="box box-solid">
          <div class="box-header">
            <h3 class="box-title">Produk Terinput</h3>
          </div>


          <!-- /.box-header -->
          <div class="box-body" style="overflow: auto;">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="max-width:100px;">Tanggal</th>
                <th>SKU</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th style="max-width:100px;">Total Harga</th>
              </tr>
              </thead>

            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <br>
<form action="<?php echo site_url('products/cetaklaporanmasuk') ?>" method="post">
      <center><label style="font-size: 30px">Cetak Laporan Barang Masuk</label></center><br>
      <label>Dari : </label><br><input type="date"  name="tgl_awal" class="form-control" required=""><br>
      <label>Sampai : </label><br><input type="date"  name="tgl_akhir" class="form-control" required=""><br><br>
      <center><button class="btn btn-success" name=tgl type="submit"><i class="fa fa-print"></i> Cetak</button></center>
</form>
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
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainProductNav").addClass('active');
    $("#addProductNav").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
    $("#product_image").fileinput({
        overwriteInitial: true,
        maxFileSize: 0,
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
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });


  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'products/laporanmasuk',
    'order': []
  });

  });
</script>