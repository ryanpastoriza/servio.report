<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>DMS | <?php echo $title; ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="login col-md-3" style="margin-top: 15%;margin-left: 35%; margin-right: 35%;">
		<form method="post" action="<?php echo base_url(); ?>login/verify">
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Username" >
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Password" >
				</div>
			<div class="form-group">
				<input type="submit" name="insert" value="Login" class="btn btn-primary">
			</div>
		</form>
	</div>
</body>
</html>