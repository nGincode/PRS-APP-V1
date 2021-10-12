<!DOCTYPE html>
      <html>
      <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Laporan Stock Produk Logistik</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/dist/css/AdminLTE.min.css">
      </head>
      <body onload="window.print();">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title" style="width: 100%;"><center><font style="font-size: x-large;font-weight: 700;">CV. Prima Rasa Selaras</font></center><hr> <br>Laporan Stock Produk Logistik

</h3>
<?php 
echo "Print Tanggal : ".date('d-m-Y');
?>
          </div>


          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">

  <tr>
              <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Qty Tersedia</th>
                <th>Total Harga</th>
              </tr>
<?php
$result = array('data' => array());

        $no=0;
        $data = $this->model_products->getProductData();

        foreach ($data as $key => $value) {


            $uang=$value['price'];
            $harga=number_format("$uang", 0, ",", ".");

            $angka=$value['price']*$value['qty'];
            $hargatotal=number_format("$angka", 0, ",", ".");


        $no++;
?>
 <tr>
<td><?php echo $no ?></td>
<td><?php echo $value['name'] ?></td>
<td>Rp. <?php echo $harga ?> / <?php echo $value['satuan'] ?></td>
<td><?php echo $value['qty'] ?></td>
<td>Rp. <?php echo $hargatotal ?></td>
</tr>

<?php
        } // /foreach
?>
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
    </body>
  </html>
