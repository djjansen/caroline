<?php 
ini_set("display_errors",1);
include("/var/cred.php");

$q = (string)$_GET['q'];
$rdout = (string)$_GET['rdout'];

if (!$conn) {
    die('Could not connect: ' . mysqli_error($con));
}

$sql = "INSERT INTO timer (time,status,readout)
VALUES (now(),'".$q."','".$rdout."')";

$result = mysqli_query($conn,$sql);

echo $result;

mysqli_close($conn);
?>
