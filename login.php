<?php
//We include the configuration file
include("config.php");
$error = "";

//Start the session
session_start();


if($_SERVER["REQUEST_METHOD"] == "POST") {
	$myusername = mysqli_real_escape_string($db, $_POST['username']);
	$mypassword = mysqli_real_escape_string($db, $_POST['password']); 

	
	
	//Building the query
	$sql = "SELECT * FROM Password WHERE u_email = '{$myusername}' and u_password = '{$mypassword}'";

	//Performs a query on the database
	$result = mysqli_query($db,$sql);

	//Fetch a result row as an associative, a numeric array, or both
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	//Gets the number of rows in a result
	$count = mysqli_num_rows($result);

	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count == 1) {
		// Get the role
		$queryRole = "SELECT * FROM User1 WHERE u_email='{$myusername}'";
		$resultRole = mysqli_query($db, $queryRole);
		$arrayRole = mysqli_fetch_assoc($resultRole);
		$role = $arrayRole['u_role'];
		$name = $arrayRole['u_name'];
		
		$_SESSION['login_user'] = $myusername;
		$_SESSION['login_role'] = $role;
		$_SESSION['login_name'] = $role;
		
		header("location: index.php");
	} else {
	 $error = "Your Login Name or Password is invalid";
  }
  
  if($_SERVER["REQUEST_METHOD"] == "POST") {
	  if($_GET['forgotPassword']){
			$_SESSION['login_user'] = 'Forgot';
			header("location: ForgotPass.php");
		}
  }
  
}


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bootstrap Dashboard by Bootstrapious.com</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.red.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Font Awesome CDN-->
    <!-- you can replace it by local Font Awesome-->
    <script src="https://use.fontawesome.com/99347ac47f.js"></script>
    <!-- Font Icons CSS-->
    <link rel="stylesheet" href="https://file.myfontastic.com/da58YPMQ7U5HY8Rb6UxkNf/icons.css">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1>Welcome</h1>
                  </div>
                  <p>Reyes Elementary Science Fair</p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                <p style="color:#ff0000"><?php echo $error; ?></p>
                  <form id="login-form" method="post" action="login.php">
                    <div class="form-group">
                      <input id="login-username" type="text" name="username" required="" class="input-material">
                      <label for="login-username" class="label-material">User Name</label>
                    </div>
                    <div class="form-group">
                      <input id="login-password" type="password" name="password" required="" class="input-material">
                      <label for="login-password" class="label-material">Password</label>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Login">
                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                  </form><form method = "get" action = "login.php"><a href="ForgotPass.php" class="forgot-pass" name = "forgotPassword" input type = 'hidden'>Forgot Password?</a><br><small></form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
      </div>
    </div>
    <!-- Javascript files-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.cookie.js"> </script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/front.js"></script>

  </body>
</html>