<?php
//**************************************************************
//If the DB doesn't exist, make it
//**************************************************************
$link = mysqli_connect("localhost", "root", "");

if($link === false){
    die("ERROR: Could not connect to localhost. " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS ChrisMcGurkExperiment";
if(mysqli_query($link, $sql)){
    echo "Database created successfully <br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Close Connection
mysqli_close($link);

//**************************************************************
//If the table doesn't exist already, make it
//**************************************************************
$link=mysqli_connect("localhost","root","","ChrisMcGurkExperiment");

if($link===false){
	die("ERROR: Could not connect to Database. " . mysqli_connect_error());
}

$sql = "CREATE TABLE IF NOT EXISTS participants(
	pid INT UNSIGNED AUTO_INCREMENT,
	age VARCHAR(4) NOT NULL,
	gender VARCHAR(30) NOT NULL,
	spokenLang VARCHAR(30) NOT NULL,
	PRIMARY KEY (pid)
) AUTO_INCREMENT=1000";
if(mysqli_query($link, $sql)){
    echo "Table created successfully. <br>";
} else{
    echo "ERROR: Could not execute $sql. " . mysqli_error($link);
}

$sql = "CREATE TABLE IF NOT EXISTS students(
	sid VARCHAR(10) NOT NULL,
	cid VARCHAR(20) NOT NULL,
	name VARCHAR(50) NOT NULL,
	PRIMARY KEY (sid)
)";
if(mysqli_query($link, $sql)){
    echo "Table created successfully. <br>";
} else{
    echo "ERROR: Could not execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);

//**************************************************************
//Insert the new participant's record
//**************************************************************
$link=mysqli_connect("localhost","root","","ChrisMcGurkExperiment");

// Escape user inputs for security
$age = mysqli_real_escape_string($link, $_REQUEST['age']);
$gender = mysqli_real_escape_string($link, $_REQUEST['gender']);
$first_language = mysqli_real_escape_string($link, $_REQUEST['first_language']);
$sid = mysqli_real_escape_string($link, $_REQUEST['StudentID']);
$cid = mysqli_real_escape_string($link, $_REQUEST['CourseID']);
$name = mysqli_real_escape_string($link, $_REQUEST['full_name']);
 
// Attempt insert query execution
$sql = "INSERT INTO participants (age, gender, spokenLang, sid) VALUES ('$age', '$gender', '$first_language', '$sid')";

//if the insertion was successful, grab the PID for later use
if(mysqli_query($link, $sql)){
	$pid=mysqli_insert_id($link);
    echo "Records added successfully. <br>";
    echo "Last inserted PID was " . $pid . "<br>";
} else{
    echo "ERROR: Could not execute $sql. " . mysqli_error($link);
}
// Close connection
mysqli_close($link);

//**************************************************************
//Create the table that will be assigned to the participant
//**************************************************************

//Connect to the DB
$link=mysqli_connect("localhost","root","","ChrisMcGurkExperiment");

if($link===false){
	die("ERROR: Could not connect to Database. " . mysqli_connect_error());
}

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

if($sid!=NULL){
	setcookie("sid",$sid,time()+7200,"/");
	setcookie("cid",$cid,time()+7200,"/");
	setcookie("name",$name,time()+7200,"/");
} else{
	setcookie("sid","NaN",time()+7200,"/");
}

$sid=$_COOKIE["sid"];

echo $sid;
//**************************************************************
//Generate the list of videos to present to the participant
//**************************************************************
/*
$typeMap=array(
	0=>"base",
	1=>"B060",
	2=>"B240",
	3=>"B360",
	4=>"I060",
	5=>"I240",
	6=>"I360",
	7=>"jumble"
);

$counter=0;
$speakers=array();
$phrases=array();
$types=array();


for($x=1;$x<=6;$x++){
	$numbers=range(1,27);
	shuffle($numbers);
	//echo gettype($numbers[4]) . "<br>";
	for($y=0;$y<=7;$y++){
		//echo $typeMap[$y] . "<br>";
		$speakers[$counter]=$x;
		$phrases[$counter]=$numbers[$y];
		$types[$counter]=$typeMap[$y];
		$counter++;
	}
}

$link=mysqli_connect("localhost","root","","ChrisMcGurkExperiment");

if($link===false){
	die("ERROR: Could not connect to Database. " . mysqli_connect_error());
}

$numbers=range(0,47);
shuffle($numbers);
for($x=0;$x<48;$x++){
	$i=$numbers[$x];
	$speaker=$speakers[$i];
	$phrase=$phrases[$i];
	$type=$types[$i];
	$sql = "INSERT INTO $pid (speaker, phrase, type) VALUES ($speaker, $phrase, '$type' )";
	if(mysqli_query($link, $sql)){
    	echo "Records added successfully. <br>";
	} else{
   		echo "ERROR: Could not execute $sql. " . mysqli_error($link);
	}
}

$sql="SELECT * FROM $pid WHERE id=1";

if($result=mysqli_query($link,$sql)){
	$row=mysqli_fetch_array($result);
	$speaker=$row["speaker"];
	$phrase=$row["phrase"];
	$type=$row["type"];
	echo "Speaker: " . $speaker . "<br>Phrase: " . $phrase . "<br>Type: " . $type . "<br>";
}

mysqli_close($link);

header("Location: https://localhost/McGurkExperiment/VideoDisplayPage.html?" . $pid . "|1|subclips/speaker" . $speaker . "/clip" . $phrase . "/" . $type . ".mp4");
*/


header("Location: https://localhost/McGurkExperiment/LearningVideoDisplayPage.html");
exit();

?>