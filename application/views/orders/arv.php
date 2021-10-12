<?php
if ($order_data['order_item']['0']['qtydeliv'] == NULL) :

  $this->session->set_flashdata('error', 'Maaf..! qty pesanan belum diproses');
  redirect('orders/', 'refresh');

else :
?>
  <?php if ($this->session->flashdata('success')) :
    echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
  ?>
  <?php elseif ($this->session->flashdata('error')) :
    echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
  ?>
  <?php endif; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit
        <small>Orders</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Orders</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          <div id="messages"></div>


          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><b><i class="fa fa-shopping-cart"></i> Edit Order</b></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <form role="form" id='' method="post" class="form-horizontal">
              <div class="box-body">

                <?php echo validation_errors(); ?>


                <div class="col-md-4 col-xs-12 pull pull-left">

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Nama Penerima</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Nama Pengorder" value="<?php echo $order_data['order']['customer_name'] ?>" autocomplete="off" disabled />
                      <input type="hidden" class="form-control" id="customer_name" name="customer_name" placeholder="Nama Pengorder" value="<?php echo $order_data['order']['customer_name'] ?>" autocomplete="off" />
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Outlet</label>
                    <div class="col-sm-7">

                      <input type="text" class="form-control" id="customer_address" name="customer_address" placeholder="<?php echo $order_data['order']['customer_address'] ?>" autocomplete="off" value="<?php echo $order_data['order']['customer_address'] ?>" disabled>
                      <input type="hidden" class="form-control" id="customer_address" name="customer_address" placeholder="<?php echo $order_data['order']['customer_address'] ?>" autocomplete="off" value="<?php echo $order_data['order']['customer_address'] ?>">

                    </div>
                  </div>

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">No Hp</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="No Hp Pengorder" value="<?php echo $order_data['order']['customer_phone'] ?>" autocomplete="off" disabled>
                      <input type="hidden" class="form-control" id="customer_phone" name="customer_phone" placeholder="No Hp Pengorder" value="<?php echo $order_data['order']['customer_phone'] ?>" autocomplete="off">
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Tanggal</label>
                    <div class="col-sm-7">
                      <input type="date" readonly name="tgl_order" value="<?php echo date('Y-m-d', $order_data['order']['date_time']) ?>" required class="form-control" autocomplete="off">
                    </div>
                  </div>

                </div>


                <br /> <br />
                <table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
                  <thead>
                    <tr>
                      <th style="width:3%;text-align: center;">No</th>
                      <th style="width:50%;min-width:200px;text-align: center;">Produk</th>
                      <th style="width:10%;min-width:70px;text-align: center;">Order</th>
                      <th style="width:10%;min-width:70px;text-align: center;">Deliv</th>
                      <th style="width:10%;min-width:70px;text-align: center;">Arrive</th>
                      <?php if (!$order_data['order']['status_up'] == 1) { ?>
                        <th style="width:3%;text-align: center;">Status</th>
                      <?php } ?>
                    </tr>
                  </thead>

                  <tbody>

                    <?php if (isset($order_data['order_item'])) : ?>
                      <?php $x = 1;
                      $no = 1; ?>
                      <?php foreach ($order_data['order_item'] as $key => $val) : ?>
                        <?php //print_r($v); 
                        ?>
                        <tr id="row_<?php echo $x; ?>">
                          <td>
                            <center><?= $no++; ?></center>
                          </td>
                          <td>
                            <select disabled class="form-control select_group product" data-row-id="row_<?php echo $x; ?>" id="product_<?php echo $x; ?>" name="product[]" style="width:100%;" onchange="getProductData(<?php echo $x; ?>)" required>
                              <option value=""></option>
                              <?php foreach ($products as $k => $v) : ?>
                                <option value="<?php echo $v['id'] ?>" <?php if ($val['product_id'] == $v['id']) {
                                                                          echo "selected='selected'";
                                                                        } ?>><?php echo $v['name'] ?> / <?php echo $val['satuan'] ?></option>
                              <?php endforeach ?>
                            </select>
                            <select data-row-id="row_<?php echo $x; ?>" id="product_<?php echo $x; ?>" name="product[]" style="width:100%; display: none;" onchange="getProductData(<?php echo $x; ?>)" required>
                              <option value=""></option>
                              <?php foreach ($products as $k => $v) : ?>
                                <option value="<?php echo $v['id'] ?>" <?php if ($val['product_id'] == $v['id']) {
                                                                          echo "selected='selected'";
                                                                        } ?>><?php echo $v['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td><input type="text" name="qty[]" id="qty_<?php echo $x; ?>" class="form-control" required onkeyup="getTotal(<?php echo $x; ?>)" value="<?php echo $val['qty'] ?>" disabled autocomplete="off">
                            <input type="hidden" name="qty[]" id="qty_<?php echo $x; ?>" class="form-control" required onkeyup="getTotal(<?php echo $x; ?>)" value="<?php echo $val['qty'] ?>" autocomplete="off">
                          </td>

                          <input type="hidden" name="satuan_value[]" id="satuan_<?php echo $x; ?>" value="<?php echo $val['satuan'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="store[]" value="<?php echo $val['store'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="store_id[]" value="<?php echo $val['store_id'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="user_id[]" value="<?php echo $val['user_id'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="baca[]" class="form-control" value="0" autocomplete="off">
                          </td>
                          <td>
                            <input type="number" readonly name="qtydeliv[]" step="any" id="qtydeliv_<?php echo $x; ?>" class="form-control" value="<?php echo $val['qtydeliv'] ?>" autocomplete="off">
                          </td>
                          <td style="<?php

                                      if ($val['qtyarv'] == NULL) {
                                        echo 'background: #ff000024;';
                                      } else {
                                        if ($val['qtydeliv'] == $val['qtyarv']) {
                                          echo 'background: #4caf5059;';
                                        } else {
                                          echo 'background: #f39c123d;';
                                        };
                                      }
                                      ?>">
                            <input type="number" <?php if ($order_data['order']['status_up'] == 1) {
                                                    echo 'readonly';
                                                  } ?> name="qtyarv[]" step="any" id="qtyarv_<?php echo $x; ?>" required onkeyup="getTotal(<?php echo $x; ?>)" class="form-control" value="<?php

                                                                                                                                                                                            if ($val['qtyarv'] == NULL) {
                                                                                                                                                                                              echo $val['qtydeliv'];
                                                                                                                                                                                            } else {
                                                                                                                                                                                              if ($val['qtydeliv'] == $val['qtyarv']) {
                                                                                                                                                                                                echo $val['qtyarv'];
                                                                                                                                                                                              } else {
                                                                                                                                                                                                echo $val['qtyarv'];
                                                                                                                                                                                              };
                                                                                                                                                                                            }
                                                                                                                                                                                            ?>" autocomplete="off">
                          </td>

                          <?php if (!$order_data['order']['status_up'] == 1) { ?>
                            <td style="<?php
                                        if ($val['qtyarv'] == NULL) {
                                          echo 'background: #ff000024;';
                                        } else {
                                          if ($val['qtydeliv'] == $val['qtyarv']) {
                                            echo 'background: #4caf5059;';
                                          } else {
                                            echo 'background: #f39c123d;';
                                          };
                                        }
                                        ?>">
                              <Center> <?php
                                        if ($val['qtyarv'] == NULL) {
                                          echo '<span class="label label-danger" > Belum Terisi</span>';
                                        } else {
                                          if ($val['qtydeliv'] == $val['qtyarv']) {
                                            echo ' <span class="label label-success" > Sukses</span>';
                                          } else {
                                            echo ' <span class="label label-warning" > Berbeda</span>';
                                          };
                                        }
                                        ?></Center>

                            </td>
                          <?php } ?>


                          <input type="hidden" name="rate_value[]" id="rate_value_<?php echo $x; ?>" class="form-control" value="<?php echo $val['rate'] ?>" autocomplete="off">
                          <input type="hidden" name="amount_value[]" id="amount_value_<?php echo $x; ?>" class="form-control" value="<?php echo $val['amount'] ?>" autocomplete="off">
                        </tr>
                        <?php $x++; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>

                <br /> <br />

                <div class="col-md-6 col-xs-12 pull pull-right">

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label">Jumlah Berdasarkan Qty Deliv</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled value="<?php echo $order_data['order']['gross_amount'] ?>" autocomplete="off">
                      <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" value="<?php echo $order_data['order']['gross_amount'] ?>" autocomplete="off">
                    </div>
                  </div>
                  <?php if ($is_service_enabled == true) : ?>
                    <div class="form-group">
                      <label for="service_charge" class="col-sm-5 control-label">S-Charge <?php echo $company_data['service_charge_value'] ?> %</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" id="service_charge" name="service_charge" disabled value="<?php echo $order_data['order']['service_charge'] ?>" autocomplete="off">
                        <input type="hidden" class="form-control" id="service_charge_value" name="service_charge_value" value="<?php echo $order_data['order']['service_charge'] ?>" autocomplete="off">
                      </div>
                    </div>
                  <?php endif; ?>
                  <?php if ($is_vat_enabled == true) : ?>
                    <div class="form-group">
                      <label for="vat_charge" class="col-sm-5 control-label">Vat <?php echo $company_data['vat_charge_value'] ?> %</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control" id="vat_charge" name="vat_charge" disabled value="<?php echo $order_data['order']['vat_charge'] ?>" autocomplete="off">
                        <input type="hidden" class="form-control" id="vat_charge_value" name="vat_charge_value" value="<?php echo $order_data['order']['vat_charge'] ?>" autocomplete="off">
                      </div>
                    </div>
                  <?php endif; ?>




                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">

                <input type="hidden" name="service_charge_rate" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
                <input type="hidden" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
                <?php if ($order_data['order']['status_up'] == 1) {
                  echo '<h2><b>Produk Telah dibekukan</b></h2>';
                } else {
                  echo '<button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>';
                } ?>

              </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->


    </section>
    <!-- /.content -->
  </div>
  <script type="text/javascript">
    $("#mainOrdersNav").addClass('active');
    $("#manageOrdersNav").addClass('active');
  </script>


<?php

endif;
?>