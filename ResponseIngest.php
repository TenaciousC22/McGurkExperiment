<?php

$link=mysqli_connect("localhost","root","","ChrisMcGurkExperiment");

$response = mysqli_real_escape_string($link, $_REQUEST['response']);
$pid=$_COOKIE["pid"];
$vid=$_COOKIE["vid"];

echo "PID: " . $pid . "<br>VID: " . $vid . "<br>Response: " . $response . "<br>";

$sql="UPDATE $pid SET response='$response' WHERE id = $vid";

if(mysqli_query($link,$sql)){
	echo "Update successful <br>";
} else{
	echo "ERROR: Could not execute $sql. " . mysqli_error($link);
}

$vid=$vid+1;

if($vid>5){
	header("Location: FinalPage.html");
	exit();
}
else{
	$sql="SELECT * FROM $pid WHERE id=$vid";

	if($result=mysqli_query($link,$sql)){
		$row=mysqli_fetch_array($result);
		$speaker=$row["speaker"];
		$phrase=$row["phrase"];
		$type=$row["type"];
		echo "Speaker: " . $speaker . "<br>Phrase: " . $phrase . "<br>Type: " . $type . "<br>";
	}else{
	   	echo "ERROR: Could not execute $sql. " . mysqli_error($link);
	}

	mysqli_close($link);
	
	header("Location: https://localhost/McGurkExperiment/VideoDisplayPage.html?" . $pid . "|" . $vid . "|subclips/speaker" . $speaker . "/clip" . $phrase . "/" . $type . ".mp4");
	exit();
}
?>