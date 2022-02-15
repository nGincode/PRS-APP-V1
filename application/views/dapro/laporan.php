<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laporan
            <small>Empolye</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Empolye</li>
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
                        <li><a href="#tab_1" data-toggle="tab">View</a></li>
                        <!--<li><a href="#tab_2" data-toggle="tab">Cek Perproduk</a></li>-->
                        <li class="active"><a href="#tab_3" data-toggle="tab">Excel</a></li>
                        <li class="pull-left header"><i class="fa fa-calendar"></i>Laporan</li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="tab_1">

                            <div id="messages"></div>

                            <?php if ($this->session->flashdata('success')) : ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php elseif ($this->session->flashdata('error')) : ?>
                                <div class="alert alert-error alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>

                            <!-- /.box-header -->
                            <form role="form" action="<?php echo base_url('pegawai/excel') ?>" method="post" class="form-horizontal" id="datastock">
                                <div class="box-body">

                                    <?php echo validation_errors(); ?>

                                    <div class="col-md-4 col-xs-12 pull pull-left">

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label" style="text-align:left;">Tanggal :</label>
                                            <div class="col-sm-7">

                                                <div class="input-group date">
                                                    <div class="input-group-addon ">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="date" name="date" required class="form-control pull-right" onchange="cekdata(this.value)" id="datepicker">
                                                </div>

                                            </div>
                                        </div>


                                    </div>

                                    <div id="hasilnya"></div>
                                    <br><br>
                                </div>

                            </form>
                            <!-- /.box-body -->

                        </div>



                        <!-- /.tab-pane <div class="tab-pane" id="tab_2">


              </div>

              /.tab-pane -->
                        <div class="tab-pane active" id="tab_3">

                            <div id="messages"></div>

                            <?php if ($this->session->flashdata('success')) : ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php elseif ($this->session->flashdata('error')) : ?>
                                <div class="alert alert-error alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>

                            <!-- /.box-header -->
                            <form action="<?php echo base_url('pegawai/excel') ?>" method="post" class="form-horizontal">
                                <div class="box-body">

                                    <?php echo validation_errors(); ?>

                                    <div class="form-group">
                                        <label for="gross_amount" class="col-sm-12 control-label">Tanggal: <?php
                                                                                                            $timezone = new DateTimeZone('Asia/Jakarta');
                                                                                                            $date = new DateTime();
                                                                                                            $date->setTimeZone($timezone);
                                                                                                            echo $date->format('d-m-Y') ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="gross_amount" class="col-sm-12 control-label">Pukul: <?php echo $date->format('G:i:s') ?></label>
                                    </div>

                                    <div class="col-md-4 col-xs-12 pull pull-left">



                                        <div class="form-group">
                                            <label class="col-sm-5 control-label" style="text-align:left;">Divisi</label>
                                            <div class="col-sm-7">

                                                <div class="input-group date">
                                                    <div class="input-group-addon ">
                                                        <i class="fa fa-users"></i>
                                                    </div>

                                                    <select name="lap" required class="form-control pull-right">
                                                        <option value="">- PILIH LAPORAN -</option>
                                                        <option value="1">Laporan Barang Matah</option>
                                                        <option value="2">Laporan Barang Jadi</option>
                                                        <option value="3">Laporan Ke Logistik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
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

        $("#maindaproNav").addClass('active');
        $("#laporan").addClass('active');





    });

    function cekdata(val) {
        $.ajax({
            url: 'laporandata',
            type: "POST",
            data: {
                id: val
            },
            success: function(data) {
                $('#hasilnya').html(data);
            }
        });

    }
</script>