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
      Barang Keluar
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


        <?php if ($div != 0) { ?>
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Inventaris Keluar</b></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php base_url('ivn/lkeluar') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body" id='penyesuaian'>

                <?php echo validation_errors(); ?>
                <table class="table table-bordered" id="ivn_info_table" style="width: 100%;">
                  <thead>
                    <th style="width:40%;min-width:200px;text-align: center;">Nama</th>
                    <th style="width:20%;min-width:100px;text-align: center;">Jumlah</th>
                    <th style="width:40%;min-width:100px;text-align: center;">Ket.</th>
                    <th style="max-width:100px;text-align: center;"><i class="fa fa-sign-in"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <select class="form-control select_group product" id="nama" name="nama" style="width:100%;" required>
                          <option value="">Pilih Inventaris</option>
                          <?php foreach ($ivn as $k => $v) : ?>
                            <option value="<?php echo $v['id'] ?>"><?php echo $v['nama'] ?> (<?php echo $v['bagian'] ?>)</option>
                          <?php endforeach ?>
                        </select>
                      </td>
                      <input type="hidden" class="form-control" id="tgl_keluar" required name="tgl_keluar" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" />

                      <td>
                        <input type="number" name="jumlah" id="jumlah" required class="form-control" placeholder="Barang Keluar" autocomplete="off">
                      </td>
                      <td>
                        <input type="text" name="ke" id="ke" class="form-control" placeholder="Ket." autocomplete="off">
                      </td>
                      <td>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>





                <!-- /.box-body -->
              </div>
            </form>
            <!-- /.box -->
          </div>
        <?php } ?>

        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Data Inventaris Keluar</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>



          <!-- /.box-header -->
          <div class="box-body" id='penyesuaian'>
            <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <?php if ($div == 0) { ?>
                    <th style="max-width:30px;text-align: center;"> Opsi</th>
                    <th>Store</th>
                  <?php } ?>
                  <th>Tanggal</th>
                  <th>Nama</th>
                  <th>Bagian</th>
                  <th>Tujuan</th>
                  <th>Jumlah</th>
                  <th>Harga</th>
                  <th>Total</th>
                </tr>
              </thead>

            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Hapus </h4>
      </div>

      <form role="form" action="<?php echo base_url('ivn/removekeluar') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>Yakin Ingin Menghapus ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Hapus</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainivnNav").addClass('active');
    $("#ivnkeluarNav").addClass('active');



    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'ivn/laporanivnkeluar',
      'order': []
    });

  });

  function ubahjml(jml, nama, id) {
    Swal.fire({
      title: 'Yakin ingin mengubah?',
      text: "Anda akan merubah " + nama,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ubah'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: 'ubahjmlkeluar',
          data: {
            'id': id,
            'nama': nama,
            'jml': jml
          },
          success: function(data) {
            if (data == 1) {

              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: nama + ' Berhasil di Ubah',
                showConfirmButton: false,
                timer: 1500
              })
            } else if (data == 9) {
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Data tidak diketahui',
                showConfirmButton: false,
                timer: 1500
              })
            } else {
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Terjadi Kesalahan !!',
                showConfirmButton: false,
                timer: 1500
              })
            }
          }
        })
      }
    })
  }

  function ubahhrg(jml, nama, id) {
    Swal.fire({
      title: 'Yakin ingin mengubah?',
      text: "Anda akan merubah " + nama,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ubah'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: 'ubahhrgkeluar',
          data: {
            'id': id,
            'nama': nama,
            'jml': jml
          },
          success: function(data) {
            if (data == 1) {

              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: nama + ' Berhasil di Ubah',
                showConfirmButton: false,
                timer: 1500
              })
            } else if (data == 9) {
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Data tidak diketahui',
                showConfirmButton: false,
                timer: 1500
              })
            } else {
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Terjadi Kesalahan !!',
                showConfirmButton: false,
                timer: 1500
              })
            }
          }
        })
      }
    })
  }


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
</script>