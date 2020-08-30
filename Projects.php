<?php
   include('session.php');
   $role = $_SESSION['login_role'];
   
   if($role == "user"){
	   header("location:index.php");
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
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
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
    <div class="page home-page">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
				<!-- Logout    -->
				<a href="logout.php" class="nav-link logout" align = "right"> Logout<i class="fa fa-sign-out"></i></a>
			</ul>
          </div>
        </nav>
      </header>
	  
	  
      <div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        <nav class="side-navbar">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="img/ReyesRedHawks.jpg" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
              <h1 class="h4">Science Fair</h1>
            </div>
          </div>
          <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
          <ul class="list-unstyled">
            <li> <a href="./"><i class="icon-home"></i>Home</a></li>
            <?php
				$role = $_SESSION['login_role'];
				$teacherReg = '<li><a href="TeacherRegistration.php" aria-expanded="false" > <i class="icon-interface-windows"></i>Register Teachers </a></li>';
				$studentReg = '<li> <a href="StudentRegistration.php"> <i class="icon-interface-windows"></i>Register Students </a></li>';
				$judgeReg = '<li> <a href="JudgeRegistration.php"> <i class="icon-interface-windows"></i>Register Judges </a></li>';
				$projects = '<li> <a href="Projects.php"> <i class="icon-grid"></i>Projects </a></li>';
				$reports = '<li> <a href="Reports.php"> <i class="icon-padnote"></i>Reports </a></li>';
				$projectScores = '<li> <a href="ProjectScores.php"> <i class="icon-padnote"></i>Project Scores </a></li>';
				$logout = '<li> <a href="login.php"> <i class="icon-interface-windows"></i>Login Page</a></li>';
				
				if($role == "Judge" && $username == "user"){
					echo $judgeReg;
				}
				else if($role == "Teacher"){
					echo $studentReg;
					echo $projects;
					echo $projectScores;
					echo $reports;
				}
				else if($role == "Judge"){
					echo $projects;
					echo $projectScores;
					echo $reports;
				}
				else if($role == "Admin"){
					echo $teacherReg;
					echo $studentReg;
					echo $judgeReg;
					echo $projects;
					echo $projectScores;
					echo $reports;
				}
				
				echo $logout;
			?>
        </nav>
        <div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            
          </header>
          <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
			
			
			<h2>Student Projects</h2>
			<table border="2" style= "background-color: #71787d; color: #9b3729; margin: 0 auto;" >
			<?php 
			if($role == "Judge"){
				echo "<thead>
				<tr>
				<th>Project_id</th>
				<th>Project_Name</th>
				<th>Project_Category</th>
				<th></th>
				</tr>
				</thead>";
			}else{
				echo "<thead>
				<tr>
				<th>Project_id</th>
				<th>Project_Name</th>
				<th>Project_Category</th>
				</tr>
				</thead>";
			}
			?>
			 
			<tbody>
			 <?php
			//Project Info
			$myusername = $_SESSION['login_user'];
			
			if($role == "Judge"){
				$queryProject = "SELECT p_id, p_name, P.s_id, p_category FROM Project AS P JOIN Student AS S ON S.s_id = P.s_id";
			}else{
				$queryProject = "SELECT p_id, p_name, P.s_id, p_category, u_email FROM Project AS P JOIN Student AS S ON S.s_id = P.s_id ";
			}
			$resultProject = mysqli_query($db, $queryProject);
			$rows = mysqli_num_rows($resultProject);
			
			
			
			//Score info
			
			if($rows == 0){
				echo "Empty Table";
			}
			else{
				while( $row = mysqli_fetch_assoc( $resultProject ) ){
					
					$pid = $row['p_id'];
					$myusername = $_SESSION['login_user'];
					$queryScore = "Select * FROM Rubric WHERE p_id = '$pid' AND u_email = '$myusername'";
					$resultScore = mysqli_query($db,$queryScore);
					
					//For Debugging Purposes
					/*if($resultScore){
						echo "Success";
					}else {
						echo "Failure";
					}*/
					
					$scoreArray = mysqli_fetch_assoc($resultScore);
					if(count($scoreArray) > 0){
						continue;
					}
					
						if($role == "Judge"){
						echo "<tr>
						  <form method='POST' action = 'Judging.php'>
						  <td>{$row['p_id']}</td>
						  <td>{$row['p_name']}</td>
						  <td>{$row['p_category']}</td>
						  <td><b><input type = 'submit' name = 'Judge' value = 'Judge'></b></td>
						  <input type='hidden' name='studentID' value='{$row['s_id']}'>
						  <input type='hidden' name='projectID' value='{$row['p_id']}'>
						  
						  </form>
						</tr>\n";
						}else {
							echo "<tr>
						  <form method='POST' action = 'Judging.php'>
						  <td>{$row['p_id']}</td>
						  <td>{$row['p_name']}</td>
						  <td>{$row['p_category']}</td>
						  <input type='hidden' name='studentID' value='{$row['s_id']}'>
						  <input type='hidden' name='projectID' value='{$row['p_id']}'>
						  
						  </form>
						</tr>\n";
						}
				  }
			}
		?>
		</tbody>
		</table>
		
		
		</form>
              
          </section>
          <!-- Dashboard Header Section    -->
          <section class="dashboard-header">
           
          </section>
          <!-- Projects Section-->
          <section class="projects no-padding-top">
            
          </section>
          <!-- Client Section-->
          <section class="client no-padding-top">
            
          </section>
          <!-- Feeds Section-->
          <section class="feeds no-padding-top">
           
          </section>
          <!-- Updates Section                                                -->
          <section class="updates no-padding-top">
            
          </section>
          <!-- Page Footer-->
          <footer class="main-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">
                  <p>Reyes Elementary &copy; 2017-2019</p>
                </div>
                <div class="col-sm-6 text-right">
                  <p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a></p>
                  <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </div>
    <!-- Javascript files-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.cookie.js"> </script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="js/charts-home.js"></script>
    <script src="js/front.js"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>
  </body>
</html>