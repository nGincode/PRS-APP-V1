<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo base_url('') ?>" class="logo">
    <span class="logo-mini"><b>PRS</b></span>
    <span class="logo-lg"><b>PRS System Application</b></span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <font style="color: white; font-size: 20px;float: left;padding: 10px 10px;"><b><?php echo $ds_id = $this->session->userdata('store'); ?></b></font>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i></a>
        </li>
      </ul>
    </div>


    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <!-- The user image in the navbar-->
            <img width="18.5px" src="
            <?php if (file_exists('./uploads/logo/' . $this->session->userdata('logo'))) {
              echo base_url('/uploads/logo/' . $this->session->userdata('logo'));
            } else {
              echo base_url('/uploads/ivn_image/unnamed.png');
            } ?>
            " class="img-image" alt="User Image">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs"><b><?php echo $ds_id = $this->session->userdata('store'); ?></b></span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <?php if (file_exists('./uploads/logo/' . $this->session->userdata('logo'))) {
                echo '<img src="' . base_url('/uploads/logo/' . $this->session->userdata('logo')) . '" class="img-circle" alt="User Image">';
              } else {
                echo '<img src="' . base_url('/uploads/ivn_image/unnamed.png') . '" class="img-circle" alt="User Image">';
              } ?>
              <p>
                <b><?php echo $ds_id = $this->session->userdata('store'); ?></b>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php echo base_url('users/profile/') ?>" class="btn btn-default btn-flat">Profil</a>
              </div>
              <div class="pull-right">
                <a href="<?php echo base_url('auth/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>



  </nav>
</header>