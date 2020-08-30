<?php
   include('session.php');
   
   if($role == "user"){
	   header("location:index.php");
   }
    
	
	
	if (isset($_POST['Delete'])){
		$pkToDelete = $_POST['primaryKey'];
		$pidToDelete = $_POST['projectID'];
		
		 $queryStudentDelete = "Delete FROM Student WHERE s_id = '$pkToDelete'";
		 $queryProjectDelete = "DELETE FROM Project WHERE s_id = '$pkToDelete'";
		 $queryIndDelete = "DELETE FROM Individualscores WHERE p_id = '$pidToDelete'";
		 $queryRubricDelete = "DELETE FROM Rubric WHERE p_id = '$pidToDelete'";
		 
		if( (mysqli_query($db,$queryStudentDelete)) && (mysqli_query($db,$queryProjectDelete))&& (mysqli_query($db,$queryRubricDelete))&& (mysqli_query($db,$queryIndDelete))){
		echo "Successfuly Deleted";
		}
		else{
			echo"Could not Delete";
		}
	}
	
	
	if (isset($_POST['newFair'])){
		echo "Deleted";
		
		$deleteStudent = "DELETE FROM Student";
		$deleteProject = "DELETE FROM Project";
		$deleteRubric = "DELETE FROM Rubric";
		$deleteInd = "DELETE FROM Individualscores";
		$selectUser = "SELECT * FROM User1";
		$selectPassword = "SELECT * FROM Password";
		
		$queryStudent =  mysqli_query($db,$deleteStudent);
		$queryProject =  mysqli_query($db,$deleteProject);
		$queryRubric =  mysqli_query($db,$deleteRubric);
		$queryInd =  mysqli_query($db,$deleteInd);
		
		if($queryStudent && $queryProject && $queryRubric && $queryInd){
			echo "Success, all records have been cleared";
		} else {
			echo "Unable to clear all records";
		}
		
		//Query for deleting users
		$queryUser = mysqli_query($db,$selectUser);
		while ($row = mysqli_fetch_assoc( $queryUser))
		{
			$usern = $row['u_name'];
			if($row['u_name'] == "Admin" || $row['u_name'] == "User")
			{
				continue;
			}
			$deleteU = "DELETE FROM User1 WHERE u_name = '$usern'";
			mysqli_query($db,$deleteU);
			echo $usern;
			echo "<br>";
		}
		
		//Query for deleting passwords
		$queryPass = mysqli_query($db,$selectPassword);
		while ($row = mysqli_fetch_assoc( $queryPass))
		{
			$pass = $row['u_password'];
			if($row['u_password'] == "admin1" || $row['u_password'] == "user1")
			{
				continue;
			}
			$deleteP = "DELETE FROM Password WHERE u_password = '$pass'";
			mysqli_query($db,$deleteP);
			echo $pass;
			echo "<br>";
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
				<a href="logout.php" class="nav-link logout">Logout<i class="fa fa-sign-out"></i></a>
			</ul>
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
			
			
			<h2>Reports</h2>
			
			
	
	
	
	<br>
	<br>
	<div align = "center">
	<h2>Scores (Averaged)</h2>
	</div>
	<table border="2" style= "background-color: #71787d; color: #9b3729; margin: 0 auto;" >
			 <?php
			 echo "<thead>
					<tr>
					  <th>Student_Name</th>
					  <th>Project_ID</th>
					  <th>Category</th>
					  <th>Score</th>
					</tr>
				  </thead>";
				  ?>
      
      <tbody>
        <?php
			$queryProjects = "SELECT * FROM Project";
			$resultProjects = mysqli_query($db, $queryProjects);
			$rows = mysqli_num_rows($resultProjects);
			if($rows == 0){
			}
			else{
				while( $row = mysqli_fetch_assoc( $resultProjects ) ){
					$pid = $row['p_id'];
					$sid = $row['s_id'];
					$queryAvg = " SELECT AVG(r_score) FROM Project NATURAL JOIN Rubric WHERE p_id = '$pid'";
					$resultAvg = mysqli_query($db, $queryAvg);
					$arrayAvg = mysqli_fetch_array($resultAvg, MYSQL_NUM);
					$Avg = $arrayAvg[0];
					
					//Query to get students name
					$queryStudent = "SELECT * FROM Student WHERE s_id = '$sid'";
					$queryStudentResult = mysqli_query($db, $queryStudent);
					$studArray = mysqli_fetch_assoc($queryStudentResult);
					$studName = $studArray['s_name'];
					
					if($arrayAvg[0] == NULL)
					{
						continue;
					}
					
						echo
						"<tr>
						  <form method='POST' >
						  <td>{$studName}</td>
						  <td>{$row['p_id']}</td>
						  <td>{$row['p_category']}</td>
						  <td>{$Avg}</td>
						  </form>
						</tr>\n";
					
				  }
			}
		?>
      </tbody>
    </table>
	
	
	<br>
	<br>
	<div align = "center">
	<h2>Projects By Category</h2>
	</div>
	 <table border="2" style= "background-color: #71787d; color: #9b3729; margin: 0 auto;" >
			 <?php
			 echo "<thead>
					<tr>
					  <th>Student_Name</th>
					  <th>Project_Name</th>
					  <th>Category</th>
					</tr>
				  </thead>";
				  ?>
      
      <tbody>
        <?php
			$queryProjects = "SELECT * FROM ProjectsByCategory";
			$resultProjects = mysqli_query($db, $queryProjects);
			$rows = mysqli_num_rows($resultProjects);
			if($rows == 0){
				
			}
			else{
				while( $row = mysqli_fetch_assoc( $resultProjects ) ){
						echo
						"<tr>
						  <form method='POST' >
						  <td>{$row['s_id']}</td>
						  <td>{$row['p_name']}</td>
						  <td>{$row['p_category']}</td>
						  </form>
						</tr>\n";
					
				  }
			}
		?>
      </tbody>
    </table>
	
	<br>
	<br>
	<div align = "center">
	<h2>Projects By Grade</h2>
	</div>
	 <table border="2" style= "background-color: #71787d; color: #9b3729; margin: 0 auto;" >
			 <?php
			 echo "<thead>
					<tr>
					  <th>Student_Name</th>
					  <th>Project_Name</th>
					  <th>Grade_Level</th>
					</tr>
				  </thead>";
				  ?>
      
      <tbody>
        <?php
			$queryProjects = "SELECT * FROM ProjectsByLevel";
			$resultProjects = mysqli_query($db, $queryProjects);
			$rows = mysqli_num_rows($resultProjects);
			if($rows == 0){
			}
			else{
				while( $row = mysqli_fetch_assoc( $resultProjects ) ){
						echo
						"<tr>
						  <form method='POST' >
						  <td>{$row['s_id']}</td>
						  <td>{$row['p_name']}</td>
						  <td>{$row['s_glevel']}</td>
						  </form>
						</tr>\n";
					
				  }
			}
		?>
      </tbody>
    </table>
	
	<br>
	<br>
	<div align = "center">
	<h2>Top Scores in Physics</h2>
	</div>
	 <table border="2" style= "background-color: #71787d; color: #9b3729; margin: 0 auto;" >
			 <?php
			 echo "<thead>
					<tr>
					  <th>Student_Name</th>
					  <th>Project_Name</th>
					  <th>Score</th>
					</tr>
				  </thead>";
				  ?>
      
      <tbody>
        <?php
			//Original query was a call to a procedure but it would mess up the other queries
			//$queryPhysics = "CALL ViewTopPhysics()";
			$queryPhysics = "SELECT * FROM TopPhysics";
			$resultPhysics = mysqli_query($db, $queryPhysics);
			$rows = mysqli_num_rows($resultPhysics);
			if($rows == 0){
			}
			else{
				while( $row = mysqli_fetch_assoc( $resultPhysics) ){
					$sid = $row['s_id'];
					$queryStudent = 'SELECT * FROM Student WHERE s_id = '.$sid.'';
					$queryResultStudent = mysqli_query($db,$queryStudent);
					$studArray = mysqli_fetch_assoc($queryResultStudent);
					$sname = $studArray['s_name'];
					
					
						echo
						"<tr>
						  <form method='POST' >
						  <td>{$sname}</td>
						  <td>{$row['p_name']}</td>
						  <td>{$row['r_score']}</td>
						  </form>
						</tr>\n";
					
				  }
			}
		?>
      </tbody>
    </table>
	
	<br>
	<br>
	<div align = "center">
	<h2>Top Scores in Chemistry</h2>
	</div>
	 <table border="2" style= "background-color: #71787d; color: #9b3729; margin: 0 auto;" >
			 <?php
			 echo "<thead>
					<tr>
					  <th>Student_Name</th>
					  <th>Project_Name</th>
					  <th>Score</th>
					</tr>
				  </thead>";
				  ?>
      
      <tbody>
        <?php
			$queryProjects = "SELECT * FROM TopChemistry";
			$resultProjects = mysqli_query($db, $queryProjects);
			$rows = mysqli_num_rows($resultProjects);
			if($rows == 0){
			}
			else{
				while( $row = mysqli_fetch_assoc( $resultProjects ) ){
					$sid = $row['s_id'];
					$queryStudent = 'SELECT * FROM Student WHERE s_id = '.$sid.'';
					$queryResultStudent = mysqli_query($db,$queryStudent);
					$studArray = mysqli_fetch_assoc($queryResultStudent);
					$sname = $studArray['s_name'];
					
					
						echo
						"<tr>
						  <form method='POST' >
						  <td>{$sname}</td>
						  <td>{$row['p_name']}</td>
						  <td>{$row['r_score']}</td>
						  </form>
						</tr>\n";
					
				  }
			}
		?>
      </tbody>
    </table>
		
	<br>
	<br>
	<div align = "center">
	<h2>Top Scores in Life Science</h2>
	</div>
	 <table border="2" style= "background-color: #71787d; color: #9b3729; margin: 0 auto;" >
			 <?php
			 echo "<thead>
					<tr>
					  <th>Student_Name</th>
					  <th>Project_Name</th>
					  <th>Score</th>
					</tr>
				  </thead>";
				  ?>
      
      <tbody>
        <?php
			$queryProjects = "SELECT * FROM TopLifeScience";
			$resultProjects = mysqli_query($db, $queryProjects);
			$rows = mysqli_num_rows($resultProjects);
			if($rows == 0){
			}
			else{
				while( $row = mysqli_fetch_assoc( $resultProjects ) ){
					$sid = $row['s_id'];
					$queryStudent = 'SELECT * FROM Student WHERE s_id = '.$sid.'';
					$queryResultStudent = mysqli_query($db,$queryStudent);
					$studArray = mysqli_fetch_assoc($queryResultStudent);
					$sname = $studArray['s_name'];
					
					
						echo
						"<tr>
						  <form method='POST' >
						  <td>{$sname}</td>
						  <td>{$row['p_name']}</td>
						  <td>{$row['r_score']}</td>
						  </form>
						</tr>\n";
					
				  }
			}
		?>
      </tbody>
    </table>
		
		
	<br>
	<br>
	<div align = "center">
	<h2>Top Scores in Earth Science</h2>
	</div>
	 <table border="2" style= "background-color: #71787d; color: #9b3729; margin: 0 auto;" >
			 <?php
			 echo "<thead>
					<tr>
					  <th>Student_Name</th>
					  <th>Project_Name</th>
					  <th>Score</th>
					</tr>
				  </thead>";
				  ?>
      
      <tbody>
        <?php
			$queryProjects = "SELECT * FROM TopEarthScience";
			$resultProjects = mysqli_query($db, $queryProjects);
			$rows = mysqli_num_rows($resultProjects);
			if($rows == 0){
			}
			else{
				while( $row = mysqli_fetch_assoc( $resultProjects ) ){
					$sid = $row['s_id'];
					$queryStudent = 'SELECT * FROM Student WHERE s_id = '.$sid.'';
					$queryResultStudent = mysqli_query($db,$queryStudent);
					$studArray = mysqli_fetch_assoc($queryResultStudent);
					$sname = $studArray['s_name'];
					
					
						echo
						"<tr>
						  <form method='POST' >
						  <td>{$sname}</td>
						  <td>{$row['p_name']}</td>
						  <td>{$row['r_score']}</td>
						  </form>
						</tr>\n";
					
				  }
			}
		?>
      </tbody>
    </table>
	
		<?php
		if($role == "Admin"){
			echo "	<br>
	<br>
	<br>
	<br>
	<div align = 'center'>
	<h1>!!!!!!!!!!!!WARNING!!!!!!!!!!!!</h1>
	<h1>Only Press this button if you would like to clear all records for a new science fair</h1>
	<form  method = 'post' action = 'Reports.php'>
	<input type = 'submit' value = 'Reset' name = 'newFair'>
	</form>
	</div>";
		}
		
		?>
		
              
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