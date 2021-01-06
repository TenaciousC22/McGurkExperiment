<?php
//**************************************************************
//Generate the list of videos to present to the participant
//**************************************************************
$uname="experiment";
$pword="Password123!";
$pid=$_COOKIE["pid"];
//Needs modification
//*****************************************************
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
//*****************************************************

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

$link=mysqli_connect("localhost",$uname,$pword,"ChrisMcGurkExperiment");

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

header("Location: https://tatalab.ca/MSSP/VideoDisplayPage.html?" . $pid . "|1|subclips/speaker" . $speaker . "/clip" . $phrase . "/" . $type . ".mp4");
exit();
?>
