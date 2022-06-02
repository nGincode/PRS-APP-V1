<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Produk</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Produk Logistik</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>

          <!-- /.box-header -->
          <div class="box-body" id='penyesuaian'>
            <table id="manageTable" class="table table-bordered table-striped" style="width:100%">

              <div style="position:relative;z-index: 9; display:flex;">

                <div style="margin-right:10px;">
                  <?php if (in_array('createProduct', $user_permission)) : ?>
                    <a href="<?php echo base_url('products/create') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                  <?php endif; ?>
                </div>

                <div style="margin-right:10px;">
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Export <span class="fa fa-caret-down"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="<?= base_url('products/excel') ?>"><i class="fa fa-file-excel-o"></i> Excel</a></li>
                    <li><a href="<?php echo base_url('products/laporanstock') ?>"><i class="fa fa-print"></i> Print</a></li>
                  </ul>
                </div>

                <div style="margin-right:10px;">
                  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><?= $storefilter; ?> <span class="fa fa-caret-down"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="<?= base_url() . 'products' ?>">SEMUA</a></li>
                    <?php foreach ($store as $key => $value) {
                      echo ' <li><a href="?filter=' . $value['id'] . '">' . $value['name'] . '</a></li>';
                    }; ?>
                  </ul>
                </div>


                <div style="margin-right:10px;">
                  <?php if ($updateharga == true) : ?>
                    <a href="#" onclick="updateharga()" class="btn btn-danger"><i class="fa fa-sign-out"></i> Update Harga</a>
                  <?php endif; ?>
                </div>

              </div>

              <hr>
              <thead>
                <tr>
                  <?php if (in_array('updateProduct', $user_permission) || in_array('deleteProduct', $user_permission)) : ?>
                    <th style="width: 30px;">Opsi</th>
                  <?php endif; ?>
                  <th>SKU</th>
                  <th>Nama</th>
                  <th>Harga</th>
                  <th>Qty</th>
                  <th>Ket</th>
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


    <div class="box box-danger box-solid ">
      <div class="box-header with-border">
        <h3 class="box-title"><b>Print Tanggal Produksi</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>

      <div class="form-horizontal">
        <div class="box-body">

          <div class="col-md-4 col-xs-12 pull pull-left">


            <div class="form-group">
              <label class="col-sm-5 control-label" style="text-align:left;">Produk :</label>
              <div class="col-sm-7">

                <div class="input-group date">
                  <div class="input-group-addon ">
                    <i class="fa fa-plus"></i>
                  </div>
                  <select class="form-control select_group pull-right" id="product" name="product" style="width:100%;" required>
                    <option selected="true" disabled="disabled">Pilih Produk</option>
                    <?php foreach ($products as $k => $v) : ?>
                      <option value="<?php echo $v['name'] ?>"><?php echo $v['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-5 control-label" style="text-align:left;">Jumlah :</label>
              <div class="col-sm-7">

                <div class="input-group date">
                  <div class="input-group-addon ">
                    <i class="fa fa-plus"></i>
                  </div>
                  <input type="number" required="" id="jml" name="jml" placeholder="0" class="form-control pull-right">
                </div>

              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-5 control-label" style="text-align:left;">Tanggal :</label>
              <div class="col-sm-7">

                <div class="input-group date">
                  <div class="input-group-addon ">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" required="" value="" name="tgl" id="tgl" class="form-control pull-right">
                </div>

              </div>
            </div>


          </div>

        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-app" onclick="print()"><i class="fa fa-print"></i> Print</button>
        </div>
      </div>
    </div>
  </section>



  <!-- /.content -->
</div>
<div id="printaera" style="position: absolute; z-index: -1;"></div>
<!-- /.content-wrapper -->

<?php if (in_array('deleteProduct', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Menghapus Produk</h4>
        </div>

        <form role="form" action="<?php echo base_url('products/remove') ?>" method="post" id="removeForm">
          <div class="modal-body">
            <p>Yakin Ingin Menghapus?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Hapus</button>
          </div>
        </form>


      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endif; ?>



<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {

    $(".select_group").select2();
    $("#mainProductNav").addClass('active');
    $("#manageProductNav").addClass('active');

    var filter = '<?php echo $this->input->get('filter'); ?>';
    if (filter) {
      manageTable = $('#manageTable').DataTable({
        "ajax": {
          "url": base_url + 'products/fetchProductData',
          "type": 'POST',
          "data": {
            'filter': filter
          }
        },
        'order': []
      });

    } else {
      manageTable = $('#manageTable').DataTable({
        'ajax': base_url + 'products/fetchProductData',
        'order': []
      });
    }

  });
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
            product_id: id
          },
          dataType: 'json',
          success: function(response) {

            manageTable.ajax.reload(null, false);

            if (response.success === true) {

              Swal.fire({
                icon: 'success',
                title: 'Berhasil...!',
                text: response.messages,
                showConfirmButton: false,
                timer: 4000
              });

              // hide the modal
              $("#removeModal").modal('hide');

            } else {

              Swal.fire({
                icon: 'error',
                title: 'Maaf...!',
                text: response.messages,
                showConfirmButton: false,
                timer: 4000
              });

              $("#removeModal").modal('hide');
            }
          }
        });

        return false;
      });
    }
  }

  function print() {

    var nama = $("#product").val();
    var tgl = $("#tgl").val();
    var jml = $("#jml").val();

    if (!nama == '' && !tgl == '' && !jml == '') {
      var x;
      html = '<div style="width: 55mm;height:unset;"><table  style="font-size: 20px; width:100%;">';
      for (x = 0; x < jml; x++) {
        html += '<tr style="border-bottom: solid;"><td colspan="3" style="text-align: center;padding: 5px;line-height: normal;">' + nama + '<br>' + tgl + '<td></tr>';
      }
      html += '</table></div>';
      document.getElementById("printaera").innerHTML = html;
      $.print("#printaera");
    } else {
      alert('Isi Belum Lengkap');
    }

  }


  function updateharga() {
    $.ajax({
      url: '<?= base_url('/products/updateharga') ?>',
      type: 'POST',
      dataType: 'json',
      success: function(response) {
        if (response.success === true) {


          Swal.fire({
            icon: 'success',
            title: 'Berhasil...!',
            text: response.pesan,
            showConfirmButton: false,
            timer: 4000
          });

          setTimeout(function() {
            location.reload();
          }, 4000);

        } else {

          Swal.fire({
            icon: 'error',
            title: 'Maaf...!',
            text: response.pesan,
            showConfirmButton: false,
            timer: 4000
          });

        }
      }
    });
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/jQuery.print@1.5.1/jQuery.print.min.js"></script>