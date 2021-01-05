<?php
$uname="experiment";
$pword="Password123!";
$link=mysqli_connect("localhost",$uname,$pword,"ChrisMcGurkExperiment");

$sql="SELECT * FROM students";

$result=mysqli_query($link,$sql);

if($result){
	$row=mysqli_num_rows($result);
	echo $row;
	echo gettype($row);
	if($row>10){
		header("Location: Full.html");
	}
	else{
		header("Location: ConsentForm.html");
	}
}

?>
