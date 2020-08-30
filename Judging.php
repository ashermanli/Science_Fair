<?php
include('session.php');
$role= $_SESSION['login_role'];
$studentID = $_REQUEST['studentID'];
$projectID = $_REQUEST['projectID'];
$email = $_REQUEST['email'];

if(empty($projectID)){
	header("location:Projects.php");
	echo "test";
}

if($role == "Teacher")
{
	header("location:index.php");
}




/*$queryPID = "SELECT (p_id) FROM Project WHERE p_id = 222222";
$resultPID = mysqli_query($db,$queryPID);
$PID = mysqli_fetch_array($resultPID,MYSQL_NUM);
echo "this is pid:"
echo {$PID[0]};

$_SESSION['projID'] = $projectID;
$projID = $_SESSION['projID'];*/
echo $projectID;



$questions = array("Presented a question that could be answered through experimentation",
					"Variables and controls are defined, appropriate, and complete",
					"Clear procedural plan for testing the hypothesis, includes use of control variables",
					"The conclusions are based on multiple trials (at least 3) and adequate subjects were used",
					"Clear and thorough process for data observation and collection",
					"Sufficient data was collected to support interpretation and conclusions",
					"The finalist has an idea of what future research is warranted",
					"A minimum of three age-appropriate sources for background research",
					"Clearly identified and explained key scientific concepts releating to the experiment",
					"Used scientific principles and/or mathematical formulas correctly in the experiment",
					"Student suggests changes to the experimental procedure and/or possibilities for further study, while evaluating the success and effectiveness of the project",
					"Offers clarity of graphics and legends",
					"The important phases of the project are presented in an orderly manner",
					"Pictures and diagrams effectively convey information about the science fair project",
					"Understands the basic science relevance of the project",
					"Offers clear, concise, and thoughtful responses to questions",
					"Includes a lab notebook (High school requires a research paper)",
					"Student presents the relevance of the project",
					"Investigated an original question, used an original approach, or technique",
					"Shows enthusiasm and interest in the project",
					
					);

if(isset($_POST['submit'])){
	//Important variables
	$unansweredQ = false;
	$projID = $_REQUEST['projID'];
	$myusername = $_SESSION['login_user'];


	# Check if they left an answer blank
	for($questionNumber = 1; $questionNumber <= 20; $questionNumber++)
	{
		$questionID = 'q'.$questionNumber;
		$questionScore = $_REQUEST[$questionID]; # Score
		$questionText = $questions[$questionNumber-1];
		
		if (empty($questionScore)){
			echo "You didn't answer question $questionNumber - $questionText <br>";
			$unansweredQ = true;
			#break;
		}
	}

	

	

	if($unansweredQ){
		echo "You didn't answer all questions <br>";
	} else {
			for($questionNumber = 1; $questionNumber <= 20; $questionNumber++)
			{
				$questionID = 'q'.$questionNumber;
				$questionScore = $_REQUEST[$questionID]; # Score
				$questionText = $questions[$questionNumber-1];
				$r_id = 0;
				
				//Query to insert into Question Table
				$queryQuestion = "INSERT INTO Question (q_number, q_score, q_text) 
									VALUES ('$questionNumber', '$questionScore', '$questionText') 
									ON DUPLICATE KEY UPDATE q_score='$questionScore'";
				$resultQuestion = mysqli_query($db, $queryQuestion);
				
				//Query for individual scores
				$queryInd = "INSERT INTO Individualscores (p_id,q_score,q_number,u_email) VALUES ('$projID','$questionScore','$questionNumber','$myusername')";
				$resultInd = mysqli_query($db,$queryInd);

				/* For Debug Purposes
				if($resultQuestion){
					echo "Updated rubric with your score for question $questionNumber. <br>";
				} else {
					echo "Couldn't update your rubric score for question $questionNumber. Contact the System Admin. <br>";
				}*/

				 
			}
			//Calculate the sum for the rubric
			$querySum =  "SELECT SUM(q_score) FROM Question;";
			$resultSum = mysqli_query($db, $querySum);
			$sumArray = mysqli_fetch_array($resultSum, MYSQLI_NUM);
			$sum = $sumArray[0];
				
		

			$queryInsertRubric = "INSERT INTO Rubric(r_score, u_email, p_id) VALUES ('$sum','$myusername','$projID')";
			
			if(mysqli_query($db, $queryInsertRubric))
			{
				echo "Rubric Successfuly Inserted";
			}else{
				echo "Could not submit Rubric";
			}
	}
	

}

