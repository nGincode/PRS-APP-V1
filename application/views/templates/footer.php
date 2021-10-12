<footer class="main-footer">
  <strong>Copyright &copy; PRS System Application <?php echo date('Y') ?>.</strong>
</footer>

<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



<!-- Select2 -->
<script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js') ?>"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>

<!-- Morris.js charts -->
<script src="<?php echo base_url('assets/bower_components/raphael/raphael.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bower_components/morris.js/morris.min.js') ?>"></script>

<!-- Sparkline -->
<script src="<?php echo base_url('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') ?>"></script>

<!-- jvectormap -->
<script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>"></script>

<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/bower_components/jquery-knob/dist/jquery.knob.min.js') ?>"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>"></script>

<!-- Slimscroll -->
<script src="<?php echo base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>

<!-- FastClick -->
<script src="<?php echo base_url('assets/bower_components/fastclick/lib/fastclick.js') ?>"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist/js/adminlte.min.js') ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes)
  <script src="<?php echo base_url('assets/dist/js/pages/dashboard.js') ?>"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/dist/js/demo.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/fileinput/fileinput.min.js') ?>"></script>

<!-- ChartJS -->
<script src="<?php echo base_url('assets/bower_components/Chart.js/Chart.js') ?>"></script>

<!-- icheck -->
<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>

<!-- DataTables -->
<script src="<?php echo base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>


<!-- daterangepicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- datepicker -->
<script src="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>


<!-- Input Masak -->
<script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.extensions.js') ?>"></script>

<style type="text/css">
  /*css3 design scrollbar*/
  ::-webkit-scrollbar {
    width: 6px;
    height: 6px;
  }

  ::-webkit-scrollbar-track {
    background: #ecf0f5;
  }

  ::-webkit-scrollbar-thumb {
    background: #5d5e5f;
    border-radius: 5px;
  }

  ::-webkit-scrollbar-thumb:hover {
    background: #3c8dbc;
    border-radius: 5px;
  }


  @media screen and (max-width: 700px) {
    #penyesuaian {
      overflow: auto;
    }
  }

  /* form starting stylings ------------------------------- */

  @media screen and (min-width: 600px) {
    .group {
      position: relative;
      margin: 10px;
      float: right;
      margin-top: -36px;
      position: relative;
      z-index: 999;
    }
  }

  @media screen and (max-width: 600px) {
    .group {
      position: relative;
      margin: 10px;
      margin-top: 20px;
    }
  }

  input {
    font-size: 18px;
    padding: 10px 10px 10px 5px;
    display: block;
    width: 194px;
    border: none;
    border-bottom: 1px solid #3c8dbc;
  }

  input:focus {
    outline: none;
  }

  .labeljudul {
    color: #3c8dbc;
    font-size: 18px;
    position: absolute;
    pointer-events: none;
    top: 10px;
    transition: 0.2s ease all;
    -moz-transition: 0.2s ease all;
    -webkit-transition: 0.2s ease all;
  }

  /* active state */
  input:focus~.labeljudul,
  input:valid~.labeljudul {
    top: -10px;
    font-size: 14px;
    color: #3c8dbc;
  }

  /* BOTTOM BARS ================================= */
  .bar {
    position: relative;
    display: block;
    width: 194px;
  }

  .bar:before,
  .bar:after {
    content: '';
    height: 2px;
    width: 0;
    bottom: 1px;
    position: absolute;
    background: #3c8dbc;
    transition: 0.2s ease all;
    -moz-transition: 0.2s ease all;
    -webkit-transition: 0.2s ease all;
  }

  .bar:before {
    left: 50%;
  }

  .bar:after {
    right: 50%;
  }

  /* active state */
  input:focus~.bar:before,
  input:focus~.bar:after {
    width: 50%;
  }

  /* HIGHLIGHTER ================================== */
  .highlight {
    position: absolute;
    height: 60%;
    width: 100px;
    top: 25%;
    left: 0;
    pointer-events: none;
    opacity: 0.5;
  }

  /* active state */
  input:focus~.highlight {
    -webkit-animation: inputHighlighter 0.3s ease;
    -moz-animation: inputHighlighter 0.3s ease;
    animation: inputHighlighter 0.3s ease;
  }

  /* ANIMATIONS ================ */
  @-webkit-keyframes inputHighlighter {
    from {
      background: #5264AE;
    }

    to {
      width: 0;
      background: transparent;
    }
  }

  @-moz-keyframes inputHighlighter {
    from {
      background: #5264AE;
    }

    to {
      width: 0;
      background: transparent;
    }
  }

  @keyframes inputHighlighter {
    from {
      background: #5264AE;
    }

    to {
      width: 0;
      background: transparent;
    }
  }
</style>

</body>

</html>