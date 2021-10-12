<br><br>
<table id="manageTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th style="min-width: 100px;">Nama Produk</th>
            <th>Tgl</th>
            <th>Awal</th>
            <th>Masuk</th>
            <th>Sisa</th>
            <th>Terpakai</th>
            <th>Reg</th>
            <th>Status</th>
            <th>Ket</th>
        </tr>
    </thead>
    <?php

    $store_id = '';
    $bagian = '';
    $no = 1;
    if ($data1) {
        foreach ($data1 as $key => $value) {

            if (strlen($value['ket']) == 1) {
                $ket = '';
            } else {
                $ket = $value['ket'];
            }

            echo '<tr><td>' .  $no . '</td><td>' .
                $value['nama_produk'] . '</td><td>' .
                $value['tgl'] . '</td><td>' .
                $value['a_unit'] . '</td><td>' .
                $value['t_unit'] . '</td><td>' .
                $value['s_unit'] . '</td><td>' .
                $value['unit'] . '</td><td>' .
                $value['reg'] . '</td><td>' .
                $value['status'] . '</td><td>' .
                $ket . '</td></tr>';
            $no++;
        }
    } ?>



</table>