<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Barang</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Barang</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <i class="fa fa-th"></i>

            <h3 class="box-title">Barang Masuk</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <!-- /.box-header -->
          <form role="form" action="<?php base_url('products/bmasuk') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>
              <table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
                <thead>
                  <th style="width:10%;min-width:100px;text-align: center;">Tanggal</th>
                  <th style="width:70%;min-width:200px;text-align: center;">Produk</th>
                  <th style="width:30%;min-width:100px;text-align: center;">Qty</th>
                  <th style="width:5%;text-align: center;"><i class="fa fa-sign-in"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <input type="date" required name="tgl_bmasuk" id="tgl_bmasuk" class="form-control" autocomplete="off">
                    </td>
                    <td>
                      <select class="form-control select_group product" id="product_name" name="product_name" style="width:100%;" required>
                        <option value="">Pilih Produk</option>
                        <?php foreach ($products as $k => $v) : ?>
                          <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] . ' (' . $v['satuan'] . ')' ?></option>
                        <?php endforeach ?>
                      </select>
                    </td>

                    <td>
                      <input type="number" step="any" required name="qty" id="qty" class="form-control" placeholder="Qty" autocomplete="off">
                    </td>
                    <td>
                      <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
          </form>




          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <br />




      <div class="box box-danger box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b><i class="fa fa-th"></i> Belanja</b></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>


        <!-- /.box-header -->
        <div class="box-body" id='penyesuaian'>

          <div style="position:relative;z-index: 9; margin:10px; display: flex;">


            <div style="margin-right:10px;">
              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <?= $namastore; ?>
              </button>
            </div>
          </div>

          <div class="group">
            <input type="text" id="jadi" onchange="ubah()" name="datefilter" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label class="labeljudul">Pilih Tanggal</label>
          </div>
          <hr>



          <table id="manageTable1" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
              <tr>
                <th style="width: 3px;">Opsi</th>
                <th>Bill</th>
                <th>Tanggal</th>
                <th>Total</th>
              </tr>
            </thead>

          </table>
        </div>
        <!-- /.box-body -->
      </div>


      <?php if ($this->session->userdata('id') == 1) { ?>
        <div class="box box-warning box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-th"></i> Barang Jadi Dapro</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>


          <!-- /.box-header -->
          <div class="box-body" id='penyesuaian'>

            <div style="position:relative;z-index: 9; margin:10px; display: flex;">


              <div style="margin-right:10px;">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                  <?= $namastore; ?>
                </button>
              </div>
            </div>

            <div class="group">
              <input type="text" id="jadi" onchange="ubah1()" name="datefilter" required>
              <span class="highlight"></span>
              <span class="bar"></span>
              <label class="labeljudul">Pilih Tanggal</label>
            </div>
            <hr>



            <table id="manageTable2" class="table table-bordered table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <th style="width: 3px;">Opsi</th>
                  <th>Tanggal</th>
                  <th>Nama</th>
                  <th>Qty</th>
                  <th>Harga</th>
                  <th>Total</th>
                </tr>
              </thead>

            </table>
          </div>
          <!-- /.box-body -->
        </div>
      <?php } ?>




      <div class="box  box-solid">
        <div class="box-header">
          <h3 class="box-title">Stock Masuk</h3>
        </div>


        <!-- /.box-header -->
        <div class="box-body" id='penyesuaian'>
          <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>SKU</th>
                <th>Nama</th>
                <th>Qty After</th>
                <th>Qty Masuk</th>
                <th>Qty Total</th>
                <th>Harga</th>
                <th>Jumlah</th>
              </tr>
            </thead>

          </table>
        </div>
        <!-- /.box-body -->

      </div>
      <br />
      <!--
      <form action="<?php echo site_url('products/cetaklaporanbmasuk') ?>" method="post">
        <center><label style="font-size: 30px">Cetak Laporan Stock Masuk</label></center><br>
        <label>Dari : </label><br><input type="date" name="tgl_awal" class="form-control" required=""><br>
        <label>Sampai : </label><br><input type="date" name="tgl_akhir" class="form-control" required=""><br><br>
        <center><button class="btn btn-success" name=tgl type="submit"><i class="fa fa-print"></i> Cetak</button></center>
      </form>
                        -->
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
  </section>


  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainProductNav").addClass('active');
    $("#ProductmasukNav").addClass('active');



    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'products/laporanstockmasuk',
      'order': []
    });

  });
