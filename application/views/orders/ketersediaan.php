<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Ketersediaan
      <small>Produk</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Orders</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>


        <div class="box box-warning box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> <b>Ketersediaan</b></h3>

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
                  <th style="text-align: center;">SKU</th>
                  <th style="text-align: center;">Nama</th>
                  <th style="text-align: center;">Rp./1</th>
                  <th style="text-align: center;">Qty</th>
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


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script type="text/javascript">
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {

    $("#mainOrdersNav").addClass('active');
    $("#ketersediaanOrdersNav").addClass('active');

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'products/orderdata',
      'order': []
    });

  });
</script>