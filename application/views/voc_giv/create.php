<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
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
        <h3 class="box-title"><b>Buat Nama Voucher</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>

      <div class="box-body">
        <center>
          <caption class="title">
            <h2><b>Buat Nama Voucher</b></h2>
          </caption>
          <br>
          <form method="post" action="buatnamavoc" enctype="multipart/form-data">
            <input type="text" class="form-control" style="text-align: center;" name="nama_voucher" placeholder="Nama Voucher"><br>
            <input type="file" class="form-control" style="text-align: center;" name="img">
            <br><select name="outlet" class="form-control">
              <option value="0">Semua Outlet</option>
              <?php foreach ($outlet as $k => $v) : ?>
                <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
              <?php endforeach ?>
            </select>
            <br><button class="btn btn-success" type="submit" style="width: 100%;margin-top: 5px;"><i class="glyphicon glyphicon-plus"></i></button>
          </form>
        </center>
      </div>
    </div>

    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><b>Buat Voucher</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <div class="box-body">
        <center>
          <caption class="title">
            <h2><b>BUAT VOUCHER</b></h2>
          </caption>
          <br>
          <form method="post" action="buatvoc">
            <b style="float: left;">Nama Voucher</b>
            <select name="asal" class="form-control">
              <?php foreach ($sumber as $k => $v) : ?>
                <option value="<?php echo $v['id'] ?>"><?php echo $v['nama'] ?></option>
              <?php endforeach ?>
            </select>

            <br>
            <b style="float: left;">Tempat Penukaran</b>
            <select name="outlet" class="form-control">
              <option value="0">Semua Outlet</option>
              <?php foreach ($outlet as $k => $v) : ?>
                <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
              <?php endforeach ?>
            </select>
            <br>
            <b style="float: left;">Jumlah Voucher</b>
            <input type="number" placeholder="Jumlah Voucher" class="form-control" style="text-align: center;" name="jml">
            <br>
            <b style="float: left;">Tanggal Kadaluarsa</b>
            <input type="date" placeholder="Tanggal" class="form-control" style="text-align: center;" name="kadaluarsa">
            <br>
            <button class="btn btn-success" type="submit" style="width: 100%;margin-top: 5px;"><i class="glyphicon glyphicon-plus"></i></button>
          </form>
          <br>
          <br>
          <form method="post" action="print" style="display: flex;">
            <select name="asal" class="form-control" style="width: 200px;">
              <?php foreach ($sumber as $k => $v) : ?>
                <option value="<?php echo $v['id'] ?>"><?php echo $v['nama'] ?></option>
              <?php endforeach ?>
            </select>
            <button class="btn btn-warning" type="submit"><i class="glyphicon glyphicon-print"></i></button>
          </form>
        </center>



      </div>
    </div>

    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><b>Data Nama Voucher</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div>
          <table id="list-data" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align: center;  width: 10px;">No</th>
                <th style="text-align: center;  ">Nama</th>
                <th style="text-align: center;  width: 90px;">Gambar</th>
                <th style="text-align: center;  ">Tgl Buat</th>
                <th style="text-align: center;  ">Untuk</th>
                <th style="text-align: center;  width: 90px;">Action</th>
              </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($namavoucher as $key => $d) {
              $untuk = $this->model_vocgif->namavoc($d['untuk']);
              if ($untuk == 0) {
                $unt = 'Semua Outlet';
              } else {
                $unt = $untuk['nama'];
              };
            ?>
              <tr style="width: 200px;">
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama']; ?></td>
                <td><img width="100" src="../assets/voucher/<?php echo $d['img']; ?>"> </td>
                <td><?php echo $d['tglbuat']; ?></td>
                <td><?php echo $unt; ?></td>
                <td style="text-align: center;  width: 90px;"><button type="button" class="btn btn-danger" onclick="removeFunc(<?php echo $d['id']; ?>)" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash-o"></i></button></td>
              </tr>
            <?php
            }
            ?>
          </table>
        </div>
      </div>
    </div>


    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><b>Data Voucher</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div>
          <table id="list-data1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align: center;  width: 10px;">No</th>
                <th style="text-align: center;  width: 90px;">Voucher</th>
                <th style="text-align: center;  width: 90px;">Asal</th>
                <th style="text-align: left;  ">Keterangan</th>
              </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($data as $key => $d) {
            ?>
              <tr style="width: 200px; <?php if ($d['claim'] == 1) {
                                          echo 'background-color: #ff000033';
                                        } ?>;">
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['kode']; ?></td>
                <td><?php echo $d['namavoc']; ?></td>
                <td><?php if ($d['claim'] == 1) {
                      echo 'Terpakai';
                    } ?></td>
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
</section>
</div>



<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Hapus Voucher</h4>
      </div>

      <form role="form" action="<?php echo base_url('voucher/remove') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>Yakin Ingin Menghapus Voucher?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
  $(document).ready(function() {
    $('#list-data').DataTable();
    $('#list-data1').DataTable();

    $("#mainvoucherNav").addClass('active');
    $("#addvoucherNav").addClass('active');
  });


  function removeFunc(id) {
    if (id) {
      $("#removeForm").on('submit', function() {

        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: {
            id: id
          },
          dataType: 'json',
          success: function(response) {


            if (response.success === true) {

              Swal.fire({
                icon: 'success',
                title: 'Berhasil...!',
                text: response.messages,
                showConfirmButton: false,
                timer: 4000
              })
              setTimeout(function() {
                location.reload();
              }, 1500);

              // hide the modal
              $("#removeModal").modal('hide');

            } else {

              Swal.fire({
                icon: 'error',
                title: 'Maaf...!',
                text: response.messages,
                showConfirmButton: false,
                timer: 4000
              })
              setTimeout(function() {
                location.reload();
              }, 1500);
              // hide the modal
              $("#removeModal").modal('hide');
            }
          }
        });

        return false;
      });
    }
  }
</script>