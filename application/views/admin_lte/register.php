<!DOCTYPE html>
<html>
<head>
  <title>HRMS | Register User</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="<?= base_url('scripts/jquery.js') ?>"></script>
  <script type="text/javascript" src="<?= base_url('scripts/jquery.form.min.js') ?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/bootstrap/js/bootstrap.js') ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/bootstrap/css/bootstrap.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= asset_url('dist/css/adminLTE.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= asset_url('fonts/css/font-awesome.min.css') ?>">
</head>
<script type="text/javascript">
  $(function(){
        $('#register-form').ajaxForm({
                                  beforeSubmit: function(){
                                    $('#reg-btn').html('Verifying info. . .').attr('disa');
                                  },
                                  complete: function(r){
                                    $('#reg-btn').html('Register');
                                    var res = r.responseJSON;
                                    $('#msg-display').html(res.txt);
                                  },
                                  dataType:'json',
                                });
  })
</script>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="<?= base_url('index.php/login') ?>"><b>ACLC</b><small>HRMS</small></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register employee user account</p>

    <?= form_open(base_url('index.php/register/check_register'),"id='register-form'"); ?>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="ID Number" name="employee_id" required="">
        <span class="fa fa-credit-card form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Keycode" name="keycode" required="">
        <span class="fa fa-key form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required="">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Retype password" name="password2" required="">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-sm-12" id="msg-display"></div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" id="reg-btn">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    
    <a href="<?= base_url('index.php/login') ?>" class="text-center">Back to login page</a>
  </div>
  <!-- /.form-box -->
</div>
</body>
</html>