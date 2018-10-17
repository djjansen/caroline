<?php 
ini_set("display_errors",1);
include("/var/cred.php");

$rdout = (string)$_GET['rdout'];
$OU = (string)$_GET['ovund'];
$status = (string)$_GET['funct'];

if (!$conn) {
    die('Could not connect: ' . mysqli_error($con));
}

if ($status === 'Over' || $status === 'Under') {
	$sql = "INSERT INTO OverUnder (time,readout,OverUnder,vote)
VALUES (now(),'".$rdout."','".$OU."','".$status."')";
} else {
$sql = "INSERT INTO OverUnder (time,readout,OverUnder)
VALUES (now(),'".$rdout."','".$OU."')";
}

$result = mysqli_query($conn,$sql);

echo $result;

mysqli_close($conn);
?>
