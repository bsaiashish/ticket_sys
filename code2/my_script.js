/*$ ("#sub").click(function() {
	
		$.post($("#myForm").attr("action"), $("#myForm :input").serializeArray(), function(info) { $("#result").html(info); } );


		$.ajax({

			url:'ticketInfo.php',
			type: 'POST',
			

		});


	});

$('#myForm').submit(function() {

		return false; 

});*/

$(document).ready(function(){

	$('#sub').click(function(){


		$.ajax({

			url:"ticketInfo.php",
			type:"post",
			data:$("#myForm").serialize(),
			success:function(d){
				alert(d);
			}


		});


	});



});


return false;