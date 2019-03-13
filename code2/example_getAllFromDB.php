<html>
<head>
<!--	<meta http-equiv="refresh" content="10"> -->
</head>
<body>

<?php 

	session_start();
	if (isset($_POST['hidden'])) {
    $myid = $_POST['hidden'];

    $bak2=-1;
    $bak3=-1;

    $GLOBALS['myid2'] = $myid;


	}
	


$con = mysqli_connect("localhost","root","","final");
if (!$con){
die("Can not connect: " . mysqli_error());
}

mysqli_select_db($con,"final");



if(isset($_POST['issue_pending'])&&isset($_POST['hidden'])){ 

	global $myid;

	


	echo "

		<form action='example_getAllFromDB.php' method='post'>
			<input type=text name=solution>
			<input type='hidden' name='hidden' value='".$_POST['hidden']."'>
			<input type=submit name=send_solution value='Send Solution'> 
		</form>		

		

	";







};


if( isset($_POST['send_solution']) && isset($_POST['hidden'] ) ){ 


	//echo $_POST['solution'] ;


	global $myid;



	echo "IS THE ISSUE RESOLVED??

		<form action=example_getAllFromDB.php method=post>
		<input type='hidden' name='hidden' value='".$_POST['hidden']."'>
		<input type=submit name=yes value='YES...SOLVED'>  *********OR**********   <input type=submit name=no value='NOT SOLVED'>
		</form>
			

		";

		

};

if(isset(  $_POST['yes'] ) && isset($_POST['hidden'] )  ){ 

	global $myid;

	

	$savid = $GLOBALS['myid2'] ;


	$UpdateQuery = "UPDATE finaltable SET  status='resolved' WHERE id= '$_POST[hidden]' "; //the problem was solved by dragging the $_POST[hidden] meaning using the line <input type='hidden' name='hidden' value='".$_POST['hidden']."'> BEFORE using the <input type=submit name=yes value='YES...SOLVED'>  *********OR**********   <input type=submit name=no value='NOT SOLVED'> wala line

    
	mysqli_query( $con,$UpdateQuery);

};



if(isset($_POST['no']) && isset($_POST['hidden'])) { 

	echo "

		Ticket no: ".$_POST['hidden'].  " is still marked as pending!



	";


};


if(isset($_POST['mark_pending']) && isset($_POST['hidden'])) { 

	global $myid;

	

	$savid = $GLOBALS['myid2'] ;


	$UpdateQuery = "UPDATE finaltable SET  status='PENDING' WHERE id= '$_POST[hidden]' "; //the problem was solved by dragging the $_POST[hidden] meaning using the line <input type='hidden' name='hidden' value='".$_POST['hidden']."'> BEFORE using the <input type=submit name=yes value='YES...SOLVED'>  *********OR**********   <input type=submit name=no value='NOT SOLVED'> wala line

    
	mysqli_query( $con,$UpdateQuery);



};

if(isset($_POST['mark_resolved']) && isset($_POST['hidden'])) { 

	global $myid;

	

	$savid = $GLOBALS['myid2'] ;


	$UpdateQuery = "UPDATE finaltable SET  status='resolved' WHERE id= '$_POST[hidden]' "; //the problem was solved by dragging the $_POST[hidden] meaning using the line <input type='hidden' name='hidden' value='".$_POST['hidden']."'> BEFORE using the <input type=submit name=yes value='YES...SOLVED'>  *********OR**********   <input type=submit name=no value='NOT SOLVED'> wala line

    
	mysqli_query( $con,$UpdateQuery);


};

if(isset($_POST['submit_steps_issues'])) {

			$UpdateQuery = "UPDATE finaltable SET  issues_faced='$_POST[issues_faced]' WHERE id='$_POST[hidden]' ";
			mysqli_query($con, $UpdateQuery);

			$UpdateQuery = "UPDATE finaltable SET  steps_taken='$_POST[steps_taken]' WHERE id='$_POST[hidden]' ";
			mysqli_query($con, $UpdateQuery);


		}




$sql = "SELECT * FROM finaltable";
$myData = mysqli_query($con,$sql);
echo "<table border=1>
<tr>
<th>id</th>
<th>subject</th>
<th>date</th>
<th>status</th>
<th>issues faced</th>
<th>steps taken</th>

</tr>";
while($record = mysqli_fetch_array($myData)){
echo "<form action=example_getAllFromDB.php method=post>";
echo "<tr>";
echo "<td>" . $record['id'] . " </td>";
echo "<td>" . $record['subject'] . " </td>";
echo "<td>" . $record['my_date'] . " </td>";
echo "<td>" . $record['status'] . " </td>";

echo "<td><textarea name=issues_faced>" . $record['issues_faced'] . " </textarea></td>";
echo "<td><textarea name=steps_taken>" . $record['steps_taken'] . " </textarea>";
echo "<input type=submit name=submit_steps_issues value='submit both issues and steps'> ";


echo "<td>" . "<input type='hidden' name='hidden' value='".$record['id']."' </td>";


$myid = $record['id'];



$_POST['kewl'] = $record['id'];

if($record['status']=="resolved")
	echo "<td>" . "<input type='submit' name='mark_pending' value='Mark As Pending' " . " </td>";
else 
	echo "<td>" . "<input type='submit' name='mark_resolved' value='Mark As Resolved' " . " </td>";
 



//echo "</tr>";
echo "</form>";
}

/*
echo "<form action=mydata5.php method=post>";
echo "<tr>";
echo "<td><input type=text name=uid></td>";
echo "<td><input type=text name=utask></td>";
echo "<td><input type=text name=ustatus></td>";		
echo "<td><input type=text name=uhandler></td>";
echo "<td>" . "<input type=submit name=add value=add" . " </td>";
echo "</tr>";
echo "</form>";
echo "</table>";

*/

mysqli_close($con);





?>


</body>
</html>
