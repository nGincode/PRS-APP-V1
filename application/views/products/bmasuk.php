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
        <div class="box box-primary">
          <div class="box-header with-border">
            <i class="fa fa-th"></i>

            <h3 class="box-title">Barang Masuk</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <!-- /.box-header -->
          <form role="form" action="<?php base_url('products/bmasuk') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>
              <table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
                <thead>
                  <th style="width:70%;min-width:200px;text-align: center;">Produk</th>
                  <th style="width:30%;min-width:100px;text-align: center;">Qty</th>
                  <th style="width:5%;text-align: center;"><i class="fa fa-sign-in"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <select class="form-control select_group product" id="product_name" name="product_name" style="width:100%;" required>
                        <option value="">Pilih Produk</option>
                        <?php foreach ($products as $k => $v) : ?>
                          <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] . ' (' . $v['satuan'] . ')' ?></option>
                        <?php endforeach ?>
                      </select>
                    </td>

                    <td>
                      <input type="number" step="any" required name="qty" id="qty" class="form-control" placeholder="Qty" autocomplete="off">
                    </td>
                    <td>
                      <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
          </form>




          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <br />


      <div class="box  box-solid">
        <div class="box-header">
          <h3 class="box-title">Stock Masuk</h3>
        </div>


        <!-- /.box-header -->
        <div class="box-body" id='penyesuaian'>
          <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>SKU</th>
                <th>Nama</th>
                <th>Qty After</th>
                <th>Qty Masuk</th>
                <th>Qty Total</th>
                <th>Harga</th>
                <th>Jumlah</th>
              </tr>
            </thead>

          </table>
        </div>
        <!-- /.box-body -->

      </div>
      <br />
      <!--
      <form action="<?php echo site_url('products/cetaklaporanbmasuk') ?>" method="post">
        <center><label style="font-size: 30px">Cetak Laporan Stock Masuk</label></center><br>
        <label>Dari : </label><br><input type="date" name="tgl_awal" class="form-control" required=""><br>
        <label>Sampai : </label><br><input type="date" name="tgl_akhir" class="form-control" required=""><br><br>
        <center><button class="btn btn-success" name=tgl type="submit"><i class="fa fa-print"></i> Cetak</button></center>
      </form>
                        -->
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
    $("#ProductmasukNav").addClass('active');



    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'products/laporanstockmasuk',
      'order': []
    });

  });
</script>