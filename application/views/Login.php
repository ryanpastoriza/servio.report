<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>DMS | Login</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="<?php echo base_url('public/adminlte/bootstrap/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/adminlte/dist/css/AdminLTE.css'); ?>">
	<script src="<?php echo base_url('public/adminlte/plugins/jQuery/jquery-1.11.3.min.js'); ?>"></script>
	<script src="<?php echo base_url('public/adminlte/bootstrap/js/bootstrap.min.js'); ?>"></script>
	
</head>
<body class="hold-transition login-page">

		<div class="login-box">
			<div class="login-logo">
			<!-- <img src="<?php //echo base_url('public/images/dms_header.png'); ?>" style="width: 100%;" /> -->
				<a href=""><b><?= SITE_NAME; ?></a>
			</div>
			<!-- /.login-logo -->
			<div class="login-box-body">
				<p class="login-box-msg">Sign in to start your session</p>
				<form method="post" action="<?php echo base_url(); ?>login/verify">
					<div class="form-group">
						<input type="text" name="username" class="form-control" placeholder="Username" >
						<span class="text-danger"><?php echo form_error('username'); ?></span>
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="Password" >
						<span class="text-danger"><?php echo form_error('password'); ?></span>
					</div>
					<div class="form-group">
						<span class="text-danger"><?php echo $this->session->flashdata('error'); ?></span>
					</div>
					<div class="form-group">
						<input type="submit" name="insert" value="Login" class="btn btn-primary btn-block">
					</div>
				</form>
			</div>
			<!-- /.login-box-body -->
		</div>
</body>
</html>