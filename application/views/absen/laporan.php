
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Laporan
      <small>Absensi</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Absensi</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="ccol-md-12 col-xs-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li  class="active"><a  href="#tab_1" data-toggle="tab">Laporan Pertanggal</a></li>
              <li class="pull-left header"><i class="fa fa-calendar"></i>Laporan Absensi</li>
            </ul>
            <div class="tab-content">
      
              <div class="tab-pane active" id="tab_1">


          <!-- /.box-header -->
          <form action="<?php echo base_url('absen/excel') ?>" method="post" class="form-horizontal">
              <div class="box-body">


                <div class="form-group">
                  <label for="gross_amount" class="col-sm-12 control-label">Tanggal: <?php 
                  $timezone = new DateTimeZone('Asia/Jakarta');
                  $date = new DateTime();
                  $date->setTimeZone($timezone); echo $date->format('d-m-Y') ?></label>
                </div>
                <div class="form-group">
                  <label for="gross_amount" class="col-sm-12 control-label">Pukul: <?php echo $date->format('G:i:s') ?></label>
                </div>

                <div class="col-md-4 col-xs-12 pull pull-left">



                      <div class="form-group">
                      <label class="col-sm-5 control-label" style="text-align:left;">Tanggal Awal :</label>
                      <div class="col-sm-7">

                      <div class="input-group date">
                      <div class="input-group-addon ">
                      <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" required name="tglawal" class="form-control pull-right" id="datepicker">
                      </div>

                    </div>
                    </div>

                     <div class="form-group">
                      <label class="col-sm-5 control-label" style="text-align:left;">Tanggal Akhir :</label>
                      <div class="col-sm-7">

                      <div class="input-group date">
                      <div class="input-group-addon ">
                      <i class="fa fa-calendar"></i>
                      </div>
                      <input type="date" name="tglakhir" required class="form-control pull-right" id="datepicker">
                      </div>

                    </div>
                    </div>


            </div>

            </div>

              <div class="box-footer">
                <button type="submit" class="btn btn-app"><i class="fa fa-file-excel-o"></i> Excel</button>
              </div>
            </form>
          <!-- /.box-body -->


              </div>
              <!-- /.tab-pane -->
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
   
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

    $("#mainabsenNav").addClass('active');
    $("#laporanNav").addClass('active');

});



</script>
