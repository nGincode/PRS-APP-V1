<!DOCTYPE html>
<html>
<head>
</head>
<body>

	<?php

$store = $this->session->userdata['store'];

$filename = "Laporan_Inventaris_".$store."_".$m."_".$y.".xls";
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Pragma: no-cache');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Description: File Transfer');

	?>

		<h1>Data Inventaris <?php echo $store;?> <?php echo $m;?> <?php
		echo $y;?></h1>

	<table border="1">
		<tr>
			<th>No</th>
			<th>Bulan</th>
			<th>Nama Inventaris</th>
			<th>Bagian</th>
			<th>Jumlah</th>
			<th>Tahun</th>
		</tr>
		<?php 
		$no = 1;

		foreach ($data as $key => $d) {
			 $bln=$d['bulan'];
            if($bln == 1){
                $bulan='Januari';
            }elseif($bln == 2){
                $bulan='Februari';
            }elseif($bln == 3){
                $bulan='Maret';
            }elseif($bln == 4){
                $bulan='April';
            }elseif($bln == 5){
                $bulan=' Mei';
            }elseif($bln == 6){
                $bulan='Juni';
            }elseif($bln == 7){
                $bulan='Juli';
            }elseif($bln == 8){
                $bulan='Agustus';
            }elseif($bln == 9){
                $bulan='September';
            }elseif($bln == 10){
                $bulan='Oktober';
            }elseif($bln == 11){
                $bulan='November';
            }elseif($bln == 12){
                $bulan='Desember';
            }
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $bulan; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td><?php echo $d['bagian']; ?></td>
			<td><?php echo $d['jumlah']; ?></td>
			<td><?php echo $d['tahun']; ?></td>
		</tr>
		<?php 
		}
		?>
	</table>
</body>
</html>