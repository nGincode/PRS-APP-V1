<div class="box" style="overflow: auto;">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="vertical-align : middle;text-align:center;" rowspan="2">No</th>
        <th style="text-align: center;" colspan="3">Data Barang</th>
        <th style="vertical-align : middle;text-align:center;" rowspan="2">Awal</th>
        <th style="vertical-align : middle;text-align:center;" rowspan="2">Masuk</th>
        <th style="vertical-align : middle;text-align:center;" rowspan="2">Sisa</th>
        <th style="vertical-align : middle;text-align:center;" rowspan="2">Terpakai</th>
        <th style="text-align: center;" colspan="2">Register</th>
        <th style="vertical-align : middle;text-align:center;" rowspan="2">Ket</th>
      </tr>
      </tr>
      <tr>
        <th style="min-width: 80px;text-align: center;">Tanggal</th>
        <th style="text-align: center;">Nama Produk</th>
        <th style="min-width: 100px;text-align: center;">Rp/UOM</th>
        <th style="min-width: 50px;text-align: center;">Reg</th>
        <th style="min-width: 50px;text-align: center;">Status</th>
      </tr>
    </thead>
    <?php
    $no = 1;
    foreach ($data as $key => $value) {

      $produk_id = $value['produk_id'];
      $stock = $this->model_stock->getnamastockid($produk_id);
      $nama_produk = $stock['nama_produk'];

      if ($value['status'] > 0) {
        $status = '+' . $value['status'];
      } elseif ($value['status'] < 0) {
        $status = $value['status'];
      } elseif ($value['status'] == 0) {
        $status = $value['status'];
      }

      echo '<tr>';
      echo '<td>' . $no . '</td>';
      echo '<td>' . $value['tgl']    . '</td>';
      echo '<td>' . $nama_produk    . '</td>';
      echo '<td>' . $value['harga'] . '/' . $value['uom']  . '</td>';
      echo '<td>' . $value['a_unit'] . '</td>';
      echo '<td>' . $value['t_unit'] . '</td>';
      echo '<td>' . $value['s_unit'] . '</td>';
      echo '<td>' . $value['unit'] . '</td>';
      echo '<td>' . $value['reg'] . '</td>';
      echo '<td>' . $status  . '</td>';
      echo '<td>' . $value['ket']    . '</td>';
      echo '</tr>';

      $no++;
    } ?>
  </table>
</div>
<!-- /.box-body -->