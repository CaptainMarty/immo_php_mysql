<?php


include('../config.php');

$uid = $_GET['id'];
$sql = "SELECT * FROM user WHERE uid = {$uid}";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
    $img = $row['uimage'];
    @unlink("user/".$img);
}
$sql = "DELETE FROM user WHERE uid = {$uid}";

$result = mysqli_query($con, $sql);

if ($result == true) {
    $msg = "<p class='alert alert-success'>Builder Deleted Successfuly</p>";
    header("Location: userbuilder.php? msg=$msg");
} else {
    $msg = "<p class='alert alert-danger'>Can't Delete Builder</p>";
    header("Location: userbuilder.php? msg=$msg");
}
mysqli_close($con);
