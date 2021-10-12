<?php if ($this->session->flashdata('success')) :
  echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
?>
<?php elseif ($this->session->flashdata('error')) :
  echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
?>
<?php endif; ?>

<?php

$div = $this->session->userdata['divisi'];
$store_id = $this->session->userdata['store_id'];

if (isset($order_data['order_item'])) {
  $od = $order_data['order_item'];
  foreach ($od as $key => $value) {
    $arv[] = $value['qtyarv'];
  }
  $dt = json_encode($arv);
  $dp = str_replace('[',  '',  $dt);
  $dk = str_replace('"",',  '',  $dp);
  $orderan = str_replace('""]',  '',  $dk);
} else {
  $orderan = '';
}

if ($store_id == 1) :
?>

  <!-- Edit Untuk Logistik -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
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

          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><b><i class="fa fa-shopping-cart"></i> EDIT ORDER <?= $order_data['order']['bill_no'] ?> BY LOGISTIK</b></h3>

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

                <div class="form-group">
                  <label for="date" class="col-sm-12 control-label">No Bill: <?= $order_data['order']['bill_no'] ?></label>
                </div>

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
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Tgl Pemesanan</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($order_data['order']['tgl_pesan'])) ?>" autocomplete="off" readonly name="tgl_order">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Tgl Laporan</label>
                    <div class="col-sm-7">
                      <input type="date" name="tgl_lap" <?php if ($order_data['order']['status_up'] == 1) {
                                                          echo "readonly";
                                                        } ?> value="<?php echo date('Y-m-d', $order_data['order']['date_time']) ?>" required class="form-control" autocomplete="off">
                    </div>
                  </div>

                </div>


                <br /> <br />
                <table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
                  <thead>
                    <tr>
                      <th style="width:50%;min-width:200px;text-align: center;">Produk</th>
                      <th style="width:10%;min-width:70px;text-align: center;">Qty Order</th>
                      <th style="width:10%;min-width:70px;text-align: center;">Qty Deliv</th>
                      <?php
                      if ($orderan) : ?>
                        <th style="width:10%;min-width:70px;text-align: center;">Qty Arv</th>
                      <?php endif; ?>
                      <th style="width:10%;min-width:100px;text-align: center;">Hrg/1</th>
                      <th style="width:20%;min-width:100px;text-align: center;">Jumlah</th>
                      <?php if (!$order_data['order']['status_up'] == 1) : ?>
                        <th style="width:10%"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th>
                      <?php endif; ?>
                    </tr>
                  </thead>

                  <tbody>

                    <?php if (isset($order_data['order_item'])) : ?>
                      <?php $x = 1; ?>
                      <?php foreach ($order_data['order_item'] as $key => $val) : ?>
                        <tr id="row_<?php echo $x; ?>" style="<?php if ($val['qtyarv'] == NULL) {
                                                                echo '';
                                                              } else {
                                                                if ($val['qtydeliv'] == $val['qtyarv']) {
                                                                  echo 'background: #4caf5059;';
                                                                } else {
                                                                  echo 'background: #f39c123d;';
                                                                };
                                                              } ?>">
                          <td>
                            <select disabled class="form-control select_group product" data-row-id="row_<?php echo $x; ?>" id="product_<?php echo $x; ?>" name="product[]" style="width:100%;" onchange="getProductData(<?php echo $x; ?>)" required>
                              <option selected="true" value="" disabled="disabled">-- Pilih Produk --</option>
                              <?php foreach ($products as $k => $v) : ?>
                                <option value="<?php echo $v['id'] ?>" <?php if ($val['product_id'] == $v['id']) {
                                                                          echo "selected='selected'";
                                                                        } ?>><?php echo $v['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                            <select data-row-id="row_<?php echo $x; ?>" id="product_<?php echo $x; ?>" name="product[]" style="width:100%; display: none;" onchange="getProductData(<?php echo $x; ?>)" required>
                              <option selected="true" value="" disabled="disabled">-- Pilih Produk --</option>
                              <?php foreach ($products as $k => $v) : ?>
                                <option value="<?php echo $v['id'] ?>" <?php if ($val['product_id'] == $v['id']) {
                                                                          echo "selected='selected'";
                                                                        } ?>><?php echo $v['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td><input type="text" name="qty[]" id="qty_<?php echo $x; ?>" class="form-control" required onkeyup="getTotal(<?php echo $x; ?>)" value="<?php echo $val['qty'] ?>/<?php echo $val['satuan'] ?>" disabled autocomplete="off">
                            <input type="hidden" name="qty[]" id="qty_<?php echo $x; ?>" class="form-control" required onkeyup="getTotal(<?php echo $x; ?>)" value="<?php echo $val['qty'] ?>" autocomplete="off">
                          </td>

                          <input type="hidden" name="satuan_value[]" id="satuan_<?php echo $x; ?>" value="<?php echo $val['satuan'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="store[]" value="<?php echo $val['store'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="store_id[]" value="<?php echo $val['store_id'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="user_id[]" value="<?php echo $val['user_id'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="baca[]" class="form-control" value="0" autocomplete="off">
                          <input type="hidden" name="status_up[]" class="form-control" value="<?php echo $val['status_up'] ?>" autocomplete="off">
                          <input type="hidden" name="arv[]" class="form-control" value="<?php echo $val['qtyarv'] ?>" autocomplete="off">
                          </td>
                          <td>
                            <input type="number" <?php if ($val['status_up'] == 1) {
                                                    echo "readonly";
                                                  } ?> name="qtydeliv[]" step="any" id="qtydeliv_<?php echo $x; ?>" required onkeyup="getTotal(<?php echo $x; ?>)" class="form-control" value="<?php echo $val['qtydeliv'] ?>" autocomplete="off">
                          </td>

                          <?php
                          if ($orderan) : ?>
                            <td>
                              <input type="number" readonly class="form-control" value="<?php echo $val['qtyarv'] ?>" autocomplete="off">
                            </td>
                          <?php endif; ?>

                          <td>

                            <input type="text" name="rate[]" id="rate_<?php echo $x; ?>" class="form-control" disabled value="<?php echo $val['rate'] ?>" autocomplete="off">
                            <input type="hidden" name="rate_value[]" id="rate_value_<?php echo $x; ?>" class="form-control" value="<?php echo $val['rate'] ?>" autocomplete="off">
                          </td>
                          <td>
                            <input type="text" name="amount[]" id="amount_<?php echo $x; ?>" class="form-control" disabled value="<?php echo $val['amount'] ?>" autocomplete="off">
                            <input type="hidden" name="amount_value[]" id="amount_value_<?php echo $x; ?>" class="form-control" value="<?php echo $val['amount'] ?>" autocomplete="off">
                          </td>
                          <?php if (!$order_data['order']['status_up'] == 1) : ?>
                            <td><button type="button" class="btn btn-default" onclick="removeRow('<?php echo $x; ?>')"><i class="fa fa-close"></i></button></td>
                          <?php endif; ?>
                        </tr>
                        <?php $x++; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>

                <br /> <br />

                <div class="col-md-6 col-xs-12 pull pull-right">

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label">Jumlah Gross</label>
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
                  <div class="form-group">
                    <label for="discount" class="col-sm-5 control-label">Discount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount" onkeyup="subAmount()" value="<?php echo $order_data['order']['discount'] ?>" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="net_amount" class="col-sm-5 control-label">Jumlah Total</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="net_amount" name="net_amount" disabled value="<?php echo $order_data['order']['net_amount'] ?>" autocomplete="off">
                      <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value" value="<?php echo $order_data['order']['net_amount'] ?>" autocomplete="off">
                    </div>
                  </div>



                  <div class="form-group">
                    <label for="net_amount" class="col-sm-5 control-label">Status Paid</label>
                    <div class="col-sm-7">
                      <?php if ($orderdata['paid_status'] == '1') {
                        echo '<div class="btn btn-success"><i class="fa fa-money"></i> Paid </div>';
                      } ?> <?php if ($orderdata['paid_status'] == '0') {
                              echo '<div class="btn btn-danger"><i class="fa fa-money"></i> Unpaid </div>';
                            } ?>
                    </div>
                  </div>


                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">

                <input type="hidden" name="service_charge_rate" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
                <input type="hidden" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">


                <a onclick="receipt('<?= $order_data['order']['id'] ?>')" href="#" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                <?php if ($order_data['order']['status_up'] == 1) {
                  echo '';
                } else {
                  echo '<button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>';
                } ?>
                <?php if ($orderdata['paid_status'] == '0') {
                  echo '<a href="' . base_url() . 'orders/paid/' . $order_data['order']['id'] . '" class="btn btn-success"><i class="fa fa-money"></i> Paid </a>';
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
    var product_info_table;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function() {
      $(".select_group").select2();
      $("#description").wysihtml5();

      $("#mainOrdersNav").addClass('active');
      $("#manageOrdersNav").addClass('active');


      // Add new row in the table 
      $("#add_row").unbind('click').bind('click', function() {
        var table = $("#product_info_table");
        var count_table_tbody_tr = $("#product_info_table tbody tr").length;
        var row_id = count_table_tbody_tr + 1;
        var tambah = $('#add_row');

        $.ajax({
          url: base_url + '/orders/getTableProductRow/',
          type: 'post',
          dataType: 'json',
          beforeSend: function() {
            tambah.attr('disabled', 'disabled');
          },
          success: function(response) {
            tambah.attr('disabled', false);


            // console.log(reponse.x);
            var html = '<tr id="row_' + row_id + '">' +
              '<td>' +
              '<select class="form-control select_group product" data-row-id="' + row_id + '" id="product_' + row_id + '" name="product[]" style="width:100%;" onchange="getProductData(' + row_id + ')">' +
              '<option selected="true" value="" disabled="disabled">-- Pilih Produk --</option>';
            $.each(response, function(index, value) {
              html += '<option value="' + value.id + '">' + value.name + ' / ' + value.satuan + '</option>';
            });

            html += '</select>' +
              '</td>' +
              '<input type="hidden" name="store[]" value="<?php echo $val['store'] ?>" class="form-control" autocomplete="off"><input type="hidden" name="store_id[]" value="<?php echo $val['store_id'] ?>" class="form-control" autocomplete="off"><input type="hidden" name="user_id[]" value="<?php echo $val['user_id'] ?>" class="form-control" autocomplete="off"><input type="hidden" name="status_up[]"   class="form-control" value="<?php echo $val['status_up'] ?>" autocomplete="off"><input type="hidden" name="arv[]" class="form-control" value="<?php echo $val['qtyarv'] ?>" autocomplete="off">' +
              '<td><input type="number" disabled class="form-control" ><input type="hidden" name="baca[]"   class="form-control" value="0" autocomplete="off"></td>' +
              '<input type="hidden" name="qty[]"  step="any" value="0" class="form-control" autocomplete="off">' +
              '<td><input type="number" name="qtydeliv[]"  step="any" id="qtydeliv_' + row_id + '" required onkeyup="getTotal(' + row_id + ')" class="form-control" autocomplete="off"></td>' +

              <?php if ($orderan) : ?> '<td><input type="number"  readonly class="form-control" autocomplete="off"></td>' +

              <?php endif; ?> '<td><input type="text" name="rate[]" id="rate_' + row_id + '" class="form-control" disabled><input type="hidden" name="rate_value[]" id="rate_value_' + row_id + '" class="form-control"></td>' +
              '<td><input type="text" name="amount[]" id="amount_' + row_id + '" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_' + row_id + '" class="form-control"></td>' +
              '<td><button type="button" class="btn btn-default" onclick="removeRow(\'' + row_id + '\')"><i class="fa fa-close"></i></button></td>' +
              '</tr>';

            if (count_table_tbody_tr >= 1) {
              $("#product_info_table tbody tr:last").after(html);
            } else {
              $("#product_info_table tbody").html(html);
            }

            $(".product").select2();

          }
        });

        return false;
      });

    }); // /document

    function getTotal(row = null) {
      if (row) {
        var total = Number($("#rate_value_" + row).val()) * Number($("#qtydeliv_" + row).val());
        total = total.toFixed(0);
        $("#amount_" + row).val(total);
        $("#amount_value_" + row).val(total);

        subAmount();

      } else {
        alert('no row !! please refresh the page');
      }
    }

    // get the product information from the server
    function getProductData(row_id) {
      var product_id = $("#product_" + row_id).val();
      if (product_id == "") {
        $("#rate_" + row_id).val("");
        $("#rate_value_" + row_id).val("");

        $("#qty_" + row_id).val("");

        $("#qtydeliv_" + row_id).val("");

        $("#amount_" + row_id).val("");
        $("#amount_value_" + row_id).val("");

      } else {
        $.ajax({
          url: base_url + 'orders/getProductValueById',
          type: 'post',
          data: {
            product_id: product_id
          },
          dataType: 'json',
          success: function(response) {
            // setting the rate value into the rate input field

            $("#rate_" + row_id).val(response.price);
            $("#rate_value_" + row_id).val(response.price);

            $("#qty_" + row_id).val(1);
            $("#qty_value_" + row_id).val(1);


            $("#qtydeliv_" + row_id).val(1);

            var total = Number(response.price) * 1;
            total = total.toFixed(0);
            $("#amount_" + row_id).val(total);
            $("#amount_value_" + row_id).val(total);

            subAmount();
          } // /success
        }); // /ajax function to fetch the product data 
      }
    }

    // calculate the total amount of the order
    function subAmount() {
      var service_charge = <?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value'] : 0; ?>;
      var vat_charge = <?php echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value'] : 0; ?>;

      var tableProductLength = $("#product_info_table tbody tr").length;
      var totalSubAmount = 0;
      for (x = 0; x < tableProductLength; x++) {
        var tr = $("#product_info_table tbody tr")[x];
        var count = $(tr).attr('id');
        count = count.substring(4);

        totalSubAmount = Number(totalSubAmount) + Number($("#amount_" + count).val());
      } // /for

      totalSubAmount = totalSubAmount.toFixed(0);

      // sub total
      $("#gross_amount").val(totalSubAmount);
      $("#gross_amount_value").val(totalSubAmount);

      // vat
      var vat = (Number($("#gross_amount").val()) / 100) * vat_charge;
      vat = vat.toFixed(0);
      $("#vat_charge").val(vat);
      $("#vat_charge_value").val(vat);

      // service
      var service = (Number($("#gross_amount").val()) / 100) * service_charge;
      service = service.toFixed(0);
      $("#service_charge").val(service);
      $("#service_charge_value").val(service);

      // total amount
      var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
      totalAmount = totalAmount.toFixed(0);
      // $("#net_amount").val(totalAmount);
      // $("#totalAmountValue").val(totalAmount);

      var discount = $("#discount").val();
      if (discount) {
        var grandTotal = Number(totalAmount) - Number(discount);
        grandTotal = grandTotal.toFixed(0);
        $("#net_amount").val(grandTotal);
        $("#net_amount_value").val(grandTotal);
      } else {
        $("#net_amount").val(totalAmount);
        $("#net_amount_value").val(totalAmount);

      } // /else discount 

      var paid_amount = Number($("#paid_amount").val());
      if (paid_amount) {
        var net_amount_value = Number($("#net_amount_value").val());
        var remaning = net_amount_value - paid_amount;
        $("#remaining").val(remaning.toFixed(0));
        $("#remaining_value").val(remaning.toFixed(0));
      }

    } // /sub total amount

    function paidAmount() {
      var grandTotal = $("#net_amount_value").val();

      if (grandTotal) {
        var dueAmount = Number($("#net_amount_value").val()) - Number($("#paid_amount").val());
        dueAmount = dueAmount.toFixed(0);
        $("#remaining").val(dueAmount);
        $("#remaining_value").val(dueAmount);
      } // /if
    } // /paid amoutn function

    function removeRow(tr_id) {
      Swal.fire({
        title: 'Yakin Ingin Menghapus?',
        text: "Produk yang di pesan akan terhapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.isConfirmed) {
          $("#product_info_table tbody tr#row_" + tr_id).remove();
          subAmount();
          Swal.fire(
            'Deleted!',
            'Produk Pesanan Terhapus, Simpan Untuk Menetapkan',
            'success'
          )
        }
      })

    }
  </script>


  <?php
endif;

if ($div > 0) :

  if ($sekarang > $mulai or $sekarang < $sampai) :
    if (isset($order_data['order_item'])) {
      $qtyorderdeliv = $order_data['order_item']['0']['qtydeliv'];
    } else {
      $qtyorderdeliv = '';
      $this->session->set_flashdata('error', 'Maaf..! Data tidak ditemukan');
      redirect('orders/', 'refresh');
    }
    if ($qtyorderdeliv == '') :
      if ($order_data['order']['store'] == 'LOGISTIK PRS') {
        $this->session->set_flashdata('error', 'Maaf..! Data dibuat oleh logistik tidak bisa diedit');
        redirect('orders/', 'refresh');
      }
  ?>

      <!-- Edit Untuk Outlet -->

      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Manage
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

              <div class="box box-danger box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><b><i class="fa fa-shopping-cart"></i> EDIT ORDER <?= $order_data['order']['bill_no'] ?></b></h3>

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

                    <div class="form-group">
                      <label for="date" class="col-sm-12 control-label">No Bill: <?= $order_data['order']['bill_no'] ?></label>
                    </div>

                    <div class="col-md-4 col-xs-12 pull pull-left">

                      <div class="form-group">
                        <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Nama Penerima</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Nama Pengorder" value="<?php echo $order_data['order']['customer_name'] ?>" autocomplete="off" />
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Outlet</label>
                        <div class="col-sm-7">

                          <input type="text" readonly class="form-control" id="customer_address" name="customer_address" placeholder="<?php echo $order_data['order']['customer_address'] ?>" autocomplete="off" value="<?php echo $order_data['order']['customer_address'] ?>">

                        </div>
                      </div>

                      <div class="form-group">
                        <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">No Hp</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="No Hp Pengorder" value="<?php echo $order_data['order']['customer_phone'] ?>" autocomplete="off">
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Tanggal Pemesanan</label>
                        <div class="col-sm-7">
                          <input type="text" readonly name="tgl_order" value="<?php echo date($order_data['order']['tgl_pesan']) ?>" required class="form-control" autocomplete="off">
                          <input type="hidden" name="tgl_lap" value="<?php echo $order_data['order']['date_time'] ?>">
                        </div>
                      </div>

                    </div>


                    <br /> <br />
                    <table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
                      <thead>
                        <tr>
                          <th style="width:50%;min-width:200px;text-align: center;">Produk</th>
                          <th style="width:10%;min-width:70px;text-align: center;">Qty Order</th>
                          <th style="width:10%;min-width:100px;text-align: center;">Hrg/1</th>
                          <th style="width:20%;min-width:100px;text-align: center;">Jumlah</th>
                          <?php if (!$order_data['order']['status_up'] == 1) : ?>
                            <th style="width:3%;"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th>
                          <?php endif; ?>
                        </tr>
                      </thead>


                      <tbody>

                        <?php if (isset($order_data['order_item'])) : ?>
                          <?php $x = 1; ?>
                          <?php foreach ($order_data['order_item'] as $key => $val) : ?>

                            <input type="hidden" name="satuan_value[]" id="satuan_<?php echo $x; ?>" value="<?php echo $val['satuan'] ?>" class="form-control" autocomplete="off">
                            <input type="hidden" name="store[]" value="<?php echo $val['store'] ?>" class="form-control" autocomplete="off">
                            <input type="hidden" name="store_id[]" value="<?php echo $val['store_id'] ?>" class="form-control" autocomplete="off">
                            <input type="hidden" name="qtydeliv[]" class="form-control" value="" autocomplete="off">
                            <input type="hidden" name="baca[]" class="form-control" value="1" autocomplete="off">
                            <input type="hidden" name="status_up[]" class="form-control" value="<?php echo $val['status_up'] ?>" autocomplete="off">
                            <input type="hidden" name="arv[]" class="form-control" value="<?php echo $val['qtyarv'] ?>" autocomplete="off">
                            <tr id="row_<?php echo $x; ?>">
                              <td>
                                <select class="form-control select_group product" data-row-id="row_<?php echo $x; ?>" id="product_<?php echo $x; ?>" name="product[]" style="width:100%;" onchange="getProductData(<?php echo $x; ?>)" required>
                                  <option selected="true" value="" disabled="disabled">-- Pilih Produk --</option>
                                  <?php foreach ($products as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>" <?php if ($val['product_id'] == $v['id']) {
                                                                              echo "selected='selected'";
                                                                            } ?>><?php echo $v['name'] . ' / ' . $v['satuan'] ?></option>
                                  <?php endforeach ?>
                                </select>
                              </td>
                              <td><input type="number" name="qty[]" step="any" id="qty_<?php echo $x; ?>" class="form-control" required onkeyup="getTotal(<?php echo $x; ?>)" value="<?php echo $val['qty'] ?>" autocomplete="off"></td>
                              <td>
                                <input type="text" name="rate[]" id="rate_<?php echo $x; ?>" class="form-control" disabled value="<?php echo $val['rate'] ?>" autocomplete="off">
                                <input type="hidden" name="rate_value[]" id="rate_value_<?php echo $x; ?>" class="form-control" value="<?php echo $val['rate'] ?>" autocomplete="off">
                              </td>
                              <td>
                                <input type="text" name="amount[]" id="amount_<?php echo $x; ?>" class="form-control" disabled value="<?php echo $val['amount'] ?>" autocomplete="off">
                                <input type="hidden" name="amount_value[]" id="amount_value_<?php echo $x; ?>" class="form-control" value="<?php echo $val['amount'] ?>" autocomplete="off">
                              </td>
                              <?php if (!$order_data['order']['status_up'] == 1) : ?>
                                <td><button type="button" class="btn btn-default" onclick="removeRow('<?php echo $x; ?>')"><i class="fa fa-close"></i></button></td>
                              <?php endif; ?>
                            </tr>

                            </tr>
                            <?php $x++; ?>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </tbody>
                    </table>

                    <br /> <br />

                    <div class="col-md-6 col-xs-12 pull pull-right">
                      <div class="form-group">
                        <label for="gross_amount" class="col-sm-5 control-label">Jumlah Total</label>
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
                      <input type="hidden" class="form-control" id="discount" name="discount" placeholder="Discount" onkeyup="subAmount()" value="<?php echo $order_data['order']['discount'] ?>" autocomplete="off">
                      <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value" value="<?php echo $order_data['order']['net_amount'] ?>" autocomplete="off">



                      <div class="form-group">
                        <label for="net_amount" class="col-sm-5 control-label">Status Paid</label>
                        <div class="col-sm-7">
                          <?php if ($orderdata['paid_status'] == '1') {
                            echo '<div class="btn btn-success"><i class="fa fa-money"></i> Paid </div>';
                          } ?> <?php if ($orderdata['paid_status'] == '0') {
                                  echo '<div class="btn btn-danger"><i class="fa fa-money"></i> Unpaid </div>';
                                } ?>
                        </div>
                      </div>


                    </div>
                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">

                    <input type="hidden" name="service_charge_rate" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
                    <input type="hidden" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">


                    <a onclick="receipt('<?= $order_data['order']['id'] ?>')" href="#" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                    <?php if ($order_data['order']['status_up'] == 1) {
                      echo '';
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
        var product_info_table;
        var base_url = "<?php echo base_url(); ?>";

        $(document).ready(function() {
          $(".select_group").select2();
          // $("#description").wysihtml5();

          $("#mainOrdersNav").addClass('active');
          $("#manageOrdersNav").addClass('active');


          // Add new row in the table 
          $("#add_row").unbind('click').bind('click', function() {
            var table = $("#product_info_table");
            var count_table_tbody_tr = $("#product_info_table tbody tr").length;
            var row_id = count_table_tbody_tr + 1;
            var tambah = $('#add_row');

            $.ajax({
              url: base_url + '/orders/getTableProductRow/',
              type: 'post',
              dataType: 'json',
              beforeSend: function() {
                tambah.attr('disabled', 'disabled');
              },
              success: function(response) {
                tambah.attr('disabled', false);


                // console.log(reponse.x);
                var html = '<tr id="row_' + row_id + '">' +
                  '<td>' +
                  '<select class="form-control select_group product" data-row-id="' + row_id + '" id="product_' + row_id + '" name="product[]" style="width:100%;" onchange="getProductData(' + row_id + ')" required>' +
                  '<option selected="true" value="" disabled="disabled">-- Pilih Produk --</option>';
                $.each(response, function(index, value) {
                  html += '<option value="' + value.id + '">' + value.name + ' / ' + value.satuan + '</option>';
                });

                html += '</select>' +
                  '</td>' +
                  '<input type="hidden" name="store[]" value="<?php echo $val['store'] ?>" class="form-control" autocomplete="off"><input type="hidden" name="store_id[]" value="<?php echo $val['store_id'] ?>" class="form-control" autocomplete="off"><input type="hidden" name="baca[]"   class="form-control" value="1" autocomplete="off"><input type="hidden" name="status_up[]"   class="form-control" value="<?php echo $val['status_up'] ?>" autocomplete="off"><input type="hidden" name="qtydeliv[]"  class="form-control" value="" autocomplete="off"><td><input type="number" name="qty[]" step="any" id="qty_' + row_id + '" class="form-control" onkeyup="getTotal(' + row_id + ')"><input type="hidden" name="arv[]" class="form-control" value="<?php echo $val['qtyarv'] ?>" autocomplete="off"></td>' +
                  '<td><input type="text" name="rate[]" id="rate_' + row_id + '" class="form-control" disabled><input type="hidden" name="rate_value[]" id="rate_value_' + row_id + '" class="form-control"></td>' +
                  '<td><input type="text" name="amount[]" id="amount_' + row_id + '" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_' + row_id + '" class="form-control"></td>' +
                  '<td><button type="button" class="btn btn-default" onclick="removeRow(\'' + row_id + '\')"><i class="fa fa-close"></i></button></td>' +
                  '</tr>';

                if (count_table_tbody_tr >= 1) {
                  $("#product_info_table tbody tr:last").after(html);
                } else {
                  $("#product_info_table tbody").html(html);
                }

                $(".product").select2();

              }
            });

            return false;
          });

        }); // /document

        function getTotal(row = null) {
          if (row) {
            var total = Number($("#rate_value_" + row).val()) * Number($("#qty_" + row).val());
            total = total.toFixed(0);
            $("#amount_" + row).val(total);
            $("#amount_value_" + row).val(total);

            subAmount();

          } else {
            alert('no row !! please refresh the page');
          }
        }

        // get the product information from the server
        function getProductData(row_id) {
          var product_id = $("#product_" + row_id).val();
          if (product_id == "") {
            $("#rate_" + row_id).val("");
            $("#rate_value_" + row_id).val("");

            $("#qty_" + row_id).val("");

            $("#amount_" + row_id).val("");
            $("#amount_value_" + row_id).val("");

          } else {
            $.ajax({
              url: base_url + 'orders/getProductValueById',
              type: 'post',
              data: {
                product_id: product_id
              },
              dataType: 'json',
              success: function(response) {
                // setting the rate value into the rate input field


                $("#rate_" + row_id).val(response.price);
                $("#rate_value_" + row_id).val(response.price);

                $("#qty_" + row_id).val(1);
                $("#qty_value_" + row_id).val(1);

                var total = Number(response.price) * 1;
                total = total.toFixed(0);
                $("#amount_" + row_id).val(total);
                $("#amount_value_" + row_id).val(total);

                subAmount();
              } // /success
            }); // /ajax function to fetch the product data 
          }
        }

        // calculate the total amount of the order
        function subAmount() {
          var service_charge = <?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value'] : 0; ?>;
          var vat_charge = <?php echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value'] : 0; ?>;

          var tableProductLength = $("#product_info_table tbody tr").length;
          var totalSubAmount = 0;
          for (x = 0; x < tableProductLength; x++) {
            var tr = $("#product_info_table tbody tr")[x];
            var count = $(tr).attr('id');
            count = count.substring(4);

            totalSubAmount = Number(totalSubAmount) + Number($("#amount_" + count).val());
          } // /for

          totalSubAmount = totalSubAmount.toFixed(0);

          // sub total
          $("#gross_amount").val(totalSubAmount);
          $("#gross_amount_value").val(totalSubAmount);

          // vat
          var vat = (Number($("#gross_amount").val()) / 100) * vat_charge;
          vat = vat.toFixed(0);
          $("#vat_charge").val(vat);
          $("#vat_charge_value").val(vat);

          // service
          var service = (Number($("#gross_amount").val()) / 100) * service_charge;
          service = service.toFixed(0);
          $("#service_charge").val(service);
          $("#service_charge_value").val(service);

          // total amount
          var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
          totalAmount = totalAmount.toFixed(0);
          // $("#net_amount").val(totalAmount);
          // $("#totalAmountValue").val(totalAmount);

          var discount = $("#discount").val();
          if (discount) {
            var grandTotal = Number(totalAmount) - Number(discount);
            grandTotal = grandTotal.toFixed(0);
            $("#net_amount").val(grandTotal);
            $("#net_amount_value").val(grandTotal);
          } else {
            $("#net_amount").val(totalAmount);
            $("#net_amount_value").val(totalAmount);

          } // /else discount 

          var paid_amount = Number($("#paid_amount").val());
          if (paid_amount) {
            var net_amount_value = Number($("#net_amount_value").val());
            var remaning = net_amount_value - paid_amount;
            $("#remaining").val(remaning.toFixed(0));
            $("#remaining_value").val(remaning.toFixed(0));
          }

        } // /sub total amount

        function paidAmount() {
          var grandTotal = $("#net_amount_value").val();

          if (grandTotal) {
            var dueAmount = Number($("#net_amount_value").val()) - Number($("#paid_amount").val());
            dueAmount = dueAmount.toFixed(0);
            $("#remaining").val(dueAmount);
            $("#remaining_value").val(dueAmount);
          } // /if
        } // /paid amoutn function


        function removeRow(tr_id) {
          Swal.fire({
            title: 'Yakin Ingin Menghapus?',
            text: "Produk yang di pesan akan terhapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
          }).then((result) => {
            if (result.isConfirmed) {
              $("#product_info_table tbody tr#row_" + tr_id).remove();
              subAmount();
              Swal.fire(
                'Deleted!',
                'Produk Pesanan Terhapus, Simpan Untuk Menetapkan',
                'success'
              )
            }
          })

        }
      </script>
  <?php
    else :
      $this->session->set_flashdata('error', 'Maaf..! Data Anda Telah di proses oleh Logistik, tidak dapat di ubah');
      redirect('orders/', 'refresh');
    endif;
  else :
    $this->session->set_flashdata('error', 'Maaf..! Anda tidak bisa ubah orderan, Jam Order telah habis, silakan hub admin Logistik');
    redirect('orders/', 'refresh');
  endif;
  ?>
<?php endif; ?>




<?php
if ($store_id > 1 && $div == 0) :
?>

  <!-- Edit Untuk Logistik -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
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

          <div class="box box-warning box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><b><i class="fa fa-shopping-cart"></i> CEK ORDER <?= $order_data['order']['bill_no'] ?></b></h3>

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

                <div class="form-group">
                  <label for="date" class="col-sm-12 control-label">No Bill: <?= $order_data['order']['bill_no'] ?></label>
                </div>

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
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Tgl Pemesanan</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($order_data['order']['tgl_pesan'])) ?>" autocomplete="off" readonly name="tgl_order">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Tgl Laporan</label>
                    <div class="col-sm-7">
                      <input type="date" name="tgl_lap" <?php if ($order_data['order']['status_up'] == 1) {
                                                          echo "readonly";
                                                        } ?> value="<?php echo date('Y-m-d', $order_data['order']['date_time']) ?>" required class="form-control" autocomplete="off">
                    </div>
                  </div>

                </div>


                <br /> <br />
                <table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
                  <thead>
                    <tr>
                      <th style="width:50%;min-width:200px;text-align: center;">Produk</th>
                      <th style="width:10%;min-width:70px;text-align: center;">Qty Order</th>
                      <th style="width:10%;min-width:70px;text-align: center;">Qty Deliv</th>
                      <?php
                      if ($orderan) : ?>
                        <th style="width:10%;min-width:70px;text-align: center;">Qty Arv</th>
                      <?php endif; ?>
                      <th style="width:10%;min-width:100px;text-align: center;">Hrg/1</th>
                      <th style="width:20%;min-width:100px;text-align: center;">Jumlah</th>
                    </tr>
                  </thead>

                  <tbody>

                    <?php if (isset($order_data['order_item'])) : ?>
                      <?php $x = 1; ?>
                      <?php foreach ($order_data['order_item'] as $key => $val) : ?>
                        <tr id="row_<?php echo $x; ?>" style="<?php if ($val['qtyarv'] == NULL) {
                                                                echo '';
                                                              } else {
                                                                if ($val['qtydeliv'] == $val['qtyarv']) {
                                                                  echo 'background: #4caf5059;';
                                                                } else {
                                                                  echo 'background: #f39c123d;';
                                                                };
                                                              } ?>">
                          <td>
                            <select disabled class="form-control select_group product" data-row-id="row_<?php echo $x; ?>" id="product_<?php echo $x; ?>" name="product[]" style="width:100%;" onchange="getProductData(<?php echo $x; ?>)" required>
                              <option selected="true" value="" disabled="disabled">-- Pilih Produk --</option>
                              <?php foreach ($products as $k => $v) : ?>
                                <option value="<?php echo $v['id'] ?>" <?php if ($val['product_id'] == $v['id']) {
                                                                          echo "selected='selected'";
                                                                        } ?>><?php echo $v['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                            <select data-row-id="row_<?php echo $x; ?>" id="product_<?php echo $x; ?>" name="product[]" style="width:100%; display: none;" onchange="getProductData(<?php echo $x; ?>)" required>
                              <option selected="true" value="" disabled="disabled">-- Pilih Produk --</option>
                              <?php foreach ($products as $k => $v) : ?>
                                <option value="<?php echo $v['id'] ?>" <?php if ($val['product_id'] == $v['id']) {
                                                                          echo "selected='selected'";
                                                                        } ?>><?php echo $v['name'] ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td><input type="text" name="qty[]" id="qty_<?php echo $x; ?>" class="form-control" required onkeyup="getTotal(<?php echo $x; ?>)" value="<?php echo $val['qty'] ?>/<?php echo $val['satuan'] ?>" disabled autocomplete="off">
                            <input type="hidden" name="qty[]" id="qty_<?php echo $x; ?>" class="form-control" required onkeyup="getTotal(<?php echo $x; ?>)" value="<?php echo $val['qty'] ?>" autocomplete="off">
                          </td>

                          <input type="hidden" name="satuan_value[]" id="satuan_<?php echo $x; ?>" value="<?php echo $val['satuan'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="store[]" value="<?php echo $val['store'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="store_id[]" value="<?php echo $val['store_id'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="user_id[]" value="<?php echo $val['user_id'] ?>" class="form-control" autocomplete="off">
                          <input type="hidden" name="baca[]" class="form-control" value="0" autocomplete="off">
                          <input type="hidden" name="status_up[]" class="form-control" value="<?php echo $val['status_up'] ?>" autocomplete="off">
                          <input type="hidden" name="arv[]" class="form-control" value="<?php echo $val['qtyarv'] ?>" autocomplete="off">
                          </td>
                          <td>
                            <input type="number" <?php if ($val['status_up'] == 1) {
                                                    echo "readonly";
                                                  } ?> name="qtydeliv[]" step="any" id="qtydeliv_<?php echo $x; ?>" required onkeyup="getTotal(<?php echo $x; ?>)" class="form-control" value="<?php echo $val['qtydeliv'] ?>" autocomplete="off">
                          </td>

                          <?php
                          if ($orderan) : ?>
                            <td>
                              <input type="number" readonly class="form-control" value="<?php echo $val['qtyarv'] ?>" autocomplete="off">
                            </td>
                          <?php endif; ?>

                          <td>

                            <input type="text" name="rate[]" id="rate_<?php echo $x; ?>" class="form-control" disabled value="<?php echo $val['rate'] ?>" autocomplete="off">
                            <input type="hidden" name="rate_value[]" id="rate_value_<?php echo $x; ?>" class="form-control" value="<?php echo $val['rate'] ?>" autocomplete="off">
                          </td>
                          <td>
                            <input type="text" name="amount[]" id="amount_<?php echo $x; ?>" class="form-control" disabled value="<?php echo $val['amount'] ?>" autocomplete="off">
                            <input type="hidden" name="amount_value[]" id="amount_value_<?php echo $x; ?>" class="form-control" value="<?php echo $val['amount'] ?>" autocomplete="off">
                          </td>
                        </tr>
                        <?php $x++; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>

                <br /> <br />

                <div class="col-md-6 col-xs-12 pull pull-right">

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label">Jumlah Gross</label>
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
                  <div class="form-group">
                    <label for="net_amount" class="col-sm-5 control-label">Jumlah Total</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="net_amount" name="net_amount" disabled value="<?php echo $order_data['order']['net_amount'] ?>" autocomplete="off">
                      <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value" value="<?php echo $order_data['order']['net_amount'] ?>" autocomplete="off">
                    </div>
                  </div>



                  <div class="form-group">
                    <label for="net_amount" class="col-sm-5 control-label">Status Paid</label>
                    <div class="col-sm-7">
                      <?php if ($orderdata['paid_status'] == '1') {
                        echo '<div class="btn btn-success"><i class="fa fa-money"></i> Paid </div>';
                      } ?> <?php if ($orderdata['paid_status'] == '0') {
                              echo '<div class="btn btn-danger"><i class="fa fa-money"></i> Unpaid </div>';
                            } ?>
                    </div>
                  </div>


                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">

                <input type="hidden" name="service_charge_rate" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
                <input type="hidden" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">


                <a onclick="receipt('<?= $order_data['order']['id'] ?>')" href="#" class="btn btn-default"><i class="fa fa-print"></i> Print</a>

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
    var product_info_table;
    var base_url = "<?php echo base_url(); ?>";

    $(document).ready(function() {
      $(".select_group").select2();
      $("#description").wysihtml5();

      $("#mainProductNav").addClass('active');
      $("#ProductkeluarNav").addClass('active');



      // Add new row in the table 
      $("#add_row").unbind('click').bind('click', function() {
        var table = $("#product_info_table");
        var count_table_tbody_tr = $("#product_info_table tbody tr").length;
        var row_id = count_table_tbody_tr + 1;
        var tambah = $('#add_row');

        $.ajax({
          url: base_url + '/orders/getTableProductRow/',
          type: 'post',
          dataType: 'json',
          beforeSend: function() {
            tambah.attr('disabled', 'disabled');
          },
          success: function(response) {
            tambah.attr('disabled', false);


            // console.log(reponse.x);
            var html = '<tr id="row_' + row_id + '">' +
              '<td>' +
              '<select class="form-control select_group product" data-row-id="' + row_id + '" id="product_' + row_id + '" name="product[]" style="width:100%;" onchange="getProductData(' + row_id + ')">' +
              '<option selected="true" value="" disabled="disabled">-- Pilih Produk --</option>';
            $.each(response, function(index, value) {
              html += '<option value="' + value.id + '">' + value.name + ' / ' + value.satuan + '</option>';
            });

            html += '</select>' +
              '</td>' +
              '<input type="hidden" name="store[]" value="<?php echo $val['store'] ?>" class="form-control" autocomplete="off"><input type="hidden" name="store_id[]" value="<?php echo $val['store_id'] ?>" class="form-control" autocomplete="off"><input type="hidden" name="user_id[]" value="<?php echo $val['user_id'] ?>" class="form-control" autocomplete="off"><input type="hidden" name="status_up[]"   class="form-control" value="<?php echo $val['status_up'] ?>" autocomplete="off"><input type="hidden" name="arv[]" class="form-control" value="<?php echo $val['qtyarv'] ?>" autocomplete="off">' +
              '<td><input type="number" disabled class="form-control" ><input type="hidden" name="baca[]"   class="form-control" value="0" autocomplete="off"></td>' +
              '<input type="hidden" name="qty[]"  step="any" value="0" class="form-control" autocomplete="off">' +
              '<td><input type="number" name="qtydeliv[]"  step="any" id="qtydeliv_' + row_id + '" required onkeyup="getTotal(' + row_id + ')" class="form-control" autocomplete="off"></td>' +

              <?php if ($orderan) : ?> '<td><input type="number"  readonly class="form-control" autocomplete="off"></td>' +

              <?php endif; ?> '<td><input type="text" name="rate[]" id="rate_' + row_id + '" class="form-control" disabled><input type="hidden" name="rate_value[]" id="rate_value_' + row_id + '" class="form-control"></td>' +
              '<td><input type="text" name="amount[]" id="amount_' + row_id + '" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_' + row_id + '" class="form-control"></td>' +
              '</tr>';

            if (count_table_tbody_tr >= 1) {
              $("#product_info_table tbody tr:last").after(html);
            } else {
              $("#product_info_table tbody").html(html);
            }

            $(".product").select2();

          }
        });

        return false;
      });

    }); // /document

    function getTotal(row = null) {
      if (row) {
        var total = Number($("#rate_value_" + row).val()) * Number($("#qtydeliv_" + row).val());
        total = total.toFixed(0);
        $("#amount_" + row).val(total);
        $("#amount_value_" + row).val(total);

        subAmount();

      } else {
        alert('no row !! please refresh the page');
      }
    }

    // get the product information from the server
    function getProductData(row_id) {
      var product_id = $("#product_" + row_id).val();
      if (product_id == "") {
        $("#rate_" + row_id).val("");
        $("#rate_value_" + row_id).val("");

        $("#qty_" + row_id).val("");

        $("#qtydeliv_" + row_id).val("");

        $("#amount_" + row_id).val("");
        $("#amount_value_" + row_id).val("");

      } else {
        $.ajax({
          url: base_url + 'orders/getProductValueById',
          type: 'post',
          data: {
            product_id: product_id
          },
          dataType: 'json',
          success: function(response) {
            // setting the rate value into the rate input field

            $("#rate_" + row_id).val(response.price);
            $("#rate_value_" + row_id).val(response.price);

            $("#qty_" + row_id).val(1);
            $("#qty_value_" + row_id).val(1);


            $("#qtydeliv_" + row_id).val(1);

            var total = Number(response.price) * 1;
            total = total.toFixed(0);
            $("#amount_" + row_id).val(total);
            $("#amount_value_" + row_id).val(total);

            subAmount();
          } // /success
        }); // /ajax function to fetch the product data 
      }
    }

    // calculate the total amount of the order
    function subAmount() {
      var service_charge = <?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value'] : 0; ?>;
      var vat_charge = <?php echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value'] : 0; ?>;

      var tableProductLength = $("#product_info_table tbody tr").length;
      var totalSubAmount = 0;
      for (x = 0; x < tableProductLength; x++) {
        var tr = $("#product_info_table tbody tr")[x];
        var count = $(tr).attr('id');
        count = count.substring(4);

        totalSubAmount = Number(totalSubAmount) + Number($("#amount_" + count).val());
      } // /for

      totalSubAmount = totalSubAmount.toFixed(0);

      // sub total
      $("#gross_amount").val(totalSubAmount);
      $("#gross_amount_value").val(totalSubAmount);

      // vat
      var vat = (Number($("#gross_amount").val()) / 100) * vat_charge;
      vat = vat.toFixed(0);
      $("#vat_charge").val(vat);
      $("#vat_charge_value").val(vat);

      // service
      var service = (Number($("#gross_amount").val()) / 100) * service_charge;
      service = service.toFixed(0);
      $("#service_charge").val(service);
      $("#service_charge_value").val(service);

      // total amount
      var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
      totalAmount = totalAmount.toFixed(0);
      // $("#net_amount").val(totalAmount);
      // $("#totalAmountValue").val(totalAmount);

      var discount = $("#discount").val();
      if (discount) {
        var grandTotal = Number(totalAmount) - Number(discount);
        grandTotal = grandTotal.toFixed(0);
        $("#net_amount").val(grandTotal);
        $("#net_amount_value").val(grandTotal);
      } else {
        $("#net_amount").val(totalAmount);
        $("#net_amount_value").val(totalAmount);

      } // /else discount 

      var paid_amount = Number($("#paid_amount").val());
      if (paid_amount) {
        var net_amount_value = Number($("#net_amount_value").val());
        var remaning = net_amount_value - paid_amount;
        $("#remaining").val(remaning.toFixed(0));
        $("#remaining_value").val(remaning.toFixed(0));
      }

    } // /sub total amount

    function paidAmount() {
      var grandTotal = $("#net_amount_value").val();

      if (grandTotal) {
        var dueAmount = Number($("#net_amount_value").val()) - Number($("#paid_amount").val());
        dueAmount = dueAmount.toFixed(0);
        $("#remaining").val(dueAmount);
        $("#remaining_value").val(dueAmount);
      } // /if
    } // /paid amoutn function

    function removeRow(tr_id) {
      Swal.fire({
        title: 'Yakin Ingin Menghapus?',
        text: "Produk yang di pesan akan terhapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.isConfirmed) {
          $("#product_info_table tbody tr#row_" + tr_id).remove();
          subAmount();
          Swal.fire(
            'Deleted!',
            'Produk Pesanan Terhapus, Simpan Untuk Menetapkan',
            'success'
          )
        }
      })

    }
  </script>


<?php
endif;
?>


<div id="printaera" style="position: absolute; z-index: -1;"></div>

<script>
  //print
  function receipt(id) {
    $.ajax({
      url: "<?= base_url('orders/printDiv') ?>",
      type: 'POST',
      data: {
        id: id
      },
      success: function(data) {
        document.getElementById("printaera").innerHTML = data;
        $.print("#printaera");
      }
    });

  }
</script>
<script src="https://cdn.jsdelivr.net/npm/jQuery.print@1.5.1/jQuery.print.min.js"></script>