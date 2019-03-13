
<?php

$con = mysqli_connect("localhost","root","","final");
if (!$con){
die("Can not connect: " . mysqli_error());
}

mysqli_select_db($con,"finaltable");
$query = "SELECT status, count(*) as number FROM finaltable GROUP BY status ";
$pieresult = mysqli_query($con, $query);

?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width = device-width, initial-scale = 1">



	<title>Halliburton Ticketing System</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type="text/javascript">
	
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart()
{
	var data = google.visualization.arrayToDataTable([
			['status', 'number'],

			<?php

				while($row = mysqli_fetch_array($pieresult))
				{
					echo "['".$row["status"]."', ".$row["number"]."]," ;
				}

			?>	


		]);


	var options = {'title':'Percentage of Pending and Resolved Tasks', is3D:true};

	var chart = new google.visualization.PieChart(document.getElementById('piechart'));

	chart.draw(data, options);



}

</script>



</head>



<!--<body style="background-color:#F8F9F9;">-->


<body background="https://i2.wp.com/www.technig.com/wp-content/uploads/2016/05/use-particlesjs.gif?fit=800%2C600&ssl=1">


<!--TABLE CODE-->



<?php
/*
$con = mysqli_connect("localhost","root","","final");
if (!$con){
die("Can not connect: " . mysqli_error());
}

mysqli_select_db($con,"finaltable");


echo "

<center>

<h2>TICKET IDS PENDING:</h2>

</center>

</br>";

$q = mysqli_query($con, "SELECT id FROM finaltable WHERE status='PENDING' ");

while($record = mysqli_fetch_array($q)){

$za = $record['id'];

echo "<a href =#$za>". $record['id']. "</a> ";

}

$query = "SELECT status, count(*) as number FROM finaltable GROUP BY status ";
$pieresult = mysqli_query($con, $query);

*/

?>


<!--TABLE CODE-->

<center>
<div id="piechart" style="width: 900px; height: 500px;"></div>
</center>



<div class="container">
	<div class="page-header">
		<br>
		<h1>___________ Welcome to Halliburton Ticketing System ___________</h1>
		<br>
	</div>


	<div class="jumbotron">
	<p>This web app tracks all the emails received and assigns them as tickets. Also, one can view attachments as well as inline images which may have been added as screenshots.</p>
	</div>

</div>	




<?php
// Turn off error reporting



error_reporting(E_ALL & ~E_DEPRECATED);

//error_reporting(E_ALL ^ E_DEPRECATED);


error_reporting(0);



// Report runtime errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Report all errors
error_reporting(E_ALL);



// Same as error_reporting(E_ALL);
ini_set("error_reporting", E_ALL);

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);
?>


<?php
/* 
 * File: example.php 
 * Description: Received Mail Example 
 * Created: 01-03-2006 
 * Author: Mitul Koradia 
 * Email: mitulkoradia@gmail.com 
 * Cell : +91 9825273322 
 */ 
include("receivemail.class.php"); 

////////////







//
//session_start commented to remove warning
//session_start();
    if (isset($_POST['hidden'])) {
    $myid = $_POST['hidden'];

    $bak2=-1;
    $bak3=-1;

    $GLOBALS['myid2'] = $myid;


    }


?>





<?php


$con = mysqli_connect("localhost","root","","final");
if (!$con){
die("Can not connect: " . mysqli_error());
}

mysqli_select_db($con,"finaltable");



if(isset($_POST['submit_issues'])) {

            $UpdateQuery = "UPDATE finaltable SET  issues_faced='$_POST[issues_faced]' WHERE id='$_POST[hidden]' ";
            mysqli_query($con, $UpdateQuery);


        }

if(isset($_POST['submit_steps'])) {

            $UpdateQuery = "UPDATE finaltable SET  steps_taken='$_POST[steps_taken]' WHERE id='$_POST[hidden]' ";
            mysqli_query($con, $UpdateQuery);


        }

