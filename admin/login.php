<?php
session_start();
include 'function/generic.function.php';
include_once '../Classes/class.phpdoquery.php';

if( isset($_POST['submit']) && $_POST['submit'] == 'Login' ) {
	$obj = new phpdoquery();
	$obj->table = 'users';
	$obj->where = array( 'username' => $_POST['username'], 'password' => md5( $_POST['password'] ) );
	if( $obj->HaveQuery() ) {
		$row = $obj->SingleQuery();
		
		$_SESSION['logged'] = TRUE;		
		$_SESSION['user'] = $row->id;
		$_SESSION['rules'] = $row->rules;
		
		header( 'Location: index.php' );
	} else {
		header( 'Location: login.php?error=username o password errati' );
	}
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Recensionibookmakers | Login</title>
<!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container" style="background:none; box-shadow:none">
  <div class="col-sm-4 col-sm-offset-4 signin" style="background:white; box-shadow:#aaa 0px 3px 5px 0px;">
    <form class="form-signin" role="form" method="post" action="login.php">
    
    
    <h3 class="form-signin-heading text-center">Recensioni bookmakers</h3>
    <h4 class="text-center" style="color:red"><?php if( !empty( $_GET['error'] ) ) : echo $_GET['error']; endif; ?></h4>
      <input type="text" name="username" class="form-control input-sm" id="inputEmail3" placeholder="Username" required autofocus>
      <input type="password" name="password" class="form-control input-sm" id="inputPassword3" placeholder="Password" required>
      <input type="submit" class="btn btn-sm btn-block btn-primary" name="submit" value="Login" >
    </form>
    <div class="col-sm-12">
    <?php if( get_option('user') ) : ?><p class="text-center">Sing in or <a href=".register" class="click">Register</a></p><?php endif; ?>
    <p class="text-center">Copyleft <a href="http://www.stefanopascazi.it" title="FreeBlog">FreeBlog CMS</a></p>
    </div>
  </div>
  <div class="col-sm-4 col-sm-offset-4 register" style="background:white; box-shadow:#aaa 0px 3px 5px 0px;">
    <form class="form-signin" role="form" method="post" action="lib/register.php">
    
    
    <h3 class="form-signin-heading text-center">Recensioni bookmakers</h3>
    <h4 class="text-center" style="color:red"><?php if( !empty( $_GET['error'] ) ) : echo $_GET['error']; endif; ?></h4>
      <input type="text" name="email" class="form-control input-sm" id="inputEmail3" placeholder="@ email" required autofocus>
      <input type="text" name="username" class="form-control input-sm" id="inputEmail3" placeholder="Username" required autofocus>
      <input type="password" name="password" class="form-control input-sm" id="inputPassword3" placeholder="Password" required>
      <input type="password" name="password2" class="form-control input-sm" id="inputPassword3" placeholder="Repeat password" required>
      <input type="submit" class="btn btn-sm btn-block btn-primary" name="submit" value="Register" >
    </form>
    <div class="col-sm-12">
    <p class="text-center"><a href=".signin" class="click">Sing in</a> or Register</p>
    <p class="text-center">Copyleft <a href="http://www.stefanopascazi.it" title="FreeBlog">FreeBlog CMS</a></p>
    </div>
  </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
	jQuery(document).ready(function($) {
		$('.click').click(function() {
			event.preventDefault();
			var $ancor = $(this).attr('href');
			$('.col-sm-4').hide();
			$($ancor).fadeIn(500);
		})
	})
	</script>
</body>
</html>