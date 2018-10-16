<?php 
ini_set("display_errors",1);
include("/var/cred.php");

$rdout = (string)$_GET['rdout'];
$OU = (string)$_GET['ovund'];

if (!$conn) {
    die('Could not connect: ' . mysqli_error($con));
}

$sql = "INSERT INTO OverUnder (time,readout,OverUnder)
VALUES (now(),'".$rdout."','".$OU."')";

$result = mysqli_query($conn,$sql);

echo $result;

mysqli_close($conn);
?>
