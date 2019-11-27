
<?php

$con = mysqli_connect("localhost","mobiwved_mashroom","mashroom123$","mobiwved_mashroom");
$today=date("Y-m-d");
$sql = "UPDATE users SET is_plus='0',is_plus_enddate='0000-00-00' WHERE is_plus_enddate='$today'";
mysqli_query($con, $sql);

?>