</script>


<script type="text/javascript">
  function ubah() {

    $(document).ready(function() {
      var da = $('#jadi').val();
      var validasiAngka = /^[0-9]+$/;

      $("#mainProductNav").addClass('active');

      if (da) {
        manageTable = $('#manageTable1').DataTable({
          processing: false,
          serverSide: false,
          destroy: true,
          "ajax": {
            url: base_url + 'products/masukbelanja',
            type: "POST",
            beforeSend: function() {
              $("#load").css("display", "block");
            },
            data: {
              tgl: da
            },
            complete: function() {
              $("#load").css("display", "none");
            }
          }
        });

      } else {
        alert('Tanggal harus dipilih');
      }
    });

  }


  function ubah1() {

    $(document).ready(function() {
      var da = $('#jadi').val();
      var validasiAngka = /^[0-9]+$/;

      $("#mainProductNav").addClass('active');

      if (da) {
        manageTable = $('#manageTable2').DataTable({
          processing: false,
          serverSide: false,
          destroy: true,
          "ajax": {
            url: base_url + 'products/masukbarangjadi',
            type: "POST",
            beforeSend: function() {
              $("#load").css("display", "block");
            },
            data: {
              tgl: da
            },
            complete: function() {
              $("#load").css("display", "none");
            }
          }
        });

      } else {
        alert('Tanggal harus dipilih');
      }
    });

  }

  $(function() {

    $('input[name="datefilter"]').daterangepicker({
      locale: {
        "format": 'DD/MM/YYYY',
        "applyLabel": 'Simpan',
        "cancelLabel": 'Hapus',
        "opens": "left",
        "drops": "up"
      },
      startDate: moment().subtract(7, 'days'),
      endDate: moment().subtract(1, 'days')
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });

  });




  function upload(id) {
    Swal.fire({
      title: 'Yakin ingin Upload?',
      text: "Data akan langsung menambah stock & tidak bisa diubah",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Upload'
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
          type: "POST",
          url: "<?= base_url() ?>products/uploadbarangmasuk",
          data: {
            'id': id
          },
          cache: false,
          beforeSend: function() {
            Swal.fire({
              title: 'Memproses!',
              didOpen: () => {
                Swal.showLoading()
              },
            })
          },
          success: function(data) {
            if (data) {
              Swal.fire({
                icon: 'error',
                title: 'Kesalahan...!',
                text: 'Item ' + data + ' Tidak Bisa diupload',
                showConfirmButton: false,
                timer: 1500
              });
            } else {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil...!',
                text: 'Item Berhasil ditambah',
                showConfirmButton: false,
                timer: 1500
              });
              manageTable.ajax.reload(null, false);
            }
          }
        });




      }
    })


  }


  function upload1(id) {
    Swal.fire({
      title: 'Yakin ingin Upload?',
      text: "Data akan langsung menambah stock & tidak bisa diubah",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Upload'
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
          type: "POST",
          url: "<?= base_url() ?>products/uploadbarangjadi",
          data: {
            'id': id
          },
          cache: false,
          beforeSend: function() {
            Swal.fire({
              title: 'Memproses!',
              didOpen: () => {
                Swal.showLoading()
              },
            })
          },
          success: function(data) {
            if (data) {
              Swal.fire({
                icon: 'error',
                title: 'Kesalahan...!',
                text: 'Item ' + data + ' Tidak Bisa diupload',
                showConfirmButton: false,
                timer: 1500
              })
            } else {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil...!',
                text: 'Item Berhasil ditambah',
                showConfirmButton: false,
                timer: 1500
              });
              $('#manageTable2').ajax.reload(null, false);
            }
          }
        });




      }
    })


  }
</script>