
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




<a href="example_today.php">Read Today's Tickets</a></br></br>
<a href="example_yest.php">Read Yesterday's Tickets</a></br></br>
<a href="example_yest2.php">Tickets 2 days ago</a></br></br>
<a href="example_yest3.php">Ticekts 3 days ago</a></br></br>
<a href="example_yest4.php">Tickets 4 days ago</a></br></br>

<a href="example_getAllFromDB.php">ALL TICKETS SUMMARY IN TABULAR LIST FORM</a></br></br>

 



<script src="<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js" type="text/javascript"></script>




</body>
</div>
</html>


