<?php
   include('session.php');
   
   
   
   $role= $_SESSION['login_role'];

if($role == "Judge")
{
	header("location:index.php");
}
   
   //Get variables from table
   $studentID = $_REQUEST['primaryKey'];
   $studentName= $_REQUEST['studentName'];
   $studentSchool = $_REQUEST['studentSchool'];
   $studentLevel = $_REQUEST['studentLevel'];
   $projectID = $_REQUEST['projectID'];
   $email = $_REQUEST['email'];
   
   
   
   $role = $_SESSION['login_role'];
   if($role == "Admin"){
	   if(isset($_POST['submitted'])){
		   $studentid = $_REQUEST['sid'];
			$sname = $_REQUEST['sname'];
			$school = $_REQUEST['school'];
			$slevel = $_REQUEST['slevel'];
			$regemail = $_REQUEST['regemail'];
			$projectid = $_REQUEST['pid'];
			$projectname = $_REQUEST['pname'];
			$projectcategory = $_REQUEST['Category'];
			
			//This converts input into empty strings (DO NOT USE)
			
			//$jname = mysql_real_escape_string($jname);
			//$jemail = mysql_real_escape_string($jemail);
			//$jpass = mysql_real_escape_string($jpass);
			
			if(empty($studentid) && empty($projectid) && empty($projectcategory)){
				echo "You didn't fill in the form correctly";
			}else{
			
				$queryStudentInsert = "INSERT INTO Student (s_id, s_name, s_school,s_glevel, u_email) VALUES ('$studentid', '$sname', '$school', '$slevel','$regemail')";
				$queryProjectInsert = "INSERT INTO Project (p_id, p_name, s_id,p_category) VALUES ('$projectid', '$projectname','$studentid', '$projectcategory')";
			
				if((mysqli_query($db, $queryStudentInsert)) && (mysqli_query($db,$queryProjectInsert))){
					echo "Records inserted successfully.";
				} else{
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
				}
			}
		}
		
   }else{
	   if(isset($_POST['submitted'])){
		   $studentid = $_REQUEST['sid'];
			$sname = $_REQUEST['sname'];
			$school = $_REQUEST['school'];
			$slevel = $_REQUEST['slevel'];
			$regemail = $_SESSION['login_name'];
			$projectid = $_REQUEST['pid'];
			$projectname = $_REQUEST['pname'];
			$projectcategory = $_REQUEST['Category'];
			
			//This converts input into empty strings (DO NOT USE)
			
			//$jname = mysql_real_escape_string($jname);
			//$jemail = mysql_real_escape_string($jemail);
			//$jpass = mysql_real_escape_string($jpass);
			
			if(empty($studentid) || empty($projectid)){
				echo "You didn't fill in the form";
			}else{
			
				$queryStudentInsert = "INSERT INTO Student (s_id, s_name, s_school,s_glevel, u_email) VALUES ('$studentid', '$sname', '$school', '$slevel','$regemail')";
				$queryProjectInsert = "INSERT INTO Project (p_id, p_name, s_id,p_category) VALUES ('$projectid', '$projectname','$studentid', '$projectcategory')";
				
			
				if((mysqli_query($db, $queryStudentInsert)) && (mysqli_query($db,$queryProjectInsert))){
					echo "Records inserted successfully.";
				} else{
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
				}
			}
		}
   }	
		
		
		if(isset($_POST['update'])){
	   $studentid = $_REQUEST['usid'];
		$sname = $_REQUEST['usname'];
		$school = $_REQUEST['uschool'];
		$slevel = $_REQUEST['uslevel'];
		$projectid = $_REQUEST['upid'];
		$regemail = $_REQUEST['uregemail'];
		
		//This converts input into empty strings (DO NOT USE)
		
		//$jname = mysql_real_escape_string($jname);
		//$jemail = mysql_real_escape_string($jemail);
		//$jpass = mysql_real_escape_string($jpass);
		
		$queryUpdateStudent = "UPDATE Student SET s_name = '$sname', s_school = '$school', s_glevel = '$slevel', u_email = '$regemail'  WHERE s_id = '$studentid'";
		
		
		if(mysqli_query($db, $queryUpdateStudent)){
			echo "Records inserted successfully.";
		} else{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
		}
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
				<a href="logout.php" class="nav-link logout" >Logout<i class="fa fa-sign-out"></i></a>
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
		<div style="float:left; margin-bottom:20px;">
			<h2>Register a Student</h2>
				 <form action="StudentRegistration.php" method="post">
				Student ID: &nbsp&nbsp&nbsp&nbsp<br>
				<input type="text" name="sid">&nbsp&nbsp&nbsp&nbsp<br>
				
				Student Name: &nbsp&nbsp&nbsp&nbsp<br>
				<input type="text" name="sname"> &nbsp&nbsp&nbsp&nbsp<br>
				
				School:&nbsp&nbsp&nbsp&nbsp<br>
				<input type = "text" name = "school">&nbsp&nbsp&nbsp&nbsp<br>
				
				Grade Level:&nbsp&nbsp&nbsp&nbsp<br>
				<input type = "text" name = "slevel">&nbsp&nbsp&nbsp&nbsp<br>
				
				Project ID:&nbsp&nbsp&nbsp&nbsp<br>
				<input type = "text" name = "pid">&nbsp&nbsp&nbsp&nbsp<br>
				
				Project Name:&nbsp&nbsp&nbsp&nbsp<br>
				<input type = "text" name = "pname">&nbsp&nbsp&nbsp&nbsp<br>
				
				Project Category:&nbsp&nbsp&nbsp&nbsp<br>
				<input type='radio' name='Category'value = 'Physics' >Physics
				<input type='radio' name='Category' value = 'Chemistry'>Chemistry 
				<input type='radio' name='Category' value = 'Life Science'>Life Science
				<input type='radio' name='Category' value = 'Earth Science'>Earth Science 
				<br>
				<br>
	
				<?php
				$role = $_SESSION['login_role'];
				if($role == "Admin"){
					$emailReg = '<input type = "text" name = "regemail">&nbsp&nbsp<br>';
					echo "Teacher's Name:&nbsp&nbsp<br>";
					echo $emailReg;
				}
				?>
		
				<input type = "submit" value = "Submit" name = "submitted">
				</form>
		</div>
			
			
				
				<?php
				if(isset($_POST['Update'])){
				echo "<div style ='padding-left: 15%;'>
				<h2>Update Student ".$studentID."</h2>
				 <form action='StudentRegistration.php' method='post'>
				 
					Student Name:<br>
					<input type='text' name='usname' value = '$studentName'><br>
					
					School:<br>
					<input type = 'text' name = 'uschool' value = '$studentSchool'><br>
					
					Grade Level:<br>
					<input type = 'text' name = 'uslevel' value = '$studentLevel'><br>
					
					Project ID:<br>
					<input type = 'text' name = 'upid' value = '$projectID'><br>
					
					Registrator's Email:<br>
					<input type = 'text' name = 'uregemail' value = '$email'><br>
					<input type = 'hidden' name = 'usid' value = '$studentID'>
					
					<input type = 'submit' value = 'Update' name = 'update'>
					</div>
				</form>";
				}
		
				?>
				
		
		
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<div align = "right">
			 <table border="2" style= "background-color: #71787d; color: #9b3729; margin: 0 auto;" >
			 <?php
			 if($role == 'Admin' || $role == 'Teacher'){
			 echo "<thead>
					<tr>
					  <th>Student_id</th>
					  <th>Student_Name</th>
					  <th>Student_School</th>
					  <th>Student_Grade</th>
					  <th>Project_ID</th>
					  <th>Registrator</th>
					  <th>Delete</th>
					  <th>Update</th>
					</tr>
				  </thead>";
			 }else {
				 echo "<thead>
					<tr>
					  <th>Student_id</th>
					  <th>Student_Name</th>
					  <th>Student_School</th>
					  <th>Student_Grade</th>
					  <th>Project_ID</th>
					  <th>Registrator</th>
					</tr>
				  </thead>";
			 }
			 ?>
      
      <tbody>
        <?php
			$queryStudent = "SELECT * FROM Student";
			$resultStudent = mysqli_query($db, $queryStudent);
			$rows = mysqli_num_rows($resultStudent);
			if($rows == 0){
				
			}
			else{
				while( $row = mysqli_fetch_assoc( $resultStudent ) ){
					$sid = $row['s_id'];
					$queryPID = "SELECT p_id FROM Project WHERE s_id='{$sid}'";
					
					$resultPID = mysqli_query($db, $queryPID);
					$arrayPID = mysqli_fetch_array($resultPID, MYSQL_NUM);
					$pid = $arrayPID[0];
					
					if($role == "Admin" || $role == "Teacher"){
						echo
						"<tr>
						  <form method='POST' >
						  <td>{$row['s_id']}</td>
						  <td>{$row['s_name']}</td>
						  <td>{$row['s_school']}</td>
						  <td>{$row['s_glevel']}</td>
						  <td>{$pid}</td>
						  <td>{$row['u_email']}</td> 
						  <td><b><input type = 'submit' name = 'Delete' value = 'Delete' formaction = 'StudentRegistration.php'></b></td>
						  <td><b><input type = 'submit' name = 'Update' value = 'Update' formaction = 'StudentRegistration.php'></b></td>
						  <input type='hidden' name='primaryKey' value='{$row['s_id']}'>
						  <input type='hidden' name='studentName' value = '{$row['s_name']}'>
						  <input type='hidden' name='studentSchool' value = '{$row['s_school']}'>
						  <input type='hidden' name='studentLevel' value = '{$row['s_glevel']}'>
						  <input type='hidden' name='projectID' value = '{$pid}'>
						  <input type='hidden' name='email' value = '{$row['u_email']}'>
						  </form>
						</tr>\n";
					}else{
						echo
						"<tr>
						  <form method='POST' >
						  <td>{$row['s_id']}</td>
						  <td>{$row['s_name']}</td>
						  <td>{$row['s_school']}</td>
						  <td>{$row['s_glevel']}</td>
						  <td>{$pid}</td>
						  <td>{$row['u_email']}</td> 
						  <input type='hidden' name='primaryKey' value='{$row['s_id']}'>
						  <input type='hidden' name='studentName' value = '{$row['s_name']}'>
						  <input type='hidden' name='studentSchool' value = '{$row['s_school']}'>
						  <input type='hidden' name='studentLevel' value = '{$row['s_glevel']}'>
						  <input type='hidden' name='projectID' value = '{$pid}'>
						  <input type='hidden' name='email' value = '{$row['u_email']}'>
						  </form>
						</tr>\n";
					}
				  }
			}
		?>
      </tbody>
    </table>
	</div>
              
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
          <footer class="main-footer" style="margin-top:10px;">
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