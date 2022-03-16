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
      Input
      <small>Item Resep</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Resep</li>
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
            <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Tambah Item Resep</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <form role="form" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <font style="color: red"><?php echo validation_errors(); ?></font>



              <div class="form-group">
                <label for="nama">Nama Item </label>
                <input type="text" class="form-control" id="nama" required name="nama" placeholder="Masukkan Nama Item" autocomplete="off" />
              </div>


              <div class="form-group">
                <label for="satuan">Satuan</label><br>

                <select name="satuan" class="form-control">
                  <option value="Pcs">Pcs</option>
                  <option value="Pck">Pck</option>
                  <option value="Klg">Klg</option>
                  <option value="Kg">Kg</option>
                  <option value="Gr">Gr</option>
                  <option value="Jrg">Jrg</option>
                  <option value="Dus">Dus</option>
                  <option value="Btl">Btl</option>
                  <option value="Box">Box</option>
                  <option value="Bks">Bks</option>
                  <option value="Btr">Btr</option>
                  <option value="Por">Porsi</option>
                  <option value="Ml">Ml</option>
                  <option value="Ptg">Potong</option>
                </select>
              </div>



              <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" step="any" class="form-control" id="harga" name="harga" placeholder="Masukkan Harga" autocomplete="off" />
              </div>



            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
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


  <section class="content">


    <br /> <br />


    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Data Item Resep</b></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body" id='penyesuaian'>
        <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;">
          <thead>
            <tr>
              <th style="width: 10px;">Action</th>
              <th style="width: 300px;">Nama</th>
              <th style="width: 150px;">Harga/1</th>
              <th>Resep</th>
            </tr>
          </thead>

        </table>
      </div>
      <!-- /.box-body -->
    </div>
  </section>



  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>


        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-briefcase"></i> Edit Item Resep</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?= base_url('penjualan/edititem') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <font style="color: red"><?php echo validation_errors(); ?></font>
              <div class="form-group">
                <label for="satuan">Pilih Yang diedit</label><br>

                <select onchange="edit()" id="selectBox" name="id" class="form-control select_group">

                  <?php foreach ($dataitem as $val) { ?>
                    <option value="<?= $val['id'] ?>"><?= $val['nama'] ?></option>
                  <?php } ?>
                </select>
              </div>


              <div class="form-group">
                <label for="nama">Nama Item </label>
                <input type="text" class="form-control" id="namaedit" required name="nama" placeholder="Masukkan Nama Item" autocomplete="off" />
              </div>


              <div class="form-group">
                <label for="satuan">Satuan</label><br>

                <select name="satuan" id="selectedit" class="form-control">
                  <option value="Pcs" id="Pcs">Pcs</option>
                  <option value="Pck" id="Pck">Pck</option>
                  <option value="Klg" id="Klg">Klg</option>
                  <option value="Kg" id="Kg">Kg</option>
                  <option value="Gr" id="Gr">Gr</option>
                  <option value="Jrg" id="Jrg">Jrg</option>
                  <option value="Dus" id="Dus">Dus</option>
                  <option value="Btl" id="Btl">Btl</option>
                  <option value="Box" id="Box">Box</option>
                  <option value="Bks" id="Bks">Bks</option>
                  <option value="Btr" id="Btr">Btr</option>
                  <option value="Por" id="Pr">Porsi</option>
                  <option value="Ml" id="Ml">Ml</option>
                  <option value="Ptg" id="Ptg">Potong</option>
                </select>
              </div>



              <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" step="any" class="form-control" id="hargaedit" name="harga" placeholder="Masukkan Harga" autocomplete="off" />
              </div>



            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Edit</button>
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
  <!-- /.box -->
</div>
<!-- col-md-12 -->
</div>
<!-- /.row -->


</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php if (in_array('deletepenjualan', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Menghapus Item</h4>
        </div>

        <form role="form" action="<?php echo base_url('penjualan/remove') ?>" method="post" id="removeForm">
          <div class="modal-body">
            <p>Yakin Ingin Menghapus?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
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

    $("#mainpenjualanNav").addClass('active');
    $("#addpenjualanNav").addClass('active');

    $(".select_group").select2();

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'penjualan/fetchitemresep',
      'order': []
    });

  });

  function edit() {
    var selectBox = document.getElementById("selectBox");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    if (selectedValue) {
      $.ajax({
        url: base_url + '/penjualan/edititempjl',
        type: 'POST',
        data: {
          id: selectedValue
        },
        success: function(data) {
          const obj = JSON.parse(data);
          $('#namaedit').val(obj.nama);

          var opt = $("#" + obj.satuan),
            html = $("<div>").append(opt.clone()).html();
          html = html.replace(/\>/, ' selected="selected">');
          opt.replaceWith(html);

          $('#hargaedit').val(obj.harga);
        }
      });

      // return false;
    }
  }

  // remove functions 
  function removeFunc(id) {
    if (id) {
      $("#removeForm").on('submit', function() {

        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: {
            id: id
          },
          dataType: 'json',
          success: function(response) {

            manageTable.ajax.reload(null, false);

            if (response.success === true) {
              // hide the modal
              $("#removeModal").modal('hide');
              Swal.fire({
                icon: 'success',
                title: 'Berhasil...!',
                text: response.messages,
                showConfirmButton: false,
                timer: 4000
              })

            } else {
              $("#removeModal").modal('hide');
              Swal.fire({
                icon: 'error',
                title: 'Maaf...!',
                text: response.messages,
                showConfirmButton: false,
                timer: 4000
              })

            }
          }
        });

        return false;
      });
    }
  }
</script>