if(isset($_POST['submit_steps_issues'])) {

            $UpdateQuery = "UPDATE finaltable SET  issues_faced='$_POST[issues_faced]' WHERE id='$_POST[hidden]' ";
            mysqli_query($con, $UpdateQuery);

            $UpdateQuery = "UPDATE finaltable SET  steps_taken='$_POST[steps_taken]' WHERE id='$_POST[hidden]' ";
            mysqli_query($con, $UpdateQuery);


            $my_issues = $_POST["issues_faced"];
            $my_steps = $_POST["steps_taken"];


        }



/*

if(isset($_POST['issue_pending'])&&isset($_POST['hidden'])){ 

    global $myid;

    


    echo "

        <form action='madtest.php' method='post'>
            <input type=text name=solution>
            <input type='hidden' name='hidden' value='".$_POST['hidden']."'>
            <input type=submit name=send_solution value='Send Solution'> 
        </form>     

        

    ";







};  

*/

/*
if( isset($_POST['issue_pending']) && isset($_POST['hidden'] ) ){ 


    //echo $_POST['solution'] ;


    global $myid;



    echo "ISSUE IS RESOLVED!

        <form action=madtest.php method=post>
        <input type='hidden' name='hidden' value='".$_POST['hidden']."'>
        <input type=submit name=yes value='YES...SOLVED'>  *********OR**********   <input type=submit name=no value='NOT SOLVED'>
        </form>
            

        ";

        

};*/

