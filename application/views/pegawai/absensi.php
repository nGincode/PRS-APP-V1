<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Absensi</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Absensi</li>
    </ol>
  </section>

  <!-- Main content -->
  <?php if (!$div == 0) : ?>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">


          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Absensi </b></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>

            <form role="form" method="post" id="register">
              <div class="box-body">

                <div style="width: 100%;text-align: center;">
                  <div id="clock" style="font-size:x-large;font-weight:bolder;">
                  </div>
                </div>

                <div class="form-group">
                  <label for="nama">Nama Pegawai</label>
                  <select name="nama" id="nama" class="form-control select_group" required style="width:100%;">
                    <option selected="true" value="" disabled="disabled">Pilih Pegawai</option>
                    <?php foreach ($pegawai_data as $k => $v) : ?>
                      <option value="<?php echo $v['id'] ?>"><?php echo $v['nama'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="sift">Sift</label>
                  <select name="sift" id="sift" class="form-control" required style="width:100%;">
                    <option selected="true" value="" disabled="disabled">Pilih Sift</option>
                    <?php
                    $s1 = json_decode($dt_store['s1'], TRUE);
                    $s2 = json_decode($dt_store['s2'], TRUE);
                    $lembur = json_decode($dt_store['lembur'], TRUE);
                    $khusus_s1 = json_decode($dt_store['khusus_s1'], TRUE);
                    $khusus_s2 = json_decode($dt_store['khusus_s2'], TRUE);
                    ?>
                    <?php
                    if (date('D') == 'Sunday' or date('D') == 'Saturday') {
                      if ($khusus_s1[0] or $khusus_s2[0]) {

                        if (date('D') == 'Sunday') {
                          $hari = 'Minggu Shift 1';
                        } else  if (date('D') == 'Saturday') {
                          $hari = 'Sabtu Shift 1';
                        }

                        if (date('D') == 'Sunday') {
                          $hari1 = 'Minggu Shift 2';
                        } else  if (date('D') == 'Saturday') {
                          $hari1 = 'Sabtu Shift 2';
                        }

                        if ($khusus_s1[0]) {
                          echo '<option value="4">' . $hari . '</option>';
                        }
                        if ($khusus_s2[0]) {
                          echo '<option value="5">' . $hari1 . '</option>';
                        }
                      } else {
                        if ($s1[0]) {
                          echo '<option value="1">Shift 1</option>';
                        };
                        if ($s2[0]) {
                          echo '<option value="2">Shift 2</option>';
                        };
                        if ($lembur[0]) {
                          echo '<option value="3">Lembur</option>';
                        };
                      }
                    } else {  ?>

                      <?php if ($s1[0]) { ?>
                        <option value="1">Sift 1</option>
                      <?php }  ?>
                      <?php if ($s2[0]) { ?>
                        <option value="2">Sift 2</option>
                    <?php }
                    } ?>
                    <?php if ($lembur[0]) { ?>
                      <option value="3">Lembur</option>
                    <?php } ?>

                  </select>
                </div>

                <div class="form-group">
                  <div id="donate">
                    <label><input type="radio" id="ket" name="ket" value="1" <?php if (date('His') < '150000') {
                                                                                echo "checked";
                                                                              } ?>><span>Masuk</span></label>
                    <label><input type="radio" id="ket2" name="ket" value="2" <?php if (date('His') > '150000') {
                                                                                echo "checked";
                                                                              } ?>><span>Keluar</span></label>
                  </div>
                </div>
                <br><br><br><br><br>
                <div class="form-group">
                  <label for="camera">Camera</label>
                  <div id="my_camera">
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
      <!-- /.row -->


    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

    <script language="JavaScript">
      Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
      });
      Webcam.attach('#my_camera');
    </script>


    <!-- Code to handle taking the snapshot and displaying it locally -->
    <script type="text/javascript">
      $('#register').on('submit', function(event) {
        event.preventDefault();
        var image = '';
        var nama = $('#nama').val();
        var sift = $('#sift').val();
        var ket = $("#ket:checked").val();
        Webcam.snap(function(data_uri) {
          image = data_uri;
          //$('#my_camera').html('<img src="' + data_uri + '"/>')
        });

        if (image) {
          $.ajax({
              url: '<?php echo site_url("Pegawai/saveabsensi"); ?>',
              type: 'POST',
              dataType: 'json',
              data: {
                nama: nama,
                image: image,
                ket: ket,
                sift: sift
              },
            })
            .done(function(data) {
              if (data == 'q') {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal...!',
                  text: 'Terjadi Masalah Pada Gambar',
                  showConfirmButton: false,
                  timer: 1500
                });
              } else if (data == 'qw') {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal...!',
                  text: 'Foto anda tidak terdeteksi',
                  showConfirmButton: false,
                  timer: 1500
                });
              } else if (data == 'zz') {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal...!',
                  text: 'Shift Tidak Valid',
                  showConfirmButton: false,
                  timer: 1500
                });
              } else if (data == 5) {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal...!',
                  text: 'Anda Harus Absen Masuk Dulu',
                  showConfirmButton: false,
                  timer: 1500
                });
              } else if (data > 0) {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil...!',
                  text: 'Anda Berhasil Absen',
                  showConfirmButton: false,
                  timer: 1500
                });

                setTimeout(function() { // wait for 5 secs(2)
                  location.reload(); // then reload the page.(3)
                }, 1500);
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal...!',
                  text: 'Anda Telah Absen Hari Ini',
                  showConfirmButton: false,
                  timer: 1500
                });

              }
            })
            .fail(function(data) {
              console.log(data);
            });

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal...!',
            text: 'Kamera Bermasalah Refresh Halaman',
            showConfirmButton: false,
            timer: 1500
          });
        }



      });
    </script>


    <script type="text/javascript">
      function showTime() {
        var a_p = "";
        var today = new Date();
        var curr_hour = today.getHours();
        var curr_minute = today.getMinutes();
        var curr_second = today.getSeconds();
        if (curr_hour < 12) {
          a_p = "AM";
        } else {
          a_p = "PM";
        }
        if (curr_hour == 0) {
          curr_hour = 12;
        }
        if (curr_hour > 12) {
          curr_hour = curr_hour - 12;
        }
        curr_hour = checkTime(curr_hour);
        curr_minute = checkTime(curr_minute);
        curr_second = checkTime(curr_second);
        document.getElementById('clock').innerHTML = curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p;
      }

      function checkTime(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
      }
      setInterval(showTime, 500);
      //-->
    </script>

  <?php endif; ?>
  <!-- /.content -->


  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">


        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Absensi Terinput </b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body" id='penyesuaian'>

            <div style="position:relative;z-index: 9; margin:20px; display: flex;">

              <?php if ($div == 0) { ?>
                <div style="margin-right:10px;">
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <?= $pilih; ?>
                    <span class="fa fa-caret-down"></span>
                  </button>
                  <ul class="dropdown-menu" style="text-align: center;">
                    <li><a href="<?= base_url('Pegawai/absensi');  ?>">SEMUA</a></li>
                    <li class="divider"></li>
                    <?php foreach ($store as $key => $value) {
                      echo '<li><a href="?filter=' . $value['id'] . '">' . $value['name'] . '</a></li>';
                    }; ?>
                  </ul>
                </div>
              <?php } ?>
            </div>


            <div class="group">
              <input type="text" id="jadi" onchange="ubah()" name="datefilter" required>
              <span class="highlight"></span>
              <span class="bar"></span>
              <label class="labeljudul">Pilih Tanggal</label>
            </div>

            <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <?php if (in_array('deletePegawai', $this->permission) or in_array('updatePegawai', $this->permission)) : ?>
                    <th style='width:10px'>
                      <center>Action</center>
                    </th>
                  <?php endif; ?>
                  <th style='width:70px'>Tanggal</th>
                  <?php if ($div == 0) : ?>
                    <th>Outlet</th>
                  <?php endif; ?>
                  <th>Nama</th>
                  <th>Sift</th>
                  <?php if ($div == 0) : ?>
                    <th style='width:70px'>
                      <center>G.Masuk</center>
                    </th>
                  <?php endif; ?>
                  <?php if ($div == 0) : ?>
                    <th style='width:70px'>
                      <center>G.Keluar</center>
                    </th>
                  <?php endif; ?>
                  <th style='width:70px'>
                    <center>Masuk</center>
                  </th>
                  <th style='width:70px'>
                    <center>Keluar</center>
                  </th>
                </tr>
              </thead>

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



  <?php if ($div == 0) : ?>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Atur Jam Outlet</h3>
            </div>
            <br><br>
            <!-- /.box-header -->




            <form action="<?php echo base_url('Pegawai/jamoutletinput') ?>" method="post" class="form-horizontal">
              <div class="box-body">

                <?php echo validation_errors(); ?>


                <div class="col-md-4 col-xs-12 pull pull-left">

                  <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Outlet :</label>
                    <div class="col-sm-7">

                      <select name="outlet" id="outlet" class="form-control">
                        <option value="">-- Pilih --</option>
                        <?php foreach ($store as $k => $v) : ?>
                          <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                        <?php endforeach ?>
                      </select>

                    </div>
                  </div>
                  <div id="isijam"></div>

                </div>

              </div>

              <div class="box-footer">
                <button type="submit" class="btn btn-app"><i class="fa fa-sign-in"></i> Simpan</button>
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



      <!-- /.box-body -->
    </section>
  <?php endif; ?>


  <?php if ($div == 0) : ?>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Laporan Absensi</h3>
            </div>
            <br><br>
            <!-- /.box-header -->




            <form action="<?php echo base_url('Pegawai/laporanabsensi') ?>" method="post" class="form-horizontal">
              <div class="box-body">

                <?php echo validation_errors(); ?>


                <div class="col-md-4 col-xs-12 pull pull-left">

                  <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Outlet :</label>
                    <div class="col-sm-7">

                      <select name="outlet" class="form-control">
                        <?php foreach ($store as $k => $v) : ?>
                          <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                        <?php endforeach ?>
                      </select>

                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Tanggal Awal :</label>
                    <div class="col-sm-7">

                      <div class="input-group date">
                        <div class="input-group-addon ">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" value="<?= date('Y-m-d', mktime(0, 0, 0, date("m") - 1, '26', date("Y"))); ?>" required name="tgl_awal" class="form-control pull-right">
                      </div>

                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Tanggal Akhir :</label>
                    <div class="col-sm-7">

                      <div class="input-group date">
                        <div class="input-group-addon ">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input value="<?= date('Y-m') . '-25' ?>" type="date" name="tgl_akhir" required class="form-control pull-right">
                      </div>

                    </div>
                  </div>


                </div>

              </div>

              <div class="box-footer">
                <button type="submit" class="btn btn-app"><i class="fa fa-file-excel-o"></i> Excel</button>
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



      <!-- /.box-body -->
    </section>
  <?php endif; ?>

  <!-- /.row -->

