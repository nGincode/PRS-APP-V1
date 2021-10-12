<?php if ($this->session->flashdata('success')) : echo "<script> Swal.fire({icon: 'success',title: 'Berhasil...!',text: '" . $this->session->flashdata('success') . "',showConfirmButton: false,timer: 4000});</script>";
elseif ($this->session->flashdata('error')) : echo "<script> Swal.fire({icon: 'error',title: 'Maaf...!',text: '" . $this->session->flashdata('error') . "',showConfirmButton: false,timer: 4000});</script>";
endif; ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      POS
      <small>Point Of Sales (POS)</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">POS</li>
    </ol>
  </section>



  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-star"></i> Favorite</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <div class="box-body ">
            <div style="display: flex;width:100%;flex-direction: row;flex-wrap: wrap;" class="d-flex flex-nowrap">
              <?php
              foreach ($products as $key => $value) { ?>
                <div class="item">
                  <div class="card">
                    <div class="imgBx">
                      <img src="assets/images/logo/empty.png">
                    </div>
                    <div class="contentBx">
                      <h2><?= $value['name'] ?></h2>
                      <div class="size">
                        <h3>Size :</h3>
                        <span>7</span>
                        <span>8</span>
                        <span>9</span>
                        <span>10</span>
                      </div>
                      <div class="color">
                        <h3>Color :</h3>
                        <span></span>
                        <span></span>
                        <span></span>
                      </div>
                      <a href="#">Tambahkan</a>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title"><b><i class="fa fa-shopping-cart"></i> Bill</b></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>

          <!-- /.box-header -->
          <form role="form" action="<?php echo base_url('orders/create') ?>" method="post" class="form-horizontal">
            <div class="box-body">
              <table class="table table-bordered" id="product_info_table" style="overflow-x: scroll;display:block;">
                <thead>
                  <th style="width:50%;min-width:200px;text-align: center;">Produk</th>
                  <th style="width:10%;min-width:70px;text-align: center;">Qty</th>
                  <th style="width:10%;min-width:100px;text-align: center;">Hrg/1</th>
                  <th style="width:10%;min-width:70px;text-align: center;">Satuan</th>
                  <th style="width:20%;min-width:100px;text-align: center;">Jumlah</th>
                  <th style="width:10%"></th>
                  </tr>
                </thead>

                <tbody>

                </tbody>
              </table>
              <br /> <br />

              <div class="col-md-6 col-xs-12 pull pull-right">

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label">Jumlah Harga</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled autocomplete="off">
                    <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" autocomplete="off">
                  </div>
                </div>
                <?php if ($is_service_enabled == true) : ?>
                  <div class="form-group">
                    <label for="service_charge" class="col-sm-5 control-label">S-Charge <?php echo $company_data['service_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="service_charge" name="service_charge" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="service_charge_value" name="service_charge_value" autocomplete="off">
                    </div>
                  </div>
                <?php endif; ?>
                <?php if ($is_vat_enabled == true) : ?>
                  <div class="form-group">
                    <label for="vat_charge" class="col-sm-5 control-label">PPN <?php echo $company_data['vat_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="vat_charge" name="vat_charge" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="vat_charge_value" name="vat_charge_value" autocomplete="off">
                    </div>
                  </div>
                <?php endif; ?>
                <div class="form-group" style="display: none;">
                  <label for="discount" class="col-sm-5 control-label">Discount</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount" onkeyup="subAmount()" autocomplete="off">
                  </div>
                </div>
                <div class="form-group" style="display: none ;">
                  <label for="net_amount" class="col-sm-5 control-label">Jumlah Total</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="net_amount" name="net_amount" disabled autocomplete="off">
                    <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value" autocomplete="off">
                  </div>
                </div>

              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <input type="hidden" name="service_charge_rate" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
              <input type="hidden" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
              <button type="submit" class="btn btn-success"><i class="fa fa-sign-in"></i> Pesan</button>
              <a href="<?php echo base_url('orders/') ?>" class="btn btn-warning"><i class="fa fa-close"></i> Batal</a>
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

</div>


<script type="text/javascript">
  $(document).ready(function() {
    $('#userTable').DataTable();

    $("#mainposNav").addClass('active');
    $("#addposNav").addClass('active');
  });
</script>


<style>
  .item {
    position: relative;
    margin: 10px;
  }

  .item .card {
    position: relative;
    width: 220px;
    height: 350px;
    background: #232323;
    border-radius: 20px;
    overflow: hidden;
  }

  .item .card:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #9bdc28;
    clip-path: circle(150px at 80% 20%);
    transition: 0.5s ease-in-out;
  }

  .item .card:hover:before {
    clip-path: circle(300px at 80% -20%);
  }

  .item .card:after {
    content: 'POS';
    position: absolute;
    top: 30%;
    left: -20%;
    font-size: 10em;
    font-weight: 800;
    font-style: italic;
    color: rgba(255, 255, 25, 0.05)
  }

  .item .card .imgBx {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 99;
    width: 100%;
    height: 120px;
    transition: 0.5s;
  }

  .item .card:hover .imgBx {
    top: 0%;
    transform: translateY(0%);

  }

  .item .card .imgBx img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-25deg);
    width: 170px;
  }

  .item .card .contentBx {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 100px;
    text-align: center;
    transition: 1s;
    z-index: 10;
  }

  .item .card:hover .contentBx {
    height: 210px;
  }

  .item .card .contentBx h2 {
    position: relative;
    font-weight: 600;
    letter-spacing: 1px;
    color: #fff;
    margin: 0;
  }

  .item .card .contentBx .size,
  .item .card .contentBx .color {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 8px 10px;
    transition: 0.5s;
    opacity: 0;
    visibility: hidden;
    padding-top: 0;
    padding-bottom: 0;
  }

  .item .card:hover .contentBx .size {
    opacity: 1;
    visibility: visible;
    transition-delay: 0.5s;
  }

  .item .card:hover .contentBx .color {
    opacity: 1;
    visibility: visible;
    transition-delay: 0.6s;
  }

  .item .card .contentBx .size h3,
  .item .card .contentBx .color h3 {
    color: #fff;
    font-weight: 300;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-right: 10px;
  }

  .item .card .contentBx .size span {
    width: 26px;
    height: 26px;
    text-align: center;
    line-height: 26px;
    font-size: 14px;
    display: inline-block;
    color: #111;
    background: #fff;
    margin: 0 5px;
    transition: 0.5s;
    color: #111;
    border-radius: 4px;
    cursor: pointer;
  }

  .item .card .contentBx .size span:hover {
    background: #9bdc28;
  }

  .item .card .contentBx .color span {
    width: 20px;
    height: 20px;
    background: #ff0;
    border-radius: 50%;
    margin: 0 5px;
    cursor: pointer;
  }

  .item .card .contentBx .color span:nth-child(2) {
    background: #9bdc28;
  }

  .item .card .contentBx .color span:nth-child(3) {
    background: #03a9f4;
  }

  .item .card .contentBx .color span:nth-child(4) {
    background: #e91e63;
  }

  .item .card .contentBx a {
    display: inline-block;
    padding: 10px 20px;
    background: #fff;
    border-radius: 4px;
    margin-top: 10px;
    text-decoration: none;
    font-weight: 600;
    color: #111;
    opacity: 0;
    transform: translateY(50px);
    transition: 0.5s;
    margin-top: 0;
  }

  .item .card:hover .contentBx a {
    opacity: 1;
    transform: translateY(0px);
    transition-delay: 0.75s;

  }
</style>