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
      Data Barang
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

        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-book"></i> Tambah Data Barang</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('stock/databarang') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Masukkan Nama Produk" autocomplete="off" />
              </div>

              <?php

              $user_id = $this->session->userdata('id');
              $div = $this->session->userdata('divisi');

              if ($div == 0) {
                echo '<div class="form-group"><label>Outlet</label><select name="outlet" class="form-control">';
                foreach ($store as $k => $v) {
                  echo '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
                }
                echo '</select></div>';

                echo '
                <div class="form-group">
                  <label for="Bagian">Bagian</label><br>

                <select name="bagian"  class="form-control">
                  <?php ?>
                   <option value="1" >Bar & Kasir</option>
                   <option value="2">Waiter</option>
                   <option value="3">Dapur</option>
                 </select>
                </div>';
              } elseif ($div == 11) {
                echo '
                <div class="form-group">
                  <label for="Bagian">Bagian</label><br>

                <select name="bagian"  class="form-control">
                  <?php ?>
                   <option value="1" >Bar & Kasir</option>
                   <option value="2">Waiter</option>
                   <option value="3">Dapur</option>
                 </select>
                </div>';
              } else {
                if ($div == 1) {
                  $bagian = 'Bar & Kasir';
                } elseif ($div == 2) {
                  $bagian = 'Waiter';
                } elseif ($div == 3) {
                  $bagian = 'Kitchen';
                };
                echo '<div class="form-group">
                  <label for="Bagian">Bagian</label><br>

                <select name="bagian"  class="form-control">
                  <?php ?>
                   <option value="' . $div . '" >' . $bagian . '</option>
                 </select>
                </div>';
              }
              ?>




              <div class="form-group">
                <label for="satuan">Satuan</label><br>

                <select name="satuan" class="form-control">
                  <option value="Pcs">Pcs</option>
                  <option value="Pck">Pck</option>
                  <option value="Klg">Klg</option>
                  <option value="Kg">Kg</option>
                  <option value="Gr">Gr</option>
                  <option value="Jrg">Jrg</option>
                  <option value="Dus">Dus</option>
                  <option value="Btl">Btl</option>
                  <option value="Box">Box</option>
                  <option value="Bks">Bks</option>
                  <option value="Btr">Btr</option>
                  <option value="Por">Porsi</option>
                </select>
              </div>


              <div class="form-group">
                <label for="kategori">Category</label><br>

                <select name="kategori" class="form-control">
                  <option value="1">Bahan Baku</option>
                  <option value="2">Supply</option>
                  <option value="3">Perlengkapan</option>
                </select>
              </div>

              <div class="form-group">
                <label for="harga">Harga Produk</label>
                <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan Harga Produk" autocomplete="off" />
              </div>



            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
            </div>
          </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->





    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><b><i class="fa fa-book"></i> Data Barang</b></h3>

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
              <?php if (in_array('updatestock', $user_permission)  || in_array('deletestock', $user_permission)) : ?>

                <?php if ($div == 11) {
                  echo $data = '<th style="min-width: 5px;">Opsi</th>';
                } elseif ($div == 1 or $div == 2 or $div == 3) {
                  echo $data = '<th style="min-width: 5px;">Opsi</th>';
                } ?>

              <?php endif; ?>
              <?php if ($div == 0) : ?>
                <th style="max-width: 3%;">Opsi</th>
                <th style="max-width: 3%;">Profit</th>
              <?php endif; ?>
              <th>Nama Produk</th>
              <th>Store</th>
              <th>Category</th>
              <th>Harga</th>
              <th>Bagian</th>
              <th>Satuan</th>
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


<?php if (in_array('deletestock', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Hapus Data Barang</h4>
        </div>

        <form role="form" action="<?php echo base_url('stock/removedb') ?>" method="post" id="removeForm">
          <div class="modal-body">
            <p>Yakin Ingin Menghapus Data Barang?</p>
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
    $("#mainstockNav").addClass('active');
    $("#addstocknbNav").addClass('active');


    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'stock/fetchstockDatabarang',
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


  function uploadharga(id) {
    Swal.fire({
      title: 'Anda Yakin?',
      text: "Semua harga distok sebelumnya akan berubah !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ubah'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "<?= base_url('stock/uploadkestock/') ?>" + id;
      }
    })
  }
</script>