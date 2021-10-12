

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Produk</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">


       

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



        <div class="box  box-solid">
          <div class="box-header">
            <h3 class="box-title">Manage Produk</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body" style="overflow: auto;">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Tanggal</th>
                <th>Nama Produk</th>
                <th>SKU</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Total Harga</th>
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

<?php if(in_array('deleteProduct', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Menghapus Produk</h4>
      </div>

      <form role="form" action="<?php echo base_url('products/remove') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>Yakin Ingin Menghapus?</p>
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

$(document).ready(function() {

  $("#mainProductNav").addClass('active');
  $("#laporanp").addClass('active');
  $("#stocklaporanp").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'products/fetchlaporanstock',
    'order': []
  });

});

// remove functions 
function removeFunc(id)
{
  if(id) {
    $("#removeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { product_id:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
           
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

            $("#removeModal").modal('hide');
          }
        }
      }); 

      return false;
    });
  }
}


</script>
