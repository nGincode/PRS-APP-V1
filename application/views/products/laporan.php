<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <section class="content-header">
        <h1>
            Manage
            <small>Absensi</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Absensi</li>
        </ol>
    </section>
    <!-- Content Header (Page header) -->

    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Laporan Produk</h3>
                    </div>
                    <br><br>
                    <!-- /.box-header -->
                    <form action="<?php echo base_url('products/laporan') ?>" method="post" class="form-horizontal">
                        <div class="box-body">

                            <?php echo validation_errors(); ?>


                            <div class="col-md-4 col-xs-12 pull pull-left">

                                <div class="form-group">
                                    <label class="col-sm-5 control-label" style="text-align:left;">Outlet :</label>
                                    <div class="col-sm-7">

                                        <select name="outlet" class="form-control">
                                            <option value="0">KESELURUHAN</option>
                                            <?php foreach ($store as $k => $v) : ?>
                                                <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                            <?php endforeach ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-5 control-label" style="text-align:left;">Tanggal Awal :</label>
                                    <div class="col-sm-7">

                                        <div class="input-group date">
                                            <div class="input-group-addon ">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="date" required name="tgl_awal" class="form-control pull-right">
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
                                            <input type="date" name="tgl_akhir" required class="form-control pull-right">
                                        </div>

                                    </div>
                                </div>


                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-app"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </form>
                    <br><br><br>

                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- col-md-12 -->
        </div>
        <!-- /.row -->
        <!-- /.box-body -->
        <!-- /.row -->
    </section>


</div>
<!-- /.content-wrapper -->


<script type="text/javascript">
    $(document).ready(function() {
        $('#userTable').DataTable();
        $(".select_group").select2();
        $("#mainProductNav").addClass('active');
        $("#laporanp").addClass('active');
        $("#laporanproduk").addClass('active');
    });
</script>