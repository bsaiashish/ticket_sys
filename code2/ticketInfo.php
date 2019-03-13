
<?php

$con = mysqli_connect("localhost","root","","final");
if (!$con){
die("Can not connect: " . mysqli_error());
}

mysqli_select_db($con,"finaltable");




$UpdateQuery = "UPDATE finaltable SET  issues_faced='$_POST[issues_faced]' WHERE id='$_POST[hidden]' ";
            mysqli_query($con, $UpdateQuery);

            $UpdateQuery = "UPDATE finaltable SET  steps_taken='$_POST[steps_taken]' WHERE id='$_POST[hidden]' ";
            mysqli_query($con, $UpdateQuery);


            $my_issues = $_POST["issues_faced"];
            $my_steps = $_POST["steps_taken"];




 mysqli_close($con);

 //print_r($_POST);

?>