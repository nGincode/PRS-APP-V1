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
      <small>Inventaris</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Inventaris</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <script type="text/javascript">
          function sweet() {
            Swal.fire({
              title: 'Jadikan Laporan Bulan Ini?',
              text: "Jika Terupload Tidak Dapat di Ubah",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Oke'
            }).then((result) => {
              if (result.isConfirmed) {
                //var updatebln = "<?php echo base_url('ivn/updatebln'); ?>";
                var url = "<?php echo base_url('ivn/arsip'); ?>";


                //$.ajax({
                //    url : updatebln,
                //    type: "POST",
                //});


                $.ajax({
                  url: url,
                  type: "POST",
                  success: function() {
                    Swal.fire(
                      'Berhasil',
                      'Data Anda Terupload Harap Jangan Klik Arsip lagi',
                      'success'
                    )
                  }
                });


              }
            });
          }
        </script>

        <?php
        $tgl = date('d');
        $notif = "'Jadikan Laporan Bulan Ini?'";

        if ($tgl == 27) {
          echo $html = '<button href="' . base_url("ivn/") . '" onclick="sweet()" class="btn btn-primary" style=" float: right;"><i class="fa fa-sign-in"></i> Arsipkan</button><br><br>';
        }
        if ($tgl == 28) {
          echo $html = '<button href="' . base_url("ivn/") . '" onclick="sweet()" class="btn btn-primary" style=" float: right;"><i class="fa fa-sign-in"></i> Arsipkan</button><br><br>';
        }
        ?>

        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Manage Inventaris</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body" id='penyesuaian'>

            <?php if ($div == 0 or $div == 11) { ?>
              <div style="position:relative;z-index: 9; margin:10px; display: flex;">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Export <span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="ivn/laporanasset"><i class="fa fa-print"></i> Print</a></li>
                </ul>
              </div>
              <hr>
            <?php } ?>

            <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <?php if (in_array('updateivn', $user_permission) || in_array('deleteivn', $user_permission)) : ?>
                    <th style="width: 5px;">Opsi</th>
                  <?php endif; ?>
                  <?php
                  $div = $this->session->userdata['divisi'];
                  if ($div == 0) : ?>
                    <th>Store</th>
                  <?php endif; ?>
                  <th>Gambar</th>
                  <th>Bagian</th>
                  <th>Nama</th>
                  <th>Harga</th>
                  <th>Jumlah</th>
                </tr>
              </thead>

            </table>
          </div>
          <!-- /.box-body -->
        </div>

        <?php if ($div == 0 or $div == 11) { ?>
          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Laporan Inventaris</b></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>

            <form action="<?php echo base_url('ivn/proseslaporan') ?>" method="post" class="form-horizontal">
              <div class="box-body">

                <?php echo validation_errors(); ?>


                <div class="col-md-4 col-xs-12 pull pull-left">

                  <br>
                  <div class="form-group">
                    <label class="col-sm-5 control-label" style="text-align:left;">Tanggal Awal :</label>
                    <div class="col-sm-7">

                      <div class="input-group date">
                        <div class="input-group-addon ">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" value="<?= date('Y-m-d', mktime(0, 0, 0, date("m"), '1', date("Y"))); ?>" required name="tgl_awal" class="form-control pull-right">
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
                        <input type="date" name="tgl_akhir" required class="form-control pull-right">
                      </div>

                    </div>
                  </div>


                </div>

              </div>

              <div class="box-footer">
                <button type="submit" class="btn btn-app"><i class="fa fa-file-excel-o"></i> Excel</button>
              </div>
            </form>
          </div>
        <?php } ?>

        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->



  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php if (in_array('deleteivn', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Menghapus Inventaris</h4>
        </div>

        <form role="form" action="<?php echo base_url('ivn/remove') ?>" method="post" id="removeForm">
          <div class="modal-body">
            <p>Yakin Ingin Menghapus?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
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

    $("#mainivnNav").addClass('active');
    $("#manageivn").addClass('active');
    $("#manageivnNav").addClass('active');

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'ivn/fetchivnData',
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
            ivn_id: id
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