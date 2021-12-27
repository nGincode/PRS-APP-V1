<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Groups</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">groups</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">



        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b> Tambah Group</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <form role="form" action="<?php base_url('groups/create') ?>" method="post">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="group_name">Nama Group</label>
                <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Masukkan Nama Group">
              </div>
              <div class="form-group">
                <label for="permission">Perizinan</label>

                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Tambah</th>
                      <th>Edit</th>
                      <th>lihat</th>
                      <th>Hapus</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Pengguna</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createUser" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateUser" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewUser" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteUser" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Groups</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createGroup" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateGroup" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewGroup" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteGroup" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Brands Product</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createBrand" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateBrand" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewBrand" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteBrand" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Kategori</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createCategory" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateCategory" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewCategory" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteCategory" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Outlet</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createStore" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateStore" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewStore" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteStore" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Attributes</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createAttribute" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateAttribute" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewAttribute" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteAttribute" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Pengadaan</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createpengadaan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatepengadaan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewpengadaan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletepengadaan" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Inventaris</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createivn" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateivn" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewivn" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteivn" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Stock</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createstock" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatestock" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewstock" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletestock" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Barang</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createProduct" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateProduct" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewProduct" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteProduct" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Orders</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createOrder" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateOrder" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewOrder" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteOrder" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Pegawai</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createPegawai" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatePegawai" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewPegawai" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletePegawai" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Omzet</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createOmzet" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateOmzet" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewOmzet" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteOmzet" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Absensi Office</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createabsen" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateabsen" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewabsen" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deleteabsen" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Pelaporan</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createpelaporan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatepelaporan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewpelaporan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletepelaporan" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Belanja</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createbelanja" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatebelanja" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewbelanja" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletebelanja" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Voucher Pegawai</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createvocp" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatevocp" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewvocp" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletevocp" class="minimal"></td>
                    </tr>

                    <tr>
                      <td>Point Of Sales (POS)</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createpos" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatepos" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewpos" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletepos" class="minimal"></td>
                    </tr>

                    <tr>
                      <td>Pelanggan</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createpelanggan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatepelanggan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewpelanggan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletepelanggan" class="minimal"></td>
                    </tr>


                    <tr>
                      <td>Voucher</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createvoucher" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatevoucher" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewvoucher" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletevoucher" class="minimal"></td>
                    </tr>


                    <tr>
                      <td>Penjualan</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createpenjualan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatepenjualan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewpenjualan" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletepenjualan" class="minimal"></td>
                    </tr>

                    <tr>
                      <td>Dapur Produksi</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="createdapro" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updatedapro" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewdapro" class="minimal"></td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="deletedapro" class="minimal"></td>
                    </tr>
                    <tr>
                      <td>Reports</td>
                      <td> - </td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewReports" class="minimal"></td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Perusahaan</td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateCompany" class="minimal"></td>
                      <td> - </td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Profil</td>
                      <td> - </td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="viewProfile" class="minimal"></td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Pengaturan</td>
                      <td>-</td>
                      <td><input type="checkbox" name="permission[]" id="permission" value="updateSetting" class="minimal"></td>
                      <td> - </td>
                      <td> - </td>
                    </tr>
                  </tbody>
                </table>

              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>
            </div>
          </form>
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
  $(document).ready(function() {
    $("#mainGroupNav").addClass('active');
    $("#addGroupNav").addClass('active');

    $('input[type="checkbox"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
  });
</script>