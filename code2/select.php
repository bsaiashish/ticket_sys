<?php

	$connect = mysqli_connect("localhost","root","","final");
	$output = '';
	$sql = "SELECT * FROM tbl_sample ORDER BY id DESC ";
	$result = mysqli_query($connect, $sql);

?>