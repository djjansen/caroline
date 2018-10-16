<?php
ini_set('display_errors', 1); 
include("/var/cred.php");

if (!$conn) {
    die('Could not connect: ' . mysqli_error($con));
}
$sql = "SELECT * FROM timer ORDER BY id DESC LIMIT 1;";

$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$sql2 = "SELECT TIMEDIFF(NOW(),(SELECT MAX(time) from timer)) AS DIFF;";
$res2 = mysqli_query($conn,$sql2);
$row2 = mysqli_fetch_array($res2, MYSQLI_ASSOC);

$sql3 = "SELECT * FROM OverUnder ORDER BY id DESC LIMIT 1;";
$res3 = mysqli_query($conn,$sql3);
$row3 = mysqli_fetch_array($res3, MYSQLI_ASSOC);

$package = array($row2["DIFF"],$row["status"],$row["readout"],$row3["OverUnder"]);
echo $package[0] . "," . $package[1] . "," . $package[2] . "," . $package[3];
mysqli_close($conn);
?>
