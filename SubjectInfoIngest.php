<?php
//**************************************************************
//If the DB doesn't exist, make it
//**************************************************************
$uname="experiment";
$pword="Password123!";

//**************************************************************
//Insert the new participant's record
//**************************************************************
$link=mysqli_connect("localhost",$uname,$pword,"ChrisMcGurkExperiment");

// Escape user inputs for security
$age = mysqli_real_escape_string($link, $_REQUEST['age']);
$gender = mysqli_real_escape_string($link, $_REQUEST['gender']);
$first_language = mysqli_real_escape_string($link, $_REQUEST['first_language']);
$hearing = mysqli_real_escape_string($link, $_REQUEST['hearing']);
$handedness = mysqli_real_escape_string($link, $_REQUEST['handedness']);
$audio = mysqli_real_escape_string($link, $_REQUEST['audio']);
$sid = mysqli_real_escape_string($link, $_REQUEST['StudentID']);
$cid = mysqli_real_escape_string($link, $_REQUEST['CourseID']);
$name = mysqli_real_escape_string($link, $_REQUEST['full_name']);
 
// Attempt insert query execution
$sql = "INSERT INTO participants (age, sex, spokenLang, hearing, handedness, audio) VALUES ('$age', '$gender', '$first_language', '$hearing', '$handedness', '$audio')";

//if the insertion was successful, grab the PID for later use
if(mysqli_query($link, $sql)){
	$pid=mysqli_insert_id($link);
    echo "Records added successfully. <br>";
    echo "Last inserted PID was " . $pid . "<br>";
} else{
    echo "ERROR: Could not execute $sql. " . mysqli_error($link);
}

$finished=0;
if($sid!="NaN"){
	$sql = "INSERT INTO students (sid, cid, name, finished) VALUES ('$sid', '$cid', '$name', '$finished')";
	if(mysqli_query($link, $sql)){
    	echo "Records added successfully. <br>";
	} else{
   		echo "ERROR: Could not execute $sql. " . mysqli_error($link);
	}
}

//**************************************************************
//Create the table that will be assigned to the participant
//**************************************************************

//Append P to the PID so that it's a valid table name
$pid="p" . $pid;

$sql = "CREATE TABLE IF NOT EXISTS $pid (
	id INT UNSIGNED AUTO_INCREMENT,
	speaker INT UNSIGNED NOT NULL,
	phrase INT UNSIGNED NOT NULL,
	type VARCHAR(10) NOT NULL,
	response VARCHAR(300),
	PRIMARY KEY (id)
)";

//Messages for testing
if(mysqli_query($link, $sql)){
    echo "Table created successfully. <br>";
} else{
    echo "ERROR: Could not execute $sql. " . mysqli_error($link);
}

setcookie("pid",$pid,time()+3600,"/");

// Close connection
mysqli_close($link);

//Needed for determining if the partcipant finished the experiment
if($sid!=NULL){
	setcookie("sid",$sid,time()+7200,"/");
	setcookie("cid",$cid,time()+7200,"/");
	setcookie("name",$name,time()+7200,"/");
} else{
	setcookie("sid","NaN",time()+7200,"/");
}

$sid=$_COOKIE["sid"];

echo $sid;

header("Location: https://tatalab.ca/MSSP/LearningVideoDisplayPage.html");
exit();

?>
