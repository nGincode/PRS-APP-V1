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
                                    <th>Opsi</th>
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
                                        <td>
                                            <button type="button" class="btn btn-default" onclick="removeFunc(<?php echo $v['id'] ?>)"><i class="fa fa-trash"></i></button>
                                        </td>
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


    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="messages"></div>



                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Laporan</h3>
                    </div>
                    <br><br>
                    <!-- /.box-header -->



                    <form role="form" action="pelanggan/excel" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tanggal Awal</label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" name="tgl_awal" required="">
                            </div>
                        </div>

                        <br><br>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tanggal Akhir</label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" name="tgl_akhir" required="">
                            </div>
                        </div>

                        <br><br>


                        <div class="form-group">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export</button>
                            </div>
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


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#userTable').DataTable();
        $("#mainpelangganNav").addClass('active');
        $("#managepelangganNav").addClass('active');
    });



    // remove functions 
    function removeFunc(id) {
        Swal.fire({
            title: 'Yakin Ingin Menghapus?',
            text: "Data akan hilang selamanya !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus !'
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "<?php echo base_url('pelanggan/remove') ?>";
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Berhasil Terhapus',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() { // wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1500);
                    }
                });

            }
        })
    }
</script>