if(isset($_POST['updateScores'])){
	//Important variables
	$unansweredQ = false;
	$projID = $_REQUEST['projID'];
	$myusername = $_SESSION['login_user'];
	$email = $_REQUEST['jEmail'];
	
	echo $projID;
	echo $email;
	
	
	
			for($questionNumber = 1; $questionNumber <= 20; $questionNumber++)
			{
				$questionID = 'q'.$questionNumber;
				$questionScore = $_REQUEST[$questionID]; # Score
				$questionText = $questions[$questionNumber-1];
				$r_id = 0;
				
				//Query to insert into Question Table(UPDATES SCORE EACH TIME)
				$queryQuestion = "INSERT INTO Question (q_number, q_score, q_text) 
									VALUES ('$questionNumber', '$questionScore', '$questionText') 
									ON DUPLICATE KEY UPDATE q_score='$questionScore'";
				$resultQuestion = mysqli_query($db, $queryQuestion);
				
				//Query to update Individualscores Table
				$queryQUpdate = "UPDATE Individualscores SET q_score = '$questionScore' WHERE q_number = '$questionNumber' AND p_id = '$projID' AND u_email = '$email'";
				$resultQUpdate = mysqli_query($db, $queryQUpdate);
				
				//Query for individual scores
				//$queryInd = "INSERT INTO Individualscores (p_id,q_score,q_number,u_email) VALUES ('$projID','$questionScore','$questionNumber','$myusername')";
				//$resultInd = mysqli_query($db,$queryInd);

				//For Debug Purposes
				if($resultQUpdate){
					echo "Updated rubric with your score for question $questionNumber. <br>";
				} else {
					echo "Couldn't update your rubric score for question $questionNumber. Contact the System Admin. <br>";
				}

				 
			}
			//Calculate the sum for the rubric
			$querySum =  "SELECT SUM(q_score) FROM Question;";
			$resultSum = mysqli_query($db, $querySum);
			$sumArray = mysqli_fetch_array($resultSum, MYSQLI_NUM);
			$sum = $sumArray[0];
			
			
			$queryUpdateRubric = "UPDATE Rubric SET r_score = '$sum' WHERE p_id = '$projID' AND u_email = '$email'";

			//$queryInsertRubric = "INSERT INTO Rubric(r_score, u_email, p_id) VALUES ('$sum','$myusername','$projID')";
			
			if(mysqli_query($db, $queryUpdateRubric))
			{
				echo "Rubric Successfuly updated";
			}else{
				echo "Could not update Rubric";
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
			
			<?php
			 $sql = "SELECT * FROM Student";

			$result = mysqli_query($db,$sql);
			
			$row = mysqli_fetch_assoc($result);
			
			$role = $_SESSION['login_role'];
			
			echo "Student ID: {$studentID} &nbsp &nbsp Project ID: {$projectID}";
			
			?>
			
			  
			  <h2>Scientific Method</h2> <br>
			  
			   <form action="Judging.php" method="post">
			   
			   <?php
			   $scores = array();
			   
				//Query to retrieve saved scores
				$querySavedScores = "SELECT q_number,q_score FROM Individualscores WHERE p_id = '$projectID' AND u_email = '$email'";
				$resultSavedScores = mysqli_query($db,$querySavedScores);
				
				
				while($savedScoreArray = mysqli_fetch_assoc($resultSavedScores)){
					//echo var_dump($savedScoreArray);
					//echo "<br>";
					
				$testScore = $savedScoreArray['q_score'];
				$qnumber = $savedScoreArray['q_number'];
				
				//Make sure values are received from table
				//echo "The test Score is".$testScore;
				//echo "The Question number is". $qnumber;
				
					if($testScore == 1){
						$scoreInput ="<input type='radio' name='q".$qnumber."'value = '5' >5 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '4'>4 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '3'>3 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '2'>2 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '1' checked>1 &nbsp&nbsp"; 
							
							//echo "Inside the if";
							//echo $scoreInput;
							
							array_push($scores, $scoreInput);
					}
					if($testScore == 2){
						$scoreInput ="<input type='radio' name='q".$qnumber."'value = '5' >5 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '4'>4 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '3'>3 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '2' checked>2 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '1'>1 &nbsp&nbsp"; 
							
							//echo "Inside the if";
							//echo $scoreInput;
							
							array_push($scores, $scoreInput);
					}
					if($testScore == 3){
						$scoreInput ="<input type='radio' name='q".$qnumber."'value = '5' >5 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '4'>4 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '3' checked>3 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '2'>2 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '1'>1 &nbsp&nbsp"; 
							
							//echo "Inside the if";
							//echo $scoreInput;
							
							array_push($scores, $scoreInput);
					}
					if($testScore == 4){
						$scoreInput ="<input type='radio' name='q".$qnumber."'value = '5' >5 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '4' checked>4 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '3'>3 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '2'>2 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '1'>1 &nbsp&nbsp"; 
							
							//echo "Inside the if";
							//echo $scoreInput;
							
							array_push($scores, $scoreInput);
					}
					if($testScore == 5){
						$scoreInput ="<input type='radio' name='q".$qnumber."'value = '5' checked>5 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '4'>4 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '3'>3 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '2'>2 &nbsp&nbsp
							<input type='radio' name='q".$qnumber."' value = '1'>1 &nbsp&nbsp"; 
							
							//echo "Inside the if";
							//echo $scoreInput;
							
							array_push($scores, $scoreInput);
					}
					
				}
				//echo $scores[0]."<br>";
				//echo $scores[1]."<br>";
				
				//echo var_dump($scores);
			   
			   
			   $questions = "<input type='radio' name='q1'value = '5' >5 &nbsp&nbsp
						<input type='radio' name='q1' value = '4'>4 &nbsp&nbsp
						<input type='radio' name='q1' value = '3'>3 &nbsp&nbsp
						<input type='radio' name='q1' value = '2'>2 &nbsp&nbsp
						<input type='radio' name='q1' value = '1'>1 &nbsp&nbsp";
						
			   
			   $update = $_REQUEST['Updates'];
			   if($update == 'Update'){
				   

			   echo "
					$projectID; <br>
					We updating this bitch<br>
					1. Presented a question that could be answered through experimentation:
					<br>
					$scores[0];
					</div>
					<br>
					
					
					2. Variables and controls are defined, appropriate, and complete:
					<br>
					<div class = 'QButtons'>
					$scores[1];
					</div>
					<br>
					
					3. Clear procedural plan for testing the hypothesis, includes use of control variables:
					<div class = 'Qbuttons'>
					$scores[2];
					</div>
					<br>
					
					4. The conclusions are based on multiple trials (at least 3) and adequate subjects were used:
					<div class = 'Qbuttons'>
					$scores[3];
					</div>
					<br>
					
					5. Clear and thorough process for data observation and collection:
					<div class = 'Qbuttons'>
					$scores[4];
					</div>
					<br>
					
					6. Sufficient data was collected to support interpretation and conclusions:
					<div class = 'Qbuttons'>
					$scores[5];
					</div>
					<br>
					7. The finalist has an idea of what future research is warranted:
					<div class = 'Qbuttons'>
					$scores[6];
					</div>
					
					<br>
					<h2>Scientific Knowledge</h2><br>
					
					8. A minimum of three age-appropriate sources for background research:
					<div class = 'Qbuttons'>
					$scores[7];
					</div>
					<br>
					
					9. Clearly identified and explained key scientific concepts releating to the experiment:
					<div class = 'Qbuttons'>
					$scores[8];
					</div>
					<br>
					
					10. Used scientific principles and/or mathematical formulas correctly in the experiment:
					<div class = 'Qbuttons'>
					$scores[9];
					</div>
					<br>
					
					11. Student suggests changes to the experimental procedure and/or possibilities for further study, while evaluating the success and effectiveness of the project:
					<div class = 'Qbuttons'>
					$scores[10];
					</div>
					
					<br>
					<h2>Presentation</h2><br>
					
					
					12. Offers clarity of graphics and legends:
					<div class = 'Qbuttons'>
					$scores[11];
					</div>
					<br>
					
					13. The important phases of the project are presented in an orderly manner:
					<div class = 'Qbuttons'>
					$scores[12];
					</div>
					<br>
					
					14. Pictures and diagrams effectively convey information about the science fair project:
					<div class = 'Qbuttons'>
					$scores[13];
					</div>
					<br>
					
					15. Understands the basic science relevance of the project:
					<div class = 'Qbuttons'>
					$scores[14];
					</div>
					<br>
					
					16. Offers clear, concise, and thoughtful responses to questions:
					<div class = 'Qbuttons'>
					$scores[15];
					</div>
					<br>
					
					17. Includes a lab notebook (High school requires a research paper):
					<div class = 'Qbuttons'>
					$scores[16];
					</div>
					
					<br>
					<h2>Creativity</h2><br>
					
					18. Student presents the relevance of the project:
					<div class = 'Qbuttons'>
					$scores[17];
					</div>
					<br>
					
					19. Investigated an original question, used an original approach, or technique:
					<div class = 'Qbuttons'>
					$scores[18];
					</div>
					<br>
					
					20. Shows enthusiasm and interest in the project:
					<div class = 'Qbuttons'>
					$scores[19];
					</div>
					<br>
					<br>
					<input type = 'submit' value = 'Update' name = 'updateScores'>";
			   }else {
				    echo "
					
					1. Presented a question that could be answered through experimentation:
					<br>
					<div class = 'QButtons'>
					<input type='radio' name='q1' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q1' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q1' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q1' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q1' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					
					2. Variables and controls are defined, appropriate, and complete:
					<br>
					<div class = 'QButtons'>
					<input type='radio' name='q2' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q2' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q2' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q2' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q2' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					3. Clear procedural plan for testing the hypothesis, includes use of control variables:
					<div class = 'Qbuttons'>
					<input type='radio' name='q3' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q3' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q3' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q3' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q3' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					4. The conclusions are based on multiple trials (at least 3) and adequate subjects were used:
					<div class = 'Qbuttons'>
					<input type='radio' name='q4' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q4' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q4' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q4' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q4' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					5. Clear and thorough process for data observation and collection:
					<div class = 'Qbuttons'>
					<input type='radio' name='q5' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q5' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q5' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q5' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q5' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					6. Sufficient data was collected to support interpretation and conclusions:
					<div class = 'Qbuttons'>
					<input type='radio' name='q6' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q6' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q6' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q6' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q6' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					7. The finalist has an idea of what future research is warranted:
					<div class = 'Qbuttons'>
					<input type='radio' name='q7' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q7' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q7' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q7' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q7' value = '1'>1 &nbsp&nbsp
					</div>
					
					<br>
					<h2>Scientific Knowledge</h2><br>
					
					8. A minimum of three age-appropriate sources for background research:
					<div class = 'Qbuttons'>
					<input type='radio' name='q8' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q8' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q8' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q8' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q8' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					9. Clearly identified and explained key scientific concepts releating to the experiment:
					<div class = 'Qbuttons'>
					<input type='radio' name='q9' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q9' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q9' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q9' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q9' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					10. Used scientific principles and/or mathematical formulas correctly in the experiment:
					<div class = 'Qbuttons'>
					<input type='radio' name='q10' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q10' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q10' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q10' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q10' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					11. Student suggests changes to the experimental procedure and/or possibilities for further study, while evaluating the success and effectiveness of the project:
					<div class = 'Qbuttons'>
					<input type='radio' name='q11' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q11' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q11' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q11' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q11' value = '1'>1 &nbsp&nbsp
					</div>
					
					<br>
					<h2>Presentation</h2><br>
					
					
					12. Offers clarity of graphics and legends:
					<div class = 'Qbuttons'>
					<input type='radio' name='q12' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q12' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q12' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q12' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q12' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					13. The important phases of the project are presented in an orderly manner:
					<div class = 'Qbuttons'>
					<input type='radio' name='q13' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q13' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q13' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q13' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q13' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					14. Pictures and diagrams effectively convey information about the science fair project:
					<div class = 'Qbuttons'>
					<input type='radio' name='q14' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q14' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q14' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q14' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q14' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					15. Understands the basic science relevance of the project:
					<div class = 'Qbuttons'>
					<input type='radio' name='q15' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q15' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q15' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q15' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q15' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					16. Offers clear, concise, and thoughtful responses to questions:
					<div class = 'Qbuttons'>
					<input type='radio' name='q16' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q16' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q16' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q16' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q16' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					17. Includes a lab notebook (High school requires a research paper):
					<div class = 'Qbuttons'>
					<input type='radio' name='q17' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q17' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q17' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q17' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q17' value = '1'>1 &nbsp&nbsp
					</div>
					
					<br>
					<h2>Creativity</h2><br>
					
					18. Student presents the relevance of the project:
					<div class = 'Qbuttons'>
					<input type='radio' name='q18' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q18' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q18' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q18' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q18' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					19. Investigated an original question, used an original approach, or technique:
					<div class = 'Qbuttons'>
					<input type='radio' name='q19' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q19' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q19' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q19' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q19' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					
					20. Shows enthusiasm and interest in the project:
					<div class = 'Qbuttons'>
					<input type='radio' name='q20' value = '5'>5 &nbsp&nbsp
					<input type='radio' name='q20' value = '4'>4 &nbsp&nbsp
					<input type='radio' name='q20' value = '3'>3 &nbsp&nbsp
					<input type='radio' name='q20' value = '2'>2 &nbsp&nbsp
					<input type='radio' name='q20' value = '1'>1 &nbsp&nbsp
					</div>
					<br>
					<br>
					<input type = 'submit' value = 'Submit' name = 'submit'>";
			   }
		
		?>
		<input type = "hidden" value = "<?php echo htmlspecialchars($projectID)?>" name = "projID">
		<input type = "hidden" value = "<?php echo htmlspecialchars($email)?>" name = "jEmail">
		
		
		
		
		
		
		
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