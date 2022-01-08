<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage
            <small>Produk</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Products</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">


                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Stock Dapro</b></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body" id='penyesuaian'>


                        <table id="manageTable1" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tipe</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                        </table>
                        <!-- /.box-body -->
                    </div>



                    <!-- /.box -->
                </div>


                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Akumulasi Resep</b></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body" id='penyesuaian'>


                        <table id="manageTable" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <!-- <th style="width: 30px;">Opsi</th> -->
                                    <th>Nama Resep</th>
                                    <th>Qty dapat dibuat</th>
                                    <th>Qty dibuat</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>


                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Barang Jadi</b></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body" id='penyesuaian'>


                        <table id="manageTable2" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <!-- <th style="width: 30px;">Opsi</th> -->
                                    <th>Nama </th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Total</th>
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
<div id="printaera" style="position: absolute; z-index: -1;"></div>
<!-- /.content-wrapper -->

<?php if (in_array('deleteProduct', $user_permission)) : ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Menghapus Produk</h4>
                </div>

                <form role="form" action="<?php echo base_url('products/remove') ?>" method="post" id="removeForm">
                    <div class="modal-body">
                        <p>Yakin Ingin Menghapus?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Hapus</button>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>



<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function() {

        $(".select_group").select2();
        $("#maindaproNav").addClass('active');
        $("#hasil").addClass('active');


        manageTable = $('#manageTable2').DataTable({
            processing: false,
            serverSide: false,
            destroy: true,
            "ajax": {
                url: base_url + 'dapro/fatchbrngjdi',
                type: "POST",
                beforeSend: function() {
                    $("#load").css("display", "block");
                },
                complete: function() {
                    $("#load").css("display", "none");
                }
            }
        });

        manageTable = $('#manageTable1').DataTable({
            processing: false,
            serverSide: false,
            destroy: true,
            "ajax": {
                url: base_url + 'dapro/fatchorderstock',
                type: "POST",
                beforeSend: function() {
                    $("#load").css("display", "block");
                },
                complete: function() {
                    $("#load").css("display", "none");
                }
            }
        });


        manageTable = $('#manageTable').DataTable({
            processing: false,
            serverSide: false,
            destroy: true,
            "ajax": {
                url: base_url + 'dapro/fatchresep',
                type: "POST",
                beforeSend: function() {
                    $("#load").css("display", "block");
                },
                complete: function() {
                    $("#load").css("display", "none");
                }
            }
        });
    });

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

    function print() {

        var nama = $("#product").val();
        var tgl = $("#tgl").val();
        var jml = $("#jml").val();

        if (!nama == '' && !tgl == '' && !jml == '') {
            var x;
            html = '<div style="width: 55mm;height:unset;"><table  style="font-size: 20px; width:100%;">';
            for (x = 0; x < jml; x++) {
                html += '<tr style="border-bottom: solid;"><td colspan="3" style="text-align: center;padding: 5px;line-height: normal;">' + nama + '<br>' + tgl + '<td></tr>';
            }
            html += '</table></div>';
            document.getElementById("printaera").innerHTML = html;
            $.print("#printaera");
        } else {
            alert('Isi Belum Lengkap');
        }

    }



    function upload_orderdapro(id) {
        Swal.fire({
            title: 'Yakin ingin Upload?',
            text: "Data akan langsung menambah item & tidak bisa diubah",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Upload'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>dapro/status_up",
                    data: {
                        'id': id
                    },
                    cache: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Memproses!',
                            didOpen: () => {
                                Swal.showLoading()
                            },
                        })
                    },
                    success: function(response) {
                        if (response == 1) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal...!',
                                text: 'Tidak Mempunyai Hak Akses',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                        if (response == 6) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil...!',
                                text: 'Produk Ditambahkan',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function() {
                                window.location.href = '<?php base_url('products/lkeluar'); ?>';
                            }, 1500);
                        }
                    }
                });




            }
        })


    }


    function kirimbrngjdi() {
        var $id = $('#indent').val();
        var $max = $('#keleb').val();
        var $jml = $('#jml').val();
        var $harganya = $('#harganya').val();
        var $nmmnu = $('#nmmnu').val();
        if ($jml > $max) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal...!',
                text: 'Tidak Boleh Melebihi Qty Yang Dapat dibuat',
                showConfirmButton: false,
                timer: 1500
            });
        } else if (0 >= $jml) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal...!',
                text: 'Tidak Valid',
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            Swal.fire({
                title: 'Yakin ingin mengirim?',
                text: "Semua Stock Akan Berkurang Dan Tidak Dapat Dikemablikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Kirim'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url() ?>dapro/inputbrngjdi",
                        data: {
                            'id': $id,
                            'max': $max,
                            'jml': $jml,
                            'harganya': $harganya,
                            'nama': $nmmnu
                        },
                        cache: false,
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Memproses!',
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                            })
                        },
                        success: function(response) {
                            if (response == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil...!',
                                    text: 'Produk di Akumulasi',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function() {
                                    window.location.href = '<?php base_url('dapro/hasil'); ?>';
                                }, 1500);

                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal...!',
                                    text: 'Terjadi masalah system',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });




                }
            })
        }

    }
</script>
<script src="https://cdn.jsdelivr.net/npm/jQuery.print@1.5.1/jQuery.print.min.js"></script>