if(isset(  $_POST['issue_pending'] ) && isset($_POST['hidden'] )  ){ 

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


if(isset($_POST['PendingAgain']) && isset($_POST['hidden'])) { 

    $UpdateQuery = "UPDATE finaltable SET  status='PENDING' WHERE id= '$_POST[hidden]' "; //the problem was solved by dragging the $_POST[hidden] meaning using the line <input type='hidden' name='hidden' value='".$_POST['hidden']."'> BEFORE using the <input type=submit name=yes value='YES...SOLVED'>  *********OR**********   <input type=submit name=no value='NOT SOLVED'> wala line

    
    mysqli_query( $con,$UpdateQuery);

};


/*


//echo "<form action=mydata5.php method=post>";
echo "<tr>";
echo "<td><input type=text name=uid></td>";
echo "<td><input type=text name=utask></td>";
echo "<td><input type=text name=ustatus></td>";     
//echo "<td><input type=text name=uhandler></td>";
echo "<td>" . "<input type=submit name=add value=add" . " </td>";
echo "</tr>";
echo "</form>";
echo "</table>";


*/


?>



<?php

$con = mysqli_connect("localhost","root","","final");
                        if (!$con)  {
                                die("Can not connect: " . mysqli_error());
                            }

                    mysqli_select_db($con,"finaltable");
















////////////

// Creating a object of reciveMail Class 
//$obj= new ReceiveMail('imap.gmail.com','testppottest@gmail.com','kamehameha13','imap','993',true,true); 

$obj= new ReceiveMail('imap.gmail.com','rtdahalliburton@gmail.com','Rtda@2018','imap','993',true,true); 


//Connect to the Mail Box 
$obj->connect(); //If connection fails give error message and exit 

if($obj->is_connected())
{
	// Get Total Number of Unread Email in mail box 
	$tot = $obj->get_total_emails(); //Total Mails in Inbox Return integer value 

	//echo "Total Mails:: ".$tot."<br>"; 
	
	//This function will only work with IMAP.. If it is POP3 then you have to use "get_total_emails()".
/*	$unread = $obj->get_unread_emails();
	
	if(!$unread)
	{
		echo "No Unread email found.<br>"; 
	}
	else
	{
		echo "Total Unread E-Mails:: ".count($unread)."<br>"; 
		
		//Displaying all unread emails.
		for($i=0; $i<count($unread); $i++) 
		{ 
			$eml_num = $unread[$i]; 
			//Return all email header information such as Subject, Date, To, CC, From, ReplyTo. It also return Serialise object from the IMAP for detail use.
			$head = $obj->get_email_header($eml_num);
			echo "<br>"; 
				echo "<pre>";
					print_r($head);
				echo "</pre>";
			echo "<br>*******************************************************************************************<BR>"; 
			//The below function return email body.. If you want Text body from HTML formated email then pass second parameter i.e. $obj->get_email_body($eml_num,'text');
			echo $obj->get_email_body($eml_num); 
			
			//The below function will store attachment at the path passed in second argument and return Array of file names received.	
			$arrFiles=$obj->get_attachments($eml_num,"./"); 
			if($arrFiles)
			{
				foreach($arrFiles as $key=>$value) 
				{
					echo ($value=="")?"":"Attached File :: ".$value."<br>"; 
				}
				echo "<br>------------------------------------------------------------------------------------------<BR>"; 
			}
			// The below function will mark the email as Read in the mail box but commented in example site...
			//$obj->markas_read_email($eml_num);
			
			// The below function will delete the email from mail box but commented in example for accidental deletion...
			//$obj->delete_email($eml_num); 
		} 
	}

*/


	$fullread = $obj->get_YEST3_email();
	//$fullread = $obj->get_every_email();


	if(!$fullread)
	{
		echo "No  email found.<br>"; 
	}
	else
	{
		//echo "Total Unread E-Mails:: ".count($fullread)."<br>"; 
		
		//Displaying all unread emails.
		for($i=0; $i<count($fullread); $i++) 
		{ 
			$eml_num = $fullread[$i]; 
			//Return all email header information such as Subject, Date, To, CC, From, ReplyTo. It also return Serialise object from the IMAP for detail use.



			//echo "<div class="container">"

			echo "<a name = '$eml_num'></a> ";

			echo "TICKET NUMBER: ";
			echo $eml_num;
			echo "<br>";

			$head = $obj->get_email_header($eml_num);

			echo "SENDER NAME/EMAIL: ";
			$maildata1 = $head['from'];
			echo "<a href=mailto:$maildata1>".$head['from']."</a>";	//<a href="mailto:' + a.from.address + '?subject=Re:' + a.subject + '">' + a.from.address + '</a><
			echo "<br>";
			echo "SENDER NAME/EMAIL: ";
			$maildata2 = $head['fromName'];
			echo "<a href=$maildata1>".$head['fromName']."</a>";
			echo "<br>";
			echo "DATE EMAIL RECEIVED: ";
			echo $head['datetime'];
			echo "<br>";
			echo "TICKET EMAILED TO (RECEIVER'S EMAIL ADDRESS): ";
			echo $head['to'];
			echo "<br>";
			echo "SUBJECT: ";
			echo $head['subject'];
			echo "<br>";

			echo "TICKET CONTENTS: ";



		/*	echo "<br>"; 
				echo "<pre>";
					print_r($head);
				echo "</pre>";

				echo "<br>";
		*/

/*
			$head = $obj->get_email_header($eml_num);
			echo "<br>"; 
				echo "<pre>";
					print_r($head);
				echo "</pre>";*/
			//echo "<HR>"; 
			//The below function return email body.. If you want Text body from HTML formated email then pass second parameter i.e. $obj->get_email_body($eml_num,'text');
			echo "<br>";
			echo $obj->get_email_body($eml_num,'html'); 
			
			//The below function will store attachment at the path passed in second argument and return Array of file names received.

			$arrFiles=$obj->get_attachments($eml_num,"./"); 
			if($arrFiles)
			{

				echo "<br>";
				echo "ATTACHMENTS RECEIVED:";
				echo "<br>";

				foreach($arrFiles as $key=>$value) 
				{
					echo ($value=="")?"":"Attached File :: ".$value."<br>"; 
					echo "<a href='$value'>$value</a>";
				}
				echo "<br>------------------------------------------------------------------------------------------<BR>"; 
			}
			// The below function will mark the email as Read in the mail box but commented in example site...
			//$obj->markas_read_email($eml_num);
			
			// The below function will delete the email from mail box but commented in example for accidental deletion...
			//$obj->delete_email($eml_num); 


















			//ECHO "<HR>";




			$con = mysqli_connect("localhost","root","","final");
                        if (!$con)  {
                                die("Can not connect: " . mysqli_error());
                            }

                    mysqli_select_db($con,"finaltable");

            $id_check = mysqli_query($con, "SELECT * FROM finaltable WHERE id='$eml_num' ");

                                $num_rows = mysqli_num_rows($id_check);

                                if($num_rows > 0){

                                }

                                else

                                    {
                                        mysqli_query($con, "INSERT INTO finaltable (id, subject, my_date) VALUES ('$eml_num','$head[subject]','$head[datetime]')");
                                    }




//$fullread = $email->get_every_email();


$sql = "SELECT * FROM finaltable WHERE id='$eml_num'";

$myData = mysqli_query($con,$sql);

/*

echo "<table border=1>
<tr>
<th>id</th>
<th>subject</th>
<th>message</th>
<th>received from</th>
<th>date and time task was received</th>
<th>issues faced</th>
<th>steps taken to resolve the issue</th>
<th>status</th>


</tr>";
while($record = mysqli_fetch_array($myData)){
echo "<form action=testing.php method=post>";
echo "<tr>";
echo "<td>" . $record['id'] . " </td>";
echo "<td>" . $record['subject'] . " </td>";

echo "<td>" . $email->loadMessageSpecial($record['id']) . "</td>";

echo "<td>" . $email->loadEmailSpecial($record['id']) . "</td>";
echo "<td>" . $record['my_date'] . " </td>";
echo "<td><textarea name=issues_faced>" . $record['issues_faced'] . " </textarea></td>";
echo "<td><textarea name=steps_taken>" . $record['steps_taken'] . " </textarea>";
echo "<input type=submit name=submit_steps_issues value='submit both issues and steps'> ";
echo "<td>" . $record['status'] . " </td>";
//echo "<td>" . $record['handler'] . " </td>";


echo "<td>" . "<input type='hidden' name='hidden' value='".$record['id']."' </td>";


$myid = $record['id'];



$_POST['kewl'] = $record['id'];

if($record['status']=="pending")
    echo "<td>" . "<input type='submit' name='issue_pending' value='ISSUE PENDING...RESOLVE!!!' " . " </td>";
else 
    echo "<td>" . "ISSUE IS RESOLVED " . " </td>";
 



//echo "</tr>";
echo "</form>";




}

//old format display

*/





while($record = mysqli_fetch_array($myData)){

/*
echo "</br>";

echo "</br>EMAIL/TICKET ID: " . $record['id'] . "</br> ";
echo "</br>EMAIL SUBJECT: " . $record['subject'] . "</br> EMAIL/TICKET MESSAGE BODY:";

echo "</br> " . $email->loadMessageSpecial($record['id']) . "</br> RECEIVED FROM:";

echo "</br>" . $email->loadEmailSpecial($record['id']) . "</br>";


//attachment stuff...

echo "hahaha";

$arrFiles=$email->getAttachmentSpecial($record['id'],"./"); 
            if($arrFiles)
            {
                foreach($arrFiles as $key=>$value) 
                {
                    echo ($value=="")?"":"Attached File :: ".$value."<br>"; 
                    echo "<a href='$value'>$value</a>";
                }
                echo "<br>------------------------------------------------------------------------------------------<BR>"; 
            }
            else{
                echo "f off";
            }


//


echo "</br>DATE RECEIVED:" . $record['my_date'] . " </br>";


*/

//i changed the contents of the form....took out the ones that were not a part of the input type and put them above this line/comment

///////////








///////////
echo "<form id='myForm' method='post'>";//removed action='ticketInfo.php'
echo "<tr>";


echo "</br>ISSUES FACED:</br><textarea name='issues_faced'>" . $record['issues_faced'] . " </textarea></br>";
echo "</br>STEPS TAKEN TO RESOLVE THE ISSUE:</br><textarea name='steps_taken'>" . $record['steps_taken'] . " </textarea></br>";

echo "</br><input type=submit name=submit_steps_issues value='Submit Both Issues and Steps'></br> ";

//echo "</br><button name='submit_steps_issues' id='sub'>Submit Both Issues and Steps</button>";

echo "</br>STATUS: " . $record['status'] . " </br>";
//echo "<td>" . $record['handler'] . " </td>";


echo "" . "<input type='hidden' name='hidden' value='".$record['id']."' ";

echo "<span id='result'></span>";



$myid = $record['id'];



$_POST['kewl'] = $record['id'];

//echo "</form>";

if($record['status']=="PENDING")
    echo "</br>" . "<input type='submit' name='issue_pending' value='*** YES...ISSUE RESOLVED ***' " . " </br>";
else 
    echo "</br>" . "ISSUE IS RESOLVED " . " </br>";
 

echo "</br><input type=submit name=PendingAgain value='CHANGE STATUS TO PENDING'></br> ";


echo "</form>";


echo "</tr>";


echo "<hr>";

}



		} 


		    mysqli_close($con);



	}






}
$obj->close_mailbox(); //Close Mail Box 





?> 






<?php
/*
$imap = imap_open("{imap.gmail.com:993/imap/ssl/novalidate-cert}", "testppottest@gmail.com", "kamehameha13");


$numMessages = imap_num_msg($imap);
for ($i = $numMessages; $i > ($numMessages - 20); $i--) {
    $header = imap_header($imap, $i);

   

    $uid = imap_uid($imap, $i);
    $class = ($header->Unseen == "U") ? "unreadMsg" : "readMsg";

    //echo "<ul class="' . $class . '">";
    echo "<li><strong>From:</strong>" . $details["fromName"];
    echo " " . $details["fromAddr"] . "</li>";
    echo "<li><strong>Subject:</strong> " . $details["subject"] . "</li>";
    echo '<li><a href="mail.php?folder=' . $folder . '&uid=' . $uid . '&func=read">Read</a>';
    echo " | ";
    echo '<a href="mail.php?folder=' . $folder . '&uid=' . $uid . '&func=delete">Delete</a></li>';
    echo "</ul>";
}


$mailStruct = imap_fetchstructure($imap, $i);
$attachments = getAttachments($imap, $i, $mailStruct, "");




function getAttachments($imap, $mailNum, $part, $partNum) {
    $attachments = array();

    if (isset($part->parts)) {
        foreach ($part->parts as $key => $subpart) {
            if($partNum != "") {
                $newPartNum = $partNum . "." . ($key + 1);
            }
            else {
                $newPartNum = ($key+1);
            }
            $result = getAttachments($imap, $mailNum, $subpart,
                $newPartNum);
            if (count($result) != 0) {
                 array_push($attachments, $result);
             }
        }
    }
    else if (isset($part->disposition)) {
        if ($part->disposition == "ATTACHMENT") {
            $partStruct = imap_bodystruct($imap, $mailNum,
                $partNum);
            $attachmentDetails = array(
                "name"    => $part->dparameters[0]->value,
                "partNum" => $partNum,
                "enc"     => $partStruct->encoding
            );
            return $attachmentDetails;
        }
    }

    return $attachments;
}


echo "Attachments: ";
foreach ($attachments as $attachment) {

echo '<a href="mail.php?func=' . $func . '&folder=' . $folder . '&uid=' . $uid .
    '&part=' . $attachment["partNum"] . '&enc=' . $attachment["enc"] . '">' .
    $attachment["name"] . "</a>";
}


function downloadAttachment($imap, $uid, $partNum, $encoding, $path) {
    $partStruct = imap_bodystruct($imap, imap_msgno($imap, $uid), $partNum);

    $filename = $partStruct->dparameters[0]->value;
    $message = imap_fetchbody($imap, $uid, $partNum, FT_UID);

    switch ($encoding) {
        case 0:
        case 1:
            $message = imap_8bit($message);
            break;
        case 2:
            $message = imap_binary($message);
            break;
        case 3:
            $message = imap_base64($message);
            break;
        case 4:
            $message = quoted_printable_decode($message);
            break;
    }

    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . $filename);
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    echo $message;
}

*/

?>



<!--</div>-->


 <!--<script src="my_script.js" type="text/javascript"></script>-->
 <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
 



<script src="<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js" type="text/javascript"></script>




</body>
</div>
</html>


