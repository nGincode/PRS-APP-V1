<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Laporan
      <small>Produk</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">




    <div class="box box-danger box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><b><i class="fa fa-th"></i> Barang Keluar</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>


      <!-- /.box-header -->
      <div class="box-body" id='penyesuaian'>

        <div style="position:relative;z-index: 9; margin:10px; display: flex;">

          <?php if ($div == 0) { ?>
            <div style="margin-right:10px;">
              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <?= $pilih; ?>
                <span class="fa fa-caret-down"></span>
              </button>
              <ul class="dropdown-menu" style="text-align: center;">
                <li><a href="<?= base_url('products/lkeluar');  ?>">SEMUA</a></li>
                <li class="divider"></li>
                <?php foreach ($store as $key => $value) {
                  echo '<li><a href="?filter=' . $value['id'] . '">' . $value['name'] . '</a></li>';
                }; ?>
              </ul>
            </div>
          <?php } else { ?>

            <div style="margin-right:10px;">
              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                <?= $namastore; ?>
              </button>
            </div>
          <?php } ?>
        </div>

        <div class="group">
          <input type="text" id="jadi" onchange="ubah()" name="datefilter" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label class="labeljudul">Pilih Tanggal</label>
        </div>
        <hr>



        <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
          <thead>
            <tr>
              <th style="width: 3px;">Opsi</th>
              <th>Bill</th>
              <th>Nama</th>
              <th>Outlet</th>
              <th>Waktu</th>
              <th>Total</th>
              <th>Jumlah</th>
              <th>Status</th>
            </tr>
          </thead>

        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <br />
    <!--
    <form action="<?php echo site_url('products/cetaklaporankeluar') ?>" method="post">
      <center><label style="font-size: 30px">Cetak Laporan Stock Keluar</label></center><br>
      <label>Dari : </label><br><input type="date" name="tgl_awal" class="form-control" required=""><br>
      <label>Sampai : </label><br><input type="date" name="tgl_akhir" class="form-control" required=""><br><br>
      <center><button class="btn btn-success" name=tgl type="submit"><i class="fa fa-print"></i> Cetak</button></center>
    </form>
-->
</div>


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

  var filter = "<?php echo $this->input->get('filter'); ?>";

  function ubah() {

    $(document).ready(function() {
      var da = $('#jadi').val();
      var validasiAngka = /^[0-9]+$/;

      $("#mainProductNav").addClass('active');
      $("#ProductkeluarNav").addClass('active');

      if (da) {
        manageTable = $('#manageTable').DataTable({
          processing: false,
          serverSide: false,
          destroy: true,
          "ajax": {
            url: base_url + 'products/laporankeluar',
            type: "POST",
            beforeSend: function() {
              $("#load").css("display", "block");
            },
            data: {
              tgl: da,
              filter: filter
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
</script>
<script type="text/javascript">
  function upload(id) {
    Swal.fire({
      title: 'Yakin ingin Upload?',
      text: "Data akan langsung mengurangi stock & tidak bisa diubah",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Upload'
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
          type: "POST",
          url: "<?= base_url() ?>products/status_up",
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
          success: function(response) {
            if (response == 1) {
              Swal.fire({
                icon: 'error',
                title: 'Gagal...!',
                text: 'Tidak Mempunyai Hak Akses',
                showConfirmButton: false,
                timer: 1500
              });
            }
            if (response == 2) {
              Swal.fire({
                icon: 'error',
                title: 'Gagal...!',
                text: 'Qty Arv & Qty Deliv Harus Sama',
                showConfirmButton: false,
                timer: 1500
              });
            }
            if (response == 3) {
              Swal.fire({
                icon: 'error',
                title: 'Gagal...!',
                text: 'Qty Arv & Qty Deliv Belum Terisi',
                showConfirmButton: false,
                timer: 1500
              });
            }
            if (response == 4) {
              Swal.fire({
                icon: 'error',
                title: 'Gagal...!',
                text: 'Qty Arv & Qty Deliv Belum Terisi',
                showConfirmButton: false,
                timer: 1500
              });
            }
            if (response == 5) {
              Swal.fire({
                icon: 'error',
                title: 'Gagal...!',
                text: 'Terjadi Kesalahan Penambahan!!',
                showConfirmButton: false,
                timer: 1500
              });
            }
            if (response == 6) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil...!',
                text: 'Produk Ditambahkan & Telah dijadikan laporan',
                showConfirmButton: false,
                timer: 1500
              });
              setTimeout(function() {
                window.location.href = '<?php base_url('products/lkeluar'); ?>';
              }, 1500);
            }
            if (response > 8) {
              Swal.fire({
                icon: 'warning',
                title: 'Bingunggg...!',
                text: 'Beberapa produk ada yg telah terupload',
                showConfirmButton: false,
                timer: 1500
              });
            }
          }
        });




      }
    })


  }
</script>