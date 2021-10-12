

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Pelaporan</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pelaporan</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

       

        <?php if($this->session->flashdata('success')):

echo "<script> Swal.fire({
              icon: 'success',
              title: 'Berhasil...!',
              text: '".$this->session->flashdata('success')."',
              showConfirmButton: false,
              timer: 4000
            });
</script>";

         ?>
            
        <?php elseif($this->session->flashdata('error')):
echo "<script> Swal.fire({
              icon: 'error',
              title: 'Maaf...!',
              text: '".$this->session->flashdata('error')."',
              showConfirmButton: false,
              timer: 4000
            });
</script>";

         ?>

            
        <?php endif; ?>


        <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Pelaporan</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('pelaporan/create') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                  <input type="hidden" class="form-control" id="tgl_input" name="tgl_input" autocomplete="off" value="<?php 
echo date('Y-m-d');?>" /> 
                <div class="form-group">
                  <label for="nama">Judul Pelaporan</label>
                  <input type="text" class="form-control" id="nama" required name="nama" placeholder="Masukkan Nama Inventaris" autocomplete="off"/>
                </div>


                <div class="form-group">
                  <label for="ket">Keterangan</label>
                  <textarea class="form-control" id="ket" required name="ket" placeholder="Keterangan" autocomplete="off" ></textarea> 
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                <a href="<?php echo base_url('ivn/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    


          <br /> <br />


        <div class="box box-solid">
          <div class="box-header">
            <h3 class="box-title">Data Pelaporan Terinput</h3>
          </div>


          <!-- /.box-header -->
          <div class="box-body" style="overflow: auto;">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Tanggal & Waktu</th>
                <th>Outlet</th>
                <th>Divisi</th>
                <th>Judul Pelaporan</th>
                <th>Keterangan</th>
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
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {

    $("#mainpelaporanNav").addClass('active');
    $("#addpelaporanNav").addClass('active');
    

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'pelaporan/fetchpelaporan',
    'order': []
  });

  });
</script>