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


        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-shopping-cart"></i> Manage Order</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->

          <div class="box-body" id='penyesuaian'>



            <div style="position:relative;z-index: 9; margin:10px; display: flex;">

              <?php if ($div == 0) { ?>
                <div style="margin-right:10px;">
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <?= $pilih; ?>
                    <span class="fa fa-caret-down"></span>
                  </button>
                  <ul class="dropdown-menu" style="text-align: center;">
                    <li><a href="<?= base_url('orders');  ?>">SEMUA</a></li>
                    <li class="divider"></li>
                    <?php foreach ($store as $key => $value) {
                      echo '<li><a href="?filter=' . $value['id'] . '">' . $value['name'] . '</a></li>';
                    }; ?>
                  </ul>
                </div>
              <?php } else { ?>

                <div style="margin-right:10px;">
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <?= $namastore; ?>
                  </button>
                </div>
              <?php } ?>
            </div>

            <div class="group">
              <input type="text" id="jadi" onchange="ubah()" name="datefilter" required>
              <span class="highlight"></span>
              <span class="bar"></span>
              <label class="labeljudul">Pilih Tanggal</label>
            </div>
            <hr>


            <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <?php if (in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)) : ?>
                    <th style="max-width:30px;text-align: center;"> Opsi</th>
                  <?php endif; ?>
                  <?php
                  if ($div == 1 or $div == 2 or $div == 3 or $div == 11) : ?>
                    <th style=" max-width:30px;text-align: center;">Arrive</th>
                  <?php endif; ?>
                  <th style="text-align: center;">Tanggal</th>
                  <th style="text-align: center;">Outlet</th>
                  <?php if ($div == 0) : ?>
                    <th style="text-align: center;">Outlet</th>
                  <?php endif; ?>
                  <th style="text-align: center;">Jumlah</th>
                  <th style="text-align: center;">Status</th>
                </tr>
              </thead>

            </table>

            <div id="load" class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
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


<div id="printaera" style="position: absolute; z-index: -1;"></div>

<?php if (in_array('deleteOrder', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Hapus Orderan</h4>
        </div>

        <form role="form" action="<?php echo base_url('orders/remove') ?>" method="post" id="removeForm">
          <div class="modal-body">
            <p>Yakin Ingin Menghapus Orderan?</p>
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

<?php if (in_array('viewOrder', $user_permission)) : ?>
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

<?php endif; ?>



<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";
  var filter = "<?php echo $this->input->get('filter'); ?>";

  function ubah() {

    $(document).ready(function() {
      var da = $('#jadi').val();
      var validasiAngka = /^[0-9]+$/;

      $("#mainOrdersNav").addClass('active');
      $("#manageOrdersNav").addClass('active');

      if (da) {
        manageTable = $('#manageTable').DataTable({
          processing: false,
          serverSide: false,
          destroy: true,
          "ajax": {
            url: base_url + 'orders/fetchOrdersData',
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

      } else {
        alert('Tanggal harus dipilih');
      }
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
      startDate: moment().subtract(7, 'days'),
      endDate: moment().subtract(1, 'days')
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });

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
            order_id: id
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
              // hide the modal
              $("#removeModal").modal('hide');
            }
          }
        });

        return false;
      });
    }
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