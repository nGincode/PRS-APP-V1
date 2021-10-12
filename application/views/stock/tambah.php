        
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
            <h3 class="box-title">Tambah</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('tambah') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>


             <div class="form-group">
                <label class="col-sm-2 control-label" style="text-align:left;">Outlet</label>
                <div class="col-sm-7">
                <select name="outlet" onchange="cek_data()" class="form-control">
                <option value="">- Tampil Semua -</option>
                            <?php foreach ($store as $k => $v): ?>
                              <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                            <?php endforeach ?>
                </select>
              </div>
              </div>
              <br><br><br>

             <div class="form-group">
                <label class="col-sm-2 control-label" style="text-align:left;">Divisi</label>
                <div class="col-sm-7">
                <select name="bagian" onchange="cek_data()" class="form-control">
                <option value="1">BAR & KASIR</option>
                <option value="2">WAITHER</option>
                <option value="3">DAPUR</option>
                </select>
              </div>
              </div>
              <br><br>



              <div class="loading"></div>
              <div class="tambah"></div>
  
    <script type="text/javascript">
      function cek_data()
      {
        outlet = $('[name="outlet"]');
        bagian = $('[name="bagian"]');
        var view = "<?php echo base_url('stock/view_tambah'); ?>";

        $.ajax({
          type : 'POST',
          data: { cari: "1", bagian: bagian.val(), store_id: outlet.val() },
          url  : view,
          cache: false,
          beforeSend: function() {
            outlet.attr('disabled', false);
            bagian.attr('disabled', false);
            $('.loading').html('Loading...');
          },
          success: function(data){
            $('.loading').html('');
            if (outlet.val() && bagian.val() ) {
            $('.tambah').html(data);
          }
          }
        });
       return false;
      }
    </script>


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
    $("#tambahstockNav").addClass('active');
    

  });
</script>