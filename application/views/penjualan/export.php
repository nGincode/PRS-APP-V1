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
      Kelola Penjualan
      <small>Resep & HPP</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Resep</li>
    </ol>
  </section>




  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>


        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Upload Penjualan</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->


          <!-- Option button -->


          <?= form_open_multipart('penjualan/export') ?>
          <div class="box-body">
            <input type="file" class="form-control" name="file_import">
          </div>
          <div class="box-footer">
            <input type="submit" class="btn btn-primary" name="preview" value="Upload">
            <a href="<?= base_url() ?>penjualan/dl_format" class="btn btn-success"><i class="fa fa-download" class="btn btn-success"></i> Download Format</a>
          </div>
          </form>

          <!-- /.box-body -->

          <div class="box-body">
            Keterangan : <br>
            <font color='red'>*</font> Perhatian Upload dengan benar pada qty jika tidak benar akan di ubah jadi 0<br>
            <font color='red'>*</font> Data akan di replace ke data yang baru diupload<br>
            <font color='red'>*</font> Untuk melihat data yang terupload bisa kunjungi submenu export<br>

          </div>
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>


  <?php if (isset($fields) && isset($sheet)) { ?>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Data Siap Import</b></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>

            <form>
              <div class="box-body">
                <br><br>
                <table class="table">


                  <thead>
                    <tr>
                      <!-- Header -->
                      <?php foreach ($fields as $field) : ?>
                        <th scope="col"><?= strtoupper($field) ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>

                  <!-- Data -->
                  <tbody>
                    <?php $i = 0;
                    foreach ($sheet as $row) : ?>
                      <tr class="clickable">

                        <?php
                        // skip the first row(header row)
                        if ($i == 0) {
                          $i++;
                        } else {
                          foreach ($letters as $col) {
                            // if any col are empty, give a style color
                            $null_col = (!empty($row[$col])) ? "" : " style='background: #fdd835;'";
                            echo '<td class="view"' . $null_col . '>' . $row[$col] . '</td>';
                          }
                        }
                        ?>

                      </tr>
                    <?php endforeach; ?>

                  </tbody>
                </table>
              </div>
              <div class="box-footer">
                <a href="<?= base_url() ?>penjualan/import" class="btn btn-success"><i class="fa fa-sign-in"></i> Import</a>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /.row -->


    </section>
  <?php } ?>

  <section class="content">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Hasil Import Permenu</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body" id='penyesuaian'>
        <a href="<?= base_url('penjualan/excelpermenu') ?>"><button class="btn btn-success"><i class="fa fa-download"></i> Download </button></a><br><br>
        <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
          <thead>
            <tr>
              <th style="width: 10px;">No</th>
              <th>Nama Import</th>
              <th>Nama Menu</th>
              <th>Qty Import</th>
              <th> Resep Menu</th>
              <th> Resep Varian</th>
              <th>Total</th>
              <th>HPP</th>
            </tr>
          </thead>

        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->



  </section>



  <section class="content">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Hasil Import Peritem</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body" id='penyesuaian'>
        <a href="<?= base_url('penjualan/excelperitem') ?>"><button class="btn btn-success"><i class="fa fa-download"></i> Download </button></a><br><br>
        <table id="manageTable2" class="table table-bordered table-striped" style="width: 100%;">
          <thead>
            <tr>
              <th style="width: 10px;">No</th>
              <th>Nama Item</th>
              <th>Qty Total</th>
              <th>1/Harga</th>
              <th>Harga Total</th>
            </tr>
          </thead>

        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->



  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php if (in_array('deletepenjualan', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Menghapus Item</h4>
        </div>

        <form role="form" action="<?php echo base_url('penjualan/remove') ?>" method="post" id="removeForm">
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
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {

    $("#mainpenjualanNav").addClass('active');
    $("#addexportNav").addClass('active');

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'penjualan/fetchimport',
      'order': []
    });


    // initialize the datatable 
    manageTable = $('#manageTable2').DataTable({
      'ajax': base_url + 'penjualan/fetchimportitem',
      'order': []
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