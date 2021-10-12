<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>PRS System | LAPORAN ASSET <?php echo $store?></title>
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
            <center><img src="https://wellthefood.com/wp-content/uploads/2020/08/prs.png" width="200">
            <h3 class="box-title" style="width: 100%;"><center><font style="font-size: x-large;font-weight: 700;">CV. Prima Rasa Selaras</font></center><hr> <br><B>LAPORAN ASSET <?php echo $store?></B><br>

</h3>
</center>
          </div>


          <!-- /.box-header -->
          <div class="box-body">
            <font style="font-size: 10px;"><b>Diambil Pada <?php echo date('d-m-Y h:s:i') ?></b></font>
            <table id="manageTable" class="table table-bordered table-striped">

  <tr>
            	<th>No</th>
                <th>Nama Barang</th>
                <th>Bagian</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Jangka Waktu</th>
              </tr>
<?php
        $no=0;
        foreach ($ivn as $key => $value) {
          $jumlahivn[] = $value['harga']*$value['jumlah'];

        $no++;

?>
 <tr>
<td><?php echo $no ?></td>
<td><?php echo $value['nama'] ?></td>
<td><?php echo $value['bagian'] ?></td>
<td><?php echo  "Rp " . number_format($value['harga'],0,',','.'); ?></td>
<td><?php echo $value['jumlah'] ?></td>
<td><?php echo  "Rp " . number_format($value['jumlah']*$value['harga'],0,',','.'); ?></td>
<td></td>
</tr>

<?php
        } // /foreach

$jumlahnya = array_sum($jumlahivn);
?>


  <tr style="background-color: #ffcc7352;">
    <td  colspan="5"><b>Total</b></td>
    <td colspan="2"><?php echo  "Rp " . number_format($jumlahnya,0,',','.'); ?></td>
  </tr>
            </table>
            <br>

            </table>


          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    <div style=" text-align: center; width: 100%;">
    <div style="
    float: left;
    text-align: center;
    width: 200px;
    margin-left: 40px;
">
      Manajer <br><?php echo $store?><br><br><br><br><?php echo $nama;?>
    </div>
     <div style="
     float: right;
    text-align: center;
    width: 200px;
    margin-right: 50px;
">
      
    </div>
  </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
		</body>
	</html>
