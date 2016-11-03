<?php
	$con=mysql_connect("localhost","root","");
	mysql_query("SET NAMES UTF8");
	if(!$con){
		 die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("tlod", $con);
	?>