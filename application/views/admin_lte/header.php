<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= defined('HEADER_TITLE') ? HEADER_TITLE : "Default Title" ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?= asset_url('bootstrap/css/bootstrap.min.css') ?> ">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= asset_url('fonts/css/font-awesome.min.css') ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= asset_url('ionicons/css/ionicons.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= asset_url('dist/css/AdminLTE.min.css') ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= asset_url('dist/css/skins/_all-skins.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= asset_url('plugins/iCheck/flat/blue.css') ?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?= asset_url('plugins/morris/morris.css') ?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?= asset_url('plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?= asset_url('plugins/datepicker/datepicker3.css') ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= asset_url('plugins/daterangepicker/daterangepicker-bs3.css') ?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?= asset_url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<script src="<?= asset_url('plugins/jQuery/jQuery-1.11.3.min.js') ?>"></script>
<script src="<?= asset_url('plugins/jQueryUI/jquery-ui.min.js') ?> ?>"></script>
<script src="<?= asset_url('bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= asset_url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>"></script>
<!-- Slimscroll -->
<script src="<?= asset_url('plugins/slimScroll/jquery.slimscroll.min.js') ?>"></script>
<!-- FastClick -->
<script src="<?= asset_url('plugins/fastclick/fastclick.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= asset_url('dist/js/app.min.js') ?>"></script>

<?php if ($addStyles): ?>
    <?php foreach ($addStyles as $key => $value): ?>
      <link rel="stylesheet" type="text/css" href="<?= $value ?>">
    <?php endforeach ?>
<?php endif ?>

<?php if ($addPlugins): ?>
    <?php foreach ($addPlugins as $key => $value): ?>
        <script src="<?= $value ?>"></script>
    <?php endforeach ?>
<?php endif ?>
</head>
<body class="hold-transition skin-red-light sidebar-mini">
  <div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?= defined('MAIN_PAGE') ? MAIN_PAGE : "#" ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?= defined('SITE_NAME') ? SITE_NAME : "Default Website Name" ?>  </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
        <?= defined('SITE_LOGO') ? "<img src='".SITE_LOGO."' height='40px' width='100px' >" : "" ?>
        <?= defined('SITE_NAME') ? SITE_NAME : "Default Website Name" ?>
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <?php if (isset($rightNav) && $rightNav != false): ?>
        
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <?php foreach ($rightNav as $key => $value): ?>
            <?= $value ?>
          <?php endforeach ?>
        </ul>
      </div>
      <?php endif ?>

    </nav>  
  </header>    