

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Laporan
      <small>Produk</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products</li>
    </ol>
  </section>

  <!-- Main content -->
<section class="content">


 
              <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Barang Keluar</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>


          <!-- /.box-header -->
          <div class="box-body" style="overflow: auto;">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Bill no</th>
                <th>Nama Penerima</th>
                <th>Outlet</th>
                <th>No Hp</th>
                <th>Waktu</th>
                <th>Total</th>
                <th>Jumlah</th>
                <th>Status</th>
                  <th>Action</th>
              </tr>
              </thead>

            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
        
          <br />
<form action="<?php echo site_url('products/cetaklaporankeluar') ?>" method="post">
      <center><label style="font-size: 30px">Cetak Laporan Stock Keluar</label></center><br>
      <label>Dari : </label><br><input type="date"  name="tgl_awal" class="form-control" required=""><br>
      <label>Sampai : </label><br><input type="date"  name="tgl_akhir" class="form-control" required=""><br><br>
      <center><button class="btn btn-success" name=tgl type="submit"><i class="fa fa-print"></i> Cetak</button></center>
</form>
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

  $("#mainProductNav").addClass('active');
  $("#ProductkeluarNav").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'products/laporankeluar', 
    'order': []
  });




});



</script>
<script type="text/javascript">
  function upload(id){
  Swal.fire({
  title: 'Yakin ingin Upload?',
  text: "Data akan langsung mengurangi stock & tidak bisa diubah",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Upload'
}).then((result) => {
  if (result.isConfirmed) {
    

Swal.fire({
  title: 'Sedang Memperoses',
  timer: 3000,
  timerProgressBar: true,
  showConfirmButton: false,
  backdrop: 'rgba(175, 175, 177, 0.92)',
  onBeforeOpen: () => {
   Swal.showLoading()
    timerInterval = setInterval(() => {
      Swal.getContent().querySelector('b')
    }, 100)
  },
  onClose: () => {
    clearInterval(timerInterval)
  }
}); setTimeout(function(){ 

   window.location.href = 'status_up/'+id;

}, 3000); 



  }
})
}
</script>






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

