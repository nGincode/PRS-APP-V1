          <table id="manageTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align: center;" colspan="6">Awal</th>
                <th style="text-align: center;" colspan="4">+</th>
                <th style="text-align: center;" colspan="4">Sisa</th>
                <th style="text-align: center;" colspan="4">Terpakai</th>
                <th style="text-align: center;" colspan="3">Register</th>
              </tr>
              <tr>
                <th>No</th>
                <th style="min-width: 300px;">Nama Produk</th>
                <th>Unit</th>
                <th>UOM</th>
                <th>Harga</th>
                <th>Nominal</th>
                <th>Unit</th>
                <th>UOM</th>
                <th>Harga</th>
                <th>Nominal</th>
                <th>Unit</th>
                <th>UOM</th>
                <th>Harga</th>
                <th>Nominal</th>
                <th>Unit</th>
                <th>UOM</th>
                <th>Harga</th>
                <th>Nominal</th>
                <th>Reg</th>
                <th>UOM</th>
                <th>Pemakaian</th>
              </tr>
            </thead>
            <?php

            $store_id = '';
            $bagian = '';
            $no = 1;
            if ($data) {
              foreach ($data as $key => $value) {

                //nama produk
                $produk_id = $value['produk_id'];
                $stock = $this->model_stock->getnamastockid($produk_id);
                if (isset($stock['nama_produk'])) {
                  $nama_produk = $stock['nama_produk'];
                } else {
                  $nama_produk = $value['produk_id'] . ' Tidak diketahui';
                }

                //unit
                $an = $this->model_stock->a_unit($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $a_unit = $an['a_unit'];

                $t = $this->model_stock->t_unit($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $t_unit = round($t['sum(t_unit)'], 1);

                $s = $this->model_stock->s_unit($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $s_unit = $s['s_unit'];

                $up = $this->model_stock->unit($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $p_unit = round($up['sum(unit)'], 1);

                $pk = $this->model_stock->pakai($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $pakai = round($pk['sum(status)'], 1);

                //UOM
                $um = $this->model_stock->uom($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $uom = $um['0']['uom'];

                //harga
                $hr = $this->model_stock->harga($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $harga = $hr['0']['harga'];

                //reg
                $rg = $this->model_stock->reg($produk_id, $store_id, $bagian, $tgl_awal1, $tgl_akhir1);
                $reg = round($rg['sum(reg)'], 1);



                //Nom
                if ($harga) {
                  $hrg = $harga;
                } else {
                  $hrg = 0;
                };
                if ($a_unit) {
                  $aunit = $a_unit;
                } else {
                  $aunit = 0;
                };
                if ($t_unit) {
                  $tunit = $t_unit;
                } else {
                  $tunit = 0;
                };
                if ($s_unit) {
                  $sunit = $s_unit;
                } else {
                  $sunit = 0;
                };
                if ($p_unit) {
                  $punit = $p_unit;
                } else {
                  $punit = 0;
                };

                $nom_a = round($aunit * $hrg, 1);
                $nom_t = round($tunit * $hrg, 1);
                $nom_s = round($sunit * $hrg, 1);
                $nom_p = round($punit * $hrg, 1);


                echo '<tr><td>' .  $no . '</td><td>' .  $nama_produk . '</td><td>' .  $aunit . '</td><td>' .  $uom . '</td><td>' .  $hrg . '</td><td>' .  $nom_a . '</td><td>' .  $tunit . '</td><td>' .  $uom . '</td><td>' . $hrg . '</td><td>' .  $nom_t . '</td><td>' .  $sunit . '</td><td>' .  $uom . '</td><td>' .  $hrg . '</td><td>' .  $nom_s . '</td><td>' .  $punit . '</td><td>' .  $uom . '</td><td>' .  $hrg . '</td><td>' .  $nom_p . '</td><td>' .  $reg . '</td><td>' .  $uom . '</td><td>' .  $pakai . '</td></tr>';
                $no++;
              }


              $ket = $this->model_stock->ket($store_id, $bagian, $tgl_awal1, $tgl_akhir1);
              echo '<table class="table">
            <tr><th>Keterangan : </th></tr>
              <tr>
                <th style="text-align: center;" >Tanggal</th>
                <th style="text-align: center;" >Nama Produk</th>
                <th style="text-align: center;" >Ket.</th>
              </tr>';
              foreach ($ket as $key => $value) {
                //nama produk
                $produk_id = $value['produk_id'];
                if ($value['nama_produk']) {
                  $n_produk = $value['nama_produk'];
                } else {
                  $stock = $this->model_stock->getnamastockid($produk_id);

                  if (isset($stock['nama_produk'])) {
                    $n_produk = $stock['nama_produk'];
                  } else {

                    $n_produk = $value['produk_id'] . ' Tidak diketahui';
                  }
                }

                if ($value['ket']) {

                  echo '<tr><td>' . $value['tgl'] . '</td>';
                  echo '<td>' . $n_produk . '</td>';
                  echo '<td>' . $value['ket'] . '</td></tr>';
                }
              }
            } else {
            } ?>



          </table>