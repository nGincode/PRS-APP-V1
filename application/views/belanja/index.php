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
      <small>Belanja</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Belanja</li>
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
            <h3 class="box-title"><b>Manage Belanja</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->

          <div class="box-body" id='penyesuaian'>
            <table id="manageTable" class="table  table-bordered table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <th style=" width:5px;text-align: center;">Opsi</th>
                  <th style="text-align: center;">Tanggal</th>
                  <th style="text-align: center;">No Bill</th>
                  <th style="text-align: center;">Total</th>
                  <th style="text-align: center;">Status</th>
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

    <div class="box box-danger box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><b>Laporan Belanja</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>

      <form action="<?php echo base_url('belanja/excel') ?>" method="post" class="form-horizontal">
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
                  <input type="date" required name="tgl_awal" class="form-control pull-right">
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



  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<div id="printaera" style="position: absolute; z-index: -1;"></div>

<?php if (in_array('deletebelanja', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Hapus Belanja</h4>
        </div>

        <form role="form" action="<?php echo base_url('belanja/remove') ?>" method="post" id="removeForm">
          <div class="modal-body">
            <p>Yakin Ingin Menghapus Belanja?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
          </div>
        </form>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endif; ?>
<div class="modal fade" tabindex="-1" role="dialog" id="lihatBelnj">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Produk Belanja</h4>
      </div>

      <div class="box-body" style="overflow: auto;">
        <div id="lihatForm">
          <div id="datablj">
          </div>
        </div>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {

    $("#mainbelanjaNav").addClass('active');
    $("#managebelanjaNav").addClass('active');

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'belanja/fetchbelanjaData',
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
            belanja_id: id
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


  //print
  function receipt(id) {
    $.ajax({
      url: "<?= base_url('belanja/printDiv') ?>",
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

  function bekukan(id) {
    Swal.fire({
      title: 'Yakin akan di bekukan?',
      text: "Pada tanggal ini tidak akan bisa di tambah dan edit!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url('belanja/bekukan/') ?>" + id,
          type: 'POST',
          data: {
            id: id
          },
          success: function(data) {
            if (data == '') {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil...!',
                text: 'Data berhasil dibekukan',
                showConfirmButton: false,
                timer: 4000
              });
              manageTable.ajax.reload(null, false);
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Gagal...!',
                text: 'Terdapat Masalah',
                showConfirmButton: false,
                timer: 4000
              });

            }
          }
        });
      }
    })
  }
  // lihat functions 
  function lihatBelnj(id) {
    if (id) {
      $.ajax({
        url: "<?php echo base_url('belanja/lihatblj'); ?>",
        type: "POST",
        data: {
          id: id
        },
        success: function(data) {
          $('#datablj').html(data);
        }
      });

      return false;
    }
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/jQuery.print@1.5.1/jQuery.print.min.js"></script>