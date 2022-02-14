<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Scanned
      <small>Voucher</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Voucher</li>
    </ol>
  </section>


  <section class="content">

    <div class="box box-primary box-solid">

      <div class="box-header with-border">
        <h3 class="box-title"><b>Scanned Voucher</b></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <div class="box-body" id="QR-Code">
        <div class="panel-heading">
          <div class="navbar-form navbar-left">
            <select class="form-control" id="camera-select"></select>
            <div class="form-group" style="padding: 5px;">
              <button style="display:none;" title="Decode Image" class="btn btn-default btn-sm" id="decode-img" type="hidden" data-toggle="tooltip"><span class="glyphicon glyphicon-upload"></span></button>
              <button style="display:none;" title="Image shoot" class="btn btn-info btn-sm disabled" id="grab-img" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-picture"></span></button>
              <button title="Jalankan Camera" class="btn btn-success btn-sm" id="play" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-play"></span><b>Mulai</b></button>
              <button style="display:none;" title="Pause" class="btn btn-warning btn-sm" id="pause" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-pause"></span> </button>
              <button title="Berhenti" class="btn btn-danger btn-sm" id="stop" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-stop"></span> <b>Stop</b></button>
            </div>
            <hr>
          </div>
        </div>
        <div class="panel-body text-center">
          <div class="col-md-6">
            <div class="well">
              <canvas style="width: 100%;height: 100%;" id="webcodecam-canvas"></canvas>
              <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
              <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
              <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
              <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
            </div>
            <p id="scanned-QR"></p>
            <div class="well">
              <div style="width: 100%;">
                <label style="display: none;" id="zoom-value" width="100">Zoom: 2</label>
                <input style="display: none;" id="zoom" onchange="Page.changeZoom();" type="range" min="10" max="30" value="20">
                <label style="display: none;" id="brightness-value" width="100">Brightness: 0</label>
                <input style="display: none;" id="brightness" onchange="Page.changeBrightness();" type="range" min="0" max="128" value="0">
                <label style="display: none;" id="contrast-value" width="100">Contrast: 0</label>
                <input style="display: none;" id="contrast" onchange="Page.changeContrast();" type="range" min="0" max="64" value="0">
                <label style="display: none;" id="threshold-value" width="100">Threshold: 0</label>
                <input style="display: none;" id="threshold" onchange="Page.changeThreshold();" type="range" min="0" max="512" value="0">
                <label style="display: none;" id="sharpness-value" width="100">Sharpness: off</label>
                <input style="display: none;" id="sharpness" onchange="Page.changeSharpness();" type="checkbox">
                <label style="display: none;" id="grayscale-value" width="100">grayscale: off</label>
                <input style="display: none;" id="grayscale" onchange="Page.changeGrayscale();" type="checkbox">
                <br>
                <label style="display: none;" id="flipVertical-value" width="100">Flip Vertical: off</label>
                <input style="display: none;" id="flipVertical" onchange="Page.changeVertical();" type="checkbox">
              </div>
              <label id="flipHorizontal-value" width="100">Flip Camera: off</label>
              <input id="flipHorizontal" onchange="Page.changeHorizontal();" type="checkbox">
            </div>

          </div>
          <div class="col-md-6">
            <div class="thumbnail" id="result">
              <div class="well" style="overflow: hidden;padding: 5px;">
                <img width="100%" height="100%" style="max-width: 100px;" id="scanned-img" src="https://www.btklsby.go.id/images/placeholder/basic.png">
              </div>
              <div class="caption" style="margin-top: -40px;">
                <h3>Hasil Scan</h3>
                <center>
                  <div id="info"></div>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Barcode -->
      <link href="<?= base_url() ?>assets/webcodecamjs/css/style.css" rel="stylesheet">
      <script type="text/javascript" src="<?= base_url() ?>assets/webcodecamjs/js/filereader.js"></script>
      <script type="text/javascript" src="<?= base_url() ?>assets/webcodecamjs/js/qrcodelib.js"></script>
      <script type="text/javascript" src="<?= base_url() ?>assets/webcodecamjs/js/webcodecamjs.js"></script>
      <script type="text/javascript" src="<?= base_url() ?>assets/webcodecamjs/js/main.js"></script>
    </div>



    <div class="box box-primary box-solid">

      <div class="box-header with-border">
        <h3 class="box-title"><b>Data penggunaan Voucher</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>

      <div class="box-body">
        <div>
          <table id="userTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align: center; ">Opsi</th>
                <th style="text-align: center; ">Tanggal</th>
                <th style="text-align: center; ">Nama</th>
                <th style="text-align: center;  ">ID </th>
                <th style="text-align: center;  ">Penukaran</th>
              </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($datapakai as $pakai) {
            ?>
              <tr>
                <td style="text-align: center; "><button class="btn btn-primary" onclick="print(<?php echo $pakai->id; ?>)"><i class="fa fa-print"></i></button></td>
                <td style="text-align: center; "><?php echo $pakai->tgl; ?></td>
                <td style="text-align: center; "><?php echo $pakai->nama; ?></td>
                <td style="text-align: center; "><?php echo $pakai->nopegawai; ?></td>
                <td style="text-align: center; "><?php echo $pakai->outlet; ?></td>
              </tr>
            <?php
            }
            ?>
          </table>
        </div>
      </div>
    </div>

  </section>
</div>
<div id="printaera" style="position: absolute; z-index: -1;"></div>
<script type="text/javascript">
  $(document).ready(function() {
    $('#userTable').DataTable();

    $("#mainvocpNav").addClass('active');
    $("#addvocpNav").addClass('active');
  });

  function print(id) {
    $.ajax({
      url: "<?= base_url('voc_peg/printDiv') ?>",
      type: 'POST',
      data: {
        id: id
      },
      success: function(data) {
        document.getElementById("printaera").innerHTML = data;
        $.print("#printaera");
      }
    });

  }
</script>
<script src="https://cdn.jsdelivr.net/npm/jQuery.print@1.5.1/jQuery.print.min.js"></script>