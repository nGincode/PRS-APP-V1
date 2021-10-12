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
      Barang Rusak
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


        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Inventaris Rusak/Hilang</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body" id='penyesuaian'>
            <form role="form" action="<?php base_url('ivn/lrusak') ?>" method="post" enctype="multipart/form-data">
              <?php echo validation_errors(); ?>
              <table class="table table-bordered" id="ivn_info_table" style="width: 100%;">
                <thead>
                  <th style="width:50%;min-width:100px;text-align: center;">Inventaris</th>
                  <th style="width:20%;min-width:100px;text-align: center;">Jumlah</th>
                  <th style="width:30%;min-width:200px;text-align: center;">Ket</th>
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
                    <input type="hidden" class="form-control" id="tgl_rusak" name="tgl_rusak" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" />

                    <td>
                      <input type="Number" name="jumlah" id="jumlah" required class="form-control" placeholder="Barang Yg Rusak" autocomplete="off">
                    </td>
                    <td>
                      <input type="text" name="ket" id="ket" class="form-control" required placeholder="Keterangan" autocomplete="off">
                    </td>
                    <td>
                      <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


        <br /> <br />


        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Data Inventaris Rusak/Hilang</b></h3>

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
                  <th>Tanggal</th>
                  <th>Nama</th>
                  <th>Bagian</th>
                  <th>Ket</th>
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

<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainivnNav").addClass('active');
    $("#ivnrusakNav").addClass('active');



    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'ivn/laporanivnrusak',
      'order': []
    });

  });
</script>