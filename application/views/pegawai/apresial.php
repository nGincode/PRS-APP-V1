<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Appraisal</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Appraisal</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">



        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b> Tambah Appraisal</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>

          <form role="form" method="post">
            <div class="box-body">

              <div class="form-group">
                <label for="nama">Nama Pegawai</label>
                <select name="nama" class="form-control select_group" style="width:100%;">
                  <option selected="true" disabled="disabled">Pilih Pegawai</option>
                  <?php foreach ($pegawai_data as $k => $v) : ?>
                    <option value="<?php echo $v['id'] ?>"><?php echo $v['nama'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <div class="form-group">
                <label for="tipe">Tipe Score</label>
                <select name="tipe" class="form-control" style="width:100%;">
                  <option selected="true" disabled="disabled">Pilih Tipe</option>
                  <option value="1">Leader</option>
                  <option value="2">Staf</option>

                </select>
              </div>

              <div class="form-group">
                <label for="score">Score</label>
                <input type="number" class="form-control" name="score" required placeholder="Score" autocomplete="off">
              </div>


              <div class="form-group">
                <label for="tanggal">Perpanjangan</label>
                <input type="text" class="form-control" name="tanggal" required placeholder="Tanggal Perpanjangan" autocomplete="off">
              </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>
            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
  </section>
  <!-- /.content -->

  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Manage Appraisal</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->

          <!-- /.box-header -->
          <div class="box-body" id='penyesuaian'>
            <table id="userTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Outlet</th>
                  <th>Nama</th>
                  <th>Divisi</th>
                  <th>Jabatan</th>
                  <th>Score</th>
                  <th>Nilai</th>
                  <th>Perpanjangan</th>
                  <th style='width:70px'>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($apraisal_data as $k => $v) : ?>
                  <tr>
                    <td><?php echo $v['store']; ?></td>
                    <td><?php echo $v['nama']; ?></td>
                    <td><?php echo $v['divisi']; ?></td>
                    <td><?php echo $v['jabatan']; ?></td>
                    <td><?php echo $v['score']; ?></td>
                    <td><?php echo $v['nilai']; ?></td>
                    <td><?php echo $v['tanggal']; ?></td>


                    <td>
                      <button type="button" class="btn btn-danger" onclick="removeFunc(<?php echo $v['id'] ?>)"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>

  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">




        <div class="box box-danger box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Laporan Appraisal</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->


          <br>

          <form role="form" action="excelapresial" method="post" enctype="multipart/form-data">

            <div class="form-group">
              <label class="col-sm-2 control-label" style="text-align:left;">Outlet</label>
              <div class="col-sm-7">
                <select name="outlet" class="form-control">
                  <option value="">- Tampil Semua -</option>
                  <?php foreach ($store as $k => $v) : ?>
                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <br><br><br>

            <br><br>


            <div class="form-group">
              <div class="col-sm-9">
                <button type="submit" class="btn btn-success"><i class='fa fa-file-excel-o'></i> Export</button>
              </div>
            </div>
          </form>
          <br><br><br>

          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>



</div>
<!-- /.content-wrapper -->



<script type="text/javascript">
  $(document).ready(function() {
    $('#userTable').DataTable();
    $(".select_group").select2();
    $("#mainPegawaiNav").addClass('active');
    $("#apraisalNav").addClass('active');
  });


  // remove functions 
  function removeFunc(id) {
    Swal.fire({
      title: 'Yakin Ingin Menghapus?',
      text: "Hilangkan Data Pegawai, Namun Absensi Tetap Tercatat!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Hapus !'
    }).then((result) => {
      if (result.isConfirmed) {
        var url = "<?php echo base_url('Pegawai/removeappresial') ?>";
        $.ajax({
          url: url,
          type: "post",
          data: {
            id: id
          },
          success: function(response) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Berhasil Terhapus',
              showConfirmButton: false,
              timer: 1500
            })
            setTimeout(function() { // wait for 5 secs(2)
              location.reload(); // then reload the page.(3)
            }, 1500);
          }
        });

      }
    })
  }
</script>