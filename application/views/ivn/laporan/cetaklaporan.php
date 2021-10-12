<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>PRS System | LAPORAN INVENTARIS <?php echo $store?></title>
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
            <h3 class="box-title" style="width: 100%;"><center><font style="font-size: x-large;font-weight: 700;">CV. Prima Rasa Selaras</font></center><hr> <br><B>LAPORAN INVENTARIS <?php echo $store?></B><br>

</h3>
<?php 
echo $judul;
?>
</center>
          </div>


          <!-- /.box-header -->
          <div class="box-body">
            <font style="font-size: 15px;"><b>1). Jumlah Barang Sekarang</b></font>
            <table id="manageTable" class="table table-bordered table-striped">

  <tr>
            	<th>No</th>
                <th>NAMA BARANG</th>
                <th>DIVISI</th>
                <th>HARGA</th>
                <th>JUMLAH</th>
                <th>TOTAL</th>
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
</tr>

<?php
        } // /foreach

$jumlahnya = array_sum($jumlahivn);
?>


  <tr style="background-color: #ffcc7352;">
    <td  colspan="5"><b>Total</b></td>
    <td><?php echo  "Rp " . number_format($jumlahnya,0,',','.'); ?></td>
  </tr>
            </table>
            <br>

<font style="font-size: 15px;"><b>2). Barang Rusak/Hilang</b></font>
<table id="manageTable" class="table table-bordered table-striped">

  <tr>
              <th>No</th>
                <th>NAMA BARANG</th>
                <th>DIVISI</th>
                <th>HARGA</th>
                <th>JUMLAH</th>
                <th>TOTAL</th>
              </tr>
<?php
if(!empty($rusak)){
        $no=0;
        foreach ($rusak as $key => $value) {
          $jumlahrusak[] = $value['harga']*$value['jumlah'];


        $no++;

?>
 <tr>
<td><?php echo $no ?></td>
<td><?php echo $value['nama'] ?></td>
<td><?php echo $value['bagian'] ?></td>
<td><?php echo  "Rp " . number_format($value['harga'],0,',','.'); ?></td>
<td><?php echo $value['jumlah'] ?></td>
<td><?php echo  "Rp " . number_format($value['jumlah']*$value['harga'],0,',','.'); ?></td>
</tr>

<?php
        } // /foreach

$jrusak = array_sum($jumlahrusak);
?>


  <tr style="background-color: #ffcc7352;">
    <td  colspan="5"><b>Total</b></td>
    <td><?php echo  "Rp " . number_format($jrusak,0,',','.'); ?></td>
  </tr>
  <?php
}else{
  echo '<tr style="background-color: #ffcc7352;">
    <td  colspan="6"><center><b>Data Tidak Ditemukan</b></center></td>
  </tr>';
};
   ?>

            </table>

<br>

<font style="font-size: 15px;"><b>3). Barang Masuk</b></font>
<table id="manageTable" class="table table-bordered table-striped">

  <tr>
              <th>No</th>
                <th>NAMA BARANG</th>
                <th>DIVISI</th>
                <th>HARGA</th>
                <th>JUMLAH</th>
                <th>TOTAL</th>
              </tr>
<?php
if(!empty($masuk)){
        $no=0;
        foreach ($masuk as $key => $value) {
          $jumlahmasuk[] = $value['harga']*$value['jumlah'];


        $no++;

?>
 <tr>
<td><?php echo $no ?></td>
<td><?php echo $value['nama'] ?></td>
<td><?php echo $value['bagian'] ?></td>
<td><?php echo  "Rp " . number_format($value['harga'],0,',','.'); ?></td>
<td><?php echo $value['jumlah'] ?></td>
<td><?php echo  "Rp " . number_format($value['jumlah']*$value['harga'],0,',','.'); ?></td>
</tr>

<?php
        } // /foreach

$jmasuk = array_sum($jumlahmasuk);
?>


  <tr style="background-color: #ffcc7352;">
    <td  colspan="5"><b>Total</b></td>
    <td><?php echo  "Rp " . number_format($jmasuk,0,',','.'); ?></td>
  </tr>
  <?php
}else{
  echo '<tr style="background-color: #ffcc7352;">
    <td  colspan="6"><center><b>Data Tidak Ditemukan</b></center></td>
  </tr>';
};
   ?>
            </table>

            <br>

<font style="font-size: 15px;"><b>4). Barang Baru</b></font>
<table id="manageTable" class="table table-bordered table-striped">

  <tr>
              <th>No</th>
                <th>NAMA BARANG</th>
                <th>DIVISI</th>
                <th>HARGA</th>
                <th>JUMLAH</th>
                <th>TOTAL</th>
              </tr>
<?php
if(!empty($baru)){
        $no=0;
        foreach ($baru as $key => $value) {
          $jumlahbaru[] = $value['harga']*$value['jumlah'];


        $no++;

?>
 <tr>
<td><?php echo $no ?></td>
<td><?php echo $value['nama'] ?></td>
<td><?php echo $value['bagian'] ?></td>
<td><?php echo  "Rp " . number_format($value['harga'],0,',','.'); ?></td>
<td><?php echo $value['jumlah'] ?></td>
<td><?php echo  "Rp " . number_format($value['jumlah']*$value['harga'],0,',','.'); ?></td>
</tr>

<?php
        } // /foreach

$jbaru = array_sum($jumlahbaru);
?>


  <tr style="background-color: #ffcc7352;">
    <td  colspan="5"><b>Total</b></td>
    <td><?php echo  "Rp " . number_format($jbaru,0,',','.'); ?></td>
  </tr>
  <?php
}else{
  echo '<tr style="background-color: #ffcc7352;">
    <td  colspan="6"><center><b>Data Tidak Ditemukan</b></center></td>
  </tr>';
};
   ?>
            </table>

            <br>

<font style="font-size: 15px;"><b>5). Barang Keluar</b></font>
<table id="manageTable" class="table table-bordered table-striped">

  <tr>
              <th>No</th>
                <th>NAMA BARANG</th>
                <th>DIVISI</th>
                <th>HARGA</th>
                <th>JUMLAH</th>
                <th>TOTAL</th>
              </tr>
<?php
if(!empty($keluar)){
        $no=0;
        foreach ($keluar as $key => $value) {
          $jumlahkeluar[] = $value['harga']*$value['jumlah'];


        $no++;

?>
 <tr>
<td><?php echo $no ?></td>
<td><?php echo $value['nama'] ?></td>
<td><?php echo $value['bagian'] ?></td>
<td><?php echo  "Rp " . number_format($value['harga'],0,',','.'); ?></td>
<td><?php echo $value['jumlah'] ?></td>
<td><?php echo  "Rp " . number_format($value['jumlah']*$value['harga'],0,',','.'); ?></td>
</tr>

<?php
        } // /foreach

$jkeluar = array_sum($jumlahkeluar);
?>


  <tr style="background-color: #ffcc7352;">
    <td  colspan="5"><b>Total</b></td>
    <td><?php echo  "Rp " . number_format($jkeluar,0,',','.'); ?></td>
  </tr>
  <?php
}else{
  echo '<tr style="background-color: #ffcc7352;">
    <td  colspan="6"><center><b>Data Tidak Ditemukan</b></center></td>
  </tr>';
};
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
      Audit <br>Divisi III<br><br><br><br>Fembi Nur Ilham
    </div>
  </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
		</body>
	</html>
