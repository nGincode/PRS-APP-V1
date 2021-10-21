<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets/login/style.css') ?>" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <title>PRS System Application</title>
  <link rel="icon" type="image/png" href="<?= base_url() ?>assets/images/logo/prslogin.png" />
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">


        <form action="<?php echo base_url('auth/login') ?>" method="post" class="sign-in-form">
          <a href="<?php echo base_url('auth/login'); ?>" style='padding-top: 70px'><img width="200px" src="<?= base_url() ?>assets/images/logo/prslogin.png"></a>
          <h2 class="title" style='font-size: revert;'>System Application</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" name="username" required="" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required="" />
          </div>

          <div class="checkbox icheck">
            <label>
              <input id='input' type="checkbox"> Remember Me
            </label>
          </div>
          <input type="submit" value="Login" class="btn solid" />
          <p class="social-text">Kunjungi Social Platforms Kami</p>
          <div class="social-media">
            <a href="https://www.instagram.com/primarasaselaras/" class="social-icon">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="https://www.youtube.com/channel/UCzPPk2wNq9JKM67BWgVXfQQ" class="social-icon">
              <i class="fab fa-youtube"></i>
            </a>
            <a href="https://api.whatsapp.com/send?phone=+6285320003950" class="social-icon">
              <i class="fab fa-whatsapp"></i>
            </a>
          </div>
          <br>
          System Version V.1.0.0
        </form>
        <form action="#" class="sign-up-form"><a href="<?php echo base_url('auth/login'); ?>"><img width="200px" src="<?= base_url() ?>assets/images/logo/prslogin.png"></a>
          <h2 class="title">Registrasi</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" />
          </div>
          <div class="input-field">
            <i class="fas fa-phone"></i>
            <input type="number" placeholder="No Handphone Aktif" />
          </div>
          <input type="submit" class="btn" id='daftar' value="Daftar" onclick="myFunction()" />
          <p class="social-text">Kunjungi Social Platforms Kami</p>
          <div class="social-media">
            <a href="https://www.instagram.com/primarasaselaras/" class="social-icon">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="https://www.youtube.com/channel/UCzPPk2wNq9JKM67BWgVXfQQ" class="social-icon">
              <i class="fab fa-youtube"></i>
            </a>
            <a href="https://api.whatsapp.com/send?phone=+6285320003950" class="social-icon">
              <i class="fab fa-whatsapp"></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Anda Mau Bergabung Bersama Kami ?</h3>
          <p>
            Daftarkan Data Anda Untuk Menikmati System Kami
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Daftar
          </button>
        </div>
        <img src="<?php echo base_url('assets/login/img/log.svg') ?>" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Sudah Terdaftar?</h3>
          <p>
            Sign in jika telah memiliki akun anda
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>
        <img src="<?php echo base_url('assets/login/img/register.svg') ?>" class="image" alt="" />
      </div>
    </div>
  </div>

  <font color="red">
    <?php if (!empty($errors)) {
      echo "<script>
  Swal.fire({
  position: 'bottom-end',
  icon: 'error',
  title: '" . $errors . "',
  showConfirmButton: false,
  timer: 1500
})</script>";
    } ?>
  </font>
  <script src="<?php echo base_url('assets/login/app.js') ?>"></script>
  <script type="text/javascript">
    function myFunction() {
      Swal.fire({
        position: 'bottom-end',
        icon: 'error',
        title: 'Maaf..! ',
        text: 'Untuk Sekarang Anda Belum Bisa Daftar',
        showConfirmButton: false,
        timer: 1500
      })
    }
  </script>

</body>

</html>