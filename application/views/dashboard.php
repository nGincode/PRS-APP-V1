<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <?php if ($is_admin == 1) : ?>

      <div class="row">

        <!-- admin system -->
        <?php if ($group_id == 1) : ?>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?php echo $total_users; ?></h3>

                <p>Total Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-people"></i>
              </div>
              <a href="<?php echo base_url('users/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo $total_stores ?></h3>

                <p>Total Stores</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-home"></i>
              </div>
              <a href="<?php echo base_url('stores/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        <?php endif; ?>

        <!-- admin logistik -->
        <?php if ($group_id == 2) : ?>
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $total_products ?></h3>

                <p>Total Barang</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url('products/') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php echo $total_paid_orders ?></h3>

                <p>Total Order Terbayar</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('orders/') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo $total_paid_notorders ?></h3>

                <p>Total Order Belum Terbayar</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url('orders/') ?>" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>


          <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="box box-warning box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title"><b> Produk Qty Low</b></h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                    <!-- /.box-tools -->
                  </div>
                  <div class="box-body" id='penyesuaian'>
                    <table id="manageTable2" class="table table-bordered table-striped" style="width: 100%;">
                      <thead>
                        <tr>
                          <th style="width: 100px;">SKU</th>
                          <th>Nama Produk</th>
                          <th>Qty</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="box box-danger box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title"><b> Produk Hampir Kadaluarsa</b></h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                    <!-- /.box-tools -->
                  </div>
                  <div class="box-body" id='penyesuaian'>
                    <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
                      <thead>
                        <tr>
                          <th style="width: 100px;">SKU</th>
                          <th>Nama Produk</th>
                          <th>Tgl Kadaluarsa</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </section>


          <!-- ./col -->
        <?php endif; ?>

        <!-- office -->
        <?php if ($group_id > 2) : ?>

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php echo $total_paid_orders_dsall ?></h3>

                <p>Total Order</p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-cart"></i>
              </div>
              <a href="<?php echo base_url('orders/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $total_ivn_dsall ?></h3>

                <p>Total Inventaris</p>
              </div>
              <div class="icon">
                <i class="fa fa-cubes"></i>
              </div>
              <a href="<?php echo base_url('ivn/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
                <h3><?php echo $total_pegawai_dsall ?></h3>

                <p>Total Pegawai</p>
              </div>
              <div class="icon">
                <i class="fa fa-group"></i>
              </div>
              <a href="<?php echo base_url('pegawai/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-teal">
              <div class="inner">
                <h3><?php echo $total_pengadaan_ds ?></h3>

                <p>Total Pengadaan</p>
              </div>
              <div class="icon">
                <i class="fa fa-download"></i>
              </div>
              <a href="<?php echo base_url('pengadaan/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        <?php endif; ?>

      </div>




    <?php elseif ($is_admin == 2) : ?>
      <!-- Leader -->
      <div class="row">

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $total_ivn_ds ?></h3>

              <p>Total Inventaris</p>
            </div>
            <div class="icon">
              <i class="fa fa-cubes"></i>
            </div>
            <a href="<?php echo base_url('ivn/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-teal">
            <div class="inner">
              <h3><?php echo $total_pengadaan_ds ?></h3>

              <p>Total Pengadaan</p>
            </div>
            <div class="icon">
              <i class="fa fa-download"></i>
            </div>
            <a href="<?php echo base_url('pengadaan/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $total_pegawai_ds ?></h3>

              <p>Total Pegawai</p>
            </div>
            <div class="icon">
              <i class="fa fa-group"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $total_paid_orders_ds ?></h3>

              <p>Total Orders</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="<?php echo base_url('orders/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->



        <!-- ./col -->
      </div>
      <!-- /.row -->

    <?php elseif ($is_admin == 3) : ?>
      <!-- Divisi -->
      <div class="row">

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $total_ivn_dsdiv ?></h3>

              <p>Total Inventaris</p>
            </div>
            <div class="icon">
              <i class="fa fa-cubes"></i>
            </div>
            <a href="<?php echo base_url('ivn/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-teal">
            <div class="inner">
              <h3><?php echo $total_pengadaan_dsdiv ?></h3>

              <p>Total Pengadaan</p>
            </div>
            <div class="icon">
              <i class="fa fa-download"></i>
            </div>
            <a href="<?php echo base_url('pengadaan/') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->



        <!-- ./col -->
      </div>

      <!-- /.row -->





    <?php endif; ?>




  </section>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#dashboardMainMenu").addClass('active');
  });


  var manageTable;
  var manageTable2;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'products/kadaluarsa',
      'order': []
    });


    manageTable2 = $('#manageTable2').DataTable({
      'ajax': base_url + 'products/qtylow',
      'order': []
    });

  });
</script>

</script>