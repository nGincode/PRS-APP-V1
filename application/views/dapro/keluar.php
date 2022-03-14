<?php if ($this->session->flashdata('success')) :
    echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
?>
<?php elseif ($this->session->flashdata('error')) :
    echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
?>
<?php endif; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Barang Keluar
            <small>DAPRO</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">DAPRO</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="messages"></div>


                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Produk Keluar Bahan Matah</b></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <form role="form" action="<?= base_url('dapro/inputkeluar') ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body" id='penyesuaian'>

                            <?php echo validation_errors(); ?>
                            <table class="table table-bordered" id="ivn_info_table" style="width: 100%;">
                                <thead>
                                    <th style="width:40%;min-width:200px;text-align: center;">Nama</th>
                                    <th style="width:20%;min-width:100px;text-align: center;">Jumlah</th>
                                    <th style="width:40%;min-width:100px;text-align: center;">Ket.</th>
                                    <th style="max-width:100px;text-align: center;"><i class="fa fa-sign-in"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control select_group product" id="nama" name="nama" style="width:100%;" required>
                                                <option value="">Pilih Barang</option>
                                                <?php foreach ($data as $k => $v) : ?>
                                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['nama'] ?> (<?php echo $v['qty'] . ' ' . $v['satuan'] ?>)</option>
                                                <?php endforeach ?>
                                            </select>
                                        </td>
                                        <input type="hidden" class="form-control" id="tgl_keluar" required name="tgl_keluar" autocomplete="off" value="<?php echo date('Y-m-d'); ?>" />

                                        <td>
                                            <input type="number" name="jumlah" id="jumlah" required class="form-control" placeholder="Barang Keluar" autocomplete="off">
                                        </td>
                                        <td>
                                            <input type="text" name="ket" id="ket" class="form-control" required placeholder="Ket." autocomplete="off">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>





                            <!-- /.box-body -->
                        </div>
                    </form>
                    <!-- /.box -->
                </div>

                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Data Barang Keluar</b></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>



                    <!-- /.box-header -->
                    <div class="box-body" id='penyesuaian'>
                        <div style="position:relative;z-index: 9; margin:10px; display: flex;">

                            <div style="margin-right:10px;">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    <?= $namastore; ?>
                                </button>
                            </div>
                        </div>

                        <div class="group">
                            <input type="text" id="jadi" onchange="ubah()" name="datefilter" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label class="labeljudul">Pilih Tanggal</label>
                        </div>
                        <hr>
                        <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tipe</th>
                                    <th>Nama</th>
                                    <th>Qty</th>
                                    <th>1/Rp</th>
                                    <th>Total</th>
                                    <th>Ket</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- col-md-12 -->
            </div>
            <!-- /.row -->


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hapus </h4>
            </div>

            <form role="form" action="<?php echo base_url('ivn/removekeluar') ?>" method="post" id="removeForm">
                <div class="modal-body">
                    <p>Yakin Ingin Menghapus ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>
            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $(function() {

        $('input[name="datefilter"]').daterangepicker({
            locale: {
                "format": 'DD/MM/YYYY',
                "applyLabel": 'Simpan',
                "cancelLabel": 'Hapus',
                "opens": "left",
                "drops": "up"
            },
            startDate: moment().subtract(7, 'days'),
            endDate: moment().subtract(-3, 'days')
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });

    var manageTable;
    var base_url = "<?php echo base_url(); ?>";

    function ubah() {

        $(document).ready(function() {

            $(".select_group").select2();
            $("#maindaproNav").addClass('active');
            $("#daprokeluar").addClass('active');

            var da = $('#jadi').val();
            var validasiAngka = /^[0-9]+$/;
            if (da) {
                manageTable = $('#manageTable').DataTable({
                    processing: false,
                    serverSide: false,
                    destroy: true,
                    "ajax": {
                        url: base_url + 'dapro/fetchbkeluar',
                        type: "POST",
                        beforeSend: function() {
                            $("#load").css("display", "block");
                        },
                        data: {
                            tgl: da
                        },
                        complete: function() {
                            $("#load").css("display", "none");
                        }
                    }
                });

            } else {
                alert('Tanggal harus dipilih');
            }

        });
    }
</script>