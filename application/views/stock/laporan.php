<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Laporan
      <small>Stock Dari Office</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Stock</li>
    </ol>
  </section>

  <?php if ($this->session->flashdata('success')) :
    echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
  ?>
  <?php elseif ($this->session->flashdata('error')) :
    echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
  ?>
  <?php endif; ?>



  <!-- Main content -->

  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="ccol-md-12 col-xs-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs pull-right">
            <li><a href="#tab_1" data-toggle="tab">Audit + -</a></li>
            <li><a href="#tab_2" data-toggle="tab">Audit Ket</a></li>
            <li><a href="#tab_3" data-toggle="tab">Export Akumulasi</a></li>
            <li class="active"><a href="#tab_4" data-toggle="tab">Export All</a></li>
            <li class="pull-left header"><i class="fa fa-calendar"></i>Laporan Stock</li>
          </ul>
          <div class="tab-content">

            <div class="tab-pane" id="tab_1">


              <div class="row">
                <div class="col-md-12 col-xs-12">



                  <div class="box-body" style="overflow: auto;">


                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Awal</label>
                      <div class="col-sm-7">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input value="<?= date('Y-m-d', mktime(0, 0, 0, date("m") - 1, '26', date("Y"))); ?>" type="date" class="form-control" onchange="cek_data1()" name="tgl_awalll1" required data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                        </div>
                      </div>
                    </div>

                    <br><br>


                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Akhir</label>
                      <div class="col-sm-7">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input value="<?= date('Y-m') . '-25' ?>" type="date" class="form-control" onchange="cek_data1()" name="tgl_akhirrr1" required data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                        </div>
                      </div>
                    </div>


                    <br><br>



                    <div class="form-group">
                      <label class="col-sm-2 control-label" style="text-align:left;">Store</label>
                      <div class="col-sm-7">
                        <select name="outlettt1" onchange="cek_data1()" class="form-control">
                          <?php foreach ($store as $k => $v) : ?>
                            <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <br><br>


                    <div class="form-group">
                      <label class="col-sm-2 control-label" style="text-align:left;">Divisi</label>
                      <div class="col-sm-7">
                        <select name="bagian11" onchange="cek_data1()" class="form-control">
                          <option value="">- PILIH BAGIAN -</option>
                          <option value="1">BAR & KASIR</option>
                          <option value="2">WAITHER</option>
                          <option value="3">DAPUR</option>
                        </select>
                      </div>
                    </div>


                    <div class="loading3"></div>
                    <div class="tampilkan_data3"></div>

                  </div>
                  <!-- /.box -->
                </div>
                <!-- col-md-12 -->
              </div>


              <script type="text/javascript">
                function cek_data1() {
                  sel_tglawal = $('[name="tgl_awalll1"]');
                  sel_tglakhir = $('[name="tgl_akhirrr1"]');
                  sel_outlet = $('[name="outlettt1"]');
                  sel_bagian = $('[name="bagian11"]');
                  var view = "<?php echo base_url('stock/view_audit'); ?>";

                  if (sel_tglawal && sel_tglakhir && sel_outlet && sel_bagian) {
                    $.ajax({
                      type: 'POST',
                      data: {
                        cari: "1",
                        tgl_awal: sel_tglawal.val(),
                        tgl_akhir: sel_tglakhir.val(),
                        outlet: sel_outlet.val(),
                        bagian: sel_bagian.val()
                      },
                      url: view,
                      cache: false,
                      beforeSend: function() {
                        sel_tglawal.attr('disabled', false);
                        sel_tglakhir.attr('disabled', false);
                        if (sel_tglawal.val() && sel_tglakhir.val() && sel_outlet.val() && sel_bagian.val()) {
                          $('.loading3').html('<div class="overlay"><i class="fa fa-refresh fa-spin" style="z-index: 999999999;"></i></div>');
                        }
                      },
                      success: function(data) {
                        $('.loading3').html('');
                        if (sel_tglawal.val() && sel_tglakhir.val() && sel_outlet.val() && sel_bagian.val()) {
                          $('.tampilkan_data3').html(data);
                        }
                      }
                    });
                  }
                }
              </script>


            </div>

            <div class="tab-pane" id="tab_2">


              <div class="row">
                <div class="col-md-12 col-xs-12">



                  <div class="box-body" style="overflow: auto;">


                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Awal</label>
                      <div class="col-sm-7">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input value="<?= date('Y-m-d', mktime(0, 0, 0, date("m") - 1, '26', date("Y"))); ?>" type="date" class="form-control" onchange="cek_data()" name="tgl_awalll" required data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                        </div>
                      </div>
                    </div>

                    <br><br>


                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Akhir</label>
                      <div class="col-sm-7">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input value="<?= date('Y-m') . '-25' ?>" type="date" class="form-control" onchange="cek_data()" name="tgl_akhirrr" required data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                        </div>
                      </div>
                    </div>


                    <br><br>



                    <div class="form-group">
                      <label class="col-sm-2 control-label" style="text-align:left;">Store</label>
                      <div class="col-sm-7">
                        <select name="outlettt" onchange="cek_data()" class="form-control">
                          <option value="">Pilih</option>
                          <?php foreach ($store as $k => $v) : ?>
                            <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                    <br><br>


                    <div class="loading"></div>
                    <div class="tampilkan_data"></div>

                  </div>
                  <!-- /.box -->
                </div>
                <!-- col-md-12 -->
              </div>


              <script type="text/javascript">
                function cek_data() {
                  sel_tglawal = $('[name="tgl_awalll"]');
                  sel_tglakhir = $('[name="tgl_akhirrr"]');
                  sel_outlet = $('[name="outlettt"]');
                  var view = "<?php echo base_url('stock/view_akm'); ?>";

                  if (sel_tglawal && sel_tglakhir && sel_outlet) {
                    $.ajax({
                      type: 'POST',
                      data: {
                        cari: "1",
                        tgl_awal: sel_tglawal.val(),
                        tgl_akhir: sel_tglakhir.val(),
                        outlet: sel_outlet.val()
                      },
                      url: view,
                      cache: false,
                      beforeSend: function() {
                        sel_tglawal.attr('disabled', false);
                        sel_tglakhir.attr('disabled', false);
                        $('.loading').html('<div class="overlay"><i class="fa fa-refresh fa-spin" style="z-index: 999999999;"></i></div>');
                      },
                      success: function(data) {
                        $('.loading').html('');
                        if (sel_tglawal.val() && sel_tglakhir.val() && sel_outlet.val()) {
                          $('.tampilkan_data').html(data);
                        }
                      }
                    });
                  }

                }
              </script>


            </div>


            <div class="tab-pane" id="tab_3">


              <!-- /.box-header -->
              <form role="form" action="akexcel" id="akexcel" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="box-body">


                  <div class="col-md-4 col-xs-12 pull pull-left">

                    <div class="form-group">
                      <label class="col-sm-5 control-label" style="text-align:left;">Outlet</label>
                      <div class="col-sm-7">
                        <select name="outlet" id="outlet" class="form-control">
                          <option value="">- Tampil Semua -</option>
                          <?php foreach ($store as $k => $v) : ?>
                            <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-5 control-label" style="text-align:left;">Divisi</label>
                      <div class="col-sm-7">
                        <select name="bagian" id="bagian" class="form-control">
                          <option value="">- Tampil Semua -</option>
                          <option value="1">BAR & KASIR</option>
                          <option value="2">WAITHER</option>
                          <option value="3">DAPUR</option>
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
                          <input type="date" required name="tgl_awal" id="tgl_awal" value="<?= date('Y-m-d', mktime(0, 0, 0, date("m") - 1, '26', date("Y"))); ?>" class="form-control pull-right">
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
                          <input type="date" value="<?= date('Y-m') . '-25' ?>" name="tgl_akhir" id="tgl_akhir" required class="form-control pull-right">
                        </div>

                      </div>
                    </div>


                  </div>

                </div>

                <div class="box-footer">
                  <button type="submit" class="btn btn-app"><i class="fa fa-file-excel-o"></i> Akumulasi</button>
                </div>
              </form>
              <!-- /.box-body -->
            </div>

            <div class="tab-pane active" id="tab_4">

              <!-- /.box-header -->
              <form action="<?php echo base_url('stock/export') ?>" id="export" enctype="multipart/form-data" method="post" class="form-horizontal">
                <div class="box-body">


                  <div class="col-md-4 col-xs-12 pull pull-left">

                    <div class="form-group">
                      <label class="col-sm-5 control-label" style="text-align:left;">Outlet</label>
                      <div class="col-sm-7">
                        <select name="outlet" id="outlet1" class="form-control">
                          <option value="">- Tampil Semua -</option>
                          <?php foreach ($store as $k => $v) : ?>
                            <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-5 control-label" style="text-align:left;">Divisi</label>
                      <div class="col-sm-7">
                        <select name="bagian" id="bagian1" class="form-control">
                          <option value="">- Tampil Semua -</option>
                          <option value="1">BAR & KASIR</option>
                          <option value="2">WAITHER</option>
                          <option value="3">DAPUR</option>
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
                          <input type="date" id="tglawal" required name="tglawal" class="form-control pull-right" value="<?= date('Y-m-d', mktime(0, 0, 0, date("m") - 1, '26', date("Y"))); ?>">
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
                          <input type="date" id="tglakhir" value="<?= date('Y-m') . '-25' ?>" name="tglakhir" required class="form-control pull-right">
                        </div>

                      </div>
                    </div>


                  </div>

                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-app"><i class="fa fa-file-excel-o"></i> Perhari</button>
                </div>
              </form>


            </div>
            <!-- /.tab-pane -->
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
      </div>

    </div>
    <!-- col-md-12 -->
    <!-- /.row -->

    <div class="box  box-primary box-solid">

      <div class="box-header with-border">
        <h3 class="box-title"><b>File Export</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.box-tools -->

      <div class="box-body" id='penyesuaian'>
        <table id="manageTable1" class="table table-bordered table-striped" style="width: 100%;">
          <thead>
            <tr>
              <th style="text-align: center;">Nama</th>
              <th style="text-align: center; width:60px;">Action</th>
            </tr>
          </thead>

        </table>
      </div>

      <div id="load" class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
      <!-- /.box-body -->
    </div>


    </tbody>
    </table>

  </section>
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";
  $(document).ready(function() {

    $("#mainstockNav").addClass('active');
    $("#laporanstockNav").addClass('active');

    $('#manageTable1').DataTable({
      processing: false,
      serverSide: false,
      destroy: true,
      "ajax": {
        url: base_url + 'stock/fileexcel',
        beforeSend: function() {
          $("#load").css("display", "block");
        },
        complete: function() {
          $("#load").css("display", "none");
        }
      }
    });

  });

  $('#akexcel').on('submit', function(event) {
    event.preventDefault();
    var outlet = $('#outlet').val();
    var bagian = $('#bagian').val();
    var tgl_awal = $('#tgl_awal').val();
    var tgl_akhir = $('#tgl_akhir').val();

    if (outlet) {


      $.ajax({
          url: '<?php echo site_url("stock/akexcel"); ?>',
          type: 'POST',
          data: {
            outlet: outlet,
            bagian: bagian,
            tgl_awal: tgl_awal,
            tgl_akhir: tgl_akhir
          },
          beforeSend: function() {
            Swal.showLoading();
          },
          success: function(data) {
            if (data == 1) {
              Swal.fire({
                icon: 'error',
                title: 'Maaf...!',
                text: 'Data tidak ditemukan',
                showConfirmButton: false,
                timer: 4000
              })

            } else {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil...!',
                text: 'Berhasil diexport',
                showConfirmButton: false,
                timer: 4000
              })
              setTimeout(function() { // wait for 5 secs(2)
                location.reload(); // then reload the page.(3)
              }, 4000);
            }
          }
        })
        .fail(function(data) {
          Swal.fire({
            icon: 'error',
            title: 'Gagal...!',
            text: 'Terjadi kegagalan server',
            showConfirmButton: false,
            timer: 4000
          })
        });

    } else {
      Swal.fire({
        icon: 'error',
        title: 'Maaf...!',
        text: 'Server Tidak Mampu Sekarang',
        showConfirmButton: false,
        timer: 4000
      })

    }
  });


  $('#export').on('submit', function(event) {
    event.preventDefault();
    var outlet1 = $('#outlet1').val();
    var bagian1 = $('#bagian1').val();
    var tgl_awal = $('#tglawal').val();
    var tgl_akhir = $('#tglakhir').val();

    if (outlet1) {

      $.ajax({
          url: '<?php echo site_url("stock/export"); ?>',
          type: 'POST',
          data: {
            outlet: outlet1,
            bagian: bagian1,
            tglawal: tgl_awal,
            tglakhir: tgl_akhir
          },
          beforeSend: function() {
            Swal.showLoading();
          },
          success: function(data) {

            if (data == 1) {
              Swal.fire({
                icon: 'error',
                title: 'Maaf...!',
                text: 'Data tidak ditemukan',
                showConfirmButton: false,
                timer: 4000
              })

            } else {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil...!',
                text: 'Berhasil diexport',
                showConfirmButton: false,
                timer: 4000
              })
              setTimeout(function() { // wait for 5 secs(2)
                location.reload(); // then reload the page.(3)
              }, 4000);
            }


          }
        })
        .fail(function(data) {
          Swal.fire({
            icon: 'error',
            title: 'Gagal...!',
            text: 'Terjadi kegagalan server',
            showConfirmButton: false,
            timer: 4000
          })
        });

    } else {
      Swal.fire({
        icon: 'error',
        title: 'Maaf...!',
        text: 'Server Tidak Mampu Sekarang',
        showConfirmButton: false,
        timer: 4000
      })

    }
  });
</script>