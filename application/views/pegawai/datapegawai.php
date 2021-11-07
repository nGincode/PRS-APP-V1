<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Pegawai</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pegawai</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">



        <?php if ($this->session->flashdata('success')) :

          echo "<script> Swal.fire({
              icon: 'success',
              title: 'Berhasil...!',
              text: '" . $this->session->flashdata('success') . "',
              showConfirmButton: false,
              timer: 4000
            });
</script>";

        ?>

        <?php elseif ($this->session->flashdata('error')) :
          echo "<script> Swal.fire({
              icon: 'error',
              title: 'Maaf...!',
              text: '" . $this->session->flashdata('error') . "',
              showConfirmButton: false,
              timer: 4000
            });
</script>";

        ?>


        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Tambah Pegawai</h3>
          </div>
          <form role="form" method="post">
            <div class="box-body">

              <div class="form-group">
                <label for="nama">Store</label>
                <select name="store" class="form-control">
                  <?php foreach ($store as $k => $v) : ?>
                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" required placeholder="Nama Lengkap" autocomplete="off">
              </div>


              <div class="form-group">
                <label for="tempat">Tempat Lahir</label>
                <input type="text" class="form-control" name="tempat" required autocomplete="off" placeholder="Tempat Lahir">
              </div>

              <div class="form-group">
                <label for="lahir">Tanggal Lahir</label>
                <input type="date" class="form-control" name="lahir" required autocomplete="off">
              </div>

              <div class="form-group">
                <label for="masuk_kerja">Tanggal Masuk Kerja</label>
                <input type="date" class="form-control" name="masuk_kerja" required autocomplete="off">
              </div>

              <div class="form-group">
                <label for="agama">Agama</label>
                <select class="form-control" name="agama" required>
                  <option value="" disabled="">--Pilih Agama--</option>
                  <option value="Islam">Islam</option>
                  <option value="Katolik">Katolik</option>
                  <option value="Kristen">Kristen</option>
                  <option value="Hindu">Hindu</option>
                  <option value="Budha">Budha</option>
                  <option value="Ateis">Ateis</option>
                  <option value="Konghucu ">Konghucu </option>
                </select>
              </div>

              <div class="form-group">
                <label for="jk">Jenis Kelamin</label>
                <select class="form-control" name="jk" required>
                  <option value="" disabled="">--Jenis Kelamin--</option>
                  <option value="1">Laki-Laki</option>
                  <option value="2">Perempuan</option>
                </select>
              </div>


              <div class="form-group">
                <label for="divisi">Divisi</label>
                <select class="form-control" name="divisi" required>
                  <option value="Accounting">Accounting</option>
                  <option value="Enginering">Enginering</option>
                  <option value="Marketing">Marketing</option>
                  <option value="HR & GA">HR & GA</option>
                  <option value="Logistik">Logistik</option>
                  <option value="Dapro">Dapur Produksi</option>
                  <option value="Chief Leader">Chief Leader</option>
                  <option value="Kitchen">Kitchen</option>
                  <option value="Bar">Bar</option>
                  <option value="Service Crew">Service Crew</option>
                  <option value="Akustik">Akustik</option>
                </select>
              </div>

              <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <select class="form-control" name="jabatan" required>
                  <option value="Supervisor">Supervisor</option>
                  <option value="Manager">Manager</option>
                  <option value="Leader">Leader</option>
                  <option value="Staf">Staf</option>
                  <option value="Freelance">Freelance</option>
                </select>
              </div>

              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" required="" name="alamat" placeholder="Alamat" autocomplete="off">
              </div>


              <div class="form-group">
                <label for="hp">No. Hp</label>
                <input type="number" class="form-control" required="" name="hp" placeholder="No Hp" autocomplete="off">
              </div>


            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>
              <a href="<?php echo base_url('pegawai/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#groups").select2();

    $("#mainPegawaiNav").addClass('active');
    $("#addPegawaiNav").addClass('active');

  });
</script>