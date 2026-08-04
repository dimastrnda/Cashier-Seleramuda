<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login SeleraMuda</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">
  <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/logincss.css">
</head>
<body>

<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>SELERA MUDA</b></a>
  </div>
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <form action="<?=site_url('auth/process')?>" method="post">
      <div class="form-group">
        <span class="icon glyphicon glyphicon-user"></span>
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
      </div>
      <div class="form-group">
        <span class="icon glyphicon glyphicon-lock"></span>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body>
</html>