<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>PRS Inventory System | Invoice</title>
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

            <h3 class="box-title" style="width: 100%;"><center><font style="font-size: x-large;font-weight: 700;">CV. Prima Rasa Selaras</font></center><hr> <br>Laporan Keluar Stock Produk

</h3>
<?php 
echo $title;
?>
          </div>


          <!-- /.box-header -->
          <div class="box-body">


            

              <?php

     foreach ($hasil as $s) {

            $no=0;

            $outlet = $this->model_stores->getStoresData($s['store_id']);

            echo '

            <h4><b>Outlet : '.$outlet['name'].'</b></h4>
            <table id="manageTable" class="table table-bordered table-striped">
              <tr>
              <th><center>No</center></th>
                <th><center>Outlet</center></th>
                <th><center>Tanggal Order</center></th>
                <th><center>Nama Produk</center></th>
                <th><center>Hrg/Satuan</center></th>
                <th><center>Qty</center></th>
                <th><center>Total Harga</center></th>
              </tr>';

            $cetak =$this->model_orders->cetakpertanggal($s['store_id'], $tgl_awal,$tgl_akhir);

            $Jumlah = 0;
            $qty = 0;
            foreach ($cetak as $row) {

            $products = $this->model_products->getProductData($row->product_id);
            $pp=$products['name'];

            $store = $this->model_stores->getStoresData($row->store_id);
            $Jumlah += $row->amount;
            $qty += $row->qtydeliv;
            

            $no++;
         ?>

<tr>
<td><center><?php echo $no ?></center></td>
<td><center><?php echo $store['name']; ?></center></td>
<td><center><?php echo $row->tgl_order; ?></center></td>
<td><?php echo $pp; ?></td>
<td style="text-align: right;">Rp. <?php echo number_format($row->rate,0,',','.').'/'.$row->satuan; ?></td>
<td  style="text-align: right;"><?php echo $row->qtydeliv ?></td>
<td  style="text-align: right;">Rp. <?php echo number_format($row->amount,0,',','.'); ?></td>
</tr>

         <?php
            }
       echo  '<tr style="background-color: #00c0ef38;">
                    <td colspan="5"><b>Jumlah</b></td>
                    <td  style="text-align: right;"s><b>'.$qty.'</b></td>
                    <td  style="text-align: right;"><b>Rp. '.number_format($Jumlah,0,',','.').'</b></td>
                    </tr>
            </table><br><br>';


       }
?>














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
