

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit
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
        <div class="col-md-12 col-xs-12">

        <?php if($this->session->flashdata('success')):

echo "<script> Swal.fire({
              icon: 'success',
              title: 'Berhasil...!',
              text: '".$this->session->flashdata('success')."',
              showConfirmButton: false,
              timer: 4000
            });
</script>";

         ?>
            
        <?php elseif($this->session->flashdata('error')):
echo "<script> Swal.fire({
              icon: 'error',
              title: 'Maaf...!',
              text: '".$this->session->flashdata('error')."',
              showConfirmButton: false,
              timer: 4000
            });
</script>";

         ?>

            
        <?php endif; ?>

          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><b>Edit Absens <?php echo $absen['nama']?></b></h3>
            </div>
            <form role="form" method="post">
              <div class="box-body">
                

                <div class="form-group">
                  <label for="Tanggal">Tanggal</label>
                  <input type="date" class="form-control" value="<?php echo $absen['tgl']; ?>" name="tgl" required placeholder="Tanggal" autocomplete="off">
                </div>

                      <div class="form-group">
                        <label for="nama">Nama Pegawai</label>
                        <select name="nama" class="form-control select_group" style="width:100%;">
                          <option selected="true" disabled="disabled">Pilih Pegawai</option>
                            <?php foreach ($pegawai_data as $k => $v): ?>
                              <option value="<?php echo $v['id'] ?>" <?php if($v['nama'] == $absen['nama']){echo "selected";}?>><?php echo $v['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        </div>

                      <div class="form-group">
                        <label>Keterangan</label>
                      <select name="pilianwaktu" class="form-control" style="width:100%;">
                          <option selected="true" disabled="disabled">Status</option>
                              <option value="1" <?php if(1 == $absen['waktu_masuk']){echo "selected";}?>>Masuk</option>
                              <option value="2" <?php if(1 == $absen['waktu_keluar']){echo "selected";}?>>Keluar</option>
                        </select>
                        </div>


                <div class="form-group">
                  <label for="image">Gambar</label><br>
                  <img src="../../uploads/absensi/<?php echo $absen['image']; ?>">
                </div>

                <div class="form-group">
                  <label for="Tanggal">Waktu</label>
                  <input type="text" class="form-control"  value="<?php echo $absen['waktu']; ?>" name="tgl" required placeholder="Waktu" autocomplete="off">
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Simpan</button>
                <a href="<?php echo base_url('pegawai/absensiedit') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
              </div>
            </form>
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
    $(".select_group").select2();
    $("#mainPegawaiNav").addClass('active');
    $("#absensiNav").addClass('active');
    });


// remove functions 
function removeFunc(id)
{
Swal.fire({
  title: 'Yakin Ingin Menghapus?',
  text: "Hilangkan Data Pegawai, Namun Absensi Tetap Tercatat!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Hapus !'
}).then((result) => {
  if (result.isConfirmed) {
      var url = "<?php echo base_url('Pegawai/removeappresial') ?>";
     $.ajax({
        url: url,
        type: "post",
        data: { id:id }, 
        success:function(response) {
          Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Berhasil Terhapus',
          showConfirmButton: false,
          timer: 1500
          })
           setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 1500); 
        }
      });

  }
})
}
  </script>
