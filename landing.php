<?php
//*********************************************************************
//Create tables if they don't exist so the first person in doesn't get shafted
$uname="experiment";
$pword="Password123!";
$link = mysqli_connect("localhost", $uname, $pword);

$sql = "CREATE DATABASE IF NOT EXISTS ChrisMcGurkExperiment";
if(mysqli_query($link, $sql)){
    echo "Database created successfully <br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

mysqli_close($link);

$link=mysqli_connect("localhost",$uname,$pword,"ChrisMcGurkExperiment");

$sql = "CREATE TABLE IF NOT EXISTS participants(
	pid INT UNSIGNED AUTO_INCREMENT,
	age VARCHAR(4) NOT NULL,
	sex VARCHAR(30) NOT NULL,
	spokenLang VARCHAR(1) NOT NULL,
	hearing VARCHAR(1) NOT NULL,
	handedness VARCHAR(1) NOT NULL,
	audio VARCHAR(1) NOT NULL,
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
	finished BOOLEAN NOT NULL,
	PRIMARY KEY (sid)
)";
if(mysqli_query($link, $sql)){
    echo "Table created successfully. <br>";
} else{
    echo "ERROR: Could not execute $sql. " . mysqli_error($link);
}
//*********************************************************************

$sql="SELECT * FROM students WHERE finished='1'";

$result=mysqli_query($link,$sql);
mysqli_close($link);

if($result){
	$row=mysqli_num_rows($result);
	echo $row;
	echo gettype($row);
	if($row>25){
		header("Location: Full.html");
	}
	else{
		header("Location: ConsentForm.html");
	}
}

?>
