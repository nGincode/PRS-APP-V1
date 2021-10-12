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
            <center><img src="https://wellthefood.com/wp-content/uploads/2020/08/prs.png" width="200">
            <h3 class="box-title" style="width: 100%;"><center><font style="font-size: x-large;font-weight: 700;">CV. Prima Rasa Selaras</font></center><hr> <br><B>SELURUH PELAPORAN</B><br>

</h3>
</center>
          </div>


          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">

  <tr>
              <th>No</th>
                <th>Tanggal Pengajuan </th>
                <th>Store</th>
                <th>Judul Pelaporan</th>
                <th>Keterangan </th>
                <th>Status </th>
              </tr>
<?php
        $no=0;
        $data = $this->model_pelaporan->getpelaporanseluruh();

        foreach ($data as $key => $value) {

        $no++;
        
            $status=$value['status'];
           if ($status == 0){
               $sts= '<span class="label label-warning">Proses</span>';
           }elseif ($status == 1) {
               $sts= '<span class="label label-danger">Ditolak</span>';
           }elseif ($status == 2) {
               $sts= '<span class="label label-success">Diterima</span>';
           }

?>
 <tr>
<td><?php echo $no ?></td>
<td><?php echo $value['tgl_input'] ?></td>
<td><?php echo $value['store'] ?></td>
<td><?php echo $value['nama'] ?></td>
<td><?php echo $value['ket'] ?></td>
<td><?php echo $sts ?></td>
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
    <div style=" text-align: center; width: 100%;">
    <div style="
    float: left;
    text-align: center;
    width: 200px;
    margin-left: 40px;
">
      
    </div>
     <div style="
     float: right;
    text-align: center;
    width: 200px;
    margin-right: 50px;
">
       <br>Divisi III<br><br><br><br>Fembi Nur Ilham
    </div>
  </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
		</body>
	</html>
