<br>
<div class="col-md-4 col-xs-12 pull pull-right">
  <div class="form-group">
    <label class="col-sm-5 control-label">Tanggal</label>
    <div class="col-sm-7">
      <input type="date" name="tgl" readonly class="form-control" autocomplete="off" value="<?php echo $tgl ?>" required="">
    </div>
  </div>
</div>
<table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
  <tr>
    <th>No</th>
    <th style="text-align: center;min-width: 200px;">Nama</th>
    <th style="text-align: center;min-width: 30px;">Satuan</th>
    <th style="text-align: center;min-width: 90px;">Awal</th>
    <th style="text-align: center;min-width: 90px;">Masuk</th>
    <th style="text-align: center;min-width: 90px;">Sisa</th>
    <th style="text-align: center;min-width: 90px;background-color: #ff00003b;">Terpakai</th>
    <th style="text-align: center;min-width: 90px;">Register</th>
    <th style="text-align: center;min-width: 90px;">Status</th>
    <th style="text-align: center;min-width: 90px;">Ket</th>
  </tr>
  </thead>
  <tbody>
    <tr>

      <input type="hidden" name="bagian" class="form-control" value="<?php echo $this->input->post('divisi'); ?>" autocomplete="off">

      <?php $no = 1;
      foreach ($data as $k => $v) : ?>
        <script type="text/javascript">
          function pemakaian<?php echo $no; ?>() {
            var hitung = Number($("#reg_<?php echo $no; ?>").val()) - Number($("#unit_value_<?php echo $no; ?>").val());

            total = hitung.toFixed(1);
            if (total > 0) {
              var t = '+';
              var ttl = t.concat(total);
            }
            if (total == 0) {
              var ttl = '0';
            }
            if (total < 0) {
              var ttl = total;
            }
            $("#pemakaian_<?php echo $no; ?>").val(ttl);
            $("#pemakaian_value_<?php echo $no; ?>").val(ttl);
          }

          function apakai<?php echo $no; ?>() {
            var hitung = Number($("#a_unit_<?php echo $no; ?>").val()) + Number($("#t_unit_<?php echo $no; ?>").val()) - Number($("#s_unit_<?php echo $no; ?>").val());
            total = hitung.toFixed(1);
            $("#unit_<?php echo $no; ?>").val(total);
            $("#unit_value_<?php echo $no ?>").val(total);
            $("#unit_value2_<?php echo $no ?>").val(total);
          }
        </script>
        <input type="hidden" name="a_harga[]" id="a_harga_<?php echo $no ?>" class="form-control" autocomplete="off" value="<?php echo $v['harga']; ?>">
        <input type="hidden" name="kategory[]" class="form-control" value="<?php echo $v['kategori']; ?>" autocomplete="off">

        <td>
          <?php echo $no; ?>
        <td>
          <input type="text" name="product[]" id="nama_<?php echo $no ?>" class="form-control" value="<?php echo $v['nama_produk'] ?>" disabled autocomplete="off">
          <input type="hidden" name="product[]" id="product<?php echo $no ?>" value="<?php echo $v['id'] ?>" class="form-control" autocomplete="off">
          <input type="hidden" name="nama_produk[]" class="form-control" value="<?php echo $v['nama_produk'] ?>" autocomplete="off">
          <input type="hidden" name="count[]" id="count_<?php echo $no ?>" class="form-control" autocomplete="off">
        </td>
        <?php $stock = $this->model_stock->produkid($v['id']);
        if ($stock) {
          $aunit = $stock['s_unit'];
        } else {
          $aunit = 0;
        }
        ?>
        <td>
          <input type="text" disabled name="satuan_value[]" id="satuan_value_<?php echo $no ?>" class="form-control" value="<?php echo $v['satuan'] ?>" autocomplete="off">
          <input type="hidden" name="satuan_value[]" id="satuan_value_<?php echo $no ?>" value="<?php echo $v['satuan'] ?>" class="form-control" autocomplete="off">
        </td>
        <td>
          <input type="number" disabled name="a_unit[]" id="a_unit_<?php echo $no ?>" class="form-control" onkeyup="apakai<?php echo $no ?>()" onkeyup="nom<?php echo $no; ?>()" value="<?php echo $aunit; ?>">
          <input type="hidden" name="a_unit[]" id="a_unit_value_<?php echo $no ?>" class="form-control" value="<?php echo $aunit; ?>">
        </td>
        <td>
          <input type="number" required step="any" name="t_unit[]" id="t_unit_<?php echo $no ?>" class="form-control" autocomplete="off" onkeyup="apakai<?php echo $no ?>()">
        </td>
        <td>
          <input type="number" required step="any" name="s_unit[]" id="s_unit_<?php echo $no ?>" class="form-control" autocomplete="off" onkeyup="apakai<?php echo $no ?>()">
        </td>
        <td style="text-align: center;min-width: 100px;background-color: #ff00003b;">
          <input type="number" name="unit[]" id="unit_<?php echo $no ?>" class="form-control" disabled autocomplete="off">
          <input type="hidden" name="unit_value[]" id="unit_value_<?php echo $no; ?>" class="form-control" autocomplete="off" oninput="pemakaian<?php echo $no; ?>()">
        </td>
        <td>
          <input type="number" step="any" name="reg[]" id="reg_<?php echo $no; ?>" class="form-control" autocomplete="off" oninput="pemakaian<?php echo $no; ?>()" required>
        </td>
        <td>
          <input type="text" name="pemakaian[]" id="pemakaian_<?php echo $no; ?>" class="form-control" disabled autocomplete="off">
          <input type="hidden" name="pemakaian_value[]" id="pemakaian_value_<?php echo $no; ?>" class="form-control" autocomplete="off">
        </td>
        <td>
          <input type="text" name="ket[]" class="form-control" autocomplete="off">
        </td>
    </tr>

  <?php $no++;
      endforeach; ?>
  </tbody>
</table>