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

        <?php if ($this->session->flashdata('success')) : ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif ($this->session->flashdata('error')) : ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Edit Employe</h3>
          </div>
          <form role="form" method="post">
            <div class="box-body">

              <div class="form-group">
                <label for="nama">Store</label>
                <select name="store" class="form-control">
                  <?php foreach ($store as $k => $v) : ?>
                    <option value="<?php echo $v['id'] ?>" <?php if ($pegawai_data['store_id'] == $v['id']) {
                                                              echo "selected='' ";
                                                            } ?>><?php echo $v['name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" required placeholder="Nama Lengkap" autocomplete="off" value="<?php echo $pegawai_data['nama']; ?>">
              </div>


              <div class="form-group">
                <label for="tempat">Tempat Lahir</label>
                <input type="text" class="form-control" name="tempat" required autocomplete="off" placeholder="Tempat Lahir" value="<?php echo $pegawai_data['tempat']; ?>">
              </div>

              <div class="form-group">
                <label for="lahir">Tanggal Lahir</label>
                <input type="date" class="form-control" name="lahir" required autocomplete="off" value="<?php echo $pegawai_data['lahir']; ?>">
              </div>

              <div class="form-group">
                <label for="masuk_kerja">Tanggal Masuk Kerja</label>
                <input type="date" class="form-control" name="masuk_kerja" required autocomplete="off" value="<?php echo $pegawai_data['masuk_kerja']; ?>">
              </div>

              <div class="form-group">
                <label for="agama">Agama</label>
                <select class="form-control" name="agama" required>
                  <option value="" disabled="">--Pilih Agama--</option>
                  <option value="Islam" <?php if ($pegawai_data['agama'] == 'Islam') {
                                          echo "selected='' ";
                                        } ?>>Islam</option>
                  <option value="Katolik" <?php if ($pegawai_data['agama'] == 'Katolik') {
                                            echo "selected='' ";
                                          } ?>>Katolik</option>
                  <option value="Kristen" <?php if ($pegawai_data['agama'] == 'Kristen') {
                                            echo "selected='' ";
                                          } ?>>Kristen</option>
                  <option value="Hindu" <?php if ($pegawai_data['agama'] == 'Hindu') {
                                          echo "selected='' ";
                                        } ?>>Hindu</option>
                  <option value="Budha" <?php if ($pegawai_data['agama'] == 'Budha') {
                                          echo "selected='' ";
                                        } ?>>Budha</option>
                </select>
              </div>

              <div class="form-group">
                <label for="jk">Jenis Kelamin</label>
                <select class="form-control" name="jk" required>
                  <option value="" disabled="">--Jenis Kelamin--</option>
                  <option value="1" <?php if ($pegawai_data['jk'] == '1') {
                                      echo "selected='' ";
                                    } ?>>Laki-Laki</option>
                  <option value="2" <?php if ($pegawai_data['jk'] == '2') {
                                      echo "selected='' ";
                                    } ?>>Perempuan</option>
                </select>
              </div>

              <div class="form-group">
                <label for="divisi">Divisi</label>
                <select class="form-control" name="divisi" required>
                  <option value="Accounting" <?php if ($pegawai_data['divisi'] == 'Accounting') {
                                                echo "selected='' ";
                                              } ?>>Accounting</option>
                  <option value="Enginering" <?php if ($pegawai_data['divisi'] == 'Enginering') {
                                                echo "selected='' ";
                                              } ?>>Enginering</option>
                  <option value="Marketing" <?php if ($pegawai_data['divisi'] == 'Marketing') {
                                              echo "selected='' ";
                                            } ?>>Marketing</option>
                  <option value="HR & GA" <?php if ($pegawai_data['divisi'] == 'HR & GA') {
                                            echo "selected='' ";
                                          } ?>>HR & GA</option>
                  <option value="Logistik" <?php if ($pegawai_data['divisi'] == 'Logistik') {
                                              echo "selected='' ";
                                            } ?>>Logistik</option>
                  <option value="Dapro" <?php if ($pegawai_data['divisi'] == 'Dapro') {
                                          echo "selected='' ";
                                        } ?>>Dapur Produksi</option>
                  <option value="Chief Leader" <?php if ($pegawai_data['divisi'] == 'Chief Leader') {
                                                  echo "selected='' ";
                                                } ?>>Chief Leader</option>
                  <option value="Kitchen" <?php if ($pegawai_data['divisi'] == 'Kitchen') {
                                            echo "selected='' ";
                                          } ?>>Kitchen</option>
                  <option value="Bar" <?php if ($pegawai_data['divisi'] == 'Bar') {
                                        echo "selected='' ";
                                      } ?>>Bar</option>
                  <option value="Service Crew" <?php if ($pegawai_data['divisi'] == 'Service Crew') {
                                                  echo "selected='' ";
                                                } ?>>Service Crew</option>
                  <option value="Akustik" <?php if ($pegawai_data['divisi'] == 'Akustik') {
                                            echo "selected='' ";
                                          } ?>>Akustik</option>
                </select>
              </div>

              <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <select class="form-control" name="jabatan" required>
                  <option value="Supervisor" <?php if ($pegawai_data['jabatan'] == 'Supervisor') {
                                                echo "selected='' ";
                                              } ?>>Supervisor</option>
                  <option value="Manager" <?php if ($pegawai_data['jabatan'] == 'Manager') {
                                            echo "selected='' ";
                                          } ?>>Manager</option>
                  <option value="Leader" <?php if ($pegawai_data['jabatan'] == 'Leader') {
                                            echo "selected='' ";
                                          } ?>>Leader</option>
                  <option value="Staf" <?php if ($pegawai_data['jabatan'] == 'Staf') {
                                          echo "selected='' ";
                                        } ?>>Staf</option>
                  <option value="Freelance" <?php if ($pegawai_data['jabatan'] == 'Freelance') {
                                              echo "selected='' ";
                                            } ?>>Freelance</option>
                </select>
              </div>

              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" required="" name="alamat" placeholder="Alamat" autocomplete="off" value="<?php echo $pegawai_data['alamat']; ?>">
              </div>


              <div class="form-group">
                <label for="hp">No. Hp</label>
                <input type="number" class="form-control" required="" name="hp" placeholder="No Hp" autocomplete="off" value="<?php echo $pegawai_data['hp']; ?>">
              </div>


              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" required>
                  <option value="0" <?php if ($pegawai_data['keluar'] == '0') {
                                      echo "selected='' ";
                                    } ?>>Aktif</option>
                  <option value="1" <?php if ($pegawai_data['keluar'] == '1') {
                                      echo "selected='' ";
                                    } ?>>Resign</option>
                </select>
              </div>


            </div>

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