

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Stock</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Barang</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Edit Stock <br><b><?php echo $nama_produk; ?></b></h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('stock/update') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>

<table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
              <tr>
              </tr>
                <th style="text-align: center;min-width: 50px;">Tanggal</th>
                <th style="text-align: center;min-width: 100px;">Nama Produk</th>
                <th style="text-align: center;min-width: 50px;">Rp/UOM</th>
                <th style="text-align: center;min-width: 100px;">Awal</th>
                <th style="text-align: center;min-width: 100px;">Masuk</th>
                <th style="text-align: center;min-width: 100px;">Sisa</th>
                <th style="text-align: center;min-width: 100px;">Terpakai</th>
                <th style="text-align: center;min-width: 100px;">Reg</th>
                <th style="text-align: center;min-width: 100px;">Status</th>
                <th style="text-align: center;min-width: 100px;">Ket.</th>
                    </tr>
<script type="text/javascript">

  function pemakaian1() {
      var hitung = Number($("#reg_1").val()) - Number($("#unit_1").val());

      total = hitung.toFixed(1);
      $("#pemakaian_1").val(total);
      $("#pemakaian_value_1").val(total);


  }


function apakai1() {


      var hitung = Number($("#a_unit_1").val()) + Number($("#t_unit_1").val()) - Number($("#s_unit_1").val());


      total = hitung.toFixed(1);

      $("#unit_1").val(total);
      $("#unit_value_1").val(total);

}


</script>

                   <tbody>
                    
                     <tr id="row_1"> 
                      <input type="hidden"  name="harga" class="form-control" required value="<?php echo $harga; ?>" >
                      <input type="hidden"  name="bagian" class="form-control" required value="<?php echo $bagian; ?>" >
                          <input type="hidden" name="nama_produk[]" value="<?php echo $nama_produk; ?>" class="form-control" autocomplete="off">
                           <input type="hidden" class="form-control" name="satuan" value="<?php echo $satuan ?>">
                      <td>
                          <input type="date" disabled name="tgl" id="tgl_1" class="form-control" value="<?php echo $stock_data['tgl']; ?>" autocomplete="off">
                        </td>

                        <td>
                       <input type="text" class="form-control" id="product" disabled  name="product" placeholder="Masukkan Nama Produk" value="<?php echo $nama_produk; ?>"  autocomplete="off"/>
                        </td>
              <td>
                  <input type="text" class="form-control" disabled value="<?php if($harga){echo $harga."/".$satuan;}else{ echo "0/".$satuan; } ?>"></td>

                        <td><input type="number"  step="any"  name="a_unit" id="a_unit_1" class="form-control" required value="<?php echo $stock_data['a_unit']; ?>" ></td>


                        <td><input type="number"  step="any"  name="t_unit" onkeyup="apakai1()" id="t_unit_1" class="form-control" required value="<?php echo $stock_data['t_unit']; ?>" ></td>


                        <td><input type="number"  step="any"  name="s_unit" onkeyup="apakai1()" id="s_unit_1" class="form-control" required value="<?php echo $stock_data['s_unit']; ?>" ></td>


                        <td><input type="number" disabled name="unit" id="unit_1" oninput="pemakaian1()" class="form-control" required value="<?php echo $stock_data['unit']; ?>" ><input type="hidden" name="unit" value="<?php echo $stock_data['unit']; ?>" id="unit_value_1"class="form-control"  ></td>

                        <td><input type="number" step="any"  name="reg" id="reg_1" oninput="pemakaian1()" class="form-control" required value="<?php echo $stock_data['reg']; ?>" ></td>
                        <td>
                          <input  type="number" disabled name="pemakaian"  id="pemakaian_1" class="form-control" value="<?php echo $stock_data['status']; ?>"  required  autocomplete="off">
                          <input  type="hidden" name="pemakaian"  id="pemakaian_value_1" value="<?php echo $stock_data['status']; ?>" class="form-control" autocomplete="off">
                        </td>

                        <td><input type="text" name="ket"  class="form-control" required value="<?php echo $stock_data['ket']; ?>" ></td>
                     </tr>
                   </tbody>
                </table>





              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo base_url('stock/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
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
  
  $(document).ready(function() {
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#mainstockNav").addClass('active');
    $("#managestockNav").addClass('active');
    

  });
</script>