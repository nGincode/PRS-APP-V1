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
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>


        <?php if (in_array('createstock', $user_permission)) : ?>
          <a href="<?php echo base_url('stock/datastock') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
          <br /> <br />
        <?php endif; ?>


        <div class="box  box-primary box-solid">

          <div class="box-header with-border">
            <h3 class="box-title"><b>Manage Stock</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-tools -->

          <div class="box-body" id='penyesuaian'>

            <div style="position:relative;z-index: 9; margin:10px; display: flex;">
              <div style="margin-right:10px;">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Export <span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a data-toggle="tooltip" data-placement="top" <?php if ($pilih == 'SEMUA' or $pilih == 'Tidak ditemukan') {
                                                                      echo 'title="Pilih Outlet Untuk Export"';
                                                                    } else { ?> onclick='jadi(1)' <?php } ?> href="#">Excel</a></li>
                  <li><a onclick='jadi(2)' href="#">PDF</a></li>
                </ul>
              </div>
              <?php if ($div == 0) { ?>
                <div style="margin-right:10px;">
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <?= $pilih; ?>
                    <span class="fa fa-caret-down"></span>
                  </button>
                  <ul class="dropdown-menu" style="text-align: center;">
                    <li><a href="<?= base_url('stock');  ?>">SEMUA</a></li>
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
            <hr>

            <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <th style="text-align: center;" colspan="6">Data</th>
                  <th style="text-align: center;" colspan="1">Awal</th>
                  <th style="text-align: center;" colspan="1">Masuk</th>
                  <th style="text-align: center;" colspan="1">Sisa</th>
                  <th style="text-align: center;" colspan="1">Terpakai</th>
                  <th style="text-align: center;" colspan="3">Register</th>
                </tr>
                </tr>
                <tr>
                  <?php $div = $this->session->userdata('divisi');
                  if (in_array('updatestock', $user_permission)  || in_array('deletestock', $user_permission)) : ?>

                    <?php if ($div == 11 or $div == 0) {
                      echo $data = '<th style="min-width: 10px;">Action</th>';
                    } elseif ($div == 1 or $div == 2 or $div == 3) {
                      echo $data = '';
                    } ?>

                  <?php endif; ?>
                  <th style="min-width: 40px;text-align: center;">Store</th>
                  <th style="min-width: 80px;text-align: center;">Divisi</th>
                  <th style="min-width: 80px;text-align: center;">Tanggal</th>
                  <th style="text-align: center;">Nama </th>
                  <th style="min-width: 100px;text-align: center;">Rp/UOM</th>
                  <th style="min-width: 50px;text-align: center;">Unit</th>
                  <th style="min-width: 50px;text-align: center;">Unit</th>
                  <th style="min-width: 50px;text-align: center;">Unit</th>
                  <th style="min-width: 50px;text-align: center;">Unit</th>
                  <th style="min-width: 50px;text-align: center;">Reg</th>
                  <th style="min-width: 50px;text-align: center;">Status</th>
                  <th style="min-width: 50px;text-align: center;">Ket</th>
                </tr>
              </thead>

            </table>
          </div>

          <div id="load" class="overlay">
            <i class="fa fa-refresh fa-spin"></i>
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

<?php if (in_array('deletestock', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Hapus Stock</h4>
        </div>

        <form role="form" action="<?php echo base_url('stock/remove') ?>" method="post" id="removeForm">
          <div class="modal-body">
            <p>Yakin Ingin Menghapus Stock?</p>
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
  var filter = "<?php echo $this->input->get('filter'); ?>";

  function ubah() {
    var da = $('#jadi').val();

    $(document).ready(function() {
      $("#mainstockNav").addClass('active');
      $("#managestockNav").addClass('active');
      manageTable = $('#manageTable').DataTable({
        processing: false,
        serverSide: false,
        destroy: true,
        "ajax": {
          url: base_url + 'stock/fetchstockData',
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

  function jadi(id) {
    var da = $('#jadi').val();
    if (id === 1) {
      $.ajax({
        type: 'POST',
        url: base_url + 'stock/export',
        data: {
          tgl: da,
          outlet: filter,
          jenis: id,
        },
        xhrFields: {
          responseType: 'blob'
        },
        success: function(data) {
          var a = document.createElement('a');
          var url = window.URL.createObjectURL(data);
          a.href = url;
          a.download = 'Laporan Stock <?= $pilih; ?> Dari ' + da + '.xlsx';
          document.body.append(a);
          a.click();
          a.remove();
          window.URL.revokeObjectURL(url);

          Swal.fire({
            icon: 'success',
            title: 'Export Berhasil..!',
            text: 'File Sedang di kirim',
            showConfirmButton: false,
            timer: 4000
          });
        }
      });
    } else {
      alert('pdf');
    }
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
      startDate: '<?= date('d/m/Y', mktime(0, 0, 0, date("m") - 1, '26', date("Y"))); ?>',
      endDate: '<?= '25/' . date('m/Y') ?>'
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
            stock_id: id
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