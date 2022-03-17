<?php if ($this->session->flashdata('success')) :
  echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
?>
<?php elseif ($this->session->flashdata('error')) :
  echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
?>
<?php endif; ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tambah
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
        <?php
        if ($this->data['sekarang'] > $this->data['mulai'] or $this->data['sekarang'] < $this->data['sampai'] or $div == 0) {
        } else { ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Anda Hanya Dapat Order Dijam <?= $mulai ?> - <?= $sampai ?> (<?= $sekarang ?>)
          </div>
        <?php } ?>

        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-shopping-cart"></i> <?= $page_title ?></b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <form role="form" id="createorder" method="post" class="form-horizontal">
            <div class="box-body">

              <?php echo validation_errors(); ?>
              <br>

              <div class="col-md-4 col-xs-12 pull pull-left">

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Nama Pengorder</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="customer_name" required name="customer_name" placeholder="Nama Penerima" autocomplete="off" value="<?php echo $user['firstname'] ?>" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Outlet</label>
                  <div class="col-sm-7">
                    <?php


                    if ($div == 1 or $div == 2 or $div == 3 or $div == 11) :
                    ?>
                      <input type="text" class="form-control" name="customer_address" placeholder="<?php echo $outlet ?>" autocomplete="off" value="<?php echo $outlet ?>" disabled>
                      <input type="hidden" class="form-control" id="customer_address" name="customer_address" placeholder="<?php echo $outlet ?>" autocomplete="off" value="<?php echo $outlet ?>">
                      <input type="hidden" class="form-control" name="store_id" value="<?php echo $store_id ?>">

                      <input type="hidden" class="form-control" id="tunai" name="tunai" autocomplete="off" value="0">
                      <input type="hidden" class="form-control" id="kasir" name="kasir" autocomplete="off" value="0">
                    <?php elseif ($div == 0) : ?>
                      <select name="customer_address" class="form-control">
                        <?php foreach ($store as $k => $v) : ?>
                          <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                      <input type="hidden" class="form-control" id="tunai" name="tunai" autocomplete="off" value="0">
                    <?php endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">No Hp</label>
                  <div class="col-sm-7">
                    <input type="number" class="form-control" required value="<?php echo $user['phone'] ?>" id="customer_phone" name="customer_phone" placeholder="No Hp" autocomplete="off">
                  </div>
                </div>


                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Logistik</label>
                  <div class="col-sm-7">
                    <select name="gudang_id" id="gudang_id" onchange="gudang()" class="form-control">
                      <?php foreach ($logistik as $s => $l) : ?>
                        <option value="<?php echo $l['id'] ?>"><?php echo $l['name'] ?></option>
                      <?php endforeach ?>
                    </select>

                  </div>
                </div>

              </div>


              <br /> <br />
              <table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
                <thead>
                  <th style="width:50%;min-width:200px;text-align: center;">Produk</th>
                  <th style="width:10%;min-width:70px;text-align: center;">Qty</th>
                  <th style="width:10%;min-width:100px;text-align: center;">Hrg/1</th>
                  <th style="width:10%;min-width:70px;text-align: center;">Satuan</th>
                  <th style="width:20%;min-width:100px;text-align: center;">Jumlah</th>
                  <th style="width:10%;text-align: center;"><i class="fa fa-trash"></i></th>
                </thead>

                <tbody>
                </tbody>
                <tfoot>
                  <th colspan="6">
                    <button type="button" style="width:20%;min-width:100%;text-align: center;" id="add_row" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                  </th>
                </tfoot>
              </table>
              <br /> <br />

              <div class="col-md-6 col-xs-12 pull pull-right">

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label">Jumlah Harga</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled autocomplete="off">
                    <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" autocomplete="off">
                  </div>
                </div>
                <?php if ($is_service_enabled == true) : ?>
                  <div class="form-group">
                    <label for="service_charge" class="col-sm-5 control-label">S-Charge <?php echo $company_data['service_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="service_charge" name="service_charge" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="service_charge_value" name="service_charge_value" autocomplete="off">
                    </div>
                  </div>
                <?php endif; ?>
                <?php if ($is_vat_enabled == true) : ?>
                  <div class="form-group">
                    <label for="vat_charge" class="col-sm-5 control-label">PPN <?php echo $company_data['vat_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="vat_charge" name="vat_charge" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="vat_charge_value" name="vat_charge_value" autocomplete="off">
                    </div>
                  </div>
                <?php endif; ?>
                <div class="form-group" style="display: none;">
                  <label for="discount" class="col-sm-5 control-label">Discount</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount" onkeyup="subAmount()" autocomplete="off">
                  </div>
                </div>
                <div class="form-group" style="display: none ;">
                  <label for="net_amount" class="col-sm-5 control-label">Jumlah Total</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="net_amount" name="net_amount" disabled autocomplete="off">
                    <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value" autocomplete="off">
                  </div>
                </div>

              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <input type="hidden" name="service_charge_rate" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
              <input type="hidden" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
              <button type="submit" class="btn btn-success" id="tblsmt"><i class="fa fa-sign-in"></i> Pesan</button>
              <a href="<?php echo base_url('orders/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
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
<!-- /.content-wrapper -->

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainOrdersNav").addClass('active');
    $("#addOrderNav").addClass('active');

    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
      'onclick="alert(\'Call your custom code here.\')">' +
      '<i class="glyphicon glyphicon-tag"></i>' +
      '</button>';

    // Add new row in the table 
    $("#add_row").unbind('click').bind('click', function() {
      var table = $("#product_info_table");
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;
      var row_id = count_table_tbody_tr + 1;

      var tambah = $('#add_row');

      var gudang_id = $('#gudang_id').val();
      $.ajax({
        url: base_url + '/orders/getTableProductRow/',
        type: 'post',
        data: {
          gudang_id: gudang_id
        },
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
            '<option selected="true" disabled="disabled">Pilih Produk</option>';

          $.each(response, function(index, value) {
            html += '<option value="' + value.id + '">' + value.name + '</option>';
          });


          html += '</select>' +
            '</td>' +
            '<td><input type="number" step="any" name="qty[]" id="qty_' + row_id + '" class="form-control" onkeyup="getTotal(' + row_id + ')"></td>' +
            '<td><input type="text" name="rate[]" id="rate_' + row_id + '" class="form-control" disabled><input type="hidden" name="rate_value[]" id="rate_value_' + row_id + '" class="form-control"></td>' +
            '<td><input type="text" name="satuan[]" id="satuan_' + row_id + '" class="form-control" disabled><input type="hidden" name="satuan_value[]" id="satuan_value_' + row_id + '" class="form-control"></td>' +
            '<td><input type="text" name="amount[]" id="amount_' + row_id + '" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_' + row_id + '" class="form-control"></td>' +
            '<td><button type="button" class="btn btn-danger" onclick="removeRow(\'' + row_id + '\')"><i class="fa fa-close"></i></button></td>' +
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

  function gudang() {
    $("#product_info_table tbody tr").html('');
  }

  // get the product information from the server
  function getProductData(row_id) {
    var product_id = $("#product_" + row_id).val();
    if (product_id == "") {
      $("#rate_" + row_id).val("");
      $("#rate_value_" + row_id).val("");

      $("#satuan_" + row_id).val("");
      $("#satuan_value_" + row_id).val("");

      $("#qty_" + row_id).val("");

      $("#amount_" + row_id).val("");
      $("#amount_value_" + row_id).val("");

    } else {
      var gudang_id = $('#gudang_id').val();
      $.ajax({
        url: base_url + 'orders/getProductValueById',
        type: 'post',
        data: {
          gudang_id: gudang_id,
          product_id: product_id
        },
        dataType: 'json',
        success: function(response) {

          var tgl = new Date().getDate() - 3;
          var bulan = new Date().getMonth() + 1;
          var thn = new Date().getFullYear();
          var gabung = thn + "" + bulan + "" + tgl;

          var hariini = gabung.replace(/-0/g, '');

          if (response.price_tgl) {
            var date_price = response.price_tgl.replace(/-0/g, '')

            if (hariini < date_price) {

              $("#row_" + row_id).css("background-color", "rgba(253, 253, 86, 0.72)");

              // $("#row_" + row_id).append('<i class="fa fa-warning" style="position: absolute;z-index: 9;margin-top: 18px;margin-left: -7px;color:red;"></i>');

              Swal.fire({
                icon: 'info',
                title: 'Harga Berubah!',
                text: 'Dari ' + response.price_old + ' Ke ' + response.price,
                showConfirmButton: false,
                timer: 1500
              });
            } else {
              $("#row_" + row_id).css("background-color", "unset");

            }
          }

          // setting the rate value into the rate input field

          $("#rate_" + row_id).val(response.price);
          $("#rate_value_" + row_id).val(response.price);

          $("#satuan_" + row_id).val(response.satuan);
          $("#satuan_value_" + row_id).val(response.satuan);

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

  } // /sub total amount

  function removeRow(tr_id) {
    $("#product_info_table tbody tr#row_" + tr_id).html('<td hidden><input type="hidden" id="amount_' + tr_id + '" value="0" class="form-control" disabled="" autocomplete="off"></td>');
    subAmount();
  }


  $(document).ready(function() {
    $("#createorder").submit(function(event) {
      event.preventDefault();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('orders/create') ?>",
        data: $('#createorder').serialize(),
        success: function(data) {

          if (data == 1) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil...!',
              text: '',
              showConfirmButton: false,
              timer: 3000
            });
            $('#tblsmt').attr("disabled", true);
            setTimeout(
              function() {
                window.location = "<?php echo base_url('orders/') ?>"
              },
              3000);
          } else if (data == 9) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal...!',
              text: 'Terjadi Kesalahan Silahkan Hubungi Bng Fembi',
              showConfirmButton: false,
              timer: 4000
            });

          } else if (data == 8) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal...!',
              text: 'Ada data tidak ditampilkan dengan benar',
              showConfirmButton: false,
              timer: 4000
            });

          } else if (data == 2) {
            Swal.fire({
              icon: 'info',
              title: 'Cek Orderan Anda Kembali...!',
              text: 'Produk Pesanan Anda Ada Yang Duplikat',
              showConfirmButton: false,
              timer: 4000
            });

          } else if (data == 3) {
            Swal.fire({
              icon: 'success',
              title: 'Sorry Bray...!',
              text: 'Jam Order Telah Habis, 18:00 - 05:00!!',
              showConfirmButton: false,
              timer: 4000
            });

          }


        }
      });
    });
  });
</script>