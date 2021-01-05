<?php
$uname="experiment";
$pword="Password123!";
$link=mysqli_connect("localhost",$uname,$pword,"ChrisMcGurkExperiment");

$response = mysqli_real_escape_string($link, $_REQUEST['response']);
$pid=$_COOKIE["pid"];
$vid=$_COOKIE["vid"];
$sid=$_COOKIE["sid"];

echo "PID: " . $pid . "<br>VID: " . $vid . "<br>Response: " . $response . "<br>";

$sql="UPDATE $pid SET response='$response' WHERE id = $vid";

if(mysqli_query($link,$sql)){
	echo "Update successful <br>";
} else{
	echo "ERROR: Could not execute $sql. " . mysqli_error($link);
}

$vid=$vid+1;

if($vid>48){
	/*
	echo $sid."<br>";
	if($sid!="NaN"){
		$cid=$_COOKIE["cid"];
		$name=$_COOKIE["name"];
		$sql = "INSERT INTO students (sid, cid, name) VALUES ('$sid', '$cid', '$name')";
		if(mysqli_query($link, $sql)){
	    	echo "Records added successfully. <br>";
		} else{
	   		echo "ERROR: Could not execute $sql. " . mysqli_error($link);
		}
	}
	*/
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
	
	header("Location: https://tatalab.ca/MSSP/VideoDisplayPage.html?" . $pid . "|" . $vid . "|subclips/speaker" . $speaker . "/clip" . $phrase . "/" . $type . ".mp4");
	exit();
}
?>
