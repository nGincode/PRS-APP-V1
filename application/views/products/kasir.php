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
      Point Of Sales
      <small>(POS)</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">POS</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div class="box box-white box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-shopping-cart"></i> Point Of Sales</b></h3>

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
                    <input type="text" class="form-control" id="customer_name" required name="customer_name" placeholder="Nama Penerima" autocomplete="off" />
                    <input type="hidden" class="form-control" id="store_id" name="gudang_id" value="<?= $store_id ?>" autocomplete="off" />
                    <input type="hidden" class="form-control" id="kasir" name="kasir" value="1" autocomplete="off" />
                    <input type="hidden" class="form-control" id="customer_address" name="customer_address" autocomplete="off" value="<?php echo $outlet ?>">
                  </div>
                </div>


                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">No Hp</label>
                  <div class="col-sm-7">
                    <input type="number" class="form-control" id="customer_phone" name="customer_phone" placeholder="No Hp" autocomplete="off">
                  </div>
                </div>


                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Barcode</label>
                  <div class="col-sm-7">
                    <input type="number" class="form-control" id="barcode" name="barcode" placeholder="Input No Barcode" autocomplete="off">
                  </div>
                </div>

                *Proses ini akan mengurangi qty product
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
                  </tr>
                </thead>

                <tbody>

                  <tr id="row_1">
                    <td>
                      <select class="form-control select_group product" data-row-id="row_1" id="product_1" name="product[]" style="width:100%;" onchange="getProductData(1)" required>
                        <option selected="true" disabled="disabled">Pilih Produk</option>
                        <?php foreach ($products as $k => $v) : ?>
                          <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </td>
                    <td><input type="number" step="any" name="qty[]" id="qty_1" class="form-control" required onkeyup="getTotal(1)"></td>
                    <td>
                      <input type="text" name="rate[]" id="rate_1" class="form-control" disabled autocomplete="off">
                      <input type="hidden" name="rate_value[]" id="rate_value_1" class="form-control" autocomplete="off">
                    </td>
                    <td>
                      <input type="text" name="satuan[]" id="satuan_1" class="form-control" disabled autocomplete="off">
                      <input type="hidden" name="satuan_value[]" id="satuan_value_1" class="form-control" autocomplete="off">
                    </td>
                    <td>
                      <input type="text" name="amount[]" id="amount_1" class="form-control" disabled autocomplete="off">
                      <input type="hidden" name="amount_value[]" id="amount_value_1" class="form-control" autocomplete="off">
                    </td>
                    <td><button type="button" class="btn btn-danger" onclick="removeRow('1')"><i class="fa fa-close"></i></button></td>
                  </tr>
                </tbody>
                <tfoot>
                  <th colspan="6">
                    <button type="button" style="width:20%;min-width:100%;text-align: center;" id="add_row" class="btn btn-success"><i class="fa fa-plus"></i></button>
                  </th>
                </tfoot>
              </table>
              <br /> <br />

              <div class="col-md-6 col-xs-12 pull pull-right">

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label">Jumlah</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled autocomplete="off">
                    <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label">Tunai</label>
                  <div class="col-sm-7">
                    <input type="number" class="form-control" required id="tunai" name="tunai" autocomplete="off">
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
              <button type="submit" style="width: 100%;height: 80px;" class="btn btn-primary"><i class="fa fa-sign-in"></i> Submit</button>
            </div>
          </form>
          <!-- /.box-body -->
        </div>



        <div class="box box-solid">
          <div class="box-header">
            <h3 class="box-title"><b><i class="fa fa-shopping-cart"></i> History Transaksi</b></h3>
          </div>


          <!-- /.box-header -->
          <div class="box-body" id='penyesuaian'>
            <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <th style="width: 10px;">Opsi</th>
                  <th>Tanggal</th>
                  <th>Bill</th>
                  <th>Nama</th>
                  <th>Total</th>
                  <th>Cash</th>
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


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="print" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>Transaksi Berhasil</b></h4>
      </div>

      <form>
        <div class="modal-body">
          <center>
            <h2><b>~Kembalian~</b></h2>
            <h2 id="kembalian" style="color: green;">123</h2><br>
            <button type="button" id="idprint" class="btn btn-primary" onclick="print(this.value)" value=""><i class="fa fa-print"></i> Print</button>
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" style="width: 100%;" class="btn btn-success" data-dismiss="modal" onClick="window.location.reload()">Kembali</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="lihatModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Produk Diorder</h4>
      </div>

      <div class="box-body" style="overflow: auto;">
        <div id="lihatForm">
          <div id="dataorder">
          </div>
        </div>

      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="printaera" style="position: absolute; z-index: -1;"></div>

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainposNav").addClass('active');
    $("#addposNav").addClass('active');


    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'products/history',
      'order': []
    });

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


  function print(id) {


    $.ajax({
      type: "POST",
      url: "<?php echo base_url('products/kasir_print') ?>",
      data: {
        id: id
      },
      success: function(data) {

        if (data) {

          document.getElementById("printaera").innerHTML = data;
          $.print("#printaera");
        } else {
          alert('Isi Belum Lengkap');
        }
      }
    });


  }


  // lihat functions 
  function lihatFunc(id) {
    if (id) {
      var lihatorder = "<?php echo base_url('orders/lihatorder'); ?>";

      $.ajax({
        url: lihatorder,
        type: "POST",
        data: {
          id: id
        },
        success: function(data) {
          $('#dataorder').html(data);
        }
      });

      return false;
    }
  }

  $(document).ready(function() {
    $("#createorder").submit(function(event) {
      event.preventDefault();

      $jml = parseInt($("#gross_amount_value").val());
      $tunai = parseInt($("#tunai").val());

      if ($tunai > $jml || $jml === $tunai) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('products/kasir') ?>",
          data: $('#createorder').serialize(),
          success: function(data) {

            if (data > 0) {
              $('#print').modal('show');
              $('#idprint').val(data);
              document.getElementById("createorder").reset();


              $.ajax({
                type: "POST",
                url: "<?php echo base_url('products/kembalian') ?>",
                data: {
                  id: data
                },
                success: function(hasil) {
                  document.getElementById("kembalian").innerHTML = hasil;
                }
              });


              // Swal.fire({
              //   icon: 'success',
              //   title: 'Berhasil...!',
              //   text: data,
              //   showConfirmButton: false,
              //   timer: 4000
              // });

              // setTimeout(
              //   function() {
              //     window.location = "<?php echo base_url('products/kasir') ?>"
              //   },
              //   4000);
            } else if (data === 'ere') {
              Swal.fire({
                icon: 'error',
                title: 'Gagal...!',
                text: 'Terjadi Kesalahan Silahkan Hubungi Bng Fembi',
                showConfirmButton: false,
                timer: 4000
              });

            } else if (data === 'dup') {
              Swal.fire({
                icon: 'info',
                title: 'Sory Bro...!',
                text: 'Produk Pesanan Anda Ada Yang Duplikat',
                showConfirmButton: false,
                timer: 4000
              });

            }


          }
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Gagal...!',
          text: 'Uang yang dibayarkan kurang',
          showConfirmButton: false,
          timer: 4000
        });
      }
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/jQuery.print@1.5.1/jQuery.print.min.js"></script>