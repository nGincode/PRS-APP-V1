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

            <h3 class="box-title" style="width: 100%;"><center><img src="https://wellthefood.com/wp-content/uploads/2020/08/prs.png" width="200"><br><font style="font-size: x-large;font-weight: 700;">CV. Prima Rasa Selaras</font></center><hr> <br>Laporan Masuk Stock Produk

</h3>
<?php 
echo $title;
?>
          </div>


          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">

  <tr>
            	<th>No</th>
               <th>Tanggal</th>
                <th>SKU</th>
                <th>Nama Produk</th>
                <th>Qty Sebelumnya</th>
                <th>Qty Masuk</th>
                <th>Qty Total</th>
                <th>Harga</th>
                <th>Total Harga</th>
              </tr>

              <?php

        $no=0;

     foreach ($hasil as $row) {




            $uang=$row->price;
            $harga=number_format("$uang", 0, ",", ".");

            $angka=$row->price*$row->qtytotal;
            $hargatotal=number_format("$angka", 0, ",", ".");



        $no++;
         ?>

<tr>
<td><?php echo $no ?></td>
<td><?php echo $row->tgl_bmasuk; ?></td>
<td><?php echo $row->sku; ?></td>
<td><?php echo $row->name; ?></td>
<td><?php echo $row->qtysblm; ?>/<?php echo $row->satuan; ?></td>
<td><?php echo $row->qtymasuk ?>/<?php echo $row->satuan; ?></td>
<td><?php echo $row->qtytotal; ?>/<?php echo $row->satuan; ?></td>
<td>Rp. <?php echo $harga ?></td>
<td>Rp. <?php echo $hargatotal ?></td>
</tr>

         <?php
       }
      
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
