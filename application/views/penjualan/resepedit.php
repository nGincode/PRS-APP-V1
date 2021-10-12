<?php if ($this->session->flashdata('success')) :

  echo "<script> Swal.fire({
              icon: 'success',
              title: 'Berhasil...!',
              text: '" . $this->session->flashdata('success') . "',
              showConfirmButton: false,
              timer: 4000
            });</script>";

?>
<?php elseif ($this->session->flashdata('error')) :
  echo "<script> Swal.fire({
              icon: 'error',
              title: 'Maaf...!',
              text: '" . $this->session->flashdata('error') . "',
              showConfirmButton: false,
              timer: 4000
            });</script>";

?>
<?php endif; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tambah
      <small>Resep</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Resep</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>


        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Tambah Resep</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php echo base_url('penjualan/resepeditinput') ?>" method="post" class="form-horizontal">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="col-md-4 col-xs-15 ">
                <div class="form-group">
                  <label for="nama">Nama Menu </label>
                  <input type="text" class="form-control" value="<?php echo $namaresep ?>" id="nama" required name="menu" placeholder="Nama Menu Harus Sama Dengan Moka" autocomplete="off" />
                  <input type="hidden" class="form-control" value="<?php echo $this->input->get('id') ?>" id="id" name="id" autocomplete="off" />
                </div>
              </div>

              <table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
                <thead>
                  <th style="width:50%;min-width:200px;text-align: center;">Nama Item</th>
                  <th style="width:10%;min-width:70px;text-align: center;">Qty</th>
                  <th style="width:10%;min-width:70px;text-align: center;">Satuan</th>
                  <th style="width:10%;min-width:100px;text-align: center;">Harga</th>
                  <th style="width:3%"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th>
                  </tr>
                </thead>

                <tbody>

                  <?php
                  if (isset($dt)) : ?>
                    <?php $x = 1; ?>
                    <?php foreach ($dt as $key => $val) :
                      $ambiliditem = $this->model_penjualan->getitemresep($val['iditemresep']);
                      if ($ambiliditem) {
                        $satuan = $ambiliditem['satuan'];
                        $rate = $ambiliditem['harga'];
                      } else {
                        $satuan = '';
                        $rate = '';
                      }
                    ?>
                      <tr id="row_<?php echo $x; ?>">
                        <td>
                          <select class=" form-control select_group product" data-row-id="row_<?php echo $x; ?>" id="product_<?php echo $x; ?>" name="product[]" style="width:100%;" onchange="getProductData(<?php echo $x; ?>)" required=''>
                            <option selected="true" disabled="disabled">Pilih Produk</option>
                            <?php foreach ($products as $k => $v) : ?>
                              <option value="<?php echo $v['id'] ?>" <?php if ($val['iditemresep'] == $v['id']) {
                                                                        echo "selected='selected'";
                                                                      } ?>><?php echo $v['nama'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </td>
                        <td>
                          <input type="number" step="any" name="qty[]" id="qty_<?php echo $x; ?>" value="<?php echo $val['qty'] ?>" class="form-control" required onkeyup="getTotal(<?php echo $x; ?>)">
                        </td>

                        <td>
                          <input type="text" name="satuan[]" id="satuan_<?php echo $x; ?>" value="<?php echo $satuan ?>" class="form-control" disabled autocomplete="off">
                          <input type="hidden" name="satuan_value[]" id="satuan_value_<?php echo $x; ?>" value="<?php echo $satuan ?>" class="form-control" autocomplete="off">
                        </td>
                        <td>
                          <input type="number" disabled name="rate[]" id="rate_<?php echo $x; ?>" value="<?php echo $rate ?>" required class="form-control" autocomplete="off">
                          <input type="hidden" name="rate_value[]" id="rate_value_<?php echo $x; ?>" value="<?php echo $rate ?>" required class="form-control" autocomplete="off">
                        </td>
                        <td><button type="button" class="btn btn-default" onclick="removeRow('<?php echo $x; ?>'')"><i class="fa fa-close"></i></button></td>
                      </tr>
                      <?php $x++; ?>
                    <?php endforeach; ?>
                  <?php endif; ?>

                </tbody>
              </table>
              <br /> <br />

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-success"><i class="fa fa-sign-in"></i> Edit</button>
              <a href="<?php echo base_url('belanja/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
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



<?php if (in_array('viewpenjualan', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="lihatModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Lihat Item</h4>
        </div>
        <div id="tampil"></div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endif; ?>



<?php if (in_array('deletepenjualan', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Menghapus Item</h4>
        </div>

        <form role="form" action="<?php echo base_url('penjualan/removeitem') ?>" method="post" id="removeForm">
          <div class="modal-body">
            <p>Yakin Ingin Menghapus?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>


      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endif; ?>

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {


    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'penjualan/fetchresep',
      'order': []
    });


    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainpenjualanNav").addClass('active');
    $("#addresepNav").addClass('active');

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
        url: base_url + '/penjualan/getTableProductRow/',
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
            html += '<option value="' + value.id + '">' + value.nama + '</option>';
          });

          html += '</select>' +
            '</td>' +
            '<td><input type="number" step="any" name="qty[]" id="qty_' + row_id + '" class="form-control" onkeyup="getTotal(' + row_id + ')"></td>' +
            '<td><input type="text" name="satuan[]" id="satuan_' + row_id + '" class="form-control" disabled><input type="hidden" name="satuan_value[]" id="satuan_value_' + row_id + '" class="form-control"></td>' +
            '<td><input type="hidden" name="rate[]" id="rate_' + row_id + '" class="form-control"><input disabled type="number" name="rate_value[]" id="rate_value_' + row_id + '" class="form-control"></td>' +
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


  // get the product information from the server
  function getProductData(row_id) {
    var product_id = $("#product_" + row_id).val();
    if (product_id == "") {
      $("#rate_value_" + row_id).val("");

      $("#satuan_" + row_id).val("");
      $("#satuan_value_" + row_id).val("");

      $("#nama_produk_" + row_id).val("");

      $("#qty_" + row_id).val("");


    } else {
      $.ajax({
        url: base_url + 'penjualan/getProductValueById',
        type: 'post',
        data: {
          product_id: product_id
        },
        dataType: 'json',
        success: function(response) {
          // setting the rate value into the rate input field

          $("#rate_value_" + row_id).val(response.harga);
          $("#rate_" + row_id).val(response.harga);

          $("#satuan_" + row_id).val(response.satuan);
          $("#satuan_value_" + row_id).val(response.satuan);

          $("#nama_produk_" + row_id).val(response.nama);

          $("#qty_" + row_id).val();
          $("#qty_" + row_id).focus();
          $("#qty_value_" + row_id).val(1);

        } // /success
      }); // /ajax function to fetch the product data 
    }
  }

  function removeRow(tr_id) {
    $("#product_info_table tbody tr#row_" + tr_id).remove();
    subAmount();
  }




  function lihat(id) {
    if (id) {
      $.ajax({
        url: base_url + '/penjualan/fetchitemresepid',
        type: 'POST',
        data: {
          id: id
        },
        success: function(data) {
          $("#tampil").html(data);
        }
      });

      return false;
    }
  }


  // remove functions 
  function removeFunc(id) {
    if (id) {
      $("#removeForm").on('submit', function() {

        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: {
            id: id
          },
          dataType: 'json',
          success: function(response) {

            manageTable.ajax.reload(null, false);

            if (response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                '</div>');

              // hide the modal
              $("#removeModal").modal('hide');

            } else {

              $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }
          }
        });

        return false;
      });
    }
  }
</script>