</div>
<!-- /.content-wrapper -->





<script type="text/javascript">
  $(document).ready(function() {
    $('#userTable').DataTable();
    $(".select_group").select2();
    $("#mainPegawaiNav").addClass('active');
    $("#absensiNav").addClass('active');
  });


  var manageTable;
  var base_url = "<?php echo base_url(); ?>";
  var filter = "<?php echo $this->input->get('filter'); ?>";

  function ubah() {
    var da = $('#jadi').val();

    $(document).ready(function() {
      manageTable = $('#manageTable').DataTable({
        processing: false,
        serverSide: false,
        destroy: true,
        "order": [],
        "ajax": {
          url: base_url + 'Pegawai/fetchabsensiData',
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
      startDate: '<?= date('d/m/Y', mktime(0, 0, 0, date("m"), date('d') - 7, date("Y"))); ?>',
      endDate: '<?= date('d/m/Y') ?>'
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });

  });


  // remove functions 
  function removeFunc(id, image) {
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
        var url = "<?php echo base_url('Pegawai/removeabsen') ?>";
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


  $('#outlet').change(function() {
    var id = $(this).val();
    $.ajax({
      type: 'POST',
      url: 'jamoutlet',
      data: {
        'id': id
      },
      success: function(data) {
        $('#isijam').html(data);
      }
    });
  });
</script>

<style>
  #my_camera {
    -webkit-transform: scaleX(-1);
    transform: scaleX(-1);
  }

  #donate {
    margin: 4px;
    float: left;
  }

  #donate label {
    float: left;
    width: 170px;
    background-color: #EFEFEF;
    overflow: auto;
    cursor: pointer;

  }

  #donate label span {
    text-align: center;
    font-size: 32px;
    padding: 13px 0px;
    display: block;
  }

  #donate label input {
    position: absolute;
    top: -20px;
    visibility: hidden;
  }

  #donate input:checked+span {
    background-color: #3c8dbc;
    color: #F7F7F7;
  }
</style>