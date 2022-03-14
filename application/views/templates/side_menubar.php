<?php
$divisi = $this->session->userdata['divisi'];
$id_user = $this->session->userdata['id'];
$user_data = $this->model_users->getUserData($id_user);



$CI = &get_instance();
$CI->load->model('model_stores');
$CI->load->model('model_orders');
$CI->load->model('model_users');

$store_id = $this->session->userdata('store_id');
if ($store_id) {
  $cek = $CI->model_stores->getStoresData($store_id);
} else {
  $cek = '';
}

$countbaca = $CI->model_orders->countbaca(1);

?>

<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->

  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src=" <?php if (file_exists('/uploads/logo/' . $this->session->userdata('logo'))) {
                      echo base_url('/uploads/logo/' . $this->session->userdata('logo'));
                    } else {
                      echo base_url('/uploads/ivn_image/unnamed.png');
                    } ?>" style="margin-top: 10px;" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $user_data['firstname'] . ' ' . $user_data['lastname']; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat">
            <i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu tree" data-widget="tree">
      <li class="header">
        <center>Menu Navigation</center>
      </li>
      <li id="dashboardMainMenu">
        <a href="<?php echo base_url('dashboard') ?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

      <?php if ($user_permission) : ?>


        <?php if (in_array('createpos', $user_permission) || in_array('updatepos', $user_permission) || in_array('viewpos', $user_permission) || in_array('deletepos', $user_permission)) : ?>
          <li class="treeview" id="mainposNav">
            <a href="#">
              <i class="fa fa-shopping-bag "></i>
              <span>Point Of Sales</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <?php if (in_array('createpos', $user_permission)) : ?>
                <li id="addposNav"><a href="<?php echo base_url('products/kasir') ?>"><i class="fa fa-sign-in"></i> Transaksi</a>
                </li>
              <?php endif; ?>

            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>
          <li class="treeview" id="mainUserNav">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>User</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if (in_array('createUser', $user_permission)) : ?>
                <li id="createUserNav"><a href="<?php echo base_url('users/create') ?>"><i class="fa fa-sign-in"></i>Tambah User</a></li>
              <?php endif; ?>

              <?php if (in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>
                <li id="manageUserNav"><a href="<?php echo base_url('users') ?>"><i class="fa fa-gear"></i> Manage User</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)) : ?>
          <li class="treeview" id="mainGroupNav">
            <a href="#">
              <i class="fa fa-files-o"></i>
              <span>Group</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if (in_array('createGroup', $user_permission)) : ?>
                <li id="addGroupNav"><a href="<?php echo base_url('groups/create') ?>"><i class="fa fa-sign-in"></i>Tambah Group</a></li>
              <?php endif; ?>
              <?php if (in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)) : ?>
                <li id="manageGroupNav"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-gear"></i>Manage Group</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createStore', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)) : ?>
          <li id="storeNav">
            <a href="<?php echo base_url('stores/') ?>">
              <i class="fa fa-home"></i> <span>Outlet</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (in_array('createbelanja', $user_permission) || in_array('updatebelanja', $user_permission) || in_array('viewbelanja', $user_permission) || in_array('deletebelanja', $user_permission)) : ?>
          <li class="treeview" id="mainbelanjaNav">
            <a href="#">
              <i class="fa fa-dollar"></i>
              <span>Belanja</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if (in_array('createbelanja', $user_permission)) : ?>
                <li id="addbelanjaNav"><a href="<?php echo base_url('belanja/create') ?>"><i class="fa fa-plus"></i> Tambah Belanja</a>
                </li>
              <?php endif; ?>

              <?php if (in_array('updatebelanja', $user_permission) || in_array('viewbelanja', $user_permission) || in_array('deletebelanja', $user_permission)) : ?>
                <li id="managebelanjaNav"><a href="<?php echo base_url('belanja') ?>"><i class="fa fa-gear"></i> Manage Belanja</a></li>
              <?php endif; ?>

            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)) : ?>
          <li class="treeview" id="mainProductNav">
            <a href="#">
              <i class="fa fa-cube"></i>
              <span>Barang Logistik</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <?php
              if ($cek['tipe'] == 2) { ?>
                <?php if (in_array('createProduct', $user_permission)) : ?>

                  <li id="addProductNav"><a href="<?php echo base_url('products/create') ?>"><i class="fa fa-plus"></i> Barang Baru</a>
                  </li>
                <?php endif; ?>

                <?php if (in_array('createProduct', $user_permission)) : ?>
                  <li id="ProductmasukNav"><a href="<?php echo base_url('products/bmasuk') ?>"><i class="fa fa-sign-in"></i> Barang Masuk</a></li>
                <?php endif; ?>

                <?php if (in_array('createProduct', $user_permission)) : ?>
                  <li id="ProductrusakNav"><a href="<?php echo base_url('products/rmasuk') ?>"><i class="fa fa-sign-in"></i> Barang Rusak</a></li>
                <?php endif; ?>

                <?php if (in_array('createProduct', $user_permission)) : ?>
                  <li id="ProductkeluarNav"><a href="<?php echo base_url('products/lkeluar') ?>"><i class="fa fa-sign-out"></i> Barang Keluar</a></li>
                <?php endif; ?>

                <?php if (in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)) : ?>
                  <li id="manageProductNav"><a href="<?php echo base_url('products') ?>"><i class="fa fa-gear"></i> Manage Barang</a></li>
                <?php endif; ?>

                <li class="treeview" id="laporanp">
                  <a href="#"><i class="fa fa-arrow-right"></i> Laporan
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">

                    <?php if (in_array('viewProduct', $user_permission)) : ?>
                      <li id="stocklaporanp"><a href="<?php echo base_url('products/laporanstockproduk') ?>"><i class="fa fa-window-maximize"></i> Arsip Barang</a></li>
                    <?php endif; ?>

                    <?php if (in_array('viewProduct', $user_permission)) : ?>
                      <li id="laporanproduk"><a href="<?php echo base_url('products/laporan') ?>"><i class="fa fa-print"></i> Print</a></li>
                    <?php endif; ?>

                  </ul>
                </li>
              <?php } else { ?>

                <li id="ProductkeluarNav"><a href="<?php echo base_url('products/lkeluar') ?>"><i class="fa fa-sign-out"></i> Barang Keluar</a></li>

              <?php } ?>
            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createpengadaan', $user_permission) || in_array('updatepengadaan', $user_permission) || in_array('viewpengadaan', $user_permission) || in_array('deletepengadaan', $user_permission)) : ?>
          <li class="treeview" id="mainpengadaanNav">
            <a href="#">
              <i class="fa fa-download"></i>
              <span>Pengadaan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <?php if (in_array('createpengadaan', $user_permission)) : ?>
                <li id="addpengadaanNav"><a href="<?php echo base_url('pengadaan/create') ?>"><i class="fa fa-sign-in"></i> Buat</a>
                </li>
              <?php endif; ?>

              <?php if (in_array('viewpengadaan', $user_permission)) : ?>
                <li id="managepengadaanNav"><a href="<?php echo base_url('pengadaan') ?>"><i class="fa fa-gear"></i>Manage</a></li>
              <?php endif; ?>

            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createPegawai', $user_permission) || in_array('updatePegawai', $user_permission) || in_array('viewPegawai', $user_permission) || in_array('deletePegawai', $user_permission)) : ?>
          <li class="treeview" id="mainPegawaiNav">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Pegawai</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">


              <?php if (in_array('viewPegawai', $user_permission)) : ?>
                <li id="absensiNav"><a href="<?php echo base_url('Pegawai/absensi') ?>"><i class="fa fa-address-card-o"></i>Absensi</a></li>
              <?php endif; ?>

              <?php
              if ($cek['tipe'] == 0) {  ?>
                <?php if (in_array('createPegawai', $user_permission)) : ?>
                  <li id="addPegawaiNav"><a href="<?php echo base_url('Pegawai/datapegawai') ?>"><i class="fa fa-sign-in"></i>Tambah</a>
                  </li>
                <?php endif; ?>

                <?php if (in_array('createPegawai', $user_permission)) : ?>
                  <li id="apraisalNav"><a href="<?php echo base_url('Pegawai/apraisal') ?>"><i class="fa fa-file-archive-o"></i>Apraisal</a></li>
                <?php endif; ?>


                <?php if (in_array('viewPegawai', $user_permission)) : ?>
                  <li id="managePegawaiNav"><a href="<?php echo base_url('Pegawai') ?>"><i class="fa fa-gear"></i>Manage</a></li>
                <?php endif; ?>
              <?php } ?>

            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createOmzet', $user_permission) || in_array('updateOmzet', $user_permission) || in_array('viewOmzet', $user_permission) || in_array('deleteOmzet', $user_permission)) : ?>
          <li class="treeview" id="mainOmzetNav">
            <a href="#">
              <i class="fa fa-money"></i>
              <span>Omzet</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <?php if (in_array('createOmzet', $user_permission)) : ?>
                <li id="addOmzetNav"><a href="<?php echo base_url('Omzet/create') ?>"><i class="fa fa-circle-o"></i>Tambah Omzet</a>
                </li>
              <?php endif; ?>

              <?php
              if ($divisi == 0) :
              ?>

                <?php if (in_array('viewOmzet', $user_permission)) : ?>
                  <li id="laporanNav"><a href="<?php echo base_url('Omzet/laporan') ?>"><i class="fa fa-circle-o"></i>Laporan</a></li>
                <?php endif; ?>

              <?php else : ?>



                <?php if (in_array('viewOmzet', $user_permission)) : ?>
                  <li id="manageOmzetNav"><a href="<?php echo base_url('Omzet') ?>"><i class="fa fa-circle-o"></i>Manage Omzet</a></li>
                <?php endif; ?>

              <?php endif; ?>

            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createivn', $user_permission) || in_array('updateivn', $user_permission) || in_array('viewivn', $user_permission) || in_array('deleteivn', $user_permission)) : ?>
          <li class="treeview" id="mainivnNav">
            <a href="#">
              <i class="fa fa-briefcase"></i>
              <span>Inventaris</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if (in_array('createivn', $user_permission)) : ?>
                <li id="addivnNav"><a href="<?php echo base_url('ivn/create') ?>"><i class="fa fa-plus"></i> Baru</a>
                </li>
              <?php endif; ?>

              <?php if (in_array('createivn', $user_permission)) : ?>
                <li id="ivnmasukNav"><a href="<?php echo base_url('ivn/bmasuk') ?>"><i class="fa fa-sign-in"></i> Masuk</a></li>
              <?php endif; ?>


              <?php if (in_array('createivn', $user_permission)) : ?>
                <li id="ivnkeluarNav"><a href="<?php echo base_url('ivn/lkeluar') ?>"><i class="fa fa-sign-out"></i> Keluar</a></li>
              <?php endif; ?>

              <?php if (in_array('createivn', $user_permission)) : ?>
                <li id="ivnrusakNav"><a href="<?php echo base_url('ivn/lrusak') ?>"><i class="fa fa-refresh"></i> Rusak/Hilang</a></li>
              <?php endif; ?>



              <li class="treeview" id="manageivn">
                <a href="#"><i class="fa fa-gear"></i> Manage
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">


                  <?php if (in_array('updateivn', $user_permission) || in_array('viewivn', $user_permission) || in_array('deleteivn', $user_permission)) : ?>
                    <li id="manageivnNav"><a href="<?php echo base_url('ivn') ?>"><i class="fa fa-gear"></i>Manage Inventaris</a></li>
                  <?php endif; ?>

                  <?php if (in_array('viewivn', $user_permission)) : ?>
                    <li id="ivnarsipNav"><a href="<?php echo base_url('ivn/larsip') ?>"><i class="fa fa-archive"></i>Arsip</a></li>
                  <?php endif; ?>
                </ul>
              </li>
            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createstock', $user_permission) || in_array('updatestock', $user_permission) || in_array('viewstock', $user_permission) || in_array('deletestock', $user_permission)) : ?>
          <li class="treeview" id="mainstockNav">
            <a href="#">
              <i class="fa fa-cubes"></i>
              <span>Stock</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if (in_array('createstock', $user_permission)) : ?>
                <li id="addstocknbNav"><a href="<?php echo base_url('stock/databarang') ?>"><i class="fa fa-book"></i>Data Barang</a>
                </li>
              <?php endif; ?>

              <?php if (in_array('createstock', $user_permission)) : ?>
                <li id="addstockNav"><a href="<?php echo base_url('stock/datastock') ?>"><i class="fa fa-stack-overflow "></i>Data Stock</a>
                </li>
              <?php endif; ?>


              <?php if (in_array('createstock', $user_permission)) : ?>
                <li id="laporstockNav"><a href="<?php echo base_url('stock/laporanstore') ?>"><i class="fa fa-file-text-o"></i>Laporan</a>
                </li>
              <?php endif; ?>


              <?php

              if ($divisi == 0) {
                echo $data = '<li id="addstocknbNav"><a href="' . base_url('stock/databarang') . '"><i class="fa fa-book"></i>Data Barang</a>
                  </li><li id="laporanstockNav"><a href="' . base_url('stock/laporan') . '"><i class="fa fa-file-text-o"></i>Laporan Office</a>
                  </li></li><li id="tambahstockNav"><a href="' . base_url('stock/tambah') . '"><i class="fa fa-sign-in"></i>Tambah Satuan</a>
                  </li>';
              }
              ?>
              <?php if (in_array('updatestock', $user_permission) || in_array('viewstock', $user_permission) || in_array('deletestock', $user_permission)) : ?>
                <li id="managestockNav"><a href="<?php echo base_url('stock') ?>"><i class="fa fa-gear"></i>Manage Stock</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)) : ?>
          <li class="treeview" id="mainOrdersNav">
            <a href="#">
              <i class="fa fa-shopping-cart"></i>
              <span>Orders</span>
              <span class="pull-right-container">
                <?php
                if ($countbaca) {
                  if ($divisi == 0) {
                    echo ' <span class="label label-primary pull-right">' . $countbaca . '</span>';
                  } else {
                    echo '<i class="fa fa-angle-left pull-right"></i>';
                  }
                } else {
                  echo '<i class="fa fa-angle-left pull-right"></i>';
                }
                ?>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if (in_array('createOrder', $user_permission)) : ?>
                <li id="addOrderNav"><a href="<?php echo base_url('orders/create') ?>"><i class="fa fa-plus"></i> Tambah Order</a></li>
              <?php endif; ?>

              <?php if (in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)) : ?>
                <li id="manageOrdersNav"><a href="<?php echo base_url('orders') ?>"><i class="fa fa-gear"></i> Manage Orders</a></li>
              <?php endif; ?>

              <li id="ketersediaanOrdersNav"><a href="<?php echo base_url('orders/Ketersediaan') ?>"><i class="fa fa-archive"></i> Ketersediaan</a></li>
            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createabsen', $user_permission) || in_array('updateabsen', $user_permission) || in_array('viewabsen', $user_permission) || in_array('deleteabsen', $user_permission)) : ?>
          <li class="treeview" id="mainabsenNav">
            <a href="#">
              <i class="fa fa-user-o"></i>
              <span>Absen Office & Logistik</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <?php if (in_array('createabsen', $user_permission)) : ?>
                <li id="addabsenNav"><a href="<?php echo base_url('absen/create') ?>"><i class="fa fa-circle-o"></i>Tambah Absen</a>
                </li>
              <?php endif; ?>

              <?php if (in_array('viewabsen', $user_permission)) : ?>
                <li id="laporanNav"><a href="<?php echo base_url('absen/laporan') ?>"><i class="fa fa-circle-o"></i>Laporan</a></li>
              <?php endif; ?>


              <?php if (in_array('viewabsen', $user_permission)) : ?>
                <li id="manageabsenNav"><a href="<?php echo base_url('absen') ?>"><i class="fa fa-circle-o"></i>Manage Absen</a></li>
              <?php endif; ?>

            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createvocp', $user_permission) || in_array('updatevocp', $user_permission) || in_array('viewvocp', $user_permission) || in_array('deletevocp', $user_permission)) : ?>
          <li class="treeview" id="mainvocpNav">
            <a href="#">
              <i class="fa fa-ticket"></i>
              <span>Vocuher Claim</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <?php if (in_array('createvocp', $user_permission)) : ?>
                <li id="addvocpNav"><a href="<?php echo base_url('voc_peg/scan') ?>"><i class="fa fa-barcode"></i> Scan Voucher</a>
                </li>
              <?php endif; ?>

              <?php if (in_array('viewvocp', $user_permission)) : ?>
                <li id="managevocpNav"><a href="<?php echo base_url('voc_peg') ?>"><i class="fa fa-circle-o"></i>Manage</a></li>
              <?php endif; ?>

            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createpelaporan', $user_permission) || in_array('updatepelaporan', $user_permission) || in_array('viewpelaporan', $user_permission) || in_array('deletepelaporan', $user_permission)) : ?>
          <li class="treeview" id="mainpelaporanNav">
            <a href="#">
              <i class="fa fa-microphone"></i>
              <span>Pelaporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <?php if (in_array('createpelaporan', $user_permission)) : ?>
                <li id="addpelaporanNav"><a href="<?php echo base_url('pelaporan/create') ?>"><i class="fa fa-sign-in"></i> Buat</a>
                </li>
              <?php endif; ?>

              <?php if (in_array('viewpelaporan', $user_permission)) : ?>
                <li id="managepelaporanNav"><a href="<?php echo base_url('pelaporan') ?>"><i class="fa fa-gear"></i>Manage</a></li>
              <?php endif; ?>

            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createpelanggan', $user_permission) || in_array('updatepelanggan', $user_permission) || in_array('viewpelanggan', $user_permission) || in_array('deletepelanggan', $user_permission)) : ?>
          <li class="treeview" id="mainpelangganNav">
            <a href="#">
              <i class="fa fa-address-card"></i>
              <span>Pelanggan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <?php if (in_array('createpelanggan', $user_permission)) : ?>
                <li id="addpelangganNav"><a href="<?php echo base_url('pelanggan/create') ?>"><i class="fa fa-sign-in"></i> Buat</a>
                </li>
              <?php endif; ?>

              <?php if (in_array('viewpelanggan', $user_permission)) : ?>
                <li id="managepelangganNav"><a href="<?php echo base_url('pelanggan') ?>"><i class="fa fa-gear"></i>Manage</a></li>
              <?php endif; ?>

            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createpenjualan', $user_permission) || in_array('updatepenjualan', $user_permission) || in_array('viewpenjualan', $user_permission) || in_array('deletepenjualan', $user_permission)) : ?>
          <li class="treeview" id="mainpenjualanNav">
            <a href="#">
              <i class="fa fa-dollar"></i>
              <span>Penjualan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <?php if (in_array('createpenjualan', $user_permission)) : ?>
                <li id="addpenjualanNav"><a href="<?php echo base_url('penjualan/item') ?>"><i class="fa fa-sign-in"></i> Item Resep</a>
                </li>
              <?php endif; ?>


              <?php if (in_array('createpenjualan', $user_permission)) : ?>
                <li id="addresepNav"><a href="<?php echo base_url('penjualan/resep') ?>"><i class="fa fa-sign-in"></i> Resep</a>
                </li>
              <?php endif; ?>


              <?php if (in_array('createpenjualan', $user_permission)) : ?>
                <li id="addimportNav"><a href="<?php echo base_url('penjualan/check_import') ?>"><i class="fa fa-sign-in"></i> Import Excel</a>
                </li>
              <?php endif; ?>


              <?php if (in_array('createpenjualan', $user_permission)) : ?>
                <li id="addexportNav"><a href="<?php echo base_url('penjualan/export') ?>"><i class="fa fa-sign-in"></i> Export</a>
                </li>
              <?php endif; ?>

            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createvoucher', $user_permission) || in_array('updatevoucher', $user_permission) || in_array('viewvoucher', $user_permission) || in_array('deletevoucher', $user_permission)) : ?>
          <li class="treeview" id="mainvoucherNav">
            <a href="#">
              <i class="fa fa-ticket"></i>
              <span>Voucher</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <?php if (in_array('viewvoucher', $user_permission)) : ?>
                <li id="viewvoucherNav"><a href="<?php echo base_url('voucher/data') ?>"><i class="fa fa-sign-in"></i> Data</a>
                </li>
              <?php endif; ?>


              <?php if (in_array('createvoucher', $user_permission)) : ?>
                <li id="addvoucherNav"><a href="<?php echo base_url('voucher/create') ?>"><i class="fa fa-sign-in"></i> Create</a>
                </li>
              <?php endif; ?>


            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createdapro', $user_permission) || in_array('updatedapro', $user_permission) || in_array('viewdapro', $user_permission) || in_array('deletedapro', $user_permission)) : ?>
          <li class="treeview" id="maindaproNav">
            <a href="#">
              <i class="fa fa-cube"></i>
              <span>Dapur Produksi</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <?php if (in_array('createdapro', $user_permission)) : ?>
                <li id="bahanmatah"><a href="<?php echo base_url('dapro/bahanmatah') ?>"><i class="fa fa-sign-in"></i> Bahan Baku</a>
                </li>
              <?php endif; ?>


              <?php if (in_array('createdapro', $user_permission)) : ?>
                <li id="hasil"><a href="<?php echo base_url('dapro/hasil') ?>"><i class="fa fa-sign-in"></i> Resep to produk</a>
                </li>
              <?php endif; ?>


              <?php if (in_array('viewdapro', $user_permission)) : ?>
                <li id="daprokeluar"><a href="<?php echo base_url('dapro/keluar') ?>"><i class="fa fa-sign-out"></i> Produk Keluar</a>
                </li>
              <?php endif; ?>


              <?php if (in_array('viewdapro', $user_permission)) : ?>
                <li id="laporan"><a href="<?php echo base_url('dapro/laporan') ?>"><i class="fa fa-file-text-o"></i> Laporan</a>
                </li>
              <?php endif; ?>

              <!-- <?php if (in_array('viewdapro', $user_permission)) : ?>
                <li id="managedaproNav"><a href="<?php echo base_url('dapro') ?>"><i class="fa fa-gear"></i>Manage</a></li>
              <?php endif; ?> -->

            </ul>
          </li>
        <?php endif; ?>

        <li class="header">Settings</li>

        <?php if (in_array('viewProfile', $user_permission)) : ?>
          <li id="profNav"><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-o"></i> <span>Profil</span></a></li>
        <?php endif; ?>
        <?php if (in_array('updateSetting', $user_permission)) : ?>
          <li id="setNav"><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-wrench"></i> <span>Pengaturan</span></a></li>
        <?php endif; ?>

        <?php if (in_array('viewReports', $user_permission)) : ?>
          <li id="reportNav">
            <a href="<?php echo base_url('reports/') ?>">
              <i class="glyphicon glyphicon-stats"></i> <span>Reports</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if (in_array('updateCompany', $user_permission)) : ?>
          <li id="companyNav"><a href="<?php echo base_url('company/') ?>"><i class="fa fa-files-o"></i> <span>Perusahaan</span></a></li>
        <?php endif; ?>

      <?php endif; ?>
      <!-- user permission info -->

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>