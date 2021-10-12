<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage
            <small><?= $page_title; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?= $page_title; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b><i class="fa fa-address-card"></i> <?= $page_title ?></b></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <form role="form" method="post">
                        <div class="box-body">

                            <?php echo validation_errors(); ?>


                            <div class="form-group">
                                <label for="nama">Outlet</label>
                                <input type="text" class="form-control" name="store" readonly value="<?php echo $this->session->userdata('store'); ?>" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="lahir">Tanggal</label>
                                <input type="date" class="form-control" name="tgl" value="<?php echo $this->session->userdata('store'); ?>" required autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="pr">Perempuan</label>
                                <input type="number" class="form-control" required="" name="pr" placeholder="Jumlah Perempuan Sehari" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="lk">Laki-Laki</label>
                                <input type="number" class="form-control" placeholder="Jumlah Laki-Laki Sehari" name="lk" required autocomplete="off">
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




    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b><i class="fa fa-address-card"></i> Manage Jumlah Pelanggan</b></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id='penyesuaian'>
                        <table id="userTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Outlet</th>
                                    <th>Perempuan</th>
                                    <th>Laki-Laki</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($pelanggan_data as $k => $v) : $jml = $v['pr'] + $v['lk']; ?>

                                    <tr>
                                        <td><?php echo $v['tgl']; ?></td>
                                        <td><?php echo $v['store']; ?></td>
                                        <td><?php echo "Rp " . number_format($v['pr'], 0, ',', '.'); ?></td>
                                        <td><?php echo  "Rp " . number_format($v['lk'], 0, ',', '.'); ?></td>
                                        <td><?php echo  "Rp " . number_format($jml, 0, ',', '.'); ?></td>

                                    </tr>
                                <?php $no++;
                                endforeach ?>
                            </tbody>
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
    $(document).ready(function() {
        $("#groups").select2();

        $("#mainpelangganNav").addClass('active');
        $("#addpelangganNav").addClass('active');

    });
</script>