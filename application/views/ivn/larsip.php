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
      Arsip
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


        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Laporan Arsip Bulanan</b></h3>

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
                  <th>Bulan</th>
                  <th>Nama</th>
                  <th>Bagian</th>
                  <th>Jumlah</th>
                  <th>Tahun</th>
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
    $("#manageivn").addClass('active');
    $("#ivnarsipNav").addClass('active');



    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'ivn/tampilarsip',
      'order': []
    });

  });
</script>