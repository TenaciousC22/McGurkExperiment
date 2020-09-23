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
	sid VARCHAR(10),
	PRIMARY KEY (pid)
) AUTO_INCREMENT=1000";
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
 
// Close connection
mysqli_close($link);

//**************************************************************
//Generate the list of videos to present to the participant
//**************************************************************

$typeMap=array();
$typeMap[0]="base";
$typeMap[1]="B060";
$typeMap[2]="B240";
$typeMap[3]="B360";
$typeMap[4]="I060";
$typeMap[5]="I240";
$typeMap[6]="I360";
$typeMap[7]="jumble";

$counter=0;
$speakers=array();
$phrases=array();
$types=array();


for($x=1;$x<=6;$x++){
	$numbers=range(1,28);
	shuffle($numbers);
	//echo gettype($numbers[4]) . "<br>";
	for($y=0;$y<=7;$y++){
		$speakers[$counter]=$x;
		$phrases[$counter]=$numbers[$y];
		$types[$counter]=$y;
		$counter++;
	}
}
echo "Done";



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

mysqli_close($link);

?>