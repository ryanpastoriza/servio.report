<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>DMS | Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
	<section class="content">
      	<div class="row" >
        	<section class="col-xs-12">
         		<div class="box box-primary">
					<div class="box-body">
					


						<div class="login col-md-3 box-primary" style="margin-top: 15%;margin-left: 35%; margin-right: 35%;">
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
									<input type="submit" name="insert" value="Login" class="btn btn-primary">
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
		

</body>
</html>