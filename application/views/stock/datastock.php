<!-- Content Wrapper. Contains page content -->
<?php
$timezone = new DateTimeZone('Asia/Jakarta');
$date = new DateTime();
$date->setTimeZone($timezone);
if ($div == 1) {
  $bagian = 'Bar & Kasir';
} elseif ($div == 2) {
  $bagian = 'Waiter';
} elseif ($div == 3) {
  $bagian = 'Dapur';
};
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Stock</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Stock</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="ccol-md-12 col-xs-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs pull-right">
            <li><a href="#tab_1" data-toggle="tab">Cek Harian</a></li>
            <li><a href="#tab_2" data-toggle="tab">Cek Perproduk</a></li>
            <li class="active"><a href="#tab_3" data-toggle="tab">Tambah</a></li>
            <li class="pull-left header"><i class="fa fa-th"></i>Tambah Stock</li>
          </ul>
          <div class="tab-content">
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_1">

              <div id="messages"></div>


              <?php if ($this->session->flashdata('success')) :
                echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
              ?>
              <?php elseif ($this->session->flashdata('error')) :
                echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
              ?>
              <?php endif; ?>

              <!-- /.box-header -->
              <form role="form" action="<?php base_url('stock/datastock') ?>" method="post" class="form-horizontal" id="datastock">
                <div class="box-body">
                  <?php echo validation_errors(); ?>
                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-12 control-label">Tanggal: <?php echo $date->format('d-m-Y') ?></label>
                  </div>

                  <div class="col-md-4 col-xs-12 pull pull-left">
                    <div class="form-group">
                      <label class="col-sm-5 control-label" style="text-align:left;">Tanggal :</label>
                      <div class="col-sm-7">
                        <div class="input-group date">
                          <div class="input-group-addon ">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="date" onchange="cek_data()" name="date" class="form-control pull-right" id="datepicker">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-5 control-label" style="text-align:left;">Divisi</label>
                      <div class="col-sm-7">
                        <div class="input-group date">
                          <div class="input-group-addon ">
                            <i class="fa fa-users"></i>
                          </div>
                          <?php if (!$div == 1 or $div == 2 or $div == 3) { ?>
                            <select name="divisi" onchange="cek_data()" class="form-control pull-right">
                              <option value="<?php echo $div ?>"><?php echo $bagian ?></option>
                            </select>
                          <?php } else { ?>
                            <select name="divisi" onchange="cek_data()" class="form-control pull-right">
                              <option value="1">Bar & Kasir</option>
                              <option value="2">Waiter</option>
                              <option value="3">Dapur</option>
                            </select>
                          <?php }; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br><br>
                  <div class="loading"></div>
                  <div class="tampilkan_data"></div>
                </div>

                <script type="text/javascript">
                  function cek_data() {
                    sel_date = $('[name="date"]');
                    sel_divisi = $('[name="divisi"]');
                    var view = "<?php echo base_url('stock/view_data'); ?>";

                    $.ajax({
                      type: 'POST',
                      data: {
                        cari: "1",
                        date: sel_date.val(),
                        divisi: sel_divisi.val()
                      },
                      url: view,
                      cache: false,
                      beforeSend: function() {
                        $('.loading').html('Loading...');
                      },
                      success: function(data) {
                        $('.loading').html('');
                        if (sel_date.val() && sel_divisi.val()) {
                          $('.tampilkan_data').html(data);
                        }
                      }
                    });
                    return false;
                  }
                </script>
                <br /> <br />
                <br /> <br />
              </form>
              <!-- /.box-body -->

            </div>

            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">

              <!-- /.box-header -->
              <form role="form" action="<?php base_url('stock/datastock') ?>" method="post" class="form-horizontal" id="datastock">
                <div class="box-body">

                  <?php echo validation_errors(); ?>

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-12 control-label">Tanggal: <?php echo $date->format('d-m-Y') ?></label>
                  </div>

                  <div class="col-md-4 col-xs-12 pull pull-left">

                    <div class="form-group">
                      <label class="col-sm-5 control-label" style="text-align:left;">Tanggal Awal :</label>
                      <div class="col-sm-7">

                        <div class="input-group date">
                          <div class="input-group-addon ">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="date" onchange="cek_data3()" name="tglawal" class="form-control pull-right" id="datepicker">
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
                          <input type="date" onchange="cek_data3()" name="tglakhir" class="form-control pull-right" id="datepicker">
                        </div>

                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-5 control-label" style="text-align:left;">Divisi</label>
                      <div class="col-sm-7">

                        <div class="input-group date">
                          <div class="input-group-addon ">
                            <i class="fa fa-users"></i>
                          </div>

                          <?php if (!$div == 1 or $div == 2 or $div == 3) { ?>
                            <select name="divisi3" onchange="cek_data3()" class="form-control pull-right">
                              <option value="<?php echo $div ?>"><?php echo $bagian ?></option>
                            </select>
                          <?php } else { ?>
                            <select name="divisi3" onchange="cek_data3()" class="form-control pull-right">
                              <option value="1">Bar & Kasir</option>
                              <option value="2">Waiter</option>
                              <option value="3">Dapur</option>
                            </select>
                          <?php }; ?>
                        </div>
                      </div>
                    </div>
                  </div>

                  <br><br>

                  <div class="loading3"></div>
                  <div class="tampilkan_data3"></div>
                </div>

                <script type="text/javascript">
                  function cek_data3() {
                    sel_tglawal = $('[name="tglawal"]');
                    sel_tglakhir = $('[name="tglakhir"]');
                    sel_divisi = $('[name="divisi3"]');
                    var view = "<?php echo base_url('stock/view_data3'); ?>";

                    $.ajax({
                      type: 'POST',
                      data: {
                        cari: "1",
                        divisi: sel_divisi.val(),
                        tglawal: sel_tglawal.val(),
                        tglakhir: sel_tglakhir.val()
                      },
                      url: view,
                      cache: false,
                      beforeSend: function() {
                        sel_divisi.attr('disabled', false);
                        $('.loading3').html('Loading...');
                      },
                      success: function(data) {
                        sel_divisi.attr('disabled', false);
                        $('.loading3').html('');
                        if (sel_divisi.val() && sel_tglawal.val() && sel_tglakhir.val()) {
                          $('.tampilkan_data3').html(data);
                        }
                      }
                    });
                    return false;
                  }
                </script>


              </form>
              <!-- /.box-body -->


            </div>

            <!-- /.tab-pane -->
            <div class="tab-pane active" id="tab_3">
              <?php if ($div == 1 or $div == 2 or $div == 3) { ?>
                <!-- /.box-header -->
                <form role="form" action="<?php base_url('stock/datastock') ?>" method="post" class="form-horizontal" id="datastock">
                  <div class="box-body">
                    <?php echo validation_errors(); ?>
                    <div class="col-md-4 col-xs-12 pull pull-left">
                      <div class="form-group">
                        <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Outlet</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control" id="customer_address" name="customer_address" placeholder="<?php echo $outlet ?>" autocomplete="off" value="<?php echo $outlet ?>" disabled>
                          <input type="hidden" class="form-control" id="customer_address" name="customer_address" placeholder="<?php echo $outlet ?>" autocomplete="off" value="<?php echo $outlet ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-5 control-label" style="text-align:left;">Divisi</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control" autocomplete="off" value="<?php echo $bagian ?>" readonly>
                          <input type="hidden" class="form-control" name="divisi2" autocomplete="off" value="<?php echo $div ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-5 control-label" style="text-align:left;">Tanggal</label>
                        <div class="col-sm-7">
                          <input type="date" name="tgl" readonly class="form-control" autocomplete="off" value="<?php echo $tgl ?>" required="">
                        </div>
                      </div>
                    </div>

                    <table class="table table-bordered table-striped" id="product_info_table" style="overflow-x: scroll;display:block;">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th style="text-align: center;min-width: 200px;">Nama Produk</th>
                          <th style="text-align: center;">Satuan</th>
                          <th style="text-align: center;min-width: 90px;">Awal</th>
                          <th style="text-align: center;min-width: 90px;">Masuk</th>
                          <th style="text-align: center;min-width: 90px;">Sisa</th>
                          <th style="text-align: center;min-width: 90px;background-color: #ff00003b;">Terpakai</th>
                          <th style="text-align: center;min-width: 90px;">Register</th>
                          <th style="text-align: center;min-width: 90px;">Status</th>
                          <th style="text-align: center;min-width: 90px;">Ket</th>
                        </tr>
                      </thead>
                      <tbody>
                        <input type="hidden" name="bagian" class="form-control" value="<?php echo $div; ?>" autocomplete="off">

                        <?php $no = 1;
                        foreach ($data as $k => $v) : ?>
                          <tr>
                            <script type="text/javascript">
                              function pemakaian<?php echo $no; ?>() {
                                var hitung = Number($("#reg_<?php echo $no; ?>").val()) - Number($("#unit_value_<?php echo $no; ?>").val());

                                total = hitung.toFixed(1);
                                if (total > 0) {
                                  var t = '+';
                                  var ttl = t.concat(total);
                                }
                                if (total == 0) {
                                  var ttl = '0';
                                }
                                if (total < 0) {
                                  var ttl = total;
                                }
                                $("#pemakaian_<?php echo $no; ?>").val(ttl);
                                $("#pemakaian_value_<?php echo $no; ?>").val(ttl);
                              }

                              function apakai<?php echo $no; ?>() {
                                var hitung = Number($("#a_unit_value_<?php echo $no; ?>").val()) + Number($("#t_unit_<?php echo $no; ?>").val()) - Number($("#s_unit_<?php echo $no; ?>").val());
                                total = hitung.toFixed(1);
                                $("#unit_<?php echo $no; ?>").val(total);
                                $("#unit_value_<?php echo $no ?>").val(total);
                                $("#unit_value2_<?php echo $no ?>").val(total);
                              }
                            </script>
                            <input type="hidden" name="a_harga[]" id="a_harga_<?php echo $no ?>" class="form-control" autocomplete="off" value="<?php echo $v['harga']; ?>">
                            <input type="hidden" name="kategory[]" class="form-control" value="<?php echo $v['kategori']; ?>" autocomplete="off">

                            <td>
                              <?php echo $no; ?>
                            <td>
                              <?= $v['nama_produk'] ?>
                              <input type="hidden" name="product[]" id="product<?php echo $no ?>" value="<?php echo $v['id'] ?>" class="form-control" autocomplete="off">
                              <input type="hidden" name="nama_produk[]" class="form-control" value="<?php echo $v['nama_produk'] ?>" autocomplete="off">
                              <input type="hidden" name="count[]" id="count_<?php echo $no ?>" class="form-control" autocomplete="off">
                            </td>
                            <?php $stock = $this->model_stock->produkid($v['id']);
                            if ($stock) {
                              $aunit = $stock['s_unit'];
                            } else {
                              $aunit = 0;
                            }
                            ?>
                            <td>
                              <center><?= $v['satuan'] ?></center>
                              <input type="hidden" name="satuan_value[]" id="satuan_value_<?php echo $no ?>" value="<?php echo $v['satuan'] ?>" class="form-control" autocomplete="off">
                            </td>
                            <td>
                              <center><?= $aunit ?></center>
                              <input type="hidden" name="a_unit[]" id="a_unit_value_<?php echo $no ?>" class="form-control" value="<?php echo $aunit; ?>">
                            </td>
                            <td>
                              <input type="number" required step="any" name="t_unit[]" id="t_unit_<?php echo $no ?>" class="form-control" autocomplete="off" onkeyup="apakai<?php echo $no ?>()">
                            </td>
                            <td>
                              <input type="number" required step="any" name="s_unit[]" id="s_unit_<?php echo $no ?>" class="form-control" autocomplete="off" onkeyup="apakai<?php echo $no ?>()">
                            </td>
                            <td style="text-align: center;min-width: 100px;background-color: #ff00003b;">
                              <input type="number" name="unit[]" id="unit_<?php echo $no ?>" class="form-control" disabled autocomplete="off">
                              <input type="hidden" name="unit_value[]" id="unit_value_<?php echo $no; ?>" class="form-control" autocomplete="off" oninput="pemakaian<?php echo $no; ?>()">
                            </td>
                            <td>
                              <input type="number" step="any" name="reg[]" id="reg_<?php echo $no; ?>" class="form-control" autocomplete="off" oninput="pemakaian<?php echo $no; ?>()" required>
                            </td>
                            <td>
                              <input type="text" name="pemakaian[]" id="pemakaian_<?php echo $no; ?>" class="form-control" disabled autocomplete="off">
                              <input type="hidden" name="pemakaian_value[]" id="pemakaian_value_<?php echo $no; ?>" class="form-control" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" name="ket[]" class="form-control" autocomplete="off">
                            </td>
                          </tr>
                        <?php $no++;
                        endforeach; ?>
                      </tbody>
                    </table>
                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Kirim</button>
                      <a href="<?php echo base_url('stock/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
                    </div>

                  </div>
                </form>

              <?php } else { ?>

                <!-- /.box-header -->
                <form role="form" action="<?php base_url('stock/datastock') ?>" method="post" class="form-horizontal" id="datastock">
                  <div class="box-body">

                    <?php echo validation_errors(); ?>

                    <div class="form-group">
                      <label for="gross_amount" class="col-sm-12 control-label">Tanggal: <?php echo $date->format('d-m-Y') ?></label>
                    </div>

                    <div class="col-md-4 col-xs-12 pull pull-left">

                      <div class="form-group">
                        <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Outlet</label>
                        <div class="col-sm-7">

                          <input type="text" class="form-control" id="customer_address" name="customer_address" placeholder="<?php echo $outlet ?>" autocomplete="off" value="<?php echo $outlet ?>" disabled>
                          <input type="hidden" class="form-control" id="customer_address" name="customer_address" placeholder="<?php echo $outlet ?>" autocomplete="off" value="<?php echo $outlet ?>">

                        </div>
                      </div>
                      <?php

                      if ($div == 0) {
                        echo ' <div class="form-group">
                       <label class="col-sm-5 control-label" style="text-align:left;">Divisi</label>
                        <div class="col-sm-7">
                       <select name="divisi2" onchange="cek_data2()" class="form-control">
                       <option selected="true" disabled="disabled">- PILIH DIVISI -</option>
                        <option value="1" >Bar & Kasir</option>
                        <option value="2">Waiter</option>
                        <option value="3">Dapur</option>
                         </select>
                        </div></div>';
                      } elseif ($div == 11) {
                        echo ' <div class="form-group">
                        <label class="col-sm-5 control-label" style="text-align:left;">Divisi</label>
                        <div class="col-sm-7">
                        <select name="divisi2" onchange="cek_data2()" class="form-control">
                        <option selected="true" disabled="disabled">- PILIH DIVISI -</option>
                        <option value="1" >Bar & Kasir</option>
                        <option value="2">Waiter</option>
                        <option value="3">Dapur</option>
                        </select>
                          </div></div>';
                      } else {
                        if ($div == 1) {
                          $bagian = 'Bar & Kasir';
                        } elseif ($div == 2) {
                          $bagian = 'Waiter';
                        } elseif ($div == 3) {
                          $bagian = 'Kitchen';
                        };
                        echo ' <div class="form-group">
                          <label class="col-sm-5 control-label" style="text-align:left;">Divisi</label>
                          <div class="col-sm-7">
                          <select name="divisi2" onchange="cek_data2()" class="form-control">
                          <option selected="true" disabled="disabled">- PILIH DIVISI -</option>
                         <option value="' . $div . '" >' . $bagian . '</option>
                          </select>
                         </div></div>';
                      }
                      ?>

                    </div>

                    <br><br>

                    <div class="loading2"></div>
                    <div class="tampilkan_data2"></div>
                  </div>

                  <script type="text/javascript">
                    function cek_data2() {
                      sel_divisi = $('[name="divisi2"]');
                      var view = "<?php echo base_url('stock/view_data2'); ?>";

                      $.ajax({
                        type: 'POST',
                        data: {
                          cari: "1",
                          divisi: sel_divisi.val()
                        },
                        url: view,
                        cache: false,
                        beforeSend: function() {
                          sel_divisi.attr('disabled', false);
                          $('.loading2').html('Loading...');
                        },
                        success: function(data) {
                          sel_divisi.attr('disabled', false);
                          $('.loading2').html('');
                          if (sel_divisi.val()) {
                            $('.tampilkan_data2').html(data);
                          }
                        }
                      });
                      return false;
                    }
                  </script>



                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Kirim</button>
                    <a href="<?php echo base_url('stock/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
                  </div>
                </form>

              <?php }; ?>
              <!-- /.box-body -->
            </div>
            <!-- /.tab-pane -->

          </div>
          <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
      </div>

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

    $("#mainstockNav").addClass('active');
    $("#addstockNav").addClass('active');



  });


  "use strict";
  (() => {
    const modified_inputs = new Set;
    const defaultValue = "defaultValue";
    // store default values
    addEventListener("beforeinput", (evt) => {
      const target = evt.target;
      if (!(defaultValue in target || defaultValue in target.dataset)) {
        target.dataset[defaultValue] = ("" + (target.value || target.textContent)).trim();
      }
    });
    // detect input modifications
    addEventListener("input", (evt) => {
      const target = evt.target;
      let original;
      if (defaultValue in target) {
        original = target[defaultValue];
      } else {
        original = target.dataset[defaultValue];
      }
      if (original !== ("" + (target.value || target.textContent)).trim()) {
        if (!modified_inputs.has(target)) {
          modified_inputs.add(target);
        }
      } else if (modified_inputs.has(target)) {
        modified_inputs.delete(target);
      }
    });
    // clear modified inputs upon form submission
    addEventListener("submit", (evt) => {
      modified_inputs.clear();
      // to prevent the warning from happening, it is advisable
      // that you clear your form controls back to their default
      // state with evt.target.reset() or form.reset() after submission
    });
    // warn before closing if any inputs are modified
    addEventListener("beforeunload", (evt) => {
      if (modified_inputs.size) {
        const unsaved_changes_warning = "Changes you made may not be saved.";
        evt.returnValue = unsaved_changes_warning;
        return unsaved_changes_warning;
      }
    });
  })();
</script>